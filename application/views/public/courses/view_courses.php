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
				<a href="<?php echo site_url("courses/view/"); ?>">Courses</a>
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
					  <?php foreach($courses as $courses): ?>
                         
                         
            <tr>
                <th><?php echo $this->lang->line('class'); ?></th>
                <td>
                    <?php echo $courses->class; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('course_name'); ?></th>
                <td>
                    <?php echo $courses->course_name; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('course_detail'); ?></th>
                <td>
                    <?php echo $courses->course_detail; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('course_fee'); ?></th>
                <td>
                    <?php echo $courses->course_fee; ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('is_subject'); ?></th>
                <td>
                    <?php echo $courses->is_subject; ?>
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
