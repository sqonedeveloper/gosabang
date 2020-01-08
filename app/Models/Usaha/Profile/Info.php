<?php namespace App\Models\Usaha\Profile;

use CodeIgniter\Model;

class Info extends Model {

   protected $db;
   protected $id_profile_usaha;

   public function __construct() {
      $this->db = \Config\Database::connect();

      $session = \Config\Services::session();
      $this->id_profile_usaha = $session->get('id_profile_usaha');
   }

   function submit($post = []) {
      if ($post['thumbnail'] === 'undefined') {
         unset($post['thumbnail']);
      } else {
         @unlink(ROOTPATH . 'public/img/' . $post['old_thumbnail']);
      }

      unset($post['old_thumbnail']);

      $table = $this->db->table('tb_profile_usaha');
      $table->where('id', $this->id_profile_usaha);
      $table->update($post);
   }

   function getDetailProfileUsaha() {
      $table = $this->db->table('tb_profile_usaha');
      $table->select('name, address, phone, email, latitude, longtitude, thumbnail');
      $table->where('id', $this->id_profile_usaha);

      $get = $table->get();
      $data = $get->getRowArray();

      if (isset($data)) {
         return $data;
      } else {
         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
      }
   }

}