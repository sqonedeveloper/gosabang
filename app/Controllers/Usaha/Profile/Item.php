<?php namespace App\Controllers\Usaha\Profile;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\UsahaController;
use App\Validation\Usaha\Profile\Item as Validate;
use App\Models\Usaha\Profile\Item as Model;

class Item extends UsahaController {

   public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
      parent::initController($request, $response, $logger);
   }

   public function index() {
      $this->data = [
         'title' => 'Item',
         'pageType' => 'insert',
         'internalCss' => $this->app->datatable['css'],
         'internalJs' => [
            $this->app->datatable['js'],
            'bundle/usahaProfileItemForms.js'
         ]
      ];

      $this->template($this->data);
   }
   
   public function edit($id) {
      $model = new Model();
      $footerJs['detail'] = $model->getDetailEdit($id);

      $this->data = [
         'title' => 'Edit Item',
         'pageType' => 'update',
         'internalCss' => $this->app->datatable['css'],
         'internalJs' => [
            $this->app->datatable['js'],
            'bundle/usahaProfileItemForms.js'
         ],
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
            $file = $this->request->getFile('image');
            if (!empty($file)) {
               $path = ROOTPATH . 'public/img/';
               $newName = $file->getRandomName();
               $file->move($path, $newName);
               @chmod($path . $newName, 0777);

               $post['image'] = $newName;
            }

            $model = new Model();
            $model->submit($post);

            $response['status'] = true;
            $response['msg_response'] = 'Data saved successfully.';
            $response['emptyPost'] = $this->emptyPost($post);
         } else {
            $response['msg_response'] = 'Something went wrong?';
            $response['errors'] = \Config\Services::validation()->getErrors();
         }
         return $this->response->setJSON($response);
      } else {
         $this->notFound();
      }
   }

   public function getData() {
      if ($this->request->isAJAX()) {
         $model = new Model();
         $query = $model->getData();
   
         $i = $_POST['start'];
         $response = [];
         foreach ($query->getResultArray() as $data) {
            $i++;
   
            $action = '<div class="row-actions">';
            $action .= '<span class="edit"><a data-id="'.$data['id'].'">Edit</a></span>';
            $action .= '<span class="delete"><a data-id="'.$data['id'].'" data-image="'.$data['image'].'" data-type="delete">Delete</a></span>';
            $action .= '</div>';
   
            $result = [];
            $result[] = '<img src="' . base_url('img/' . $data['image']) . '" class="img-thumbnail" style="width: 50px; height: 50px;" />';
            $result[] = $data['name'] . '<br/>' . $action;
            $result[] = number_format($data['price'], 0, '', '.');
   
            $response[] = $result;
         }
   
         $output = [
            'draw' => intval($_POST['draw']),
            'recordsTotal' => intval($model->countData()),
            'recordsFiltered' => intval($model->filteredData()),
            'data' => $response
         ];
   
         return $this->response->setJSON($output);
      } else {
         $this->notFound();
      }
   }

   public function delete() {
      if ($this->request->isAJAX()) {
         $response = ['status' => false, 'errors' => [], 'msg_response' => ''];
         $post = $this->request->getVar();
         $validate = new Validate();
      
         if ($this->validate($validate->generated($post))) {
            $model = new Model();
            $model->deleteItems($post);

            $response['status'] = true;
            $response['msg_response'] = 'Data successfully deleted.';
         } else {
            $response['msg_response'] = 'Failed to delete data?';
            $response['errors'] = \Config\Services::validation()->getErrors();
         }
         return $this->response->setJSON($response);
      } else {
         $this->notFound();
      }
   }

}