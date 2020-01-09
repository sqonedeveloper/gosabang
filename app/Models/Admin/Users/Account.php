<?php namespace App\Models\Admin\Users;

use CodeIgniter\Model;

class Account extends Model {

   protected $db;

   public function __construct() {
      $this->db = \Config\Database::connect();
   }

   public function getDetailEdit($id) {
      $table = $this->db->table('tb_users a');
      $table->select('a.name, a.username, a.email, a.role, a.status, b.id as id_profile_usaha');
      $table->join('tb_profile_usaha b', 'b.id_users = a.id', 'left');
      $table->where('a.id', $id);

      $get = $table->get();
      $data = $get->getRowArray();

      if (isset($data)) {
         return $data;
      } else {
         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
      }
   }

   public function getListsProfile() {
      $table = $this->db->table('tb_profile_usaha');
      $table->select('id, name');
      $table->orderBy('name', 'asc');

      $get = $table->get();

      $response = [];
      foreach ($get->getResultArray() as $data) {
         array_push($response, [
            'value' => $data['id'],
            'label' => $data['name']
         ]);
      }
      return $response;
   }

   public function submit($post = []) {
      $table = $this->db->table('tb_users');

      if ($post['pageType'] === 'insert') {
         $table->insert([
            'name' => $post['name'],
            'username' => $post['username'],
            'email' => $post['email'],
            'password' => password_hash($post['password'], PASSWORD_BCRYPT),
            'role' => $post['role'],
            'status' => $post['status'],
            'uploaded' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
         ]);
         $id_users = $this->db->insertID();

         if ($post['role'] === '2') {
            $profile = $this->db->table('tb_profile_usaha');
            $profile->where('id', $post['id_profile_usaha']);
            $profile->update([
               'id_users' => $id_users
            ]);
         }
      } else if ($post['pageType'] === 'update') {
         if (!empty($post['password'])) {
            $table->set('password', password_hash($post['password'], PASSWORD_BCRYPT));
         }
         
         $table->set('modified', date('Y-m-d H:i:s'));
         $table->set('name', $post['name']);
         $table->set('status', $post['status']);
         $table->where('id', $post['id']);
         $table->update();
      }
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