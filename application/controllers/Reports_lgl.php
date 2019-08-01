<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_lgl extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Report_model');
        }

        public function index(){ 
              //I'm just using rand() function for data example 
            $this->view_search_report();
	}
        
        function view_search_report($datas=''){
//            $data['report_list'] = $this->Report_model->search_result();
            $data['main_content']='reports/search_report'; 
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
//            $data['country_list'] = get_dropdown_data(COUNTRY_LIST,'country_name','country_code','Country');
            $data = $this->load_data();
            $data['action']		= 'Add';
            $data['main_content'] = 'reports/manage_report';  
           
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'Edit';
            $data['main_content'] = 'reports/manage_report'; 
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content'] = 'reports/manage_report'; 
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='reports/manage_report';  
            $this->load->view('includes/template',$data);
	}
	
        
	function validate(){  
            $this->form_val_setrules(); 
            if($this->form_validation->run() == False){
                switch($this->input->post('action')){
                    case 'Add':
                            $this->add();
                            break;
                    case 'Edit':
                            $this->edit($this->input->post('id'));
                            break;
                    case 'Delete':
                            $this->delete($this->input->post('id'));
                            break;
                } 
            }
            else{
                switch($this->input->post('action')){
                    case 'Add':
                            $this->create();
                    break;
                    case 'Edit':
                        $this->update();
                    break;
                    case 'Delete':
                        $this->remove();
                    break;
                    case 'View':
                        $this->view();
                    break;
                }	
            }
	}
        
	function form_val_setrules(){
            $this->form_validation->set_error_delimiters('<p style="color:rgb(255, 115, 115);" class="help-block"><i class="glyphicon glyphicon-exclamation-sign"></i> ','</p>');

            $this->form_validation->set_rules('report_date','Report Date','min_length[5]');
            $this->form_validation->set_rules('object','Object','required');
            $this->form_validation->set_rules('customer','Customer','required');
            $this->form_validation->set_rules('gem_type','Report Type','required');
            $this->form_validation->set_rules('spec_cost','Special Cost','required');
            $this->form_validation->set_rules('identification','Identification','required');
            $this->form_validation->set_rules('variety','variety','required');
            $this->form_validation->set_rules('weight','Carat Weight','required');
            $this->form_validation->set_rules('dimension','Dimension','required');
            $this->form_validation->set_rules('cut','Cut','required');
//            $this->form_validation->set_rules('phone','phone','required|min_length[10]|integer'); 
//            $this->form_validation->set_rules('commission_value','Commission Value','required|numeric'); 
//            $this->form_validation->set_rules('credit_limit','Credit Limit','required|numeric'); 
        }
        
	function create(){ 
            $inputs = $this->input->post(); 
            $inputs['status'] = (isset($inputs['status']))?1:0;
            $inputs['show_origin'] = (isset($inputs['show_origin']))?1:0;
            $inputs['show_color_distribution'] = (isset($inputs['show_color_distribution']))?1:0;
            
            $report_no = gen_id(REPNO_PREFIX, LAB_REPORT, 'id');
           
             //create Dir if not exists for store necessary images 
            if(!is_dir(LAB_REPORT_IMAGES.$report_no.'/')) mkdir(LAB_REPORT_IMAGES.$report_no.'/', 0777, TRUE);
            
            $this->create_qr($report_no); //Generate QR
            $this->create_qr($report_no,'qr2'); //Generate QR 2 BG Blue
            $this->create_barcode($report_no); //Generate Barcode
            
            //Upload picture
            $pic_upload_1 = $this->do_upload('pic1','default',$report_no);  
            $pic_upload_2 = $this->do_upload('pic2','pic2',$report_no);  
            $pic_upload_3 = $this->do_upload('pic3','pic3',$report_no);  
                


            $data = array(
                            'report_no' => $report_no,
                            'customer_id' => $inputs['customer'],
                            'report_issued' => $inputs['report_issued'],
                            'gem_type' => $inputs['gem_type'],
                            'spec_cost' => $inputs['spec_cost'],
                            'report_date' => $inputs['report_date'],
                            'object' => $inputs['object'],
                            'identification' => $inputs['identification'],
                            'variety' => $inputs['variety'],
                            'weight' => $inputs['weight'],
                            'dimension' => $inputs['dimension'],
                            'cut' => $inputs['cut'],
                            'polish' => $inputs['polish'],
                            'shape' => $inputs['shape'],
                            'color' => $inputs['color'],
                            'color_distribution' => $inputs['color_distribution'],
                            'show_color_distribution' => $inputs['show_color_distribution'],
                            'transparency' => $inputs['transparency'],
                            'comments' => $inputs['comments'],
                            'appendix' => $inputs['appendix'],
                            'phenomonon' => $inputs['phenomonon'],
                            'treatment' => $inputs['treatment'],
                            'origin' => ($inputs['origin']=='')?'--':$inputs['origin'], //deflt Sri Lanka
                            'show_origin' => $inputs['show_origin'],
                            'refractive_index' => $inputs['refractive_index'],
                            'specific_gravity' => $inputs['specific_gravity'],
                            'ri_text_value' => $inputs['ri_text_value'],
                            'sg_text_value' => $inputs['sg_text_value'],
                            'hardness' => $inputs['hardness'],
                            'optical_character' => $inputs['optical_character'],
                            'plechroism' => $inputs['plechroism'],
                            'absorption_spectrum' => $inputs['absorption_spectrum'],
                            'fluorebcence' => $inputs['fluorebcence'],
                            'magnification' => $inputs['magnification'],
                            'special_note' => $inputs['special_note'],
                            'status' => $inputs['status'], 
                            'sync_required' => $inputs['sync_required'], 
                            'pic1' => $pic_upload_1,
                            'pic2' => $pic_upload_2,
                            'pic3' => $pic_upload_3,
                            'added_on' => date('Y-m-d'),
                            'added_by' => $this->session->userdata('ID'),
                        ); 
                    
		$add_stat = $this->Report_model->add_report($data);
                
		if($add_stat){
//                    $this->Report_model->edit_report($inputs['id'],array('sync_required' => $inputs['sync_required']));
                    $this->pvc_report_generate($report_no,'report_no');
                    $this->a4_report_generate($report_no,'report_no');
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect('reports'); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect('reports');
                } 
	}
        
        function create_qr($report_no,$qr_name='qr'){   
            //Generate QR Pic 
            $this->load->library('ciqrcode'); 
            $params['data'] = REPORT_VER_URL.'verification/report_verifcation.php?repno='. base64_encode($report_no);
            $params['level'] = 'H';
            $params['size'] = 10;
            if($qr_name!='qr')
                $params['black'] = array(33,78,137); 
            $params['white'] = array(64,64,64);
            $params['savename'] = LAB_REPORT_IMAGES.$report_no.'/'.$qr_name.'.png';
            $this->ciqrcode->generate($params);
            
            
        }
        
        function create_barcode($report_no){ 
             //Generate BarCode Pic
            $this->load->library('zend'); 
            $this->zend->load('Zend/Barcode'); //load in folder Zend
            $code = $report_no;
            $file = Zend_Barcode::draw('code128', 'image', array('text' => $code), array()); 
            $store_image = imagepng($file,LAB_REPORT_IMAGES.$report_no."/barcode.png");
            
        }
	
	function update(){
            $inputs = $this->input->post();
           
            $inputs['status'] = (isset($inputs['status']))?1:0;
            $inputs['show_origin'] = (isset($inputs['show_origin']))?1:0;
            $inputs['show_color_distribution'] = (isset($inputs['show_color_distribution']))?1:0;
            
            $report_no = $inputs['report_no'];

            
            //create Dir if not exists for store necessary images 
            if(!is_dir(LAB_REPORT_IMAGES.$report_no.'/')) mkdir(LAB_REPORT_IMAGES.$report_no.'/', 0777, TRUE);
            
            
            $this->create_qr($report_no); //Generate QR
            $this->create_qr($report_no,'qr2'); //Generate QR 2 BG Blue
            $this->create_barcode($report_no); //Generate Barcode

              $data = array( 
                            'customer_id' => $inputs['customer'],
                            'gem_type' => $inputs['gem_type'],
                            'report_issued' => $inputs['report_issued'],
                            'spec_cost' => $inputs['spec_cost'],
                            'report_date' => $inputs['report_date'],
                            'object' => $inputs['object'],
                            'identification' => $inputs['identification'],
                            'variety' => $inputs['variety'],
                            'weight' => $inputs['weight'],
                            'dimension' => $inputs['dimension'],
                            'cut' => $inputs['cut'],
                            'polish' => $inputs['polish'],
                            'shape' => $inputs['shape'],
                            'color' => $inputs['color'],
                            'color_distribution' => $inputs['color_distribution'],
                            'show_color_distribution' => $inputs['show_color_distribution'],
                            'transparency' => $inputs['transparency'],
                            'comments' => $inputs['comments'],
                            'appendix' => $inputs['appendix'],
                            'phenomonon' => $inputs['phenomonon'],
                            'treatment' => $inputs['treatment'],
                            'origin' => ($inputs['origin']=='')?'--':$inputs['origin'],
                            'show_origin' => $inputs['show_origin'],
                            'refractive_index' => $inputs['refractive_index'],
                            'specific_gravity' => $inputs['specific_gravity'],
                            'ri_text_value' => $inputs['ri_text_value'],
                            'sg_text_value' => $inputs['sg_text_value'],
                            'hardness' => $inputs['hardness'],
                            'optical_character' => $inputs['optical_character'],
                            'plechroism' => $inputs['plechroism'],
                            'absorption_spectrum' => $inputs['absorption_spectrum'],
                            'fluorebcence' => $inputs['fluorebcence'],
                            'magnification' => $inputs['magnification'],
                            'special_note' => $inputs['special_note'],
                            'status' => $inputs['status'], 
                            'updated_on' => date('Y-m-d'),
                            'updated_by' => $this->session->userdata('ID'),
                        ); 
                    
             //Upload picture
            $pic_upload_1 = $this->do_upload('pic1','default',$report_no);
            if($pic_upload_1!=''){
                $data['pic1'] = $pic_upload_1;
            } 
             //Upload picture
            $pic_upload_2 = $this->do_upload('pic2','pic2',$report_no);
            if($pic_upload_2!=''){
                $data['pic2'] = $pic_upload_2;
            } 
             //Upload picture
            $pic_upload_3 = $this->do_upload('pic3','pic3',$report_no);
            if($pic_upload_3!=''){
                $data['pic3'] = $pic_upload_3;
            } 
//            echo '<pre>';            print_r($inputs); die;
            $edit_stat = $this->Report_model->edit_report($inputs['id'],$data);
            if($edit_stat){
//            echo '<pre>';            print_r($inputs); die;
                $this->Report_model->edit_report($inputs['id'],array('sync_required' => $inputs['sync_required']));
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                redirect('reports_lgl/edit/'.$inputs['id']);
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect('reports');
            } 
	}	
        
        function remove(){
            $inputs = $this->input->post();
                                        
            $data = array(
                            'deleted' => 1,
                            'sync_required' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata('ID')
                         ); 
                                        
            $delete_stat = $this->Report_model->delete_report($inputs['id'],$data);
                    
            if($delete_stat){
                $this->Report_model->edit_report($inputs['id'],array('sync_required' => $inputs['sync_required']));
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect('reports');
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect('reports');
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            if($this->Report_model->delete2_report($id)){
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect('reports');
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect('reports');
            }  
	}
        
        function load_data($id=''){ 
            if($id!=''){ 
                $data['property_data'] = $this->Report_model->get_single_row($id); 
             }else{
                 
                $data['report_no'] = gen_id(REPNO_PREFIX, LAB_REPORT, 'id');
             }
            $data['country_list'] = get_dropdown_data(COUNTRY_LIST,'country_name','country_code','Country');
            $data['agent_type_list'] = get_dropdown_data(AGENT_TYPE,'agent_type_name','id','Agent Type');
            $data['customer_list'] = get_dropdown_data(AGENTS,'agent_name','id','Customer Name');
            $data['gem_type_list'] = get_dropdown_data(GEM_CAT,'name','id','Stone Category');
            $data['spec_cost_list'] = get_dropdown_data(SPEC_COST,'name','id','Special Cost');
            
            $data['item_list_dpd']             = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Item',array('col'=>'dropdown_id', 'val'=>4));
            $data['identification_list_dpd']   = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Identification',array('col'=>'dropdown_id', 'val'=>5));
            $data['variety_list_dpd']          = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Variety',array('col'=>'dropdown_id', 'val'=>6));
            $data['cut_list_dpd']              = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Cut',array('col'=>'dropdown_id', 'val'=>7));
            $data['shape_list_dpd']            = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Shape',array('col'=>'dropdown_id', 'val'=>8));
            $data['color_type_list_dpd']       = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Color Distribution',array('col'=>'dropdown_id', 'val'=>9));
            $data['refractive_index_list_dpd'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Refractive Index',array('col'=>'dropdown_id', 'val'=>10));
            $data['specific_gravity_list_dpd'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Item',array('col'=>'dropdown_id', 'val'=>11));
            $data['comments_list']             = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','dropdown_value','Comments',array('col'=>'dropdown_id', 'val'=>12));
            $data['phenomonon_list']           = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','dropdown_value','Phenomonon',array('col'=>'dropdown_id', 'val'=>13));

            return $data;	
	}	
        
        function search_report(){ 
                $status = $this->input->post('status'); 
                $inputs = $this->input->post();
//                echo '<pre>'; print_r($inputs); die;
		$search_data=array( 'report_no' => $this->input->post('report_no'),  
                                    'status' => ($status!='')?1:0,
                                    'sync_pending' => ($this->input->post('sync_pending')!='')?0:1, 
                                    ); 
                $limit='';
                if(isset($inputs['ignore_limit']) && $inputs['limit']>0 ){
                    $limit = $inputs['limit'];
                }
                    
		$data_view['search_list'] = $this->Report_model->search_result($search_data,$limit);
                                        
//                echo '<pre>'; print_r($data_view); die;
		$this->load->view('reports/search_report_result',$data_view);
	}
                                        
        function test(){
                $parent_id = $this->input->post('idnfcn_id');
                $this->db->select("dropdown_value, id");	
				$this->db->from(DROPDOWN_LIST);	 
                $this->db->where('deleted',0);
                $this->db->where('dropdown_id',6); //6 for variety
                if($parent_id > 0){
                    $this->db->where('parent_id',$parent_id); //identification - parent for variety
                }                       
                
				$res = $this->db->get()->result_array();
                $dropdown_data=array();
                    
                    $dropdown_data['']='Select Variety'; 
                foreach ($res as $res1){
                    $dropdown_data[$res1['id']] = $res1['dropdown_value'];
                }
//                echo '<pre>';                print_r($res); die;
//                echo form_dropdown('variety',$dropdown_data, set_value('variety'),' class="form-control select" data-live-search="true" id="variety" ');
            echo json_encode($res);
        }
        function get_dropdown_variety_data(){
                $parent_id = $this->input->post('idnfcn_id');
                $this->db->select("dropdown_value, id");	
				$this->db->from(DROPDOWN_LIST);	 
                $this->db->where('deleted',0);
                $this->db->where('dropdown_id',6); //6 for variety
                if($parent_id > 0){
                    $this->db->where('parent_id',$parent_id); //identification - parent for variety
                }                       
                
				$res = $this->db->get()->result_array();
                $dropdown_data=array();
                    
                    $dropdown_data['']='Select Variety'; 
                foreach ($res as $res1){
                    $dropdown_data[$res1['id']] = $res1['dropdown_value'];
                }
//                echo '<pre>';                print_r($res); die;
//                echo form_dropdown('variety',$dropdown_data, set_value('variety'),' class="form-control select" data-live-search="true" id="variety" ');
            echo json_encode($res);
        }
        
        function pvc_report_generate($report_no,$col_name='id'){ 
            $report_data = $this->Report_model->get_single_row($report_no,$col_name);
            $report_data = $report_data[0]; 
            
            $color_type_htm = '<tr><td>Colour Type</td> <td>:</td> <td>'.$report_data['color_distribution_val'].'</td></tr>';
            $appendix_htm = '';
            if($report_data['appendix']!=''){
                $appendix_htm = '<tr><td>Appendix</td> <td>:</td> <td>'.$report_data['appendix'].'</td></tr>';
            }
            $color_dist_htm = ($report_data['show_color_distribution']==1)?$color_type_htm:$appendix_htm;
            
            $qr_path = base_url().LAB_REPORT_IMAGES.$report_data['report_no'].'/qr.png';
            //load library
            $this->load->library('Pdf');
            $pdf = new Pdf('L', 'mm', array('85.6','54'), true, 'UTF-8', false);
                    
           
            $pdf->setPrintHeader(false);  // remove default header 
            $pdf->setPrintFooter(false);  // remove default footer 
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);// set default monospaced font
            $pdf->SetMargins(10, 1, 10); // set margins
            $pdf->SetAutoPageBreak(FALSE, 0); // set auto page breaks
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);// set image scale factor
                    
            // ---------------------------------------------------------
            $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
            $pdf->AddPage('L',array('86','54'));
                    
            //set bg color blue
//            $pdf->Rect(0, 0, $pdf->getPageWidth(),    $pdf->getPageHeight(), 'DF', array('all' => array('width' => 0)),  array(33, 78, 137));
//            $pdf->Line(1, 1, 85, 1);
//            $pdf->Line(1, 1, 1, 53);
            
            $html1 = '
                    <table border="0">
                        <tr>
                            <td width="80%">
                                <table border="0" style="padding-left:3px;color:black;line-height:13px;">
                                     <tr><td colspan="3" style="font-size:3px;"></td></tr>
                                    <tr style="font-weight: bold;">
                                        <td width="35%">Date</td>
                                        <td width="5%">:</td>
                                        <td width="73%">'.date("d M Y",strtotime($report_data['report_date'])).'</td>
                                    </tr>
                                    <tr style="font-weight: bold;">
                                        <td>Report No</td>
                                        <td>:</td>
                                        <td>'.$report_data['report_no'].'</td>
                                    </tr>
                                     <tr><td colspan="3" style="font-size:3px;"></td></tr>
                                     <tr>
                                        <td>Weight </td>
                                        <td>:</td>
                                        <td>'.$report_data['weight'].' carat</td>
                                    </tr>
                                     <tr>
                                        <td>Color </td>
                                        <td>:</td>
                                        <td>'.$report_data['color_distribution_val'].'</td>
                                    </tr>
                                     <tr>
                                        <td>Shape</td>
                                        <td>:</td>
                                        <td>'.$report_data['shape_val'].' '.$report_data['cut_val'].'</td>
                                    </tr>
                                     <tr>
                                        <td>Dimension </td>
                                        <td>:</td>
                                        <td>'.$report_data['dimension'].' mm</td>
                                    </tr>
                                     <tr>
                                        <td>Identification </td>
                                        <td>:</td>
                                        <td>'.($report_data['variety_val']).'</td>
                                    </tr>
                                     <tr>
                                        <td>Comments </td>
                                        <td>:</td>
                                        <td>'.($report_data['comments']).'</td>
                                    </tr>
                                    '.$color_dist_htm.'
                                </table>
                            </td>

                            <td align="center" width="20%">
                                <table>
                                    <tr><td></td></tr> 
                                    <tr><td height="5px;"></td></tr>
                                     <tr><td height="5px;"></td></tr>
                                
                                </table>
                            </td>
                        </tr>
                    </table>';
            
                $fontname = TCPDF_FONTS::addTTFfont('storage/fonts/HTOWERT.TTF', 'TrueTypeUnicode', '', 96);
                // use the font
                $pdf->SetFont($fontname, '', 15.5, '', false);
                $htm1_headerTexts = '<p style="font-size:9px; color:black;"><b>GEMSTONE BRIEF REPORT</b></p>'; 
                $pdf->writeHTMLCell(85.6, 1, 37,8.5,$htm1_headerTexts); 
                
                $fontname = TCPDF_FONTS::addTTFfont('storage/fonts/himalaya.ttf', 'TrueTypeUnicode', '', 96);
                $pdf->SetFont($fontname,'',14);  // set font 
                $pdf->SetFillColor(255,355,255);
                /* $pdf->writeHTMLCell(45, 17, 20, 0, '',0,0,TRUE); */

                $pdf->writeHTMLCell(85, 37, 0, 18.5, $html1); 
                
                
                
                
                $htm1_headerTexts = '<p style="font-size:22px; color:black;"><b>LONDON GEM LAB</b></p>'; 
                $pdf->writeHTMLCell(85.6, 1, 36,2,$htm1_headerTexts); 
                //logo lines  
                $pdf->Rect(0, 7.6, 86,0.45 , 'DF', array('all' => array('width' => 0,'color' => array(25, 51, 100))), array(25, 51, 100));
//                $pdf->Rect(0, 7.6, 86,0.25 , 'DF', array('all' => array('width' => 0)),  array(255, 255, 255));
                $pdf->Image(base_url().'storage/images/company/lgl_header_logo.png',5.5,2.5,20,17,'PNG'); 
                //QR corner
//                $pdf->Image($qr_path,72,41,11,11,'PNG'); 
                //QR default
                $pdf->Image($qr_path,67.5,37,15,15,'PNG'); 
                
                //stone pic default
                $pdf->Rect(66.75, 18.25, 16.5,16.5, 'DF', array('all' => array('width' => 0.5,'color' => array(25, 51, 100))),  array(255, 255, 255));
                $pdf->Image(LAB_REPORT_IMAGES.$report_data['report_no'].'/'.$report_data['pic1'],67,18.5,16,16); 

                    
                    //Close and output PDF document
                if (file_exists(BASEPATH.'.'.LAB_REPORT_PVC_PDF.$report_data['report_no'].'.pdf')){
                    //move existing file before generated new one
//                    rename(BASEPATH.'.'.LAB_REPORT_PVC_PDF.$report_data['report_no'].'.pdf', BASEPATH.'.'.LAB_REPORT_PVC_PDF_TRASH.$report_data['report_no'].'_'.time().'.pdf'); 
    //                unlink(BASEPATH.'.'.LAB_REPORT_PDF.$report_data['report_no'].'.pdf');
                }
//                    $pdf_output = $pdf->Output(BASEPATH.'.'.LAB_REPORT_PVC_PDF.$report_data['report_no'].'_pvc.pdf', 'I'); 
                    $pdf_output = $pdf->Output(BASEPATH.'.'.LAB_REPORT_PVC_PDF.$report_data['report_no'].'_pvc.pdf', 'F');
//                    die;
//                    echo '<pre>';                    print_r($pdf_output); die;
                    $this->session->set_flashdata('warn','The PVC report data generated.');

                    
        }
                                        
        function report_print($report_no,$e_report=0){
            $report_data = $this->Report_model->get_single_row($report_no);
            $report_data = $report_data[0];
            if($e_report==1){
//                echo LAB_E_REPORT_PDF.$report_data['report_no'].'.pdf'; die;
                if(file_exists(LAB_E_REPORT_PDF.$report_data['report_no'].'.pdf'))
                    redirect(base_url().LAB_E_REPORT_PDF.$report_data['report_no'].'.pdf');
                else{
                    $this->a4_report_generate($report_no,'id',true);
                    redirect(base_url().LAB_E_REPORT_PDF.$report_data['report_no'].'.pdf');
                    }
                }
            else
                redirect(base_url().LAB_REPORT_PDF.$report_data['report_no'].'.pdf');
        }
        function report_print_pvc($report_no){
            $report_data = $this->Report_model->get_single_row($report_no);
            $report_data = $report_data[0];
            redirect(base_url().LAB_REPORT_PVC_PDF.$report_data['report_no'].'_pvc.pdf');
        }
        
        function report_generate($report_no,$col_name='id'){ //parameter report_id
            $this->pvc_report_generate($report_no,$col_name);
            $this->a4_report_generate($report_no,$col_name);
        }
        
        function a4_report_generate($report_no,$col_name='id',$bg=false){ //parameter report_id
            $report_data = $this->Report_model->get_single_row($report_no,$col_name);
            $report_data = $report_data[0];
//            echo '<pre>';            print_r($report_data); die;
            
            //hide Data
            $col_ditr = ' <tr>
                                <td width="26%" align="right">Colour Type :</td>
                                <td width="5%" align="center"></td>
                                <td width="80%">'.$report_data['color_distribution_val'].'</td>
                            </tr>';
            
            //appendix instead of color_type or color distribution
			$appendix ='';
            if($report_data['appendix'] !=''){
                $appendix= ' <tr>
                                    <td width="26%" align="right">Appendix :</td>
                                    <td width="5%" align="center"></td>
                                    <td width="78%">'.$report_data['appendix'].'</td>
                            </tr>';
            }
			//Origin left side 
			$origin_left='';
            if($report_data['show_origin']==1){
                $origin_left= ' <tr>
                                    <td width="26%" align="right">Origin :</td>
                                    <td width="5%" align="center"></td>
                                    <td style="" width="80%">Gemmological testing revealed charecteristics corresponding to those '.$report_data['identification_val'].' from <b>'.$report_data['country_name'].'</b></td>
                            </tr>
							<tr><td colspan="3"></td></tr>
							<tr>
                                    <td width="26%" align="right"></td>
                                    <td width="5%" align="center"></td>
                                    <td width="80%">Any statement on geographic origin is an expert opinion based on a collection of observations and analytical data.</td>
                            </tr>';
            }
            //Phenomonon instead of color_type or color distribution
			$phenomonon='';
            if($report_data['phenomonon'] !=''){
                $phenomonon= ' <tr>
                                    <td width="26%" align="right">Phenomenon :</td>
                                    <td width="5%" align="center"></td>
                                    <td width="78%">'.$report_data['phenomonon'].'</td>
                            </tr>';
            }
            //Treatment instead of color_type or color distribution
			$treatment = '';
            if($report_data['treatment'] !=''){
                $treatment= ' <tr>
                                    <td width="26%" align="right"> :'.strtoupper('Treatment').':</td>
                                    <td width="5%" align="center"></td>
                                    <td width="78%">'.$report_data['treatment'].'</td>
                            </tr>';
            }
            
            $origin = '<table border="0">
                            <tr>
                                <td height="160px"></td>
                            </tr>
                            <tr>
                                <td height="30px" colspan="2" style="letter-spacing:3px;text-align:center;font-size:15px;"><b></b></td>
                            </tr>  
							<tr>
                                <td height="20px" colspan="2" style="letter-spacing:0.5px;line-height:0px;text-align:center;font-size:13px;">'.$report_data['comments'].'</td>
                            </tr> 
                            <tr>
                                <td width="90%" style="font-size:15px;"><b>Origin</b></td>
                                <td width="10%"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="line-height:120%;text-align:justify;font-size:13px;">Gemmological testing revealed charecteristics corresponding to those '.$report_data['identification_val'].' from:</td>
                                
                            </tr> 
                            <tr>
                                <td colspan="2"  align="center" style="font-size:15px; line-height: 25px;"><b>'.$report_data['country_name'].'</b></td>
                                
                            </tr>
                        </table>';
            $origin2 = '<table border="0">
                            <tr>
                                <td colspan="2" height="0px"></td>
                            </tr>
                            <tr>
                                <td width="96%" height="40px"  style="letter-spacing:0px;text-align:center;font-size:20px;"></td>
                                <td width="4%" ></td>
                            </tr>  
                            <tr>
                                <td width="96%" style="line-height:120%;text-align:center;font-size:13px;">'.$report_data['comments'].'</td>
                                <td width="4%" ></td>
                            </tr>  
                        </table>';
            $show_color_distribution = ($report_data['show_color_distribution']==1)?$col_ditr:$appendix;
            // $show_origin = ($report_data['show_origin']==1)?$origin:$origin2;
            $show_origin = ($report_data['show_origin']==1)?$origin2:$origin2;
            
            $logo_path = base_url().COMPANY_LOGO.'logo_1.png';
            $qr_path = base_url().LAB_REPORT_IMAGES.$report_data['report_no'].'/qr.png';
            $barcode_path = base_url().LAB_REPORT_IMAGES.$report_data['report_no'].'/barcode.png';
            //load library
            $this->load->library('Pdf');

            $pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
//            echo $bg;die;
           
                if($bg==true){
                   $pdf->fl_header='header_2';//invice bg  
               }
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Fahry Lafir');
            $pdf->SetTitle('PDF BGL Report');
            $pdf->SetSubject('BGL Report');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

            
              // set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

            // remove default header/footer
//            $pdf->setPrintHeader(false);
//            $pdf->setPrintFooter(false);

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(10, 15, 10);
            

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 5);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
            }

            // ---------------------------------------------------------

            $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');

            // set font
            $pdf->SetFont('helvetica');  

             $pdf->AddPage('L', 'A4');
			
