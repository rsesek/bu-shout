<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Shout</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css" />
<link rel="alternate" type="application/atom+xml" title="Shout @ BU - Atom" href="<?php echo base_url() ?>shout/atom" />
</head>
<body>

<div id="header"></div>
<div id="pane">

<div id="left_col">

	<div id="left_top" class="rounded">
		<?php echo anchor('shout', "<img src='" . base_url() . "css/logo.gif' />"); ?>
	</div>
	<div id="left_bottom" class="rounded">
	
	<div class="notice">Something on your mind?  Shout it.</div>
	<?php
		echo form_open('shout', array('id' => 'shout_form'));
		echo form_label('Title', 'title', array('class' => 'form_label') );
		echo form_error('title', "<span class='error_msg'>", '</span>');
		echo "<br />";
		echo form_input( array('name' => 'title', 'value' => set_value('title'), 'cols' => '60', 'class' => 'form_input' ) );
		echo "<br />";
		echo form_label('Comment', 'body', array('class' => 'form_label') );
		echo form_error('body', "<span class='error_msg'>", '</span>');
		echo "<br />";
		echo form_textarea( array('name' => 'body', 'value' => set_value('body'), 'cols' => '60', 'class' => 'form_textarea') );
		echo "<br />";
		echo form_input( array('name' => 'human', 'id' => 'human') );
		echo form_submit( array('value' => 'Shout It') );
		echo form_close();
	?>
	</div>
</div>

<div id="right_col" class="rounded">
	<?php if($submissions->num_rows() > 0): ?>
		<?php foreach($submissions->result() as $submission):?><?php if($this->session->userdata('username')){echo anchor('/shout/admin/delete_shout/' . $submission->id, 'delete', array('class'=>'admin_action'));}?><div class="rounded shout"><div class="rounded shout_border"><div class="rounded shout_content"><a href="<?php echo base_url() . 'shout/detail/' . $submission->id;?>" class="shout_link"><span class="title"><?php echo $submission->title;?></span><span class="date"><?php echo intval($submission->count) ?> <?php echo ($submission->count > 1 || $submission->count == 0) ? 'comments' : 'comment' ?>, last:<br /><?php echo get_friendly_date(strtotime($submission->lastpost));?></span></a></div></div></div><?php endforeach;?>
	<?php endif; ?>
	<?php echo $pageNavLinks ?>

<?php
	if($this->session->userdata('username'))
	{
		echo anchor('/shout/admin', 'Admin Page') . '&nbsp;&nbsp;&nbsp;&nbsp;' . anchor('/shout/admin/logout', 'Logout');
		echo "<br /><br />";
	}
?>
</div>
</div>
<div id="footer"></div>

<div id="footer_text">
	Opinions expressed on this site do not represent those of the
	<?php echo anchor('http://www.bustudentunion.com/', 'BU Student Union'); ?>.
</div>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-6018923-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>