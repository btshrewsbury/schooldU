$(window).load(function() {	window.fbAsyncInit = function() {	// init the FB JS SDK	FB.init({	  appId      : '184934348318098', // App ID from the App Dashboard	  status     : true, // check the login status upon init?	  cookie     : true, // set sessions cookies to allow your server to access the session?	});	// Additional initialization code such as adding Event Listeners goes here	};	// Load the SDK's source Asynchronously	// Note that the debug version is being actively developed and might 	// contain some type checks that are overly strict. 	// Please report such bugs using the bugs tool.	(function(d, debug){	 var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];	 if (d.getElementById(id)) {return;}	 js = d.createElement('script'); js.id = id; js.async = true;	 js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";	 ref.parentNode.insertBefore(js, ref);	}(document, /*debug*/ false));});function sendFbMessage(to,link,articleTitle,description) {		FB.ui({method: 'send',	  link: link,	  picture: 'http://schooldu.com/img/Schooldu_app.png',	  name: articleTitle,	  to: to,	  description: description	}, requestCallback);}	     function postToFbWall(to,link,linkName,subLinkText,message) {		FB.ui({method: 'feed',	  link: link,	  picture: 'http://schooldu.com/img/Schooldu_app.png',	  to: to,	  name: linkName,	  caption: subLinkText,	  description: message	}, requestCallback);}	 	function requestCallback(response) {}  