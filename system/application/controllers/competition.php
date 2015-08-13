<?php

# Controller: Competition
# Author: kaushtuvgurung@gmail.com

class Competition extends Controller {

	function __construct() {
		parent::Controller();
		$cur_user = $this->session->userdata('userloggedin');													
		if($cur_user['level'] == 2)
		{
			redirect(TRADE_SITE);
		}
		$this->load->model('Content_model');
		$this->load->model('Product_model');
		$this->load->model('Category_model');
		$this->load->model('System_model');
		$this->load->model('Cart_model');
		$this->load->model('Customer_model');
		$this->load->model('Order_model');
		$this->load->model('User_model');
		$this->load->model('Subscribe_model');
		$this->load->model('Menu_model');
		$this->load->model('Gallery_model');
		$this->load->model('Position_model');
		
		$this->load->model('Competition_entry_model');
		$this->load->model('Competition_invites_model');
		$this->load->model('Competition_pool_model');
		#error_reporting(E_ALL);

	}
	
	function index()
	{
		redirect('competition/entry');	
	}
	
	function entry($token = "") {

		$cur = $this->System_model->get_currency();
		
		$data['usa'] = $cur['usa'];
		$data['eur'] = $cur['eur'];
		$data['gbp'] = $cur['gbp'];
		$data['jpy'] = $cur['jpy'];
		
		$data['states'] = $this->System_model->get_states();
		$data['countries'] = $this->System_model->get_countries();
		$data['token'] = $token;
		
		$this->load->view('common/header',$data);
		$this->load->view('competition/main_view',$data);
		$this->load->view('common/footer',$data);
	}
	
	function enter_competition()
	{
		$input = $_POST;

		# validate data
		if(!$input['firstname'] || !$input['lastname'] || !$input['email'] || !$input['state'] || !$input['country']){
			
			echo json_encode(
					array(
							'status' => 'error',
							'msg' => 'One or more required field is missing'
						)
				);
			return;
			
		}
		if(!filter_var($input['email'],FILTER_VALIDATE_EMAIL)){
			echo json_encode(
					array(
							'status' => 'error',
							'msg' => 'Invalid email'
						)
				);
			return;	
		}
		
		

		# if duplicate - checks by email
		$duplicate = $this->Competition_entry_model->check_duplicate($input['email']);
		if($duplicate){
			# even if the main entry is duplicate we do want them to send invites
			# however they don't get added to the competition pool 
			$this->_insert_invites($duplicate['entry_id'],$input);	
		}else{
			# if new entry add to competition entry
			# add to competition pool
			# add invites and send invitation 
			$entry_id = $this->_insert_new_competition($input);
			if($entry_id){
				$this->_insert_competition_pool($entry_id,$input);
				$this->_insert_invites($entry_id,$input);	
				
				# send confirmation
				# $this->_send_confirmation($entry_id);
			}
		}
		
		# notify user 
		echo json_encode(
					array(
							'status' => 'ok',
							'msg' => 'Succesful'
						)
				);
		
	}
	
	function _insert_new_competition($data)
	{
		$entry_data = array(
							'firstname' => $data['firstname'],
							'lastname' => $data['lastname'],
							'email' => $data['email'],
							'state' => $data['state'],
							'country' => $data['country'],
							'user_token' => md5(SALT.$data['email'])
						);
		
			
		# check token to see if this entry was due to an invitation.
		if($data['token']){
			$inviter = $this->Competition_entry_model->get_entry_by_field('user_token',$data['token']);
			if($inviter){
				$entry_data['inviter_token'] = $data['token'];
				
				# add inviter to the competition pool
				$this->_insert_competition_pool($inviter['entry_id'],array('email' => $inviter['email']));
			}
		}
		
		$customer = $this->Customer_model->identify_by_email($data['email']);
		if($customer){
			$entry_data['customer_id'] = $customer['id'];
		}
		
		# insert entry	
		return $this->Competition_entry_model->insert($entry_data);
		
		# add to subscriber list if this is a new email
		if(!$this->Subscribe_model->exist($email)){;
			$this->Subscribe_model->add(array('email' => $data['email']));	
		}
	}

	function _insert_invites($entry_id,$data)
	{
		$friend_names = $data['friend_name'];
		$friend_emails = $data['friend_email'];
		$count = 0;
		
		if(count($friend_names) && count($friend_emails)){
			foreach($friend_names as $key => $val){
				
				# if not null
				if(trim($val) && trim($friend_emails[$key])){
					# if email is valid 
					# add to database and send email to friend
					if(filter_var($friend_emails[$key],FILTER_VALIDATE_EMAIL)){
						$invitee_data = array(
									'entry_id' => $entry_id,
									'invitee_name' => $val,
									'invitee_email' => $friend_emails[$key],
									);	
						$this->Competition_invites_model->insert($invitee_data);
						$count++;
						
						# send notification to friend
						$this->_notify_friend($entry_id,$invitee_data);
					}
				}
			}
		}
		return $count;
	}
	
	function _insert_competition_pool($entry_id,$data)
	{
		$pool_data = array(
						'entry_id' => $entry_id,
						'email' => $data['email']
						);	
		return $this->Competition_pool_model->insert($pool_data);
	}
	
	function _send_confirmation($entry_id)
	{
			
	}
	
	function _notify_friend($entry_id,$invitee)
	{
		# for testing purpose in localhost
		#$this->_local_email($entry_id,$invitee);
		#return;
		
		$inviter = $this->Competition_entry_model->get_entry($entry_id);
		if($inviter){
			
			$email_data = array(
							'invitee_firstname' => $invitee['invitee_name'],
							'inviter_firstname' => $inviter['firstname'],
							'token' => $inviter['user_token']
							);
			
			
			$email_content = $this->load->view('competition/invitation_email', $email_data , true);
			
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);		
			$this->email->from('info@bared.com.au', $inviter['firstname'] . ' ' . $inviter['lastname']);
			$this->email->to($invitee['invitee_email']);
			#$this->email->to('kaushtuv@propagate.com.au');
			$this->email->subject('The Big Bared Winter Clearance Sale!');
			$this->email->message($email_content);
			$this->email->send();
			$this->email->clear();
		}
	}
	
	function _local_email($entry_id,$invitee){
		$inviter = $this->Competition_entry_model->get_entry($entry_id);
		if($inviter){
				
			$email_data = array(
							'invitee_firstname' => $invitee['invitee_name'],
							'inviter_firstname' => $inviter['firstname'],
							'token' => $inviter['user_token']
							);

			
			
			$email_content = $this->load->view('competition/invitation_email', $email_data , true);
			
			$config = array(
						  'protocol' => 'smtp',
						  'smtp_host' => 'ssl://smtp.googlemail.com',
						  'smtp_port' => 465,
						  'smtp_user' => 'propagate.au@gmail.com', // change it to yours
						  'smtp_pass' => '', // change it to yours
						  'mailtype' => 'html',
						  'charset' => 'iso-8859-1',
						  'wordwrap' => TRUE
						);
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('propagate.au@gmail.com', $inviter['firstname'] . ' ' . $inviter['lastname']); // change it to yours
			$this->email->to('kaushtuv@propagate.com.au');// change it to yours
			$this->email->subject($invitee['invitee_name'] . ' The Big Bared Winter Clearance Sale!');
			$this->email->message($email_content);
			$this->email->send();
		}
	}
	
	
	
}

?>