<?php 

class User_default_model extends CI_Model
{
    function __construct(){
    parent::__construct();
    //	$remember_txt = $this->input->post('remember');
            if ( $this->input->post( 'remember' ) ){ // set sess_expire_on_close to 0 or FALSE when remember me is checked.
            $this->config->set_item('sess_expire_on_close', '0'); // do change session config
            $this->load->library('session');
            }
    }


    public function get_user_profile($id=''){
            $this->db->select('*');
            $this->db->from(USER_TBL);
            $this->db->where('u_sid',$id);
            $query = $this->db->get();

            return $query->result_array();
    }
	
    function get_all()
    {
        $sql = "SELECT ID,CONCAT(first_name,' ',last_name) as name FROM ".USER_TBL." ORDER BY first_name,last_name";
		return $this->db->query($sql)->result();
    }
    
	function login($data)
	{		
		$this->load->library('encrypt'); 
		/*$user_obj = $this->db->get_where(USER_TBL,array('user_name'=>$data['username']))->result();*/
//		var_dump($data); die;
		$this->db->select('usr.*,mst.first_name,mst.last_name,mst.pic');
		$this->db->from(USER_TBL.' usr');
                $this->db->join(USER.' mst','mst.auth_id = usr.id',"LEFT");
		$this->db->where('usr.user_name', $data['uname']);
		$this->db->where('usr.status', 1);
		$this->db->where('mst.deleted', 0);
		$user_obj = $this->db->get()->result();
	 
//        echo '<br>DEBUG sql in '.__FUNCTION__.'<br><pre>'.$this->db->last_query().'</pre>';   die();
		$valid = false;
		if(!empty($user_obj)){
			$pw = $user_obj['0']->id.'_'.$data['password'];  
			if($this->encrypt->decode($user_obj['0']->user_password) == $pw){ 
				$this->set_session_web($user_obj); 
				$valid = TRUE;	
			}else if($this->encrypt->decode($user_obj['0']->tmp_pwd) == $pw){ 
                            $this->set_session_web($user_obj);
                            $this->db->where('user_id',$user_obj['0']->user_id);
                            $this->db->update(USER_TBL, array('user_password'=>$user_obj['0']->tmp_pwd,'tmp_pwd'=>'','tmp_pwdreqdate'=>'0000-00-00'));
                            $valid = TRUE;	
			}else if( $this->encrypt->decode($user_obj['0']->user_password) != $pw){ 
                            $this->session->set_flashdata('error','Invalid Password !');
                            $valid = FALSE;
			}
		} 
                
            if(!$valid){$this->session->set_flashdata('error','Invalid Login');}
            return $valid;
	}
        
    function set_session_web($user_obj) //Add session data for web users
	{
	  	//echo '<pre>';print_r($user_obj);echo'<pre>';die;
		
        $session_data = array(
                              'ID'              => $user_obj['0']->id,
                              'user_role_ID'    => $user_obj['0']->user_role_id,
                              'user_first_name'	=> $user_obj['0']->first_name,
                              'user_last_name'	=> $user_obj['0']->last_name, 
                              'user_name'       => $user_obj['0']->user_name,
                              'is_logged_in' 	=> TRUE,
                              'access_type'	=> 'web',
                              'profile_pix'     => $user_obj['0']->pic
               );
			   
		$this->session->set_userdata($session_data);
        		
	}
        
        function check_authority($user_group,$page,$method)
	{   
                if($method == ''){ $method = 'index';}
		$this->db->select('mur.*, ma.status');
		$allowed= false;
		$this->db->from(MODULE_USER_ROLE_ACT.' mur');
		$this->db->join(MODULES_ACTION.' ma','ma.id= mur.module_action_id','LEFT');
		$this->db->join(MODULES.' m','m.id= ma.module_id','LEFT'); 
		$this->db->where('mur.user_role_id',$user_group);
		$this->db->where('mur.status','1');
		$this->db->where('m.page_id',$page); 
		$this->db->where('ma.action',$method); 
		$this->db->where('ma.status','1'); 
	  	$nav = $this->db->get()->result();
//               echo'<br>DEBUG...'.__FUNCTION__.'<br>';echo $this->db->last_query() ; die();
//        var_dump($nav); die;
		if(!empty($nav))
		{  			
                    $allowed = TRUE; 			
		}		
		return $allowed;
	}
        
        function get_user_menu_navigation($user_group)
	{
		$navigation = array();
		//Get the main navigations		
		$this->db->select('m.*,mur.display_order'); 
		$this->db->from(MODULE_USER_ROLE_ACT.' mur');
		$this->db->join(MODULES_ACTION.' ma','ma.id= mur.module_action_id','LEFT');
		$this->db->join(MODULES.' m','m.id= ma.module_id','LEFT'); 
		$this->db->where('mur.user_role_id',$user_group);
		//$this->db->where('uro.ID',$user_group);
		$this->db->where('m.hidden',0);
		$this->db->where('m.is_parent',1);
		$this->db->where('ma.status','1'); 
		$this->db->where('mur.status','1'); 
		$this->db->group_by('m.module_name');
		$this->db->order_by('mur.display_order');
		$nav = $this->db->get()->result(); 
		$i=0;
		$j="";
                
//		var_dump($nav); die;
		foreach($nav as $n){
			$subnav = $this->get_sub_navigation($user_group,$n->id); 
	  		$n->subnav = $subnav;
			$navigation[] = $n;	
			if($n->id == 1)
			{
                            $j=$i;
                            $arr=$n; 
			}
			$i++;
		}
		array_unshift($navigation,$arr);
		unset($navigation[$j+1]); 
		return $navigation;
	}
	

	function get_sub_navigation($user_group,$parent)
	{
                $this->db->select('m.*'); 
		$this->db->from(MODULE_USER_ROLE_ACT.' mur');
		$this->db->join(MODULES_ACTION.' ma','ma.id= mur.module_action_id','LEFT');
		$this->db->join(MODULES.' m','m.id= ma.module_id','LEFT'); 
		$this->db->where('mur.user_role_id',$user_group);
		//$this->db->where('uro.ID',$user_group);
		$this->db->where('m.hidden',0);
		$this->db->where('m.show_below',$parent);
		$this->db->where('ma.status','1'); 
		$this->db->where('mur.status','1'); 
		$this->db->group_by('m.module_name');
		$this->db->order_by('mur.display_order');
             
		$nav = $this->db->get()->result();
		return $nav;
	}
    /**
	 * get_special_navs
	 *
	 * Gets records from the user access tables for special links
	 *
	 * @param	string	The user group
	 * @param	array	A List of navigation types
	 * @return	object
	 */
    function get_special_navs($user_group, $navtypes)
    {
        $this->db->select('urmo.*, mo.option_name, mo.img_cls, mo.page_id, mo.show_below,mo.qab_txt');
        $this->db->from(MOD_FOR_USER_ROLE.' urmo');
        $this->db->join(MODULE_OPTION.' mo','mo.option_code = urmo.module_option_code');
        $this->db->where('user_role_id',$user_group);
        $this->db->where_in('type',$navtypes);
        $this->db->order_by('disp_order');
        $nav = $this->db->get()->result();
//        echo '<br>DEBUG sql in '.__FUNCTION__.'<br><pre>'.$this->db->last_query().'</pre>'; //die();
        return $nav;
    }
	
	
}
?>