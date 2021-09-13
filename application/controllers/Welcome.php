<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// set error delimeters
			$this->form_validation->set_error_delimiters(
			$this->config->item('error_start_delimiter', 'ion_auth'),
			$this->config->item('error_end_delimiter', 'ion_auth')
		);

		// model
		$this->load->model(
			array(
				'inventory_model',
				'locations_model',
			)
		);

		// default datas
		// used in every pages
		if ($this->ion_auth->logged_in()) {
			// user detail
			$loggedinuser = $this->ion_auth->user()->row();
			$this->data['user_full_name'] = $loggedinuser->first_name . " " . $loggedinuser->last_name;
		}
		$this->data['dummy'] = "";
	}

	public function index(){
		// inventory by category summary
		$this->data['total_inventory'] = count($this->inventory_model->get_inventory()->result());
		$this->data['total_location']  = count($this->locations_model->get_locations()->result());

		$this->load->view('partials/_alte_header', $this->data);
		$this->load->view('partials/_alte_menu');
		$this->load->view('welcome/welcome_message');
		$this->load->view('partials/_alte_footer');
		$this->load->view('welcome/js');
	}
}
