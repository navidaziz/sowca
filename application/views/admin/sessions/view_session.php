<!-- PAGE HEADER-->
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<!-- STYLER -->
			
			<!-- /STYLER -->
			<!-- BREADCRUMBS -->
			<ul class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
				</li><li>
				<i class="fa fa-table"></i>
				<a href="<?php echo site_url(ADMIN_DIR."sessions/view/"); ?>"><?php echo $this->lang->line('Sessions'); ?></a>
			</li><li><?php echo $title; ?></li>
			</ul>
			<!-- /BREADCRUMBS -->
            <div class="row">
                        
                <div class="col-md-8">
                    <div class="clearfix">
					  <h3 class="content-title pull-left"><?php echo $sessions[0]->session_name; ?></h3>
					    
					</div>
					<div class="description">
				<b>(<?php echo $sessions[0]->start_date; ?> to <?php echo $sessions[0]->end_date; ?>)</b>
				
				<?php echo status($sessions[0]->status); ?>
				<br />
				<?php echo $sessions[0]->session_detail; ?>
			</div>
                </div>
                
                <div class="col-md-4">
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."sessions/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."sessions/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
                    </div>
                </div>
                
            </div>
            
			
		</div>
	</div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
        <!-- MESSENGER -->
        
	<div class="col-md-6">
	    <div class="box border blue" id="messenger">
		<div class="box-title">
			<h4><i class="fa fa-bell"></i> All Courses</h4>
			
		</div><div class="box-body">
			
            <div class="table-responsive">
                
                    <table class="table table-bordered">
						<thead>
                        <tr>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Fee</th>
                            <th>Instalment</th>
                            <th>Teacher</th>
                            <th>%</th>
                            <th></th>
                        </tr>
						</thead>
						<tbody>

                        <?php foreach($courses_classes as $courses_class){   ?>

                            
                                <?php 
                                if($courses_class->class==0){

                                }else{ ?>
                                <tr><td colspan="7"><h5>
                                <?php echo $courses_class->class; ?> </h5></td></tr>
                               <?php } ?>
                            
                            <?php 
                            $count = 1;
                            foreach($courses_class->courses as $courses): ?>
                            <form method="post" action="<?php echo site_url(ADMIN_DIR."sessions/add_session_courses"); ?>">
                            <input type="hidden" value="<?php echo $sessions[0]->session_id; ?>" name="session_id" />
                            <input type="hidden" value="<?php echo $courses->course_id; ?>" name="course_id" />
                            <tr>
                                <td><?php echo  $count++; ?></td>
                                <td><?php echo $courses->course_name; ?></td>
                                <td><input class="fo rm-control" min="0" required style="width: 70px;" type="number" value="" name="course_fee" /></td>
                                <td>
                                  
                                <input class="for m-control" min="1" required style="width: 70px;" type="number" value="" name="monthly_installment" /></td>
                                <td><?php if($courses->is_subject == 'Yes'){ ?>  
                                    <select class="f orm-control" name="teacher_id" required>
                                    <option value="0"> Select Teacher </option>
                                    <?php $query="SELECT * FROM `teachers` where status=1";
                                          $teachers = $this->db->query($query)->result();
                                          foreach($teachers as $teacher){
                                    ?>
                                    <option value="<?php echo $teacher->teacher_id; ?>">
                                    <?php echo $teacher->teacher_name; ?>
                                    </option>
                                    <?php 
                                          }
                                    ?>
                                    </select>
                                    <?php } ?>
                                </td>
                                <td>
                                <?php if($courses->is_subject == 'Yes'){ ?>     
                                <input min="1" max="100" required style="width: 70px;" type="number" value="" name="contract_percentage" />
                                    <?php }    ?>
                                </td>
                                
                                <td><input type="submit" class="btn btn-primary btn-sm" name="add_course" value="Add" /></td>
                            </tr>
                            </form>
                            <?php endforeach; ?>

                        <?php } ?>





					  
						</tbody>
					  </table>
                      
                      


                      
                      

            </div>
			
			
        </div>
        
        
		
    </div>
    


    

    
    


	</div>
    <!-- /MESSENGER -->
    
    <div class="col-md-6">
            <div class="box border blue" id="messenger">
            <div class="box-title"> <h4><i class="fa fa-bell"></i> Session Courses </h4> </div>
            <div class="box-body">
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Course Name</th>
                        <th>Monthly Fee</th>
                        <th>Installments</th>
                        <th>Teacher</th>
                        <th>Percentage</th>
                                    <th>remove</th>
                    </tr>
                    </thead>
                
							<tbody>
                        <?php 
                        
                        foreach($session_courses as $class_name => $classes): ?>

                            <tr>
                            
                            <?php if($class_name!=0){ ?>
                            <td colspan="7"><h5><?php if($class_name!=0){ echo $class_name; } ?></h5></td></tr>
                            <?php } ?>
                            
                        <?php 
                        $count = 1;
                        foreach($classes['session_courses'] as $session_course): ?>
							
							<tr> 
                               <td><?php echo $count++; ?></td>
                               <td title="<?php 
								$query="SELECT `teacher_name` FROM `teachers` WHERE `teacher_id` = '".$session_course->teacher_id."'";
								$result = $this->db->query($query)->result();
								if($result){
									echo $result[0]->teacher_name;
								}
								
								?>"><?php echo $session_course->course_name; ?>
                                
                            </td>
                                <td><?php echo $session_course->course_fee; ?></td>
                                <td><?php echo $session_course->monthly_installment; ?></td>
                                <td>
                                <?php if($session_course->is_subject == 'Yes'){ ?>
                                <?php 
                                
                                $query="SELECT * FROM `teachers` where teacher_id= '". $session_course->teacher_id."'";
                                echo $this->db->query($query)->result()[0]->teacher_name; ?>
                                <?php } ?>
                                </td>
                                <td>
                                <?php if($session_course->is_subject == 'Yes'){ 
                                    echo $session_course->contract_percentage." %";
                                 } ?>   

                                </td>
                                <td style="text-align: center;">
                                <a onclick="return confirm('Are you sure? you want to remove.')" href="<?php echo site_url(ADMIN_DIR."sessions/remove_session_course/".$session_course->session_course_id."/".$session_course->session_id); ?>" >
                                <i class="fa fa-times" aria-hidden="true"></i>
                                </a>
                            </td>
								</tr>
                        <?php endforeach; 
                              endforeach;
                        ?>
                          </tbody>
                            
                        </table>
                </div>
            </div>
            
            </div>
        </div>
</div>
