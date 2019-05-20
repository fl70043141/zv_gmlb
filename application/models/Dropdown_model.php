<?php 

class Dropdown_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
         public function search_result($data=''){ 
//             var_dump($data); die;
            $this->db->select('dp.*,dpn.dropdown_list_name');
            $this->db->from(DROPDOWN_LIST.' dp');  
            $this->db->join(DROPDOWN_LIST_NAMES.' dpn','dpn.id = dp.dropdown_id');  
            $this->db->where('dp.deleted',0);
            if($data !=''){
                $this->db->like('dp.dropdown_value', $data['dropdown_val']); 
            } 
            if(isset($data['dropdown_type'])){
               $this->db->like('dpn.id', $data['dropdown_type']);  
            }
            if(isset($data['status'])){
                $this->db->where('dp.status', $data['status']); 
            }
            $result = $this->db->get()->result_array();  
            return $result;
	}
	
         public function get_single_row($id){ 
            $this->db->select('dp.*,dpn.dropdown_list_name');
            $this->db->from(DROPDOWN_LIST.' dp');  
            $this->db->join(DROPDOWN_LIST_NAMES.' dpn','dpn.id = dp.dropdown_id');  
            $this->db->where('dp.id',$id);
            $this->db->where('dp.deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                        
        public function add_dropdown($data){       
                $this->db->trans_start();
		$this->db->insert(DROPDOWN_LIST, $data); 
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function edit_dropdown($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(DROPDOWN_LIST, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_dropdown($id,$data){ 
		$this->db->trans_start();
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(DROPDOWN_LIST, $data);
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_dropdown2($id){
                $this->db->trans_start();
                $this->db->delete(DROPDOWN_LIST, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
 
}
?>