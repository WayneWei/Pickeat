<?php session_start(); ?>
<!DOCTYPE HTML> 
<html>
<head> 
<title>Pickeat</title>	
	<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf8">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/store.css">
	<link rel="stylesheet" href="css/animate.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</head>
<body>
	<?php
	
	include("mysql_config.php");
	
	if($_SESSION['users']['email'] != null){
		$uid = $_SESSION['users']['email'];	
    	$uname = $_SESSION['users']['username'];
		$isClick = false;
		$mydistrict = "";
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			if(isset($_POST["submit"])){
				$isClick = true;
				$mydistrict = $_POST["select"];
				if($mydistrict=="all"){
					$query = " SELECT * FROM `store` ORDER BY RAND() LIMIT 0,1 ";
				}
				else{
					$query = " SELECT * FROM `store` where district='$mydistrict' ORDER BY RAND() LIMIT 0,1 ";
				}
				
				$result = mysql_query($query);
				$row = mysql_fetch_assoc($result);
				$store_name = $row['name'];
				
			}
			mysqli_close($query);
			 mysqli_free_result($result);
			
   		}
   		if( $uid!=null && $store_name != null && $isClick)
		{
				$sql = " INSERT INTO `Pickeat`.`history` (`id`, `store_name`) VALUES ( '$uid', '$store_name') ";
				mysql_query($sql);
				$update_query = " UPDATE `history` SET time=now() WHERE id='$uid' AND store_name ='$store_name' " ;
				mysql_query($update_query);
		}

    	
    }
    else{
    	$url = "index.php";
		echo "<script type='text/javascript'>";
		echo "window.location.href='$url'";
		echo "</script>";
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

	
<section id="main">
	<div class="container">
	<h1 class=""></h1>
		<form class="form-inline" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
			<div class="input-group col-xs-12 col-md-3">
        		<select name="select" class="selectpicker form-control" data-hide-disabled="true" data-live-search="true">
        			<option value="all" selected="selected">不分區</option>
					<option value="north">北區</option>
					<option value="east">東區</option>
					<option value="middle-west">中西區</option>
					<option value="south">南區</option>
				</select>      
            </div> 
            

            <div class="input-group col-xs-12 col-md-3">
                <button type="submit" id="withdraw" name="submit" class="btn btn-primary btn-block">抽卡</button>
            </div>
            
		</form>
	</div>
</section>

		<?php 

			if($isClick && !empty($mydistrict)){
				
				echo "	

				  	<div class=\"modal fade\" id=\"myModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
				    	<div class=\"modal-dialog\">
				      		<div class=\"modal-content\">
				        		<div class=\"modal-header\">
				          			<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
				          			<h4 class=\"modal-title\">$row[name]</h4>
				        		</div>
				        		<div class=\"modal-body\">
				        		<img src=\"$row[imgUrl]\">
				        		<table class=\"table table-striped table-hover\">
										<tr>
										  <td>地址</td>
										  <td>$row[address]</td>
										</tr>
										<tr>
										  <td>電話</td>
										  <td>$row[phone_number]</td>
										</tr>
										<tr>
										  <td>營業時間</td>
										  <td>";

										$tok = strtok($row['opening_hours'], " \n\t");

										while ($tok !== false) {
										    echo "$tok<br>";
										    $tok = strtok(" \n\t");
										}

										echo "</td>
										</tr>
										<tr>
										  <td>公休日</td>
										  <td>$row[day_off]</td>
										</tr>
									</table>
								<iframe
    							src=\"https://www.google.com/maps/embed/v1/place?key=AIzaSyAhoj8ouFcD-1VENxNV1gYjjX_iKJdrHDs
      							&q=$store_name\">
  								</iframe>
  								</div>
				      		</div>
				    	</div>
				  	</div>";
				  	$isClick = false;

				  	
				echo "

				<div class=\"col-xs-12 col-md-6 col-md-offset-4\">
				<div id=\"card\" class=\"flip-container animated fadeInUp\">
			    <div class=\"flip-cards\">
			        <div class=\"front-card\">
			        	<img src=\"$row[imgUrl]\">
			        </div>
			        <div class=\"reverse-card\">
			        	<a href=\"#\" class=\"pull-right favorite\"><span class=\"glyphicon glyphicon-star-empty\"></span></a>
			       		<h3>$row[name]</h3>

				        	<p>$row[info]</p>		
									
			       		<button class=\"btn btn-info\" data-toggle=\"modal\" data-target=\"#myModal\">
			       			<i class=\"fa fa-info\"></i>&nbsp;&nbsp;更多資訊
			       		</button>
			   		</div>
			    </div>
			    </div>";
			}
			else if($isClick && empty($mydistrict)){
				echo "<div class=\"alert alert-warning col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3\">
        			<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        			<strong>提示：</strong> 尚未選取地區
    			</div>";
			}	

			

		?>
<script type="text/javascript">
function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); };

$(document).ready(function(){
     $(document).on("keydown", disableF5);
});
</script>

</body>	
</html>	