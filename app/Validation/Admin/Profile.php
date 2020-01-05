<?php namespace App\Validation\Admin;

class Profile {

   public $pageType = [
      'pageType' => 'required|in_list[insert,update,delete]'
   ];

   public $thumbnail = [
      'thumbnail' => 'uploaded[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/gif,image/png]|max_size[thumbnail,2048]'
   ];

   public function generated($post = []) {
      if ($post['pageType'] === 'delete') {
         return array_merge($this->pageType, [
            'id' => 'required|numeric'
         ]);
      } else {
         if (@$post['thumbnail'] !== 'undefined') {
            return array_merge($this->pageType, $this->thumbnail, [
               'id' => $post['pageType'] === 'insert' ? 'permit_empty' : 'required|numeric',
               'id_categories' => [
                  'rules' => 'required|numeric',
                  'errors' => [
                     'required' => 'Can not be empty.',
                     'numeric' => 'Can only be filled with numbers.'
                  ]
               ],
               'name' => [
                  'rules' => 'required',
                  'errors' => [
                     'required' => 'Can not be empty.'
                  ]
               ],
               'address' => [
                  'rules' => 'required',
                  'errors' => [
                     'required' => 'Can not be empty.'
                  ]
               ],
               'phone' => [
                  'rules' => 'required|numeric',
                  'errors' => [
                     'required' => 'Can not be empty.',
                     'numeric' => 'Can only be filled with numbers.'
                  ]
               ],
               'email' => [
                  'rules' => 'required|valid_email',
                  'errors' => [
                     'required' => 'Can not be empty.',
                     'valid_email' => 'The email you entered is invalid.'
                  ]
               ],
               'latitude' => [
                  'rules' => 'required',
                  'errors' => [
                     'required' => 'Can not be empty.'
                  ]
               ],
               'longtitude' => [
                  'rules' => 'required',
                  'errors' => [
                     'required' => 'Can not be empty.'
                  ]
               ]
            ]);
         } else {
            return array_merge($this->pageType, [
               'id' => $post['pageType'] === 'insert' ? 'permit_empty' : 'required|numeric',
               'id_categories' => [
                  'rules' => 'required|numeric',
                  'errors' => [
                     'required' => 'Can not be empty.',
                     'numeric' => 'Can only be filled with numbers.'
                  ]
               ],
               'name' => [
                  'rules' => 'required',
                  'errors' => [
                     'required' => 'Can not be empty.'
                  ]
               ],
               'address' => [
                  'rules' => 'required',
                  'errors' => [
                     'required' => 'Can not be empty.'
                  ]
               ],
               'phone' => [
                  'rules' => 'required|numeric',
                  'errors' => [
                     'required' => 'Can not be empty.',
                     'numeric' => 'Can only be filled with numbers.'
                  ]
               ],
               'email' => [
                  'rules' => 'required|valid_email',
                  'errors' => [
                     'required' => 'Can not be empty.',
                     'valid_email' => 'The email you entered is invalid.'
                  ]
               ],
               'latitude' => [
                  'rules' => 'required',
                  'errors' => [
                     'required' => 'Can not be empty.'
                  ]
               ],
               'longtitude' => [
                  'rules' => 'required',
                  'errors' => [
                     'required' => 'Can not be empty.'
                  ]
               ]
            ]);
         }
      }
   }

}