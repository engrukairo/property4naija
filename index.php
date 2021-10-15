<?php
session_start();
if(!isset($_COOKIE['property_login'])){header("Location: login.php"); exit;}

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
          <a href="logout.php" class="btn btn-warning">Sign Out</a>
        </div>
      </div>
    </div>
  </header>
  <div class="container mt-5">
  	<div class="row justify-content-center mx-auto">
		<div class="col-lg-8">
			<?php if(isset($_SESSION['update'])){$update = $_SESSION['update']; unset($_SESSION['update']);}else{$update = "";} echo $update;?>
			Welcome <?php echo $_SESSION['property_username'];?>! Your email address is <?=$_SESSION['property_email'];?>
		</div>
	</div>
  </div>

<script src="bootstrap.min.js"></script>
</body>
</html>
