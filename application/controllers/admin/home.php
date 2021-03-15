<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Home extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/session_model");
        $this->load->model("admin/courses_model");
        $this->load->model("admin/teacher_model");
        $this->load->model("admin/student_model");
        
        
        $this->lang->load("courses", 'english');
		$this->lang->load("sessions", 'english');
        $this->lang->load("system", 'english');
        $this->lang->load("students", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){

        $this->data["scholarships"] = $this->student_model->getList("scholarships", "scholarship_id", "scholarship_name", $where ="`scholarships`.`status` IN (1) ");
        $query = "SELECT * FROM `sessions` WHERE `sessions`.`status` = '1'";
        $this->data['session'] = $session = $this->db->query($query)->result()[0];
        $this->data['session_id'] =  $session->session_id;
        $query = "SELECT
            `students`.`student_id`,
            `students`.`student_name`
            , `students`.`father_name`
            , `students`.`gender`
            , `students`.`mobile_no`
            , `students`.`class`
            , `students`.`on_scholarship`
            , `students`.`transport`
            , `session_students`.`status` as admission_confirmed
        FROM `session_students`,
            `students` 
        WHERE `session_students`.`student_id` = `students`.`student_id`
        AND `session_id` = $session->session_id;";

        $students = $this->db->query($query)->result();
        $this->data['students'] = $students;
        $this->data["title"] = "Main Dashboard";
		$this->data["view"] = ADMIN_DIR."home/index";
		$this->load->view(ADMIN_DIR."layout", $this->data); 
    }
    //---------------------------------------------------------------

    public function search_student_by_name(){
        $student_name = "%".$this->input->post("student_name")."%";
        $student_name = $this->db->escape($student_name);
        $sql = "Select * from students WHERE student_name like $student_name LIMIT 10";
        $students_list  = $this->db->query($sql)->result();
        $query = "SELECT `session_id` FROM `sessions` WHERE `sessions`.`status` = '1'";
        $session_id = $this->db->query($query)->result()[0]->session_id;
        echo "<hr />";
        if(count($students_list)>0){
            echo '<ul class="list-group list-group-flush">';
                
            foreach($students_list as $student){

                 echo '<li class="list-group-item">'.ucwords($student->student_name).' S/D of 
                 '.ucwords($student->father_name);
                $student_id = $students_list[0]->student_id;
                $query="SELECT COUNT(*) AS `total` FROM `session_students` 
                        WHERE `session_id` ='".$session_id."'
                        AND `student_id` = '".$student_id."' ";
                if($this->db->query($query)->result()[0]->total>0){
                    echo '<br /> <strong>Admitted</strong>';
                }else{
                    
                    echo '<p style="text-align:center"><button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#admission_form" 
                  onclick="get_adminssion_form(\''.$student->student_id.'\')">
                 Add to this session</button></p>';
                }        
                

                echo '</li>';

            }
            echo '<li class="list-group-item"><p style="text-align:center">
            <button type="button" onclick="$(\'#student_name\').val(\''.ucwords($this->input->post("student_name")).'\')" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#add_new_student_form">Add New Student</button>
            </p></li>';
            echo '</ul>';
        }else{
            echo '<ul class="list-group list-group-flush">';
            echo '<li class="list-group-item">';
            echo 'Student Not Found. Search again or add student as new.<br />
            <p style="text-align:center">
            <button type="button" onclick="$(\'#student_name\').val(\''.ucwords($this->input->post("student_name")).'\')" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#add_new_student_form">Add New Student</button>
            </p>';
            echo '</li>';
            echo '</ul>';
        }
        
    }

    public function save_student_data(){
        if($this->student_model->validate_form_data() === TRUE){
		  
            $student_id = $this->student_model->save_data();
            if($student_id){
                  $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                  redirect(ADMIN_DIR."home");
              }else{
                  
                  $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                  redirect(ADMIN_DIR."home");
              }
          }else{
               $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
               redirect(ADMIN_DIR."home");
              }
    }

    public function get_admission_form(){
        $student_id = (int) $this->input->post('student_id');
        $this->data["students"] = $this->student_model->get_student($student_id);

        $query = "SELECT `session_id` FROM `sessions` WHERE `sessions`.`status` = '1'";
        $session_id = $this->db->query($query)->result()[0]->session_id;
       
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
            , `courses`.`course_name`
            , `courses`.`class`
            , `session_courses`.`teacher_id`
            , `session_courses`.`course_fee`
            , `session_courses`.`monthly_installment`
            , `session_courses`.`contract_percentage`
            
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
       
        $this->load->view(ADMIN_DIR."home/admission_form", $this->data);
    }
   
