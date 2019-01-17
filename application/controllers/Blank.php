<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blank extends CI_Controller {

	public function index()
	{
		$this->load->library('pdf');


	  	$this->pdf->load_view('mypdf');
	  	$this->pdf->render();


	  	$this->pdf->stream("welcome.pdf");
	}

	function mypdf(){


	$this->load->library('pdf');


  	$this->pdf->load_view('mypdf');
  	$this->pdf->render();


  	$this->pdf->stream("welcome.pdf");
   }
}