//            $pdf->AddPage('L',array('210','215'));
            
//            $pdf->Image(COMPANY_LOGO.'report-test.jpg',0,0,'215','215');  //Temp bg
                    
//            $pdf->Line(107.5, 0, 107.5, 210);
//            $pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C'); 
            // define some HTML content with style
$html = '
<!-- EXAMPLE OF CSS STYLE -->
<style>
   #report_content, th, td {
    font-size:13px;
    height: 17px; 
    line-height: 25px; 
}
</style>
 
<br />

<table  class="first" border="0" cellpadding="0" cellspacing="6">
        <tr>
            <td width="45%">
                    <table border="0">
                        <tr><td  height="165px"  align="center"> 
                              <!--  <img style="width:250px; size:100%" src="$logo_path"> -->
                            </td></tr> 
                        <tr><td align="center"></td></tr> 
                        <tr><td align="center"><H2></H2></td></tr> 
                     
                        <tr>
                            <td>
                                <table width="425px" border="0" id="report_content">
                                    <tr>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td width="26%" align="left"><b>Date</b> </td>
                                        <td width="5%" align="center">:</td>
                                        <td width="78%">'.$report_data['report_date'].'</td>
                                    </tr>
                                    <tr>
                                        <td width="26%" align="left"><b>Report No </b></td>
                                        <td width="5%" align="center">:</td>
                                        <td width="78%">'.$report_data['report_no'].'</td>
                                    </tr> 
                                    <tr>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td width="26%" align="left"><b>Item </b></td>
                                        <td width="5%" align="center">:</td>
                                        <td width="78%">'.$report_data['object_val'].'</td>
                                    </tr>
                                    <tr>
                                        <td width="26%" align="left"><b>Weight </b></td>
                                        <td width="5%" align="center">:</td>
                                        <td width="78%">'.$report_data['weight'].' ct</td>
                                    </tr>
                                    <tr>
                                        <td width="26%" align="left"><b>Color </b></td>
                                        <td width="5%" align="center">:</td>
                                        <td width="78%">'.$report_data['color'].'</td>
                                    </tr>
                                    <tr>
                                        <td width="26%" align="left"><b>Shape </b></td>
                                        <td width="5%" align="center">:</td>
                                        <td width="78%">'.$report_data['shape_val'].'</td>
                                    </tr>
                                    <tr>
                                        <td width="26%" align="left"><b>Cut </b></td>
                                        <td width="5%" align="center">:</td>
                                        <td width="78%">'.$report_data['cut_val'].'</td>
                                    </tr> 
                                    <tr>
                                        <td width="26%" align="left"><b>Dimension </b></td>
                                        <td width="5%" align="center">:</td>
                                        <td width="78%">'.$report_data['dimension'].' mm</td>
                                    </tr>
                                    <tr>
                                        <td width="26%" align="left"><b>Transperancy </b></td>
                                        <td width="5%" align="center">:</td>
                                        <td width="78%">'.$report_data['transparency'].'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                    </tr> 
                                    <tr>
                                        <td colspan="3"><b>Conclusion</b></td>
                                    </tr>
                                    <tr>
                                        <td width="26%" align="left"><b>Variety </b></td>
                                        <td width="5%" align="center">:</td>
                                        <td width="78%"><b>'.$report_data['variety_val'].'</b></td>
                                    </tr> 
                                    <tr>
                                        <td width="26%" align="left"><b>Species</b> </td>
                                        <td width="5%" align="center">:</td>
                                        <td width="78%"><b>'.$report_data['identification_val'].'</b></td>
                                    </tr> 
                                    
                                    <tr>
                                        <td style="line-height:30px;" colspan="3"></td>
                                    </tr>
                                       
                                    <tr>
                                        <td colspan="3"></td>
                                    </tr> 
                                    <tr>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td height="30px;" colspan="3"></td>
                                    </tr>
                                     
                                </table>
                            </td>
                        </tr>
                    </table>
            </td>
             
            <td width="50%">
                    '.$show_origin.'
            </td>
        
        </tr>
