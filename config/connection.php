<?php
/*
 * Project: Vuedoo Framework
 * Copyright: 2020, Moin Uddin (pay2moin@gmail.com)
 * Version: 1.0
 * Author: Moin Uddin
 */
$protocol = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http' );
$location_base = str_replace( $_SERVER['DOCUMENT_ROOT'], '', getcwd() );
$domain = $_SERVER['HTTP_HOST'] . $location_base;
$base = $protocol.'://'.$domain;

define('PROTOCOL', $protocol);
define('DOMAIN', $domain);
define("BASE",$base);
define("LOCATION_BASE",$location_base);
define("API_BASE",$base."/api");
define("TITLE","Vuedoo framework");
define("SPICE","ydtfm~");
define("START", 2);
define("DB_NAME", "vuedoo");
define("DB_USER", "dbUser");
define("DB_PASSWORD", "dbPass");
define("DB_HOST", "localhost");

//Login using Google
//https://developers.google.com/identity/sign-in/web/sign-in
define("GLOGIN_CLIENT_ID", "gloginclientid.apps.googleusercontent.com");
define("GLOGIN_CLIENT_SECRET", "gloginclientsecret");

//Login using facebook
//https://developers.facebook.com/docs/facebook-login/web
define("FB_APP_ID", "fbappidnumber");
define("FB_API_VERSION", "v5.0");

define('SHOPIFY_API_KEY', 'shopifyapikey');
define('SHOPIFY_SECRET', 'shopifyapisecret');
define('SHOPIFY_SCOPES', 'read_script_tags,write_script_tags,read_products,read_orders,write_products,read_inventory,write_inventory,read_price_rules,write_price_rules');
define('SHOPIFY_APP_PACKAGE_NAME', 'VueDoo Monthly Plan');
define('SHOPIFY_APP_CHARGE', true);
define('SHOPIFY_APP_CHARGE_TYPE', 'recurring');
define('SHOPIFY_APP_CHARGE_AMOUNT', 19.90);
define('SHOPIFY_APP_TRIAL_DAYS', 7);
define('SHOPIFY_APP_CHARGE_TEST', true);

date_default_timezone_set('UTC');
?>
