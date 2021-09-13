<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {

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
				'profile_model',
				'inventory_model',
				'locations_model',
				'status_model',
				'color_model',
				'logs_model',
				'Export_model'
			)
		);

		// default datas
		// used in every pages
		if ($this->ion_auth->logged_in()) {
			// user detail
			$loggedinuser = $this->ion_auth->user()->row();
			$this->data['user_full_name'] = $loggedinuser->first_name . " " . $loggedinuser->last_name;
		}
	}

	/**
	*	Index Page for this controller.
	*	Showing add new data form and links to another locations.
	*
	*	@return 	void
	*
	*/
	public function index()
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else{
			// set the flash data error message if there is one
			$this->data['message']    = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['loc_list']   = $this->locations_model->get_locations('','','','asc');
			$this->data['brand_list'] = $this->inventory_model->get_brands();

			// $this->data['last_query'] = $this->db->last_query();

			$data['kodeunik'] = $this->inventory_model->cekKode();

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_data/index',$data);
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_data/js');
			$this->load->view('js_script');
		}
	}
	// Index end

	/**
	*	All inventory data.
	*	Showing all inventory data without any filtering.
	* But still using pagination.
	*
	*	@param 		string 		$page
	*	@return 	void
	*
	*/
	public function all($page="")
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			$this->data['data_list']  = $this->inventory_model->get_inventory();

			// Set pagination
			$config['base_url']         = base_url('inventory/all');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);

			// Get datas and limit based on pagination settings
			if ($page=="") { $page = 1; }
			$this->data['data_list'] = $this->inventory_model->get_inventory("",
				$config['per_page'],
				( $page - 1 ) * $config['per_page']
			);
			// $this->data['last_query'] = $this->db->last_query();
			$this->data['pagination'] = $this->pagination->create_links();

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_data/all_data2');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_data/js');
			// $this->load->view('js_script');
		}
		// Logged in
		else{
			$this->data['data_list']  = $this->inventory_model->get_inventory();

			// Set pagination
			$config['base_url']         = base_url('inventory/all');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);

			// Get datas and limit based on pagination settings
			if ($page=="") { $page = 1; }
			$this->data['data_list'] = $this->inventory_model->get_inventory("",
				$config['per_page'],
				( $page - 1 ) * $config['per_page']
			);
			// $this->data['last_query'] = $this->db->last_query();
			$this->data['pagination'] = $this->pagination->create_links();

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_data/all_data');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_data/js');
			// $this->load->view('js_script');
		}
	}
	// All inventory data end
	

	/**
	*	Inventory by location.
	*	Showing inventory location name and total inventory per location.
	* If code is provided, show data based on code.
	*
	*	@param 		string 		$code
	*	@return 	void
	*
	*/
	public function by_location($code="", $page="")
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else{
			// If code is provided, show data based on code
			if ($code!="") {
				// Get location detail
				$location_detail = $this->locations_model->get_locations_by_code($code);
				// If exists, set detailed data. Else redirect back because invalid code
				if (count($location_detail->result())>0) {
					foreach ($location_detail->result() as $loc_data) {
						$this->data['location_name'] = $loc_data->name;
						$this->data['location_desc'] = $loc_data->detail;
					}
				}
				else {
					redirect('inventory/by_location', 'refresh');
				}

				// Show all data based on code
				$this->data['data_list']  = $this->inventory_model->get_inventory_by_location_code(
					$code
				);

				// Set pagination
				$config['base_url']         = base_url('inventory/by_location/'.$code);
				$config['use_page_numbers'] = TRUE;
				$config['total_rows']       = count($this->data['data_list']->result());
				$config['per_page']         = 15;
				$this->pagination->initialize($config);

				// Get datas and limit based on pagination settings
				if ($page=="") { $page = 1; }
				$this->data['data_list'] = $this->inventory_model->get_inventory_by_location_code(
					$code,
					$config['per_page'],
					( $page - 1 ) * $config['per_page']
				);
				// $this->data['last_query'] = $this->db->last_query();
				$this->data['pagination'] = $this->pagination->create_links();

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors()
				: $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/by_location_data');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				// $this->load->view('js_script');
			}
			// Summary
			else {
				// inventory by location summary
				$this->data['summary'] = $this->inventory_model->get_inventory_by_location_summary();

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors()
				: $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/by_location_index');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				$this->load->view('js_script');
			}
		}
	}
	// Inventory by location end

	/**
	*	Inventory detail.
	*	Showing inventory detailed data
	* If code is provided, show data based on code.
	*
	*	@param 		string 		$code
	*	@return 	void
	*
	*/
	public function detail($code)
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else{
			// If code is provided, show data based on code
			if ($code!="") {
				// Show detailed data based on code
				$this->data['data_detail'] = $this->inventory_model->get_inventory_by_code(
					$code
				);
				// Show logs
				$this->data['location_logs'] = $this->logs_model->get_location_log_by_code(
					$code
				);
				$this->data['status_logs'] = $this->logs_model->get_status_log_by_code(
					$code
				);

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors()
				: $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/detail');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				// $this->load->view('js_script');
			}
		}
	}
	// Inventory by category end

	/**
	*	Search
	*	Showing inventory search form.
	*
	* @param 		string
	*	@return 	void
	*
	*/
	public function search($process="")
	{
		$this->data['loc_list']   = $this->locations_model->get_locations('','','','asc');
		$this->data['inv_list']   = $this->inventory_model->get_inventory('','','','asc');
		$this->data['col_list']   = $this->color_model->get_color('','','','asc');

			// input validation rules
		$this->form_validation->set_rules(
			'keyword',
			'Keyword',
			'trim|required'
		);

			// check if there's valid input
		if (isset($_POST) && !empty($_POST)) {
				// validation run
			if ($this->form_validation->run() === TRUE) {
					// set variables for keyword and filters
				$keyword  = $this->input->post('keyword');
				$location = (!empty($this->input->post('location'))) ?
				implode($this->input->post('location'), ",") : "";
				$filters  = array(
					'location_id' => $location
				);
				$this->data['results'] = $this->inventory_model->get_inventory_by_keyword(
					$keyword,
					$filters
				);

				$this->session->set_flashdata('message',
					$this->config->item('success_start_delimiter', 'ion_auth')."Search results with keyword '$keyword'".
					$this->config->item('success_end_delimiter', 'ion_auth')
				);
			}
		}
			// set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() :
		$this->session->flashdata('message');

		$this->load->view('partials/_alte_header', $this->data);
		$this->load->view('partials/_alte_menu');
		$this->load->view('inv_data/search_form');
		$this->load->view('partials/_alte_footer');
		$this->load->view('inv_data/js');
		$this->load->view('js_script');
	}
	// Index end

	/**
	*	Add New Data
	*	If there's data sent, insert
	*	Else, show the form
	*
	*	@return 	void
	*
	*/
	public function add()
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else {
			// input validation rules
			$this->form_validation->set_rules('code', 'Code', 'trim|required|callback__code_check');
			$this->form_validation->set_rules('brand', 'Brand', 'trim|required|addslashes');
			$this->form_validation->set_rules('model', 'Model', 'required');
			$this->form_validation->set_rules('mulai', 'Mulai', 'required');
			$this->form_validation->set_rules('serial_number', 'Serial Number', 'trim|required|addslashes|callback__sn_check');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required|addslashes');
			$this->form_validation->set_rules('descriptions', 'Descriptions', 'trim|addslashes');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {

				// validation run
				if ($this->form_validation->run() === TRUE) {
					// inv data array
					$data = array(
						'code'             => $this->input->post('code'),
						'location_id'      => $this->input->post('location'),
						'brand'            => $this->input->post('brand'),
						'model'            => $this->input->post('model'),
						'serial_number'    => $this->input->post('serial_number'),
						'description'      => $this->input->post('description'),
						'hari'			   => $this->input->post('hari'),
						'tanggal'		   => $this->input->post('tanggal'),
						'mulai'			   => $this->input->post('mulai'),
						'keterangan'	   => $this->input->post('keterangan'),
						'deleted'          => '0',
					);

					// logging array
					$data_location_log = array(
						'code'        => $this->input->post('code'),
						'location_id' => $this->input->post('location'),
					);	

					// check to see if we are inserting the data
					if ($this->inventory_model->insert_data($data)) {
						// Insert logs
						$this->logs_model->insert_location_log($data_location_log);

						// Set message
						$this->session->set_flashdata('message',
							$this->config->item('message_start_delimiter', 'ion_auth')
							."Data Saved Successfully!".
							$this->config->item('message_end_delimiter', 'ion_auth')
						);
						
					}
					else {
						// Set message
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Data Saving Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('inventory/all', 'refresh');
				}

				// validation Failed
				else {
					// set the flash data error message if there is one
					$this->data['message']   = (validation_errors()) ? validation_errors() :
					$this->session->flashdata('message');

					$this->data['stat_list'] = $this->status_model->get_status('','','','asc');
					$this->data['loc_list']  = $this->locations_model->get_locations('','','','asc');
					$this->data['col_list']  = $this->color_model->get_color('','','','asc');
					$this->data['brand_list'] = $this->inventory_model->get_brands();

					$data['kodeunik'] = $this->inventory_model->cekKode();

					$this->load->view('partials/_alte_header', $this->data);
					$this->load->view('partials/_alte_menu');
					$this->load->view('inv_data/add',$data);
					$this->load->view('partials/_alte_footer');
					$this->load->view('inv_data/js');
					$this->load->view('js_script');
				}
			}

			else {
				// $this->data['data_list'] = $this->categories_model->get_categories();
				// set the flash data error message if there is one
				$this->data['message']   = (validation_errors()) ? validation_errors() :
				$this->session->flashdata('message');

				$this->data['stat_list'] = $this->status_model->get_status('','','','asc');
				$this->data['loc_list']  = $this->locations_model->get_locations('','','','asc');
				$this->data['col_list']  = $this->color_model->get_color('','','','asc');
				$this->data['brand_list'] = $this->inventory_model->get_brands();

				$data['kodeunik'] = $this->inventory_model->cekKode();

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/add',$data);
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				$this->load->view('js_script');
			}
		}
	}
	// Add data end

	/**
	*	Callback to check duplicate code
	*
	*	@param 		string 		$code
	*	@return 	bool
	*
	*/
	public function _code_check($code)
	{
		$datas = $this->inventory_model->code_check($code);
		$total = count($datas->result());
		if ($total == 0) {
			return TRUE;
		}
		else {
			$this->form_validation->set_message('_code_check', 'The {field} already exists.');
			return FALSE;
		}
	}
	// End _code_check

	/**
	*	Callback to check duplicate sn
	*
	*	@param 		string 		$sn
	*	@return 	bool
	*
	*/
	public function _sn_check($sn)
	{
		if ($sn=="") {
			return TRUE;
		}

		$datas = $this->inventory_model->sn_check($sn);
		$total = count($datas->result());
		if ($total == 0) {
			return TRUE;
		}
		else {
			$this->form_validation->set_message('_sn_check', 'The {field} already exists.');
			return FALSE;
		}
	}
	// End _code_check

	/**
	*	Callback to check duplicate color name
	*
	*	@param 		string 		$new_color
	*	@return 	bool
	*
	*/
	public function _color_check($new_color)
	{
		$datas = $this->color_model->name_check($new_color);
		$total = count($datas->result());
		if ($total == 0) {
			return TRUE;
		}
		else {
			$this->form_validation->set_message('_color_check', 'The {field} already exists.');
			return FALSE;
		}
	}
	// End _code_check

	/**
	*	Edit Data
	*	If there's data sent, update
	*	Else, show the form
	*
	*	@param 		string 		$code
	*	@return 	void
	*
	*/
	public function edit($code)
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else {
			// input validation rules
			$this->form_validation->set_rules('brand', 'Brand', 'trim|required|addslashes');
			$this->form_validation->set_rules('model', 'Model', 'required');
			$this->form_validation->set_rules('mulai', 'Mulai', 'required');
			$this->form_validation->set_rules('serial_number', 'Serial Number', 'trim|required|addslashes');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required|addslashes');
			$this->form_validation->set_rules('descriptions', 'Descriptions', 'trim|addslashes');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {

				// validation run
				if ($this->form_validation->run() === TRUE) {
					// inv data array
					$data = array(
						'location_id'      => $this->input->post('location'),
						'brand'            => $this->input->post('brand'),
						'model'            => $this->input->post('model'),
						'serial_number'    => $this->input->post('serial_number'),
						'description'      => $this->input->post('description'),
						'hari'			   => $this->input->post('hari'),
						'tanggal'		   => $this->input->post('tanggal'),
						'mulai'			   => $this->input->post('mulai'),
						'keterangan'	   => $this->input->post('keterangan'),
					);

					// check to see if we are updating the data
					if ($this->inventory_model->updating_inventory_by_code($code, $data)) {
						// Set message
						$this->session->set_flashdata('message',
							$this->config->item('message_start_delimiter', 'ion_auth')
							."Inventory Updated!".
							$this->config->item('message_end_delimiter', 'ion_auth')
						);
					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Inventory Update Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('inventory/all', 'refresh');
				}
			}


			// Get data
			$this->data['code']       = $code;
			$this->data['data_list']  = $this->inventory_model->get_inventory_by_code($code);
			$this->data['loc_list']   = $this->locations_model->get_locations('','','','asc');
			$this->data['brand_list'] = $this->inventory_model->get_brands();

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_data/edit');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_data/js');
			$this->load->view('js_script');
		}
	}
	// Edit data end

	/**
	*	Delete Data
	*	If there's data sent, update deleted
	*	Else, redirect to categories
	*
	*	@param 		string 		$id
	*	@return 	void
	*
	*/
	public function delete($code)
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login/inventory', 'refresh');
		}
		// Jika login
		else
		{
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {

				// input validation rules
				$this->form_validation->set_rules('id', 'ID', 'trim|numeric|required');

				// validation run
				if ($this->form_validation->run() === TRUE) {
					
					$this->inventory_model->delete($code);

					// check to see if we are updating the data
					if ($this->inventory_model->update_inventory_by_code($code)) {
						$this->session->set_flashdata('message',
							$this->config->item('message_start_delimiter', 'ion_auth')
							."Inventory Deleted!".
							$this->config->item('message_end_delimiter', 'ion_auth')
						);
					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Inventory Delete Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
				}
			}
			// Always redirect no matter what!
			redirect('inventory/all', 'refresh');
		}
	}
	// Delete data end


	public function createXLS() {
		include APPPATH.'third_party/PHPExcel/Classes/PHPExcel.php';
		// create file name
		$fileName = 'PeminjamanLab.xlsx';  
		// load excel library
		$data_list  = $this->inventory_model->get_inventory();

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
        // set Header
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Kode Peminjaman');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Nama Peminjam');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Tujuan Peminjaman');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'No. HP Peminjam');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Hari'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Tanggal');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Jam Mulai');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Jam Selesai');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Laboratorium');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Keterangan');     

        // set Row
		$rowCount = 2;
		foreach ($data_list->result() as $data) 
		{
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $data->code);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $data->brand);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $data->description);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $data->serial_number);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $data->hari);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $data->tanggal);
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $data->mulai);
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $data->model);
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $data->location_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $data->keterangan);
			$rowCount++;
		}

		// Set width kolom
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30); // Set width kolom B
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17); // Set width kolom D
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10); // Set width kolom E
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13); // Set width kolom A
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13); // Set width kolom B
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13); // Set width kolom C
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30); // Set width kolom D
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25); // Set width kolom E

         // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-5);
    	// Set orientasi kertas jadi LANDSCAPE
    $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $objWriter->save($fileName);
		// download file
    header("Content-Type: application/vnd.ms-excel");
    redirect(site_url().$fileName);              
}
}

/* End of Inventory.php */