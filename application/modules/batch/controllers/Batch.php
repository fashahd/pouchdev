<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Batch extends MX_Controller {

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
		$transaction_id = $this->aes->decrypt_aes256API($transaction_id);
		$data				= $this->ModelDisbursement->getTransaction($transaction_id);
		list($reference,$fullName,$created_dttm,$status)=$data;
		$table 	= $this->ModelDisbursement->getTransactionDetail($transaction_id);
		$sql    = " SELECT a.* FROM pouch_mastertransactiondetail as a"
                    . " WHERE a.transaction_id = '$transaction_id' and status='$status'";
		$query  = $this->db->query($sql);
		$total = $query->num_rows();
		$amount = 0;
		if($query->num_rows()>0){
			foreach($query->result() as $key){
				$amount = $amount+$key->amount;
			}
		}
		$sqle    = " SELECT a.* FROM pouch_mastertransactiondetail as a"
                    . " WHERE a.transaction_id = '$transaction_id' and status='failed'";
		$querye  = $this->db->query($sqle);
		$totale = $querye->num_rows();
		$amounte = 0;
		if($querye->num_rows()>0){
			foreach($querye->result() as $key){
				$amounte = $amounte+$key->amount;
			}
		}
		$keterangan = "";
		$btnproses = "";
		if($status == "active"){
			$status = "<span class='btn btn-primary btn-sm'>Need Approval</span>";
			$icon 	= "icon-enlarge7";
			$keterangan = '
			<h4 class="text-center content-group">
				Batch awaiting approval
				<small class="display-block">This batch is awaiting approval. You will be able to monitor or download all transactions after you have approved the batch.</small>
			</h4>
			';
			$btnproses = '
			<div class="tabbale col-lg-6">
				<div class="pull-right">
					<a href="#upload" class="btn btn-primary btn-labeled btn-sm"><b><i class="icon-cloud-upload"></i></b> Proses</a>
				</div>
			</div>';
		}else if($status == "completed"){
			$status = "<span class='btn btn-primary btn-sm'>$status</span>";
			$icon 	= "icon-shield-check";
		}else{
			$status = "<span class='btn btn-primary btn-sm'>$status</span>";
			$icon 	= "icon-enlarge7";
		}
		$ret = '
		<div class="page-header page-header-default">
			<div class="page-header-content">
				<div class="page-title">
					<h4>Batch Disbursements</h4>
				</div>
			</div>
			<div class="breadcrumb-line">
				<div class="panel-flat">
					<div class="panel-body">
						<div class="row search-option-buttons">
							<div class="col-sm-6">
								<ul class="list-inline list-inline-condensed no-margin-bottom">
									<li class="dropdown">
										<a href="'.base_url().'batch" class="btn btn-link btn-sm" >
											<i class="icon-circle-left2 position-left"></i> Go Back
										</a>
									</li>
									<li>'.$status.'</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="content">
			'.$keterangan.'
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-flat">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-4">
									<div class="content-group">
										<h6 class="text-semibold heading-divided">Reference : '.$reference.'</h6>
									</div>
									<div class="content-group">
										<h6 class="text-semibold heading-divided">Uploaded By : '.$fullName.'</h6>
									</div>
									<div class="content-group">
										<h6 class="text-semibold heading-divided">Uploaded On : '.date("d/M/Y",strtotime($created_dttm)).'</h6>
									</div>
								</div>
								<div class="col-md-8">
									<div class="col-md-6">
										<div class="content-group">
											<h6 class="text-semibold heading-divided"><i class="icon-file-text position-left"></i> Uploaded Transactions</h6>
											<p>Number of transactions that have been uploaded</p><br>
											<div class="panel panel-body">
												<div class="media">
													<div class="media-left">
														<a><i class="'.$icon.' text-slate-800 icon-2x no-edge-top mt-5"></i></a>
													</div>

													<div class="media-body">
														<h6 class="media-heading text-semibold">'.$total.'</h6>
														TOTAL TRANSACTION
													</div>
												</div>
											</div>
											<div class="panel panel-body">
												<div class="media">
													<div class="media-left">
														<a><img style="width:40px" class="no-edge-top mt-5" src="'.base_url().'appsources/rupiah.png"/></a>
													</div>

													<div class="media-body">
														<h6 class="media-heading text-semibold">'.number_format($amount).'</h6>
														TOTAL AMOUNT
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="content-group">
											<h6 class="text-semibold heading-divided"><i class="icon-bell-cross position-left"></i> Transactions Issues</h6>
											<p>Transactions that cannot be processed. Get download the errors and easily fix them and upload again.</p>
											<div class="panel panel-body">
												<div class="media">
													<div class="media-left">
														<a><i class="icon-cross text-danger icon-2x no-edge-top mt-5"></i></a>
													</div>

													<div class="media-body">
														<h6 class="media-heading text-semibold">'.$totale.'</h6>
														TOTAL TRANSACTION
													</div>
												</div>
											</div>
											<div class="panel panel-body">
												<div class="media">
													<div class="media-left">
														<a><img style="width:40px" class="no-edge-top mt-5" src="'.base_url().'appsources/rupiah_red.png"/></a>
													</div>

													<div class="media-body">
														<h6 class="media-heading text-semibold">'.number_format($amounte).'</h6>
														TOTAL AMOUNT
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="panel panel-flat">
						<div class="panel-heading">
							<div class="tabbable col-lg-6">
								<h6>List of Transaction</h6>
							</div>
							'.$btnproses.'
						</div>
						<div class="panel-body">							
							<div class="row">
								<div class="col-md-12">
									<div class="table-responsive">
										<table id="tableDisbursement" class="table">
											<thead>
												<tr>
												<th>Ammount (IDR)</th>
												<th>Bank Code</th>
												<th>Account Name</th>
												<th>Account Number</th>
												<th>Proses</th>
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
