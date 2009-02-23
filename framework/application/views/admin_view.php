<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Shout: Admin</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css" />
</head>
<body>

<h1>Admin Panel</h1>

<p><?php echo anchor('shout', 'Back to the latest shouts'); ?></p>
<div id="left_col">

	<div id="left_bottom" class="rounded">
	<br />Yeah, this page is fugglesworthy, but you should only be here if you're an admin.<br /><br /><br />
	<?php 
		if($this->session->userdata('username'))
		{
			echo anchor('/shout/admin/logout', 'Logout');
			echo '<br/><br/><br/>';
			echo "Right, so, you're an admin.  Don't be dumb when you choose a new password.  Make it at least four characters long and remember it.<br/><br/>";
			if(isset($pass_notice)){echo $pass_notice;}
			echo 'Change your password:</br>';
			echo form_open('shout/admin/new_pass');
			echo form_label('New password ', 'new_password');
			echo form_password('password');
			echo form_label('Confirm password ', 'confirm_password');
			echo form_password('confirm_password');
			echo form_submit('submit', 'Change Password');
			echo form_close();
		}
		else
		{
			$form_attributes = array('id' => 'comment_form');
	
			echo $login_message;
			echo "<br />";
			echo validation_errors();
			echo form_open('shout/admin');
			echo form_label('Username ', 'username', array('class' => 'form_label'));
			echo form_input( array('name'=>'username', 'value'=>set_value('username'), 'class' => 'form_input' ) );
			echo "<br />";
			echo form_label('Password ', 'password');
			echo form_password('password');
			echo "<br />";
			echo form_input( array('name'=>'human', 'id'=>'human') );
			echo form_submit('submit', 'Login');
			echo form_close();
		}
	?>
	</div>
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