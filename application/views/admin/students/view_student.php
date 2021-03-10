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
				<a href="<?php echo site_url(ADMIN_DIR."students/view/"); ?>"><?php echo $this->lang->line('Students'); ?></a>
			</li><li><?php echo $title; ?></li>
			</ul>
			<!-- /BREADCRUMBS -->
            <div class="row">
                        
                <div class="col-md-6">
                    <div class="clearfix">
					  <h3 class="content-title pull-left"><?php echo $title; ?></h3>
					</div>
					<div class="description"><?php echo $title; ?></div>
                </div>
                
                <div class="col-md-6">
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."students/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a>
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."students/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
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
	<div class="col-md-12">
	<div class="box border blue" id="messenger">
		<div class="box-title">
			<h4><i class="fa fa-bell"></i> <?php echo $title; ?></h4>
			<!--<div class="tools">
            
				<a href="#box-config" data-toggle="modal" class="config">
					<i class="fa fa-cog"></i>
				</a>
				<a href="javascript:;" class="reload">
					<i class="fa fa-refresh"></i>
				</a>
				<a href="javascript:;" class="collapse">
					<i class="fa fa-chevron-up"></i>
				</a>
				<a href="javascript:;" class="remove">
					<i class="fa fa-times"></i>
				</a>
				

			</div>-->
		</div><div class="box-body">
			
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
                            <tr>
                                <th><?php echo $this->lang->line('Status'); ?></th>
                                <td>
                                    <?php echo status($student->status); ?>
                                </td>
                            </tr>
                         
                      <?php endforeach; ?>
						</tbody>
					  </table>
                      
                      
                      

            </div>
			
			
		</div>
		
	</div>
	</div>
	<!-- /MESSENGER -->
</div>
