<?php namespace App\Validation\Usaha;

class Account {

   public $pageType = [
      'pageType' => 'required|in_list[insert,update,delete]'
   ];

   public function generated($post = []) {
      return array_merge($this->pageType, [
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
               'valid_email' => 'The email you entered is invalid.'
            ]
         ],
         'password' => [
            'rules' => 'matches[confirm_password]',
            'errors' => [
               'matches' => 'Passwords don\'t match'
            ]
         ],
         'confirm_password' => [
            'rules' => 'matches[password]',
            'errors' => [
               'matches' => 'Passwords don\'t match'
            ]
         ],
      ]);
   }

}