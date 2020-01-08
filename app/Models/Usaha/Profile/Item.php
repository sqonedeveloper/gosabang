<?php namespace App\Models\Usaha\Profile;

use CodeIgniter\Model;

class Item extends Model {

   protected $db;
   protected $id_profile_usaha;

   public function __construct() {
      $this->db = \Config\Database::connect();

      $session = \Config\Services::session();
      $this->id_profile_usaha = $session->get('id_profile_usaha');
   }

   function deleteItems($post = []) {
      @unlink(ROOTPATH . 'public/img/' . $post['image']);

      $table = $this->db->table('tb_items');
      $table->where('id', $post['id']);
      $table->where('id_profile_usaha', $this->id_profile_usaha);
      $table->delete();
   }

   function getDetailEdit($id) {
      $table = $this->db->table('tb_items');
      $table->select('name');
      $table->where('id', $id);
      $table->where('id_profile_usaha', $this->id_profile_usaha);

      $get = $table->get();
      $data = $get->getRowArray();

      if (isset($data)) {
         return $data;
      } else {
         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
      }
   }

   function submit($post = []) {
      $table = $this->db->table('tb_items');

      $post['modified'] = date('Y-m-d H:i:s');
      $post['slug'] = url_title($post['name'], 'dash', true);
      $post['id_profile_usaha'] = $this->id_profile_usaha;

      if ($post['pageType'] === 'insert') {
         unset($post['pageType'], $post['id']);

         $post['uploaded'] = date('Y-m-d H:i:s');
         $table->insert($post);
      } else if ($post['pageType'] === 'update') {
         unset($post['pageType']);

         $table->where('id', $post['id']);
         $table->update($post);
      }
   }

   function getData() {
      $table = $this->_queryData();
      if ($_POST['length'] != -1)
         $table->limit($_POST['length'], $_POST['start']);
      return $table->get();
   }
   
   function countData() {
      $table = $this->db->table('tb_items');
      $table->where('id_profile_usaha', $this->id_profile_usaha);
      $get = $table->get();
      return count($get->getResult());
   }
   
   function filteredData() {
      $table = $this->_queryData();
      $get = $table->get();
      return count($get->getResult());
   }
   
   private function _queryData() {
      $table = $this->db->table('tb_items');
      $table->select('id, name, image, price');
      $table->where('id_profile_usaha', $this->id_profile_usaha);
      $table->select('id, name');
   
      $i = 0;
      $column_search = ['name'];
      $column_order = ['id', 'name'];
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