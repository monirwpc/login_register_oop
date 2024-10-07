<?php 
	include_once 'inc/header.php'; 
	include 'lib/User.php'; 
?>

<?php 
	$user = new User();
	if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register']) ) {
		$usrReg = $user->userRegistration($_POST);
	}
?>


	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>User Registration</h2>
		</div>
		<div class="panel-body">
			<div style="max-width: 600px; margin: 0 auto">
			<?php 
				if( isset($usrReg) ) {
					echo $usrReg;
				}
			?>
			</div>
			<form action="" method="POST" style="max-width: 600px; margin: 0 auto">
				<div class="form-group">
				    <label for="name">Name</label>
				    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
				</div>
				<div class="form-group">
				    <label for="username">Username</label>
				    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username">
				</div>
				<div class="form-group">
				    <label for="email">Email Address</label>
				    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address">
				</div>
				<div class="form-group">
				    <label for="password">Password</label>
				    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
				</div>
				<button type="submit" name="register" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>

<?php include_once 'inc/footer.php'; ?>