public function admit_student(){
    $session_courses_ids = $this->input->post('session_course_id');
    $student_id = $this->input->post('student_id');
    $query = "SELECT `session_id` FROM `sessions` WHERE `sessions`.`status` = '1'";
    $current_session_id = $this->db->query($query)->result()[0]->session_id;

    $query="SELECT COUNT(*) as total FROM `session_students`  WHERE `student_id` = '".$student_id."' AND `session_id` = '".$current_session_id."'";
    if($this->db->query($query)->result()[0]->total==0){

        
       
        //admit the student into this session 
        $query="INSERT INTO `session_students`(`session_id`, `student_id`) VALUES ('".$current_session_id."','".$student_id."')";
        if($this->db->query($query)){
            $session_student_id = $this->db->insert_id();
            foreach($session_courses_ids as $session_courses_id){
                //get current session course detail ....
                
                $query = "SELECT * FROM session_courses WHERE `session_course_id` = '".$session_courses_id."'";
                $session_course = $this->db->query($query)->result()[0];
                for($installment=1; $installment<=$session_course->monthly_installment; $installment++){
                    if($session_course->course_id==25){
                        $transport_fee= (int) $this->input->post("transport_fee");
                    $query="INSERT INTO `session_student_fees`(`session_student_id`, `session_id`, `student_id`, `course_id`, `course_installment_no`, `course_fee_total`, `teacher_id`) 
                            VALUES ('".$session_student_id."','".$current_session_id."','".$student_id."','".$session_course->course_id."','".$installment."','".$transport_fee."' ,'".$session_course->teacher_id."')";
                    $this->db->query($query);
                    }else{
                        $query="INSERT INTO `session_student_fees`(`session_student_id`, `session_id`, `student_id`, `course_id`, `course_installment_no`, `course_fee_total`, `teacher_id`) 
                            VALUES ('".$session_student_id."','".$current_session_id."','".$student_id."','".$session_course->course_id."','".$installment."','".$session_course->course_fee."' ,'".$session_course->teacher_id."')";
                    $this->db->query($query);

                    }
                }

            
            }
        }

       

        $this->session->set_flashdata("msg_success", "Student Admit successfully");
        redirect(ADMIN_DIR."home");

    }else{
        $this->session->set_flashdata("msg_success", "Sorry we can't add this student is already admitted");
        redirect(ADMIN_DIR."home");
    }

    
    
}



public function get_installment_payment_form(){
    $student_id = (int) $this->input->post('student_id');
    $query = "SELECT `session_id` FROM `sessions` WHERE `sessions`.`status` = '1'";
    $session_id = $this->db->query($query)->result()[0]->session_id;
    $this->data["students"] = $this->student_model->get_student($student_id);

    $query="SELECT `course_installment_no` 
            FROM `session_student_fees` 
            WHERE `student_id` = '".$student_id."' 
            AND `session_id` = '".$session_id."' 
            GROUP BY course_installment_no";
    $student_courses_installments = $this->db->query($query)->result();
    foreach($student_courses_installments as $student_courses_installment){
        $query="SELECT 
        `courses`.`course_name`
        , `courses`.`course_fee`
        , `courses`.`is_subject`
        , `session_student_fees`.* 
        FROM `courses`,
            `session_student_fees` 
        WHERE 
        `courses`.`course_id` = `session_student_fees`.`course_id`
        AND `student_id` = '".$student_id."' 
        AND `session_id` = '".$session_id."'
        AND `course_installment_no` = '".$student_courses_installment->course_installment_no."'";

        $student_courses_installment->installment = $this->db->query($query)->result();
    }


    $this->data["student_courses_installments"] = $student_courses_installments;

    

    
   
    $this->load->view(ADMIN_DIR."home/installment_payment", $this->data); 
}



