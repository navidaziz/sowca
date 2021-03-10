<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Sessions extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/session_model");
		$this->lang->load("sessions", 'english');
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
		$data = $this->session_model->get_session_list($where,TRUE, TRUE);
		 $this->data["sessions"] = $data->sessions;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = "Sessions";
         $this->data["view"] = PUBLIC_DIR."sessions/sessions";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_session($session_id){
        
        $session_id = (int) $session_id;
        
        $this->data["sessions"] = $this->session_model->get_session($session_id);
        $this->data["title"] = "Sessions Details";
        $this->data["view"] = PUBLIC_DIR."sessions/view_session";
        $this->load->view(PUBLIC_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
}        
