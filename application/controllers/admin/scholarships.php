<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Scholarships extends Admin_Controller{
    
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
		
        $where = "`scholarships`.`status` IN (0, 1) ";
		$data = $this->scholarship_model->get_scholarship_list($where);
		 $this->data["scholarships"] = $data->scholarships;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Scholarships');
		$this->data["view"] = ADMIN_DIR."scholarships/scholarships";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_scholarship($scholarship_id){
        
        $scholarship_id = (int) $scholarship_id;
        
        $this->data["scholarships"] = $this->scholarship_model->get_scholarship($scholarship_id);
        $this->data["title"] = $this->lang->line('Scholarship Details');
		$this->data["view"] = ADMIN_DIR."scholarships/view_scholarship";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`scholarships`.`status` IN (2) ";
		$data = $this->scholarship_model->get_scholarship_list($where);
		 $this->data["scholarships"] = $data->scholarships;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Scholarships');
		$this->data["view"] = ADMIN_DIR."scholarships/trashed_scholarships";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($scholarship_id, $page_id = NULL){
        
        $scholarship_id = (int) $scholarship_id;
        
        
        $this->scholarship_model->changeStatus($scholarship_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."scholarships/view/".$page_id);
    }
    
    /**
      * function to restor scholarship from trash
      * @param $scholarship_id integer
      */
     public function restore($scholarship_id, $page_id = NULL){
        
        $scholarship_id = (int) $scholarship_id;
        
        
        $this->scholarship_model->changeStatus($scholarship_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."scholarships/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft scholarship from trash
      * @param $scholarship_id integer
      */
     public function draft($scholarship_id, $page_id = NULL){
        
        $scholarship_id = (int) $scholarship_id;
        
        
        $this->scholarship_model->changeStatus($scholarship_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."scholarships/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish scholarship from trash
      * @param $scholarship_id integer
      */
     public function publish($scholarship_id, $page_id = NULL){
        
        $scholarship_id = (int) $scholarship_id;
        
        
        $this->scholarship_model->changeStatus($scholarship_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."scholarships/view/".$page_id);
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
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."scholarships/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Scholarship
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Scholarship');$this->data["view"] = ADMIN_DIR."scholarships/add_scholarship";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->scholarship_model->validate_form_data() === TRUE){
		  
		  $scholarship_id = $this->scholarship_model->save_data();
          if($scholarship_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."scholarships/edit/$scholarship_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."scholarships/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Scholarship
      */
     public function edit($scholarship_id){
		 $scholarship_id = (int) $scholarship_id;
        $this->data["scholarship"] = $this->scholarship_model->get($scholarship_id);
		  
        $this->data["title"] = $this->lang->line('Edit Scholarship');$this->data["view"] = ADMIN_DIR."scholarships/edit_scholarship";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($scholarship_id){
		 
		 $scholarship_id = (int) $scholarship_id;
       
	   if($this->scholarship_model->validate_form_data() === TRUE){
		  
		  $scholarship_id = $this->scholarship_model->update_data($scholarship_id);
          if($scholarship_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."scholarships/edit/$scholarship_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."scholarships/edit/$scholarship_id");
            }
        }else{
			$this->edit($scholarship_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["scholarships"] = $this->scholarship_model->getBy($where, false, "scholarship_id" );
				$j_array[]=array("id" => "", "value" => "scholarship");
				foreach($data["scholarships"] as $scholarship ){
					$j_array[]=array("id" => $scholarship->scholarship_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
