<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?php echo $title;?></title>
	<?php
	echo css_tag([
      'css/bootstrap.min.css',
      'css/style.min.css',
      'css/blue.css'
   ]);
	echo @$internalCss;
   echo '<style type="text/css">';
   $minify = new \App\Libraries\Minify();
   echo $minify->css('public/css/custom.css');
   echo '</style>';
	?>
	<!--[if lt IE 9]>
   <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
   <![endif]-->
</head>
<body class="fix-header fix-sidebar card-no-border">
	<div id="main-wrapper">
      <div id="header" class="topbar"></div>
      <div id="sidebar"></div>
      <div class="page-wrapper" id="root"></div>
   </div>
	<?php
	echo script_tag([
      'js/jquery.min.js',
      'js/popper.min.js',
      'js/bootstrap.min.js',
      'js/jquery.slimscroll.js',
      'js/waves.js',
      'js/sidebarmenu.js',
      'js/sticky-kit.min.js',
      'js/custom.min.js'
   ]);
	echo '<script type="text/javascript">';
   echo 'var baseURL = "' . base_url() . '",';
   echo 'siteURL = "' . base_url('index.php') . '",';
   echo 'segment = ' . $segment . ',';
   echo 'pageType = "' . $pageType . '",';
   echo 'content = ' . $footerJs . ';';
   echo '</script>';
   echo $internalJs;
	?>
</body>
</html>