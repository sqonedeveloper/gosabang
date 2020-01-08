<?php namespace App\Models\Admin;

use CodeIgniter\Model;

class Dashboard extends Model {

   protected $db;

   public function __construct() {
      $this->db = \Config\Database::connect();
   }

   function getCountingData() {
      $response = [
         'categories' => $this->_countCategories(),
         'profile' => $this->_countProfileUsaha(),
         'blog' => $this->_countBlog()
      ];
      return $response;
   }

   private function _countCategories() {
      $table = $this->db->table('tb_categories');
      $table->select('count(*) as count');

      $get = $table->get();
      $data = $get->getRowArray();

      return $data['count'];
   }
   
   private function _countProfileUsaha() {
      $table = $this->db->table('tb_profile_usaha');
      $table->select('count(*) as count');

      $get = $table->get();
      $data = $get->getRowArray();

      return $data['count'];
   }
   
   private function _countBlog() {
      $table = $this->db->table('tb_blog');
      $table->select('count(*) as count');

      $get = $table->get();
      $data = $get->getRowArray();

      return $data['count'];
   }

}