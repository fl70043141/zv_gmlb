<?php
if(!isset($_SESSION)) session_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('get_combo_from_results')){
    
    
        // generate serial
	function get_dropdown_data($table='', $name='', $id=''){
		$CI =& get_instance();
		$CI->db->select("".$name.",".$id."");	
		$res = $CI->db->get($table)->row();	
		return $res;
	}
	
	function get_combo_from_results($result , $id, $name , $empty_option = ''){
		$combo_ary = array();
		if($empty_option != ''){
			$combo_ary[''] = $empty_option;
		}
		if(count($result) > 0)
		{
			if(!is_array($name))
			{
				foreach($result as $row)
				{
					@$combo_ary[$row->$id] = $row->$name;
				}

			}else{
				foreach($result as $row)
				{
					$i=0;
					$fields = '';
					foreach($name as $nm){
						$fields .= $row->$nm.' ';
					}
					$combo_ary[$row->$id] = $fields;
				}
			}		
		}
		return 	$combo_ary;	
	}
}

/*	function get_xml_result($query , $root, $element){
		$CI =& get_instance();
		$CI->load->dbutil();
		$config = array (
                  'root'    => $root,
                  'element' => $element, 
                  'newline' => "\n", 
                  'tab'    => "\t"
                );
		echo $CI->dbutil->xml_from_result($query, $config);
	}
	
	function get_xml_from_array($ary, $root , $element){
		$doc = new DOMDocument();
		
		$r = $doc->createElement($root);
		$doc->appendChild($r);
		
		if(count($ary) > 0){
			foreach($ary as $row)
			{
				$parent = $doc->createElement($element);
				$r->appendChild($parent);
				foreach($row as $key=>$value){
					$value = htmlentities($value);
					$child = $doc->createElement($key , $value);
					$parent->appendChild($child);
				}
				
			}
		}
		echo $doc->saveXML();
	}
*/	

	function has_transactions($tbl_ary='')
	{
		
		$has_transactions=FALSE;
		$CI =& get_instance();
		
		foreach($tbl_ary as $ary)
		{
			
			$rows = $CI->db->get_where($ary['table_name'],array($ary['field_name']=>$ary['value']))->num_rows();
			
			if($rows > 0){ $has_transactions = TRUE; break; }
		}
		return $has_transactions;
	}

    function generate_tempass($salt)
{
 return  $temp_pasword=strtolower(str_shuffle(substr($salt,0,3).rand(0,100000)));
}
	
	function show_multi_col_results($one_d_ary, $no_cols, $inputfld = "",$td_class = '', $tr_class = '')
	{
		/*  in order to let the developer have the flexibility of having own formatting the 
			table tag is not included here 
		* $tr_class = the class for the row
		* $trd_class = the class for the column
		* $inputfld = the text desciption of an input field if any - eg.checkbox  
		*/	
		
		$echo_tbl = '';
		if($td_class!=''){$td_class = 'class="'.$td_class.'"';}
		if($tr_class!=''){$tr_class = 'class="'.$tr_class.'"';}
		 $cols = 1;
		foreach($one_d_ary as $key=>$val)
		{
			if($cols==$no_cols){$echo_tbl .='</tr>'; $cols =1;}
			if($cols==1){$echo_tbl .='<tr '.$tr_class.'>';}
			$echo_tbl .= '<td '.$td_class.'>'.$val.' '.$inputfld.'</td>';
			$cols++;
		}
		$cols--;// to make the counter equal to the actual columns created
		$i=1;
		if($cols!=$no_cols)
		{
			$bal_toprint = $no_cols - $cols;
			for($i=1;$i<=$bal_toprint;$i++)
			{
				$echo_tbl .= '<td '.$td_class.'>&nbsp;</td>';
			}
		}
		$echo_tbl .='</tr>';
		return $echo_tbl;
	}

	function get_user_full_name($user_id)
	{
		
		$CI =& get_instance();

		$CI->db->select('CONCAT(first_name," ",last_name) AS full_name',FALSE);
		$result = $CI->db->get_where(USER_TBL,array('ID'=>$user_id))->row();
		return $result->full_name;
	}


	function rows_to_columns($multirow_ary, $colname) // should be a 1 D  array - multiple rows, multip cols
	{
		$cols = array();
		//print'<pre>';print_r($multirow_ary);print'</pre>';
		foreach($multirow_ary as $row)
		{
			array_push($cols,$row[$colname]);
		}
		return $cols;
	}

	function prep_data($data,$tblname)
	{	
		$CI =& get_instance();	
		$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$CI->db->database."' AND TABLE_NAME = '".$tblname."'";
		$cols = $CI->db->query($sql)->result();
		foreach ($cols as $obj) {
			$col[] = $obj->COLUMN_NAME; 
		}

		foreach ($data as $key => $value) {
			if(in_array($key,$col)){
				$prep[$key] = $value; 
			}
		}
		
		return $prep;

	}
	
	
	
	// generate serial
	function generate_serial($table='', $column=''){
		$CI =& get_instance();
		$CI->db->select('IFNULL(MAX('.$column.'),0) AS max_no',FALSE);	
		$res_serial = $CI->db->get($table)->row();	
		$serial = $res_serial->max_no;
		$serial = ($serial == 0) ? SERIAL_STARTS : $serial+1;
		return $serial;
	}
	
	// Generate seq_no by each user id
	function generate_user_serial($table='', $seq_column='', $id_column='', $user_id='', $prefix='N'){
		$CI =& get_instance();
		$CI->db->select('IFNULL(MAX('.$seq_column.'), 0) AS max_no', FALSE);
		$CI->db->like($id_column, $prefix.$user_id, 'right');	
		$res_serial = $CI->db->get($table)->row();	
		$serial = $res_serial->max_no;
		$serial = ($serial == 0) ? SERIAL_STARTS : $serial+1;
		return $serial;
	}
    
	function gen_unique_id($mode='', $user='', $type='', $seqno=''){
		return $mode.$user.$type.$seqno;
	}
    
    function get_fixedval($type){
   	    $CI =& get_instance();
        return $result = $CI->db->get_where(FXDVAL,array('type'=>$type))->result();
    }
    
	
	// generate id
	function gen_id($prefix='', $table='', $column='', $pad_amount=6, $pad_sym='0')
    {
		return $id = $prefix.str_pad(generate_serial($table, $column), $pad_amount, $pad_sym, STR_PAD_LEFT);
	}
    
    function geninquiry_id($prefix='', $table='', $column='')
    {
		return $id = $prefix.generate_serial($table, $column);
	}
    
    function encode_url($toencode){
        if($toencode!=''){
        	return strtr(base64_encode($toencode), '+/=', '-__');
        }
    }
    
    function decode_url($todecode){
        if($todecode!=''){
        	return base64_decode(strtr($todecode, '-__', '+/='));
        }
    }
    function get_svrty_color($svrity_code)
    {
        $ret_code = '';
        $svrity = array('D' => 'danger','I'=>'info','F'=>'default','S'=>'success');
        if(array_key_exists($svrity_code,$svrity))
        {
           $ret_code =  $svrity[$svrity_code];
        }
        
        return $ret_code;
    }
    /**
     * get_btn_class_forpos
     * This is to show alternative colours for a row of buttons. the values could be extended if needed. Currently set for 4
     * @param int Button position
     * @return Button class
     */
    function get_btn_class_forpos($i)
    {
        $btn_cls = array('danger','info','success','warning','primary');  
        $pos = ($i % count($btn_cls));
        return $btn_cls[$pos];
    }
    /**
     * load_option_info
     * This is to load the information to the bread crumbs with the image position. 
     * @param string Button position
     * @return Button class
     */
    function load_option_info($option)
    {
        $CI =& get_instance();
        $CI->db->select('mo.*',false);
        $CI->db->from('u01_02module_option'.' mo');
        $CI->db->where('mo.option_code',$option);
        $qry = $CI->db->get()->row();
        if($qry->img_cls=='')
        {
            $qry->img_cls = get_image_parent($qry->show_below);
        }
        return $qry;
    }
    function get_image_parent($parent)
    {
        $CI =& get_instance();
        $CI->db->select('img_cls');
        $CI->db->from('u01_02module_option');
        $CI->db->where('option_code',$parent);
        $qry = $CI->db->get()->row(); 
        return $qry->img_cls;
    }
    function load_nav_breadcrumb($option)
    {
        // get the lower, then the parent
        // have the parent info and others separately
        $path_ary = array();
        $path_inf = new stdClass() ;
        $CI =& get_instance();
        $CI->db->select('mo.*',false);
        $CI->db->from('u01_02module_option'.' mo');
        $CI->db->where('mo.option_code',$option);
        $qry = $CI->db->get()->row();
        $path_ary[] = array('option_name'=>$qry->option_name,'page_id'=>$qry->page_id );
        $parent = $qry->show_below;
        while($parent!=''):
            $CI->db->select('*');
            $CI->db->from('u01_02module_option'.' mo');
            $CI->db->where('mo.option_code',$parent);
            $qry_parent = $CI->db->get()->row();
            $path_ary[] = array('option_name'=>$qry_parent->option_name,'page_id'=>$qry_parent->page_id ); 
            $parent =  $qry_parent->show_below;
            //$CI->db->free_result($qry_parent);
        endwhile;
        return $path_ary;
    }
    function badge_style_forrole($role_id)
    {
        $color = '';
        $badge = array("A"=>'danger',"E"=>'primary',"C"=>'info',"S"=>'success');
        for($i=0;$i<strlen($role_id);$i++)
        {
            $x = substr($role_id,$i,1);
            if(array_key_exists($x,$badge)){$color = $badge[$x]; break;}
        }
        return $color; 
    }

	function convert_date_to_mysql($date)
	{
		$date_val 	= str_replace('/', '-', $date);
		$newDate	= date('Y-m-d', strtotime($date_val));
		return $newDate;
	}
	
	function convert_date_ddmmyyyy($date)
	{
		$date_val 	= str_replace('-', '/', $date);
		$newDate	= date('d/m/Y', strtotime($date_val));
		
		if($date<date('d-m-Y'<strtotime('1971-01-01'))){ //return String if date< 1971-01-01
		return $date_val;
		}
		else{
		return $newDate;
		}
	}

	function convert_datetime($datetime)
	{
		$date_val 	= explode(" ", $datetime);
		$get_date 	= convert_date_to_mysql($date_val[0]);
		$NewDate 	= $get_date.' '.@$date_val[1];
		return $NewDate;
	}
		
	function convert_date_to_mysql_ym($date){ //parameter: Eg; 'YYYY MM'
		$date_val 	= str_replace(' ', '/', $date);
		$get_date =  convert_date_to_mysql($date_val);
		return substr($get_date,0,7);
	}
		
	function convert_date_to_mysql_ym2($date){ //parameter: Eg; 'YYYY MM'
		$date_val 	= str_replace(' ', '/', $date);
		$get_date =  convert_date_to_mysql($date_val);
		return $get_date;
	}
	
	function gt_time_in_seconds($field_name)
	{
		$value_lst_2_digits 	= substr($field_name, -2)*60; // mins
		$value_other			= substr($field_name,0,-2)*3600; //hours
		$total_seconds			= $value_lst_2_digits+$value_other;
		return $total_seconds;
		
	}
    
	
	function convert_yr_month($yrmonth)
	{
		$gt_yr			= substr($yrmonth,-4);
		$month 			= substr($yrmonth, 0, strpos($yrmonth, ' '));
		if($month=='January'){ 
			$gt_month = '01'; }
		if($month=='February'){ 
			$gt_month = '02'; }
		if($month=='March'){ 
			$gt_month = '03'; }
		if($month=='April'){ 
			$gt_month = '04'; }
		if($month=='May'){ 
			$gt_month = '05'; }
		if($month=='June'){ 
			$gt_month = '06'; }
		if($month=='July'){ 
			$gt_month = '07'; }
		if($month=='August'){ 
			$gt_month = '08'; }
		if($month=='September'){ 
			$gt_month = '09'; }
		if($month=='October'){ 
			$gt_month = '10'; }
		if($month=='November'){ 
			$gt_month = '11'; }
		if($month=='December'){ 
			$gt_month = '12'; }
			
		$yrmonth = $gt_yr.'-'.@$gt_month;
		
		return $yrmonth;
	
	}
	
	function do_upload($file_nm)
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($file_nm))
		{
			return "";
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			return $data['upload_data']['file_name'];
		}
	}
	
	function disp_time_in_HHMM($field_name)
	{
		 if($field_name == '00:00:00'){
			$value = '-'; 
		 } else {
			$value = substr($field_name,0,5); 
		 }
		 return $value;
	}
    function ary_off_remarks()
    {
        return  array(
            'off',
            'leave',
            'rest');
    }
	
	function convrt_to_hhmm($val)
	{
		$res 	= substr($val,-2);
		$value 	= strlen($res);
		if($value==1){ $gt_val = '0'.$res; } else { $gt_val = $res; }
		
		$res1 	= substr($val, 0, -2);
		$value1 	= strlen($res1);
		if($value1==1){ $gt_val1 = '0'.$res1; } else if ($value1==0){$gt_val1 = '00';} else { $gt_val1 = $res1; }
		
		
		$concat_vals = $gt_val1.':'.$gt_val;

		return $concat_vals;
	}

	/**
	 * @param integer $seconds Number of seconds to parse
	 * @return array
	 */
	function secondsToTime($seconds)
	{
		$hours = floor($seconds / (60 * 60));
		$divisor_for_minutes = $seconds % (60 * 60);
		$minutes = floor($divisor_for_minutes / 60);
		$divisor_for_seconds = $divisor_for_minutes % 60;
		$seconds = ceil($divisor_for_seconds);
		$obj = array(
			"h" => (int) $hours,
			"m" => (int) $minutes,
			"s" => (int) $seconds,
		);
		return $obj;
	}
	
