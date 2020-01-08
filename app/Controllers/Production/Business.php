<?php namespace App\Controllers\Production;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\ProductionController;
use App\Models\Production\Business as Model;

class Business extends ProductionController {

   public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
      parent::initController($request, $response, $logger);
   }

   public function index($id) {
      $model = new Model();
      $footerJs['listsCategories'] = $model->getListsCategories();
      $footerJs['detail'] = $model->getDetailUsaha($id);
      $footerJs['usahaGallery'] = $model->getUsahaGallery($id);
      $footerJs['itemLists'] = $model->getProductItem($id);

      $this->data = [
         'title' => 'Business',
         'internalJs' => ['bundle/businessDetail.js'],
         'footerJs' => $footerJs
      ];

      $this->template($this->data);
   }

}