</table>';
            // define some HTML content with style
$html2 = <<<EOF
        <table border="0">
         <tr>
            <td colspan="1">
                <img style="width:83px;height:81px" src="$qr_path">
            </td>
            <td colspan="2">
                <table border="0">
                    <tr>
                        <td height="24px;"></td>
                    </tr> 
                </table>
            </td>
        </tr>
    </table>
EOF;

//            echo '<pre>';            print_r($report_data); die;

$html3 = "Scan the QR & verify this report here.";
if($bg==true){ 
    $pdf->Image(LAB_REPORT_IMAGES.$report_data['report_no'].'/'.$report_data['pic1'],205,13,33,''); 
}

// $pdf->Line(295, 0, 295, 250);
// $pdf->Line(100, 0, 100, 250);
// $pdf->Line(195, 0, 195, 250);
// output the HTML content

$pdf->SetTextColor(64,64,64);
$fontname = TCPDF_FONTS::addTTFfont('storage/fonts/lgl/SourceSansPro-Regular.ttf', 'TrueTypeUnicode', '', 96);
$pdf->SetFont($fontname,'',14);  // set font 
$pdf->writeHTMLCell(215, 160, 98, 0, $html);

$pdf->writeHTMLCell(138, 10, 102, 182, $html2);
$pdf->SetFontSize(10.5);
$pdf->writeHTMLCell(138, 10, 128,190, $html3); 
//$pdf->Image(LAB_REPORT_IMAGES.'../other/arrow.png',153,65,18,''); 

