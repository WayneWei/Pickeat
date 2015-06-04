<!DOCTYPE HTML> 
<html>
<head>
<title>註冊</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
	<link href="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link href="css/register.css" rel="stylesheet">
	<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
</head>
<body> 


<?php

include("mysql_config.php");

$nameErr = $emailErr = $pwdErr = $pwd2Err = $genderErr = $birthdayErr = "";
$name = $email = $pwd = $pwd2 = $gender = $birthday = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if(empty($_POST["name"])) {
    	$nameErr = "這裡必須填入資料";
   	} 
   	else{
    	$name = test_input($_POST["name"]);
     	if (!preg_match("/^[a-zA-Z ]{3,16}$/",$name)) {
       		$nameErr = "輸入3-16個英文字母或空白"; 
     	}
    }
   
    if(empty($_POST["email"])) {
    	$emailErr = "這裡必須填入資料";
    } 
    else{
    	$email = test_input($_POST["email"]);
 
    	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    		$emailErr = "輸入正確Email格式"; 
    	}
     	else{
	    	$query = "SELECT * FROM `account` WHERE email = '$email' ";
			$result = mysql_query($query);
			$row = @mysql_num_rows($result);
	    	if (!empty($row))
			{
				$emailErr = "這個Email已經被註冊過";
			}
     	}
    }
   
    if(empty($_POST["pwd"])) {
		$pwdErr = "這裡必須填入資料";
    } 
    else{
    	$pwd = test_input($_POST["pwd"]);
    	if(!preg_match("/^[a-zA-Z0-9_-]{6,20}$/",$pwd)) {
       		$pwdErr = "密碼至少要有6個字元的英文字母或數字"; 
     	}
    }
   
    if(empty($_POST["pwd2"])) {
    	$pwd2Err = "請重新輸入密碼";
    } 
    else{
    	$pwd2 = test_input($_POST["pwd2"]);
    
    	if($pwd2!=$pwd) {
    		$pwd2Err = "請輸入相同的密碼"; 
		}
    }

	if(empty($_POST["gender"])) {
		$genderErr = "這裡必須填入資料";
    } 
    else{
		$gender = $_POST["gender"];
    }
   
    if(empty($_POST["birthday"])) {  
	   $birthdayErr="這裡必須填入資料";
    }
    else{ 
		$date=explode("/", $_POST["birthday"]);
		$birthday = $date[2]."-".$date[0]."-".$date[1];
	}
}

