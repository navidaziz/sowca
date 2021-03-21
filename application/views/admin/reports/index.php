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
			<!-- STYLER -->

			<!-- /STYLER -->
			<!-- BREADCRUMBS -->
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
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
	

	<div class="col-md-12">
		<div class="box border blue" id="messenger">
			<div class="box-body">

				<div class="table-responsive">

				<?php foreach($classes as $classe){ ?>
				<h4><?php echo $classe->class; ?></h4>
				    <table id="examp le" class="table table-bordered"  style="font-size: 9px;" >
						<thead>
						<tr><td colspan="7">Student Profile</td>
						<?php $query = "SELECT
									MAX(`monthly_installment`) AS max_installment
								FROM `session_courses`
								WHERE `session_id`= (SELECT session_id FROM sessions WHERE `sessions`.`status`=1);";
								$max_installment = $this->db->query($query)->result()[0]->max_installment;
								for ($installment = 1; $installment <= $max_installment; $installment++) { ?>
									<th colspan="6">Instalment <?php echo $installment; ?></th>
								<?php } ?>
						</tr>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Father Name</th>
								<th>Contact No</th>
								<th>Gender</th>
								<th>Transport</th>
								<th>Scholarship</th>
								<?php $query = "SELECT
									MAX(`monthly_installment`) AS max_installment
								FROM `session_courses`
								WHERE `session_id`= (SELECT session_id FROM sessions WHERE `sessions`.`status`=1);";
								$max_installment = $this->db->query($query)->result()[0]->max_installment;
								for ($installment = 1; $installment <= $max_installment; $installment++) { 
									$query = "SELECT
									            `courses`.`course_id`,
												`courses`.`course_name`
											FROM `courses`,`session_courses`
											WHERE `courses`.`course_id` = `session_courses`.`course_id`
											AND `session_courses`.`session_id` = (SELECT session_id FROM sessions WHERE STATUS=1) 
									        GROUP BY `course_name` ORDER BY `courses`.`course_id` DESC";
									$courses = $this->db->query($query)->result();
									 foreach($courses as $course){
										 echo "<td>".$course->course_name."</td>";
										}
									?>
									
								<?php } ?>
								
								
								
							</tr>
						</thead>
						<tbody>
							<?php 
							$count = 1;
							foreach ($classe->students as $student) { ?>

								<?php
								$query = "SELECT
										MAX(course_installment_no) AS max_installment
										FROM `session_student_fees`
										WHERE `session_id`= (SELECT session_id FROM sessions WHERE `sessions`.`status`=1)
										AND `session_student_fees`.`student_id` = '" . $student->student_id . "';";
								$max_installment_student = $this->db->query($query)->result()[0]->max_installment;

								?>
								<tr>
									<td> <?php echo $count++; ?> </td>
									<td><?php echo $student->student_name; ?></td>
									<td><?php echo $student->father_name; ?></td>
									<td><?php echo $student->mobile_no; ?></td>
									<td><b><?php echo ucfirst(substr($student->gender, 0, 1)); ?></b></td>
									<td><b><?php

											$query = "SELECT
													`courses`.`course_name`
												FROM `courses`, 
													`session_student_fees`
												WHERE `courses`.`course_id` = `session_student_fees`.`course_id`
												AND `session_student_fees`.`student_id`= '" . $student->student_id . "'
												AND `session_student_fees`.`session_id`= (SELECT session_id FROM sessions WHERE `sessions`.`status`=1)
												AND `courses`.`course_name` = 'Transport'
												GROUP BY `courses`.`course_name`";

											if (@$this->db->query($query)->result()[0]->course_name == 'Transport') {
												echo '<b>Y</b>';
											} else {
												//echo '<b>N</b>';
											}

											//echo substr($student->transport,0,1); 
											?></b></td>
									<td><b><?php

											$query = "SELECT
												SUM(course_fee_discount) AS total_discount
											FROM  `session_student_fees`
											WHERE  `session_student_fees`.`student_id`= '" . $student->student_id . "'
											AND `session_student_fees`.`session_id`= (SELECT session_id FROM sessions WHERE `sessions`.`status`=1)
											";

											if (@$this->db->query($query)->result()[0]->total_discount > 1) {
												echo '<b>Y</b>';
											} else {
												//echo '<b>N</b>';
											}

											?></b></td>
								<?php $query = "SELECT
									MAX(`monthly_installment`) AS max_installment
								FROM `session_courses`
								WHERE `session_id`= (SELECT session_id FROM sessions WHERE `sessions`.`status`=1);";
								$max_installment = $this->db->query($query)->result()[0]->max_installment;
								for ($installment = 1; $installment <= $max_installment; $installment++) { 
									$query = "SELECT
									            `courses`.`course_id`,
												`courses`.`course_name`
											FROM `courses`,`session_courses`
											WHERE `courses`.`course_id` = `session_courses`.`course_id`
											AND `session_courses`.`session_id` = (SELECT session_id FROM sessions WHERE STATUS=1) 
									        GROUP BY `course_name` ORDER BY `courses`.`course_id` DESC";
									$courses = $this->db->query($query)->result();
									 foreach($courses as $course){
										 $query="SELECT * FROM `session_student_fees`
										 WHERE `session_student_fees`.`session_id` = (SELECT session_id FROM sessions WHERE STATUS=1) 
										 AND `session_student_fees`.`student_id` ='". $student->student_id."'
										 AND `session_student_fees`.`course_id` ='". $course->course_id."'
										 AND `session_student_fees`.`course_installment_no` ='".$installment."'
										 ";
										 @$session_student_fee = $this->db->query($query)->result()[0];
										 echo "<td>".@$session_student_fee->course_fee_paid."</td>";
										}
									?>
									
								<?php } ?>

									

								</tr>
							<?php } ?>
						</tbody>

					</table>
					<?php } ?>


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


