<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Disbursements extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata("sessUserID")){
			redirect("auth/login");
			return;
		}
		$this->load->model("ModelDisbursement");
	}

	public function index()
	{
		$data["date"]	= date("d/m/Y");
		$data["date2"]	= date("d/m/Y");
		$data["module"] = "Disbursements";
		$data["datadisburse"] = $this->ModelDisbursement->getDisbursementAPI();
		$data["email"]	= $this->session->userdata("sessEmail");
		$this->layout->content("index",$data);
	}
}
