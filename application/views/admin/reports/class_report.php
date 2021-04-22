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
				<li>
					<i class="fa fa-home"></i>
					<a href="<?php echo site_url(ADMIN_DIR . 'reports/index'); ?>">Session Reports</a>
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
					<table id="examp le" class="table table-bordered" style="font-size: 12px;">
						<thead>
							<tr>
								<td colspan="2"></td>
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
									$query = "SELECT `course_id`, `course_name`
										FROM `students_fee`
										WHERE `session_id`= '" . $session->session_id . "' 
										AND `course_installment_no`= '" . $installment . "'
										GROUP BY `course_name` ORDER BY `course_id` DESC;";
									$all_courses = $this->db->query($query)->result();
									foreach ($all_courses as $course) {
										echo "<th>" . $course->course_name . "</th>";
									}
									echo '<th>Total</th>';
								?>

								<?php } ?>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 1;
							foreach ($classes as $class) { ?>

								<tr>
									<th><?php echo $count++; ?></th>
									<th><?php echo $class->class; ?></th>
									<?php $query = "SELECT
									MAX(`monthly_installment`) AS max_installment
								FROM `session_courses`
								WHERE `session_id`= $session->session_id;";
									$max_installment = $this->db->query($query)->result()[0]->max_installment;
									for ($installment = 1; $installment <= $max_installment; $installment++) {

										$query = "SELECT `course_id`, `course_name`
										FROM `students_fee`
										WHERE `session_id`= '" . $session->session_id . "' 
										AND `course_installment_no`= '" . $installment . "'
										GROUP BY `course_name` ORDER BY `course_id` DESC;";
										$all_courses = $this->db->query($query)->result();
										foreach ($all_courses as $course) {
											echo "<td>";
											$query = "SELECT SUM(`course_fee_paid`) AS total_paid, `teacher_id`
											FROM `students_fee`
											WHERE `session_id`= '" . $session->session_id . "'
											AND `course_name` =  '" . $course->course_name . "'
											AND `course_installment_no`= '" . $installment . "'
											AND `class` = '" . $class->class . "'
											GROUP BY `course_name` ORDER BY `course_id` DESC;";
											$courses = $this->db->query($query)->result();
											foreach ($courses as $course) {
												echo $course->total_paid;
												// if ($course->teacher_id) {
												// 	$query = "SELECT * FROM teachers WHERE teacher_id = '" . $course->teacher_id . "'";
												// 	$teacher_info = $this->db->query($query)->result()[0];
												// 	echo "<br />" . $teacher_info->teacher_name;
												// }
											}
											echo "</td>";
										}

									?>
										<th>
											<?php
											$query = "SELECT 
									SUM(`course_fee_paid`) AS total_paid, 
									COUNT(`course_fee_paid`) AS total_paid_students  
									FROM `students_fee`  
									WHERE `session_id` = $session->session_id
									AND `students_fee`.class = '" . $class->class . "' 
									AND `students_fee`.`course_installment_no` ='" . $installment . "'
									";
											@$session_student_fee = $this->db->query($query)->result()[0];
											echo @$session_student_fee->total_paid;
											?>
										</th>
									<?php } ?>
								</tr>

							<?php } ?>

							<tr>
								<th colspan="2">Total</th>
								<?php $query = "SELECT
									MAX(`monthly_installment`) AS max_installment
								FROM `session_courses`
								WHERE `session_id`= $session->session_id;";
								$max_installment = $this->db->query($query)->result()[0]->max_installment;
								for ($installment = 1; $installment <= $max_installment; $installment++) {

									$query = "
										 SELECT 
										`students_fee`.`course_name`,
										SUM(`course_fee_paid`) AS total_paid,
										COUNT(`course_fee_paid`) AS total_paid_students 
										FROM
										`students_fee` 
										WHERE `session_id` = $session->session_id
										AND `course_installment_no` ='" . $installment . "'
										GROUP BY `students_fee`.`course_name` 
										ORDER BY `students_fee`.`course_id` DESC
										 
										 ";
									$courses = $this->db->query($query)->result();
									foreach ($courses as $course) {
										echo "<th>" . @$course->total_paid . "</th>";
									}


								?>
									<th>
										<?php
										$query = "SELECT 
									SUM(`course_fee_paid`) AS total_paid, 
									COUNT(`course_fee_paid`) AS total_paid_students  
									FROM `students_fee`  
									WHERE `session_id` = $session->session_id
									AND `students_fee`.`course_installment_no` ='" . $installment . "'
									";
										@$session_student_fee = $this->db->query($query)->result()[0];
										echo @$session_student_fee->total_paid;
										?>
									</th>
								<?php } ?>
							</tr>



							<!-- <tr><th colspan="2">Total Students</th>
							<?php $query = "SELECT
									MAX(`monthly_installment`) AS max_installment
								FROM `session_courses`
								WHERE `session_id`= $session->session_id;";
							$max_installment = $this->db->query($query)->result()[0]->max_installment;
							for ($installment = 1; $installment <= $max_installment; $installment++) {
								$query = "SELECT `course_id`, `course_name`
										FROM `students_fee`
										WHERE `session_id`= '" . $session->session_id . "' 
										AND `course_installment_no`= '" . $installment . "'
										GROUP BY `course_name` ORDER BY `course_id` DESC;";
								$all_courses = $this->db->query($query)->result();
								foreach ($all_courses as $course) {
									echo "<th>" . $course->course_name . "</th>";
								}
								echo '<th>Total</th>';
							?>
									<th>
									<?php
									$query = "SELECT DISTINCT COUNT(`student_id`) AS total_students
									FROM `students_fee`
									WHERE `session_id`= '" . $session->session_id . "'
									AND `course_installment_no`= '" . $installment . "'";
									@$session_student_fee = $this->db->query($query)->result()[0];
									echo @$session_student_fee->total_students;
									?>
									</th>
									<?php } ?>
							</tr> -->
						</tbody>

					</table>

					<script>
						$(document).ready(function() {
							$('#example').DataTable();
						});
					</script>



					<div class="table-responsive">

						<?php foreach ($classes as $class) { ?>
							<h4><?php echo $class->class; ?></h4>
							<table id="examp le" class="table table-bordered" style="font-size: 10px;">
								<thead>
									<tr>
										<td colspan="7">Student Profile</td>
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
										<th>Name</th>
										<th>Father Name</th>
										<th>Contact No</th>
										<th>Gender</th>
										<th>Transport</th>
										<th>Scholarship</th>
										<?php $query = "SELECT
									MAX(`monthly_installment`) AS max_installment
								FROM `session_courses`
								WHERE `session_id`= $session->session_id;";
										$max_installment = $this->db->query($query)->result()[0]->max_installment;
										for ($installment = 1; $installment <= $max_installment; $installment++) {
											$query = "SELECT `course_id`, `course_name`
										FROM `students_fee`
										WHERE `session_id`= '" . $session->session_id . "' 
										AND `course_installment_no`= '" . $installment . "'
										GROUP BY `course_name` ORDER BY `course_id` DESC;";
											$all_courses = $this->db->query($query)->result();
											foreach ($all_courses as $course) {
												echo "<th>" . $course->course_name . "</th>";
											}
											echo '<th>Total</th>';
										?>

										<?php } ?>



									</tr>
								</thead>
								<tbody>
									<?php
									$count = 1;
									foreach ($class->students as $student) { ?>

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
							WHERE `session_id`= $session->session_id;";
											$max_installment_student = $this->db->query($query)->result()[0]->max_installment;

											for ($installment = 1; $installment <= $max_installment; $installment++) {
												$query = "SELECT `course_id`, `course_name`
										FROM `students_fee`
										WHERE `session_id`= '" . $session->session_id . "' 
										AND `course_installment_no`= '" . $installment . "'
										GROUP BY `course_name` ORDER BY `course_id` DESC;";
												$all_courses = $this->db->query($query)->result();
												foreach ($all_courses as $course) {
													echo "<td>";
													$query = "SELECT SUM(`course_fee_paid`) AS total_paid
											FROM `students_fee`
											WHERE `session_id`= '" . $session->session_id . "'
											AND `course_name` =  '" . $course->course_name . "'
											AND `course_installment_no`= '" . $installment . "'
											AND `class` = '" . $class->class . "'
											AND `student_id` = '" . $student->student_id . "'
											GROUP BY `course_name` ORDER BY `course_id` DESC;";
													$courses = $this->db->query($query)->result();
													foreach ($courses as $course) {
														echo $course->total_paid;
													}
													echo "</td>";
												} ?>
												<th>
													<?php
													$query = "SELECT sum(course_fee_paid) as total_paid FROM `session_student_fees`
									WHERE `session_student_fees`.`session_id` = (SELECT session_id FROM sessions WHERE STATUS=1) 
									AND `session_student_fees`.`student_id` ='" . $student->student_id . "'
									AND `session_student_fees`.`course_installment_no` ='" . $installment . "'
									";
													@$session_student_fee = $this->db->query($query)->result()[0];
													echo @$session_student_fee->total_paid;
													?>
												</th>

											<?php } ?>



										</tr>
									<?php } ?>
									<tr>
										<th colspan="7">Total</th>
										<?php $query = "SELECT
								MAX(`monthly_installment`) AS max_installment
							FROM `session_courses`
							WHERE `session_id`= $session->session_id;";
										$max_installment = $this->db->query($query)->result()[0]->max_installment;
										for ($installment = 1; $installment <= $max_installment; $installment++) {
											$query = "SELECT `course_id`, `course_name`
										FROM `students_fee`
										WHERE `session_id`= '" . $session->session_id . "' 
										AND `course_installment_no`= '" . $installment . "'
										GROUP BY `course_name` ORDER BY `course_id` DESC;";
											$all_courses = $this->db->query($query)->result();
											foreach ($all_courses as $course) {
												echo "<td>";
												$query = "SELECT SUM(`course_fee_paid`) AS total_paid
											FROM `students_fee`
											WHERE `session_id`= '" . $session->session_id . "'
											AND `course_name` =  '" . $course->course_name . "'
											AND `course_installment_no`= '" . $installment . "'
											AND `class` = '" . $class->class . "'
											GROUP BY `course_name` ORDER BY `course_id` DESC;";
												$courses = $this->db->query($query)->result();
												foreach ($courses as $course) {
													echo $course->total_paid;
												}
												echo "</td>";
											} ?>
											<th>
												<?php
												$query = "SELECT 
									SUM(`course_fee_paid`) AS total_paid, 
									COUNT(`course_fee_paid`) AS total_paid_students  
									FROM `students_fee`  
									WHERE `session_id` = (SELECT session_id FROM `sessions` WHERE `sessions`.`status`=1)
									AND `students_fee`.class = '" . $class->class . "' 
									AND `students_fee`.`course_installment_no` ='" . $installment . "'
									";
												@$session_student_fee = $this->db->query($query)->result()[0];
												echo @$session_student_fee->total_paid;
												?>
											</th>
										<?php } ?>
									</tr>
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

</div>


<div class="row">
	<?php $query = "SELECT
									MAX(`monthly_installment`) AS max_installment
								FROM `session_courses`
								WHERE `session_id`= $session->session_id;";
	$max_installment = $this->db->query($query)->result()[0]->max_installment;

	for ($installment = 1; $installment <= $max_installment; $installment++) { ?>
		<div class="col-md-<?php echo (12 / $max_installment) ?>">
			<div class="box border blue" id="messenger">
				<div class="box-body">
					<div class="table-responsive">
						<h2><?php echo "Teacher Salaries " . $installment; ?></h2>
						<table class="table table-bordered" style="font-size: 10px !important;">
							<tr>
								<th>S/No</th>
								<th>Teacher Name</th>
								<th width="100">Class</th>
								<th>Subject</th>
								<th>Students Fees</th>
								<th>Teacher Salary-70%</th>
								<th>Academy-30%</th>
							</tr>
							<?php
							$query = "Select teacher_id, teacher_name FROM teachers_salaries WHERE  `session_id`= '" . $session->session_id . "' GROUP BY teacher_id";
							$teachers = $this->db->query($query)->result();
							$s_no = 1;

							foreach ($teachers as  $teacher) {


								$query = "SELECT * FROM teachers_salaries WHERE teacher_id = '" . $teacher->teacher_id . "' 
							AND `session_id`= '" . $session->session_id . "'
							AND `course_installment_no` = '" . $installment . "'";
								$teacher_salaries = $this->db->query($query)->result();
								$count = 1;
								$stuent_fees = 0;
								foreach ($teacher_salaries as $teacher_salary) {

									echo '<tr>';
									if ($count == 1) {
										echo '<td rowspan="' . count($teacher_salaries)  . '">' . $s_no++ . '</td>';
										echo '<td rowspan="' . count($teacher_salaries)  . '">' . $teacher_salary->teacher_name . '</td>';
									}

									$count++;

									echo '<td>' . $teacher_salary->class . '</td>
										<td>' . $teacher_salary->course_name . '</td>
										<td>' . $teacher_salary->total . '</td>
										<td>' . ((70 * $teacher_salary->total) / 100) . '</td>
										<td>' . ((30 * $teacher_salary->total) / 100) . '</td>
										</tr>';
									$stuent_fees = $stuent_fees + $teacher_salary->total;
								}
								echo '<tr>
									<th colspan="4" style="text-align:right">Total</th>
									<th>' . $stuent_fees . '</th>
									<th>' . ((70 * $stuent_fees) / 100) . '</th>
									<th>' . ((30 * $stuent_fees) / 100) . '</th>
									
									</tr>';
							}
							?>
						</table>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
</div>