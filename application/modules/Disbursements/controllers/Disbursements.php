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
		$date 	= date("Y-m-d");
		$date2 	= date("Y-m-d");
		$status = "";
		if($this->session->userdata("date")){
			$date 		= $this->session->userdata("date");
		}
		if($this->session->userdata("date2")){
			$date2 		= $this->session->userdata("date2");
		}
		if($this->session->userdata("status")){
			$status 	= $this->session->userdata("status");
		}
		$data["date"]	= $date;
		$data["date2"]	= $date2;
		$data["module"] = "Disbursements";
		$data["status"] = $status;
		$data["datadisburse"] = $this->ModelDisbursement->getDisbursementAPI($date,$date2,$status);
		$data["email"]	= $this->session->userdata("sessEmail");
		$this->layout->content("index",$data);
	}

	function detaildisburse(){
		$disburse_id 	= $_POST["disburse_id"];
		$infodetail 	= $this->ModelDisbursement->getDetailDisburse($disburse_id);
		list($status,$account_name,$account_number,$bank_code,$description,$external_id,$created_datetime,$amount,$callback,$callback_datetime,$callback_message,$bank_reference)=$infodetail;
		$failure = '';
		$complete = '';
		if($status == "PENDING"){
			$alert_info = '				
			<span class="label label-flat border-warning text-warning-600" style="font-size:10pt">Pending</span>
			';
		}
		if($status == "FAILED"){
			$alert_info = '				
			<span class="label label-flat border-danger text-danger-600" style="font-size:10pt">Failed</span>
			';
			$failure = '
			<div class="col-lg-5">
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h5 class="panel-title">Failur Details</h5>
						
					</div>
					<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr>
									<td>Failur Code</td>
									<td><b>'.$callback.'</b></td>
								</tr>
								<tr>
									<td>Failur Description</td>
									<td><b>'.$callback_message.'</b></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!-- /solid thead border -->
			</div>
			<div class="col-lg-5">
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h5 class="panel-title">Transaction Timeline</h5>
						
					</div>
					<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr>
									<td>Created Date</td>
									<td><b>'.date("d M Y, H:i:s", strtotime($created_datetime)).'</b></td>
								</tr>
								<tr>
									<td>Failure Date</td>
									<td><b>'.date("d M Y, H:i:s", strtotime($callback_datetime)).'</b></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!-- /solid thead border -->
			</div>
			';
		}
		if($status == "COMPLETED"){
			$alert_info = '				
			<span class="label label-flat border-info text-info-600" style="font-size:10pt">Completed</span>
			';
			$complete = '
			<div class="col-lg-5">
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h5 class="panel-title">Transaction Timeline</h5>
						
					</div>
					<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr>
									<td>Created Date</td>
									<td><b>'.date("d M Y, H:i:s", strtotime($created_datetime)).'</b></td>
								</tr>
								<tr>
									<td>Failure Date</td>
									<td><b>'.date("d M Y, H:i:s", strtotime($callback_datetime)).'</b></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!-- /solid thead border -->
			</div>
			<div class="col-lg-6">
				<div class="panel panel-flat">
					<div class="panel-heading" style="background:#008cff;color:#fff">
						<h6 class="panel-title">BUKTI TRANSFER</h6>
						<div class="heading-elements">
							<span class="label heading-text"><img width="80px" src="'.base_url().'appsources/mypouch-white.png"/></span>
						</div>
					</div>

					<div class="table-responsive">
						<table class="table table-lg text-nowrap">
							<tbody>
								<tr>
									<td class="col-md-6">
										<div class="media-left">
											<div id="campaigns-donut"></div>
										</div>

										<div class="media-left">
											<h6 class="text-semibold no-margin">Date / Hour</h6>
											<ul class="list-inline list-inline-condensed no-margin">
												<li>
													<span class="text-muted">'.date('d M Y, h:i A', strtotime($callback_datetime)).'</span>
												</li>
											</ul>
										</div>
									</td>
									<td class="col-md-6">
										<div class="media-left">
											<div id="campaigns-donut"></div>
										</div>

										<div class="media-left">
											<h6 class="text-semibold no-margin">Bank Reference Number</h6>
											<ul class="list-inline list-inline-condensed no-margin">
												<li>
													<span class="text-muted">'.$bank_reference.'</span>
												</li>
											</ul>
										</div>
									</td>
								</tr>
								<tr>
									<td class="col-md-6">
										<div class="media-left">
											<div id="campaigns-donut"></div>
										</div>

										<div class="media-left">
											<h6 class="text-semibold no-margin">Sender Name</h6>
											<ul class="list-inline list-inline-condensed no-margin">
												<li>
													<span class="text-muted">PT. Sakuku Digital Indonesia</span>
												</li>
											</ul>
										</div>
									</td>
									<td class="col-md-6">
										<div class="media-left">
											<div id="campaigns-donut"></div>
										</div>

										<div class="media-left">
											<h6 class="text-semibold no-margin">Merchant Name</h6>
											<ul class="list-inline list-inline-condensed no-margin">
												<li>
													<span class="text-muted">Mypouch</span>
												</li>
											</ul>
										</div>
									</td>
								</tr>
							</tbody>
						</table>	
					</div>
				</div>
			</div>
			';
		}
		$ret = '
		<div class="page-header page-header-default">
			<div class="page-header-content">
				<div class="page-title">
					<h4>Disbursements</h4>
				</div>
			</div>
			<div class="breadcrumb-line">
				<div class="panel-flat">
					<div class="panel-body">
						<div class="row search-option-buttons">
							<div class="col-sm-6">
								<ul class="list-inline list-inline-condensed no-margin-bottom">
									<li class="dropdown">
										<a href="'.base_url().'disbursements" class="btn btn-link btn-sm" >
											<i class="icon-circle-left2 position-left"></i> Go Back
										</a>
									</li>
								</ul>
							</div>
							<div class="col-sm-6">
								<div class="pull-right">'.$alert_info.'</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="content">
			<div class="row">
				<div class="col-lg-5">
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">Payment Details <img class="pull-right no-paddings" width="80px" src="'.base_url().'appsources/mypouch-color.png"/></h5>
							
						</div>
						<div class="table-responsive">
							<table class="table">
								<tbody>
									<tr>
										<td>External ID</td>
										<td><b>'.$external_id.'</b></td>
									</tr>
									<tr>
										<td>Name</td>
										<td><b>'.$account_name.'</b></td>
									</tr>
									<tr>
										<td>Bank Account Number</td>
										<td><b>'.$account_number.'</b></td>
									</tr>
									<tr>
										<td>Bank Code</td>
										<td><b>'.$bank_code.'</b></td>
									</tr>
									<tr>
										<td>Transfer Amount</td>
										<td><b>IDR '.number_format($amount).'</b></td>
									</tr>
									<tr>
										<td>Transaction Date</td>
										<td><b>'.date("d M Y, H:i:s", strtotime($created_datetime)).'</b></td>
									</tr>
									<tr>
										<td>Description</td>
										<td><b>'.$description.'</b></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<!-- /solid thead border -->
				</div>
				'.$failure.'
				'.$complete.'
			</div>
		</div>
		';

		echo $ret;
	}

	function getDisburseDataStatus(){
		$status = $_POST["status"];
		$date 	= $_POST["date"];
		$date2	= $_POST["date2"];

		$this->session->set_userdata("date",$date);
		$this->session->set_userdata("date2",$date2);
		$this->session->set_userdata("status",$status);

		$disbursement = $this->ModelDisbursement->getDisbursementAPI($date,$date2,$status);
		if($disbursement != ""){
			$ret = '
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table id="tableDisbursement" class="table">
							<thead>
								<tr>
									<th>External ID</th>
									<th>Date</th>
									<th>Amount (Rp)</th>
									<th>Bank Code</th>
									<th>Account Name</th>
									<th>Account Number</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								'.$disbursement.'
							</tbody>
						</table>
					</div>
				</div>
			</div>
			';
		}else{
			$ret = '
				<div class="row">
					<div class="col-md-12">
						<div class="panel">
							<div class="panel-body text-center">
								<div class="icon-object border-success text-success"><i class="icon-wallet"></i></div>
								<h5 class="text-semibold">No disbursements found</h5>
								<p class="mb-15">We show disbursements by filter, try changing your filter</p>
							</div>
						</div>
					</div>
				</div>
			';
		}

		echo $ret;
	}
}
