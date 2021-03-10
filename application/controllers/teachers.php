<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Teachers extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/teacher_model");
		$this->lang->load("teachers", 'english');
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
		$data = $this->teacher_model->get_teacher_list($where,TRUE, TRUE);
		 $this->data["teachers"] = $data->teachers;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Teachers";
         $this->data["view"] = PUBLIC_DIR."teachers/teachers";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_teacher($teacher_id){
        
        $teacher_id = (int) $teacher_id;
        
        $this->data["teachers"] = $this->teacher_model->get_teacher($teacher_id);
        $this->data["title"] = "Teachers Details";
        $this->data["view"] = PUBLIC_DIR."teachers/view_teacher";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
