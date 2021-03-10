<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Courses extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/courses_model");
		$this->lang->load("courses", 'english');
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
		$data = $this->courses_model->get_courses_list($where,TRUE, TRUE);
		 $this->data["courses"] = $data->courses;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Courses";
         $this->data["view"] = PUBLIC_DIR."courses/courses";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_courses($course_id){
        
        $course_id = (int) $course_id;
        
        $this->data["courses"] = $this->courses_model->get_courses($course_id);
        $this->data["title"] = "Courses Details";
        $this->data["view"] = PUBLIC_DIR."courses/view_courses";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
