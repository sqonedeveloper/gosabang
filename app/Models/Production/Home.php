<?php namespace App\Models\Production;

use CodeIgniter\Model;

class Home extends Model {

   protected $db;

   public function __construct() {
      $this->db = \Config\Database::connect();
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