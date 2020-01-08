<?php namespace App\Controllers\Usaha;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\UsahaController;
use App\Models\Usaha\Account as Model;
use App\Validation\Usaha\Account as Validate;

class Account extends UsahaController {

   protected $username;
   protected $email;

   public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
      parent::initController($request, $response, $logger);

      $session = \Config\Services::session();
      $this->username = $session->get('username');
      $this->email = $session->get('email');
   }

   public function index() {
      $model = new Model($this->username, $this->email);

      $footerJs['detail'] = $model->getDetailContent();

      $this->data = [
         'title' => 'Account',
         'internalJs' => ['bundle/usahaAccount.js'],
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
            $model = new Model($this->username, $this->email);
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