public function get_edit_form(){


    
    $student_id = (int) $this->input->post('student_id');
    $query = "SELECT `session_id` FROM `sessions` WHERE `sessions`.`status` = '1'";
    $session_id = $this->db->query($query)->result()[0]->session_id;
    $this->data["students"] = $this->student_model->get_student($student_id);

    $query="SELECT `course_installment_no` 
            FROM `session_student_fees` 
            WHERE `student_id` = '".$student_id."' 
            AND `session_id` = '".$session_id."' 
            GROUP BY course_installment_no";
    $student_courses_installments = $this->db->query($query)->result();
    foreach($student_courses_installments as $student_courses_installment){
        $query="SELECT 
        `courses`.`course_name`
        , `courses`.`course_fee`
        , `courses`.`is_subject`
        , `session_student_fees`.* 
        FROM `courses`,
            `session_student_fees` 
        WHERE 
        `courses`.`course_id` = `session_student_fees`.`course_id`
        AND `student_id` = '".$student_id."' 
        AND `session_id` = '".$session_id."'
        AND `course_installment_no` = '".$student_courses_installment->course_installment_no."'";

        $student_courses_installment->installment = $this->db->query($query)->result();
    }


    $this->data["student_courses_installments"] = $student_courses_installments;


    $query = "SELECT `session_id` FROM `sessions` WHERE `sessions`.`status` = '1'";
    $session_id = $this->db->query($query)->result()[0]->session_id;
   
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
        , `courses`.`course_id`
        , `courses`.`class`
        , `session_courses`.`teacher_id`
        , `session_courses`.`course_fee`
        , `session_courses`.`monthly_installment`
        , `session_courses`.`contract_percentage`
        
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

    

    
   
    $this->load->view(ADMIN_DIR."home/edit_form", $this->data); 
}

