<section class="title">
	<h4><?php echo lang('ie:import'); ?></h4>
</section>

<section class="item">

	<section class="content">

		<?php echo form_open_multipart($this->uri->uri_string().'/upload', 'class="upload"'); ?>
			
			<div class="form_inputs">
		
				<ul>
					<li>
		            	<p><?php echo lang('ie:import_files_inst'); ?></p>
						<div class="input"><input type="file" name="userfile" size="20" /></div>
					</li>
				</ul>
			
			</div>
			
			<div class="buttons">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('import'))); ?>
			</div>

		<?php echo form_close(); ?>

	</section>

</section>