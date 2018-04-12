<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata("sessUserID")){
			redirect(base_url()."auth/login");
			return;
		}
		$this->load->model("ModelUser");
	}

	public function cash()
	{
		$vdt = date("Y-m-d");
		$vdt2 = date("Y-m-d");
		if($this->session->userdata("vdt") != ""){
			$vdt = $this->session->userdata("vdt");
		}
		if($this->session->userdata("vdt2") != ""){
			$vdt2 = $this->session->userdata("vdt2");
		}
		$companyID 	= $this->session->userdata("sessCompanyID");
		list($jmltransaction,$jmlamount)=$this->ModelUser->getTransactions($companyID,$vdt,$vdt2);
		$data["balance"] = $this->ModelUser->getBalance($companyID);
		$data["income"]	= $this->ModelUser->getIncome($companyID,$vdt,$vdt2);
		$data["transactions"]	= number_format($jmltransaction);
		$data["outcome"]	= number_format($jmlamount);
		$data["date"]	= date("Y-m-d", strtotime($vdt));
		$data["date2"]	= date("Y-m-d", strtotime($vdt2));
		$data["module"] = "Cash Account";
		$data["email"]	= $this->session->userdata("sessEmail");
		$this->layout->content("cash",$data);
	}

	function checkData(){
		$tmpvdt 	= $_POST["vdt"];
		$tmpvdt2 	= $_POST["vdt2"];
		$vdt		= date("Y-m-d", strtotime($tmpvdt));
		$vdt2		= date("Y-m-d", strtotime($tmpvdt2));
		$this->session->set_userdata("vdt",$vdt);
		$this->session->set_userdata("vdt2",$vdt2);
		$companyID 	 = $this->session->userdata("sessCompanyID");
		list($jmltransaction,$jmlamount)=$this->ModelUser->getTransactions($companyID,$vdt,$vdt2);

		$data 	= array(
			"total_transaction"	=> number_format($jmltransaction),
			"outcome"			=> "Rp ".number_format($jmlamount)
		);

		echo json_encode($data);
	}
	
}
