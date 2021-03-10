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
				<a href="<?php echo site_url("scholarships/view/"); ?>">Scholarships</a>
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
					  <?php foreach($scholarships as $scholarship): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('scholarship_name'); ?></th>
                <td>
                    <?php echo $scholarship->scholarship_name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('scholarship_detail'); ?></th>
                <td>
                    <?php echo $scholarship->scholarship_detail; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('scholarship_value'); ?></th>
                <td>
                    <?php echo $scholarship->scholarship_value; ?>
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
