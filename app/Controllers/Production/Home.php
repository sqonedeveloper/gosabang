<?php namespace App\Controllers\Production;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\ProductionController;
use App\Models\Production\Home as Model;

class Home extends ProductionController {

   public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
      parent::initController($request, $response, $logger);
   }

   public function index() {
      $model = new Model();
      $footerJs['listsCategories'] = $model->getListsCategories();

      $this->data = [
         'title' => 'Go Sabang',
         'internalJs' => ['bundle/home.js'],
         'footerJs' => $footerJs
      ];

      $this->template($this->data);
   }

}