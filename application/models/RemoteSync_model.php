<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RemoteSync_model extends CI_Model
{
   
    /**
     * FL NOTE --> WE MUST SET THIS REMOTE URL CORRECTLY
     * IF IT IS IN SAME LOCAL SERVER --> $url = "http://localhost/SYSTEM_NAME/PATH/TO/FILE/a.php";
     * IF IT IS IN REMOTE SERVER --> $url = "http://BGL.com/interface/punch/a.php";
     */    
    
     // private $url = "http://localhost/bgl_remote/sync.php";
    
//   $url = "http://berberyngemlab.com/bgl_reports/report_sync/BglSync";
    
    
    /*
     * FL NOTE --> THIS FUNCTION USE TO POST THE DATA TO REMOTE SERVER
     */
    public function postToRemoteServer($post_sub_array=array('fahry'=>1991))
    {
        $this->curl->create($this->url);
        
        //data serialize
        $post_data = array('post_data' => serialize($post_sub_array));
        
        
        //Post - If you do not use post, it will just run a GET request        
        $this->curl->post($post_data);    
        
        //Execute - returns responce
        $result = $this->curl->execute(); 
        echo '<img src="data:image/gif;base64,'.$result.'">'; die;
//        echo '<pre>';        print_r($result); die;

        /**
         * ARSP NOTE --> GIVEN BELOW CODES USE TO GET THE DEBUG INFORMATION
         *  Debug data ------------------------------------------------
         *          
         * Errors-->
         * $this->curl->error_code; // int
         * $this->curl->error_string;
         * 
         * Information-->
         * $this->curl->info; // array   
         */

        return $result; 
    }
}

?>