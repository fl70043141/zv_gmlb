<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_dropdown_data'))
{
      // generate serial
	function get_dropdown_data($table='', $name='', $id='',$first_null_option='User', $where=''){
		$CI =& get_instance();
		$CI->db->select("".$name.",".$id."");	
		$CI->db->from($table);	 
                $CI->db->where('deleted',0);
                
                if($where != ''){
                    if(isset($where['col']) && isset($where['val'])){
                        $CI->db->where($where['col'],$where['val']);
                    }
                }
                
		$res = $CI->db->get()->result_array();
                $dropdown_data=array();
                
                if($first_null_option != ""){
                    $dropdown_data['']='Select '.$first_null_option;
                }
                foreach ($res as $res1){
                    $dropdown_data[$res1[$id]] = $res1[$name];
                }
		return $dropdown_data;
	}
}

function get_dropdown_value($dp_id){
    $CI =& get_instance();
    $CI->db->select("dropdown_value");	
    $CI->db->from(DROPDOWN_LIST);	
    $CI->db->where('id',$dp_id);
    $res = $CI->db->get()->result_array();
    if(isset($res[0]['dropdown_value'])){
        return $res[0]['dropdown_value'];
    }
    return 0;
    
}


if ( ! function_exists('get_autoincrement_no'))
{
      // generate serial
	function get_autoincrement_no($table=''){
		$CI =& get_instance();
                $query = $CI->db->query("SHOW TABLE STATUS LIKE '$table'");
                $row = $query->result();
                return $row[0]->Auto_increment;
		
	}
}


// generate serial
    function generate_serial($table='', $column=''){
            $CI =& get_instance();
            $CI->db->select('IFNULL(MAX('.$column.'),0) AS max_no',FALSE);	
            $res_serial = $CI->db->get($table)->row();	
            $serial = $res_serial->max_no;
            $serial = ($serial == 0) ? 1 : $serial+1;
            return $serial;
    }
    
if ( ! function_exists('gen_id'))
{
// generate id
    function gen_id($prefix='', $table='', $column='', $pad_amount=7, $pad_sym='0')
    {
        return $id = $prefix.str_pad(generate_serial($table, $column), $pad_amount, $pad_sym, STR_PAD_LEFT);
    }
}


// Encrypt Function
function mc_encrypt($encrypt, $key){
    $encrypt = serialize($encrypt);
    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
    $key = pack('H*', $key);
    $mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
    $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt.$mac, MCRYPT_MODE_CBC, $iv);
    $encoded = base64_encode($passcrypt).'|'.base64_encode($iv);
    return $encoded;
}
// Decrypt Function
function mc_decrypt($decrypt, $key){
    $decrypt = explode('|', $decrypt.'|');
    $decoded = base64_decode($decrypt[0]);
    $iv = base64_decode($decrypt[1]);
    if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ return false; }
    $key = pack('H*', $key);
    $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
    $mac = substr($decrypted, -64);
    $decrypted = substr($decrypted, 0, -64);
    $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
    if($calcmac!==$mac){ return false; }
    $decrypted = unserialize($decrypted);
    return $decrypted;
}

