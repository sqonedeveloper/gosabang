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

}