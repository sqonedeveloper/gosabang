<?php namespace App\Validation\Admin;

class Categories {

   public $pageType = [
      'pageType' => 'required|in_list[insert,update,delete]'
   ];

   public $icon = [
      'icon' => 'uploaded[icon]|mime_in[icon,image/jpg,image/jpeg,image/gif,image/png]|max_size[icon,2048]'
   ];

   public function generated($post = []) {
      if ($post['pageType'] === 'delete') {
         return array_merge($this->pageType, [
            'id' => 'required|numeric'
         ]);
      } else {
         if (@$post['icon'] !== 'undefined') {
            return array_merge($this->pageType, $this->icon, [
               'id' => $post['pageType'] === 'insert' ? 'permit_empty' : 'required|numeric',
               'name' => [
                  'rules' => 'required',
                  'errors' => [
                     'required' => 'Can not be empty.'
                  ]
               ]
            ]);
         } else {
            return array_merge($this->pageType, [
               'id' => $post['pageType'] === 'insert' ? 'permit_empty' : 'required|numeric',
               'name' => [
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