
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>School'd</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	
    <link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/schoold.css" rel="stylesheet">
	
	
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>
    <div class="container">
		<? include 'nav.php'; ?>
		<? include 'carousel.php'; ?>


			<div class="row">
				<p></p>
			</div>
			<div class="row">
			  <div class="span3 blue_test"><img src="img/widget1.png"/></div>
			  <div class="span3 blue_test"><img src="img/widget2.png"/></div>
			  <div class="span6 blue_test"><img src="img/widget3.png"/></div>
			</div>
			<div class="row">
				<p></p>
			</div>
			
			<div class="row">
			  <div class="span4 blue_test"><img src="img/head2head.png"/></div>
			  <div class="span4 blue_test"><img src="img/widget5.png"/></div>
			  <div class="span4 blue_test"><img src="img/widget6.png"/></div>
			</div>


    </div>

    <? include 'js.php'; ?>
    
	<script type="text/javascript">
			$(window).load(function() {
				$('.carousel').carousel({
					interval: 5000
				});
			});
	</script>
	
  </body>
</html>
