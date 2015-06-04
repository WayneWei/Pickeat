<!DOCTYPE HTML> 
<html>
<head>
<title>登入</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
	<link href="css/login.css" rel="stylesheet">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</head>
<body> 
	
<?php
	session_start(); 
	$error="";
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$email = $_POST["email"];
		$pwd = $_POST["pwd"];

		include("mysql_config.php");

		$sql = "SELECT * FROM `account` WHERE email = '$email' ";
		$result = mysql_query($sql);
		$row = @mysql_fetch_row($result);

		if($email != null && $pwd != null && $row[1] == $email && $row[2] == $pwd){
        	$_SESSION['users'] = array();
			$_SESSION['users']['username'] = $row[0];
			$_SESSION['users']['email'] = $email;
        	$error = "";
        	$url = "index.php";
			echo "<script type='text/javascript'>";
			echo "window.location.href='$url'";
			echo "</script>"; 
		}
		else{
			$error ="帳號 或 密碼  錯誤";
		}
	}
?>

<div class="container">
<form class="form-signin" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
<h1 class="form-signin-heading">登入</h1>


<input type="text" name="email" class="form-control" placeholder="電子郵件" required autofocus>

<input type="password" name="pwd" class="form-control" placeholder="密碼" required>
<br>
<button class="btn btn-large btn-info btn-block" type="submit">登入</button>
<a href="register.php" class="btn btn-large btn-warning btn-block">註冊</a>
<a href="index.php" class="btn btn-large btn-default btn-block">返回</a>

<?php
	if($error==null){
	}
	else{
		echo "<div class=\"alert alert-danger col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-1\">
        			<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        			<strong>提示：</strong> $error
    			</div>";
	}
?>        
</form>

</div>

<div class="navbar navbar-fixed-bottom">
	<div class="container">
		<p class="navbar-text text-default ">Copyright &copy; 2084 WAYNE WEI </p>
	</div>
</div>

</body>
</html>