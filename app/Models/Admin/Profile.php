<?php namespace App\Models\Admin;

use CodeIgniter\Model;

class Profile extends Model {

   protected $db;

   public function __construct() {
      $this->db = \Config\Database::connect();
   }

   function getListsCategories() {
      $table = $this->db->table('tb_categories');
      $table->orderBy('id', 'asc');

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

   function deleteProfile($post = []) {
      @unlink(ROOTPATH . 'public/img/' . $post['thumbnail']);

      $table = $this->db->table('tb_profile_usaha');
      $table->where('id', $post['id']);
      $table->delete();
   }

   function getDetailEdit($id) {
      $table = $this->db->table('tb_profile_usaha');
      $table->where('id', $id);

      $get = $table->get();
      $data = $get->getRowArray();

      if (isset($data)) {
         return $data;
      } else {
         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
      }
   }

   function submit($post = []) {
      $table = $this->db->table('tb_profile_usaha');
      
      $post['modified'] = date('Y-m-d H:i:s');
      if ($post['pageType'] === 'insert') {
         $generatedUsers = $this->generatedUsers([
            'name' => $post['name'],
            'email' => $post['email'],
            'username' => $post['email'],
            'password' => password_hash($post['email'], PASSWORD_BCRYPT),
            'role' => '2',
            'status' => '1',
            'uploaded' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
         ]);

         unset($post['pageType'], $post['id']);

         $post['id_users'] = $generatedUsers;
         $post['uploaded'] = date('Y-m-d H:i:s');
         $table->insert($post);
      } else if ($post['pageType'] === 'update') {
         unset($post['pageType']);

         if ($post['thumbnail'] === 'undefined') {
            unset($post['thumbnail']);
         }

         $table->where('id', $post['id']);
         $table->update($post);
      }
   }

   function generatedUsers($post = []) {
      $table = $this->db->table('tb_users');
      $table->insert($post);

      return $this->db->insertID();
   }

   function getData() {
      $table = $this->_queryData();
      if ($_POST['length'] != -1)
         $table->limit($_POST['length'], $_POST['start']);
      return $table->get();
   }
   
   function countData() {
      $table = $this->db->table('tb_profile_usaha');
      $get = $table->get();
      return count($get->getResult());
   }
   
   function filteredData() {
      $table = $this->_queryData();
      $get = $table->get();
      return count($get->getResult());
   }
   
   private function _queryData() {
      $table = $this->db->table('tb_profile_usaha');
      $table->select('id, name, address, phone, email, thumbnail');
   
      $i = 0;
      $column_search = ['name', 'address', 'phone', 'email'];
      $column_order = ['name', 'address', 'phone', 'email'];
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