$report_path = ($bg==true)?LAB_E_REPORT_PDF:LAB_REPORT_PDF;
//echo $report_path; die;    
//                        //Close and output PDF document
            if (file_exists(BASEPATH.'.'.$report_path.$report_data['report_no'].'.pdf')){
                //move existing file before generated new one
                rename(BASEPATH.'.'.$report_path.$report_data['report_no'].'.pdf', BASEPATH.'.'.LAB_REPORT_PDF_TRASH.$report_data['report_no'].'_'.time().'.pdf'); 
//                unlink(BASEPATH.'.'.LAB_REPORT_PDF.$report_data['report_no'].'.pdf');
            } 
//            $pdf_output = $pdf->Output(BASEPATH.'.'.$report_path.$report_data['report_no'].'.pdf', 'F');
            $pdf_output = $pdf->Output(BASEPATH.'.'.$report_path.$report_data['report_no'].'.pdf', 'I');
            die;
            
            $this->a4_report_generate_2($report_data['id']);
            $this->session->set_flashdata('warn','The report data generated.');
                    
            redirect(base_url().'reports_lgl/edit/'.$report_data['id']);

//            echo gen_id(REPNO_PREFIX, LAB_REPORT, 'id');
//            echo BASEPATH.'../'.LAB_REPORT_PDF;
        }
        
        function a4_report_generate_2($report_no,$col_name='id',$bg=true){ //parameter report_id
            $report_data = $this->Report_model->get_single_row($report_no,$col_name);
            $report_data = $report_data[0];
//            echo '<pre>';            print_r($report_data); die;
            
            
            //hide Data
            $col_ditr = ' <tr>
                                <td width="28%" align="left"><b>Colour Type:</b></td>
                                <td width="1%" align="center"></td>
                                <td width="78%">'.$report_data['color_distribution_val'].'</td>
                            </tr>';
            
            //appendix instead of color_type or color distribution
			$appendix ='';
            if($report_data['appendix'] !=''){
                $appendix= ' <tr>
                                    <td width="28%" align="left"><b>Appendix:</b></td>
                                    <td width="1%" align="center"></td>
                                    <td width="78%">'.$report_data['appendix'].'</td>
                            </tr>';
            }
            //Phenomonon instead of color_type or color distribution
			$phenomonon='';
            if($report_data['phenomonon'] !=''){
                $phenomonon= ' <tr>
                                    <td width="28%" align="left">Phenomenon:</td>
                                    <td width="1%" align="center"></td>
                                    <td width="78%">'.$report_data['phenomonon'].'</td>
                            </tr>';
            }
            //Treatment instead of color_type or color distribution
			$treatment = '';
            if($report_data['treatment'] !=''){
                $treatment= ' <tr>
                                    <td width="28%" align="left">:'.strtoupper('Treatment').':</b></td>
                                    <td width="1%" align="center"></td>
                                    <td width="78%">'.$report_data['treatment'].'</td>
                            </tr>';
            }
            
            $origin = '<table border="0">
                            <tr>
                                <td height="160px"></td>
                            </tr>
                            <tr>
                                <td height="30px" colspan="2" style="text-align:center;font-size:18px;"><b>'.strtoupper($report_data['variety_val']).'</b></td>
                            </tr>
                            <tr>
                                <td width="90%" style="font-size:18px;"><b>Origin</b></td>
                                <td width="10%"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:justify;font-size:14px;">Gemmological testing revealed charecteristics corresponding to those '.$report_data['identification_val'].' from:</td>
                                
                            </tr> 
                            <tr>
                                <td colspan="2"  align="center" style="font-size:17px; line-height: 25px;"><b>'.$report_data['country_name'].'</b></td>
                                
                            </tr>
                        </table>';
            $origin2 = '<table border="0">
                            <tr>
                                <td height="160px"></td>
                            </tr>
                            <tr>
                                <td height="30px" colspan="2" style="text-align:center;font-size:18px;">'.strtoupper($report_data['variety_val']).'</td>
                            </tr> 
                        </table>';
            $show_color_distribution = ($report_data['show_color_distribution']==1)?$col_ditr:$appendix;
            $show_origin = ($report_data['show_origin']==1)?$origin:$origin2;
            
            $logo_path = base_url().COMPANY_LOGO.'logo_1.png';
            $qr_path = base_url().LAB_REPORT_IMAGES.$report_data['report_no'].'/qr.png';
            $barcode_path = base_url().LAB_REPORT_IMAGES.$report_data['report_no'].'/barcode.png';
            //load library
            $this->load->library('Pdf');

            $pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
//            echo $bg;die;
           
                if($bg==true){
                   $pdf->fl_header='header_2';//invice bg  
               }
            // set document information
             // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Fahry Lafir');
            $pdf->SetTitle('PDF BGL Report');
            $pdf->SetSubject('BGL Report');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

            
              // set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

            // remove default header/footer
//            $pdf->setPrintHeader(false);
//            $pdf->setPrintFooter(false);

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(10, 15, 10);
            

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 5);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
            }

            // ---------------------------------------------------------

            $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');

            // set font
            $pdf->SetFont('helvetica');  

            // $pdf->AddPage('L', 'A4');
			
            $pdf->AddPage('L',array('287','195'));
