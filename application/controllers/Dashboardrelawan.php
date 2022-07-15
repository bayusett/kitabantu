<?php
    defined('BASEPATH') OR exit ('No direct script access allowed');

    class Dashboardrelawan extends CI_Controller{
        public function index()
        {
            if(!empty($this->session->userdata('id_relawan'))){
                $this->load->view('relawan/index.php');
                //tampilakn views/relawan/index.php
            }else{
                $this->load->session->sess_destroy();
                redirect(base_url());
            }
        }
        public function logout(){
            $this->session->sess_destroy();
            redirect(base_url());
        }

        public function profil($id_relawan){
            $this->load->model('mymodel');
            $relawan = $this->mymodel->GetWhere('relawan', array('id_relawan'=>$id_relawan));
            $data = array(
                'id_relawan' => $id_relawan,
                'username' => $relawan[0]['username'],
                'email' => $relawan[0]['email'],
                'password' => $relawan[0]['password'],
                'nama_lengkap' => $relawan[0]['nama_lengkap'],
                'tempat_lahir' => $relawan[0]['tempat_lahir'],
                'tanggal_lahir' => $relawan[0]['tanggal_lahir'],
                'alamat' => $relawan[0]['alamat'],
                'no_hp' => $relawan[0]['no_hp'],
                'foto' => $relawan[0]['foto']
            );
            $this->load->view('relawan/profil', $data);
        }

        public function proses_edit_profil($id_relawan){
            $this->load->model('mymodel');
            $data = array(
                'username' => $this->input->post('username'),
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'alamat' => $this->input->post('alamat'),
                'no_hp' => $this->input->post('no_hp')
            );
            if(!empty($_FILES['foto']['tmp_name'])){
                //jika ada foto yg diupload
                $data['foto'] = "assets/img/relawan/".$this->_uploadImage();
                //tambahkan foto di array $data, tidak pake => namun hanya =
                // _uploadImage() adalah fungsi,
            }
            $where = array(
                'id_relawan' => $id_relawan
            );
            $query = $this->mymodel->Update('relawan',$data,$where);
            if($query){
                echo "<script>alert('Edit relawan sukses')</script>";
                $this->profil($id_relawan);
            }
            else{
                echo "<script>alert('Edit relawan gagal')</script>";
                $this->profil($id_relawan);
            }
  
        }
        private function _uploadImage(){
            $config['upload_path'] = "assets/img/relawan";
            $config['allowed_types'] = '*';
            $config['file_name'] = date("y-m-d-h-i-sa").$_FILES['foto']['name'];
            $config['overwrite'] = true;
            $config['max_size'] = 2048;

            $this->load->library('upload',$config);
            
            if($this->upload->do_upload('foto')){
                //echo "berhasil";
                return $this->upload->data("file_name");
            }else{
                //echo errors = $this->upload->display_errors();
                return "assets/img/relawan/default.png";
                //kita harus menyimpan gambar default
            }
        }

        public function acara($id_relawan){
            $this->load->model('mymodel');
            $acara_relawan = $this->mymodel->GetAcaraRelawan($id_relawan);
            $data = array('data' =>$acara_relawan);
            $this->load->view('relawan/acara', $data);
        }

        public function hapus_acara($id_relawan_acara){
            $this->load->model('mymodel');
            $id_relawan_acara = array(
                'id_relawan_acara' => $id_relawan_acara
            );
            $query = $this->mymodel->Delete('relawan_acara', $id_relawan_acara);
            if($query){
                echo "<script>alert('Hapus Acara acara sukses')</script>";
                $this->acara($this->session->userdata('id_relawan'));
            }
            else{
                echo "<script>alert('Hapus Acara acara gagal')</script>";
                $this->acara($this->session->userdata('id_relawan'));
            }
        }

        public function daftar_acara($id_relawan){
            $this->load->model('mymodel');
            $acara = $this->mymodel->Get('acara');
            $data = array('data' =>$acara);
            $this->load->view('relawan/daftar_acara', $data);
        }

        public function proses_daftar_acara($id_relawan){
            $this->load->model('mymodel');
            
            $data = array(
                'id_relawan' => $id_relawan,
                'id_acara' => $this->input->post('acara')
            );

            $query = $this->mymodel->Insert('relawan_acara',$data);
            if($query){
                echo "<script>alert('Daftar acara sukses')</script>";
                $this->acara('id_relawan');
            }
            else{
                echo "<script>alert('Daftar acara gagal')</script>";
                $this->daftar_acara('id_relawan');
                
            }
        }
    }
?>