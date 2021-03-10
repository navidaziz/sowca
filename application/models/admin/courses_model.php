<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Courses_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "courses";
        $this->pk = "course_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "class",
                            "label"  =>  "Class",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "course_name",
                            "label"  =>  "Course Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "course_detail",
                            "label"  =>  "Course Detail",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "course_fee",
                            "label"  =>  "Course Fee",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "is_subject",
                            "label"  =>  "Is Subject",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["class"]  =  $this->input->post("class");
                    
                    $inputs["course_name"]  =  $this->input->post("course_name");
                    
                    $inputs["course_detail"]  =  $this->input->post("course_detail");
                    
                    $inputs["course_fee"]  =  $this->input->post("course_fee");
                    
                    $inputs["is_subject"]  =  $this->input->post("is_subject");
                    
	return $this->courses_model->save($inputs);
	}	 	

public function update_data($course_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["class"]  =  $this->input->post("class");
                    
                    $inputs["course_name"]  =  $this->input->post("course_name");
                    
                    $inputs["course_detail"]  =  $this->input->post("course_detail");
                    
                    $inputs["course_fee"]  =  $this->input->post("course_fee");
                    
                    $inputs["is_subject"]  =  $this->input->post("is_subject");
                    
	return $this->courses_model->save($inputs, $course_id);
	}	
	
    //----------------------------------------------------------------
 public function get_courses_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("courses.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->courses_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->courses_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->courses_model->joinGet($fields, "courses", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->courses = $this->courses_model->joinGet($fields, "courses", $join_table, $where);
			return $data;
		}else{
			return $this->courses_model->joinGet($fields, "courses", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_courses($course_id){
	
		$fields = array("courses.*");
		$join_table = array();
		$where = "courses.course_id = $course_id";
		
		return $this->courses_model->joinGet($fields, "courses", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

