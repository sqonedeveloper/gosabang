<?php namespace App\Models\Production;

use CodeIgniter\Model;

class Business extends Model {

   protected $db;

   public function __construct() {
      $this->db = \Config\Database::connect();
   }

   function getProductItem($id) {
      $table = $this->db->table('tb_items');
      $table->select('name, price, image');
      $table->where('id_profile_usaha', $id);

      $get = $table->get();

      $response = [];
      foreach ($get->getResultArray() as $data) {
         array_push($response, [
            'name' => $data['name'],
            'price' => 'Rp ' . number_format($data['price'], 0, '', '.'),
            'image' => base_url('img/' . $data['image'])
         ]);
      }
      return $response;
   }

   function getUsahaGallery($id) {
      $table = $this->db->table('tb_gallery');
      $table->select('name, file');
      $table->where('id_profile_usaha', $id);

      $get = $table->get();

      $response = [];
      foreach ($get->getResultArray() as $data) {
         array_push($response, [
            'name' => $data['name'],
            'path' => base_url('img/' . $data['file'])
         ]);
      }
      return $response;
   }

   function getDetailUsaha($id) {
      $table = $this->db->table('tb_profile_usaha a');
      $table->select('a.name, a.address, a.phone, a.email, a.latitude, a.longtitude');
      $table->where('a.id', $id);

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