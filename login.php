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

	if(isset($_POST['signIn'])){
		$username = addslashes($_POST['username']);
		$password = addslashes($_POST['password']);
		
		$sql = "SELECT COUNT(*) FROM users WHERE username = '".$username."'";
		$result = $pro4nj->query($sql);
		$error = $pro4nj->errorInfo();
		if (isset($error[2])) die($error[2]);
		$usercount = $result->fetchColumn();

		if($usercount == 1){
			$sql = "SELECT password FROM users WHERE username = '$username'";
				foreach ($pro4nj ->query($sql) as $row){
				$hpassword = $row['password'];
				
					if (password_verify($password, $hpassword)) {
						$sql = "SELECT * FROM users WHERE username = '$username'";
							foreach ($pro4nj ->query($sql) as $row){
							$username = $row['username'];
							$useremail = $row['email'];
							$name = $row['name'];
	
							setcookie("property_login", $useremail, time()+60*60*24*365, "/");
							$_SESSION['property_username'] = $username;
							$_SESSION['property_email'] = $useremail;
							$_SESSION['update'] = "<div class='alert alert-success text-center'>Your have successfully logged in.</div>";
								//send a gossip email...lol
								$subject = "Your account has been used to log in";
								$email_content = "Your account has just been used to log in to Property for Naija";
								$subj3 = " $useremail";
								$headers  = 'MIME-Version: 1.0' . "\r\n";
								$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
								$headers .= 'From: Property Support <support@property.com>';
								mail($subj3, $subject, $email_content, $headers);
							header("Location: index.php"); exit;
						}
					}else{$_SESSION['update'] = "<div class='alert alert-danger' align='center'>The password you entered is wrong.</div>";}
				}
		}else{$_SESSION['update'] = "<div class='alert alert-danger' align='center'>The Username you entered does not exist.</div>";}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link rel="stylesheet" href="bootstrap.min.css" />
</head>

<body>

  <header class="p-3 bg-light text-white">
    <div class="container mt-5">
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
          <a href="signup.php" class="btn btn-warning">Sign Up</a>
        </div>
      </div>
    </div>
  </header>
  <div class="container">
  	<div class="row justify-content-center mx-auto">
		<div class="col-lg-5 my-5">
			<?php if(isset($_SESSION['update'])){$update = $_SESSION['update']; unset($_SESSION['update']);}else{$update = "";} echo $update;?>
			<h1 class="text-center">Sign In</h1>
			<form action="<?=$_SERVER['REQUEST_URI'];?>" method="POST">
				<div class="form-group">
					<label>Your Username</label>
					<input type="text" name="username" class="form-control" required="required" />
				</div>
				<div class="form-group">
					<label>Your Password</label>
					<input type="password" name="password" class="form-control" required="required" />
				</div>
				<div class="form-group mt-3">
					<input type="submit" name="signIn" class="form-control btn btn-primary" value="Sign In" />
				</div>
				<p>New here? <a href="signup.php">Please sign up</a></p>
			</form>
		</div>
	</div>
  </div>

<script src="bootstrap.min.js"></script>
</body>
</html>
