<?php 

class SummaryReports_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
         public function search_result($data=''){ 
//             echo '<pre>';print_r($data); echo'<pre>';die;
            $this->db->select('lr.*, cnry.country_name as country_name,  ag.agent_name as customer_name, gc.name as gem_type_name, sc.name as spec_cost_name,
                                (select dropdown_value from dropdown_list where id=lr.object) as object_val, 
                               (select dropdown_value from dropdown_list where id=lr.identification) as identification_val, 
                               (select dropdown_value from dropdown_list where id=lr.variety) as variety_val, 
                               (select dropdown_value from dropdown_list where id=lr.cut) as cut_val, 
                               (select dropdown_value from dropdown_list where id=lr.shape) as shape_val, 
                               (select dropdown_value from dropdown_list where id=lr.color_distribution) as color_distribution_val, 
                               (select dropdown_value from dropdown_list where id=lr.refractive_index) as refractive_index_val, 
                               (select dropdown_value from dropdown_list where id=lr.specific_gravity) as specific_gravity_val'); 
            $this->db->join(AGENTS.' ag', 'ag.id = lr.customer_id', 'left'); 
            $this->db->join(GEM_CAT.' gc', 'gc.id = lr.gem_type', 'left'); 
            $this->db->join(SPEC_COST.' sc', 'sc.id = lr.spec_cost', 'left'); 
            $this->db->join(COUNTRY_LIST.' cnry', 'cnry.country_code = lr.origin', 'left'); 
            
            if(isset($data['report_no'])){ 
                $this->db->like('lr.report_no', $data['report_no']); 
            }
            if(isset($data['report_date'])){ 
                $this->db->like('lr.report_date', $data['report_date']); 
            }
            if(isset($data['customer'])){ 
                $this->db->like('lr.customer_id', $data['customer']); 
            }
              
            if(isset($data['date_monthly'])){ 
                if($data['date_monthly'] != ''){
                    $dt_arr = explode('-', $data['date_monthly']);
                    $this->db->where('MONTH(lr.report_date)', $dt_arr[0]); 
                    $this->db->where('YEAR(lr.report_date)', $dt_arr[1]); 
                }
            }
            if(isset($data['date_year'])){ 
                if($data['date_year'] != ''){  
                    $this->db->where('YEAR(lr.report_date)',$data['date_year']); 
                }
            }
            if(isset($data['status'])){
                $this->db->where('lr.status', $data['status']); 
            }else{
//                 $this->db->where('status', '0'); 
            }   
            $this->db->from(LAB_REPORT.' lr');  

            $this->db->where('lr.deleted', '0'); 
            $result = $this->db->get()->result_array();   
//            echo $this->db->last_query(); die;
//            echo '<pre>'; print_r($result); echo '<pre>'; die;
            return $result;
	}
	
         public function get_single_row($id, $col_name='id'){ 
            $this->db->select('lr.*,cl.country_name');
            $this->db->join(COUNTRY_LIST.' cl','cl.country_code = lr.origin');
            $this->db->from(LAB_REPORT.' lr'); 
            $this->db->where('lr.'.$col_name,$id);
            $this->db->where('lr.deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                         
        public function get_column_list($table_name){
            $fields = $this->db->list_fields($table_name);
            return $fields;
        }
 
}
?>