if( $name != null && $nameErr == null && $email != null && $emailErr == null && empty($rows) && $pwd != null && $pwdErr== null && $pwd2 != null && $pwd == $pwd2 && $birthday != null && $gender != null && $genderErr ==null)
{
	$sql = "INSERT INTO `Pickeat`.`account` (`name`, `email`, `password`, `gender`, `birthday`) VALUES ( '$name', '$email', '$pwd', '$gender', '$birthday') ";
		
	if(mysql_query($sql))
	{              
        $url = "login.php";
		echo "<script type='text/javascript'>";
		echo "window.location.href='$url'";
		echo "</script>";       
    }
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

?>

<div class="container">

<form class="form-signup" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
	<h1 class="form-signup-heading">註冊</h1>
	
    <?php
	   	if($nameErr==null){
			echo "<label for=\"inputName\" class=\"sr-only\">Name</label>
			<input type=\"text\" name=\"name\" class=\"form-control\" placeholder=\"名稱\" maxlength=\"20\" required autofocus>";
		}
		else if($nameErr=="輸入英文字母或空白"){
			echo "<div class=\"control-group warning\">
  			<div class=\"controls\">
    		<input type=\"text\" name=\"name\" class=\"form-control\" placeholder=\"名稱\" maxlength=\"20\" required autofocus>
    		<span class=\"help-inline\">$nameErr</span>
  			</div>
			</div>";
		}
		else{
			echo "<div class=\"control-group error\">
  			<div class=\"controls\">
    		<input type=\"text\" name=\"name\" class=\"form-control\" placeholder=\"名稱\" maxlength=\"20\" required autofocus>
    		<span class=\"help-inline\">$nameErr</span>
  			</div>
			</div>";
		}
		 
		 
		if($emailErr==null){
			echo "<label for=\"inputEmail\" class=\"sr-only\">Email address</label>
			<br>
			<input type=\"email\" name=\"email\" class=\"form-control\" placeholder=\"電子郵件\" maxlength=\"30\" required autofocus>";
			 
		}
		else if($emailErr == "輸入正確Email格式"){
			echo "<br>
			<div class=\"control-group warning\">
  			<div class=\"controls\">
    		<input type=\"email\" name=\"email\" class=\"form-control\" placeholder=\"電子郵件\" maxlength=\"30\" required autofocus>
    		<span class=\"help-inline\">$emailErr</span>
  			</div>
			</div>";
		}
		else if($emailErr=="這個Email已經被註冊過"){
			echo "<br>
			<div class=\"control-group info\">
  			<div class=\"controls\">
    		<input type=\"email\" name=\"email\" class=\"form-control\" placeholder=\"電子郵件\" maxlength=\"30\" required autofocus>
    		<span class=\"help-inline\">$emailErr</span>
  			</div>
			</div>";
		}
		else{
			echo "<br><div class=\"control-group error\">
  			<div class=\"controls\">
    		<input type=\"email\" name=\"email\" class=\"form-control\" placeholder=\"電子郵件\" maxlength=\"30\" required autofocus>
    		<span class=\"help-inline\">$emailErr</span>
  			</div>
			</div>"; 
		}
		 
		 
		if($pwdErr==null){
			echo "<label for=\"inputPassword\" class=\"sr-only\">Password</label>
			<br>
			<input type=\"password\" name=\"pwd\" class=\"form-control\" placeholder=\"密碼\" maxlength=\"20\" required>";	 
		}
		else if($pwdErr=="密碼至少要有6個字元的英文字母或數字"){
			echo "<br><div class=\"control-group error\">
  			<div class=\"controls\">
    		<input type=\"password\" name=\"pwd\" class=\"form-control\" placeholder=\"密碼\" maxlength=\"20\" required autofocus>
    		<span class=\"help-inline\">$pwdErr</span>
  			</div>
			</div>";	 
		}
		else{
			echo "<br><div class=\"control-group error\">
  			<div class=\"controls\">
    		<input type=\"password\" name=\"pwd\" class=\"form-control\" placeholder=\"密碼\" maxlength=\"20\" required autofocus>
    		<span class=\"help-inline\">$pwdErr</span>
  			</div>
			</div>";	 
		}
		 
		 
		if($pwd2Err==null){
		 	echo "<label for=\"retypePassword\" class=\"sr-only\">Re-Password</label>
		 	<br>
			<input type=\"password\" name=\"pwd2\" class=\"form-control\" placeholder=\"重新輸入密碼\" maxlength=\"20\" required>";
		}
		else if($pwd2Err=="請輸入相同的密碼"){
			echo "<br>
			<div class=\"control-group error\">
  			<div class=\"controls\">
    		<input type=\"password\" name=\"pwd2\" class=\"form-control\" placeholder=\"重新輸入密碼\" maxlength=\"20\" required autofocus>
    		<span class=\"help-inline\">$pwd2Err</span>
  			</div>
			</div>"; 
		 }
		else{
			echo "<br>
			<div class=\"control-group error\">
  			<div class=\"controls\">
    		<input type=\"password\" name=\"pwd2\" class=\"form-control\" placeholder=\"重新輸入密碼\" maxlength=\"20\" required autofocus>
    		<span class=\"help-inline\">$pwd2Err</span>
  			</div>
			</div>"; 
		}
		
		
		if($genderErr==null){
		 	echo "<br>
		 	<select name=\"gender\" class=\"selectpicker form-control\" data-hide-disabled=\"true\">
		 		<option disabled selected=\"selected\">性別</option>
				<option value=\"female\"><i class=\"fa fa-venus\"></i>&nbsp;女性</option>
				<option value=\"male\"><i class=\"fa fa-mars\"></i>&nbsp;男性</option>
			</select>   ";

		}
		else{
		 	echo "<br>
  			<div class=\"control-group error\">
  			<select name=\"gender\" class=\"selectpicker form-control\" data-hide-disabled=\"true\" autofocus>
		 		<option disabled selected=\"selected\">性別</option>
				<option value=\"female\"><i class=\"fa fa-venus\"></i>&nbsp;女性</option>
				<option value=\"male\"><i class=\"fa fa-mars\"></i>&nbsp;男性</option>
			</select> 
        	<span class=\"help-inline\">$genderErr</span>
  			<div>"; 	 
		}

		if($birthdayErr==null){
	     	echo "<br>
	     	<div class=\"input-group date \">
            <input type=\"text\" id=\"date\" name=\"birthday\" class=\"form-control\" placeholder=\"生日\">
            <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span>
      		</div>";
		}
		else{
			echo "<br>
	     	<div class=\"input-group date control-group error\">
            <input type=\"text\" id=\"date\" name=\"birthday\" class=\"form-control\" placeholder=\"生日\" autofocus>
            <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span>
      		</div>
      		<div class=\"control-group error\">
      		<span class=\"help-inline\">$birthdayErr</span>
      		</div>";
		}
		 
	?>
	<br>
	<button class="btn btn-large btn-warning btn-block" type="submit">註冊</button>
	<a href="login.php" class="btn btn-large btn-default btn-block">返回</a>

</form>



</div>
<div class="container">
	<div class="navbar navbar-static-bottom">
		<div class="container">
		<p class="navbar-text text-default ">Copyright &copy; 2084 WAYNE WEI </p>
		</div>
	</div>

</div>

<script type="text/javascript">
    $('.input-group.date').datepicker({
        weekStart: 0,
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true,
        orientation: "top auto"
    });

	snowStorm.snowColor = '#fff'; // blue-ish snow!?
	snowStorm.flakesMaxActive = 60;  // show more snow on screen at once
	snowStorm.useTwinkleEffect = true; // let the snow flicker in and out of view
</script>

</body>
</html>