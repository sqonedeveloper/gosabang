<?php namespace App\Controllers\Production;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\ProductionController;
use App\Models\Production\Categories as Model;

class Categories extends ProductionController {

   public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
      parent::initController($request, $response, $logger);
   }

   public function index($slug) {
      $model = new Model();
      $footerJs['listsCategories'] = $model->getListsCategories();
      $footerJs['detailCategories'] = $model->getDetailCategories($slug);
      $footerJs['listsUsaha'] = $model->getListsUsaha($slug);

      $this->data = [
         'title' => 'Categories',
         'internalJs' => ['http://localhost:8080/categoriesLists.js'],
         'footerJs' => $footerJs
      ];

      $this->template($this->data);
   }

   public function detail($id) {
      
   }

}