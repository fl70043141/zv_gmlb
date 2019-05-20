<?php 

class Hotel_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
         public function search_result($data=''){ 
            $this->db->select('*');
            $this->db->from(HOTELS);  
            $this->db->where('deleted',0);
            if($data !=''){
                $this->db->like('hotel_name', $data['hotel_name']); 
               } 
            $result = $this->db->get()->result_array();  
            return $result;
	}
	
         public function get_single_row($id){ 
            $this->db->select('*');
            $this->db->from(HOTELS); 
            $this->db->where('id',$id);
            $this->db->where('deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                        
        public function add_hotel($data){       
                $this->db->trans_start();
		$this->db->insert(HOTELS, $data); 
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function edit_hotel($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(HOTELS, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_hotel($id,$data){ 
		$this->db->trans_start();
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(HOTELS, $data);
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