<?php session_start(); ?>
<!DOCTYPE HTML> 
<html>
<head> 
<title>Pickeat</title>	
	<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf8">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link href="css/style.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
 
</head>
<body>
	
<?php	
	include("mysql_config.php");
	
	if($_SESSION['users']['email'] != null){
		$uid = $_SESSION['users']['email'];	
		$uname = $_SESSION['users']['username'];
		$query = "SELECT * FROM `account` where email='$uid'";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);		
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
          <a href="#" class="brand"></a>
      </div>
      
      <div id="navbarCollapse" class="collapse navbar-collapse">

      <?php 
          if($row[0]!=null){
            echo " <ul class=\"nav navbar-nav navbar-right\">
                <li><a href=\"store.php\"><i class=\"fa fa-inbox\"></i>&nbsp;&nbsp;抽卡</a></li>
                <li><a href=\"store.php\"><i class=\"fa fa-street-view\"></i>&nbsp;&nbsp;新增地點</a></li>
                <li><a href=\"history.php\"><i class=\"fa fa-history\"></i>&nbsp;&nbsp;歷史紀錄</a></li>
                <li class=\"divider\"></li>
                <li class=\"dropdown\">
                    <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">
                        <i class=\"fa fa-user\"></i>&nbsp;&nbsp;".ucwords($uname)." "."<span class=\"caret\"></span>
                    </a>
                    <ul role=\"menu\" class=\"dropdown-menu\">
                        <li><a href=\"update.php\"><i class=\"fa fa-edit\"></i>&nbsp;&nbsp;修改資料</a></li>
                        <li class=\"divider\"></li>
                        <li><a href=\"logout.php\"><i class=\"fa fa-sign-out\"></i>&nbsp;&nbsp;登出</a></li>
                    </ul>   
                </li>
            </ul>";
          }
          else{
            echo "<ul class=\"nav navbar-nav navbar-right\">
                    <li><a href=\"login.php\"><i class=\"fa fa-sign-in\"></i>&nbsp;&nbsp;登入&nbsp;/&nbsp;註冊</a></li>
                </ul>";
          }
      ?>
            
      </div>
    </nav>
  </div>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
        <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>
 
      <div class="carousel-inner" role="listbox">
        <div class="item active" style="background: url(img/banner/banner_00.jpg) no-repeat center center; background-size: cover;">
          <div class="container">
            <div class="carousel-caption">
              <h1>Welcome to Pickeat</h1>
              <p class="lead">還再煩惱今天要吃什麼嗎？<br>Just Pick & Eat</p>
              <a class="btn btn-lg btn-info" href="store.php">Get Started</a>
            </div>
          </div>
        </div>
        <div class="item" style="background: url(img/banner/banner_01.jpg) no-repeat center center; background-size: cover;">
          <div class="container">
            <div class="carousel-caption">
              <h1>Simple</h1>
              <p class="lead">吃飯不再是傷腦筋<br>一切變得如此方便</p>
              <a class="btn btn-lg btn-info" href="store.php">Learn more</a>
            </div>
          </div>
        </div>
        <div class="item" style="background: url(img/banner/banner_02.jpg) no-repeat center center; background-size: cover;">
          <div class="container">
            <div class="carousel-caption">
              <h1>Surprise</h1>
              <p class="lead">讓每天吃飯都充滿期待驚奇</p>
              <a class="btn btn-lg btn-info" href="store.php">Browse gallery</a>
            </div>
          </div>
        </div>
        <div class="item" style="background: url(img/banner/banner_03.jpg) no-repeat center center; background-size: cover;">
          <div class="container">
            <div class="carousel-caption">
              <h1>One more for good measure.</h1>
              <p class="lead"></p>
              <a class="btn btn-lg btn-info" href="store.php">Browse gallery</a>
            </div>
          </div>
        </div>
      </div>
</div><!-- /.carousel -->


   
	
</body>	
</html>	