<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Scholarships extends Admin_Controller_Mobile{
    
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
    


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`scholarships`.`status` IN (0, 1) ";
		$data = $this->scholarship_model->get_scholarship_list($where, false);
		 echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_scholarship($scholarship_id){
        
        $scholarship_id = (int) $scholarship_id;
		$data = $this->scholarship_model->get_scholarship($scholarship_id);
        echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`scholarships`.`status` IN (2) ";
		$data = $this->scholarship_model->get_scholarship_list($where, true);
		 echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($scholarship_id){
        
        $scholarship_id = (int) $scholarship_id;
		$this->scholarship_model->changeStatus($scholarship_id, "2");
        $data["msg_success"] = $this->lang->line("trash_msg_success");
        echo json_encode($data);
    }
    
    /**
      * function to restor scholarship from trash
      * @param $scholarship_id integer
      */
     public function restore($scholarship_id){
        
        $scholarship_id = (int) $scholarship_id;
		$this->scholarship_model->changeStatus($scholarship_id, "1");
		$data["msg_success"] = $this->lang->line("restore_msg_success");
        echo json_encode($data);
        
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft scholarship from trash
      * @param $scholarship_id integer
      */
     public function draft($scholarship_id){
        
        $scholarship_id = (int) $scholarship_id;
		$this->scholarship_model->changeStatus($scholarship_id, "0");
		$data["msg_success"] = $this->lang->line("draft_msg_success");
        echo json_encode($data);
       
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish scholarship from trash
      * @param $scholarship_id integer
      */
     public function publish($scholarship_id){
        
        $scholarship_id = (int) $scholarship_id;
		$this->scholarship_model->changeStatus($scholarship_id, "1");
		$data["msg_success"] = $this->lang->line("publish_msg_success");
        echo json_encode($data);
        
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Scholarship
      * @param $scholarship_id integer
      */
     public function delete($scholarship_id, $page_id = NULL){
        
        $scholarship_id = (int) $scholarship_id;
        //$this->scholarship_model->changeStatus($scholarship_id, "3");
        $this->scholarship_model->delete(array( 'scholarship_id' => $scholarship_id));
		$data["msg_success"] = $this->lang->line("delete_msg_success");
        echo json_encode($data);
     }
     //----------------------------------------------------
    public function save_data(){
	
	$scholarship_id = $this->scholarship_model->save_data();
	$data["msg_success"] = $this->lang->line("add_msg_success");
    echo json_encode($data);
	
	 }


    
	 public function update_data($scholarship_id){
		$scholarship_id = $this->scholarship_model->update_data($scholarship_id);
		$data["msg_success"] = $this->lang->line("update_msg_success");
    	echo json_encode($data);
		
		 
		 }
	 
     
}        
