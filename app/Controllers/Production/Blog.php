<?php namespace App\Controllers\Production;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\ProductionController;
use App\Models\Production\Blog as Model;

class Blog extends ProductionController {

   public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
      parent::initController($request, $response, $logger);
   }

   public function index($id) {
      $model = new Model();
      $footerJs['listsCategories'] = $model->getListsCategories();
      $footerJs['detail'] = $model->getDetailBlog($id);

      $this->data = [
         'title' => 'Blog',
         'internalJs' => ['bundle/blogDetail.js'],
         'footerJs' => $footerJs
      ];

      $this->template($this->data);
   }

}