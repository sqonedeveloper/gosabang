<?php namespace App\Validation\Admin;

class Blog {

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
            'id' => $post['pageType'] === 'update' ? 'required|numeric' : 'permit_empty',
            'title' => [
               'rules' => 'required',
               'errors' => [
                  'required' => 'Can not be empty.'
               ]
            ],
            'id_categories' => [
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