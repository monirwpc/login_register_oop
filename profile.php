<?php 
	include 'inc/header.php';
	include 'lib/User.php';
	session::checkSession();
	$user = new User();

	if( isset($_GET['p']) ) {
		$profileID = $_GET['p'];
	}	
?>

<?php
	if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update']) ) {
		$usrUpdate = $user->userUpdate($_POST);
	}
?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>User Update <span class="pull-right"><a class="btn btn-primary" href="index.php">Back</a></span></h2>
		</div>
		<div class="panel-body">
			<div style="max-width: 600px; margin: 0 auto">
			<?php 
				if( isset($usrUpdate) ) {
					echo $usrUpdate;
				}
			?>
			</div>
			<?php 
				$profileData = $user->getProfileData($profileID);
				if( $profileData ) {
			?>
			<form action="" method="POST" style="max-width: 600px; margin: 0 auto">
				<input type="hidden" name="id" value="<?php echo $profileData->id; ?>">
				<input type="hidden" name="hidEmail" value="<?php echo $profileData->email; ?>">
				<div class="form-group">
				    <label for="name">Name</label>
				    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="<?php echo $profileData->name; ?>">
				</div>
				<div class="form-group">
				    <label for="username">Username</label>
				    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" value="<?php echo $profileData->username; ?>">
				</div>
				<div class="form-group">
				    <label for="email">Email Address</label>
				    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" value="<?php echo $profileData->email; ?>">
				</div>
				<?php 
					$sessonId = Session::get('id');
					if( $sessonId == $profileData->id ) {
				?>
				<button type="submit" name="update" class="btn btn-primary">Update</button>
				<a class="btn btn-info" href="change-password.php?p=<?php echo $profileID; ?>">Change Password</a>
				<?php } ?>
			</form>
			<?php } ?>
		</div>
	</div>

<?php include_once 'inc/footer.php'; ?>
