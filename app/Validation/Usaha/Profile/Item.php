<?php namespace App\Validation\Usaha\Profile;

class Item {

   public $pageType = [
      'pageType' => 'required|in_list[insert,update,delete]'
   ];

   public $image = [
      'image' => 'uploaded[image]|mime_in[image,image/jpg,image/jpeg,image/gif,image/png]|max_size[image,2048]'
   ];

   public function generated($post = []) {
      if ($post['pageType'] === 'delete') {
         return array_merge($this->pageType, [
            'id' => 'required|numeric'
         ]);
      } else {
         if (@$post['thumbnail'] !== 'undefined') {
            return array_merge($this->pageType, $this->image, [
               'name' => [
                  'rules' => 'required',
                  'errors' => [
                     'required' => 'Can not be empty.'
                  ]
               ],
               'price' => [
                  'rules' => 'required|numeric',
                  'errors' => [
                     'required' => 'Can not be empty.',
                     'numeric' => 'Can only be filled with numbers.'
                  ]
               ]
            ]);
         } else {
            return array_merge($this->pageType, [
               'name' => [
                  'rules' => 'required',
                  'errors' => [
                     'required' => 'Can not be empty.'
                  ]
               ],
               'price' => [
                  'rules' => 'required|numeric',
                  'errors' => [
                     'required' => 'Can not be empty.',
                     'numeric' => 'Can only be filled with numbers.'
                  ]
               ]
            ]);
         }
      }
   }

}