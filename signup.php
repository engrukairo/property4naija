<?php
session_start();

$hostname = "localhost";
$dbusername = "pro4nj";
$dbpassword = "pro4nj";
$database = "pro4nj";
try {
$pro4nj = new PDO("mysql:host=$hostname;dbname=$database", $dbusername, $dbpassword);
}
catch (PDOException $e) {
echo 'Error: '.$e->getMessage();
exit;
}

	if(isset($_POST['createAccount'])){
		$name = addslashes($_POST['name']);
		$email = addslashes($_POST['email']);
		$phone = addslashes($_POST['phone']);
		$username = addslashes($_POST['username']);
		$password = addslashes($_POST['password']);
		$password = password_hash($password, PASSWORD_DEFAULT);
		$dob = addslashes($_POST['dob']);
		
		$sql = "SELECT COUNT(*) FROM users WHERE phone = '".$phone."'";
		$result = $pro4nj->query($sql);
		$error = $pro4nj->errorInfo();
		if (isset($error[2])) die($error[2]);
		$wwws = $result->fetchColumn();
		if ($wwws > 0) {$_SESSION['update'] = "<div class='alert alert-warning' align='center'>The phone number you entered has been used earlier to sign up.</div>";
									header("Location: ".$_SERVER['HTTP_REFERER']); exit;
		}

		$sql = "SELECT COUNT(*) FROM users WHERE email = '".$email."'";
		$result = $pro4nj->query($sql);
		$error = $pro4nj->errorInfo();
		if (isset($error[2])) die($error[2]);
		$wwws = $result->fetchColumn();
		if ($wwws > 0) {$_SESSION['update'] = "<div class='alert alert-warning' align='center'>The email address you entered has been used earlier to sign up.</div>";
									header("Location: ".$_SERVER['HTTP_REFERER']); exit;
		}

		$sql = "SELECT COUNT(*) FROM users WHERE username = '".$username."'";
		$result = $pro4nj->query($sql);
		$error = $pro4nj->errorInfo();
		if (isset($error[2])) die($error[2]);
		$wwws = $result->fetchColumn();
		if ($wwws > 0) {$_SESSION['update'] = "<div class='alert alert-warning' align='center'>The username you entered has been used earlier to sign up.</div>";
									header("Location: ".$_SERVER['HTTP_REFERER']); exit;
		}

		$sql = "INSERT INTO `users`(`name`, `email`, `phone`, `dob`, `password`, `username`) VALUES ('$name','$email','$phone','$dob','$password','$username')";
			$result = $pro4nj->query($sql);
			$error = $pro4nj->errorInfo();
			if (isset($error[2])) die($error[2]);

			
			setcookie("property_login", $email, time()+60*60*24*365, "/");
			$_SESSION['property_username'] = $username;
			$_SESSION['property_email'] = $email;
			$_SESSION['update'] = "<div class='alert alert-success'>Your account has been created successfully.</div>";

			//send welcome email
			$subject = "Welcome to Property for Naija";
			$email_content = "Welcome to Property for Naija";
			$subj3 = " $email";
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Property Support <support@property.com>';
			mail($subj3, $subject, $email_content, $headers);
			header("Location: index.php"); exit;
		}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link rel="stylesheet" href="bootstrap.min.css" />
<link rel="stylesheet" href="mystyle" />
</head>

<body>

  <header class="p-3 bg-light text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <img src="logo-md-7.png" height="40px" />
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="index.php" class="nav-link px-2 text-secondary">Home</a></li>
          <li><a href="#" class="nav-link px-2 text-black">Contact Us</a></li>
          <li><a href="#" class="nav-link px-2 text-black">FAQs</a></li>
          <li><a href="#" class="nav-link px-2 text-black">About Us</a></li>
        </ul>

        <div class="text-end">
          <a href="login.php" class="btn btn-primary">Log In</a>
        </div>
      </div>
    </div>
  </header>
  <div class="container">
  	<div class="row justify-content-center mx-auto">
		<div class="col-lg-8 my-5">
			<?php if(isset($_SESSION['update'])){$update = $_SESSION['update']; unset($_SESSION['update']);}else{$update = "";} echo $update;?>
			<h1 class="text-center">Create a New Account</h1>
			<form action="<?=$_SERVER['REQUEST_URI'];?>" method="POST">
				<div class="row">
					<div class="form-group col-md-6">
						<label>Your Name</label>
						<input type="text" name="name" class="form-control" required="required" />
					</div>
					<div class="form-group col-md-6">
						<label>Your DoB</label>
						<input type="text" name="dob" class="form-control" required="required" />
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label>Your Phone Number</label>
						<input type="number" name="phone" class="form-control" required="required" />
					</div>
					<div class="form-group col-md-6">
						<label>Your Email Address</label>
						<input type="email" name="email" class="form-control" required="required" />
					</div>
				</div>
				<div class="form-group">
					<label>Create a Username</label>
					<input type="text" name="username" class="form-control" required="required" />
				</div>
				<div class="form-group">
					<label>Create a Password</label>
					<input type="password" name="password" class="form-control" required="required" />
				</div>
				<div class="form-group mt-3">
					<input type="submit" name="createAccount" class="form-control btn btn-primary" value="Create Account" />
				</div>
			</form>
		</div>
	</div>
  </div>

<script src="bootstrap.min.js"></script>
</body>
</html>