//            $pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C'); 
            // define some HTML content with style
$html = '
<!-- EXAMPLE OF CSS STYLE -->
<style>
   #report_content, th, td {
    font-size:13px;
    height: 17px; 
    line-height: 15px;
}
</style>
 
<br />

<table  class="first" border="0" cellpadding="4" cellspacing="6">
        <tr>
            <td width="50%">
                    <table border="0">
                        <tr><td  height="70px"  align="center"> 
                              <!--  <img style="width:250px; size:100%" src="$logo_path"> -->
                            </td></tr> 
                        <tr><td align="center"></td></tr> 
                        <tr><td align="center"><H2></H2></td></tr> 
                    
                        <tr><td></td></tr>
                        <tr>
                            <td>
                                <table width="425px" border="0" id="report_content">
                                  
                                    <tr>
                                        <td width="28%" align="left"><b>Report No:</b></td>
                                        <td width="1%" align="center"></td>
                                        <td width="78%"><b>'.$report_data['report_no'].'</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td width="28%" align="left">Date:</td>
                                        <td width="1%" align="center"></td>
                                        <td width="78%">'.$report_data['report_date'].'</td>
                                    </tr>
                                    <tr>
                                        <td width="28%" align="left">Item:</td>
                                        <td width="1%" align="center"></td>
                                        <td width="78%">'.$report_data['object_val'].'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td width="28%" align="left">Weight:</td>
                                        <td width="1%" align="center"></td>
                                        <td width="78%">'.$report_data['weight'].' carat</td>
                                    </tr>
                                    <tr>
                                        <td width="28%" align="left">Measurement:</td>
                                        <td width="1%" align="center"></td>
                                        <td width="78%">'.$report_data['dimension'].' mm</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td width="28%" align="left">Shape:</td>
                                        <td width="1%" align="center"></td>
                                        <td width="78%">'.$report_data['shape_val'].'</td>
                                    </tr>
                                    <tr>
                                        <td width="28%" align="left">Cut:</td>
                                        <td width="1%" align="center"></td>
                                        <td width="78%">'.$report_data['cut_val'].'</td>
                                    </tr> 
                                    <tr>
                                        <td width="28%" align="left">Transperancy:</td>
                                        <td width="1%" align="center"></td>
                                        <td width="78%">'.$report_data['transparency'].'</td>
                                    </tr>
                                    <tr>
                                        <td width="28%" align="left">Colour:</td>
                                        <td width="1%" align="center"></td>
                                        <td width="78%">'.$report_data['color'].'</td>
                                    </tr>
									
                                   '.$show_color_distribution.'
									'.$phenomonon.'
                                    
                                    <tr>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td width="28%" align="left"><b>VARIETY:</b></td>
                                        <td width="1%" align="center"></td>
                                        <td style="color:;" width="78%"><b>'.strtoupper($report_data['variety_val']).'</b></td>
                                    </tr>
                                    <tr>
                                        <td width="28%" align="left"><b>SPECIES:</b></td>
                                        <td width="1%" align="center"></td>
                                        <td style="color:;" width="78%"><b>'.strtoupper($report_data['identification_val']).'</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td width="28%" align="left"><b>COMMENTS:</b></td>
                                        <td width="1%" align="center"></td>
                                        <td width="78%"></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:justify;" colspan="3">'.$report_data['comments'].'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td height="30px;" colspan="3"></td>
                                    </tr>
                                     
                                </table>
                            </td>
                        </tr>
                    </table>
            </td>
            <td width="1%"></td>
            <td width="48%">
                    '.$show_origin.'
            </td>
        
        </tr>
