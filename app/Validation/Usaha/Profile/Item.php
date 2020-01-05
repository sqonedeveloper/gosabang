<?php namespace App\Validation\Usaha\Profile;

class Item {

   public $pageType = [
      'pageType' => 'required|in_list[insert,update,delete]'
   ];

   public function generated($post = []) {
      if ($post['pageType'] === 'delete') {
         return array_merge($this->pageType, [
            'id' => 'required|numeric'
         ]);
      } else {
         return array_merge($this->pageType, [
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