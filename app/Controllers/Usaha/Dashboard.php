<?php namespace App\Controllers\Usaha;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\UsahaController;

class Dashboard extends UsahaController {

   public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
      parent::initController($request, $response, $logger);
   }

   public function index() {
      $this->data = [
         'title' => 'Dashboard',
         'internalJs' => ['bundle/usahaDashboard.js']
      ];

      $this->template($this->data);
   }

}