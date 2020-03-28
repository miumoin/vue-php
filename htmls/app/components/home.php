<template id="<?php echo $_the_component; ?>">
	<div class="signin-body text-center">
	    This is a home page.
	    <a href="#" id="button_logout">Logout</a>
	    <p id="email_validation_required_msg" style="display:none;">
	    	Your email has not been confirmed. Please click here to resend verification email.
	    </p>
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
		mounted(){
			if( get_storage_data('access_key') == '' ) {
				this.$router.push({name: 'login'});
			}

			if( get_storage_data('email_validated') < 1 ) {
				document.getElementById('email_validation_required_msg').style.display = 'block';
			}

			this_router = this.$router;
			document.getElementById('button_logout').addEventListener('click', function() {
				delete_storage_data('access_key');
				this_router.push({name: 'login'});
			});
        },
		methods:{
		}
	});
	
</script>