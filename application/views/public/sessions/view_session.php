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
				<a href="<?php echo site_url("sessions/view/"); ?>">Sessions</a>
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
					  <?php foreach($sessions as $session): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('session_name'); ?></th>
                <td>
                    <?php echo $session->session_name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('session_detail'); ?></th>
                <td>
                    <?php echo $session->session_detail; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('start_date'); ?></th>
                <td>
                    <?php echo $session->start_date; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('end_date'); ?></th>
                <td>
                    <?php echo $session->end_date; ?>
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
