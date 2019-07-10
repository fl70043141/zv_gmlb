<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
    
    public $fl_header = '';
    public $fl_page_format = 'A4';
    public $sw_inv = '';
    
    function __construct()
    {
//        echo 'ssssss'; die;
        parent::__construct();
    }
    
    //Page header
    public function Header() {
        
//        echo 'ssssss'; die;
//        echo $this->fl_page_format; die;
        if($this->fl_header=='header_2'){
            $this->header_2();
        }else{ $this->header_empty();
            //blank
        }
    }
      // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
      
    }
    
    // Page footer
    public function header_2() {
//        echo 'ssssss'; die;
        // -- set new background --- 
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->getAutoPageBreak();
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image  
//        if($this->sw_inv=='sw_inv'){
            $image_file = COMPANY_LOGO.'big_rep_bg.jpg';
            $this->Image($image_file, 5, 5,  276, '', 'JPG', '', 'T', false, 72, '', false, false, 0, false, false, false);
//        }
    }
    public function header_pvc_bg() {
//        echo 'ssssss'; die;
        // -- set new background --- 
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->getAutoPageBreak();
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image  
//        if($this->sw_inv=='sw_inv'){
            $image_file = COMPANY_LOGO.'pvc_bg.jpg';
            $this->Image($image_file, 5, 5,  85.6, '', 'PNG', '', 'T', false, 72, '', false, false, 0, false, false, false);
//        }
    }
    // EMPTY HEADER
    public function header_empty() {
         // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->getAutoPageBreak();
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        
    }
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */