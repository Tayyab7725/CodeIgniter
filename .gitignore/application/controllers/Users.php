<?php
	class Users extends CI_Controller{

		//Register User
		public function register(){
			$data['title'] = 'Sign Up';

			$this->form_validation->set_rules('name', 'Name', 'required');


			$this->form_validation->set_rules('username', 'Username', 'required|callback_check_username_exists');

			$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');


			//$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/register', $data);
				$this->load->view('templates/footer');
			}
			else{

				//Encrypt Password to md5
				$enc_password = md5($this->input->post('password'));

				$this->user_model->register($enc_password);

				//Set Flash Message (Session Library Added in Autoload)
				$this->session->set_flashdata('user_registered', 'You are now Registered and can Log In');

				redirect('posts');
			}

		}


		//LogIn User

		public function login(){
			$data['title'] = 'Sign In';

			$this->form_validation->set_rules('username', 'Username', 'required');

			$this->form_validation->set_rules('password', 'Password', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/login', $data);
				$this->load->view('templates/footer');
			}
			else{

				//Get Username
				$username = $this->input->post('username');
				//Get and Encrypt Password to match encrypted password
				$password = md5($this->input->post('password'));

				//Login User Verify From Model Class
				$user_id = $this->user_model->login($username, $password);

				if($user_id){
					//Create Session

					$user_data = array(
						'user_id' => $user_id,
						'username' => $username,
						'logged_in' => true
					);

					$this->session->set_userdata($user_data);

					//Set Flash Message (Session Library Added in Autoload)
				$this->session->set_flashdata('user_loggedin', 'You are now Logged In');

				redirect('posts');
				}
				else{
					//Set Flash Message (Session Library Added in Autoload)
				$this->session->set_flashdata('login_failed', 'Invalid Login Information');

				redirect('users/login');
				}
				

				//Set Flash Message (Session Library Added in Autoload)
				$this->session->set_flashdata('user_loggedin', 'You are now Logged In');

				redirect('posts');
			}

		}

		//Log Out User
		public function logout(){
			//Unset User Data
			$this->session->unset_userdata('logged_in');
			$this->session->unset_userdata('user_id');
			$this->session->unset_userdata('username');

			//Set Flash Message (Session Library Added in Autoload)
				$this->session->set_flashdata('user_loggedout', 'You are now Logged Out');
 
				redirect('users/login');
		}


		// Check if username exists
		public function check_username_exists($username){
			$this->form_validation->set_message('check_username_exists', 'That username is taken. Please choose a different one');
			if($this->user_model->check_username_exists($username)){
				return true;
			} else {
				return false;
			}
		}

		// Check if email exists
		public function check_email_exists($email){
			$this->form_validation->set_message('check_email_exists', 'That email is taken. Please choose a different one');
			if($this->user_model->check_email_exists($email)){
				return true;
			} else {
				return false;
			}
		}

	}