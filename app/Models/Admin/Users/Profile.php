<?php namespace App\Models\Admin\Users;

use CodeIgniter\Model;

class Profile extends Model {

   protected $db;
   protected $username;

   public function __construct() {
      $this->db = \Config\Database::connect();

      $session = \Config\Services::session();
      $this->username = $session->get('username');
   }

   public function getDetailContent() {
      $table = $this->db->table('tb_users');
      $table->select('name, username, email');
      $table->where('username', $this->username);

      $get = $table->get();
      $data = $get->getRowArray();

      if (isset($data)) {
         return $data;
      } else {
         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
      }
   }

   public function submit($post = []) {
      if (!empty($post['password'])) {
         $post['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
      }

      unset($post['confirm_password']);

      $table = $this->db->table('tb_users');
      $table->where('username', $post['username']);
      $table->where('email', $post['email']);
      $table->update($post);
   }

}