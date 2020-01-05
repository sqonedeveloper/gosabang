<?php namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\BaseController;

class AdminController extends BaseController {

   public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
      parent::initController($request, $response, $logger);
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
            'label' => 'Supplier',
            'icon' => 'mdi mdi-gauge',
            'active' => ['supplier'],
            'url' => '/admin/supplier',
            'sub' => false
         ],
         [
            'label' => 'Produk',
            'icon' => 'mdi mdi-gauge',
            'active' => ['produk'],
            'url' => '#',
            'sub' => true,
            'child' => [
               [
                  'label' => 'Kategori',
                  'active' => ['kategori'],
                  'url' => '/admin/produk/kategori'
               ],
               [
                  'label' => 'Satuan',
                  'active' => ['satuan'],
                  'url' => '/admin/produk/satuan'
               ],
               [
                  'label' => 'Data Produk',
                  'active' => ['dataProduk'],
                  'url' => '/admin/produk/dataProduk'
               ]
            ]
         ],
         [
            'label' => 'Stok',
            'icon' => 'mdi mdi-gauge',
            'active' => ['stok'],
            'url' => '#',
            'sub' => true,
            'child' => [
               [
                  'label' => 'Masuk',
                  'active' => ['masuk'],
                  'url' => '/admin/stok/masuk'
               ],
               [
                  'label' => 'Keluar',
                  'active' => ['keluar'],
                  'url' => '/admin/stok/keluar'
               ]
            ]
         ],
         [
            'label' => 'Transaksi',
            'icon' => 'mdi mdi-gauge',
            'active' => ['transaksi'],
            'url' => '/admin/transaksi',
            'sub' => false
         ],
         [
            'label' => 'Laporan',
            'icon' => 'mdi mdi-gauge',
            'active' => ['laporan'],
            'url' => '#',
            'sub' => true,
            'child' => [
               [
                  'label' => 'Penjualan',
                  'active' => ['penjualan'],
                  'url' => '/admin/laporan/penjualan'
               ],
               [
                  'label' => 'Stok Masuk',
                  'active' => ['stokMasuk'],
                  'url' => '/admin/laporan/stokMasuk'
               ],
               [
                  'label' => 'Stok Keluar',
                  'active' => ['stokKeluar'],
                  'url' => '/admin/laporan/stokKeluar'
               ]
            ]
         ],
         [
            'label' => 'Akun',
            'icon' => 'mdi mdi-gauge',
            'active' => ['akun'],
            'url' => '/admin/akun',
            'sub' => false
         ],
         [
            'label' => 'Settings',
            'icon' => 'mdi mdi-gauge',
            'active' => ['settings'],
            'url' => '/admin/settings',
            'sub' => false
         ],
      ];
      return $config;
   }

}