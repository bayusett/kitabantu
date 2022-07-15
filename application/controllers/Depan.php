<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Depan extends CI_Controller {

	public function index()
	{
		$this->load->view('index');
	}

	public function login()
	{
		$this->load->view('login');
	}

	public function proses_daftar_relawan()
	{
		$this->load->model('mymodel');
            $data=array(
                //$username = $_POST['username'];//bisa
                'username'=>$this->input->post('username'),
                'email'=>$this->input->post('email'),
                'password'=>md5($this->input->post('password'))
            );

            //echo $data; //karena $data array maka tidak bisa mencetak menggunakan echo
            //echo digunakan untuk mencetak string, maka gunakan var_dump
            //var_dump($data);

            $query = $this->mymodel->Insert('relawan',$data);

            if($query){
                echo " <script> alert('Daftar relawan sukses') </script> ";
                $this->load->view('index');
            }else{
                echo " <script> alert('Daftar relawan gagal') </script> ";
                $this->load->view('index');
            }
	}

	function proses_login_relawan()
	{
		$this->load->model('mymodel');
            $where = array(
                    'email' => $this->input->post('email'),
                    'password' => md5($this->input->post('password'))
            );
            $cek = $this->mymodel->GetWhere('relawan', $where);
            $count_cek = count($cek);
            if($count_cek>0){
                    $relawan = $this->mymodel->GetWhere('relawan', array('email' =>$this->input->post('email')));

                    $data_session = array(
                            'id_relawan' => $relawan[0]['id_relawan'],
                            'username' => $relawan[0]['username'],
                            'foto' => $relawan[0]['foto']
                    );
                    $this->session->set_userdata($data_session);
                    echo "<script>alert('Login relawan sukses')</script>";
                    redirect(base_url("index.php/dashboardrelawan"));
                    //membaca controller baru yaitu dashboardrelawan
            }else{
                echo "<script>alert('Login relawan gagal')</script>";
                $this->index();
                //kembali ke halaman awal
            }
    }
    function email_ada(){
        $this->load->model('mymodel');
        $email = $this->input->post('email');
        if($this->mymodel->email_ada_gak($email)>0){
            echo '1';
        }else{
            echo '0';
        }
    }
}
