<?php	
if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	
    function phpmailer($to,$sub,$msg){        
        require("./PHPMailer/class.phpmailer.php");

            $email = 'mss.parvezkhan@gmail.com';
            $password = 'mact@123';
            $to_id = $to;
            $message = $msg;
            $subject = $sub;
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->SMTPDebug = 1;
            $mail->Host = "mactosys.com";
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;
            $mail->From = "info@khidmat.com";
            $mail->FromName = "Khidmat";
            $mail->SMTPAuth = false;
            $mail->Username = 'dating@mactosys.com';
            $mail->Password = 'dating!@#';
            $mail->addAddress($to_id);
            $mail->Subject = $subject;
            $mail->msgHTML($message);
            $mail->send();
    }
    
	    
    
    function get_user($userid){       
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('id'=>$userid));
            $query = $CI->db->get('users');            
            $reslt = $query->row();
            //print_r($userid); die;			
            return $reslt;
    }
    
    
    function get_parent($catid,$html=''){        
            $CI =& get_instance();
            $CI->db->select('*');            
            $CI->db->where(array('id'=>$catid));
            $query = $CI->db->get('category');            
            $reslt = $query->row();
            
            //print_r($reslt->parent_id); die;
            $html .= ';<li class="breadcrumb-item"><a href="'.site_url('catalog/'.$reslt->parent_id.'/'.$reslt->id).'">'.$reslt->title.'</a></li>';
            
            if($reslt->parent_id != 0){                
                get_parent($reslt->parent_id,$html);
            }else{
               $html = implode(' ',array_reverse(explode(';',$html)));
                echo rtrim($html,' ');    
            }
            
    }
    
	function get_featured_products(){        
            $CI =& get_instance();
            $CI->db->select('*');
			$CI->db->limit('10');
			$CI->db->order_by('rand()');   
            $query = $CI->db->get('featured_products');            
            $reslt = $query->result();
            //print_r($reslt); die;
            return $reslt;
    }
	
    function get_product($pid){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('id'=>$pid));
            $query = $CI->db->get('products');            
            $reslt = $query->row();
            //print_r($userid); die;
            return $reslt;
    }
	
	function get_other_product($pid){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('id'=>$pid));
            $query = $CI->db->get('other_products');            
            $reslt = $query->row();
            //print_r($userid); die;
            return $reslt;
    }
	
	function get_album($pid){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('id'=>$pid));
            $query = $CI->db->get('album');            
            $reslt = $query->row();
            //print_r($userid); die;
            return $reslt;
    }
    
    function get_wallet($userid){        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('user_id'=>$userid));            
            $query = $CI->db->get('wallet');            
            $reslt = $query->row();
            //print_r($userid); die;
            return $reslt;
    }
	
	function get_all_jobs(){        
            $CI =& get_instance();
            $CI->db->select('*');                       
            $query = $CI->db->get('jobs');            
            $reslt = $query->result();            
            return $reslt;
    }
	
	function get_all_videos(){        
            $CI =& get_instance();
            $CI->db->select('*');                       
			$CI->db->where(array('file_type'=>1));            
            $query = $CI->db->get('products');            
            $reslt = $query->result();            
            return $reslt;
    }
	function get_all_audios(){        
            $CI =& get_instance();
            $CI->db->select('*');                       
			$CI->db->where(array('file_type'=>2));            
            $query = $CI->db->get('products');            
            $reslt = $query->result();            
            return $reslt;
    }
	function get_all_pictures(){        
            $CI =& get_instance();
            $CI->db->select('*');                       
			$CI->db->where(array('file_type'=>3));            
            $query = $CI->db->get('products');            
            $reslt = $query->result();            
            return $reslt;
    }
	function get_all_orders(){        
            $CI =& get_instance();
            $CI->db->select('*');                       			           
            $query = $CI->db->get('order');            
            $reslt = $query->result();            
            return $reslt;
    }
	function get_total_transactions(){        
            $CI =& get_instance();
            $CI->db->select_sum('payment_amt');                       			          
            $query = $CI->db->get('transactions');            
            $reslt = $query->row();            
            return $reslt;
    }
    
    function get_packages(){        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('id !='=>1));      
            $query = $CI->db->get('membership_plan');            
            $reslt = $query->result();
            //print_r($reslt); die;
            return $reslt;
    }
    
    function get_charge_amount($userid){        
            
            return 5;
    }
    
    function deduct_wallet($userid,$amount){                        
            $wallet = get_wallet($userid);
            //echo $userid; die;
            $data['amount'] = ($wallet->amount - $amount );
            $CI =& get_instance();            
            $CI->db->where(array('user_id'=>$userid));            
            $reslt = $CI->db->update('wallet',$data);                                    
            
            return $reslt;
    }
    
    function added_wallet($userid,$amount){
        
            $wallet = get_wallet($userid);
            //echo $userid; die;
            $data['amount'] = ($wallet->amount + $amount );
            $CI =& get_instance();            
            $CI->db->where(array('user_id'=>$userid));            
            $reslt = $CI->db->update('wallet',$data);                                    
            
            return $reslt;
    }
    
    function get_category($catid){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('id'=>$catid));
            $query = $CI->db->get('category');            
            $reslt = $query->row();
            //print_r($userid); die;
            return $reslt;
    }
    
    function get_service($serviceid){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('id'=>$serviceid));
            $query = $CI->db->get('services');            
            $reslt = $query->row();
            //print_r($userid); die;
            return $reslt;
    }
    
    function get_job_type($type){
        
            if($type == 1) return "Full Time";
            else if($type == 2) return "Part Time";
            else if($type == 3) return "Hourly Time";
            else if($type == 4) return "Freelancer";
            else return 'N/A';
    }
    
    function get_time_ago( $time )
    {
        $time_difference = time() - $time;
    
        if( $time_difference < 1 ) { return 'less than 1 second ago'; }
        $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                    30 * 24 * 60 * 60       =>  'month',
                    24 * 60 * 60            =>  'day',
                    60 * 60                 =>  'hour',
                    60                      =>  'minute',
                    1                       =>  'second'
        );
    
        foreach( $condition as $secs => $str )
        {
            $d = $time_difference / $secs;
    
            if( $d >= 1 )
            {
                $t = round( $d );
                return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
            }
        }
    }
    
    function get_genre($id){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('id'=>$id));
            $query = $CI->db->get('genre');            
            $reslt = $query->row();
            //print_r($userid); die;
            return $reslt;
    }
    
    function get_follow_list($artist_id){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('artist_id'=>$artist_id));
            $query = $CI->db->get('follow');            
            $reslt = $query->result();
            //print_r($userid); die;
            return $reslt;
    }
    
    function get_cool_list($artist_id){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('artist_id'=>$artist_id));
            $query = $CI->db->get('cool');            
            $reslt = $query->result();
            //print_r($userid); die;
            return $reslt;
    }
    
    function get_cool_product_list($product_id){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('product_id'=>$product_id));
            $query = $CI->db->get('cool_products');            
            $reslt = $query->result();
            //print_r($userid); die;
            return $reslt;
    }
	
	function get_cool_other_product_list($product_id){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('product_id'=>$product_id));
            $query = $CI->db->get('cool_other_products');            
            $reslt = $query->result();
            //print_r($userid); die;
            return $reslt;
    }
    
    function get_likes_list($product_id){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('product_id'=>$product_id));
            $query = $CI->db->get('likes');            
            $reslt = $query->result();
            //print_r($userid); die;
            return $reslt;
    }
	
	function get_likes_other_products_list($product_id){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('product_id'=>$product_id));
            $query = $CI->db->get('likes_other_products');            
            $reslt = $query->result();
            //print_r($userid); die;
            return $reslt;
    }
    
    function get_cool_album_list($product_id){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('product_id'=>$product_id));
            $query = $CI->db->get('cool_album');            
            $reslt = $query->result();
            //print_r($userid); die;
            return $reslt;
    }
    
    function get_likes_album_list($product_id){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('product_id'=>$product_id));
            $query = $CI->db->get('likes_album');            
            $reslt = $query->result();
            //print_r($userid); die;
            return $reslt;
    }
    
    function get_comments_list($product_id){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('product_id'=>$product_id));
            $query = $CI->db->get('product_comments');            
            $reslt = $query->result();
            //print_r($this->db->last_query()); die;
            return $reslt;
    }
    function get_other_products_comments_list($product_id){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('product_id'=>$product_id));
            $query = $CI->db->get('other_products_comments');            
            $reslt = $query->result();
            //print_r($this->db->last_query()); die;
            return $reslt;
    }
	
    function get_album_comments_list($product_id){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('product_id'=>$product_id));
            $query = $CI->db->get('album_comments');            
            $reslt = $query->result();
            //print_r($this->db->last_query()); die;
            return $reslt;
    }
    
    function get_product_rating($product_id){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('product_id'=>$product_id));
            $query = $CI->db->get('product_rating');            
            $reslt = $query->result();
            //print_r($reslt); die;
            $rating = 0;
            foreach($reslt as $row){
                $rating += $row->rating;
            }
            $final_rating = $rating/count($reslt);
            //print_r($final_rating); die;
            return round($final_rating);
    }
    
    function get_job_rating($job_id){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('job_id'=>$job_id));
            $query = $CI->db->get('job_rating');            
            $reslt = $query->result();
            //print_r($reslt); die;
            $rating = 0;
            foreach($reslt as $row){
                $rating += $row->rating;
            }
            $final_rating = $rating/count($reslt);
            //print_r($final_rating); die;
            return round($final_rating);
    }
    
    function get_cards($user_id){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('user_id'=>$user_id));
            $query = $CI->db->get('cards');            
            $reslt = $query->result();
            //print_r($reslt); die;
            $bronze = 0; $silver = 0; $gold = 0;
            foreach($reslt as $row){
                if($row->card_type == 1){
                    $bronze++;    
                }
                if($row->card_type == 2){
                    $silver++;    
                }
                if($row->card_type == 3){
                    $gold++;    
                }
            }
            $cards = array($bronze,$silver,$gold);
            //print_r($final_rating); die;
            return $cards;
    }
    
    function get_follower_list($user_id){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('artist_id'=>$user_id));
            $query = $CI->db->get('follow');            
            $reslt = $query->result();
            //print_r($this->db->last_query()); die;
            return $reslt;
    }
    
    function get_following_list($user_id){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('follower_id'=>$user_id));
            $query = $CI->db->get('follow');            
            $reslt = $query->result();
            //print_r($this->db->last_query()); die;
            return $reslt;
    }
    
    function get_favorite_products($user_id){
        
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('follower_id'=>$user_id));
            $query = $CI->db->get('likes');            
            $reslt = $query->result();
            //print_r($this->db->last_query()); die;
            $images = ''; $audio = ''; $video = ''; $album = '';
            foreach($reslt as $row){
                
                $CI->db->select('*');
                $CI->db->where(array('id'=>$row->product_id));
                $query = $CI->db->get('products');            
                $rslt = $query->row();
                
                if($rslt->file_type == 1){
                    $video[] = ["thumb"=>$rslt->thumb,"file"=>$rslt->file,"id"=>$rslt->id,"title"=>$rslt->title];    
                }
                if($rslt->file_type == 2){
                    $audio[] = ["thumb"=>$rslt->thumb,"file"=>$rslt->file,"id"=>$rslt->id,"title"=>$rslt->title];    
                }
                if($rslt->file_type == 3){
                    $images[] = ["thumb"=>$rslt->thumb,"file"=>$rslt->file,"id"=>$rslt->id,"title"=>$rslt->title];    
                }
            }
            return array($video,$audio,$images);
    }
    
    function get_favorite_album($user_id){        
            $CI =& get_instance();
            $CI->db->select('a.*');
            $CI->db->from('likes_album as la');
            $CI->db->join('album as a', 'la.product_id = a.id' ,'left');
            $CI->db->where(array('la.follower_id'=>$user_id));
            $query = $CI->db->get();            
            $reslt = $query->result();
            //print_r($reslt); die;            
            return $reslt;
    }
    
    function get_favorite_jobs($user_id){
        
            $CI =& get_instance();
            $CI->db->select('j.*');
            $CI->db->from('likes_job as lj');
            $CI->db->join('jobs as j', 'lj.job_id = j.id' ,'left');
            $CI->db->where(array('lj.follower_id'=>$user_id));
            $query = $CI->db->get();            
            $reslt = $query->result();
            
            return $reslt;
    }
    
    function get_membership($user_id){
        
            $CI =& get_instance();
            $CI->db->select('mp.*');
            $CI->db->from('membership as m');
            $CI->db->join('membership_plan as mp', 'm.plan_id = mp.id' ,'left');
            $CI->db->where(array('m.user_id'=>$user_id));
            $query = $CI->db->get();            
            $reslt = $query->row();
            
            return $reslt;
    }
    
    function get_order_detail($order_id){
        
            $CI =& get_instance();
			
			$CI->db->select('*');
			$CI->db->from('order_detail');
			$CI->db->where(array('order_id'=>$order_id));
			$query = $CI->db->get();            
            $rslt = $query->row();
			
			if($rslt->other_product_id){
				$CI->db->select('p.*');
				$CI->db->from('order_detail as od');
				$CI->db->join('other_products as p', 'od.other_product_id = p.id' ,'left');
				$CI->db->where(array('od.order_id'=>$order_id));
				$CI->db->where(array('od.other_product_id !='=>0));
				$query = $CI->db->get();            
				$reslt = $query->result();
				
				return $reslt;	
			}else if($rslt->album_id){
				$CI->db->select('p.*');
				$CI->db->from('order_detail as od');
				$CI->db->join('album as p', 'od.album_id = p.id' ,'left');
				$CI->db->where(array('od.order_id'=>$order_id));
				$CI->db->where(array('od.album_id !='=>0));
				$query = $CI->db->get();            
				$reslt = $query->result();
				
				return $reslt;	
			}else{
				$CI->db->select('p.*');
				$CI->db->from('order_detail as od');
				$CI->db->join('products as p', 'od.product_id = p.id' ,'left');
				$CI->db->where(array('od.order_id'=>$order_id));
				$CI->db->where(array('od.product_id !='=>0));
				$query = $CI->db->get();            
				$reslt = $query->result();
				
				return $reslt;	
			}
			
            
    }
		
    
    function get_offer_money($offer_id){
        
            $CI =& get_instance();
            $CI->db->select('od.amount');
            $CI->db->from('order_detail as od');
            $CI->db->join('order as o', 'od.order_id = o.order_no' ,'left');
            $CI->db->where(array('od.offer_id'=>$offer_id,'o.payment_status'=>2));
            $query = $CI->db->get();            
            $reslt = $query->result();
            $total = 0;
            foreach($reslt as $r){
                $total += $r->amount;
            }
            //print_r($reslt); die;
            return $total;
    }
	
	function get_unread_notifications($userid){        
            $CI =& get_instance();
            $CI->db->select('*');
			$CI->db->where('user_id',$userid);
			$CI->db->where('is_read',0);  
            $query = $CI->db->get('notifications');            
            $reslt = $query->result();            
            return $reslt;
    }
	
	function get_unread_messages($userid){        
            $CI =& get_instance();
            $CI->db->select('*');
			$CI->db->where('message_to',$userid);
			$CI->db->where('status','0');  
            $query = $CI->db->get('comments');            
            $reslt = $query->result();
			//print_r($reslt); die;
            return $reslt;
    }
	
	function get_unread_requests(){        
            $CI =& get_instance();
            $CI->db->select('*');			
			$CI->db->where('status','0');  
            $query = $CI->db->get('withdraw');            
            $reslt = $query->result();
			//print_r($reslt); die;
            return $reslt;
    }
	
	function get_counter_offer($offerid){        
            $CI =& get_instance();
            $CI->db->select('*');
			$CI->db->where('offer_id',$offerid);
			$CI->db->order_by('id','desc');	
            $query = $CI->db->get('counter_offer');            
            $reslt = $query->row();            
            return $reslt;
    }
	
	function getLatLong($address){
		if(!empty($address)){
		    //Formatted address
		    $formattedAddr = str_replace(' ','+',$address);
		    //Send request and receive json data by address
		    $geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false'); 
		    $output = json_decode($geocodeFromAddr);
		    //Get latitude and longitute from json data
		    $data['latitude']  = $output->results[0]->geometry->location->lat; 
		    $data['longitude'] = $output->results[0]->geometry->location->lng;
		    //Return latitude and longitude of the given address
		    if(!empty($data)){
			return $data;
		    }else{
			return false;
		    }
		}else{
		    return false;   
		}
	}
    
    if (!function_exists('truncate')) {
      function truncate($text, $length) {
         $length = abs((int)$length);
         if(strlen($text) > $length) {
            $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
         }
         return($text);
      }
    }
    
    function get_parent_id($catid){        
            $CI =& get_instance();
            $CI->db->select('*');            
            $CI->db->where(array('id'=>$catid));
            $query = $CI->db->get('category');            
            $reslt = $query->row();
            
            if($reslt->level == 1){
                $id = $reslt->id;
                return $id;
            }

            for ($i=0; $i < $reslt->level-1; $i++) { 
                $id = $reslt->parent_id;
                get_parent_id($reslt->parent_id);
            }
            return $id;
    }

    function get_request_count($userId){
        $CI =& get_instance();
        $count = $CI->db->select('COUNT(id) as count')->get_where('order_detail',array('vendor_id' => $userId,'order_status' => 1))->row_array();
        return $count['count'];    
    }

    function get_notifications($userId){
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->where('user_id',$userId);
        $query = $CI->db->get('notification');            
        $reslt = $query->result_array();
        return $reslt;
    }

    function get_footer_list(){
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->where('parent_id',0);
        $query = $CI->db->get('category');            
        $reslt = $query->result_array();
        return $reslt;
    }

    function get_review_count($userId){
        $CI =& get_instance();
        $count = $CI->db->select('COUNT(reviewId) as count')->get_where('review',array('receiverId' => $userId))->row_array();
        return $count['count']; 
    }

    if (!function_exists('baseE')) {
      function baseE($data){
        return base64_encode(md5(rand()).'_'.$data.'_'.md5(rand()));
      }
    }

    if (!function_exists('baseD')) {
      function baseD($data){
        return explode('_', base64_decode($data))[1] ;
      }
    }  

    function get_city($id){       
            $CI =& get_instance();
            $CI->db->select('*');
            $CI->db->where(array('id'=>$id));
            $query = $CI->db->get('cities');            
            $reslt = $query->row();
            //print_r($userid); die;			
            return $reslt;
    }
?>