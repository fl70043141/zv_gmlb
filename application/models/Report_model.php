<?php 

class Report_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
         public function search_result($data=''){ 
//             echo '<pre>';print_r($data); echo'<pre>';die;
             $part_query = '';
             if(isset($data['sync_pending']) && $data['sync_pending']==0){
                 $part_query .= ' remote_sync_status='.$data['sync_pending'].' AND';
            } 
            $this->db->select('*,
                               (select agent_name  from '.AGENTS.' where id=lab_report.customer_id) as customer_name, 
                               (select dropdown_value from dropdown_list where id=lab_report.object) as object_val, 
                               (select dropdown_value from dropdown_list where id=lab_report.identification) as identification_val, 
                               (select dropdown_value from dropdown_list where id=lab_report.variety) as variety_val, 
                               (select dropdown_value from dropdown_list where id=lab_report.cut) as cut_val, 
                               (select dropdown_value from dropdown_list where id=lab_report.shape) as shape_val, 
                               (select dropdown_value from dropdown_list where id=lab_report.color_distribution) as color_distribution_val, 
                               (select dropdown_value from dropdown_list where id=lab_report.refractive_index) as refractive_index_val, 
                               (select dropdown_value from dropdown_list where id=lab_report.specific_gravity) as specific_gravity_val,
                               (select remote_sync_status from '.LAB_REPORT_SYNC.' where '.$part_query.' report_id=lab_report.id order by id desc limit 1) as remote_sync_status,
                            '); 
            
            if(isset($data['report_no'])){ 
                $this->db->like('report_no', $data['report_no']); 
            }
              
            if(isset($data['status'])){
                $this->db->where('status', $data['status']); 
            } 
            
            $this->db->from(LAB_REPORT);  

            $this->db->where('deleted', '0'); 
            $this->db->order_by('report_no', 'desc');  
//            $this->db->limit('50'); 
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;
//            echo '<pre>'; print_r($result); echo '<pre>'; die;
            return $result;
	}
	
         public function get_single_row($id, $col_name='id'){ 
            $this->db->select('lr.*,cl.country_name,
                               (select dropdown_value from dropdown_list where id=lr.object) as object_val, 
                               (select dropdown_value from dropdown_list where id=lr.identification) as identification_val, 
                               (select dropdown_value from dropdown_list where id=lr.variety) as variety_val, 
                               (select dropdown_value from dropdown_list where id=lr.cut) as cut_val, 
                               (select dropdown_value from dropdown_list where id=lr.shape) as shape_val, 
                               (select dropdown_value from dropdown_list where id=lr.color_distribution) as color_distribution_val, 
                               (select dropdown_value from dropdown_list where id=lr.refractive_index) as refractive_index_val, 
                               (select dropdown_value from dropdown_list where id=lr.specific_gravity) as specific_gravity_val
                               ');
            $this->db->join(COUNTRY_LIST.' cl','cl.country_code = lr.origin','left');
            $this->db->from(LAB_REPORT.' lr'); 
            $this->db->where('lr.'.$col_name,$id);
            $this->db->where('lr.deleted',0);
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query();
            return $result;
	}
                        
        public function add_report($data){    
//                echo '<pre>';            print_r($data); die;

                $this->db->trans_start();
		$this->db->insert(LAB_REPORT, $data); 
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function edit_report($id,$data){
//            echo '<pre>'; print_r($data); die;
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(LAB_REPORT, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_report($id,$data){ 
		$this->db->trans_start();
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(LAB_REPORT, $data);
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_hotel2($id){
                $this->db->trans_start();
                $this->db->delete(LAB_REPORT, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
 
}
?>