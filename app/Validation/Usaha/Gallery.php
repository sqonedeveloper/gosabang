<?php namespace App\Validation\Usaha;

class Gallery {

   public $pageType = [
      'pageType' => 'required|in_list[insert,update,delete]'
   ];

   public $file = [
      'file' => 'uploaded[file]|mime_in[file,image/jpg,image/jpeg,image/gif,image/png]|max_size[file,2048]'
   ];

   public function generated($post = []) {
      if ($post['pageType'] === 'delete') {
         return array_merge($this->pageType, [
            'id' => 'required|numeric',
            'file' => 'required'
         ]);
      } else {
         return array_merge($this->pageType, $this->file, [
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