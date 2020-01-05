<?php namespace App\Validation;

class Login {

   public function generated($post = []) {
      return [
         'username' => 'required|callbackCheckExistsUsername',
         'password' => 'required'
      ];
   }

}