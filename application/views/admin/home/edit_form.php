<div class="row">
		<!-- MESSENGER -->
	<div class="col-md-4">
        <div class="box " id="messenger">
            <div class="box-body">
                
            <div class="table-responsive">


<div class="card">
<!--  -->
<div class="container">
<img   src="<?php echo site_url("assets/admin/no_image.jpg"); ?>" alt="Avatar" style="width:50%" />
<h3><b><?php echo $students[0]->student_name; ?></b></h3>
<h4><?php echo $students[0]->father_name; ?></h4>
<p>Gender:  <?php echo ucwords($students[0]->gender); ?></p>
<p>Address:  <?php echo $students[0]->address; ?></p>
<p>Contact: <?php echo $students[0]->mobile_no; ?> - <?php echo $students[0]->phone_no; ?></p>
<p>Class:  <?php echo $students[0]->class; ?></p>
<p>Institute: <?php echo $students[0]->institute; ?></p>
<?php if($students[0]->institute=='Yes'){ ?>
<p><?php echo $students[0]->scholarship_name; ?></p>
<?php } ?>

</div>
</div>
<style>

.card {
/* Add shadows to create the "card" effect */
box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
transition: 0.3s;
}

/* On mouse-over, add a deeper shadow */
.card:hover {
box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

/* Add some padding inside the card container */
.container {
padding: 2px 16px;
}

</style>






</div>

                
            </div>
            
        </div>
    </div>
    <div class="col-md-6">

<div class="table-responsive">

<p id="update_message"></p>
<?php $query = "SELECT `session_name` FROM `sessions` WHERE `sessions`.`status` = '1'";
                        $session_name = $this->db->query($query)->result()[0]->session_name; ?>
                <h3> Session: <?php echo ucwords($session_name);  ?> Courses / Fees</h3>
                
               <?php  if($session_courses){ ?>
                
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Course Name</th>
                    <th>Monthly Fee</th>
                    <th>Installments</th>
                </tr>
                </thead>
            
                        <tbody>
                    <?php 
                    
                    foreach($session_courses as $class_name => $classes): ?>

                        <tr>
                        
                        <?php if($class_name!=0){ ?>
                        <td colspan="6"><?php if($class_name!=0){ echo $class_name; } ?></td></tr>
                        <?php } ?>
                        
                    <?php foreach($classes['session_courses'] as $session_course): ?>
                        
                        <tr> 
                            <td><input 
                             onclick="update_student_course('<?php echo $session_course->session_course_id; ?>',  '<?php echo strtolower($session_course->course_name); ?>')" id="<?php echo $session_course->session_course_id; ?>_update_student_course"
                             
                            type="checkbox" 
                            
                            <?php $query="SELECT COUNT(*) as total FROM `session_student_fees` WHERE student_id = '".$students[0]->student_id."'
                                          AND session_id = '".$session_course->session_id."'
                                          and course_id = '".$session_course->course_id."'";
                                  if($this->db->query($query)->result()[0]->total>0){
                                  ?>
                                    checked="checked"
                                  <?php } ?>
                            
                            name="session_course_id[]" value="<?php echo $session_course->session_course_id; ?>" /></td>
                            <td title="<?php 
                            $query="SELECT `teacher_name` FROM `teachers` WHERE `teacher_id` = '".$session_course->teacher_id."'";
                            $result = $this->db->query($query)->result();
                            if($result){
                                echo $result[0]->teacher_name;
                            }
                            
                            ?>"><?php echo $session_course->course_name; ?>
                            
                        </td>
                            <td>
                            <?php if(strtolower($session_course->course_name)=='transport'){ ?>
                            <input style="width: 100px;" type="number" name="transport_fee" id="transport_fee" value="" />
                            <?php }else{?>
                            <?php echo $session_course->course_fee; ?>
                            <?php } ?>
                            </td>
                            <td><?php echo $session_course->monthly_installment; ?></td>
                            
                            
                            </tr>
                    <?php endforeach; 
                          endforeach;
                    ?>
                        </tbody>
                        
                    </table>  
                 <?php }else{ ?>
                    <h3 style="text-align: center;">Session Not Define.</h3>
                <?php } ?>    
               
            </div>                        

</div>
	<!-- /MESSENGER -->
</div>

<script>

function update_student_course(session_course_id, course_name){
    var transport_fee = null;
    if($('#'+session_course_id+'_update_student_course').is(":checked")){
        
        if(course_name==='transport'){
             transport_fee = $("#transport_fee").val();
            if(transport_fee==""){
                    $('#'+session_course_id+'_update_student_course').prop('checked', false);
                    $('#transport_fee').css('border-color', 'red'); 
                    alert("Please enter transport fee.");
                    return;
            }else{
                $('#transport_fee').css('border-color', ''); 
            }
        }
        
       
        


        $.ajax({
                type: "POST",
                url: '<?php echo site_url(ADMIN_DIR."home/add_the_session_course"); ?>',
                data: {student_id:'<?php echo $students[0]->student_id; ?>',
                       session_course_id: session_course_id,
                       transport_fee: transport_fee
                       }
            }).done(function(data) {
                
                    $('#update_message').html(data);
                    //alert(data);
                    });
    }else{
        
        $.ajax({
                type: "POST",
                url: '<?php echo site_url(ADMIN_DIR."home/remove_the_session_course"); ?>',
                data: {student_id:'<?php echo $students[0]->student_id; ?>',
                       session_course_id: session_course_id}
            }).done(function(data) {
                
                    $('#update_message').html(data);
                    //alert(data);
                    });
    }
}

</script>
