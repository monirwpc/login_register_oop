<?php 	
	$filePath = realpath( dirname(__FILE__) );
	include_once $filePath.'/../lib/Session.php';
	Session::init();
?>

<?php 
	if( isset($_GET['action']) && $_GET['action'] == 'logout' ) {
		Session::destroy();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>OOP Login Register</title>
	<link rel="stylesheet" href="inc/bootstrap.min.css"/>
	<script src="inc/jquery.min.js"></script>
	<script src="inc/bootstrap.min.js"></script>
</head>
<body>

	<div class="container">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">Login Register System with PHP OOP</a>
				</div>
				<ul class="nav navbar-nav pull-right">
					<?php 
						$id = Session::get('id');
						$usrIsLoged = Session::get('login');
						if( $usrIsLoged == true ) {
					?>
						<li><a href="index.php">Home</a></li>
						<li><a href="profile.php?p=<?php echo $id; ?>">Profile</a></li>
						<li><a href="?action=logout">Logout</a></li>
					<?php } else { ?>
						<li><a href="login.php">Login</a></li>
						<li><a href="register.php">Register</a></li>
					<?php } ?>
				</ul>
			</div>
		</nav>