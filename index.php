<?php 

session_start(); 

// If the user has submitted the form
if( isset($_POST['register']) ) {

	// Check the captcha answer
	// If the users answer is the same as the session answer
	if($_POST['captcha-answer'] == $_SESSION['captcha-answer']) {

		// Redirect the user
		header('Location: success.php');
	
	} else {
		// If the got it wrong
		echo 'Sorry, try again';
	}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PHP GD Captcha</title>
</head>
<body>

	<?php

		// Get the captcha maker class
		require_once 'vendor/captcha-maker.php';

		// Instantiate the class using namespaces
		$captchaMaker = new CaptchaMaker\CaptchaMaker();

		// Create a brand new captcha image
		$captchaMaker->makeCaptcha();

		// Get the new image to display to the user
		$captchaImage = $captchaMaker->getFileName();

		// Get captcha answer and save in the session
		$_SESSION['captcha-answer'] = $captchaMaker->getAnswer();

	?>


	<form action="index.php" method="post">

		<label for="captcha">Captcha: </label>
		<input type="text" name="captcha-answer" id="captcha-answer">

		<img src="img/captcha/<?= $captchaImage; ?>" alt="Captcha Test">
	
		<input type="submit" value="Register!" name="register">

	</form>	
	
</body>
</html>