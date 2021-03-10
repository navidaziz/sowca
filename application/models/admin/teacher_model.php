<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Teacher_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "teachers";
        $this->pk = "teacher_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "teacher_name",
                            "label"  =>  "Teacher Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "gender",
                            "label"  =>  "Gender",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "address",
                            "label"  =>  "Address",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "mobile_no",
                            "label"  =>  "Mobile No",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "phone_no",
                            "label"  =>  "Phone No",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "last_qualification",
                            "label"  =>  "Last Qualification",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "last_qualification_in_subject",
                            "label"  =>  "Last Qualification In Subject",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["teacher_name"]  =  $this->input->post("teacher_name");
                    
                    $inputs["gender"]  =  $this->input->post("gender");
                    
                    $inputs["address"]  =  $this->input->post("address");
                    
                    $inputs["mobile_no"]  =  $this->input->post("mobile_no");
                    
                    $inputs["phone_no"]  =  $this->input->post("phone_no");
                    
                    $inputs["last_qualification"]  =  $this->input->post("last_qualification");
                    
                    $inputs["last_qualification_in_subject"]  =  $this->input->post("last_qualification_in_subject");
                    
	return $this->teacher_model->save($inputs);
	}	 	

public function update_data($teacher_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["teacher_name"]  =  $this->input->post("teacher_name");
                    
                    $inputs["gender"]  =  $this->input->post("gender");
                    
                    $inputs["address"]  =  $this->input->post("address");
                    
                    $inputs["mobile_no"]  =  $this->input->post("mobile_no");
                    
                    $inputs["phone_no"]  =  $this->input->post("phone_no");
                    
                    $inputs["last_qualification"]  =  $this->input->post("last_qualification");
                    
                    $inputs["last_qualification_in_subject"]  =  $this->input->post("last_qualification_in_subject");
                    
	return $this->teacher_model->save($inputs, $teacher_id);
	}	
	
    //----------------------------------------------------------------
 public function get_teacher_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("teachers.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->teacher_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->teacher_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->teacher_model->joinGet($fields, "teachers", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->teachers = $this->teacher_model->joinGet($fields, "teachers", $join_table, $where);
			return $data;
		}else{
			return $this->teacher_model->joinGet($fields, "teachers", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_teacher($teacher_id){
	
		$fields = array("teachers.*");
		$join_table = array();
		$where = "teachers.teacher_id = $teacher_id";
		
		return $this->teacher_model->joinGet($fields, "teachers", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

