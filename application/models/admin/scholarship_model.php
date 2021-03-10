<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Scholarship_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "scholarships";
        $this->pk = "scholarship_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "scholarship_name",
                            "label"  =>  "Scholarship Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "scholarship_detail",
                            "label"  =>  "Scholarship Detail",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "scholarship_value",
                            "label"  =>  "Scholarship Value",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["scholarship_name"]  =  $this->input->post("scholarship_name");
                    
                    $inputs["scholarship_detail"]  =  $this->input->post("scholarship_detail");
                    
                    $inputs["scholarship_value"]  =  $this->input->post("scholarship_value");
                    
	return $this->scholarship_model->save($inputs);
	}	 	

public function update_data($scholarship_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["scholarship_name"]  =  $this->input->post("scholarship_name");
                    
                    $inputs["scholarship_detail"]  =  $this->input->post("scholarship_detail");
                    
                    $inputs["scholarship_value"]  =  $this->input->post("scholarship_value");
                    
	return $this->scholarship_model->save($inputs, $scholarship_id);
	}	
	
    //----------------------------------------------------------------
 public function get_scholarship_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("scholarships.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->scholarship_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->scholarship_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->scholarship_model->joinGet($fields, "scholarships", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->scholarships = $this->scholarship_model->joinGet($fields, "scholarships", $join_table, $where);
			return $data;
		}else{
			return $this->scholarship_model->joinGet($fields, "scholarships", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_scholarship($scholarship_id){
	
		$fields = array("scholarships.*");
		$join_table = array();
		$where = "scholarships.scholarship_id = $scholarship_id";
		
		return $this->scholarship_model->joinGet($fields, "scholarships", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

