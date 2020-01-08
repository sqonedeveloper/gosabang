<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class BaseController extends Controller {

	protected $helpers = [
      'style',
      'autoload',
      'text'
   ];

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger) {
		parent::initController($request, $response, $logger);

		$this->app = new \Config\App();
	}

	public function generateSegment() {
		$string = uri_string();
      $exp_string = explode('/', $string);

      $set_segment = [];
      for ($i = 0; $i < count($exp_string); $i++) {
         $set_segment[$i + 1] = $exp_string[$i];
      }

      return json_encode($set_segment);
	}

	public function emptyPost($post = []) {
      $response = [];
      foreach ($post as $key => $val) {
         $response[$key] = '';
      }
      return $response;
   }

   public function notFound() {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
   }

   public function getDefaultSitesConfig() {
      $response = [
         'nama' => 'Go Sabang'
      ];

      return $response;
   }

   public function getUsersLogin() {
      $session = \Config\Services::session();

      $response = [
         'nama' => $session->get('name'),
         'email' => $session->get('email'),
         'role' => $session->get('role')
      ];
      return $response;
   }

}
