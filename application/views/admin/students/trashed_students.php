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
                
                    <table class="table table-table-bordered">
						<thead>
						  <tr>
							<th><?php echo $this->lang->line('student_name'); ?></th>
<th><?php echo $this->lang->line('father_name'); ?></th>
<th><?php echo $this->lang->line('gender'); ?></th>
<th><?php echo $this->lang->line('address'); ?></th>
<th><?php echo $this->lang->line('mobile_no'); ?></th>
<th><?php echo $this->lang->line('phone_no'); ?></th>
<th><?php echo $this->lang->line('class'); ?></th>
<th><?php echo $this->lang->line('institute'); ?></th>
<th><?php echo $this->lang->line('on_scholarship'); ?></th>
<th><?php echo $this->lang->line('scholarship_id'); ?></th>
<th><?php echo $this->lang->line('scholarship_value'); ?></th>
<th><?php echo $this->lang->line('transport'); ?></th>
<th><?php echo $this->lang->line('scholarship_name'); ?></th>
                            <th><?php echo $this->lang->line('Action'); ?></th>
						  </tr>
						</thead>
						<tbody>
					  <?php foreach($students as $student): ?>
                         <tr>
                            
                            
            <td>
                <?php echo $student->student_name; ?>
            </td>
            <td>
                <?php echo $student->father_name; ?>
            </td>
            <td>
                <?php echo $student->gender; ?>
            </td>
            <td>
                <?php echo $student->address; ?>
            </td>
            <td>
                <?php echo $student->mobile_no; ?>
            </td>
            <td>
                <?php echo $student->phone_no; ?>
            </td>
            <td>
                <?php echo $student->class; ?>
            </td>
            <td>
                <?php echo $student->institute; ?>
            </td>
            <td>
                <?php echo $student->on_scholarship; ?>
            </td>
            <td>
                <?php echo $student->scholarship_id; ?>
            </td>
            <td>
                <?php echo $student->scholarship_value; ?>
            </td>
            <td>
                <?php echo $student->transport; ?>
            </td>
            <td>
                <?php echo $student->scholarship_name; ?>
            </td>
                            
                            <td>
                                <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."students/view_student/".$student->student_id."/".$this->uri->segment(3)); ?>"><i class="fa fa-eye"></i> </a>
                                <a class="llink llink-restore" href="<?php echo site_url(ADMIN_DIR."students/restore/".$student->student_id."/".$this->uri->segment(3)); ?>"><i class="fa fa-undo"></i></a>
                                <a class="llink llink-delete" href="<?php echo site_url(ADMIN_DIR."students/delete/".$student->student_id."/".$this->uri->segment(3)); ?>"><i class="fa fa-times"></i></a>
                            </td>
                         </tr>
                      <?php endforeach; ?>
						</tbody>
					  </table>
                      <?php echo $pagination; ?>

            </div>
			
			
		</div>
		
	</div>
	</div>
	<!-- /MESSENGER -->
</div>
