<?php namespace App\Models\Usaha;

use CodeIgniter\Model;

class Gallery extends Model {

   protected $db;
   protected $id_profile_usaha;

   public function __construct() {
      $this->db = \Config\Database::connect();

      $session = \Config\Services::session();
      $this->id_profile_usaha = $session->get('id_profile_usaha');
   }

   function deleteGallery($post = []) {
      @unlink(ROOTPATH . 'public/img/' . $post['file']);

      $table = $this->db->table('tb_gallery');
      $table->where('id_profile_usaha', $this->id_profile_usaha);
      $table->where('id', $post['id']);
      $table->delete();

      return $this->getGalleryFile();
   }

   function getGalleryFile() {
      $table = $this->db->table('tb_gallery');
      $table->select('id, file, name');
      $table->where('id_profile_usaha', $this->id_profile_usaha);
      $table->orderBy('uploaded', 'desc');

      $get = $table->get();
      $response = [];
      foreach ($get->getResultArray() as $data) {
         array_push($response, [
            'id' => $data['id'],
            'name' => $data['name'],
            'path' => base_url('img/' . $data['file']),
            'file' => $data['file']
         ]);
      }

      return $response;
   }

   function submit($post = []) {
      $table = $this->db->table('tb_gallery');

      if ($post['pageType'] === 'insert') {
         $table->insert([
            'name' => $post['name'],
            'file' => $post['file'],
            'uploaded' => date('Y-m-d H:i:s'),
            'id_profile_usaha' => $this->id_profile_usaha
         ]);
      }

      return $this->getGalleryFile();
   }

}