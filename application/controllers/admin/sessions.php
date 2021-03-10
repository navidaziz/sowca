<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Sessions extends Admin_Controller{
    
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
        $main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/view";
  		redirect($main_page); 
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`sessions`.`status` IN (0, 1) ";
		$data = $this->session_model->get_session_list($where);
		 $this->data["sessions"] = $data->sessions;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Sessions');
		$this->data["view"] = ADMIN_DIR."sessions/sessions";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_session($session_id){
        
        $session_id = (int) $session_id;

        $query="SELECT `class` FROM `courses` GROUP BY `class` ORDER BY class ASC";
        $courses_classes = $this->db->query($query)->result();
        foreach($courses_classes as $courses_class){
            $query="SELECT * FROM `courses` WHERE `class` = '".$courses_class->class."'
            AND course_id NOT IN (SELECT course_id FROM session_courses where session_id = '".$session_id."')
            ";
            $courses_class->courses = $this->db->query($query)->result();
        }
        $this->data["courses_classes"] = $courses_classes;



        $query = "SELECT `courses`.`class` 
        FROM `sessions`,
            `session_courses`,
            `courses`
        WHERE `sessions`.`session_id` = `session_courses`.`session_id`
        AND `courses`.`course_id` = `session_courses`.`course_id`
        AND `sessions`.`session_id`='".$session_id."'
        GROUP BY `courses`.`class`
        ORDER BY `courses`.`class` ASC";
        $classes = $this->db->query($query)->result();
       
        $session_courses = array();
        foreach($classes as $class){
            $query = "SELECT
            `session_courses`.`session_course_id`
            , `sessions`.`session_name`
            , `sessions`.`session_id`
            , `courses`.`course_name`
            , `courses`.`class`
            , `session_courses`.`teacher_id`
            , `session_courses`.`course_fee`
            , `session_courses`.`monthly_installment`
            , `session_courses`.`contract_percentage`
            ,  `courses`.`is_subject`
            
            FROM `sessions`,
                `session_courses`,
                `courses`
            WHERE `sessions`.`session_id` = `session_courses`.`session_id`
            AND `courses`.`course_id` = `session_courses`.`course_id`
            AND `sessions`.`session_id`='".$session_id."'
            AND `courses`.`class` = '".$class->class."'";
                        
            $session_courses[$class->class]["session_courses"] = $this->db->query($query)->result();

        }

        $this->data['session_courses'] = $session_courses;



        
        $this->data["sessions"] = $this->session_model->get_session($session_id);
        $this->data["title"] = $this->lang->line('Session Details');
		$this->data["view"] = ADMIN_DIR."sessions/view_session";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`sessions`.`status` IN (2) ";
		$data = $this->session_model->get_session_list($where);
		 $this->data["sessions"] = $data->sessions;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Sessions');
		$this->data["view"] = ADMIN_DIR."sessions/trashed_sessions";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($session_id, $page_id = NULL){
        
        $session_id = (int) $session_id;
        
        
        $this->session_model->changeStatus($session_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."sessions/view/".$page_id);
    }
    
    /**
      * function to restor session from trash
      * @param $session_id integer
      */
     public function restore($session_id, $page_id = NULL){
        
        $session_id = (int) $session_id;
        
        
        $this->session_model->changeStatus($session_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."sessions/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft session from trash
      * @param $session_id integer
      */
     public function draft($session_id, $page_id = NULL){
        
        $session_id = (int) $session_id;
        
        
        $this->session_model->changeStatus($session_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."sessions/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish session from trash
      * @param $session_id integer
      */
     public function publish($session_id, $page_id = NULL){
        
        $session_id = (int) $session_id;

        $query="UPDATE `sessions` SET `status`=0 WHERE session_id != '".$session_id."' ";
        $this->db->query($query);
        $query="UPDATE `sessions` SET `status`=1 WHERE session_id = '".$session_id."' ";
        $this->db->query($query);
        
        //$this->session_model->changeStatus($session_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."sessions/view/".$page_id);
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
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."sessions/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Session
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Session');$this->data["view"] = ADMIN_DIR."sessions/add_session";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->session_model->validate_form_data() === TRUE){
		  
		  $session_id = $this->session_model->save_data();
          if($session_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."sessions/edit/$session_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."sessions/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Session
      */
     public function edit($session_id){
		 $session_id = (int) $session_id;
        $this->data["session"] = $this->session_model->get($session_id);
		  
        $this->data["title"] = $this->lang->line('Edit Session');$this->data["view"] = ADMIN_DIR."sessions/edit_session";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($session_id){
		 
		 $session_id = (int) $session_id;
       
	   if($this->session_model->validate_form_data() === TRUE){
		  
		  $session_id = $this->session_model->update_data($session_id);
          if($session_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."sessions/edit/$session_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."sessions/edit/$session_id");
            }
        }else{
			$this->edit($session_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["sessions"] = $this->session_model->getBy($where, false, "session_id" );
				$j_array[]=array("id" => "", "value" => "session");
				foreach($data["sessions"] as $session ){
					$j_array[]=array("id" => $session->session_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------

    public function add_session_courses(){
        $session_id = (int) $this->input->post("session_id");
        $course_id = (int) $this->input->post("course_id");
        $course_fee = (int) $this->input->post("course_fee");
        $monthly_installment = (int) $this->input->post("monthly_installment");
        if($this->input->post("teacher_id")){
            $teacher_id = (int) $this->input->post("teacher_id");
            $contract_percentage = (int) $this->input->post("contract_percentage");
        }else{
            $teacher_id = 0;
            $contract_percentage = 0; 
        }

        $query = "SELECT count(*) as total from session_courses 
                  WHERE session_id = '".$session_id."' 
                  AND  course_id = '".$course_id."'";
        if($this->db->query($query)->result()->total==0){
            $query="INSERT INTO `session_courses`(`session_id`, `course_id`, `course_fee`, `monthly_installment`, `teacher_id`, `contract_percentage`) 
            VALUES ('".$session_id."','".$course_id."','".$course_fee."','".$monthly_installment."','".$teacher_id."','".$contract_percentage."')";
            $this->db->query($query);
            $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
            redirect(ADMIN_DIR."sessions/view_session/$session_id");
        }else{
            $this->session->set_flashdata("msg_success", "Course Already Assigned.");
            redirect(ADMIN_DIR."sessions/view_session/$session_id");

        }
       
        
        

       
    }


    public function remove_session_course($session_course_id, $session_id){
        $session_course_id = (int) $session_course_id;
        if($this->db->query("DELETE FROM `session_courses` WHERE `session_course_id` = '".$session_course_id."'")){
            $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
            redirect(ADMIN_DIR."sessions/view_session/$session_id");
        }else{
            $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
            redirect(ADMIN_DIR."sessions/edit/$session_id");

        }    
    }
    
}        
