<?php namespace App\Validation\Admin\Users;

class Profile {

   public function generated($post = []) {
      return [
         'name' => [
            'rules' => 'required',
            'errors' => [
               'required' => 'Can not be empty.'
            ]
         ],
         'username' => [
            'rules' => 'required',
            'errors' => [
               'required' => 'Can not be empty.'
            ]
         ],
         'email' => [
            'rules' => 'required|valid_email',
            'errors' => [
               'required' => 'Can not be empty.',
               'valid_email' => 'Email not valid.'
            ]
         ],
         'password' => [
            'rules' => 'matches[confirm_password]',
            'errors' => [
               'matches' => 'Passwort not matches.'
            ]
         ],
         'confirm_password' => [
            'rules' => 'matches[password]',
            'errors' => [
               'matches' => 'Passwort not matches.'
            ]
         ]
      ];
   }

}