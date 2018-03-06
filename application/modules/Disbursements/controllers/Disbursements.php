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
	
	function deleteBatch(){
		$arrID 	= $_POST["val"];
		$response 	= $this->ModelDisbursement->deleteBatch($arrID);

		echo $response;
		return;
	}

	function approveBatch(){
		$arrID 	= $_POST["val"];
		$response 	= $this->ModelDisbursement->approveBatch($arrID);

		echo $response;
		return;
	}

	function checkPin(){
		$pin 	= $this->aes->encrypt_aes256($_POST["pin"]);
		$response 	= $this->ModelDisbursement->checkPin($pin);
		
		echo $response;
		return;
	}

	public function index()
	{
		$tab		= "need";
		$content 	= $this->needApprove();
		if($this->session->userdata("tab_disbursement") != ''){
			$tab		= $this->session->userdata("tab_disbursement");
			if($tab == "need"){
				$content = $this->needApprove();
			}else{
				$content 	= $this->approved();
			}
		}
		$data["date"]	= date("d/m/Y");
		$data["date2"]	= date("d/m/Y");
		$data["module"] = "Batch Disbursements";
		$data["tab"]	= $tab;
		$data["content"] = $content;
		$data["email"]	= $this->session->userdata("sessEmail");
		$this->layout->content("index",$data);
	}
	
	function uploadform(){
		$form = $this->load->view("uploadform");
		echo $form;
	}

	function detailBatch(){
		$transaction_id 	= $_POST["transaction_id"];
		$data				= $this->ModelDisbursement->getTransaction($transaction_id);
		list($reference,$fullName,$created_dttm,$status)=$data;
		$table 	= $this->ModelDisbursement->getTransactionDetail($transaction_id);
		$ret = '
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-action">
					<div class="col s1 m1 l1" id="tab">
						<a href="'.base_url().'disbursements"><i class="material-icons">keyboard_backspace</i></a>
					</div>
					<div class="col s6 m6 l3" id="tab" style="margin-top:-5px;padding-bottom:10px">
						<h6>Reference : <b>'.$reference.'</b></h6>
					</div>
					<div class="col s6 m6 l5" id="tab" style="margin-top:-5px;padding-bottom:10px">
						<h6>Uploaded By : <b>'.$fullName.'</b> On <b>'.date("Y/M/d",strtotime($created_dttm)).'</b></h6>
					</div>
				</div>
			</div>
		</div>
		<div class="col s12 m12">
			<div class="card border-radius-3">
				<div class="card-content">
					<h6>List of Transaction</h6>
					<div id="table-datatables">
						<div class="row">
							<div class="col s12">
								<table id="tableDisbursement" class="responsive-table display" cellspacing="0">
									<thead>
										<tr>
										<th>Status</th>
										<th>Ammount</th>
										<th>Bank Code</th>
										<th>Account Name</th>
										<th>Account Number</th>
										<th>Bank Reference</th>
										</tr>
									</thead>
									<tbody>
										'.$table.'
									</tbody>
								</table>
							</div>
						</div>
					</div>                 
				</div>
			</div>
		</div>
		';
		echo $ret;
	}

	function setTab(){
		$type 	= $_POST["type"];
		$this->session->set_userdata("tab_disbursement",$type);
		if($type == "need"){
			$contentTab = '
				<u><a href="#needApprove" onClick="setTab(\'need\')" class="blue-text darken-4">Needs Approval</a></u>
				<a href="#approved" onClick="setTab(\'approved\')" class="grey-text text-accent-1">Approved</a>
			';
			$content = $this->needApprove();
		}else{
			$contentTab = '
				<a href="#needApprove" onClick="setTab(\'need\')" class="grey-text text-accent-1">Needs Approval</a>
				<u><a href="#approved" onClick="setTab(\'approved\')" class="blue-text  darken-4">Approved</a></u>
			';
			$content = $this->approved();
		}

		$data	= array(
			"contentTab" => $contentTab,
			"content"	=> $content
		);

		echo json_encode($data);
		return;
	}

	function needApprove(){
		$companyID 	= $this->session->userdata("sessCompanyID");
		$content 	= $this->ModelDisbursement->getDataNeedApprove($companyID);
		return $content;
	}
	
	function approved(){
		$companyID 	= $this->session->userdata("sessCompanyID");
		$content 	= $this->ModelDisbursement->getDataApproved($companyID);
		return $content;
		$content = '			
		<div class="card border-radius-3">
			<div class="card-content center">
			<i class="material-icons grey-text" style="font-size:100px">assignment</i>
			<h5 class="black-text">No batch disbursements found</h5>
			<p class="grey-text">Come back after your Approved Document One :)</p>
			</div>
		</div>
		';
		return $content;
	}

	function uploadBatch(){
		$this->load->library('excel');
		$reference 	= $_POST["reference"];
		$companyID 	= $this->session->userdata("sessCompanyID");
		$userID = $this->session->userdata("sessUserID");
		$trnscID 	= $this->ModelDisbursement->getTransactionID($companyID);
		if (isset($_FILES["filenm"]["name"])) {
			// $file = $_FILES["filenm"]["name"];
			$file   = explode('.',$_FILES['filenm']['name']);
			$length = count($file);
			if($file[$length -1] == 'xlsx' || $file[$length -1] == 'xls'){//jagain barangkali uploadnya selain file excel <img draggable="false" class="emoji" alt="🙂" src="https://s0.wp.com/wp-content/mu-plugins/wpcom-smileys/twemoji/2/svg/1f642.svg" scale="0">
				$tmp    = $_FILES['filenm']['tmp_name'];//Baca dari tmp folder jadi file ga perlu jadi sampah di server :-p
				try {
					$this->db->trans_begin();
					$this->ModelDisbursement->insertTransaction($companyID,$trnscID,$reference,$userID);
					$objPHPExcel = PHPExcel_IOFactory::load($tmp);
					$worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
					$numRows = count($worksheet);
					for ($i=2; $i < ($numRows+1) ; $i++) { 
						$ammount 		= str_replace('/', '-', $worksheet[$i]['A']);
						$bankCode		= str_replace('/', '-', $worksheet[$i]['B']);
						$accountName	= str_replace('/', '-', $worksheet[$i]['C']);
						$accountNumber	= str_replace('/', '-', $worksheet[$i]['D']);
						$description	= str_replace('/', '-', $worksheet[$i]['E']);
						$email			= str_replace('/', '-', $worksheet[$i]['F']);
						$emailCC		= str_replace('/', '-', $worksheet[$i]['G']);
						$emailBCC		= str_replace('/', '-', $worksheet[$i]['H']);
						$ammount = str_replace( ',', '', $ammount );

						$accountNumber = $this->aes->encrypt_aes256($accountNumber);
						
						if( is_numeric( $ammount ) ) {
							$ammount = $ammount;
						}
						if($ammount != '' OR $ammount != null){
							$data[] = array(
								"id"				=> "",
								"transaction_id" 	=> $trnscID,
								"company_id"	 	=> $companyID,
								"company_account"	=> "",
								"amount"			=> $ammount,
								"bank_code"			=> $bankCode,
								"account_number"	=> $accountNumber,
								"account_holder_name"	=> $accountName,
								"transaction_date"	=> date("Y-m-d H:i:s"),
								"payment_type"		=> "DISBURSE",
								"status"			=> "active"
							);
						}
					}
					$this->ModelDisbursement->insertTransactionDetail($data);
					if ($this->db->trans_status() === FALSE)
					{
						$this->db->trans_rollback();
						$status = 400;
					}
					else
					{
						$status = 200;
						$this->db->trans_commit();
					}
				} catch(Exception $e) {
					$status = 400;
				}
			}else{
				$status = 201;
			}
			// print_r($ammount);
			echo $status;
		}

		// echo $cell_collection;
	}
}
