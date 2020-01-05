<?php namespace App\Models\Usaha;

use CodeIgniter\Model;

class Account extends Model {

   protected $db;
   protected $username;
   protected $email;

   public function __construct($username, $email) {
      $this->db = \Config\Database::connect();

      $this->username = $username;
      $this->email = $email;
   }

   function submit($post = []) {
      unset($post['pageType'], $post['email'], $post['username'], $post['confirm_password']);

      if (!empty($post['password'])) {
         $post['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
      } else {
         unset($post['password']);
      }

      $table = $this->db->table('tb_users');
      $table->where('username', $this->username);
      $table->where('email', $this->email);
      $table->update($post);
   }

   function getDetailContent() {
      $table = $this->db->table('tb_users');
      $table->select('name, username, email');
      $table->where('username', $this->username);
      $table->where('email', $this->email);

      $get = $table->get();
      $data = $get->getRowArray();

      if (isset($data)) {
         return $data;
      } else {
         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
      }
   }

}