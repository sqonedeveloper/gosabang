<?php namespace App\Validation;

class Callback {

   public function uploadIcon($str, &$error = null) : bool {
      try {
         $files = $_FILES;
         $file_name = $files['icon']['name'];
         
         $target_dir = ROOTPATH . 'public/img/';
         $target_file = $target_dir . basename($file_name);
         $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
         

         
         $error = $imageFileType;
         return false;
      } catch (\CodeIgniter\UnknownFileException $e) {
         throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
      }
   }

}