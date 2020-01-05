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
	?>
	<!--[if lt IE 9]>
   <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
   <![endif]-->
</head>
<body>
   <section id="wrapper"></section>
	<?php
	echo script_tag([
      'js/jquery.min.js',
      'js/popper.min.js',
      'js/bootstrap.min.js'
   ]);
	echo '<script type="text/javascript">';
   echo 'var baseURL = "' . base_url() . '",';
   echo 'siteURL = "' . base_url('index.php') . '";';
   echo '</script>';
   echo $internalJs;
	?>
</body>
</html>