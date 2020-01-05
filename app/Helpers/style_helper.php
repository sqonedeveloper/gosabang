<?php

use Config\App;

function css_tag($href = '', $type = 'text/css', $index_page = false) {   
   $config = new App();

   $link = '';
   if (is_array($href)) {
      $push_href = '';
      foreach ($href as $key => $val) {
         if (is_array($val)) {
            foreach ($val as $k => $v) {
               if (strpos($v, '://') !== false) {
                  $push_href .= 'Link: <'.$v.'>; rel=preload; as=style;';
               } else {
                  $push_href .= 'Link: <'.base_url($v).'>; rel=preload; as=style;';
               }
            }
         } else {
            if (strpos($val, '://') !== false) {
               $push_href .= 'Link: <'.$val.'>; rel=preload; as=style;';
            } else {
               $push_href .= 'Link: <'.base_url($val).'>; rel=preload; as=style;';
            }
         }
      }
      header($push_href, true);
      foreach ($href as $v) {
         $link .= css_tag($v, $type, $index_page);
      }
   } else {
      $link .= '<link ';
      if (strpos($href, '://') !== false) {
         $link .= 'href="'.$href.'"';
      } elseif ($index_page === true) {
         $link .= 'href="'.$config->baseURL . $href.'"';
      } else {
         $link .= 'href="'.$config->baseURL . $href.'"';
      }
      $link .= " type=\"{$type}\" rel=\"stylesheet preload\" as=\"style\" />";
   }
   return $link;
}

function script_tag($src = '', $type = "text/javascript", $index_page = false) {
   $config = new App();
   $link = '';
   if (is_array($src)) {
      $push_src = '';
      foreach ($src as $key => $val) {
         if (is_array($val)) {
               foreach ($val as $k => $v) {
                  if (strpos($v, '://') !== false) {
                     $push_src .= 'Link: <'.$v.'>; rel=preload; as=script;';
                  } else {
                     $push_src .= 'Link: <'.base_url($v).'>; rel=preload; as=script;';
                  }
               }
         } else {
               if (strpos($val, '://') !== false) {
                  $push_src .= 'Link: <'.$val.'>; rel=preload; as=script;';
               } else {
                  $push_src .= 'Link: <'.base_url($val).'>; rel=preload; as=script;';
               }
         }
      }
      header($push_src, true);
      foreach ($src as $v) {
         $link .= script_tag($v, $type, $index_page);
      }
   } else {
      $link .= '<script ';
      if (strpos($src, '://') !== false) {
         $link .= 'src="'.$src.'"';
      } elseif ($index_page === true) {
         $link .= 'src="'.$config->baseURL . $src.'"';
      } else {
         $link .= 'src="'.$config->baseURL . $src.'"';
      }
      $link .= " type=\"{$type}\" rel=\"preload\" as=\"script\"></script>";
   }
   return $link;
}