public function add_payment(){
    $discounts = $this->input->post("discount");
    foreach($discounts as $session_student_fee_id => $discount){
        $session_student_fee_id = (int) $session_student_fee_id;
        $query = "SELECT course_fee_total, `session_id`, `course_id` 
                  FROM session_student_fees 
                  WHERE session_student_fee_id = '$session_student_fee_id '";
        $query_result = $this->db->query($query)->result()[0];
        $course_fee_total = $query_result->course_fee_total;
        $discount = (int) $discount;
        $course_fee_paid= $course_fee_total-$discount;
        $user_id = $this->session->userdata('user_id');

        //get teacher id for update one
        $query="SELECT teacher_id FROM session_courses 
                WHERE `session_id` = '".$query_result->session_id."'
                AND `course_id` = '".$query_result->course_id."'"; 
        $teacher_id = $this->db->query($query)->result()[0]->teacher_id;
        $this->db->query("UPDATE session_student_fees SET `course_fee_discount` = '$discount', 
        `course_fee_paid` = '".$course_fee_paid."', `status`= '1', `teacher_id` = '".$teacher_id."'
        , `created_by` = '".$user_id."', `last_updated` = NOW()
        WHERE `session_student_fee_id`= '".$session_student_fee_id."'");
        


    }

    $student_id = $this->input->post('student_id');
    $query = "SELECT `session_id` FROM `sessions` WHERE `sessions`.`status` = '1'";
    $session_id = $this->db->query($query)->result()[0]->session_id;
    
    $query="UPDATE `session_students` SET `status`=1 WHERE `student_id` = '".$student_id."' and `session_id` = '".$session_id."'";
    $this->db->query($query);
    
    $this->session->set_flashdata("msg_success", "Payment Add Successfully.");
        redirect(ADMIN_DIR."home");
    
}

public function add_the_session_course(){
    $query = "SELECT `session_id` FROM `sessions` WHERE `sessions`.`status` = '1'";
    $session_id = $this->db->query($query)->result()[0]->session_id;
    $student_id = (int) $this->input->post('student_id');
    $session_course_id = (int) $this->input->post('session_course_id');
    // $query = "SELECT `course_id` FROM `session_courses` WHERE `session_course_id` = '".$session_course_id."'";
    // $course_id = $this->db->query($query)->result()[0]->course_id;
               $query = "SELECT * FROM session_courses WHERE `session_course_id` = '".$session_course_id."'";
                $session_course = $this->db->query($query)->result()[0];
                for($installment=1; $installment<=$session_course->monthly_installment; $installment++){
                    if($session_course->course_id==25){
                        $transport_fee= (int) $this->input->post("transport_fee");
                    $query="INSERT INTO `session_student_fees`(`session_student_id`, `session_id`, `student_id`, `course_id`, `course_installment_no`, `course_fee_total`, `teacher_id`) 
                            VALUES ('".$student_id."','".$session_id."','".$student_id."','".$session_course->course_id."','".$installment."','".$transport_fee."' ,'".$session_course->teacher_id."')";
                    $this->db->query($query);
                    }else{
                        $query="INSERT INTO `session_student_fees`(`session_student_id`, `session_id`, `student_id`, `course_id`, `course_installment_no`, `course_fee_total`, `teacher_id`) 
                            VALUES ('".$student_id."','".$session_id."','".$student_id."','".$session_course->course_id."','".$installment."','".$session_course->course_fee."' ,'".$session_course->teacher_id."')";
                    $this->db->query($query);

                    }
                }




}

public function remove_the_session_course(){
    $query = "SELECT `session_id` FROM `sessions` WHERE `sessions`.`status` = '1'";
    $session_id = $this->db->query($query)->result()[0]->session_id;
    $student_id = (int) $this->input->post('student_id');
    $session_course_id = (int) $this->input->post('session_course_id');
    $query = "SELECT `course_id` FROM `session_courses` WHERE `session_course_id` = '".$session_course_id."'";
    $course_id = $this->db->query($query)->result()[0]->course_id;

    $query = "DELETE  FROM `session_student_fees` 
              WHERE `session_id` = '".$session_id."'
              AND `course_id` = '".$course_id."'
              AND `student_id` = '".$student_id."'";
    if($this->db->query($query)){
        echo "Course Removed Successfully.";
    }else{
        echo "Error Try Again";
    }

}

public function delete_subject_installment(){
    $session_student_fee_id = (int) $this->input->post('session_student_fee_id');
    $query = "DELETE  FROM `session_student_fees` 
            WHERE `session_student_fee_id` = '".$session_student_fee_id."' ";
        if($this->db->query($query)){
        echo "Fee removed successfully.";
        }else{
                echo "Error Try Again";
        }

}

public function edit_stuent_info(){
    $student_id = (int) $this->input->post('student_id');
    $this->data["student"] = $this->student_model->get($student_id);
    $this->data["scholarships"] = $this->student_model->getList("scholarships", "scholarship_id", "scholarship_name", $where ="`scholarships`.`status` IN (1) ");

    $this->load->view(ADMIN_DIR."home/update_student_info", $this->data);
    
}

public function update_student_info_data(){

    
    $student_id = (int) $this->input->post('student_id');
     $student_id = $this->student_model->update_data($student_id);
       if($student_id){
             
             $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
             redirect(ADMIN_DIR."home/index");
         }else{
             
             $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
             redirect(ADMIN_DIR."home/index");
         }
     
}
    
}        
