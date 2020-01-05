<?php namespace App\Models\Admin\Users;

use CodeIgniter\Model;

class Account extends Model {

   protected $db;

   public function __construct() {
      $this->db = \Config\Database::connect();
   }

   function deleteAccount($post = []) {
      $table = $this->db->table('tb_users');
      $table->where('id', $post['id']);
      $table->delete();
   }

   function getData() {
      $table = $this->_queryData();
      if ($_POST['length'] != -1)
         $table->limit($_POST['length'], $_POST['start']);
      return $table->get();
   }
   
   function countData() {
      $table = $this->db->table('tb_users');
      $get = $table->get();
      return count($get->getResult());
   }
   
   function filteredData() {
      $table = $this->_queryData();
      $get = $table->get();
      return count($get->getResult());
   }
   
   private function _queryData() {
      $table = $this->db->table('tb_users');
      $table->select('id, name, username, email, role, status, modified');
   
      $i = 0;
      $column_search = ['name', 'username', 'email'];
      $column_order = ['name', 'username', 'role', 'status', 'modified'];
      foreach ($column_search as $item) {
         if ($_POST['search']['value']) {
            if ($i === 0) {
               $table->groupStart();
               $table->like($item, $_POST['search']['value']);
            } else {
               $table->orLike($item, $_POST['search']['value']);
            }
   
            if (count($column_search) - 1 == $i)
               $table->groupEnd();
         }
         $i++;
      }
   
      $column = $_POST['order'][0]['column'];
      $dir = $_POST['order'][0]['dir'];
      $table->orderBy($column_order[$column], $dir);
   
      return $table;
   }

}