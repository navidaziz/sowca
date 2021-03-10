<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Sessions extends Admin_Controller_Mobile{
    
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
    


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`sessions`.`status` IN (0, 1) ";
		$data = $this->session_model->get_session_list($where, false);
		 echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_session($session_id){
        
        $session_id = (int) $session_id;
		$data = $this->session_model->get_session($session_id);
        echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`sessions`.`status` IN (2) ";
		$data = $this->session_model->get_session_list($where, true);
		 echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($session_id){
        
        $session_id = (int) $session_id;
		$this->session_model->changeStatus($session_id, "2");
        $data["msg_success"] = $this->lang->line("trash_msg_success");
        echo json_encode($data);
    }
    
    /**
      * function to restor session from trash
      * @param $session_id integer
      */
     public function restore($session_id){
        
        $session_id = (int) $session_id;
		$this->session_model->changeStatus($session_id, "1");
		$data["msg_success"] = $this->lang->line("restore_msg_success");
        echo json_encode($data);
        
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft session from trash
      * @param $session_id integer
      */
     public function draft($session_id){
        
        $session_id = (int) $session_id;
		$this->session_model->changeStatus($session_id, "0");
		$data["msg_success"] = $this->lang->line("draft_msg_success");
        echo json_encode($data);
       
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish session from trash
      * @param $session_id integer
      */
     public function publish($session_id){
        
        $session_id = (int) $session_id;
		$this->session_model->changeStatus($session_id, "1");
		$data["msg_success"] = $this->lang->line("publish_msg_success");
        echo json_encode($data);
        
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Session
      * @param $session_id integer
      */
     public function delete($session_id, $page_id = NULL){
        
        $session_id = (int) $session_id;
        //$this->session_model->changeStatus($session_id, "3");
        $this->session_model->delete(array( 'session_id' => $session_id));
		$data["msg_success"] = $this->lang->line("delete_msg_success");
        echo json_encode($data);
     }
     //----------------------------------------------------
    public function save_data(){
	
	$session_id = $this->session_model->save_data();
	$data["msg_success"] = $this->lang->line("add_msg_success");
    echo json_encode($data);
	
	 }


    
	 public function update_data($session_id){
		$session_id = $this->session_model->update_data($session_id);
		$data["msg_success"] = $this->lang->line("update_msg_success");
    	echo json_encode($data);
		
		 
		 }
	 
     
}        
