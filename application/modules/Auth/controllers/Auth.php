<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function Login()
	{
		$this->load->view('login');
	}

	function successfull($id = null){
		$this->load->view('successfull');
	}

	function register(){
		$this->load->view('register');
	}

	function status(){
		
	}

	function confirmation($userID = null){
		if($userID != ""){
			$data["userID"] = $userID;
			$this->load->view("confirmation",$data);
		}
	}

	function createUser(){
		$this->load->Model("ModelAuth");
		if(!isset($_POST)){
			echo "Isi Data Terlebih Dahulu";
			return;
		}
		$email 		= $_POST["email"];
		$password	= $this->aes->encrypt_aes256($_POST["password"]);
		$name 		= $_POST["name"];
		$phone 		= $_POST["phone"];
		$business_name 		= $_POST["business_name"];
		$business_email 	= $_POST["business_email"];

		$create 	= $this->ModelAuth->createUser($email,$password,$name,$phone,$business_name,$business_email);

		echo $create;
		return;
	}

	function validation(){
		$this->load->Model("ModelAuth");
		if(!isset($_POST["email"])){
			echo "Silahkan Isi Email anda !";
			return;
		}

		if(!isset($_POST["password"])){
			echo "Silahkan Isi Password anda !";
			return;
		}
		
		$auth 	= $this->ModelAuth->validation($_POST["email"],$_POST["password"]);
		$data = json_decode($auth, true);
		if($data["status"] == "error"){
			echo "error";
			return;
		}
		if($data["status"] == "unverified"){
			echo "unverified";
			return;
		}
		if($data["status"] == "unactive"){
			echo "unactive";
			return;
		}
		if($data["status"] == "sukses"){			
			$this->session->set_userdata("sessUserID",$data["userID"]);
			$this->session->set_userdata("sessEmail",$data["email"]);
			$this->session->set_userdata("sessFullNam",$data["fullName"]);
			$this->session->set_userdata("sessCompanyID",$data["company_id"]);
			$this->session->set_userdata("sessCompanyLogo",$data["company_logo"]);
			$this->session->set_userdata("sessCompanyName",$data["company_name"]);
			echo "Sukses";
			return;
		}

	}

	function signout(){
		$this->session->unset_userdata("sessUSerID");
		$this->session->unset_userdata("sessEmail");

		header("location:".base_url()."auth/login");
	}

	function uploadterm(){
		$userID = $_POST["userID"];
		$sql 	="SELECT * FROM pouch_masteremployeecredential WHERE md5(userID) = '$userID'";
		$query	= $this->db->query($sql);
		if($query->num_rows()>0){
			$row = $query->row();
			if($row->doc != ''){
				$output["status"] = 401;
				$output["error"] = "Document Already Exist";

				echo json_encode($output);
				return;
			}
		}

		if (isset($_FILES['doc_pendukung'])) {
			set_time_limit(0);
			$allowedImageType = array(
				"application/pdf"
			);
			if ($_FILES['doc_pendukung']["error"] > 0) {
				$output["status"] = 401;
				$output['error'] = "Error in File";
			} elseif (!in_array($_FILES['doc_pendukung']["type"], $allowedImageType)) {
				$output["status"] = 401;
				$output['error'] = "You can only upload PDF file";
			} elseif (round($_FILES['doc_pendukung']["size"] / 1024) > 4096) {
				$output["status"] = 401;
				$output['error'] = "You can upload file size up to 4 MB";
			} else {
				$path[0]     = $_FILES['doc_pendukung']['tmp_name'];
				$file        = pathinfo($_FILES['doc_pendukung']['name']);
				$fileType    = $file["extension"];
				$desiredExt  = 'pdf';
				$fileNameNew = rand(333, 999) . time() . ".$desiredExt";
				
				$url = 'appsources/doc/contract/'.$fileNameNew;
				$config['upload_path']          = './appsources/doc/contract/';
				$config['file_name'] 			= $fileNameNew;
				$config['allowed_types'] = 'pdf';
				$config['max_size'] = 1024 * 4;
				// $config['encrypt_name'] = TRUE;
		
				$this->load->library('upload', $config);
		
				if (!$this->upload->do_upload("doc_pendukung"))
				{
					$status = 'error';
					$output['status'] = 401;
					$output['error'] = "Uploading File Failed";
				}
				else
				{
					$this->load->Model("ModelAuth");
					$data 	= $this->upload->data();
					$sql 	= "UPDATE pouch_masteremployeecredential SET doc='$fileNameNew' WHERE md5(userID) = '$userID'";
					$query 	= $this->db->query($sql);
					if($query){
						$this->ModelAuth->sendMailUpload($userID);
						$output['status'] = 200;
						$output['error'] = "Document has been uploaded, please check your email address";
					}
				}
			}
		}else{			
			$output['status']       = 401;
			$output['error'] = "Uploading File Failed";
		}

		echo json_encode($output);
		return;
	}
}
