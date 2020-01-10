<?php defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);

class Stripe_pay extends MY_Controller {

     public function __construct(){
        parent::__construct();
        $this->load->model('stripe_model');
        $this->load->library('stripe');
    }
    
    public function index(){
        $userEmail = md5(rand()).'@khidmat.com';
        $cardHolderName = trim($this->input->post('cardHolderName'));
        $cardNumber     = trim($this->input->post('cardNumber'));
        $cardExpMonth   = trim($this->input->post('cardExpMonth'));
        $cardExpYear    = trim($this->input->post('cardExpYear'));
        $cardCvv        = trim($this->input->post('cardCvv'));
        $requestId      = trim($this->input->post('requestId'));
        

        $amount = $this->db->get_where('order',array('order_no' => base64_decode($requestId)))->row_array();
        $price = $mainPrice = $amount['amount'] * 100;
        $discountPresent = 0;

        $promo = trim($this->input->post('promoCode'));
        $data = $this->db->get_where('order_detail',array('order_id' => base64_decode($requestId)))->row_array();
        if(!empty($data)){
            $userId = $data['vendor_id'];
            $checkData = $this->stripe_model->SelectSingleRecord('promocode','*',array("promoCode"=>strtoupper($promo),"userId"=>$userId),'promoId desc');
            if(!empty($checkData)){
            	$discountPresent = $checkData->discountPresent;
                $discount = ($amount['amount'] / 100) * $discountPresent;
                $price = ($amount['amount'] - $discount)*100;   
            }
        }

        $addCard = $this->stripe->addCardAccount($cardNumber,$cardExpMonth,$cardExpYear,$cardCvv);
        if(isset($addCard['token']) && !empty($addCard['token'])){
            $cardAccount['cardToken'] = $addCard['token'];
            $cardAccount['cardType'] = $addCard['cardType'];
            $cardToken = $addCard['token'];
            $userEmail = $userEmail;
            $addCardToUser = $this->stripe->save_card_id($userEmail,$cardToken);
            
            if(isset($addCard['token']) && !empty($addCard['token'])){            
                $cardAccount['custId'] = $addCardToUser['id'];
                $cardAccount['custEmail'] = $addCardToUser['email'];
                $custId = $addCardToUser['id'];
                $paymentStatus = $this->stripe->pay_by_customer_id($price, $custId);
                
                
                if(isset($paymentStatus['balance_transaction']) && !empty($paymentStatus['balance_transaction'])){    
                    $cardAccount['refundedId'] = $paymentStatus['id'];
                    $cardAccount['transactionId'] = $paymentStatus['balance_transaction'];
                    $success = array('status' => 1,'message' => $cardAccount);

                    $cardAccount['requestId'] = base64_decode($requestId);
                    $cardAccount['mainPrice'] = $mainPrice;
                    $cardAccount['discountPresent'] = $discountPresent;
                    $cardAccount['price'] = $price;
                    $cardAccount['userId'] = $data['vendor_id'];
                    
                    $this->db->insert('payment',$cardAccount);

                    $this->db->where(array('order_id' => base64_decode($requestId)));
                    $this->db->update('order_detail',array('payment_status' => 'paid'));

                    $data = new stdClass();
                    $data->error = 1;
                    $data->success = 1;
                    $data->message = 'Payment successfully done.';
                    $this->session->set_flashdata('item',$data);
                    redirect('user/orderDetail/'.$requestId);

                    print_r(json_encode($success));die();

                }else{
                    $error = array('status' => 0,'message' => $paymentStatus);

                    $data = new stdClass();
                    $data->error = 1;
                    $data->success = 0;
                    $data->message = $paymentStatus;
                    $this->session->set_flashdata('item',$data);
                    redirect('user/orderDetail/'.$requestId);

                    print_r(json_encode($error));die();
                }

            }else{
                $error = array('status' => 0,'message' => $addCardToUser);
                
                $data = new stdClass();
                $data->error = 1;
                $data->success = 0;
                $data->message = $addCardToUser;
                $this->session->set_flashdata('item',$data);
                redirect('user/orderDetail/'.$requestId);

                print_r(json_encode($error));die();
            }

        }else{
            $error = array('status' => 0,'message' => $addCard);
            
            $data = new stdClass();
            $data->error = 1;
            $data->success = 0;
            $data->message = $addCard;
            $this->session->set_flashdata('item',$data);
            redirect('user/orderDetail/'.$requestId);

            print_r(json_encode($error));die();
        }
    }


