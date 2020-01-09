<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0 minimal-ui"/>
   <meta name="apple-mobile-web-app-capable" content="yes"/>
   <meta name="apple-mobile-web-app-status-bar-style" content="black">
   <meta name="google-site-verification" content="pbS1pC_JIGTEa_EvgB1LQAINbzCaIIHcjBXQonSNB8E" />
   <title><?php echo $title;?></title>
   <?php
   echo css_tag([
      'production/css/style.min.css',
      'production/css/framework.min.css',
      'production/css/font-awesome.css',
      'production/css/animate.min.css'
   ]);
   echo '<style type="text/css">';
   $minify = new \App\Libraries\Minify();
   echo $minify->css('public/production/css/custom.css');
   echo '</style>';
   ?>
</head>
<body>
   <div id="header-fixed disabled"><!--Header must be disabled, but not removed--></div>
   <div class="all-elements" id="root"></div>
   <?php
   echo script_tag([
      'production/js/jquery.js',
      'production/js/jqueryui.js',
      'production/js/framework-plugins.js',
      'production/js/custom.js'
   ]);
   echo '<script type="text/javascript">';
   echo 'var baseURL = "' . base_url() . '",';
   echo 'siteURL = "' . base_url('index.php') . '",';
   echo 'segment = ' . $segment . ',';
   echo 'content = ' . $footerJs . ';';
   echo '</script>';
   echo $internalJs;
   ?>
</body>
</html>