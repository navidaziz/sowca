<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Student_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "students";
        $this->pk = "student_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "student_name",
                            "label"  =>  "Student Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "father_name",
                            "label"  =>  "Father Name",
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
                            "field"  =>  "class",
                            "label"  =>  "Class",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "institute",
                            "label"  =>  "Institute",
                            "rules"  =>  "required"
                        ),
                       /* 
                        array(
                            "field"  =>  "on_scholarship",
                            "label"  =>  "On Scholarship",
                            "rules"  =>  "required"
                        ),
                        */
                        
                        array(
                            "field"  =>  "scholarship_id",
                            "label"  =>  "Scholarship Id",
                            "rules"  =>  "required"
                        ),
                        
                       /* array(
                            "field"  =>  "scholarship_value",
                            "label"  =>  "Scholarship Value",
                            "rules"  =>  "required"
                        ),
                        */
                        
                        array(
                            "field"  =>  "transport",
                            "label"  =>  "Transport",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["student_name"]  =  $this->input->post("student_name");
                    
                    $inputs["father_name"]  =  $this->input->post("father_name");
                    
                    $inputs["gender"]  =  $this->input->post("gender");
                    
                    $inputs["address"]  =  $this->input->post("address");
                    
                    $inputs["mobile_no"]  =  $this->input->post("mobile_no");
                    
                    $inputs["phone_no"]  =  $this->input->post("phone_no");
                    
                    $inputs["class"]  =  $this->input->post("class");
                    
                    $inputs["institute"]  =  $this->input->post("institute");
                    
                   
                    if($this->input->post("scholarship_id") != 1){
                        $inputs["scholarship_id"]  =  $this->input->post("scholarship_id");
                        $inputs["on_scholarship"]  = "Yes";
                        $inputs["scholarship_value"]  =  NULL;
                    
                    }else{
                        $inputs["scholarship_id"]  =  1;
                        $inputs["scholarship_value"]  =  "";
                        $inputs["on_scholarship"]  = "No";
                    }
                    
                    $inputs["transport"]  =  $this->input->post("transport");
                    
	return $this->student_model->save($inputs);
	}	 	

public function update_data($student_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["student_name"]  =  $this->input->post("student_name");
                    
                    $inputs["father_name"]  =  $this->input->post("father_name");
                    
                    $inputs["gender"]  =  $this->input->post("gender");
                    
                    $inputs["address"]  =  $this->input->post("address");
                    
                    $inputs["mobile_no"]  =  $this->input->post("mobile_no");
                    
                    $inputs["phone_no"]  =  $this->input->post("phone_no");
                    
                    $inputs["class"]  =  $this->input->post("class");
                    
                    $inputs["institute"]  =  $this->input->post("institute");
                    
                    $inputs["on_scholarship"]  =  $this->input->post("on_scholarship");
                    
                    $inputs["scholarship_id"]  =  $this->input->post("scholarship_id");
                    
                    if($inputs["on_scholarship"]=='yes'){
                        $inputs["scholarship_id"]  =  $this->input->post("scholarship_id");
                        $inputs["scholarship_value"]  =  NULL;
                    
                    }else{
                        $inputs["scholarship_id"]  =  NULL;
                        $inputs["scholarship_value"]  =  "";
                    }
                    
                    $inputs["transport"]  =  $this->input->post("transport");
                    
	return $this->student_model->save($inputs, $student_id);
	}	
	
    //----------------------------------------------------------------
 public function get_student_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("students.*"
                , "scholarships.scholarship_name"
            );
		$join_table = array(
            "scholarships" => "scholarships.scholarship_id = students.scholarship_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->student_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->student_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->student_model->joinGet($fields, "students", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->students = $this->student_model->joinGet($fields, "students", $join_table, $where);
			return $data;
		}else{
			return $this->student_model->joinGet($fields, "students", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_student($student_id){
	
		$fields = array("students.*"
                , "scholarships.scholarship_name"
            );
		$join_table = array(
            "scholarships" => "scholarships.scholarship_id = students.scholarship_id",
        );
		$where = "students.student_id = $student_id";
		
		return $this->student_model->joinGet($fields, "students", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