    function pay($id){
        $amount = $this->db->get_where('order',array('order_no' => base64_decode($id)))->row_array();
        $data['amount'] = $amount['amount'];
        $data['id'] = $id;
        $this->load->view('pay',$data);    
    }


    function checkPromo(){
        $postData = $this->input->post();
        $data = $this->db->get_where('order_detail',array('order_id' => base64_decode($postData['postId'])))->row_array();
        
        if(!empty($data)){
            $userId = $data['vendor_id'];
            $promo = $postData['promo'];

            $where1 = array(
                "promoCode" => strtoupper($promo),
                "userId" => $userId,
                "startDate <=" => date('Y-m-d'),
                "startDate >=" => date('Y-m-d'),
            );

            $where2 = array(
                "promoCode" => strtoupper($promo),
                "userId" => 0,
                "startDate <=" => date('Y-m-d'),
                "startDate >=" => date('Y-m-d'),
            );

            $checkData = $this->stripe_model->SelectSingleRecord('promocode','*',$where1,'promoId desc');
            if(empty($checkData)){
                $checkData = $this->stripe_model->SelectSingleRecord('promocode','*',$where2,'promoId desc');
            }


            if(!empty($checkData)){
                print_r(json_encode($checkData));
            }else{
                echo '0';
            }
            
           

        }
    }

    

    function addBankAccount(){
        $firstName     = trim($this->input->post('firstName'));
        $lastName      = trim($this->input->post('lastName'));
        $holderName    = $firstName.' '.$lastName;

        $dob           = trim($this->input->post('dob'));
        $dob           = date("Y-m-d", strtotime($dob));

        $country       = trim($this->input->post('country'));
        $currency      = trim($this->input->post('currency'));
        $accountNumber = trim($this->input->post('accountNumber'));
        $routingNumber = trim($this->input->post('routingNumber'));
        $ssnLast       = trim($this->input->post('ssnLast'));
        $postalCode    = trim($this->input->post('postalCode'));

        
        $bankToken = $this->stripe->create_bank_token($country, $currency, $holderName, 'individual', $routingNumber, $accountNumber);
       
        
        $addCardToUser = $this->stripe->save_card_id('serEmail@g.com',$bankToken['id']);

print_r($addCardToUser );die();
        if(isset($bankToken['id']) && !empty($bankToken['id'])){
            $bankData['bankToken'] = $bankToken['id'];
            $bankToken = $bankToken['id'];

            $customerToken = $this->stripe->verify_bank_account($bankToken);
            if(isset($customerToken['id']) && !empty($customerToken['id'])){
                $bankData['customerToken'] = $customerToken['id'];
                $customerToken = $customerToken['id'];

                 echo '<pre>';


                /*$pay123 = $this->stripe->save_bank_account_id($firstName, $lastName, $dob, $country, $currency, $routingNumber, $accountNumber, $country, $postalCode, $country, $country, $ssnLast);
                print_r($pay123);

                $pay = $this->stripe->payment_stripe_to_customer(1000,$customerToken);

               
                print_r($pay);*/
                print_r($bankData);
                die();
                /*(
    [bankToken] => btok_1EflniHyToIHR2zKrKhT6Tpw
    [customerToken] => cus_FA5zsxVs5qHUrV
)*/

            }
            

        }


           

        
    }

}

