<?php 

class Agent_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
         public function search_result($data=''){ 
//             echo '<pre>';print_r($this->db); echo'<pre>';die;
            $this->db->select('ag.*, at.agent_type_name');
            $this->db->join(AGENT_TYPE.' at','at.id = ag.agent_type_id');
            
            if(isset($data['agent_name'])){ 
                $this->db->like('ag.agent_name', $data['agent_name']); 
            }
            if(isset($data['agent_type_id']) && $data['agent_type_id']!=''){ 
                $this->db->where('ag.agent_type_id', $data['agent_type_id']); 
            } 
            if(isset($data['status'])){
                $this->db->where('ag.status', $data['status']); 
            }else{
//                 $this->db->where('ag.status', '0'); 
            }   
            $this->db->from(AGENTS." ag");  

            $this->db->where('ag.deleted', '0'); 
            $result = $this->db->get()->result_array();   
//            echo $this->db->last_query(); die;
//            echo '<pre>'; print_r($result); echo '<pre>'; die;
            return $result;
	}
	
         public function get_single_row($id){ 
            $this->db->select('*');
            $this->db->from(AGENTS); 
            $this->db->where('id',$id);
            $this->db->where('deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                        
        public function add_agent($data){     
                $this->db->trans_start();
		$this->db->insert(AGENTS, $data); 
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function edit_agent($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(AGENTS, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_agent($id,$data){ 
		$this->db->trans_start();
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(AGENTS, $data);
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