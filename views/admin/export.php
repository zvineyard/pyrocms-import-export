<section class="title">
	<h4><?php echo lang('ie:site'); ?></h4>
</section>

<section class="item">
	<?php echo form_open(); ?>
	<p><?php echo lang('ie:choose_site'); ?></p>
	<?php //echo form_dropdown('site', $sites, $this->input->post('site')); ?>
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('export'))); ?>
	<?php echo form_close();?>
</section>