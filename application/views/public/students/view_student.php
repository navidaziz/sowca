<!-- PAGE HEADER-->
<div class="breadcrumb-box">
  <div class="container">
			<!-- BREADCRUMBS -->
			<ul class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?php echo site_url("Home"); ?>">Home</a>
					<span class="divider">/</span>
				</li><li>
				<i class="fa fa-table"></i>
				<a href="<?php echo site_url("students/view/"); ?>">Students</a>
				<span class="divider">/</span>
			</li><li ><?php echo $title; ?> </li>
				</ul>
			</div>
		</div>
		<!-- .breadcrumb-box --><section id="main">
			  <header class="page-header">
				<div class="container">
				  <h1 class="title"><?php echo $title; ?></h1>
				</div>
			  </header>
			  <div class="container">
			  <div class="row">
			  <?php $this->load->view(PUBLIC_DIR."components/nav"); ?><div class="content span9 pull-right">
            <div class="table-responsive">
                
                    <table class="table">
						<thead>
						  
						</thead>
						<tbody>
					  <?php foreach($students as $student): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('student_name'); ?></th>
                <td>
                    <?php echo $student->student_name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('father_name'); ?></th>
                <td>
                    <?php echo $student->father_name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('gender'); ?></th>
                <td>
                    <?php echo $student->gender; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('address'); ?></th>
                <td>
                    <?php echo $student->address; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('mobile_no'); ?></th>
                <td>
                    <?php echo $student->mobile_no; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('phone_no'); ?></th>
                <td>
                    <?php echo $student->phone_no; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('class'); ?></th>
                <td>
                    <?php echo $student->class; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('institute'); ?></th>
                <td>
                    <?php echo $student->institute; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('on_scholarship'); ?></th>
                <td>
                    <?php echo $student->on_scholarship; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('scholarship_id'); ?></th>
                <td>
                    <?php echo $student->scholarship_id; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('scholarship_value'); ?></th>
                <td>
                    <?php echo $student->scholarship_value; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('transport'); ?></th>
                <td>
                    <?php echo $student->transport; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('scholarship_name'); ?></th>
                <td>
                    <?php echo $student->scholarship_name; ?>
                </td>
            </tr>
                         
                      <?php endforeach; ?>
						</tbody>
					  </table>
                      
                      
                      

            </div>
			
			</div>
		</div>
	 </div>
  <!-- .container --> 
</section>
<!-- #main -->
