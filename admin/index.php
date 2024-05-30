<?php
session_start();
//google recaptcha
$public_key = "6LdxcpwpAAAAALM0MTSLJgh15EC9q6bEb0C52v93";
$private_key = "6LdxcpwpAAAAAGCEpPULmDkTdVgGJxYEnnMU3A_n";
$url = "https://www.google.com/recaptcha/api/siteverify";
if(isset($_POST['submit'])){
  //Google recaptcha
  $response_key = $_POST['g-recaptcha-response'];

  //https://www.google.com/recaptcha/api/siteverify?secret=$private_key&response=$response_key&remoteip=currentScriptIpAddress
  $response = file_get_contents($url . "?secret=" . $private_key . "&response=" . $response_key . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
  $response = json_decode($response);
  if(!($response->success == 1)) {
    $errCaptcha = "Wrong captcha";
}
}

?>

<!DOCTYPE html>
<html lang="en" >
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
if(isset($_POST['submit']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if(!empty($_POST["submit"])) 
     {
	$loginquery ="SELECT * FROM admin WHERE username='$username' && password='".md5($password)."'";
	$result=mysqli_query($db, $loginquery);
	$row=mysqli_fetch_array($result);
	
	                        if(is_array($row))
								{
                                    	$_SESSION["adm_id"] = $row['adm_id'];
										header("refresh:1;url=dashboard.php");
	                            } 
							else
							    {
										echo "<script>alert('Invalid Username or Password!');</script>"; 
                                }
	 }
	
	
}

?>

<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

      <link rel="stylesheet" href="css/login.css">

  
</head>

<body>

  
<div class="container">
  <div class="info">
    <h1>Admin Panel </h1>
  </div>
</div>
<div class="form">
  <div class="thumbnail"><img src="images/manager.png"/></div>
  <span style="color:red;"><?php echo $message; ?></span>
   <span style="color:green;"><?php echo $success; ?></span>
  <form class="login-form" action="index.php" method="post">
    <input type="text" placeholder="Username" name="username"/>
    <input type="password" placeholder="Password" name="password"/>
    <div class="g-recaptcha" data-sitekey="<?php echo $public_key; ?>"></div>
            <?php echo isset($errCaptcha)?"<span class='error'>{$errCaptcha}</span>":""; ?>
    <input type="submit"  name="submit" value="Login" />

  </form>
  
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src='js/index.js'></script>
  <script src="https://www.google.com/recaptcha/api.js"></script>
</body>

</html>
