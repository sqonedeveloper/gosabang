<?php namespace App\Validation\Admin\Users;

class Account {

   public $pageType = [
      'pageType' => 'required|in_list[insert,update,delete]'
   ];

   public function generated($post = []) {
      if ($post['pageType'] === 'delete') {
         return array_merge($this->pageType, [
            'id' => 'required|numeric'
         ]);
      }
   }

}