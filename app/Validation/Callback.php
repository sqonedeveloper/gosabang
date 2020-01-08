<?php namespace App\Validation;

class Callback {

   public function checkNumeric(string $str, string &$error = null) : bool {
      $str = (int) str_replace('.', '', $str);

      if (!is_numeric($str)) {
         $error = 'Can only be filled with numbers.';
         return false;
      }
      return true;
   }

   public function checkExistsUsername(string $str, string &$error = null) : bool {
      $db = \Config\Database::connect();
      $table = $db->table('tb_users');
      $table->where('username', $str);
      $table->where('status', '1');

      $get = $table->get();
      $data = $get->getRowArray();

      if (isset($data)) {
         return true;
      } else {
         return false;
      }
   }

}