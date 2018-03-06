<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata("sessUserID")){
			redirect("auth/login");
			return;
		}
		$this->load->model("ModelSetting");
	}

	public function index()
	{
		$tabSetting 	= "general";
		if($this->session->userdata("sessSettings") == null){
			$tabSetting 	= "general";
		}else{
			$tabSetting 	= $this->session->userdata("sessSettings");
		}
		$data["module"] = "Settings";
		$data["userID"]	= $this->session->userdata("userID");
		$data["tabSetting"] = $this->tabSetting($tabSetting);
		$data["tab"]	= $tabSetting;
		$data["email"]	= $this->session->userdata("sessEmail");
		$this->layout->content("index",$data);
	}

	function tabSetting($tabSetting){
		$userID = $this->session->userdata("sessUserID");
		if($tabSetting == "general"){
			$ret = $this->ModelSetting->getTabGeneral($userID);
		}
		if($tabSetting == "users"){
			$ret = $this->ModelSetting->getTabUsers($userID);
		}
		if($tabSetting == "billing"){
			$ret = $this->ModelSetting->getTabBilling($userID);
		}
		if($tabSetting == "withdraw"){
			$ret = $this->ModelSetting->getTabWithdraw($userID);
		}
		if($tabSetting == "developer"){
			$ret = $this->ModelSetting->getTabDeveloper($userID);
		}
		return $ret;
	}
	
	function tabSettingAjax($tabSetting){
		$userID = $this->session->userdata("sessUserID");
		$this->session->set_userdata("sessSettings",$tabSetting);
		if($tabSetting == "general"){
			$ret = $this->ModelSetting->getTabGeneral($userID);
		}
		if($tabSetting == "users"){
			$ret = $this->ModelSetting->getTabUsers($userID);
		}
		if($tabSetting == "billing"){
			$ret = $this->ModelSetting->getTabBilling($userID);
		}
		if($tabSetting == "withdraw"){
			$ret = $this->ModelSetting->getTabWithdraw($userID);
		}
		if($tabSetting == "developer"){
			$ret = $this->ModelSetting->getTabDeveloper($userID);
		}
		echo $ret;
		return;
	}

	function updateAccountInformation(){
		$fullname 	= $_POST["fullname"];
		$email 		= $_POST["email"];
		$phone 		= $_POST["phone"];
		$data 	= array(
			"fullName" 	=> $fullname,
			"email"		=> $email,
			"phoneNumber"		=> $phone
		);
		$response 	= $this->ModelSetting->updateAccountInformation($data);
		echo $response;
		return;
	}	

	function updateBusinessInformation(){
		$company_name 		= $_POST["business_name"];
		$company_email		= $_POST["business_email"];
		$company_address 	= $_POST["address"];
		$data 	= array(
			"company_name" 		=> $company_name,
			"company_email"		=> $company_email,
			"company_address"	=> $company_address
		);
		$response 	= $this->ModelSetting->updateBusinessInformation($data);
		echo $response;
		return;
	}

	function updateNewPassword(){
		$cur_pass 	= $this->aes->encrypt_aes256($_POST["cur_pass"]);
		$new_pass 	= $this->aes->encrypt_aes256($_POST["new_pass"]);
		$re_new_pass = $this->aes->encrypt_aes256($_POST["re_new_pass"]);
		
		$response = $this->ModelSetting->updateNewPassword($cur_pass,$new_pass,$re_new_pass);

		echo $response;
		return;
	}

	function updateNewPIN(){
		$new_pin 	= $this->aes->encrypt_aes256($_POST["pin"]);
		
		$response = $this->ModelSetting->updateNewPIN($new_pin);

		echo $response;
		return;
	}

	function formEditUser(){
		if(isset($_POST["userID"])){
			$this->session->set_userdata("sessedituserID",$_POST["userID"]);
			$account 	= $this->ModelSetting->getAccountInformation($_POST["userID"]);
			$permission = $this->ModelSetting->getAccountPermission($_POST["userID"]);
			$listPermission = $this->ModelSetting->getPermssionList();
			$data["account"] = $account;
			$data["permission"] = $permission;
			$data["listPermission"] = $listPermission;
			$this->load->view("formEditUser",$data);			
		}
	}

	function updateUser(){
		$userID 	= $this->session->userdata("sessedituserID");
		$permission = $_POST["permission"];
		$updateUser = $this->ModelSetting->updateUser($userID,$_POST["permission"]);

		echo $updateUser;
		return;
	}

	function createNewUser(){
		$email 		= $_POST["email"];
		$name 		= $_POST["name"];
		$new_pass	= $_POST["new_pass"];
		$re_pass	= $_POST["re_pass"];
		$password	= $this->aes->encrypt_aes256($new_pass);
		$permission	= $_POST["permission"];
		$exist 		= $this->ModelSetting->checkUserExist($email);
		if($exist == "exist"){
			$return 	= array(
				"status"		=> 301,
				"keterangan"	=> "User Existed"
			);
			
			echo json_encode($return);
			return;
		}
		// print_r($permission);
		// return;
		if($new_pass != $re_pass){
			$return 	= array(
				"status"		=> 301,
				"keterangan"	=> "Password is Not Same"
			);
			
			echo json_encode($return);
			return;
		}

		if(!isset($_POST["permission"])){
			$return 	= array(
				"status"		=> 301,
				"keterangan"	=> "Please Fill The Permission Field"
			);
			
			echo json_encode($return);
			return;
		}
		
		$createNewUser = $this->ModelSetting->createNewUser($email,$name,$password,$_POST["permission"]);

		echo $createNewUser;
		return;
	}

	function deleteBank(){
		$id 	= $_POST["id"];
		$sql 	= "DELETE FROM pouch_withdraw_account WHERE withdraw_bank_id = '$id'";
		$query	= $this->db->query($sql);
		if(!$query){
			echo json_encode(array("status"=>400,"keterangan"=>"Gagal Menghapus, Harap Hubungi Customer Service Kami"));
			return;
		}else{
			echo json_encode(array("status"=>200,"keterangan"=>"Bank Berhasil Dihapus"));
			return;
		}
	}

	function createNewBank(){
		$bank 			= $_POST["bank"];
		$account_name 	= $_POST["account_name"];
		$account_number	= $_POST["account_number"];
		$account_number	= $this->aes->encrypt_aes256($account_number);
		
		$addbank = $this->ModelSetting->addBank($bank,$account_name,$account_number);

		echo $addbank;
		return;
	}

	function deleteUser(){
		if(isset($_POST["userID"])){
			$sql 	= "UPDATE pouch_masteremployeecredential set status= 'deactive' WHERE userID = '$_POST[userID]'";
			$query 	= $this->db->query($sql);
			if($query){
				echo "sukses";
				return;
			}else{
				echo "gagal";
				return;
			}
		}
	}
	
	function createThumb($path1, $path2, $file_type, $new_w, $new_h, $squareSize = ''){
		/* read the source image */
		$source_image = FALSE;

		if (preg_match("/jpg|JPG|jpeg|JPEG/", $file_type)) {
			$source_image = imagecreatefromjpeg($path1);
		}
		else if (preg_match("/png|PNG/", $file_type)) {
			if (!$source_image = @imagecreatefrompng($path1)) {
				$source_image = imagecreatefromjpeg($path1);
			}
		}
		elseif (preg_match("/gif|GIF/", $file_type)) {
			$source_image = imagecreatefromgif($path1);
		}  
		if ($source_image == FALSE) {
			$source_image = imagecreatefromjpeg($path1);
		}

		$orig_w = imageSX($source_image);
		$orig_h = imageSY($source_image);

		if ($orig_w < $new_w && $orig_h < $new_h) {
			$desired_width = $orig_w;
			$desired_height = $orig_h;
		} else {
			$scale = min($new_w / $orig_w, $new_h / $orig_h);
			$desired_width = ceil($scale * $orig_w);
			$desired_height = ceil($scale * $orig_h);
		}

		if ($squareSize != '') {
			$desired_width = $desired_height = $squareSize;
		}

		/* create a new, "virtual" image */
		$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
		// for PNG background white----------->
		$kek = imagecolorallocate($virtual_image, 255, 255, 255);
		imagefill($virtual_image, 0, 0, $kek);

		if ($squareSize == '') {
			/* copy source image at a resized size */
			imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $orig_w, $orig_h);
		} else {
			$wm = $orig_w / $squareSize;
			$hm = $orig_h / $squareSize;
			$h_height = $squareSize / 2;
			$w_height = $squareSize / 2;

			if ($orig_w > $orig_h) {
				$adjusted_width = $orig_w / $hm;
				$half_width = $adjusted_width / 2;
				$int_width = $half_width - $w_height;
				imagecopyresampled($virtual_image, $source_image, -$int_width, 0, 0, 0, $adjusted_width, $squareSize, $orig_w, $orig_h);
			}

			elseif (($orig_w <= $orig_h)) {
				$adjusted_height = $orig_h / $wm;
				$half_height = $adjusted_height / 2;
				imagecopyresampled($virtual_image, $source_image, 0,0, 0, 0, $squareSize, $adjusted_height, $orig_w, $orig_h);
			} else {
				imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $squareSize, $squareSize, $orig_w, $orig_h);
			}
		}

		if (@imagejpeg($virtual_image, $path2, 90)) {
			imagedestroy($virtual_image);
			imagedestroy($source_image);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function uploadlogo(){
		$companyID 	= $this->session->userdata("sessCompanyID");
		if (isset($_FILES['image_upload_file'])) {
			// $output['status'] = FALSE;
			set_time_limit(0);
			$allowedImageType = array(
				"image/gif",
				"image/jpeg",
				"image/pjpeg",
				"image/png",
				"image/x-png"
			);
			if ($_FILES['image_upload_file']["error"] > 0) {
				$output['error'] = "Error in File";
			} elseif (!in_array($_FILES['image_upload_file']["type"], $allowedImageType)) {
				$output['error'] = "You can only upload JPG, PNG and GIF file";
			} elseif (round($_FILES['image_upload_file']["size"] / 1024) > 4096) {
				$output['error'] = "You can upload file size up to 4 MB";
			} else {
				/*create directory with 777 permission if not exist - start*/
				// createDir(IMAGE_SMALL_DIR);
				// createDir(IMAGE_MEDIUM_DIR);
				/*create directory with 777 permission if not exist - end*/
				$path[0]     = $_FILES['image_upload_file']['tmp_name'];
				$file        = pathinfo($_FILES['image_upload_file']['name']);
				$fileType    = $file["extension"];
				$desiredExt  = 'jpg';
				$fileNameNew = rand(333, 999) . time() . ".$desiredExt";
				$path[1]     = 'appsources/logo/company/'.$fileNameNew;
				$path[2]     = 'appsources/logo/company/'.$fileNameNew;
				
				$url = base_url().'appsources/logo/company/'.$fileNameNew;
				$this->session->set_userdata("sessCompanyLogo",$url);
				$sql = "UPDATE pouch_mastercompanydata SET company_logo = '$url' WHERE company_id = '$companyID'";
				$this->db->query($sql);
				
				if ($this->createThumb($path[0], $path[1], $fileType, 250, 250, 250)) {
					
					if ($this->createThumb($path[1], $path[2], "$desiredExt", 250, 250, 250)) {
						$output['status']       = 200;
						$output['image_medium'] = $path[1];
						$output['image_small']  = $path[2];
					}
				}
			}
		}else{			
			$output['status']       = 400;
		}
		echo json_encode($output);
	}
}
