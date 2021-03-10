<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Students extends Admin_Controller_Mobile{
    
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
    


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`students`.`status` IN (0, 1) ";
		$data = $this->student_model->get_student_list($where, false);
		 echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_student($student_id){
        
        $student_id = (int) $student_id;
		$data = $this->student_model->get_student($student_id);
        echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`students`.`status` IN (2) ";
		$data = $this->student_model->get_student_list($where, true);
		 echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($student_id){
        
        $student_id = (int) $student_id;
		$this->student_model->changeStatus($student_id, "2");
        $data["msg_success"] = $this->lang->line("trash_msg_success");
        echo json_encode($data);
    }
    
    /**
      * function to restor student from trash
      * @param $student_id integer
      */
     public function restore($student_id){
        
        $student_id = (int) $student_id;
		$this->student_model->changeStatus($student_id, "1");
		$data["msg_success"] = $this->lang->line("restore_msg_success");
        echo json_encode($data);
        
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft student from trash
      * @param $student_id integer
      */
     public function draft($student_id){
        
        $student_id = (int) $student_id;
		$this->student_model->changeStatus($student_id, "0");
		$data["msg_success"] = $this->lang->line("draft_msg_success");
        echo json_encode($data);
       
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish student from trash
      * @param $student_id integer
      */
     public function publish($student_id){
        
        $student_id = (int) $student_id;
		$this->student_model->changeStatus($student_id, "1");
		$data["msg_success"] = $this->lang->line("publish_msg_success");
        echo json_encode($data);
        
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Student
      * @param $student_id integer
      */
     public function delete($student_id, $page_id = NULL){
        
        $student_id = (int) $student_id;
        //$this->student_model->changeStatus($student_id, "3");
        $this->student_model->delete(array( 'student_id' => $student_id));
		$data["msg_success"] = $this->lang->line("delete_msg_success");
        echo json_encode($data);
     }
     //----------------------------------------------------
    public function save_data(){
	
	$student_id = $this->student_model->save_data();
	$data["msg_success"] = $this->lang->line("add_msg_success");
    echo json_encode($data);
	
	 }


    
	 public function update_data($student_id){
		$student_id = $this->student_model->update_data($student_id);
		$data["msg_success"] = $this->lang->line("update_msg_success");
    	echo json_encode($data);
		
		 
		 }
	 
     
}        
