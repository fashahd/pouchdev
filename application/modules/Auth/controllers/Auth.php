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

	function register(){
		$this->load->view('register');
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
		// echo $auth;
		// return;
		$data = json_decode($auth, true);
		if($data["status"] == "error"){
			echo "error";
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
}
