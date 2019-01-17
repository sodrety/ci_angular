<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode extends CI_Controller {

	public $nama_tabel = 'data_cuti';

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->library('Zend');
	}

	public function _example_output($output = null)
	{
		$this->load->view('welcome_message',$output);
	}

	public function index()
	{
		
	}

	public function ca_barcode()	
	{
		$id = $this->uri->segment(3);
		//var_dump($id);exit();
	    return $this->get_barcode($id);
	}

	public function get_barcode($code)
    {
        $this->set_barcode($code);
    }

    private function set_barcode($code)
    {
        
        $this->zend->load('Zend/Barcode');
        //generate barcode
        Zend_Barcode::render('code128', 'image', array('text'=>$code), array());
    }

}

/* End of file Barcode.php */
/* Location: ./application/controllers/Barcode.php */