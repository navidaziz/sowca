<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<style>
	.dataTables_wrapper {
		margin-top: 5px !important;
	}
</style>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>


<script>
function edit_stuent_info(student_id){
		$.ajax({
				type: "POST",
				url: '<?php echo site_url(ADMIN_DIR . "home/edit_stuent_info"); ?>',
				data: {
					student_id: student_id,
				}
			}).done(function(data) {
				$('#edit_student_info_body').html(data);
			});
}
</script>

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
	<!-- MESSENGER -->


	<div class="col-md-3">
		<div class="box border blue" id="messenger">
			<div class="box-body">

				<div class="table-responsive">

					<h3 style="text-align: center; margin:2px">
					<?php echo $session->session_name; ?><br />
					<small style="font-size: 12px;"><?php echo date("d M, Y", strtotime($session->start_date)); ?> - <?php echo date("d M, Y", strtotime($session->end_date)); ?></small>
					</h3>
					<hr style="margin-top: -2px;" />
					<b>Search Student</b> By Name
					<table style="width: 100%;">
						<tr>
							<td><input type="text" name="student_name_for_search" id="student_name_for_search" class="form-control input-sm" placeholder="Student Name ....." /></td>
							<td>
								<button class="btn btn-primary btn-sm" onclick="get_student_search_result()">
									<i class="fa fa-search"></i> Search
								</button>
							</td>
						</tr>
					</table>

					<script>
						function get_student_search_result() {
							var student_name_for_search = $('#student_name_for_search').val();
							if (student_name_for_search == '') {
								alert("Enter student name for search the student");
							} else {
								$.ajax({
									type: "POST",
									url: '<?php echo site_url(ADMIN_DIR . "home/search_student_by_name"); ?>',
									data: {
										student_name: student_name_for_search,
									}
								}).done(function(data) {
									$('#student_search_result').html(data);
								});

							}
						}

						function get_adminssion_form(student_id) {
							$.ajax({
								type: "POST",
								url: '<?php echo site_url(ADMIN_DIR . "home/get_admission_form"); ?>',
								data: {
									student_id: student_id,
								}
							}).done(function(data) {
								$('#admission_form_body').html(data);
								//alert(data);
							});
						}

						function get_installment_payment_form(student_id) {

							$.ajax({
								type: "POST",
								url: '<?php echo site_url(ADMIN_DIR . "home/get_installment_payment_form"); ?>',
								data: {
									student_id: student_id,
								}
							}).done(function(data) {

								$('#installment_form_body').html(data);
								//alert(data);
							});
						}

						function get_edit_form(student_id) {



							$.ajax({
								type: "POST",
								url: '<?php echo site_url(ADMIN_DIR . "home/get_edit_form"); ?>',
								data: {
									student_id: student_id,
								}
							}).done(function(data) {

								$('#edit_form_body').html(data);
								//alert(data);
							});
						}
					</script>

					<div id="student_search_result"></div>

					<div>
						<?php
						$query = "SELECT 
											COUNT(`students`.`gender`) AS `total`,
											COUNT(IF(`students`.`gender`='female',1,NULL)) AS `females`,
											COUNT(IF(`students`.`gender`='male',1,NULL)) AS `males`  
										FROM
											`students`,
											`session_students` 
										WHERE `students`.`student_id` = `session_students`.`student_id`
										AND `session_students`.`session_id` = (SELECT session_id FROM sessions WHERE STATUS=1)";
						$student_session = $this->db->query($query)->result()[0];



						$query = "SELECT 
								COUNT(DISTINCT(`session_student_fees`.`student_id`)) AS total
								FROM
								  `courses`,
								  `session_student_fees`,
								  `students`  
								WHERE `courses`.`course_id` = `session_student_fees`.`course_id` 
								AND `students`.`student_id` = `session_student_fees`.`student_id`
								AND `courses`.`course_name`='Transport'
								AND `students`.`gender`='male'
								AND `session_student_fees`.`session_id` = (SELECT session_id FROM sessions WHERE STATUS=1)
								GROUP BY `students`.`gender`";
						@$transport_male = $this->db->query($query)->result()[0]->total;

						$query = "SELECT 
								COUNT(DISTINCT(`session_student_fees`.`student_id`)) AS total
								FROM
								  `courses`,
								  `session_student_fees`,
								  `students`  
								WHERE `courses`.`course_id` = `session_student_fees`.`course_id` 
								AND `students`.`student_id` = `session_student_fees`.`student_id`
								AND `courses`.`course_name`='Transport'
								AND `students`.`gender`='female'
								AND `session_student_fees`.`session_id` = (SELECT session_id FROM sessions WHERE STATUS=1)
								GROUP BY `students`.`gender`";
						@$transport_female = $this->db->query($query)->result()[0]->total;

						$query = "SELECT 
								COUNT(DISTINCT(`session_student_fees`.`student_id`)) AS total
								FROM
								  `courses`,
								  `session_student_fees`,
								  `students`  
								WHERE `courses`.`course_id` = `session_student_fees`.`course_id` 
								AND `students`.`student_id` = `session_student_fees`.`student_id`
								AND `session_student_fees`.`course_fee_discount` > 0
								AND `students`.`gender`='female'
								AND `session_student_fees`.`session_id` = (SELECT session_id FROM sessions WHERE STATUS=1)
								GROUP BY `students`.`gender`";
						@$scholarship_female = $this->db->query($query)->result()[0]->total;

						$query = "SELECT 
								COUNT(DISTINCT(`session_student_fees`.`student_id`)) AS total
								FROM
								  `courses`,
								  `session_student_fees`,
								  `students`  
								WHERE `courses`.`course_id` = `session_student_fees`.`course_id` 
								AND `students`.`student_id` = `session_student_fees`.`student_id`
								AND `session_student_fees`.`course_fee_discount` > 0
								AND `students`.`gender`='male'
								AND `session_student_fees`.`session_id` = (SELECT session_id FROM sessions WHERE STATUS=1)
								GROUP BY `students`.`gender`";
						@$scholarship_male = $this->db->query($query)->result()[0]->total;


						?>
						<table class="table table-bordered">
							<h4>Session Students Summary</h4>
							<tr>
								<td>Total</td>
								<td>Females</td>
								<td>Males</td>
							</tr>
							<tr>
								<td><?php echo $student_session->total; ?></td>
								<td><?php echo $student_session->females; ?></td>
								<td><?php echo $student_session->males; ?></td>
							</tr>
							<tr>
								<td>Transport</td>
								<td><?php echo $transport_female; ?></td>
								<td><?php echo $transport_male; ?></td>
							</tr>


							<tr>
								<td>On Scholarship</td>
								<td><?php echo $scholarship_female; ?></td>
								<td><?php echo $scholarship_male; ?></td>
							</tr>
							<?php
							$query = "SELECT 
								`courses`.`class`,
								COUNT(DISTINCT(`session_student_fees`.`student_id`)) AS total 
								FROM
								`courses`,
								`session_student_fees` 
								WHERE `courses`.`course_id` = `session_student_fees`.`course_id` 
								AND `courses`.`is_subject` = 'Yes'
								AND `session_student_fees`.`session_id` = (SELECT session_id FROM sessions WHERE STATUS=1)
								GROUP BY  `courses`.`class`
								ORDER BY ABS(`courses`.`class`) ASC";
							$classes_students = $this->db->query($query)->result();
							?>


							<!-- <tr><td>Class</td><td colspan="2">Total Students</td></tr> -->
							<?php foreach ($classes_students as $classes_student) { ?>
								<tr>
									<td><?php echo $classes_student->class; ?></td>
									<td colspan="2"><?php echo $classes_student->total; ?></td>
								</tr>
							<?php } ?>

						</table>

					</div>



				</div>


			</div>

		</div>
	</div>

	<div class="col-md-9">
		<div class="box border blue" id="messenger">
			<div class="box-body">

				<div class="table-responsive" style="min-height: 470px;">



					<table id="example" class="display" style="width:100%;">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Father Name</th>
								<th><i class="fa fa-phone" aria-hidden="true"></i></th>
								<th><i class="fa fa-male" aria-hidden="true"></i></th>
								<th><i class="fa fa-university" aria-hidden="true"></i></th>
								<th><i class="fa fa-bus" aria-hidden="true"></i></th>
								<th><i class="fa fa-graduation-cap" aria-hidden="true"></i></th>
								<th><i class="fa fa-edit" aria-hidden="true"></i></th>
								<?php

								$query = "SELECT
							MAX(`monthly_installment`) AS max_installment
						FROM `session_courses`
						WHERE `session_id`= (SELECT session_id FROM sessions WHERE `sessions`.`status`=1);";
								$max_installment = $this->db->query($query)->result()[0]->max_installment;
								for ($installment = 1; $installment <= $max_installment; $installment++) { ?>
									<th><i class="fa fa-credit-card" aria-hidden="true"></i> <?php echo $installment; ?></th>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($students as $student) { ?>

								<?php
								$query = "SELECT
										MAX(course_installment_no) AS max_installment
										FROM `session_student_fees`
										WHERE `session_id`= (SELECT session_id FROM sessions WHERE `sessions`.`status`=1)
										AND `session_student_fees`.`student_id` = '" . $student->student_id . "';";
								$max_installment_student = $this->db->query($query)->result()[0]->max_installment;

								?>
								<tr>
									<td>
										<?php if ($student->admission_confirmed == 0) { ?>
											<i class="fa fa-clock-o" aria-hidden="true"></i>
										<?php } else {  ?>

											<i class="fa fa-check" aria-hidden="true"></i>
										<?php } ?>
									</td>
									<td><a aria-hidden="true" data-toggle="modal" data-target="#edit_student_info" href="javascript:return false;" onclick="edit_stuent_info('<?php echo $student->student_id; ?>')" ><?php echo $student->student_name; ?></a></td>
									<td><?php echo $student->father_name; ?></td>
									<td><?php echo $student->mobile_no; ?></td>
									<td><b><?php echo ucfirst(substr($student->gender, 0, 1)); ?></b></td>
									<td><?php

										$query = "SELECT
											`courses`.`class`
										FROM `courses`, 
											`session_student_fees`
										WHERE `courses`.`course_id` = `session_student_fees`.`course_id`
										AND `courses`.`is_subject`='Yes'
										AND `session_student_fees`.`student_id`= '" . $student->student_id . "'
										AND `session_student_fees`.`session_id`= (SELECT session_id FROM sessions WHERE `sessions`.`status`=1)
										GROUP BY `courses`.`class`";
										echo @$this->db->query($query)->result()[0]->class;

										?></td>
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
									<td><i style="color:blue; cursor: pointer;" class="fa fa-edit" aria-hidden="true" data-toggle="modal" data-target="#edit_form" onclick="get_edit_form('<?php echo $student->student_id; ?>')"></i></td>
									<?php for ($installment = 1; $installment <= $max_installment; $installment++) { ?>
										<td style="text-align: center;">
										
										
											<?php if ($installment <= $max_installment_student) { 
												$query = "SELECT 
																COUNT(*) AS total
															FROM
																`session_student_fees`
															WHERE `session_student_fees`.`session_id`='".$session_id."'
															AND `session_student_fees`.`student_id`='".$student->student_id."'
															AND `session_student_fees`.`course_installment_no`='".$installment."' 
															AND `session_student_fees`.`status`=0;
															";
												$status = $this->db->query($query)->result()[0]->total; 			
												?>
												<?php if($status){ ?>
													<i class="fa fa-plus-circle" aria-hidden="true" style="color:red; cursor: pointer;" data-toggle="modal" data-target="#installment_form" onclick="get_installment_payment_form('<?php echo $student->student_id; ?>')"></i>
												
												<?php }else{ ?>
													<i class="fa fa-check-circle" aria-hidden="true" style="color:green; cursor: pointer;" data-toggle="modal" data-target="#installment_form" onclick="get_installment_payment_form('<?php echo $student->student_id; ?>')"></i>
												<?php } ?>	
											<?php } ?>
										</td>
									<?php } ?>

								</tr>
							<?php } ?>
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


<!-- Modal Add New Student From -->
<div id="add_new_student_form" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 60%;">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add New Student</h4>
			</div>
			<div class="modal-body">

				<div class="box-body">

					<?php
					$add_form_attr = array("class" => "form-hori zontal");
					echo form_open_multipart(ADMIN_DIR . "home/save_student_data", $add_form_attr);
					?>
					<div class="col-md-6">
						<div class="form-group">

							<?php
							$label = array(
								"class" => "control-label",
								"style" => "",
							);
							echo form_label($this->lang->line('student_name'), "student_name", $label);      ?>


							<?php

							$text = array(
								"type"          =>  "text",
								"name"          =>  "student_name",
								"id"            =>  "student_name",
								"class"         =>  "form-control",
								"style"         =>  "", "required"	  => "required",
								"title"         =>  $this->lang->line('student_name'),
								"value"         =>  set_value("student_name"),
								"placeholder"   =>  $this->lang->line('student_name')
							);
							echo  form_input($text);
							?>
							<?php echo form_error("student_name", "<p class=\"text-danger\">", "</p>"); ?>


						</div>

					</div>
					<div class="col-md-6">

						<div class="form-group">

							<?php
							$label = array(
								"class" => "control-label",
								"style" => "",
							);
							echo form_label($this->lang->line('father_name'), "father_name", $label);      ?>

							<?php

							$text = array(
								"type"          =>  "text",
								"name"          =>  "father_name",
								"id"            =>  "father_name",
								"class"         =>  "form-control",
								"style"         =>  "", "required"	  => "required", "title"         =>  $this->lang->line('father_name'),
								"value"         =>  set_value("father_name"),
								"placeholder"   =>  $this->lang->line('father_name')
							);
							echo  form_input($text);
							?>
							<?php echo form_error("father_name", "<p class=\"text-danger\">", "</p>"); ?>

						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<?php
							$label = array(
								"class" => "control-label",
								"style" => "",
							);
							echo form_label($this->lang->line('gender'), "gender", $label);
							?>
							<br />
							<?php
							$options = array("male" => "Male", "female" => "Female");
							foreach ($options as $option_value => $options_name) {

								$data = array(
									"name"        => "gender",
									"id"          => "gender",
									"value"       => $option_value,
									"style"       => "", "required"	  => "required",
									"class"       => "uniform"
								);
								echo form_radio($data) . "<label for=\"gender\" style=\"margin-left:10px;\">$options_name</label>   ";
							}
							?>
							<?php echo form_error("gender", "<p class=\"text-danger\">", "</p>"); ?>
						</div>

					</div>


					<div class="col-md-8">
						<div class="form-group">

							<?php
							$label = array(
								"class" => "control-label",
								"style" => "",
							);
							echo form_label($this->lang->line('address'), "address", $label);      ?>


							<?php

							$text = array(
								"type"          =>  "text",
								"name"          =>  "address",
								"id"            =>  "address",
								"class"         =>  "form-control",
								"style"         =>  "", "required"	  => "required", "title"         =>  $this->lang->line('address'),
								"value"         =>  set_value("address"),
								"placeholder"   =>  $this->lang->line('address')
							);
							echo  form_input($text);
							?>
							<?php echo form_error("address", "<p class=\"text-danger\">", "</p>"); ?>
						</div>

					</div>




					<div class="col-md-6">

						<div class="form-group">

							<?php
							$label = array(
								"class" => "control-label",
								"style" => "",
							);
							echo form_label($this->lang->line('mobile_no'), "mobile_no", $label);      ?>


							<?php

							$text = array(
								"type"          =>  "text",
								"name"          =>  "mobile_no",
								"id"            =>  "mobile_no",
								"class"         =>  "form-control",
								"style"         =>  "", "required"	  => "required", "title"         =>  $this->lang->line('mobile_no'),
								"value"         =>  set_value("mobile_no"),
								"placeholder"   =>  $this->lang->line('mobile_no')
							);
							echo  form_input($text);
							?>
							<?php echo form_error("mobile_no", "<p class=\"text-danger\">", "</p>"); ?>
						</div>



					</div>
					<div class="col-md-6">
						<div class="form-group">

							<?php
							$label = array(
								"class" => "control-label",
								"style" => "",
							);
							echo form_label($this->lang->line('phone_no'), "phone_no", $label);      ?>


							<?php

							$text = array(
								"type"          =>  "text",
								"name"          =>  "phone_no",
								"id"            =>  "phone_no",
								"class"         =>  "form-control",
								"style"         =>  "", "required"	  => "required",
								"title"         =>  $this->lang->line('phone_no'),
								"value"         =>  set_value("phone_no"),
								"placeholder"   =>  $this->lang->line('phone_no')
							);
							echo  form_input($text);
							?>
							<?php echo form_error("phone_no", "<p class=\"text-danger\">", "</p>"); ?>
						</div>



					</div>

					<div class="col-md-6">

						<div class="form-group">

							<?php
							$label = array(
								"class" => "control-label",
								"style" => "",
							);
							echo form_label($this->lang->line('class'), "class", $label);      ?>


							<?php

							$text = array(
								"type"          =>  "text",
								"name"          =>  "class",
								"id"            =>  "class",
								"class"         =>  "form-control",
								"style"         =>  "", "required"	  => "required", "title"         =>  $this->lang->line('class'),
								"value"         =>  set_value("class"),
								"placeholder"   =>  $this->lang->line('class')
							);
							echo  form_input($text);
							?>
							<?php echo form_error("class", "<p class=\"text-danger\">", "</p>"); ?>
						</div>



					</div>
					<div class="col-md-6">
						<div class="form-group">

							<?php
							$label = array(
								"class" => "control-label",
								"style" => "",
							);
							echo form_label($this->lang->line('institute'), "institute", $label);      ?>


							<?php

							$text = array(
								"type"          =>  "text",
								"name"          =>  "institute",
								"id"            =>  "institute",
								"class"         =>  "form-control",
								"style"         =>  "", "required"	  => "required", "title"         =>  $this->lang->line('institute'),
								"value"         =>  set_value("institute"),
								"placeholder"   =>  $this->lang->line('institute')
							);
							echo  form_input($text);
							?>
							<?php echo form_error("institute", "<p class=\"text-danger\">", "</p>"); ?>
						</div>



					</div>
					<!-- <div class="col-md-4">
						<div class="form-group">
							<?php
							$label = array(
								"class" => "control-label",
								"style" => "",
							);
							echo form_label($this->lang->line('on_scholarship'), "on_scholarship", $label);
							?>

						<br />
								<?php
								$options = array("Yes" => "Yes", "No" => "No");
								foreach ($options as $option_value => $options_name) {

									$data = array(
										"name"        => "on_scholarship",
										"id"          => "on_scholarship",
										"value"       => $option_value,
										"style"       => "", "required"	  => "required",
										"class"       => "uniform"
									);
									echo form_radio($data) . "<label for=\"on_scholarship\" style=\"margin-left:10px;\">$options_name</label>";
								}
								?>
								<?php echo form_error("on_scholarship", "<p class=\"text-danger\">", "</p>"); ?>
							</div>
						</div> -->
					<div class="col-md-4">

						<div class="form-group">
							<?php
							$label = array(
								"class" => "control-label",
								"style" => "",
							);
							echo form_label($this->lang->line('scholarship_name'), "Scholarship Id", $label);
							?>

							<?php
							echo form_dropdown("scholarship_id", $scholarships, "", "class=\"form-control\" required style=\"\"");
							?>
						</div>
						<?php echo form_error("scholarship_id", "<p class=\"text-danger\">", "</p>"); ?>
					</div>

					<input type="hidden" name="transport" value="No" />
					<!--<div class="col-md-4">



						<div class="form-group">
							<?php
							$label = array(
								"class" => "control-label",
								"style" => "",
							);
							echo form_label($this->lang->line('transport'), "transport", $label);
							?>

							<br />
								<?php
								$options = array("Yes" => "Yes", "No" => "No");
								foreach ($options as $option_value => $options_name) {

									$data = array(
										"name"        => "transport",
										"id"          => "transport",
										"value"       => $option_value,
										"style"       => "", "required"	  => "required",
										"class"       => "uniform"
									);
									echo form_radio($data) . "<label for=\"transport\" style=\"margin-left:10px;\">$options_name</label> ";
								}
								?>
								<?php echo form_error("transport", "<p class=\"text-danger\">", "</p>"); ?>
							</div>
						</div> -->


					<div class="col-md-8">
						<br />
						<?php
						$submit = array(
							"type"  =>  "submit",
							"name"  =>  "submit",
							"value" =>  "Save Student Informaiton",
							"class" =>  "btn btn-primary pull-right",
							"style" =>  ""
						);
						echo form_submit($submit);
						?>

					</div>
					<div style="clear:both;"></div>

					<?php echo form_close(); ?>

				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<!-- Modal Student Admission Form  -->
<div id="admission_form" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 80%;">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Admission Form</h4>
			</div>
			<div class="modal-body" id="admission_form_body">
				<p></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<!-- Modal Installment Payment Form -->
<div id="installment_form" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 80%;">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Installment Payment</h4>
			</div>
			<div class="modal-body" id="installment_form_body">
				<p></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<!-- Modal Student Course Edit form  -->
<div id="edit_form" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 80%;">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Student Session Courses</h4>
			</div>
			<div class="modal-body" id="edit_form_body">
				<p></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>



<!-- Modal Student Course Edit form  -->
<div id="edit_student_info" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 80%;">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Update Student Info</h4>
			</div>
			<div class="modal-body" id="edit_student_info_body">
				<p></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>