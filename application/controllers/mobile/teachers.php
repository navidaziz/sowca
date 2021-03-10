<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Teachers extends Admin_Controller_Mobile{
    
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
    


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`teachers`.`status` IN (0, 1) ";
		$data = $this->teacher_model->get_teacher_list($where, false);
		 echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_teacher($teacher_id){
        
        $teacher_id = (int) $teacher_id;
		$data = $this->teacher_model->get_teacher($teacher_id);
        echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`teachers`.`status` IN (2) ";
		$data = $this->teacher_model->get_teacher_list($where, true);
		 echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($teacher_id){
        
        $teacher_id = (int) $teacher_id;
		$this->teacher_model->changeStatus($teacher_id, "2");
        $data["msg_success"] = $this->lang->line("trash_msg_success");
        echo json_encode($data);
    }
    
    /**
      * function to restor teacher from trash
      * @param $teacher_id integer
      */
     public function restore($teacher_id){
        
        $teacher_id = (int) $teacher_id;
		$this->teacher_model->changeStatus($teacher_id, "1");
		$data["msg_success"] = $this->lang->line("restore_msg_success");
        echo json_encode($data);
        
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft teacher from trash
      * @param $teacher_id integer
      */
     public function draft($teacher_id){
        
        $teacher_id = (int) $teacher_id;
		$this->teacher_model->changeStatus($teacher_id, "0");
		$data["msg_success"] = $this->lang->line("draft_msg_success");
        echo json_encode($data);
       
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish teacher from trash
      * @param $teacher_id integer
      */
     public function publish($teacher_id){
        
        $teacher_id = (int) $teacher_id;
		$this->teacher_model->changeStatus($teacher_id, "1");
		$data["msg_success"] = $this->lang->line("publish_msg_success");
        echo json_encode($data);
        
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Teacher
      * @param $teacher_id integer
      */
     public function delete($teacher_id, $page_id = NULL){
        
        $teacher_id = (int) $teacher_id;
        //$this->teacher_model->changeStatus($teacher_id, "3");
        $this->teacher_model->delete(array( 'teacher_id' => $teacher_id));
		$data["msg_success"] = $this->lang->line("delete_msg_success");
        echo json_encode($data);
     }
     //----------------------------------------------------
    public function save_data(){
	
	$teacher_id = $this->teacher_model->save_data();
	$data["msg_success"] = $this->lang->line("add_msg_success");
    echo json_encode($data);
	
	 }


    
	 public function update_data($teacher_id){
		$teacher_id = $this->teacher_model->update_data($teacher_id);
		$data["msg_success"] = $this->lang->line("update_msg_success");
    	echo json_encode($data);
		
		 
		 }
	 
     
}        
