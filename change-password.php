<?php 
	include 'inc/header.php';
	include 'lib/User.php';
	session::checkSession();
	$user = new User();

	if( isset($_GET['p']) ) {
		$profileID = $_GET['p'];
		$sessonId = Session::get('id');
		if( $profileID != $sessonId ) {
			header('Location: index.php');
		}
	}
?>

<?php
	if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['changepass']) ) {
		$updatePass = $user->updatePassword($_POST);
	}
?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Change Password <span class="pull-right"><a class="btn btn-primary" href="profile.php">Back</a></span></h2>
		</div>
		<div class="panel-body">
			<div style="max-width: 600px; margin: 0 auto">
			<?php 
				if( isset($updatePass) ) {
					echo $updatePass;
				}
			?>
			</div>
			<form action="" method="POST" style="max-width: 600px; margin: 0 auto">
				<input type="hidden" name="id" value="<?php echo $profileID; ?>">
				<div class="form-group">
				    <label for="oldpass">Old Password</label>
				    <input type="password" class="form-control" name="oldpass" id="oldpass" placeholder="Password">
				</div>
				<div class="form-group">
				    <label for="newpass">New Password</label>
				    <input type="password" class="form-control" name="newpass" id="newpass" placeholder="Password">
				</div>
				<button type="submit" name="changepass" class="btn btn-primary">Password Change</button>
			</form>
		</div>
	</div>

<?php include_once 'inc/footer.php'; ?>
