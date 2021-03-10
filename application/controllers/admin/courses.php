<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Courses extends Admin_Controller{
    
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
        $main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/view";
  		redirect($main_page); 
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`courses`.`status` IN (0, 1) ";
        $this->data["courses"] = $this->courses_model->get_courses_list($where,false);
		//$data = $this->courses_model->get_courses_list($where,true);
		 //$this->data["courses"] = $data->courses;
         //$this->data["pagination"] = $data->pagination;
         $this->data["pagination"] = "";
		 $this->data["title"] = $this->lang->line('Courses');
		$this->data["view"] = ADMIN_DIR."courses/courses";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_courses($course_id){
        
        $course_id = (int) $course_id;
        
        $this->data["courses"] = $this->courses_model->get_courses($course_id);
        $this->data["title"] = $this->lang->line('Courses Details');
		$this->data["view"] = ADMIN_DIR."courses/view_courses";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`courses`.`status` IN (2) ";
		$data = $this->courses_model->get_courses_list($where);
		 $this->data["courses"] = $data->courses;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Courses');
		$this->data["view"] = ADMIN_DIR."courses/trashed_courses";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($course_id, $page_id = NULL){
        
        $course_id = (int) $course_id;
        
        
        $this->courses_model->changeStatus($course_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."courses/view/".$page_id);
    }
    
    /**
      * function to restor courses from trash
      * @param $course_id integer
      */
     public function restore($course_id, $page_id = NULL){
        
        $course_id = (int) $course_id;
        
        
        $this->courses_model->changeStatus($course_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."courses/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft courses from trash
      * @param $course_id integer
      */
     public function draft($course_id, $page_id = NULL){
        
        $course_id = (int) $course_id;
        
        
        $this->courses_model->changeStatus($course_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."courses/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish courses from trash
      * @param $course_id integer
      */
     public function publish($course_id, $page_id = NULL){
        
        $course_id = (int) $course_id;
        
        
        $this->courses_model->changeStatus($course_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."courses/view/".$page_id);
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
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."courses/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Courses
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Courses');$this->data["view"] = ADMIN_DIR."courses/add_courses";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->courses_model->validate_form_data() === TRUE){
		  
		  $course_id = $this->courses_model->save_data();
          if($course_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."courses/edit/$course_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."courses/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Courses
      */
     public function edit($course_id){
		 $course_id = (int) $course_id;
        $this->data["courses"] = $this->courses_model->get($course_id);
		  
        $this->data["title"] = $this->lang->line('Edit Courses');$this->data["view"] = ADMIN_DIR."courses/edit_courses";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($course_id){
		 
		 $course_id = (int) $course_id;
       
	   if($this->courses_model->validate_form_data() === TRUE){
		  
		  $course_id = $this->courses_model->update_data($course_id);
          if($course_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."courses/edit/$course_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."courses/edit/$course_id");
            }
        }else{
			$this->edit($course_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["courses"] = $this->courses_model->getBy($where, false, "course_id" );
				$j_array[]=array("id" => "", "value" => "courses");
				foreach($data["courses"] as $courses ){
					$j_array[]=array("id" => $courses->course_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
