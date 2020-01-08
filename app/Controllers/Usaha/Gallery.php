<?php namespace App\Controllers\Usaha;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\UsahaController;
use App\Validation\Usaha\Gallery as Validate;
use App\Models\Usaha\Gallery as Model;

class Gallery extends UsahaController {

   public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
      parent::initController($request, $response, $logger);
   }

   public function index() {
      $model = new Model();
      $footerJs['detail'] = $model->getGalleryFile();

      $this->data = [
         'title' => 'Gallery',
         'internalCss' => $this->app->magnific['css'],
         'internalJs' => [
            $this->app->magnific['js'],
            'bundle/usahaGallery.js'
         ],
         'footerJs' => $footerJs
      ];

      $this->template($this->data);
   }

   public function submit() {
      if ($this->request->isAJAX()) {
         $response = ['status' => false, 'errors' => [], 'msg_response' => ''];
         $post = $this->request->getVar();
         $validate = new Validate();
      
         if ($this->validate($validate->generated($post))) {
            $file = $this->request->getFile('file');
            if (!empty($file)) {
               $path = ROOTPATH . 'public/img/';
               $newName = $file->getRandomName();
               $file->move($path, $newName);
               @chmod($path . $newName, 0777);

               $post['file'] = $newName;
            }

            $model = new Model();
            $content = $model->submit($post);

            $response['status'] = true;
            $response['msg_response'] = 'Data saved successfully.';
            $response['emptyPost'] = $this->emptyPost($post);
            $response['detail'] = $content;
         } else {
            $response['msg_response'] = 'Something went wrong?';
            $response['errors'] = \Config\Services::validation()->getErrors();
         }
         return $this->response->setJSON($response);
      } else {
         $this->notFound();
      }
   }

   public function delete() {
      if ($this->request->isAJAX()) {
         $response = ['status' => false, 'errors' => [], 'msg_response' => ''];
         $post = $this->request->getVar();
         $validate = new Validate();
      
         if ($this->validate($validate->generated($post))) {
            $model = new Model();
            $delete = $model->deleteGallery($post);

            $response['status'] = true;
            $response['msg_response'] = 'Data successfully deleted.';
            $response['detail'] = $delete;
         } else {
            $response['msg_response'] = 'Failed to delete data?';
            $response['errors'] = \Config\Services::validation()->getErrors();
         }
         return $this->response->setJSON($response);
      } else {
         $this->notFound();
      }
   }

}