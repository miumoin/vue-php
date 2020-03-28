<template id="<?php echo $_the_component; ?>">
	<div class="signin-body text-center">
	    <form class="form-signin">
	      	<img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
	      	<h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
	      	<label for="inputEmail" class="sr-only">Email address</label>
	      	<input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
	      	<label for="inputPassword" class="sr-only">Password</label>
	      	<input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
	      	<div class="checkbox mb-3">
	        	<label>
	          		<input type="checkbox" value="remember-me"> Remember me
	        	</label>
	      	</div>
	      	<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
	      	<p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
	    </form>
	</div>
</template>

<script type="text/javascript">
	//const axios = require('axios');
	const <?php echo $_the_component; ?> = Vue.component('<?php echo $_the_component; ?>',{
		template: '#<?php echo $_the_component; ?>',
		data(){
			return {
				email: '',
				password: ''
			}
		},
		created(){
            /*const token = get_storage_data('_token');
			const subdomain = get_storage_data('_subdomain');
            if(token != '' && subdomain != ''){
                //this.$router.push({name: 'home'});
            }*/
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
		}
	});
	
</script>
