<?php namespace App\Controllers\Admin;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\AdminController;
use App\Models\Admin\Dashboard as Model;

class Dashboard extends AdminController {

   public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
      parent::initController($request, $response, $logger);
   }

   public function index() {
      $model = new Model();
      $footerJs['counting'] = $model->getCountingData();

      $this->data = [
         'title' => 'Dashboard',
         'internalJs' => ['bundle/adminDashboard.js'],
         'footerJs' => $footerJs
      ];

      $this->template($this->data);
   }

}