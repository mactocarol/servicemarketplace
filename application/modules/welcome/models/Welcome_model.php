<?php
class Welcome_model extends MY_Model 
{
	function __construct() {
		parent::__construct();		
	}
    
    function getVendor($serviceid){

		$data = $this->db->get_where('services',array('id' => $serviceid))->row_array();
	    if(empty($data)){
	        return false;
	    }
		$ser = get_parent_id($data['category_id']);
        if(empty($ser)){
	        return false;
	    }
		/*print_r($serviceid.' sdf ');
		
		die();*/
		$sql = "
			SELECT 	
				*
			FROM 
				vendor_services 
			INNER JOIN 
				users 
				ON 
					users.id=vendor_services.vendor_id 
			INNER JOIN 
				vendor_services_price 
				ON 
				vendor_services_price.userServicesId=$ser
				AND
				vendor_services_price.userId=users.id
			WHERE 
				CONCAT(',', services_search, ',') 
			LIKE '%,".$ser.",%'
		";
		//print_r($sql);die();
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}
    
    function searchVendor($serviceid){
        $data = $this->db->get_where('services',array('id' => $serviceid))->row_array();
	    if(empty($data)){
	        return false;
	    }
		$serviceid = get_parent_id($data['category_id']);
        if(empty($serviceid)){
	        return false;
	    }
        
        if(empty($serviceid)){
	        return false;
	    }
		
		$sql = "
			SELECT 	
				*
			FROM 
				vendor_services 
			INNER JOIN 
				users 
				ON 
					users.id=vendor_services.vendor_id 
			INNER JOIN 
				vendor_services_price 
				ON 
				vendor_services_price.userServicesId=$serviceid
				AND
				vendor_services_price.userId=users.id
			WHERE 
				CONCAT(',', services_search, ',') 
			LIKE '%,".$serviceid.",%' AND vendor_services_price.price != '' AND vendor_services_price.price != '0'
		";
		//print_r($sql);die();
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}
    
	function getPrice($serviceid,$userId){

		$data = $this->db->get_where('services',array('id' => $serviceid))->row_array();
		$ser = get_parent_id($data['category_id']);

		/*print_r($serviceid.' sdf ');
		print_r($ser);
		die();*/
		$sql = "
			SELECT 	
				*
			FROM 
				vendor_services 
			INNER JOIN 
				users 
				ON 
					users.id=vendor_services.vendor_id 
			INNER JOIN 
				vendor_services_price 
				ON 
				vendor_services_price.userServicesId=$ser
				AND
				vendor_services_price.userId=$userId
			WHERE 
				CONCAT(',', services_search, ',') 
			LIKE '%,".$ser.",%'
		";
		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result;
	}

	function mostPopularCategories(){
		$data = $this->db->order_by('rand()')->group_by('parent_id')->get_where('category',array('level' => 1))->result_array();
		$data = $this->db->order_by('rand()')->where_in('id',array(10,11,42,43,61,65,68,66,101,102,73,74,75,79,80,86,87))->limit(8)->get('category')->result_array();
		return $data;
	}
    
    function search_record($TableName,$keyword,$orderby)
	{
		// print_r($query);die();
        if($keyword){
            $result = $this->db->select('id,title')->from('services')
                            ->where("title LIKE '%$keyword%'")->get()->result_array();    
        }else{
            $result = [];
        }
		
       	return $result;
	}
        
}