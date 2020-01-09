<?php namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\BaseController;

class AdminController extends BaseController {

   public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
      parent::initController($request, $response, $logger);

      $this->_checkLogin();
   }

   private function _checkLogin() {
      $session = \Config\Services::session();

      $is_login = $session->get('isLogin');
      $role = $session->get('role');

      if (!$is_login || $role !== '1') {
         $msg = 'Do you have to <a href="'.site_url('login').'">log in</a> first?';
         die($msg);
      }
   }

   public function template($content = []) {
      $internalCss = [];
      if (!empty($content['internalCss'])) {
         foreach ($content['internalCss'] as $key) {
            $internalCss[] = $key;
         }
      }

      $internalJs = [
         'http://localhost:8080/vendor.js',
         'http://localhost:8080/topbar.js',
         'http://localhost:8080/sidebar.js'
      ];
      
      if (!empty($content['internalJs'])) {
         foreach ($content['internalJs'] as $key) {
            $internalJs[] = $key;
         }
      }

      $footerJs['navigation'] = $this->_generateNavigation();
      $footerJs['sites'] = $this->getDefaultSitesConfig();
      $footerJs['users'] = $this->getUsersLogin();
      if (!empty($content['footerJs'])) {
         foreach ($content['footerJs'] as $key => $val) {
            $footerJs[$key] = $val;
         }
      }

      $data['title'] = $content['title'];
      $data['internalCss'] = css_tag($internalCss);
      $data['internalJs'] = script_tag($internalJs);
      $data['segment'] = $this->generateSegment();
      $data['pageType'] = @$content['pageType'];
      $data['footerJs'] = json_encode($footerJs);

      echo view('AdminPanel', $data);
   }

   private function _generateNavigation() {
      $config = [
         [
            'label' => 'Dashboard',
            'icon' => 'mdi mdi-gauge',
            'active' => ['dashboard'],
            'url' => '/admin/dashboard',
            'sub' => false
         ],
         [
            'label' => 'Categories',
            'icon' => 'mdi mdi-access-point',
            'active' => ['categories'],
            'url' => '/admin/categories',
            'sub' => false
         ],
         [
            'label' => 'Profile',
            'icon' => 'mdi mdi-account-box-outline',
            'active' => ['profile'],
            'url' => '/admin/profile',
            'sub' => false
         ],
         [
            'label' => 'Blog',
            'icon' => 'mdi mdi-book-open-page-variant',
            'active' => ['blog'],
            'url' => '/admin/blog',
            'sub' => false
         ],
         [
            'label' => 'Users',
            'icon' => 'mdi mdi-account-network',
            'active' => ['users'],
            'url' => '#',
            'sub' => true,
            'child' => [
               [
                  'label' => 'Account',
                  'active' => ['account'],
                  'url' => '/admin/users/account'
               ]
            ]
         ],
      ];
      return $config;
   }

}