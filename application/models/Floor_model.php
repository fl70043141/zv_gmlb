<?php 

class Floor_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
         public function search_result($data=''){ 
//             var_dump($data); die;
            $this->db->select('f.*,h.hotel_name');
            $this->db->from(FLOORS.' f');  
            $this->db->join(HOTELS.' h','h.id = f.hotel_id');  
            $this->db->where('f.deleted',0);
            if($data !=''){
                $this->db->like('f.floor_name', $data['floor_name']); 
            } 
            if(isset($data['hotel'])){
               $this->db->like('h.id', $data['hotel']);  
            }
            $result = $this->db->get()->result_array();  
            return $result;
	}
	
         public function get_single_row($id){ 
            $this->db->select('f.*,h.hotel_name');
            $this->db->from(FLOORS.' f');  
            $this->db->join(HOTELS.' h','h.id = f.hotel_id');  
            $this->db->where('f.id',$id);
            $this->db->where('f.deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                        
        public function add_floor($data){       
                $this->db->trans_start();
		$this->db->insert(FLOORS, $data); 
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function edit_floor($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(FLOORS, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_floor($id,$data){ 
		$this->db->trans_start();
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(FLOORS, $data);
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