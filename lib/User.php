<?php 

	include_once 'Session.php';
	include 'Database.php';

	class User {
		private $db;
		public function __construct() {
			$this->db = new Database();
		}

		public function userRegistration( $data ) {
			$name  = $data['name'];
			$usrnm = $data['username'];
			$email = $data['email'];
			$pass  = $data['password'];
			$chkEmail = $this->emailCheck( $email );

			if( $name == '' || $usrnm == '' || $email == ''|| $pass == '' ) {
				$msg = "<div class='alert alert-danger'><strong>Error! </strong>Field must not be empty...</div>";
				return $msg;
			}

			if ( strlen($usrnm ) < 3 ) {
				$msg = "<div class='alert alert-danger'><strong>Error! </strong>User name must be more than 3 character...</div>";
				return $msg;
			} elseif ( preg_match('/[^a-z0-9_-]+/i', $usrnm ) ) {
				$msg = "<div class='alert alert-danger'><strong>Error! </strong>User name must only contain alphanumeric, dash or underscore...</div>";
				return $msg;
			}

			if( filter_var( $email, FILTER_VALIDATE_EMAIL === false ) ) {
				$msg = "<div class='alert alert-danger'><strong>Error! </strong> Email address is not valid...</div>";
				return $msg;
			}

			if( $chkEmail == true ) {
				$msg = "<div class='alert alert-danger'><strong>Error! </strong>Email address already exist...</div>";
				return $msg;
			}
			$pass  = md5( $data['password']);
			$sql = "INSERT INTO tbl_user (name, username, email, password) VALUES (:name, :username, :email, :password)";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':name', $name);
			$query->bindValue(':username', $usrnm);
			$query->bindValue(':email', $email);
			$query->bindValue(':password', $pass);
			$result = $query->execute();
			if( $result ) {
				$msg = "<div class='alert alert-success'><strong>Success! </strong>new user has been Registered...</div>";
				return $msg;
			} else {
				$msg = "<div class='alert alert-danger'><strong>Oops! </strong>user registration failed...</div>";
				return $msg;
			}
		}


		public function emailCheck( $email ) {
			$sql = "SELECT email FROM tbl_user WHERE email = :email";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':email', $email);
			$query->execute();
			if( $query->rowCount() > 0 ) {
				return true;
			} else {
				return false;
			}
		}


		public function getLoginUser( $email, $password ) {
			$sql = "SELECT * FROM tbl_user WHERE email = :email AND password = :password LIMIT 1";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':email', $email);
			$query->bindValue(':password', $password);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		}


		public function userLogin( $data ) {
			$email = $data['email'];
			$pass  = md5( $data['password'] );

			$chkEmail = $this->emailCheck( $email );

			if( $email == ''|| $pass == '' ) {
				$msg = "<div class='alert alert-danger'><strong>Error! </strong>Field must not be empty...</div>";
				return $msg;
			}

			if( filter_var( $email, FILTER_VALIDATE_EMAIL === false ) ) {
				$msg = "<div class='alert alert-danger'><strong>Error! </strong> Email address is not valid...</div>";
				return $msg;
			}

			if( $chkEmail == false ) {
				$msg = "<div class='alert alert-danger'><strong>Error! </strong>Email address doesn't exist...</div>";
				return $msg;
			}

			$result = $this->getLoginUser( $email, $pass );
			if( $result ) {
				Session::init();
				Session::set('login', true);
				Session::set('id', $result->id);
				Session::set('username', $result->username);
				Session::set('email', $result->email);
				Session::set('loginmsg', '<div class="alert alert-success"><strong>Success! </strong>you are logged in...</div>');
				header('Location: index.php');
			} else {
				$msg = "<div class='alert alert-danger'><strong>Error! </strong>Login data not found...</div>";
				return $msg;
			}
		}


		public function getUserData() {
			$sql = "SELECT * FROM tbl_user ORDER BY id DESC";
			$query = $this->db->pdo->prepare($sql);
			$query->execute();
			$result = $query->fetchAll();
			return $result;
		}

		public function getProfileData( $profileID ) {
			$sql = "SELECT * FROM tbl_user WHERE id= :profileID";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue( ':profileID', $profileID );
			$query->execute();
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		}


		public function emailCheckforUpdateUser( $email , $hidEmail ) {
			$sql = "SELECT email FROM tbl_user WHERE email = :email";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':email', $email);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_OBJ);
			if( isset( $result ) && $query->rowCount() > 0 ) {
				$upEmail = $result->email;
			} else {
				$upEmail = NULL;
			}			
			if( $query->rowCount() > 0 ) {
				if( $hidEmail == $upEmail ) {
					return false;
				} else {
					return true;
				}
			} else {
				return false;
			}
		}


		public function userUpdate( $data ) {
			$id    = $data['id'];
			$hidEmail = $data['hidEmail'];
			$name  = $data['name'];
			$usrnm = $data['username'];
			$email = $data['email'];
			// $pass  = md5( $_POST['password'] );

			$chkUpdateEmail = $this->emailCheckforUpdateUser( $email , $hidEmail);

			if( $name == '' || $usrnm == '' || $email == '' ) {
				$msg = "<div class='alert alert-danger'><strong>Error! </strong>Field must not be empty...</div>";
				return $msg;
			}

			if ( strlen($usrnm ) < 3 ) {
				$msg = "<div class='alert alert-danger'><strong>Error! </strong>User name must be more than 3 character...</div>";
				return $msg;
			} elseif ( preg_match('/[^a-z0-9_-]+/i', $usrnm ) ) {
				$msg = "<div class='alert alert-danger'><strong>Error! </strong>User name must only contain alphanumeric, dash or underscore...</div>";
				return $msg;
			}

			if( filter_var( $email, FILTER_VALIDATE_EMAIL === false ) ) {
				$msg = "<div class='alert alert-danger'><strong>Error! </strong> Email address is not valid...</div>";
				return $msg;
			}

			if( $chkUpdateEmail == true ) {
				$msg = "<div class='alert alert-danger'><strong>Error! </strong>Email address already exist...</div>";
				return $msg;
			}

			$sql = "UPDATE tbl_user SET name = :name, username = :username, email = :email WHERE id = :id LIMIT 1";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':id', $id);
			$query->bindValue(':name', $name);
			$query->bindValue(':username', $usrnm);
			$query->bindValue(':email', $email);
			$result = $query->execute();
			if( $result ) {
				$msg = "<div class='alert alert-success'><strong>Success! </strong>update completed...</div>";
				return $msg;
			} else {
				$msg = "<div class='alert alert-danger'><strong>Oops! </strong>updation failed...</div>";
				return $msg;
			}
		}


		public function oldPassCheck($id, $oldpass) {
			$oldpass = md5($oldpass);
			$sql   = "SELECT password FROM tbl_user WHERE id = :id AND password = :password";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':id', $id);
			$query->bindValue(':password', $oldpass);
			$query->execute();
			if( $query->rowCount() > 0 ) {
				return true;
			} else {
				return false;
			}
		}



		public function updatePassword($data) {
			$oldpass = $data['oldpass'];
			$newpass = $data['newpass'];
			$id      = $data['id'];

			$oldPassChk = $this->oldPassCheck($id, $oldpass);

			if( $oldpass=="" || $newpass == "" ) {
				$msg = "<div class='alert alert-danger'><strong>Error! </strong>Field must not be empty...</div>";
				return $msg;
			}

			if ( $oldPassChk == false ) {
				$msg = "<div class='alert alert-danger'><strong>Error! </strong>Old password does not exist...</div>";
				return $msg;
			}

			if( strlen( $newpass ) < 5 ) {
				$msg = "<div class='alert alert-danger'><strong>Error! </strong>Enter password atleast 5 character...</div>";
				return $msg;
			}

			$newpass = md5( $newpass );
			$sql = "UPDATE tbl_user SET password = :password WHERE id = :id LIMIT 1";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':id', $id);
			$query->bindValue(':password', $newpass);
			$result = $query->execute();
			if( $result ) {
				$msg = "<div class='alert alert-success'><strong>Success! </strong>Password update completed...</div>";
				return $msg;
			} else {
				$msg = "<div class='alert alert-danger'><strong>Oops! </strong>updation failed...</div>";
				return $msg;
			}

		}





	}

