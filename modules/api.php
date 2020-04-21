<?php
	class api {
		function __construct() {
			global $break, $start;
			$this->mysqli = dbconnect();
			$headers = getallheaders();
			$this->domain = $this->validate_domain( $headers['X-Vuedoo-Domain'] );
			$this->access_key = $headers['X-Vuedoo-Access-Key'];
			$this->method_called = $_SERVER['REQUEST_METHOD'];

			//Add/update base url as system
			$this->system_id = $this->get_system_id();

			//Let's read products of this shop and return
			if( in_array( $this->method_called, array( 'POST', 'PUT' ) ) ) {
				//here is post content (PUT/POST)
				$postdata = file_get_contents("php://input");
				$data = json_decode( $postdata, true );
			} elseif( in_array( $this->method_called, array( 'GET', 'DELETE' ) ) ) {
				//here is get content (GET/DELETE)
				$data = $_REQUEST;
			}

			//$data['domain'] = $this->validate_domain( $this->domain );
			//$data['access_key'] = $this->access_key;
			//$data['method_called'] = $this->method_called;
			$this->user_id = $this->get_user_id();

			$this->data = $data;
		}

		function get_system_id() {
			if( $this->domain == '' ) { /* return $this->error(); */ }
			else {
				$res = $this->mysqli->query("SELECT id FROM systems WHERE subdomain='" . $this->domain . "' OR domain='" . $this->domain . "' AND status <> 9");
				if( $res->num_rows < 1 ) {
					$this->mysqli->query("INSERT INTO systems ( subdomain, domain, status ) VALUES ( '" . $this->domain . "', '" . $this->domain . "', '0' )");
					$res = $this->mysqli->query("SELECT id FROM systems WHERE subdomain='" . $this->domain . "'");
				}
				$arr = $res->fetch_array( MYSQLI_ASSOC );
				return $this->system_id = $arr['id'];
			}
		}

		function get_user_id() {
			if( $this->system_id != '' & $this->access_key != '' ) {
				$res = $this->mysqli->query("SELECT id FROM users WHERE system_id='" . $this->system_id . "' AND access_key='" . $this->access_key . "'");
				if( $res->num_rows > 0 ) {
					$arr = $res->fetch_array( MYSQLI_ASSOC );
					return $arr['id'];
				}
			}
			return false;
		}

		function validate_domain( $domain ) {
			$res = $this->mysqli->query("SELECT subdomain FROM systems WHERE subdomain='$domain' OR domain='$domain'");
			if( $res->num_rows > 0 ) {
				$arr = $res->fetch_array( MYSQLI_ASSOC );
				return $arr['subdomain'];
			} else return $domain;
		}

		function get_meta( $parent, $parent_id, $key ) {
			$res = $this->mysqli->query("SELECT meta_value FROM metas WHERE parent='$parent' AND parent_id='$parent_id' AND meta_key='$key' AND status>0");
			if( $res->num_rows > 0 ) {
    			$arr = $res->fetch_array( MYSQLI_ASSOC );
    			return $arr['meta_value'];
    		} else return false;
		}

		function add_meta( $parent, $parent_id, $key, $value ) {
			if( !$res = $this->mysqli->query("INSERT INTO metas ( parent, parent_id, meta_key, meta_value, status ) VALUES ('" . $this->mysqli->real_escape_string($parent) . "', '$parent_id', '" . $this->mysqli->real_escape_string($key) . "', '" . $this->mysqli->real_escape_string( !is_array( $value ) ? $value : json_encode( $value ) ) . "','1')") ) {
				$this->mysqli->query("UPDATE metas SET meta_value='" . $this->mysqli->real_escape_string( $this->mysqli->real_escape_string( !is_array( $value ) ? $value : json_encode( $value ) ) ) . "', status=1 WHERE parent='$parent' AND parent_id='$parent_id' AND meta_key='$key'");
			}
			return true;
		}

		function add_block( $user_id, $block ) {
			$slug = uniqid();
			$this->mysqli->query("INSERT INTO blocks ( type, title, content, author, slug, parent, created_at, modified_at, permission, status ) VALUES ( '" . $this->mysqli->real_escape_string( $block['type'] ) . "', '" . $this->mysqli->real_escape_string( $block['title'] ) . "', '" . $this->mysqli->real_escape_string( $block['content'] ) . "', '$user_id', '" . $slug . "', '" . $block['parent'] . "', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d H:i:s") . "', '" . $block['permission'] . "', '1' )");
			$res = $this->mysqli->query("SELECT id, type, title, content, author, slug, parent, created_at, modified_at, permission FROM blocks WHERE author='$user_id' AND slug='$slug' AND status=1 ORDER BY id DESC LIMIT 1");
			$arr = $res->fetch_array( MYSQLI_ASSOC );

			return $arr;
		}

		function get_blocks( $user_id, $type, $page, $entries_per_page, $parent = 0 ) {
			$x = ( $page - 1 ) * $entries_per_page;
			$res = $this->mysqli->query("SELECT id, type, title, content, author, slug, parent, created_at, modified_at, permission, status FROM blocks WHERE author='$user_id' AND type='$type' AND status=1 ORDER BY id DESC LIMIT $x, $entries_per_page");

			if( $res->num_rows > 0 ) {
				while( $row = $res->fetch_array(MYSQLI_ASSOC) ) {
					$blocks[] = $row;
				}
				return $blocks;
			} else return false;
		}

		function get_block( $user_id, $type = '', $id = '', $parent = 0 ) {
			$res = $this->mysqli->query("SELECT id, type, title, content, author, slug, parent, created_at, modified_at, permission, status FROM blocks WHERE status=1 AND author='$user_id'" . ( $type != '' ? " AND type='$type'" : "" ) . ( $id > 0 ? " AND id='" . $id . "'" : "" ) . ( $parent > 0 ? " AND parent='" . $parent . "'" : "" ));
			if( $res->num_rows > 0 ) {
				while( $row = $res->fetch_array(MYSQLI_ASSOC) ) {
					$row['children'] = $this->get_block( $user_id, '', '', $row['id'] );
					$blocks[] = $row;
				}
				return $blocks;
			} else return false;
		}

		function delete_block( $id ) {
			$this->mysqli->query("UPDATE blocks SET status=0 WHERE id='$id'");
		}

		function upload_image() {
			$target_dir = "assets/uploads/";
			$target_file = $target_dir . uniqid() . '-' . basename(str_replace(' ', '-', $_FILES["file"]["name"]));

			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			// Check if image file is a actual image or fake image
			
		    $check = getimagesize($_FILES["file"]["tmp_name"]);
		    if($check !== false) {
		        $uploadOk = 1;
		    } else {
		        $uploadOk = 0;
		    }
			// Check file size
			if ($_FILES["file"]["size"] > 500000) {
			    $msg = "Sorry, your file is too large.";
			    $uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != 'ico' && $imageFileType != "gif" ) {
			    $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			    $uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			// if everything is ok, try to upload file
			} else {
			    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
			        $msg = "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
			    }
			}

			$thumbnail_url = $this->create_thumb( $target_file );

			$res = array(
							'status'		=> ( $uploadOk > 0 ? 'success' : 'fail' ),
							'url'			=> BASE . '/' . $target_file,
							'thumbnail_url'	=> BASE . '/' . $thumbnail_url,
							'message'		=> $msg
						);

			echo json_encode( $res );
		}

		function create_thumb($image)
	    {
	        $br = explode( '.', $image );
	        $extension = $br[count($br)-1];

	        $destination = str_replace( '.' . $extension, '_thumb.' . $extension, $image );

	        $img = false;
	        if( ($extension=='jpg') || ( $extension == 'jpeg' ) ) $img = imagecreatefromjpeg($image);
	        elseif($extension=='png') $img = imagecreatefrompng($image);
	        
	        if( $img ) {
	            $width = imagesx( $img );
	            $height = imagesy( $img );
	            
	            $nwidth = 683;
	            $nheight = ( $height / $width ) * $nwidth;

	            $tmp_img = imagecreatetruecolor( $nwidth, $nheight );

	            imagealphablending($tmp_img, false);
	            imagesavealpha($tmp_img, true);
	            $transparent = imagecolorallocatealpha($tmp_img, 255, 255, 255, 127);
	            imagefilledrectangle($tmp_img, 0, 0, $width, $height, $transparent);

	            imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $nwidth, $nheight, $width, $height );

	            if( ($extension=='jpg') || ($extension=='jpeg') ) imagejpeg( $tmp_img, $destination );
	            elseif($extension=='png') imagepng( $tmp_img, $destination, 1 );
	            
	            imagedestroy($img);
	            imagedestroy($tmp_img);
	            return $destination;
	        } else return false;
	    }

		function api_method() {
			//$this->data = array('a' => 'b');
			//echo json_encode( $this->data );
		}

		function authenticate() {
			$ret = array( 'error' => 'true', 'type' => 'authentication' );
			if( $this->data['params']['type'] != 'local' ) {
				if( $this->data['params']['type'] == 'facebook' ) {
					$response = json_decode( file_get_contents('https://graph.facebook.com/v5.0/me?access_token=' . $this->data['params']['access_token'] . '&fields=id%2Cname%2Cemail%2Cgender&method=get&pretty=0&sdk=joey&suppress_http_code=1'), true );

					if( isset( $response['email'] ) ) {
						$this->data['params']['email'] = $response['email'];
						$this->data['params']['meta'] = array( 'type' => $this->data['params']['type'], 'name' => $response['name'], 'facebook_id' => $response['id'] );
						unset( $this->data['params']['type'] );
						unset( $this->data['params']['access_token'] );
					}
				} elseif( $this->data['params']['type'] == 'google' ) {
					$response = json_decode( file_get_contents( 'https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode( $this->data['params']['id_token'] ) ), true );
					if( isset( $response['email'] ) ) {
						$this->data['params']['email'] = $response['email'];
						$this->data['params']['meta'] = array( 'type' => $this->data['params']['type'], 'name' => $response['name'], 'google_id_token' => $this->data['params']['id_token'], 'picture' => $response['picture'], 'locale' => $response['locale'],  );
						unset( $this->data['params']['type'] );
						unset( $this->data['params']['id_token'] );
					}
				}

				if( isset( $this->data['params']['email'] ) ) {
					//Add user if new
					$this->mysqli->query("INSERT INTO users ( system_id, email, password, access_key, privileges ) VALUES ( '" . $this->system_id . "', '" . $this->data['params']['email'] . "', '" . md5( SPICE . strtoupper( uniqid() ) ) . "', '" . md5( SPICE . uniqid() ) . "', '[]' ) ");

					//Fetch user data
					$res = $this->mysqli->query("SELECT id, access_key FROM users WHERE email='" . $this->data['params']['email'] . "' AND system_id='" . $this->system_id . "'");
					if( $res->num_rows > 0 ) {
						$arr = $res->fetch_array( MYSQLI_ASSOC );

						//Insert/update meta information
						foreach( array_keys( $this->data['params']['meta'] ) as $key ) {
							$this->add_meta( 'users', $arr['id'], $key, $this->data['params']['meta'][ $key ] );
						}

						$welcome_email_sent = $this->get_meta( 'users', $arr['id'], 'welcome_email_sent' );
						if( !$welcome_email_sent ) {
							$this->send_welcome_email( $arr['id'] );
							$this->add_meta( 'users', $arr['id'], 'welcome_email_sent', 1 );
						}

						$ret = array( 
										'success'	=> true,
										'type' 		=> 'authentication',
										'params' 	=> array(
															'access_key' 		=> $arr['access_key'],
															'email_validated' 	=> 1,
															'name'				=> $this->get_meta( 'users', $arr['id'], 'name' )
													)
									);
					}
				}
			}
			echo json_encode( $ret );
		}

		function signup() {
			if( $this->mysqli->query("INSERT INTO users ( system_id, email, password, access_key, privileges ) VALUES ( '" . $this->system_id . "', '" . $_REQUEST['email'] . "', '" . md5( $_REQUEST['password'] ) . "', '" . md5( uniqid() ) . "', '[]' )") ) {
				$res = $this->mysqli->query("SELECT id, email, access_key FROM users WHERE email='" . $_REQUEST['email'] . "' AND system_id='" . $this->system_id . "'");
				$arr = $res->fetch_array( MYSQLI_ASSOC );
				$this->add_meta( 'users', $arr['id'], 'name', $_REQUEST['name'] );

				$validation_key = md5( uniqid() );
				$this->add_meta( 'users', $arr['id'], 'signin_email_validation_key', $validation_key );

				$to = $arr['email'];
				$subject = '' . str_replace( array( 'http://', 'https://', 'www.' ), '', BASE ) . ' email confirmation';
				$message = 'Hi ' . $_REQUEST['name'] . ',

Request Email Confirmation.

Let\'s make sure this email is active. Please click on the link below to validate your email address and confirm that you are the owner of this account.:

' . BASE . '/login/?validate=true&user_id=' . $arr['id'] . '&key=' . $validation_key . '

Ignore if you didn\'t sign up.

This is an auto generated email, do not reply back.';
				
				$headers = 'From: no_reply@zivoon.com' . "\r\n" .
				    'Reply-To: no_reply@zivoon.com' . "\r\n" .
				    'X-Mailer: PHP/' . phpversion();

				$this->cmail(str_replace( array( 'http://', 'https://', 'www.' ), '', BASE ), $to, $subject, $message, $headers);

				
				$ret = array( 
							'status' 	=> 'success', 
							'type'		=> 'authentication',
							'params' 	=> array(
											'access_key' => $arr['access_key'], 
											'privileges' => $arr['privileges'], 
											'email_validated' => 0, 
											'name' => $_REQUEST['name'] 
										)
						);
			} else $ret = array( 
								'status' 	=> 'fail',
								'type'		=> 'authentication'
							);
			echo json_encode( $ret );
		}

		function validate_email() {
			$res = $this->mysqli->query("SELECT id, email FROM users WHERE id='" . $_REQUEST['user_id'] . "' AND system_id='" . $this->system_id . "'");
			if( $res->num_rows > 0 ) {
				$arr = $res->fetch_array( MYSQLI_ASSOC );
				$validation_key = $this->get_meta( 'users', $arr['id'], 'signin_email_validation_key' );
				if( $_REQUEST['validation_key'] == $validation_key ) {
					$this->add_meta( 'users', $arr['id'], 'signin_email_validation_key', '' );
					$ret = array( 
								'status'	=> 'success',
								'type'		=> 'email_validation'
									);
				}
			}
			if( !isset( $ret ) ) {
				$ret = array(
							'status'	=> 'fail',
							'type'		=> 'email_validation'
								);
			}
			echo json_encode( $ret );
		}

		function signin() {
			$res = $this->mysqli->query("SELECT id, access_key FROM users WHERE email='" . $_REQUEST['email'] . "' AND system_id='" . $this->system_id . "' AND password='" . md5( $_REQUEST['password'] ) . "'");
			if( $res->num_rows > 0 ) {
				$arr = $res->fetch_array( MYSQLI_ASSOC );
				$name = $this->get_meta( 'users', $arr['id'], 'name' );

				$signin_email_validation_key = $this->get_meta( 'users', $arr['id'], 'signin_email_validation_key' );
				$welcome_email_sent = $this->get_meta( 'users', $arr['id'], 'welcome_email_sent' );
				if( $signin_email_validation_key == '' AND !$welcome_email_sent ) {
					$this->send_welcome_email( $arr['id'] );
					$this->add_meta( 'users', $arr['id'], 'welcome_email_sent', 1 );
				}

				
				$ret = array( 
							'status' 	=> 'success', 
							'type'		=> 'authentication',
							'params' 	=> array(
												'access_key' 		=> $arr['access_key'], 
												'privileges' 		=> $arr['privileges'],
												'email_validated' 	=> ( $signin_email_validation_key != '' ? 0 : 1 ),
												'name' 				=> $name 
										)
						);
			} else $ret = array( 'status' => 'fail' );
			echo json_encode( $ret );
		}

		function send_welcome_email( $user_id ) {
			$res = $this->mysqli->query("SELECT id, email FROM users WHERE id='$user_id' AND system_id='" . $this->system_id . "'");
			if( $res->num_rows > 0 ) {
				$arr = $res->fetch_array( MYSQLI_ASSOC );
				$name = $this->get_meta( 'users', $arr['id'], 'name' );
				
				$to = $arr['email'];
				$subject = 'Your account has been created on ' . str_replace( array( 'http://', 'https://', 'www.' ), '', BASE );
				$message = 'Welcome ' . $name . '!,

Let us be the first to say how excited we are to welcome you! 

You have a whole team behind you dedicated to helping you build a business that allows you to create on your own terms.';
				
				$headers = 'From: no_reply@zivoon.com' . "\r\n" .
				    'Reply-To: no_reply@zivoon.com' . "\r\n" .
				    'X-Mailer: PHP/' . phpversion();

				$this->cmail(str_replace( array( 'http://', 'https://', 'www.' ), '', BASE ), $to, $subject, $message, $headers);
			}
		}

		function signin_recover() {
			$res = $this->mysqli->query("SELECT id, email FROM users WHERE email='" . $_REQUEST['email'] . "' AND system_id='" . $this->system_id . "'");
			if( $res->num_rows > 0 ) {
				$arr = $res->fetch_array( MYSQLI_ASSOC );
				$name = $this->get_meta( 'users', $arr['id'], 'name' );
				$recovery_key = md5( uniqid() );

				$to = $arr['email'];
				$subject = 'Your ' . str_replace( array( 'http://', 'https://', 'www.' ), '', BASE ) . ' password recovery';
				$message = 'Hi ' . $name . ',

We have received a request to reset your password.

Click the following url to change your password:

' . BASE . '/login/?reset=true&user_id=' . $arr['id'] . '&key=' . $recovery_key . '

Ignore if you didn\'t request a new password.

This is an auto generated email, do not reply back.';
				
				$headers = 'From: no_reply@zivoon.com' . "\r\n" .
				    'Reply-To: no_reply@zivoon.com' . "\r\n" .
				    'X-Mailer: PHP/' . phpversion();

				$this->cmail(str_replace( array( 'http://', 'https://', 'www.' ), '', BASE ), $to, $subject, $message, $headers);

				$this->add_meta( 'users', $arr['id'], 'signin_recovery_key', $recovery_key );
				
				$ret = array( 
							'status'	=> 'success', 
							'type' 		=> 'password_recovery' 
						);
			} else {
				$ret = array( 
							'status' 	=> 'fail',
							'type'		
						);
			}
			echo json_encode( $ret );
		}

		function signin_recover_check() {
			if( $this->get_meta( 'users', $_REQUEST['user_id'], 'signin_recovery_key' ) == $_REQUEST['recovery_key'] ) {
				$ret = array( 'status' => 'success', 'type' => 'authentication' );
			} else {
				$ret = array( 'status' => 'fail', 'type' => 'authentication' );
			}

			echo json_encode( $ret );
		}

		function signin_reset() {
			$recovery_key = $this->get_meta( 'users', $_REQUEST['user_id'], 'signin_recovery_key' );
			if( $_REQUEST['password'] != '' & $_REQUEST['password'] == $_REQUEST['repassword'] && $recovery_key == $_REQUEST['recovery_key'] ) {
				$this->mysqli->query("UPDATE users SET password='" . md5( $_REQUEST['password'] ) . "' WHERE id='" . $_REQUEST['user_id'] . "' AND system_id='" . $this->system_id . "'");
				$this->add_meta( 'users', $_REQUEST['user_id'], 'signin_recovery_key', '' );
				$ret = array( 'status' => 'success', 'type' => 'authentication' );
			} else {
				$ret = array( 'status' => 'fail', 'type' => 'authentication' );
			}

			echo json_encode( $ret );
		}

		function shopify_get_access_token() {
			require_once 'includes/shopify.php';
			$shopifyClient = new ShopifyClient($_GET['shop'], "", SHOPIFY_API_KEY, SHOPIFY_SECRET);
			$access_token = $shopifyClient->getAccessToken($_GET['code']);
			if( $access_token != '' ) {
				//fetch & update shop information
				$shopifyClient = new ShopifyClient($_GET['shop'], $access_token, SHOPIFY_API_KEY, SHOPIFY_SECRET);
				try {
					$shop = $shopdata = $shopifyClient->call('GET', '/admin/shop.json' );
				} catch(ShopifyApiException $e){
					$res['e'] = $e;
				}

				//find user with shop email and type shopify 
				$res = $this->mysqli->query("SELECT id, access_token FROM users WHERE email='" . $shop['email'] . "' AND system_id='" . $this->system_id . "'");
				if( $res->num_rows < 1 ) {
					$this->mysqli->query("INSERT INTO users ( system_id, email, password, access_key, privileges ) VALUES ( '" . $this->system_id . "', '" . $shop['email'] . "', '" . md5( uniqid() ) . "', '" . md5( uniqid() ) . "', '[]' )");
					$res = $this->mysqli->query("SELECT id, access_key, privileges FROM users WHERE email='" . $shop['email'] . "' AND system_id='" . $this->system_id . "'");
				}

				$user = $res->fetch_array( MYSQLI_ASSOC );

				$this->add_meta( 'users', $user['id'], 'login_type', 'shopify' );
				$this->add_meta( 'users', $user['id'], 'access_token', $access_token );
				
				foreach( array_keys( $shop ) as $shop_key ) {
					if( $shop_key != '' ) $this->add_meta( 'users', $user['id'], $shop_key, $shop[ $shop_key ] );
				}
				//fetch billing information
				if( SHOPIFY_APP_CHARGE != false ) {
					$shopify_billing = $this->get_meta( 'users', $user['id'], 'shopify_billing' );
					if( $shopify_billing != false ) {
						$shopify_billing = str_replace( '\"', '"', $shopify_billing );
						$shopify_billing = json_decode( $shopify_billing, true );
						if( $shopify_billing['access_token'] == $access_token ) $billed = 1;
						else {
							$billed = 0;
						}
					} else $billed = 0;
				} else $billed = 1;

				$ret = array( 
							'status' 	=> 'success',
							'type'	 	=> 'shopify_get_access_token',
							'params' 	=> array(
												'access_key' 		=> $user['access_key'], 
												'privileges' 		=> $user['privileges'], 
												'access_token' 		=> $access_token, 
												'shop' 				=> $_REQUEST['shop'], 
												'email_validated' 	=> 1,
												'billed' 			=> $billed 
											)
						);

				if( !$billed ) {
					if( SHOPIFY_APP_CHARGE_TYPE == 'recurring' ) {
						try {
			          		$charge_init = $shopifyClient->call('POST', '/admin/recurring_application_charges.json', array( 'recurring_application_charge' => array( 'name' => SHOPIFY_APP_PACKAGE_NAME, 'price' => SHOPIFY_APP_CHARGE_AMOUNT , 'trial_days' => SHOPIFY_APP_TRIAL_DAYS, 'return_url' => BASE . '/login/shopify/?subscribe=true', 'test' => ( $shop['plan_name'] == 'affiliate' ? 'true' : SHOPIFY_APP_CHARGE_TEST ) ) ) );
			            } catch(ShopifyApiException $e){
			            	echo '<pre>';
			            		var_dump( $e );
			            	echo '</pre>';
			            }

			            $ret['params']['shopify_app_charge_confirmation_url'] = $charge_init['confirmation_url'];
					}
				}
			} else $ret = array( 'status' => 'fail', 'type' => 'shopify_get_access_token' );
			echo json_encode( $ret );
		}

		function shopify_activate_charge() {
			require_once 'includes/shopify.php';
			if( $this->user_id > 0 ) {
				$shop = $this->get_meta( 'users', $this->user_id, 'myshopify_domain' );
				$access_token = $this->get_meta( 'users', $this->user_id, 'access_token' );
				$shopifyClient = new ShopifyClient($shop, $access_token, SHOPIFY_API_KEY, SHOPIFY_SECRET);

				try {
					$data = $shopifyClient->call('GET', '/admin/recurring_application_charges/' . $_REQUEST['charge_id'] . '.json');
				} catch(ShopifyApiException $e){
					echo '<pre>';
						var_dump( $e );
					echo '</pre>';
				}
					
				if( $data['status'] == 'accepted' ) {
					try {
						$activate = $shopifyClient->call('POST', '/admin/recurring_application_charges/' . $_REQUEST['charge_id'] . '/activate.json', array('recurring_application_charge'=>$data));
					} catch(ShopifyApiException $e){
						echo '<pre>';
							var_dump( $e );
						echo '</pre>';
					}

					$data['access_token'] = $access_token;

					$this->add_meta( 'users', $this->user_id, 'shopify_billing', json_encode( $data ) );
					$ret = array( 'status' => 'success', 'type' => 'shopify_activate_charge' );
				} else {
					//payment declined
				}

				if( !isset( $ret ) ) $ret = array( 'status' => 'fail', 'type' => 'shopify_activate_charge' );
				echo json_encode( $ret );
			}
		}

		function cmail($from, $to, $subject, $message) {
		    $postdata = http_build_query(
		        array(
		            'from_name' => $from,
		            'to_email' => $to,
		            'subject' => $subject,
		            'body' => $message
		        )
		    );

		    $opts = array('http' =>
		        array(
		            'method'  => 'POST',
		            'header'  => 'Content-Type: application/x-www-form-urlencoded',
		            'content' => $postdata
		        )
		    );

		    $context  = stream_context_create($opts);
		    $result = file_get_contents(CPBASE . '/mail/index.php', false, $context);
		}
	}
?>