<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Mymodel extends CI_Model{
        public function Get ($table){
            $res = $this->db->get($table);//$res = $this->db->query('SELECT * FROM '.$table);
            return $res->result_array();//mengembalikan hasil operasi $res menjadi sebuah array
        }
        public function GetWhere($table, $data){
            $res = $this->db->get_where($table, $data);
            //'SELECT * FROM '.$table.' WHERE '.$data
            //'SELECT * FROM '.$table.' WHERE id_relawan = 5
            return $res->result_array();
        }
        public function Insert($table, $data){
            $res = $this->db->insert($table, $data);
            return $res;
        }
        public function Update($table, $data, $where){
            $res = $this->db->update($table, $data, $where); //query update, mengupdate data
            return $res;
        }
        //public function Delete($table, $data, $where){
            //$res = $this->db->delete($table, $data, $where); //query delet, menghapus data
            //return $res;
            //melakukan aksi
        //}

        public function Delete($table, $where){
            $res = $this->db->delete($table, $where); //query delet, menghapus data
            return $res;
            //melakukan aksi
        }

        public function GetAcaraRelawan ($id_relawan){
            $res = $this->db->query("SELECT a.nama, ra.id_acara, ra.status, ra.id_relawan_acara FROM relawan_acara ra JOIN acara a ON 
            ra.id_acara = a.id_acara WHERE ra.id_relawan='$id_relawan'");
            return $res->result_array();
            //mengembalikan hasil operasi $res menjadi sebuah array
        }
        public function email_ada_gak($email){
            $sql = "SELECT count(email) as c FROM relawan WHERE email = '$email'";
            $query = $this->db->query($sql);
            $res = $query->result_array();
            return $res[0]['c'];
        }
	}
?>