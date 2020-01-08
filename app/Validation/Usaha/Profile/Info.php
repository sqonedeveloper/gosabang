<?php namespace App\Validation\Usaha\Profile;

class Info {

   public $thumbnail = [
      'thumbnail' => 'uploaded[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/gif,image/png]|max_size[thumbnail,2048]'
   ];

   public function generated($post = []) {
      if (@$post['thumbnail'] !== 'undefined') {
         return array_merge($this->thumbnail, [
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
         return [
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
         ];
      }
   }

}