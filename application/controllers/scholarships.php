<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Scholarships extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/scholarship_model");
		$this->lang->load("scholarships", 'english');
		$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
		
		
    }
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){
        $this->view();
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`status` IN (1) ";
		$data = $this->scholarship_model->get_scholarship_list($where,TRUE, TRUE);
		 $this->data["scholarships"] = $data->scholarships;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Scholarships";
         $this->data["view"] = PUBLIC_DIR."scholarships/scholarships";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_scholarship($scholarship_id){
        
        $scholarship_id = (int) $scholarship_id;
        
        $this->data["scholarships"] = $this->scholarship_model->get_scholarship($scholarship_id);
        $this->data["title"] = "Scholarships Details";
        $this->data["view"] = PUBLIC_DIR."scholarships/view_scholarship";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
