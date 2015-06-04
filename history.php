<?php session_start(); ?>
<!DOCTYPE HTML> 
<html>
<head>
<title>Pickeat</title>	
	<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf8">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/history.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</head>
<body> 
<?php

	include("mysql_config.php");
	
	
	$count = 0;

	if($_SESSION['users']['email'] != null)
	{
		$uid = $_SESSION['users']['email'];	
		$uname = $_SESSION['users']['username'];
		$query = "SELECT * FROM `history` where id='$uid'";
		$result = mysql_query($query);
		
	}
	else{
		header("Location: index.php"); 
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
<div class="container-fluid">
	
	<h1 class="title">歷史紀錄</h1>
	 
	 <div class="col-xs-12 col-md-8 col-md-offset-2">
	<table class="table table-hover">
	<thead>
	<tr class="active">
        <th>#</th>
        <th>店家</th>
        <th>時間</th>
    </tr>
	</thead>
	<tbody>
		<?php 
			while ($row = mysql_fetch_assoc($result)) {

					$sql = "SELECT * FROM `store` where name='$row[store_name]'";
					$res = mysql_query($sql);
					$tmp = mysql_fetch_assoc($res);
					$store[$count]['name']=$tmp['name'];	
					$store[$count]['imgUrl']=$tmp['imgUrl'];	
					$store[$count]['address']=$tmp['address'];	
					$store[$count]['phone_number']=$tmp['phone_number'];	
					$store[$count]['opening_hours']=$tmp['opening_hours'];
					$store[$count]['day_off']=$tmp['day_off'];
					$store[$count]['info']=$tmp['info'];		
				if($count%2==0){
					echo"<tr class=\"warning\">
	                <td>$count</td>
	                <td><a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal$count\">$row[store_name]</a></td>
	                <td>$row[time]</td>
					</tr>
					";

					
				}
				else{
					echo"<tr class=\"info\">
	                <td>$count</td>
	                <td><a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal$count\">$row[store_name]</a></td>
	                <td>$row[time]</td>
	                </tr>";
				}
				$count++;

			}

		?>
    </tbody>

	</table>
	</div>
</div>
</section>

<?php

for($i=0;$i<$count;$i++){
	$store_name=$store[$i]['name'];
echo "	
		
		  	<div class=\"modal fade\" id=\"myModal$i\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
		    	<div class=\"modal-dialog\">
		      		<div class=\"modal-content\">
		        		<div class=\"modal-header\">
		          			<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
		          			<h4 class=\"modal-title\">".$store[$i]['name']."</h4>
		        		</div>
		        		<div class=\"modal-body\">
			        		<img src=\"".$store[$i]['imgUrl']."\">
			        		<table class=\"table table-striped table-hover\">
									<tr>
									  <td colspan=\"2\">".$store[$i]['info']."</td>
									</tr>
									<tr>
									  <td>地址</td>
									  <td>".$store[$i]['address']."</td>
									</tr>
									<tr>
									  <td>電話</td>
									  <td>".$store[$i]['phone_number']."</td>
									</tr>
									<tr>
									  <td>營業時間</td>
									  <td>";

									$tok = strtok($store[$i]['opening_hours'], " \n\t");

									while ($tok !== false) {
									    echo "$tok<br>";
									    $tok = strtok(" \n\t");
									}

									echo "</td>
									</tr>
									<tr>
									  <td>公休日</td>
									  <td>".$store[$i]['day_off']."</td>
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
}


?>




</body>
</html>