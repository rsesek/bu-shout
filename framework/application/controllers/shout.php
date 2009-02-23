<?php

class Shout extends Controller {

	function Shout()
	{
		parent::Controller();

		$this->load->helper( array('url', 'form', 'utility_helper') );
		$this->load->library( array('form_validation', 'pagination', 'session') );
	}
	
	function admin()
	{
		# handle admin actions
		if($this->session->userdata('username'))
		{
			# logout
			if($this->uri->segment(3) == 'logout')
			{
				$this->session->sess_destroy();
				redirect('shout');
			}
			
			# delete shout (and associated comments, since DB set to cascade deletions)
			if($this->uri->segment(3) == 'delete_shout')
			{
				# ./shout/admin/delete_shout/99
				$shout_id = $this->uri->segment(4);
				
				# remove
				$this->db->delete('submissions', array('id' => $shout_id));
				
				# return
				redirect('shout');
			}
			
			# delete comment
			if($this->uri->segment(3) == 'delete_comment')
			{
				# ./shout/admin/delete_comment/99
				$comment_id = $this->uri->segment(4);

				# find shout for redirect
				$shout_id = $this->db->get_where('comments', array('id' => $comment_id))->row()->submission_id;

				#remove
				$this->db->delete('comments', array('id' => $comment_id));
				redirect('shout/detail/' . $shout_id);
			}
			
			# change password
			if($this->uri->segment(3) == 'new_pass')
			{
				# bad bad bad
				if($_POST['password'] == $_POST['confirm_password'])
				{
					$newPass = md5($_POST['password']);
					$this->db->update('users', array('password'=>$newPass), array('username' => 'admin'));
					$data['pass_notice'] = 'Password changed successfully.<br/>';
				}
				else
				{
					$data['pass_notice'] = 'Password not updated.<br/>';
				}
			}
		}

		# form validation settings
		$rules = array(
               array(
                     'field'   => 'username',
                     'label'   => 'Username',
                     'rules'   => 'required|htmlspecialchars|xss_clean'
                  ),
               array(
                     'field'   => 'password',
                     'label'   => 'Password',
                     'rules'   => 'required|md5'
                  )
            );

    	$this->form_validation->set_rules($rules);

		# valid input
		if ($this->form_validation->run() == TRUE) 
	    {		
	    	# verify humanity and redirect if bot
			if ($_POST['human'] != "") {
				redirect('shout');
			}
			else {
				# remove value from array
				unset($_POST['human']);
			}

			$entered_user = $_POST['username'];
			$entered_pass = $_POST['password'];

			$this->db->select('password');
			$this->db->where('username', $entered_user);
			$query = $this->db->get('users');

			$stored_pass = ($query->num_rows > 0) ? $query->row()->password : '';
			
			$login = TRUE;
		}
		else
		{
			$login = FALSE;
		}

		if($login && $entered_pass == $stored_pass)
		{
			$this->session->set_userdata('username', $entered_user);
			redirect('shout');
		}
		elseif($login)
		{
			#failed
			$data['login_message'] = "Bad username or password";
		}
		else
		{
			$data['login_message'] = '';
		}

		$this->load->view('admin_view', $data);
	}

