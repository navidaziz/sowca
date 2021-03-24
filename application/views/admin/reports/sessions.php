
<div class="row">
	<div class="col-sm-12">
		<div class="page-header" style="min-height: 0px;">
			<!-- STYLER -->
			
			<!-- /STYLER -->
			<!-- BREADCRUMBS -->
			<ul class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
				</li><li><?php echo $title; ?></li>
			</ul>
		
            
			
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
                
                    <table class="table table-bordered">
						<thead>
						  <tr>
                          
							<th><?php echo $this->lang->line('session_name'); ?></th>
<th><?php echo $this->lang->line('session_detail'); ?></th>
<th><?php echo $this->lang->line('start_date'); ?></th>
<th><?php echo $this->lang->line('end_date'); ?></th><th><?php echo $this->lang->line('Status'); ?></th><th><?php echo $this->lang->line('Action'); ?></th>
                        </tr>
						</thead>
						<tbody>
					  <?php foreach($sessions as $session): ?>
                         
                         <tr>
                         
                             
            <td>
                <?php echo $session->session_name; ?>
            </td>
            <td>
                <?php echo $session->session_detail; ?>
            </td>
            <td>
                <?php echo $session->start_date; ?>
            </td>
            <td>
                <?php echo $session->end_date; ?>
            </td>
                                <td>
                                   <?php  if($session->status == 1){  echo "Current Session";  } ?>
                                </td>
                                <td>
                                <a class="llink llink-view" href="<?php echo site_url(ADMIN_DIR."reports/class_report/".$session->session_id."/".$this->uri->segment(4)); ?>"><i class="fa fa-eye"></i> </a>
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
