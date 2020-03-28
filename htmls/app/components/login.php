<template id="<?php echo $_the_component; ?>">
	<div class="app_login">
		<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
		  	<header class="masthead mb-auto">
		    	<div class="inner">
		      		<h3 class="masthead-brand">Cover</h3>
	      			<nav class="nav nav-masthead justify-content-center">
				        <a class="nav-link" href="#" onclick="javascript: document.getElementById('form-signup-home').style.display='none'; document.getElementById('form-signup-email').style.display='none'; document.getElementById('form-forgot-password').style.display='none'; document.getElementById('form-signin').style.display = 'block'; return false;">Sign in</a>
				        <a class="nav-link active" href="#" onclick="javascript: document.getElementById('form-signin').style.display='none'; document.getElementById('form-forgot-password').style.display='none'; document.getElementById('form-signup-email').style.display='none'; document.getElementById('form-signup-home').style.display = 'block'; return false;">Sign up</a>
	      			</nav>
		    	</div>
		  	</header>

		  	<main role="main" class="inner cover">
		  		<div class="row">
		  			<div class="col-md-5">
		  				<div class="form-signin" id="form-signup-home">
		  					<div class="g-signin2" data-onsuccess="googleLoginSuccess" data-longtitle="true" style="margin-bottom: 20px; width: 300px; height: 35px;"></div>
		  					<button class="btn btn-primary btn-block google_login_button" type="button">Sign up using google</button>
							<button class="btn btn-primary btn-block facebook_login_button" type="button">Sign up using facebook</button>
							<button class="btn btn-primary btn-block" type="submit" onclick="javascript: document.getElementById('form-signup-home').style.display='none'; document.getElementById('form-signin').style.display='none'; document.getElementById('form-forgot-password').style.display='none'; document.getElementById('form-signup-email').style.display = 'block'; return false;">Sign up with email</button>
							<p>Already signed up? <a href="#" onclick="javascript: document.getElementById('form-signup-home').style.display='none'; document.getElementById('form-signup-email').style.display='none'; document.getElementById('form-forgot-password').style.display='none'; document.getElementById('form-signin').style.display = 'block'; return false;">Login</a></p>
		  				</div>
		  				<form class="form-signin" id="form-signup-email" style="display:none;" onsubmit="return false;">
		  					<p><a href="#" onclick="javascript: document.getElementById('form-signup-email').style.display='none'; document.getElementById('form-signin').style.display='none'; document.getElementById('form-forgot-password').style.display='none'; document.getElementById('form-signup-home').style.display = 'block'; return false;">Back</a></p>
					      	<h1 class="h3 mb-3 font-weight-normal">Sign up</h1>
					      	<div class="form-group">
						      	<label for="signupName" class="sr-only">Name</label>
						      	<input type="text" id="signupName" class="form-control" placeholder="Name" onchange="document.getElementById('signupNameInvalid').style.display = ( this.value != '' ? 'none' : 'block' )" required autofocus>
						      	<div class="invalid-feedback" id="signupNameInvalid">
					      			Invalid name.
							    </div>
						    </div>
						    <div class="form-group">
					      		<label for="signupEmail" class="sr-only">Email address</label>
					      		<input type="email" id="signupEmail" class="form-control" placeholder="Email address" onchange="document.getElementById('signupEmailInvalid').style.display = ( valid_email( this.value ) != false ? 'none' : 'block' )" required autofocus>
					      		<div class="invalid-feedback" id="signupEmailInvalid">
					      			Invalid email address.
							    </div>
					      	</div>
					      	<div class="form-group">
					      		<label for="signupPassword" class="sr-only">Password</label>
					      		<input type="password" id="signupPassword" class="form-control" placeholder="Password" onchange="document.getElementById('signupPasswordInvalid').style.display = ( isPasswordValid( this.value ) ? 'none' : 'block' )" required>
					      		<div class="invalid-feedback" id="signupPasswordInvalid">
					      			Password must be at least 6 characters long & contain numbers, letters.
							    </div>
					      	</div>
					      	<div class="form-group">
					      		<div class="invalid-feedback" id="signupRegistrationInvalid">
					      			User already exists. Please, <a href="#" onclick="javascript: document.getElementById('form-signup-home').style.display='none'; document.getElementById('form-signup-email').style.display='none'; document.getElementById('form-forgot-password').style.display='none'; document.getElementById('form-signin').style.display = 'block'; return false;">Login</a>
							    </div>
					      		<button class="btn btn-primary btn-block" type="submit" id="form-signup-email-submit">Sign up</button>
					      	</div>
					      	<p>Already signed up? <a href="#" onclick="javascript: document.getElementById('form-signup-home').style.display='none'; document.getElementById('form-signup-email').style.display='none'; document.getElementById('form-forgot-password').style.display='none'; document.getElementById('form-signin').style.display = 'block'; return false;">Login</a></p>
					    </form>

					    <form class="form-signin" id="form-signin" style="display:none;" onsubmit="return false;">
					      	<h1 class="h3 mb-3 font-weight-normal">Sign in</h1>

					      	<button class="btn btn-primary btn-block google_login_button" type="button">Sign in using google</button>
							<button class="btn btn-primary btn-block facebook_login_button" type="button">Sign in using facebook</button>

							<div class="form-signin-hr">Or</div>

							<div class="form-group">
					      		<label for="inputEmail" class="sr-only">Email address</label>
					      		<input type="email" id="signinEmail" class="form-control" placeholder="Email address" onchange="document.getElementById('signupEmailInvalid').style.display = ( valid_email( this.value ) != false ? 'none' : 'block' )" required autofocus>
					      		<div class="invalid-feedback" id="signinEmailInvalid">
					      			Invalid email address.
							    </div>
					      	</div>
					      	<div class="form-group">
					      		<label for="inputPassword" class="sr-only">Password</label>
					      		<input type="password" id="signinPassword" class="form-control" placeholder="Password" required>
					      		<div class="invalid-feedback" id="signinPasswordInvalid">
					      			Password must be at least 6 characters long & contain numbers, letters.
							    </div>
					      	</div>
					      	<div class="form-group">
					      		<div class="invalid-feedback" id="signinInvalid">
					      			Invalid email or password.
							    </div>
					      		<button class="btn btn-primary btn-block" type="submit" id="form-signin-email-submit">Sign in</button>
					      	</div>
					      	<p>
					      		Don't have an account? <a href="#" onclick="javascript: document.getElementById('form-signin').style.display='none'; document.getElementById('form-forgot-password').style.display='none'; document.getElementById('form-signup-email').style.display='none'; document.getElementById('form-signup-home').style.display = 'block'; return false;">Sign up</a>
					      		<br>
					      		<a href="#" onclick="javascript: document.getElementById('form-signin').style.display='none'; document.getElementById('form-signup-email').style.display='none'; document.getElementById('form-signup-home').style.display='none'; document.getElementById('form-forgot-password').style.display = 'block'; return false;">Forgot password?</a>
					      	</p>
					    </form>

					    <form class="form-signin" id="form-forgot-password" style="display:none;" onsubmit="return false;">
					      	<h1 class="h3 mb-3 font-weight-normal">Forgot password</h1>
					      	<div class="form-group">
						      	<label for="inputEmail" class="sr-only">Email address</label>
						      	<input type="email" id="recoverEmail" class="form-control" placeholder="Email address" onchange="document.getElementById('recoverEmailInvalid').style.display = ( valid_email( this.value ) != false ? 'none' : 'block' )" required autofocus>
						      	<div class="invalid-feedback" id="recoverEmailInvalid">
					      			Invalid email address.
							    </div>
						    </div>
						    <div class="form-group">
						    	<div class="valid-feedback" id="recoverValid">
					      			A recovery link has been sent to your email.
							    </div>
							    <div class="invalid-feedback" id="recoverInvalid">
					      			Invalid user.
							    </div>
					      		<button class="btn btn-primary btn-block" type="submit" id="form-forgot-password-submit">Recover password</button>
					      	</div>
					      	<p><a href="#" onclick="javascript: document.getElementById('form-forgot-password').style.display='none'; document.getElementById('form-signup-email').style.display='none'; document.getElementById('form-signup-home').style.display='none'; document.getElementById('form-signin').style.display = 'block'; return false;">Remembered password?</a></p>
					    </form>

					    <form class="form-signin" id="form-reset" style="display:none;" onsubmit="return false;">
					      	<h1 class="h3 mb-3 font-weight-normal">Reset password</h1>

					      	<div class="form-group">
					      		<label for="inputPassword" class="sr-only">Password</label>
					      		<input type="password" id="resetPassword" class="form-control" placeholder="Password" onchange="document.getElementById('resetPasswordInvalid').style.display = ( isPasswordValid( this.value ) ? 'none' : 'block' )" required>
					      		<div class="invalid-feedback" id="resetPasswordInvalid">
					      			Password must be at least 6 characters long & contain numbers, letters.
							    </div>
					      	</div>

					      	<div class="form-group">
					      		<label for="inputPassword" class="sr-only">Re-enter Password</label>
					      		<input type="password" id="resetrePassword" class="form-control" placeholder="Re-enter password" onchange="document.getElementById('resetrePasswordInvalid').style.display = ( this.value == document.getElementById('resetPassword').value ? 'none' : 'block' )" required>
					      		<div class="invalid-feedback" id="resetrePasswordInvalid">
					      			Password mismatched.
							    </div>
					      	</div>

					      	<div class="form-group">
					      		<div class="valid-feedback" id="resetValid">
					      			Your password has beed reset successfully, please <a href="<?php echo BASE; ?>/login">login</a>.
							    </div>
							    <div class="invalid-feedback" id="resetInvalid">
					      			Failed resetting password.
							    </div>
					      		<button class="btn btn-primary btn-block" type="submit" id="form-reset-submit">Reset</button>
					      	</div>
					      	<p>
					      		Don't have an account? <a href="#" onclick="javascript: document.getElementById('form-signin').style.display='none'; document.getElementById('form-forgot-password').style.display='none'; document.getElementById('form-signup-email').style.display='none'; document.getElementById('form-signup-home').style.display = 'block'; return false;">Sign up</a>
					      		<br>
					      		<a href="#" onclick="javascript: document.getElementById('form-signin').style.display='none'; document.getElementById('form-signup-email').style.display='none'; document.getElementById('form-signup-home').style.display='none'; document.getElementById('form-forgot-password').style.display = 'block'; return false;">Forgot password?</a>
					      	</p>
					    </form>

					    <div class="invalid-feedback" id="resetAttemptInvalid">
					      	URL has been expired.
						</div>
						<div class="invalid-feedback" id="emailValidationInvalid">
					      	URL has been expired.
						</div>
						<div class="valid-feedback" id="emailValidationValid">
					      	Your email has been confirmed successfully.
						</div>
		  			</div>
		  			<div class="col-md-2">
		  				&nbsp;
		  			</div>
		  			<div class="col-md-5">
		  				<h1 class="cover-heading">Cover your page.</h1>
					    <p class="lead">Cover is a one-page template for building simple and beautiful home pages. Download, edit the text, and add your own fullscreen background photo to make it your own.</p>
					    <p class="lead">
					      	<a href="#" class="btn btn-lg btn-secondary">Learn more</a>
					    </p>
		  			</div>
		  		</div>
		  	</main>

		  	<footer class="mastfoot mt-auto">
		    	<div class="inner">
		      		<p>Cover template for <a href="https://getbootstrap.com/">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
		    	</div>
		  	</footer>
		</div>
	</div>
