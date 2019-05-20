<?php 

class Property_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
         public function search_result($data=''){ 
            $this->db->select('p.*, pt.prop_type_name, trf.tarrif_type_name, tmb.time_base_name, htl.hotel_name, flr.floor_name');
            $this->db->from(PROPERTY.' p');  
            $this->db->join(PROPERTY_TYPE.' pt','pt.id = p.property_type_id');  
            $this->db->join(TARRIF_TYPE.' trf','trf.id = p.tarrif_type_id');  
            $this->db->join(TIME_BASE.' tmb','tmb.id = p.time_base_id');  
            $this->db->join(HOTELS.' htl','htl.id = p.hotel_id');  
            $this->db->join(FLOORS.' flr','flr.id = p.floor_id');  
            $this->db->where('p.deleted',0);
            if(isset($data['property_name'])){
                $this->db->like('p.property_name', $data['property_name']); 
            } 
            if(isset($data['property_type_id'])){
                $this->db->like('p.property_type_id', $data['property_type_id']); 
            } 
            if(isset($data['hotel_id'])){
                $this->db->like('p.hotel_id', $data['hotel_id']); 
            } 
            if(isset($data['floor_id'])){
                $this->db->like('p.floor_id', $data['floor_id']); 
            } 
            if($data != ''){
                if(isset($data['status'])){
                    $this->db->where('p.status', $data['status']); 
                }else{
                     $this->db->where('p.status', '0'); 
                }  
            }
            $result = $this->db->get()->result_array();   
//            echo $this->db->last_query(); die;
            return $result;
	}
	
         public function get_single_row($id){ 
            $this->db->select('*');
            $this->db->from(PROPERTY); 
            $this->db->where('id',$id);
            $this->db->where('deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                        
        public function add_property($data){    
            
//            echo '<pre>'; print_r($data); echo '<pre>'; die;
                $this->db->trans_start();
		$this->db->insert(PROPERTY, $data); 
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function edit_property($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(PROPERTY, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_property($id,$data){ 
		$this->db->trans_start();
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(PROPERTY, $data);
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_hotel2($id){
                $this->db->trans_start();
                $this->db->delete(HOTELS, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
 
}
?>