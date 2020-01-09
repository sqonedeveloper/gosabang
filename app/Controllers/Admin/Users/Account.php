<?php namespace App\Controllers\Admin\Users;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\AdminController;
use App\Models\Admin\Users\Account as Model;
use App\Validation\Admin\Users\Account as Validate;

class Account extends AdminController {

   public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
      parent::initController($request, $response, $logger);
   }

   public function index() {
      $this->data = [
         'title' => 'Account',
         'internalCss' => $this->app->datatable['css'],
         'internalJs' => [
            $this->app->datatable['js'],
            'bundle/adminUsersAccount.js'
         ]
      ];

      $this->template($this->data);
   }

   public function addNew() {
      $model = new Model();
      $footerJs['listsProfile'] = $model->getListsProfile();

      $this->data = [
         'title' => 'Add New Account',
         'pageType' => 'insert',
         'internalJs' => ['bundle/adminUsersAccountForms.js'],
         'footerJs' => $footerJs
      ];

      $this->template($this->data);
   }
   
   
   public function edit($id) {
      $model = new Model();
      $footerJs['listsProfile'] = $model->getListsProfile();
      $footerJs['detail'] = $model->getDetailEdit($id);

      $this->data = [
         'title' => 'Edit Account',
         'pageType' => 'update',
         'internalJs' => ['bundle/adminUsersAccountForms.js'],
         'footerJs' => $footerJs
      ];

      $this->template($this->data);
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
            $action .= '<span class="delete"><a data-id="'.$data['id'].'" data-type="delete">Delete</a></span>';
            $action .= '</div>';
   
            $result = [];
            $result[] = $data['name'] . '<br/>' . $action;
            $result[] = $data['username'] . '<br/>' . $data['email'];
            $result[] = userRoles($data['role']);
            $result[] = userStatus($data['status']);
            $result[] = $data['modified'];
   
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
            $model->deleteAccount($post);

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

   public function submit() {
      if ($this->request->isAJAX()) {
         $response = ['status' => false, 'errors' => [], 'msg_response' => ''];
         $post = $this->request->getVar();
         $validate = new Validate();
      
         if ($this->validate($validate->generated($post))) {
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

}