<template id="<?php echo $_the_component; ?>">
	<div class="app_login">
		<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
		  	<header class="masthead mb-auto">
		    	<div class="inner">
		      		<h3 class="masthead-brand">Leadformio</h3>
		    	</div>
		  	</header>

		  	<main role="main" class="inner cover">
		  		<div class="row">
		  			<div class="col-md-2">
		  				&nbsp;
		  			</div>
		  			<div class="col-md-5">
		  				<h1 class="cover-heading">Wait...</h1>
					    <p class="lead">App is connecting to your shop. Please do not close the browser. The app will connect with your shop and redirect your to the dashboard.</p>
		  			</div>
		  			<div class="col-md-2">
		  				&nbsp;
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
	var api_key = '<?php echo SHOPIFY_API_KEY; ?>';
	var scopes = '<?php echo SHOPIFY_SCOPES; ?>';
	var redirect_uri = '<?php echo BASE; ?>/login/shopify/';
	var nonce = '<?php echo uniqid(); ?>';
	var access_mode = '';

    var meta = {
      title: 'Login - Vuedoo Shopify App',
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
    };
    
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

			if( ( getUrlVars()['code'] != undefined ) && ( getUrlVars()['shop'] == get_storage_data('shopify_shop_url') ) && ( getUrlVars()['state'] == get_storage_data('shopify_login_nonce') ) ) {
				axios.get(App.api_base + '/shopify_get_access_token/?code=' + getUrlVars()['code'] + '&shop=' + getUrlVars()['shop'], { headers: { 'X-Vuedoo-Domain': App.domain, 'X-Vuedoo-Access-Key' : '' } })
				.then((res) => {
                    if( res.data.status == 'success' ) {
                    	set_storage_data('shopify_access_token', res.data.params.access_token);
                        set_storage_data('shopify_shop_url', res.data.params.shop);
                        set_storage_data('shopify_billed_status', res.data.params.billed);
                        set_storage_data('access_key', res.data.params.access_key);
                        set_storage_data('privileges', res.data.params.privileges);
                        set_storage_data('email_validated', res.data.params.email_validated);

                        if( res.data.params.billed < 1 ) window.location.href = res.data.params.shopify_app_charge_confirmation_url;
                        else this.$router.push({name: 'home'});
                    }
                }).catch((e)=>{
                    console.log(e);
                });
			} else if( getUrlVars()['shop'] != undefined ) {
				var shop_url = getUrlVars()['shop'];
				initiate_shopify_login( shop_url, api_key, scopes, redirect_uri, nonce, access_mode );
			} else if ( getUrlVars()['charge_id'] != undefined ) {
				axios.get(App.api_base + '/shopify_activate_charge/?charge_id=' + getUrlVars()['charge_id'], { headers: { 'X-Vuedoo-Domain': App.domain, 'X-Vuedoo-Access-Key' : get_storage_data('access_key') } })
				.then((res) => {
                    if( res.data.status == 'success' ) {
                    	set_storage_data('shopify_billed_status', 1);
                    	this.$router.push({name: 'home'});
                    }
                }).catch((e)=>{
                    console.log(e);
                });

				activate_shopify_charge( get_storage_data('access_key'), getUrlVars()['charge_id'] );
			} else if( get_storage_data('access_key') != '' && get_storage_data('shopify_billed_status') > 0 ) {
				this.$router.push({name: 'home'});
			}
        },
		methods:{
			initiate_login: function(event) {
				this.$router.push('/login/shopify/?shop=' + document.getElementById('inputShopURL').value);
			}
		}
	});

	function initiate_shopify_login( shop, api_key, scopes, redirect_uri, nonce, access_mode ) {
		set_storage_data('shopify_login_nonce', nonce);
		set_storage_data('shopify_shop_url', shop);
		var url = 'https://' + shop + '/admin/oauth/authorize?client_id=' + api_key + '&scope=' + encodeURIComponent( scopes ) + '&redirect_uri=' + encodeURIComponent( redirect_uri ) + '&state=' + nonce + '&grant_options[]=' + access_mode;
		window.location.href = url;
    }

    function activate_shopify_charge() {

    }
</script>
