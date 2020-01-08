<?php namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\BaseController;
use App\Validation\Login as Validate;

class Login extends BaseController {

   protected $db;

   public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
      parent::initController($request, $response, $logger);

      $this->db = \Config\Database::connect();
   }

   public function index() {
      $this->data = [
         'title' => 'Login',
         'internalJs' => script_tag([
            'bundle/vendor.js',
            'bundle/login.js',
         ])
      ];

      return view('LoginPanel', $this->data);
   }

   public function submit() {
      if ($this->request->isAJAX()) {
         $response = ['status' => false, 'errors' => [], 'msg_response' => ''];
         $post = $this->request->getVar();
         $validate = new Validate();
      
         if ($this->validate($validate->generated($post))) {
            $checkUsers = $this->_resolve_user_login($post['username'], $post['password']);
            unset($checkUsers['password']);

            $response['users'] = $checkUsers;
            if ($checkUsers) {
               $session = \Config\Services::session();
               $session->set('isLogin', true);
               $session->set($checkUsers);

               $response['status'] = true;
               $response['msg_response'] = 'Anda berhasil login, halaman segera dialihkan.';
               $response['role'] = $checkUsers['role'];
            } else {
               $response['msg_response'] = 'Username atau password salah!';
            }
         } else {
            $response['msg_response'] = 'Username atau password anda masukkan salah?';
            $response['errors'] = \Config\Services::validation()->getErrors();
         }
         return $this->response->setJSON($response);
      } else {
         $this->notFound();
      }
   }

   private function _resolve_user_login($username, $password) {
      $table = $this->db->table('tb_users a');
      $table->select('a.name, a.username, a.email, a.role, b.id as id_profile_usaha, a.password');
      $table->join('tb_profile_usaha b', 'b.id_users = a.id', 'left');
      $table->where('a.username', $username);

      $get = $table->get();
      $data = $get->getRowArray();

      
      if (isset($data)) {
         $verify = password_verify($password, $data['password']);
         
         if ($verify) {
            return $data;
         } else {
            return false;
         }
      } else {
         return false;
      }
   }

   private function _verify_password_hash($password, $hash) {
      return password_verify($password, $hash);
   }

   public function logout() {
      $session = \Config\Services::session();
      $session->destroy();
      return redirect()->to(site_url('login'));
   }

}