</table>';
            // define some HTML content with style
$html2 = <<<EOF
        <table border="0">
         <tr>
            <td colspan="1">
                <img style="width:62px;height:62px" src="$qr_path">
            </td>
            <td colspan="2">
                <table border="0">
                    <tr>
                        <td height="19px;"></td>
                    </tr>
                    <tr>
                        <td width="100%" align="right"><img style="width:136px; size=100%;" src="$barcode_path"></td>
                        <td width="5%"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
EOF;

//            echo '<pre>';            print_r($report_data); die;

$html3 = "Verify this report at ".WEB_URL." <br> or <b>scan QR code</b>";
if($bg==true){ 
    // $pdf->Image(LAB_REPORT_IMAGES.$report_data['report_no'].'/'.$report_data['pic1'],194.5,12.3	5,32,''); 
}
// output the HTML content
$pdf->writeHTMLCell(277, 160, 3, 16, $html);
$pdf->writeHTMLCell(140, '', 3, 177, $html2);
$pdf->SetFontSize(10.5);
$pdf->writeHTMLCell(140, 10, 27,177, $html3);

// $pdf->Line(143.5, 0, 143.5, 250);

$report_path = ($bg==true)?LAB_E_REPORT_PDF:LAB_REPORT_PDF;
//echo $report_path; die;    
//                        //Close and output PDF document
            if (file_exists(BASEPATH.'.'.$report_path.$report_data['report_no'].'.pdf')){
                //move existing file before generated new one
                rename(BASEPATH.'.'.$report_path.$report_data['report_no'].'.pdf', BASEPATH.'.'.LAB_REPORT_PDF_TRASH.$report_data['report_no'].'_'.time().'.pdf'); 
//                unlink(BASEPATH.'.'.LAB_REPORT_PDF.$report_data['report_no'].'.pdf');
            } 
            $pdf_output = $pdf->Output(BASEPATH.'.'.$report_path.$report_data['report_no'].'.pdf', 'F');
                    
            $this->session->set_flashdata('warn','The report data generated.');
                    
            redirect(base_url().'reports_lgl/edit/'.$report_data['id']);

//            echo gen_id(REPNO_PREFIX, LAB_REPORT, 'id');
//            echo BASEPATH.'../'.LAB_REPORT_PDF;
        }
        
       function do_upload($file_nm, $pic_name='default', $upload_dir=''){
            $config['upload_path'] = LAB_REPORT_IMAGES.$upload_dir.'/';
            $config['file_name'] = $pic_name;
            $config['overwrite'] = true;

            $config['allowed_types'] = 'gif|jpg|png'; 

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ( ! $this->upload->do_upload($file_nm)){
                    return "";
            }
            else{
                $data = array('upload_data' => $this->upload->data());  
                return $data['upload_data']['file_name'];
            }
	}
        
        function get_ri_sg_for_variety(){
            $this->load->model('Dropdown_model');
            $drp_dwn_data = $this->Dropdown_model->get_single_row($this->input->post('drp_dwn_id'));
//            $drp_dwn_data = array('ss'=>'aaaa');
            
            echo json_encode($drp_dwn_data[0]);
        }
}