</template>

<script type="text/javascript">
    var meta = {
      title: 'Login - Vuedoo App',
      metaTags: [
        {
          name: 'description',
          content: 'The login page description of our vuedoo app.'
        },
        {
          property: 'og:description',
          content: 'The login page og-description of our vuedoo app.'
        }
      ]
    }
    
	const <?php echo $_the_component; ?> = Vue.component('<?php echo $_the_component; ?>',{
		template: '#<?php echo $_the_component; ?>',
		data(){
			return {
				email: '',
				password: ''
			}
		},
		mounted(){
			document.getElementById('app').style.height = '100%';
			document.getElementById('the_routed_div').style.height = '100%';
			set_page_meta( meta );

			if( getUrlVars()['validate'] != undefined && getUrlVars()['key'] != undefined ) {
				axios.get(App.api_base + '/validate_email/?user_id=' + getUrlVars()['user_id'] + '&validation_key=' + getUrlVars()['key'], { headers: { 'X-Vuedoo-Domain': App.domain, 'X-Vuedoo-Access-Key' : '' } })
				.then((res) => {
                    if( res.data.status == 'success' ) {
                    	set_storage_data('email_validated', '1');
                    	
                    	document.getElementById('emailValidationValid').style.display = 'block';
                    	document.getElementById('form-signup-home').style.display='none'; 
                    	document.getElementById('form-forgot-password').style.display='none'; 
                    	document.getElementById('form-signup-email').style.display='none'; 
                    	document.getElementById('form-signin').style.display = 'block';
                    } else {
                    	document.getElementById('emailValidationInvalid').style.display = 'block';
                    }
                }).catch((e)=>{
                    console.log(e);
                });
			}

			if( get_storage_data('access_key') != '' ) {
				this.$router.push({name: 'home'});
			}

			for( var i = 0; i < document.getElementsByClassName('facebook_login_button').length; i++ ) {
				document.getElementsByClassName('facebook_login_button')[i].addEventListener("click", function() {
					FB.login(function(response) {
					  // handle the response
					  facebookLoginstatusChangeCallback(response);
					}, {scope: 'public_profile,email'});
				});
			}

			//Sign up using email
			var this_router = this.$router;
			document.getElementById('form-signup-email').addEventListener("submit", function() {
				var email = document.getElementById('signupEmail').value;
				var name = document.getElementById('signupName').value;
				var password = document.getElementById("signupPassword").value;

				//validate
				document.getElementById('signupRegistrationInvalid').style.display = 'none';
				document.getElementById('signupNameInvalid').style.display = ( name != '' ? 'none' : 'block' );
				document.getElementById('signupEmailInvalid').style.display = ( valid_email( email ) != false ? 'none' : 'block' );
				document.getElementById('signupPasswordInvalid').style.display = ( isPasswordValid( password ) ? 'none' : 'block' );

				//register
				if( name != '' && valid_email( email ) != false && isPasswordValid( password ) ) {
					axios.get(App.api_base + '/signup/?name=' + encodeURIComponent( name ) + '&email=' + encodeURIComponent( email ) + '&password=' + encodeURIComponent( password ), { headers: { 'X-Vuedoo-Domain': App.domain, 'X-Vuedoo-Access-Key' : '' } })
					.then((res) => {
	                    if( res.data.status == 'success' ) {
	                        set_storage_data('access_key', res.data.params.access_key);
	                        set_storage_data('email_validated', res.data.params.email_validated);
	                        set_storage_data('name', res.data.params.name);
	                        set_storage_data('privileges', res.data.params.privileges);
	                        this_router.push({name: 'home'});
	                    } else {
	                    	document.getElementById('signupRegistrationInvalid').style.display = 'block';
	                    }
	                }).catch((e)=>{
	                    console.log(e);
	                });
	            }
			});

			//Sign in using email
			document.getElementById('form-signin').addEventListener("submit", function() {
				var email = document.getElementById('signinEmail').value;
				var password = document.getElementById("signinPassword").value;

				//validate
				document.getElementById('signinInvalid').style.display = 'none';
				document.getElementById('signinEmailInvalid').style.display = ( valid_email( email ) != false ? 'none' : 'block' );
				document.getElementById('signinPasswordInvalid').style.display = ( isPasswordValid( password ) ? 'none' : 'block' );

				//register
				if( valid_email( email ) != false && isPasswordValid( password ) ) {
					axios.get(App.api_base + '/signin/?email=' + encodeURIComponent( email ) + '&password=' + encodeURIComponent( password ), { headers: { 'X-Vuedoo-Domain': App.domain, 'X-Vuedoo-Access-Key' : '' } })
					.then((res) => {
	                    if( res.data.status == 'success' ) {
	                        set_storage_data('access_key', res.data.params.access_key);
	                        set_storage_data('email_validated', res.data.params.email_validated);
	                        set_storage_data('name', res.data.params.name);
	                        set_storage_data('privileges', res.data.params.privileges);
	                        this_router.push({name: 'home'});
	                    } else {
	                    	document.getElementById('signinInvalid').style.display = 'block';
	                    }
	                }).catch((e)=>{
	                    console.log(e);
	                });
	            }
			});

			document.getElementById('form-forgot-password').addEventListener("submit", function() {
				var email = document.getElementById('recoverEmail').value;

				//validate
				document.getElementById('recoverInvalid').style.display = 'none';
				document.getElementById('recoverEmailInvalid').style.display = ( valid_email( email ) != false ? 'none' : 'block' );
				
				//register
				if( valid_email( email ) != false ) {
					axios.get(App.api_base + '/signin_recover/?email=' + encodeURIComponent( email ), { headers: { 'X-Vuedoo-Domain': App.domain, 'X-Vuedoo-Access-Key' : '' } })
					.then((res) => {
	                    if( res.data.status == 'success' ) {
	                        document.getElementById('recoverValid').style.display = 'block';
	                    } else {
	                    	document.getElementById('recoverInvalid').style.display = 'block';
	                    }
	                }).catch((e)=>{
	                    console.log(e);
	                });
	            }
			});

			if( getUrlVars()['reset'] != undefined && getUrlVars()['key'] != undefined ) {
				document.getElementById('form-signin').style.display='none';
            	document.getElementById('form-forgot-password').style.display='none';
            	document.getElementById('form-signup-email').style.display='none';
            	document.getElementById('form-signup-home').style.display = 'none';

				axios.get(App.api_base + '/signin_recover_check/?user_id=' + getUrlVars()['user_id'] + '&recovery_key=' + getUrlVars()['key'], { headers: { 'X-Vuedoo-Domain': App.domain, 'X-Vuedoo-Access-Key' : '' } })
				.then((res) => {
                    if( res.data.status == 'success' ) {
                    	document.getElementById('form-reset').style.display = 'block';
                        //document.getElementById('recoverValid').style.display = 'block';
                    } else {
                    	document.getElementById('resetAttemptInvalid').style.display = 'block';
                    }
                }).catch((e)=>{
                    console.log(e);
                });
			}

			document.getElementById('form-reset').addEventListener("submit", function() {
				document.getElementById('resetPasswordInvalid').style.display = ( isPasswordValid( document.getElementById('resetPassword').value ) ? 'none' : 'block' );
				document.getElementById('resetrePasswordInvalid').style.display = ( document.getElementById('resetrePassword').value == document.getElementById('resetPassword').value ? 'none' : 'block' );

				var password = document.getElementById('resetPassword').value;
				var repassword = document.getElementById('resetrePassword').value;
				var user_id = getUrlVars()['user_id'];
				
				//register
				if( password == repassword && isPasswordValid( password ) ) {
					axios.get(App.api_base + '/signin_reset/?user_id=' + user_id + '&recovery_key=' + getUrlVars()['key'] + '&password=' + encodeURIComponent( password ) + '&repassword=' + encodeURIComponent( repassword ), { headers: { 'X-Vuedoo-Domain': App.domain, 'X-Vuedoo-Access-Key' : '' } })
					.then((res) => {
	                    if( res.data.status == 'success' ) {
	                        document.getElementById('resetValid').style.display = 'block';
	                    } else {
	                    	document.getElementById('resetInvalid').style.display = 'block';
	                    }
	                }).catch((e)=>{
	                    console.log(e);
	                });
	            }
			});

        },
		methods:{
			/*login_me(){
				axios.get('<?php echo API_BASE;?>/users/login/?email='+this.email+'&password='+this.password)
                .then((res) => {
                    if( res.data.status == 'success' ){
                        set_storage_data('_token', res.data.data.token);
                        set_storage_data('_subdomain', res.data.data.subdomain);
                    	this.$router.push({name: 'home'});
                    }
                }).catch((e)=>{
                    console.log(e);
                });
			},
			show_registration(){	
				console.log ( this );
			}*/
			//Facebook login scripts
			


		}
	});
</script>
