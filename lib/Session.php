<?php 

	class Session {
		public static function init(){
			if( version_compare(phpversion(), '5.4.0', '<') ) {
				if( session_id() == '' ) {
					session_start();
				} else {
					if( session_status() == PHP_SESSION_NONE ) {
						session_start();
					}
				}
			}

			session_start();
		}

		public static function set($key, $val) {
			$_SESSION[$key] = $val;
		}

		public static function get($key) {
			if( isset($_SESSION[$key]) ) {
				return $_SESSION[$key];
			} else {
				return false;
			}
		}

		//check if session is not active current time then user can not access any pages without login
		public static function checkSession() {
			if ( self::get('login') == false ) {
				self::destroy();
				header('Location: login.php');
			}
		}

		//check if session active current time then user cann't access into login.php page
		public static function checkLogged() {
			if ( self::get('login') == true ) {
				header('Location: index.php');
			}
		}


		public static function destroy() {
			session_destroy();
			session_unset();
			header('Location: login.php');
		}
	}