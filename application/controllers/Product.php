<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('product_model','product');
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('product_view');
	}

	public function ajax_list()
	{
		$list = $this->product->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $product) 
		{
			$no++;
			$row = array();
			$row[] = $product->name;
			$row[] = $product->price;
			$row[] = $product->category;
			$row[] = $product->description;
			$row[] = '<img src="'.base_url('uploads/'.$product->image).'" width="50"/>';

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_product('."'".$product->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_product('."'".$product->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->product->count_all(),
						"recordsFiltered" => $this->product->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->product->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$config['upload_path']   = './uploads/'; 
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['max_size']      = 2048; 
		$config['encrypt_name']  = TRUE; 
	
		$this->load->library('upload', $config);
	
		$image_name = '';
		if (!empty($_FILES['image']['name'])) {
			if ($this->upload->do_upload('image')) {
				$uploadData = $this->upload->data();
				$image_name = $uploadData['file_name'];
				$resize_config['image_library'] = 'imagemagick';
				$resize_config['library_path']  = '/usr/bin/convert'; // Path to ImageMagick (varies by server)
				$resize_config['source_image']  = './uploads/' . $image_name;
				$resize_config['create_thumb']  = FALSE;
				$resize_config['maintain_ratio'] = TRUE;
				$resize_config['width']         = 300;
				$resize_config['height']        = 300;

				$this->load->library('image_lib', $resize_config);

				if (!$this->image_lib->resize()) {
					echo json_encode(array("status" => FALSE, "error" => $this->image_lib->display_errors()));
					return;
				}
			} else {
				echo json_encode(array("status" => FALSE, "error" => $this->upload->display_errors()));
				return;
			}
		}
		$data = array(
				'name' => $this->input->post('name'),
				'price' => $this->input->post('price'),
				'category' => $this->input->post('category'),
				'description' => $this->input->post('description'),
				'image'     => $image_name,
			);
		$insert = $this->product->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$config['upload_path']   = './uploads/'; 
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['max_size']      = 2048; 
		$config['encrypt_name']  = TRUE; 
	
		$this->load->library('upload', $config);
	
		$image_name = '';
		if (!empty($_FILES['image']['name'])) {
			if ($this->upload->do_upload('image')) {
				$uploadData = $this->upload->data();
				$image_name = $uploadData['file_name'];
				$resize_config['image_library'] = 'imagemagick';
				$resize_config['library_path']  = '/usr/bin/convert'; // Path to ImageMagick (varies by server)
				$resize_config['source_image']  = './uploads/' . $image_name;
				$resize_config['create_thumb']  = FALSE;
				$resize_config['maintain_ratio'] = TRUE;
				$resize_config['width']         = 300;
				$resize_config['height']        = 300;

				$this->load->library('image_lib', $resize_config);

				if (!$this->image_lib->resize()) {
					echo json_encode(array("status" => FALSE, "error" => $this->image_lib->display_errors()));
					return;
				}
			} else {
				echo json_encode(array("status" => FALSE, "error" => $this->upload->display_errors()));
				return;
			}
		}
		$data = array(
				'name' => $this->input->post('name'),
				'price' => $this->input->post('price'),
				'category' => $this->input->post('category'),
				'description' => $this->input->post('description'),
				'image'     => $image_name,
			);
		$this->product->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->product->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

}
