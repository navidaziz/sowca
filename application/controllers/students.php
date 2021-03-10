<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Students extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/student_model");
		$this->lang->load("students", 'english');
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
		$data = $this->student_model->get_student_list($where,TRUE, TRUE);
		 $this->data["students"] = $data->students;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Students";
         $this->data["view"] = PUBLIC_DIR."students/students";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_student($student_id){
        
        $student_id = (int) $student_id;
        
        $this->data["students"] = $this->student_model->get_student($student_id);
        $this->data["title"] = "Students Details";
        $this->data["view"] = PUBLIC_DIR."students/view_student";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
