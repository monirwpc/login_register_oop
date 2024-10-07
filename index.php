<?php 
	include 'inc/header.php';
	include 'lib/User.php';
	session::checkSession();
	$user = new User();
?>

<?php 
	$loginmsg = Session::get('loginmsg');
	if( isset($loginmsg) ) {
		echo $loginmsg;
	}
	Session::set('loginmsg', NULL );
?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>User List <span class="pull-right">Wellcome<span style="text-transform: uppercase; font-weight: bold;">
				<?php 
					$name = Session::get('username');
					if( isset($name) ) {
						echo $name;
					}
				?>
			</span></span></h2>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-bordered">
				<tr>
					<th width="20%">Serial</th>
					<th width="20%">Name</th>
					<th width="20%">Username</th>
					<th width="20%">Email</th>
					<th width="20%">Action</th>
				</tr>
				<?php 
					$userData = $user->getUserData();
					if( $userData ) {
						$i = 0;
						foreach( $userData as $data ) {
						$i++;
				?>
				<tr>
					<td width="20%"><?php echo $i; ?></td>
					<td width="20%"><?php echo $data['name']; ?></td>
					<td width="20%"><?php echo $data['username']; ?></td>
					<td width="20%"><?php echo $data['email']; ?></td>
					<td width="20%">
						<a class="btn btn-primary" href="profile.php?p=<?php echo $data['id']; ?>">View</a>
					</td>
				</tr>
			<?php } } else { ?>
				<tr>
					<td colspan="5"><h3><strong>Sorry! No user data found..</strong></h3></td>
				</tr>
			<?php } ?>
			</table>
		</div>
	</div>
<?php include_once 'inc/footer.php'; ?>


