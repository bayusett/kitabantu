<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_api extends CI_Controller {
    function __construct(){
        //pasti akan dijalankan ketika controller dipanggil
        parent::__construct();
        $this->load->model('mymodel');
    }
    function index(){
        //menampilkan data relawan
        $relawan = $this->mymodel->Get('relawan');//dari my model
        //$relawan = $this->db->query("SELECT username, email FROM relawan")->result();
        echo json_encode ($relawan) ;
    }
    function daftar_relawan(){
        $data = array(
        'username' => $this->input->post('username'),
        'email' => $this->input->post('email'),
        'password' => md5($this->input->post('password'))
        );
        $query = $this->mymodel->Insert('relawan', $data);
        if ($query){
        $hasil = array('status' => 'Berhasil Daftar Relawan');
        echo json_encode($hasil);
        } else {
        $hasil = array('status' => 'Gagal Daftar Relawan');
        echo json_encode($hasil);
        }
    }
    function update_username_relawan(){
        $data = array(
        'username' => $this->input->post('username')
        );
        $where = array (
        'id_relawan' => $this->input->post('id_relawan')
        );
        $query = $this->mymodel->Update('relawan', $data, $where);
        if ($query) {
        $hasil = array('status' => 'Berhasil Update Relawan');
        echo json_encode($hasil);
        } else {
        $hasil = array('status' => 'Gagal Update Relawan');
        echo json_encode($hasil);
        }
    }

    public function hapus_relawan($id_relawan){
        $id_relawan = array(
        'id_relawan' => $id_relawan
        );
        $query = $this->mymodel->Delete('relawan', $id_relawan);
        if ($query) {
        $hasil = array('status' => 'Berhasil Hapus Relawan');
        echo json_encode($hasil);
        } else {
        $hasil = array('status' => 'Gagal Hapus Relawan');
        echo json_encode($hasil);
        }
        }
}
?>