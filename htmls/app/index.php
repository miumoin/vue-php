<!doctype html>
<html lang="en">
  	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <link rel="icon" href="https://getbootstrap.com/docs/4.0/assets/img/favicons/favicon.ico">

	    <title>Vuedoo app</title>

	    <link rel="canonical" href="<?php echo BASE; ?>">

	    <!-- Bootstrap core CSS -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	    <!-- Custom styles for this template -->
	    <link href="<?php echo BASE; ?>/assets/app/css/style.css" rel="stylesheet">

	    <!-- Google login scripts -->
	    <?php if( defined("GLOGIN_CLIENT_ID") && GLOGIN_CLIENT_ID != '' ) { ?>
		<meta name="google-signin-client_id" content="<?php echo GLOGIN_CLIENT_ID; ?>"><?php } ?>

		<script>
			var App = { 'protocol' : '<?php echo PROTOCOL; ?>', 'domain' : '<?php echo DOMAIN; ?>', 'base' : '<?php echo BASE; ?>', 'router_base' : '<?php echo LOCATION_BASE; ?>', 'api_base' : '<?php echo API_BASE; ?>' };
		</script>
	    <script type="text/javascript"> var routes = []; </script>
		<script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js" integrity="sha256-ufGElb3TnOtzl5E4c/qQnZFGP+FYEZj5kbSEdJNrw0A=" crossorigin="anonymous"></script>
  	</head>
  	<body>

		<div id="app" v-cloak>
			<div v-if="$route.name==='dashboard'" id="the_routed_div">
				<div>Dashboard top</div>
				<router-view></router-view>
				<div>Dashboard bottom</div>
			</div>
			<div v-else-if="$route.name==='login'" id="the_routed_div">
				<router-view></router-view>
			</div>
			<div v-else id="the_routed_div">
				<router-view></router-view>
			</div>
		</div>

		<?php $components = add_components('app'); ?>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/3.1.2/vue-router.js" integrity="sha256-J8FoD0Yt1A0YS9yENPIEWQBbjAi+w9eE2wH/KqGTb2g=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

		<!-- Google login scripts -->
	    <?php if( defined("GLOGIN_CLIENT_ID") && GLOGIN_CLIENT_ID != '' ) { ?><script src="https://apis.google.com/js/api:client.js"></script><?php } ?>
	    <script>
		    var googleUser = {};
		  	var vueDooGApp = function() {
		    	gapi.load('auth2', function(){
		      		// Retrieve the singleton for the GoogleAuth library and set up the client.
		      		auth2 = gapi.auth2.init({
		        		client_id: '<?php echo GLOGIN_CLIENT_ID ; ?>',
		        		cookiepolicy: 'single_host_origin',
		      		});
		      		if( document.getElementsByClassName('google_login_button') != undefined ) {
		      			for( var i = 0; i < document.getElementsByClassName('google_login_button').length; i++ ) {
		      				googleLoginSuccess( document.getElementsByClassName('google_login_button')[i] );
		      			}
		      		}
		    	});
		  	};
			vueDooGApp();
		</script>

	    <!-- Facebook login scripts -->
		<?php if( defined("FB_APP_ID") && FB_APP_ID != '' ) { ?><script>
			window.fbAsyncInit = function() {
				FB.init({
				  appId      : '<?php echo FB_APP_ID; ?>',
				  cookie     : true,
				  xfbml      : true,
				  version    : '<?php echo FB_API_VERSION; ?>'
				});
			};

			(function(d, s, id){
			 var js, fjs = d.getElementsByTagName(s)[0];
			 if (d.getElementById(id)) {return;}
			 js = d.createElement(s); js.id = id;
			 js.src = "https://connect.facebook.net/en_US/sdk.js";
			 fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script><?php } ?>

		<script src="<?php echo BASE ;?>/assets/js/functions.js"></script>
		<script type="text/javascript">
			const isLoggedIn = (to,from,next) => {
				console.log ("hello");
			}

			<?php
				if( isset( $components ) ) {
					foreach( $components as $component ) {
						?>
						routes.push({ path: '/<?php echo ( $component != 'home' ? str_replace( '$', ':', str_replace( ':', '/', $component ) ) : ''); ?>', component: <?php echo str_replace( array( ':$' , ':' ), '_', $component ); ?>, name : '<?php echo str_replace( array( ':$' , ':' ), '_', $component ); ?>' });
						<?php
					}
				}
			?>

			const router = new VueRouter({ 
				base : App.router_base, 
				mode: 'history',
				routes: routes 
			});

			const app = new Vue({
			  router
			}).$mount('#app')
		</script>
	</body>
</html>