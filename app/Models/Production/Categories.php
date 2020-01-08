<?php namespace App\Models\Production;

use CodeIgniter\Model;

class Categories extends Model {

   protected $db;

   public function __construct() {
      $this->db = \Config\Database::connect();
   }

   function getListsUsaha($slug) {
      $usaha = $this->_getListsUsahaByCategories($slug);
      $blog = $this->_getListsBlogByCategories($slug);

      $res_usaha = [];
      foreach ($usaha as $data) {
         array_push($res_usaha, [
            'url' => site_url('business/' . $data['id_profile_usaha']),
            'name' => $data['usaha'],
            'address' => $data['address'],
            'thumbnail' => base_url('img/' . $data['thumbnail']),
            'string' => 'text'
         ]);
      }

      $res_blog = [];
      foreach ($blog as $data) {
         array_push($res_blog, [
            'url' => site_url('blog/' . $data['id']),
            'name' => $data['title'],
            'address' => word_limiter(strip_tags(html_entity_decode($data['content'])), 5),
            'thumbnail' => base_url('img/default.jpg'),
            'string' => 'html'
         ]);
      }
      return array_merge($res_usaha, $res_blog);
   }

   private function _getListsBlogByCategories($slug) {
      $table = $this->db->table('tb_categories a');
      $table->select('b.id, b.title, b.content');
      $table->join('tb_blog b', 'b.id_categories = a.id');
      $table->where('a.slug', $slug);

      $get = $table->get();
      return $get->getResultArray();
   }
   
   private function _getListsUsahaByCategories($slug) {
      $table = $this->db->table('tb_categories a');
      $table->select('b.name as usaha, b.address, b.thumbnail, b.id as id_profile_usaha');
      $table->join('tb_profile_usaha b', 'b.id_categories = a.id');
      $table->where('a.slug', $slug);

      $get = $table->get();
      return $get->getResultArray();
   }

   function getDetailCategories($slug) {
      $table = $this->db->table('tb_categories');
      $table->select('name, slug');
      $table->where('slug', $slug);

      $get = $table->get();
      $data = $get->getRowArray();

      if (isset($data)) {
         return $data;
      } else {
         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
      }
   }

   function getListsCategories() {
      $table = $this->db->table('tb_categories');
      $table->select('name, slug, icon');
      $table->orderBy('name', 'asc');

      $get = $table->get();

      $response = [];
      foreach ($get->getResultArray() as $data) {
         array_push($response, [
            'url' => site_url('categories/' . $data['slug']),
            'icon' => base_url('img/' . $data['icon']),
            'label' => $data['name']
         ]);
      }
      return $response;
   }

}