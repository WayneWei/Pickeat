<?php session_start(); ?>
<!DOCTYPE HTML> 
<html>
<head>
<title>Update</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf8">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
	<link href="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link href="css/update.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
</head>
<body> 
<?php

	include("mysql_config.php");

	if($_SESSION['users']['email'] != null)
	{
		$email = $_SESSION['users']['email'];
		$uname = $_SESSION['users']['username'];
		$sql = "SELECT * FROM `account` where email='$email'";
		$result = mysql_query($sql);
		$row = mysql_fetch_row($result);

		$nameErr = $pwdErr = $pwd2Err = $genderErr = $birthdayErr = "";
		$name = $email = $pwd = $pwd2 = $gender = $birthday = "";

		if($_SERVER["REQUEST_METHOD"] == "POST") {
	
			$email = $_POST['email'];
	
			if(empty($_POST["name"])) {
				$nameErr = "這裡必須填入資料";
        	} 
        	else{
				$name = test_input($_POST["name"]);
				if (!preg_match("/^[a-zA-Z ]{3,16}$/",$name)) {
					$nameErr = "輸入3-16個英文字母或空白"; 
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
   				$pwd2Err = "重新輸入密碼";
   			} 
   			else{
   				$pwd2 = test_input($_POST["pwd2"]);
   				if ($pwd2!=$pwd) {
   					$pwd2Err = "請輸入相同的密碼"; 
     			}
   			}

   			if(empty($_POST["gender"])) {
   				$genderErr = "這裡必須填入資料";
   			} 
   			else{
   				$gender = test_input($_POST["gender"]);
   			}
   
   			if(empty($_POST["birthday"])) {  
	   			$birthdayErr="這裡必須填入資料";
    		}
			else{ 
				$date=explode("/", $_POST["birthday"]);
				$birthday = $date[2]."-".$date[0]."-".$date[1];
			}
		}

	if( $name != null && $email != null && $pwd != null && $pwd2 != null && $pwd == $pwd2 && $birthday != null && $gender != null)
	{
		$sql = "UPDATE `Pickeat`.`account` SET `name`='$name', `password`='$pwd', `birthday`='$birthday', `gender`='$gender' WHERE email='$email' ";
			
		if(mysql_query($sql))
		{
			$_SESSION['users']['username']=$name;
        	$url = "update.php";
			echo "<script type='text/javascript'>";
			echo "window.location.href='$url'";
			echo "</script>"; 
    	}
	}
}
else{
	$url = "index.php";
	echo "<script type='text/javascript'>";
	echo "window.location.href='$url'";
	echo "</script>"; 
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}


?>

<div class="navbar-wrapper">
    <nav role="navigation" class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarCollapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>
          <a href="index.php" class="brand"></a>
      </div>
      
      <div id="navbarCollapse" class="collapse navbar-collapse">

      	<ul class="nav navbar-nav navbar-right">
            <li><a href="store.php"><i class="fa fa-inbox"></i>&nbsp;&nbsp;抽卡</a></li>
            <li><a href="store.php"><i class="fa fa-street-view"></i>&nbsp;&nbsp;新增地點</a></li>
            <li><a href="history.php"><i class="fa fa-history"></i>&nbsp;&nbsp;歷史紀錄</a></li>
            <li class="divider"></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user"></i>&nbsp;&nbsp;<?php echo ucwords($uname);?><span class="caret"></span>
                </a>
                <ul role="menu" class="dropdown-menu">
                    <li><a href="update.php"><i class="fa fa-edit"></i>&nbsp;&nbsp;修改資料</a></li>
                    <li class="divider"></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;登出</a></li>
                </ul>   
            </li>
        </ul>
            
      </div>
    </nav>
  </div>


	<div class="container">

	<form class="form-update" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
	<h1 class="form-update-heading">更新資料</h1>
	
<?php
	if($nameErr==null){
		echo "<label for=\"inputName\" class=\"sr-only\">Name</label>
		<input type=\"text\" name=\"name\" class=\"form-control\" placeholder=\"名稱\" value=\"$row[0]\" maxlength=\"20\" required autofocus>";
	}
	else if($nameErr=="Only letters and white space allowed"){
		echo "<br>
		<div class=\"control-group warning\">
  		<div class=\"controls\">
    	<input type=\"text\" name=\"name\" class=\"form-control\" placeholder=\"名稱\" maxlength=\"20\" required autofocus>
    	<span class=\"help-inline\">$nameErr</span>
  		</div>
		</div>";
	}
	else{
		echo "<br>
		<div class=\"control-group error\">
  		<div class=\"controls\">
    	<input type=\"text\" name=\"name\" class=\"form-control\" placeholder=\"名稱\" maxlength=\"20\" required autofocus>
    	<span class=\"help-inline\">$nameErr</span>
  		</div>
		</div>";
	}
		 
	echo"<label for=\"inputEmail\" class=\"sr-only\">Email address</label>
	<br>
	<input type=\"email\" name=\"email\" class=\"form-control\" value=\"$row[1]\" readonly>";
	
	
	if($pwdErr==null){
		echo "<label for=\"inputPassword\" class=\"sr-only\">Password</label>
		<br>
		<input type=\"password\" name=\"pwd\" class=\"form-control\" placeholder=\"密碼\" maxlength=\"20\" required>";	 
	}
	else if($pwdErr=="Only letters and numbers allowed"){
		echo "<br>
		<div class=\"control-group warning\">
  		<div class=\"controls\">
	    <input type=\"password\" name=\"pwd\" class=\"form-control\" placeholder=\"密碼\" maxlength=\"20\" required>
	    <span class=\"help-inline\">$pwdErr</span>
		</div>
		</div>";	 
	}
	else{
		echo "<br><div class=\"control-group error\">
		<div class=\"controls\">
		<input type=\"password\" name=\"pwd\" class=\"form-control\" placeholder=\"密碼\" maxlength=\"20\" required>
		<span class=\"help-inline\">$pwdErr</span>
		</div>
		</div>";	 
	}
		 
		 
	if($pwd2Err==null){
		echo "<label for=\"retypePassword\" class=\"sr-only\">Re-Password</label>
		<br>
		<input type=\"password\" name=\"pwd2\" class=\"form-control\" placeholder=\"重新輸入密碼\" maxlength=\"20\" required>";
	}
	else if($pwd2Err=="Please enter same password"){
		echo "<br><div class=\"control-group warning\">
  		<div class=\"controls\">
    	<input type=\"password\" name=\"pwd2\" class=\"form-control\" placeholder=\"重新輸入密碼\" maxlength=\"20\" required>
    	<span class=\"help-inline\">$pwd2Err</span>
  		</div>
		</div>";	 
	}
	else if($pwd2Err=="Please enter same password"){
		echo "<br>
		<div class=\"control-group error\">
  		<div class=\"controls\">
    	<input type=\"password\" name=\"pwd2\" class=\"form-control\" placeholder=\"重新輸入密碼\" maxlength=\"20\" required>
    	<span class=\"help-inline\">$pwd2Err</span>
  		</div>
		</div>"; 
	}
	else{
		echo "<br>
		<div class=\"control-group error\">
		<div class=\"controls\">
		<input type=\"password\" name=\"pwd2\" class=\"form-control\" placeholder=\"重新輸入密碼\" maxlength=\"20\" required>
		<span class=\"help-inline\">$pwd2Err</span>
  		</div>
		</div>"; 
	}
		
	if($row[3]=="female"){
	    echo "<br>
		 	<select name=\"gender\" class=\"selectpicker form-control\" data-hide-disabled=\"true\">
					<option value=\"female\" selected>&nbsp;女性</option>
					<option value=\"male\">&nbsp;男性</option>
				</select>   ";
    }
    else{
        echo "<br>
		 	<select name=\"gender\" class=\"selectpicker form-control\" data-hide-disabled=\"true\">
					<option value=\"female\">&nbsp;女性</option>
					<option value=\"male\" selected>&nbsp;男性</option>
				</select>   ";
    }

	if($birthdayErr==null){
		$tmp=explode("-", $row[4]);
		$bd = $tmp[1]."/".$tmp[2]."/".$tmp[0];
	    echo "<br>
	    <div class=\"input-group date\">
        <input type=\"text\" id=\"date\" name=\"birthday\" class=\"form-control\" placeholder=\"生日\" value=\"$bd\">
        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span>
      	</div>";
	}
	else{
		echo "<br>
	    <div class=\"input-group date control-group error\">
        <input type=\"text\" id=\"date\" name=\"birthday\" class=\"form-control\" placeholder=\"生日\">
        <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span>
      	</div>
      	<div class=\"control-group error\">
      	<span class=\"help-inline\">$birthdayErr</span>
      	</div>";
	}
	 
?>
	
	<br><br>	
	<button class="btn btn-large btn-warning btn-block" type="submit">更新</button>

</form>
</div>

<div class="navbar navbar-static-bottom">
	<div class="container">
		<p class="navbar-text text-default">Copyright &copy; 2084 WAYNE WEI </p>
	</div>
</div>

<script type="text/javascript">
    $('.input-group.date').datepicker({
        weekStart: 0,
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