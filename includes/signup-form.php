<?php
if (isset($_POST['signup'])) {
	$screenName = $_POST['screenName'];
	$email 		= $_POST['email'];
	$password 	= $_POST['password'];
	$error = "";

	if (empty($screenName) || empty($password) || empty($email)) {
		$error = "All fields are required";
	} else {
		$screenName = $getFromU->checkInput($screenName);
		$email 		= $getFromU->checkInput($email);
		$password 	= $getFromU->checkInput($password);

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = "Invalid email format!";
		} elseif (strlen($screenName) > 20) {
			$error = "Name must be no more 20 characters!";
		} elseif (strlen($password) < 5) {
			$error = "Passwort is too short!";
		} else {
			if ($getFromU->checkEmail($email) === true) {
				$error = "Email is already used!";
			} else {
				$user_id = $getFromU->create('users', array(
					'email' => $email, 'password' => md5($password), 'screenName' => $screenName, 'profileImage' => 'assets/images/defaultProfileImage.png',
					'profileCover' => 'assets/images/defaultCoverImage.png'
				));
				$_SESSION['user_id'] = $user_id;
				header("Location: includes/signup.php?step=1");
				exit();
			}
		}
	}
}
?>
<form method="post">
	<div class="signup-div">
		<h3>Sign up </h3>
		<ul>
			<li>
				<input type="text" name="screenName" placeholder="Full Name" />
			</li>
			<li>
				<input type="email" name="email" placeholder="Email" />
			</li>
			<li>
				<input type="password" name="password" placeholder="Password" />
			</li>
			<li>
				<input type="submit" name="signup" Value="Signup for Twitter">
			</li>
			<?php
			if (isset($error)) {
				echo '<li class="error-li"><div class="span-fp-error">' . $error . '</div></li>';
			}
			?>
		</ul>
	</div>
</form>