<?php namespace App\Validation\Admin\Users;

class Account {

   public $pageType = [
      'pageType' => 'required|in_list[insert,update,delete]'
   ];

   public function generated($post = []) {
      return $this->{$post['pageType']}($post);
   }

   public function insert($post = []) {
      return array_merge($this->pageType, [
         'name' => [
            'rules' => 'required',
            'errors' => [
               'required' => 'Can not be empty.'
            ]
         ],
         'username' => [
            'rules' => 'required|is_unique[tb_users.username]',
            'errors' => [
               'required' => 'Can not be empty.',
               'is_unique' => 'Username already exists.'
            ]
         ],
         'email' => [
            'rules' => 'required|is_unique[tb_users.email]',
            'errors' => [
               'required' => 'Can not be empty.',
               'is_unique' => 'Email already exists.'
            ]
         ],
         'password' => [
            'rules' => 'required',
            'errors' => [
               'required' => 'Can not be empty.'
            ]
         ],
         'role' => [
            'rules' => 'required|numeric',
            'errors' => [
               'required' => 'Can not be empty.',
               'numeric' => 'Can only be filled with numbers.'
            ]
         ],
         'status' => [
            'rules' => 'required|numeric',
            'errors' => [
               'required' => 'Can not be empty.',
               'numeric' => 'Can only be filled with numbers.'
            ]
         ],
         'id_profile_usaha' => [
            'rules' => $post['role'] === '2' ? 'required|numeric' : 'permit_empty',
            'errors' => [
               'required' => 'Can not be empty.',
               'numeric' => 'Can only be filled with numbers.'
            ]
         ],
      ]);
   }

   public function update($post = []) {
      return array_merge($this->pageType, [
         'id' => 'required|numeric',
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
            'rules' => 'required',
            'errors' => [
               'required' => 'Can not be empty.'
            ]
         ],
         'status' => [
            'rules' => 'required|numeric',
            'errors' => [
               'required' => 'Can not be empty.'
            ]
         ],
      ]);
   }

   public function delete() {
      return array_merge($this->pageType, [
         'id' => 'required|numeric'
      ]);
   }

}