<?php 
	include_once 'inc/header.php'; 
	include 'lib/User.php';
	Session::checkLogged();
?>

<?php 
	$user = new User();
	if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login']) ) {
		$usrLogin = $user->userLogin($_POST);
	}
?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>User Login</h2>
		</div>
		<div class="panel-body">
			<div style="max-width: 600px; margin: 0 auto">
			<?php 
				if( isset($usrLogin) ) {
					echo $usrLogin;
				}
			?>
			</div>
			<form action="" method="POST" style="max-width: 600px; margin: 0 auto">
				<div class="form-group">
				    <label for="email">Email Address</label>
				    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address">
				</div>
				<div class="form-group">
				    <label for="password">Password</label>
				    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
				</div>
				<button type="submit" name="login" class="btn btn-primary">Login</button>
			</form>
		</div>
	</div>

<?php include_once 'inc/footer.php'; ?>
