<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<style>
	.dataTables_wrapper {
		margin-top: 5px !important;
	}
</style>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

<div class="row">
	<div class="col-sm-12">
		<div class="page-header" style="min-height: 10px !important;">
			<ul class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
				</li>
				<li><?php echo $title; ?></li>
			</ul>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<div class="box border blue" id="messenger">
			<div class="box-body">
			<div class="table-responsive">
				<table id="examp le" class="table table-bordered"  style="font-size: 12px;" >
						<thead>
						<tr><td colspan="2"></td>
						<?php $query = "SELECT
									MAX(`monthly_installment`) AS max_installment
								FROM `session_courses`
								WHERE `session_id`= $session->session_id;";
								$max_installment = $this->db->query($query)->result()[0]->max_installment;
								for ($installment = 1; $installment <= $max_installment; $installment++) { ?>
									<th colspan="7">Instalment <?php echo $installment; ?></th>
								<?php } ?>
						</tr>
						<tr>
						<th>#</th>
						<th>Classes</th>
								 <?php $query = "SELECT
									MAX(`monthly_installment`) AS max_installment
								FROM `session_courses`
								WHERE `session_id`= $session->session_id;";
								$max_installment = $this->db->query($query)->result()[0]->max_installment;
								for ($installment = 1; $installment <= $max_installment; $installment++) { 
									$query = "SELECT
									            `courses`.`course_id`,
												`courses`.`course_name`
											FROM `courses`,`session_courses`
											WHERE `courses`.`course_id` = `session_courses`.`course_id`
											AND `session_courses`.`session_id` = $session->session_id 
									        GROUP BY `course_name` ORDER BY `courses`.`course_id` DESC";
									$courses = $this->db->query($query)->result();
									 foreach($courses as $course){
										 echo "<td>".$course->course_name."</td>";
										}
										echo '<th>Total</th>';
									?>
									
								<?php } ?>
								 </tr>
								 </thead>
								 <tbody>
				<?php 
				$count = 1;
				foreach($classes as $class){ ?> 
				
							<tr><th ><?php echo $count++; ?></th>
							<th ><?php echo $class->class; ?></th>
							<?php $query = "SELECT
									MAX(`monthly_installment`) AS max_installment
								FROM `session_courses`
								WHERE `session_id`= $session->session_id;";
								$max_installment = $this->db->query($query)->result()[0]->max_installment;
								for ($installment = 1; $installment <= $max_installment; $installment++) { 


									



									$query = "SELECT
									`courses`.`class`
									, `courses`.`course_name`
									, `courses`.`course_id`,
									`session_courses`.`session_id`
								FROM `courses`,
								`session_courses`
								WHERE `courses`.`course_id` = `session_courses`.`course_id`
								AND  `session_courses`.`session_id` = $session->session_id
								AND class IN('".$class->class."', '0')
								GROUP BY `course_name` ORDER BY `courses`.`course_id` DESC";
									$courses = $this->db->query($query)->result();
									 foreach($courses as $course){
										 $query="SELECT 
										 SUM(`course_fee_paid`) AS total_paid, 
										 COUNT(`course_fee_paid`) AS total_paid_students  
										 FROM `students_fee`  
										 WHERE `session_id` = $session->session_id
										 AND `course_id` ='". $course->course_id."'
										 AND `course_installment_no` ='".$installment."'
										 AND `students_fee`.class = '".$class->class."'
										 ";
										 @$session_student_fee = $this->db->query($query)->result()[0];
										 echo "<th>".@$session_student_fee->total_paid."</th>";
										}
									?>
									<th>
									<?php 
									$query="SELECT 
									SUM(`course_fee_paid`) AS total_paid, 
									COUNT(`course_fee_paid`) AS total_paid_students  
									FROM `students_fee`  
									WHERE `session_id` = $session->session_id
									AND `students_fee`.class = '".$class->class."' 
									AND `students_fee`.`course_installment_no` ='".$installment."'
									";
									@$session_student_fee = $this->db->query($query)->result()[0];
									echo @$session_student_fee->total_paid;
									?>
									</th>
									<?php } ?>
							</tr>
						
					<?php } ?>

					<tr><th colspan="2">Total</th>
							<?php $query = "SELECT
									MAX(`monthly_installment`) AS max_installment
								FROM `session_courses`
								WHERE `session_id`= $session->session_id;";
								$max_installment = $this->db->query($query)->result()[0]->max_installment;
								for ($installment = 1; $installment <= $max_installment; $installment++) { 
									
										 $query="
										 SELECT 
										`students_fee`.`course_name`,
										SUM(`course_fee_paid`) AS total_paid,
										COUNT(`course_fee_paid`) AS total_paid_students 
										FROM
										`students_fee` 
										WHERE `session_id` = $session->session_id
										AND `course_installment_no` ='".$installment."'
										GROUP BY `students_fee`.`course_name` 
										ORDER BY `students_fee`.`course_id` DESC
										 
										 ";
										 $courses = $this->db->query($query)->result();
										 foreach($courses as $course){
											echo "<th>".@$course->total_paid."</th>";
										 }
										 
										
									?>
									<th>
									<?php 
									$query="SELECT 
									SUM(`course_fee_paid`) AS total_paid, 
									COUNT(`course_fee_paid`) AS total_paid_students  
									FROM `students_fee`  
									WHERE `session_id` = $session->session_id
									AND `students_fee`.`course_installment_no` ='".$installment."'
									";
									@$session_student_fee = $this->db->query($query)->result()[0];
									echo @$session_student_fee->total_paid;
									?>
									</th>
									<?php } ?>
							</tr>
					</tbody>

</table>

					<script>
						$(document).ready(function() {
							$('#example').DataTable();
						});
					</script>


				</div>


			</div>

		</div>
	</div>

</div>


