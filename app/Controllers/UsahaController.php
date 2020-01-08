<?php namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\BaseController;

class UsahaController extends BaseController {

   protected $id_profile_usaha;

   public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
      parent::initController($request, $response, $logger);

      $this->_checkLogin();
   }

   private function _checkLogin() {
      $session = \Config\Services::session();

      $this->id_profile_usaha = $session->get('id_profile_usaha');

      $is_login = $session->get('isLogin');
      $role = $session->get('role');

      if (!$is_login || $role !== '2') {
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
         'bundle/vendor.js',
         'bundle/topbar.js',
         'bundle/sidebar.js'
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
            'url' => '/usaha/dashboard',
            'sub' => false
         ],
         [
            'label' => 'Profile',
            'icon' => 'mdi mdi-account-box-outline',
            'active' => ['profile'],
            'url' => '#',
            'sub' => true,
            'child' => [
               [
                  'label' => 'Info',
                  'active' => ['info'],
                  'url' => '/usaha/profile/info'
               ],
               [
                  'label' => 'Item',
                  'active' => ['item'],
                  'url' => '/usaha/profile/item'
               ]
            ]
         ],
         [
            'label' => 'Gallery',
            'icon' => 'mdi mdi-camera-front',
            'active' => ['gallery'],
            'url' => '/usaha/gallery',
            'sub' => false
         ],
         [
            'label' => 'Account',
            'icon' => 'mdi mdi-account-network',
            'active' => ['account'],
            'url' => '/usaha/account',
            'sub' => false
         ],
      ];
      return $config;
   }

}