<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Teachers extends Admin_Controller{
    
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
        $main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/view";
  		redirect($main_page); 
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`teachers`.`status` IN (0, 1) ";
		$data = $this->teacher_model->get_teacher_list($where);
		 $this->data["teachers"] = $data->teachers;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Teachers');
		$this->data["view"] = ADMIN_DIR."teachers/teachers";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_teacher($teacher_id){
        
        $teacher_id = (int) $teacher_id;
        
        $this->data["teachers"] = $this->teacher_model->get_teacher($teacher_id);
        $this->data["title"] = $this->lang->line('Teacher Details');
		$this->data["view"] = ADMIN_DIR."teachers/view_teacher";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`teachers`.`status` IN (2) ";
		$data = $this->teacher_model->get_teacher_list($where);
		 $this->data["teachers"] = $data->teachers;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Teachers');
		$this->data["view"] = ADMIN_DIR."teachers/trashed_teachers";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($teacher_id, $page_id = NULL){
        
        $teacher_id = (int) $teacher_id;
        
        
        $this->teacher_model->changeStatus($teacher_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."teachers/view/".$page_id);
    }
    
    /**
      * function to restor teacher from trash
      * @param $teacher_id integer
      */
     public function restore($teacher_id, $page_id = NULL){
        
        $teacher_id = (int) $teacher_id;
        
        
        $this->teacher_model->changeStatus($teacher_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."teachers/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft teacher from trash
      * @param $teacher_id integer
      */
     public function draft($teacher_id, $page_id = NULL){
        
        $teacher_id = (int) $teacher_id;
        
        
        $this->teacher_model->changeStatus($teacher_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."teachers/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish teacher from trash
      * @param $teacher_id integer
      */
     public function publish($teacher_id, $page_id = NULL){
        
        $teacher_id = (int) $teacher_id;
        
        
        $this->teacher_model->changeStatus($teacher_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."teachers/view/".$page_id);
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
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."teachers/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Teacher
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Teacher');$this->data["view"] = ADMIN_DIR."teachers/add_teacher";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->teacher_model->validate_form_data() === TRUE){
		  
		  $teacher_id = $this->teacher_model->save_data();
          if($teacher_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."teachers/edit/$teacher_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."teachers/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Teacher
      */
     public function edit($teacher_id){
		 $teacher_id = (int) $teacher_id;
        $this->data["teacher"] = $this->teacher_model->get($teacher_id);
		  
        $this->data["title"] = $this->lang->line('Edit Teacher');$this->data["view"] = ADMIN_DIR."teachers/edit_teacher";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($teacher_id){
		 
		 $teacher_id = (int) $teacher_id;
       
	   if($this->teacher_model->validate_form_data() === TRUE){
		  
		  $teacher_id = $this->teacher_model->update_data($teacher_id);
          if($teacher_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."teachers/edit/$teacher_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."teachers/edit/$teacher_id");
            }
        }else{
			$this->edit($teacher_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["teachers"] = $this->teacher_model->getBy($where, false, "teacher_id" );
				$j_array[]=array("id" => "", "value" => "teacher");
				foreach($data["teachers"] as $teacher ){
					$j_array[]=array("id" => $teacher->teacher_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
