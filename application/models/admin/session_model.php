<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Session_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "sessions";
        $this->pk = "session_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "session_name",
                            "label"  =>  "Session Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "session_detail",
                            "label"  =>  "Session Detail",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "start_date",
                            "label"  =>  "Start Date",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "end_date",
                            "label"  =>  "End Date",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["session_name"]  =  $this->input->post("session_name");
                    
                    $inputs["session_detail"]  =  $this->input->post("session_detail");
                    
                    $inputs["start_date"]  =  $this->input->post("start_date");
                    
                    $inputs["end_date"]  =  $this->input->post("end_date");
                    
	return $this->session_model->save($inputs);
	}	 	

public function update_data($session_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["session_name"]  =  $this->input->post("session_name");
                    
                    $inputs["session_detail"]  =  $this->input->post("session_detail");
                    
                    $inputs["start_date"]  =  $this->input->post("start_date");
                    
                    $inputs["end_date"]  =  $this->input->post("end_date");
                    
	return $this->session_model->save($inputs, $session_id);
	}	
	
    //----------------------------------------------------------------
 public function get_session_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("sessions.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->session_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->session_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->session_model->joinGet($fields, "sessions", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->sessions = $this->session_model->joinGet($fields, "sessions", $join_table, $where);
			return $data;
		}else{
			return $this->session_model->joinGet($fields, "sessions", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_session($session_id){
	
		$fields = array("sessions.*");
		$join_table = array();
		$where = "sessions.session_id = $session_id";
		
		return $this->session_model->joinGet($fields, "sessions", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

