<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
class Stripe
{
    private $secret_key;
    private $publishable_key;
    public function __construct(){
        $this->ci =& get_instance();
        require FCPATH . 'vendor/autoload.php';
        $this->secret_key      = "sk_test_VuG3HpNP0ZvHtU6thYakWLZu00MxWAkokm";
        $this->publishable_key = "pk_test_UL7lS6JkLserk4DNSiQiq9Le00QgTHbp1a";
    }

    function checkFun(){
        echo "Mindiii";die();
    }
    
    function addCardAccount($number, $exp_month, $exp_year, $cvv){
        $secret_key = $this->secret_key;
        Stripe\Stripe::setApiKey($secret_key);
        try {
            $result  = Stripe\Token::create(array(
                "card" => array(
                    "number" => $number,
                    "exp_month" => $exp_month,
                    "exp_year" => $exp_year,
                    "cvc" => $cvv
                )
            ));
            $success = 1;
        }
        catch (Stripe_CardError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_InvalidRequestError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_AuthenticationError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_ApiConnectionError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_Error $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Exception $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        if ($success != 1) {
            return $error[0];
        } 
        else {
            if (isset($result['id']) && !empty($result['id'])) {
                //return $result['id'];
                return array('token'=>$result['id'],'cardType'=>$result['card']['brand']);
            } //isset($result['id']) && !empty($result['id'])
            else {
                return false;
            }
        }
    }

    function save_card_id($email = '', $token = ''){
        $secret_key = $this->secret_key;
        Stripe\Stripe::setApiKey($secret_key);
        try {
            $customer = Stripe\Customer::create(array(
                "email" => $email,
                "source" => $token
            ));
            $success  = 1;
        }
        catch (Stripe_CardError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_InvalidRequestError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_AuthenticationError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_ApiConnectionError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_Error $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Exception $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        if ($success != 1) {
            return $error[0];
        } 
        else {
            if (isset($customer->id) && !empty($customer->id)) {
                return $customer;
            } //isset($customer->id) && !empty($customer->id)
            else {
                return false;
            }
        }
    }

    function pay_by_customer_id($payment, $custId){
        $secret_key = $this->secret_key;
        Stripe\Stripe::setApiKey($secret_key);
        try {
            $charge  = Stripe\Charge::create(array(
                "amount" => $payment,
                "currency" => "usd",
                "customer" => $custId
            ));
            $success = 1;
        }
        catch (Stripe_CardError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_InvalidRequestError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_AuthenticationError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_ApiConnectionError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_Error $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Exception $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        if ($success != 1) {
            return $error[0];
        }
        else {
            return $charge;
        }
    }

    function get_customer_by_id($custId){
        $secret_key = $this->secret_key;
        Stripe\Stripe::setApiKey($secret_key);

        try {

            $customer = \Stripe\Customer::retrieve($custId);

            $card = $customer->sources->retrieve($customer['default_source']);
            
            $success = 1;
        }
        catch (Stripe_CardError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_InvalidRequestError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_AuthenticationError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_ApiConnectionError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_Error $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Exception $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        if ($success != 1) {
            return $error[0];
        }
        else {
            return $card;
        }
    }

    function payment_stripe_to_customer($price,$custId){
        $secret_key = $this->secret_key;
        Stripe\Stripe::setApiKey($secret_key);

        try {
            $charge = \Stripe\Transfer::create([
                "amount" => $price,
                "currency" => "usd",
                "destination" => $custId,
                "source_type" => "bank_account"
            ]);
            $success = 1;
        }
        catch (Stripe_CardError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_InvalidRequestError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_AuthenticationError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_ApiConnectionError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_Error $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Exception $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        if ($success != 1) {
            return $error[0];
        }
        else {
            return $charge;
        }
    }

    function create_custom_bank_account($holderName,$dob,$country,$currency,$routingNumber,$accountNumber,$ssnLast,$postalCode){

        $secret_key = $this->secret_key;
        Stripe\Stripe::setApiKey($secret_key);

        if(!empty($holderName)){
            $names = explode(" ", $holderName);
        }
        $dob = explode("-", $dob);

        try{
            
            $acct = \Stripe\Account::create(array(

                "country" => $country,
                "type"    => "custom",

                "external_account"   => array(
                    "object"         => "bank_account",
                    "country"        => $country,
                    "currency"       => $currency,
                    "routing_number" => $routingNumber,
                    "account_number" => $accountNumber
                ),

                "tos_acceptance" => array(
                    "date" => time(),
                    "ip"   => $_SERVER['SERVER_ADDR']
                ),

                "legal_entity" => array(

                    'dob' => array(
                        'year'  =>$dob[0],
                        'month' =>$dob[1],
                        'day'   =>$dob[2]
                    ),

                    'first_name' => $names[0],
                    'last_name'  => $names[1],
                    'type'       => "individual",

                    'address' => array(
                        'postal_code' => $postalCode
                    ),
                    'ssn_last_4' => $ssnLast
                )
            ));
            $success = 1;
        }
        catch (Stripe_CardError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_InvalidRequestError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_AuthenticationError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_ApiConnectionError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_Error $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Exception $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        if ($success != 1) {
            return $error[0];
        }
        else {
            return $acct;
        }
    }

    function get_back_detail($acctNumber){
        $secret_key = $this->secret_key;
        Stripe\Stripe::setApiKey($secret_key);

        try {
            $charge = \Stripe\Account::retrieve($acctNumber);
            $success = 1;
        }
        catch (Stripe_CardError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_InvalidRequestError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_AuthenticationError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_ApiConnectionError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_Error $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Exception $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        if ($success != 1) {
            return $error[0];
        }
        else {
            return $charge;
        }
    }


    function create_bank_token($country, $currency, $holderName, $accountHolderType, $routingNumber, $accountNumber){
        $secret_key = $this->secret_key;
        Stripe\Stripe::setApiKey($secret_key);
        
        try {
            $bankTok = \Stripe\Token::create(array(
                "bank_account" => array(
                    "country" => $country,
                    "currency" => $currency,
                    "account_holder_name" => $holderName,
                    "account_holder_type" => 'individual',
                    "routing_number" => $routingNumber,
                    "account_number" => $accountNumber
                )
            ));
            $success = 1;
        }
        catch (Stripe_CardError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_InvalidRequestError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_AuthenticationError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_ApiConnectionError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_Error $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Exception $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        
        if ($success != 1) {
            return $error[0];
        } else {
            return $bankTok;
        }
    }

    function verify_bank_account($bankToken){
        try {
            $customer = \Stripe\Customer::create(array(
                "description" => "for verification",
                "source" => $bankToken
            ));
            $success  = 1;
        }
        catch (Stripe_CardError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_InvalidRequestError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_AuthenticationError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_ApiConnectionError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_Error $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Exception $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }

        if ($success != 1) {
            return $error[0];
        } else {
            return $customer;
        }
    }

    function add_customer_in_stripe(){
        $secret_key = $this->secret_key;
        Stripe\Stripe::setApiKey($secret_key);
        try {
            $acct    = Stripe\Account::create(array(
                "country" => "US",
                "type" => 'custom',
                "external_account" => array(
                    "platform_payments" => "bank_account",
                    "object" => "bank_account",
                    "country" => $country,
                    "currency" => $currency,
                    "routing_number" => $routingNumber,
                    "account_number" => $accountNo
                ),
                "tos_acceptance" => array(
                    "date" => time(),
                    "ip" => $_SERVER['SERVER_ADDR']
                )
            ));
            $success = 1;
        }
        catch (Stripe_CardError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_InvalidRequestError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_AuthenticationError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_ApiConnectionError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_Error $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Exception $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        if ($success != 1) {
            $responseArray = array(
                'status' => 'fail',
                'message' => $error[0]
            );
            print_r(json_encode($responseArray));die();
        } //$success != 1
        else {
            $acct_id                                     = $acct->id;
            $account                                     = Stripe\Account::retrieve($acct_id);
            $account->legal_entity->dob->year            = $dob[0];
            $account->legal_entity->dob->month           = $dob[1];
            $account->legal_entity->dob->day             = $dob[2];
            $account->legal_entity->first_name           = $firstName;
            $account->legal_entity->last_name            = $lastName;
            $account->legal_entity->type                 = "individual";
            $account->legal_entity->address->line1       = $address;
            $account->legal_entity->address->postal_code = $postalCode;
            $account->legal_entity->address->city        = $city;
            $account->legal_entity->address->state       = $state;
            $account->legal_entity->ssn_last_4           = $ssnLast;
            $account->save();
            if (isset($acct->id) && !empty($acct->id)) {
                return $acct;
            } else {
                return false;
            }
        }
    }
    
    function save_bank_account_id($firstName, $lastName, $dob, $country, $currency, $routingNumber, $accountNo, $address, $postalCode, $city, $state, $ssnLast)
    {
        if (!empty($holderName)) {
            $names = explode(" ", $holderName);
        } //!empty($holderName)
        $dob = explode("-", $dob);
        
        $secret_key = $this->secret_key;
        Stripe\Stripe::setApiKey($secret_key);
        try {
            $acct    = Stripe\Account::create(array(
                "country" => "US",
                "type" => 'custom',
                "external_account" => array(
                    "object" => "bank_account",
                    "country" => $country,
                    "currency" => $currency,
                    "routing_number" => $routingNumber,
                    "account_number" => $accountNo
                ),
                "tos_acceptance" => array(
                    "date" => time(),
                    "ip" => $_SERVER['SERVER_ADDR']
                )
            ));
            $success = 1;
        }
        catch (Stripe_CardError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_InvalidRequestError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_AuthenticationError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_ApiConnectionError $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Stripe_Error $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        catch (Exception $e) {
            $error[] = $e->getMessage();
            $success = 0;
        }
        if ($success != 1) {
            $responseArray = array(
                'status' => 'fail',
                'message' => $error[0]
            );
            print_r(json_encode($responseArray));die();
        } //$success != 1
        else {
            $acct_id                                     = $acct->id;
            $account                                     = Stripe\Account::retrieve($acct_id);
            $account->legal_entity->dob->year            = $dob[0];
            $account->legal_entity->dob->month           = $dob[1];
            $account->legal_entity->dob->day             = $dob[2];
            $account->legal_entity->first_name           = $firstName;
            $account->legal_entity->last_name            = $lastName;
            $account->legal_entity->type                 = "individual";
            $account->legal_entity->address->line1       = $address;
            $account->legal_entity->address->postal_code = $postalCode;
            $account->legal_entity->address->city        = $city;
            $account->legal_entity->address->state       = $state;
            $account->legal_entity->ssn_last_4           = $ssnLast;
            $account->save();
            if (isset($acct->id) && !empty($acct->id)) {
                return $acct->id;
            } //isset($acct->id) && !empty($acct->id)
            else {
                return false;
            }
        }
    }

    
} 