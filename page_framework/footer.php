<div class="row footer well well-small">
	<div class="span5">
		<a href="index.php">Home</a> | 
		<a href="games.php">Challenge</a> | 
		<a href="challenges.php">How It Works</a> | 
		<a href="charities.php">Charities</a> | 
		<a href="help.php">Help</a> 
	</div>
	<div class="span4">
		&copy; SchooldU.com, or its affiliates 
	</div>



	<div class="span1">
		<img src="img/poweredBy_rackspace.png" alt="powered by rackspace"/>
	</div>
	<div class="span1">
		<img src="img/poweredBy_snoball.png" alt="powered by snoball"/>
	</div>
	
	
</div>
	
<script>
$('body').on('touchstart.dropdown', '.dropdown-menu', function (e) { 
  e.stopPropagation(); 
});
$(document).on('click','.dropdown-menu a',function(){
  document.location = $(this).attr('href');
});
</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-37382812-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>