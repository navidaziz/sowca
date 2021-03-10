<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Courses extends Admin_Controller_Mobile{
    
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
    


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`courses`.`status` IN (0, 1) ";
		$data = $this->courses_model->get_courses_list($where, false);
		 echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_courses($course_id){
        
        $course_id = (int) $course_id;
		$data = $this->courses_model->get_courses($course_id);
        echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`courses`.`status` IN (2) ";
		$data = $this->courses_model->get_courses_list($where, true);
		 echo json_encode($data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($course_id){
        
        $course_id = (int) $course_id;
		$this->courses_model->changeStatus($course_id, "2");
        $data["msg_success"] = $this->lang->line("trash_msg_success");
        echo json_encode($data);
    }
    
    /**
      * function to restor courses from trash
      * @param $course_id integer
      */
     public function restore($course_id){
        
        $course_id = (int) $course_id;
		$this->courses_model->changeStatus($course_id, "1");
		$data["msg_success"] = $this->lang->line("restore_msg_success");
        echo json_encode($data);
        
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft courses from trash
      * @param $course_id integer
      */
     public function draft($course_id){
        
        $course_id = (int) $course_id;
		$this->courses_model->changeStatus($course_id, "0");
		$data["msg_success"] = $this->lang->line("draft_msg_success");
        echo json_encode($data);
       
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish courses from trash
      * @param $course_id integer
      */
     public function publish($course_id){
        
        $course_id = (int) $course_id;
		$this->courses_model->changeStatus($course_id, "1");
		$data["msg_success"] = $this->lang->line("publish_msg_success");
        echo json_encode($data);
        
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Courses
      * @param $course_id integer
      */
     public function delete($course_id, $page_id = NULL){
        
        $course_id = (int) $course_id;
        //$this->courses_model->changeStatus($course_id, "3");
        $this->courses_model->delete(array( 'course_id' => $course_id));
		$data["msg_success"] = $this->lang->line("delete_msg_success");
        echo json_encode($data);
     }
     //----------------------------------------------------
    public function save_data(){
	
	$course_id = $this->courses_model->save_data();
	$data["msg_success"] = $this->lang->line("add_msg_success");
    echo json_encode($data);
	
	 }


    
	 public function update_data($course_id){
		$course_id = $this->courses_model->update_data($course_id);
		$data["msg_success"] = $this->lang->line("update_msg_success");
    	echo json_encode($data);
		
		 
		 }
	 
     
}        
