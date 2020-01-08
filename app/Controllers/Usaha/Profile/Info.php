<?php namespace App\Controllers\Usaha\Profile;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\UsahaController;
use App\Models\Usaha\Profile\Info as Model;
use App\Validation\Usaha\Profile\Info as Validate;

class Info extends UsahaController {

   public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
      parent::initController($request, $response, $logger);
   }

   public function index() {
      $model = new Model();
      $footerJs['detail'] = $model->getDetailProfileUsaha();

      $this->data = [
         'title' => 'Info',
         'internalJs' => ['bundle/usahaProfileInfoForms.js'],
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
            $file = $this->request->getFile('thumbnail');
            if (!empty($file)) {
               $path = ROOTPATH . 'public/img/';
               $newName = $file->getRandomName();
               $file->move($path, $newName);
               @chmod($path . $newName, 0777);

               $post['thumbnail'] = $newName;
            }

            $model = new Model();
            $model->submit($post);

            $response['status'] = true;
            $response['msg_response'] = 'Data saved successfully.';
         } else {
            $response['msg_response'] = 'Something went wrong?';
            $response['errors'] = \Config\Services::validation()->getErrors();
         }
         return $this->response->setJSON($response);
      } else {
         $this->notFound();
      }
   }

}