	function index()
	{
		# form validation settings
		$rules = array(
               array(
                     'field'   => 'title',
                     'label'   => 'Title',
                     'rules'   => 'trim|required|min_length[3]|max_length[60]|htmlspecialchars|xss_clean'
                  ),
               array(
                     'field'   => 'body',
                     'label'   => 'Comment',
                     'rules'   => 'trim|required|min_length[3]|max_length[500]|htmlspecialchars|xss_clean'
                  )
            );

		$this->form_validation->set_message('required', '%s required');
		$this->form_validation->set_message('min_length', '%s too short');
		$this->form_validation->set_message('max_length', '%s too long');
		
    	$this->form_validation->set_rules($rules);
		
		# valid input
		if ($this->form_validation->run() == TRUE) 
	    {

	    	# verify humanity and redirect if bot
			if ($_POST['human'] != ""){
				redirect('shout');
			}			
			else {
				# remove value from array
				unset($_POST['human']);
			}

			# get IP 
			$ip = $_SERVER['REMOTE_ADDR'];
			
			# seed array with post data and extend
			$data = $_POST;
			$data['ip'] = $ip;
			$data['date'] = getDateTime();
			
			# insert
			$this->db->insert('submissions', $data);

			redirect('shout');
		}

		# prep db
		$this->db->select('id, title, body, ip, date');
		$this->db->order_by("date", "desc");
		
		# prep pagination
		$config['per_page'] = '10';
		$config['base_url'] = base_url() . 'shout/more';
		$config['total_rows'] = $this->db->count_all('submissions');
		$config['num_links'] = 2;

		$config['first_link'] = '';
		$config['last_link'] = '';
		$config['prev_link'] = '&larr; Newer';
		$config['next_link'] = 'Older &rarr;';
		$config['full_tag_open'] = "<div id='page_nav_links'>";
		$config['full_tag_close'] = "</div>";

		$this->pagination->initialize($config);
		
		# get uri data
		$data['db_offset'] = $this->uri->segment(3, 0);

		# get(table, limit, offset)
		$data['submissions'] = $this->db->get('submissions', $config['per_page'], $data['db_offset']);
		
		$data['pageNavLinks'] = $this->pagination->create_links();

 		# finally...
		$this->load->view('shout_view', $data);
	}
	
	function detail()
	{
		# form validation settings
		$rules = array(
               array(
                     'field'   => 'body',
                     'label'   => 'Comment',
                     'rules'   => 'trim|required|min_length[3]|max_length[450]|htmlspecialchars|xss_clean'
                  )
            );
            
        
		$this->form_validation->set_message('required', '%s required');
		$this->form_validation->set_message('min_length', '%s too short');
		$this->form_validation->set_message('max_length', '%s too long');

    	$this->form_validation->set_rules($rules);

		# valid input
		if ($this->form_validation->run() == TRUE) 
	    {
	    		
	    	# verify humanity and redirect if bot
			if ($_POST['human'] != ""){
				redirect('shout');
			}
			else {
				# remove value from array
				unset($_POST['human']);
			}

			# get IP
			$ip = $_SERVER['REMOTE_ADDR'];
			
			# seed array with post data and extend
			$data = $_POST;
			$data['ip'] = $ip;
			$data['date'] = getDateTime();
			
			$this->db->insert('comments', $data);

			redirect('shout/detail/' . $data['submission_id']);
		}

		# get comments
		$data['submission_id'] =  $this->uri->segment(3);
		
		# verify that shout exists before continuing
		$this->db->where('id', $data['submission_id']);
		$results = $this->db->count_all_results('submissions');
		if($results < 1) {
			redirect('shout');
		}

		# prep pagination
		$config['per_page'] = '10';
		$config['uri_segment'] = 5;
		$config['base_url'] = base_url() . 'index.php/shout/detail/' . $data['submission_id'] . '/more';
		
		$config['first_link'] = '';
		$config['last_link'] = '';
		$config['prev_link'] = '&larr; Newer';
		$config['next_link'] = 'Older &rarr;';
		$config['full_tag_open'] = "<div id='page_nav_links'>";
		$config['full_tag_close'] = "</div>";

		$this->db->select('id');
		$this->db->where('submission_id', $data['submission_id']);
		$config['total_rows'] = $this->db->count_all_results('comments');
		
		$this->pagination->initialize($config);

		# get uri data
		$data['db_offset'] = $this->uri->segment(5);

		# get(table, limit, offset)
		$this->db->select('id, body, ip, date');
		$this->db->where('submission_id', $data['submission_id']);
		$this->db->order_by("date", "desc");
		$data['comments'] = $this->db->get('comments', $config['per_page'], $data['db_offset']);
		
		$data['before'] = $config['total_rows'];
		$data['after'] = $data['comments']->num_rows;

		$data['pageNavLinks'] = $this->pagination->create_links();
		
		# get the shout's content
		$this->db->select('id, title, body, ip, date');
		$data['shout'] = $this->db->get_where('submissions', array('id' => $data['submission_id']));

		# finally...
		$this->load->view('detail_view', $data);
	}
	
}

/* End of file shout.php */
/* Location: ./framework/application/controllers/shout.php */