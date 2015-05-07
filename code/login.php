<!DOCTYPE html>
<?php session_start();?>
<html>
	<head>
		<meta charset="utf-8">
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<link href="css/bootstrap.css" rel="stylesheet"></style>
		<script src="js/login.js"></script>
		<style type="text/css">
			body{
			    background: url(img/back.png);
				background-color: #444;
			    background: url(img/pinlayer2.png),url(img/pinlayer1.png),url(img/back.png);    
			}
			.vertical-offset-100{
			    padding-top:100px;
			}
		</style>
		<script src="js/TweenLite.min.js"></script>
		<link href="css/navbar-fixed-top.css" rel="stylesheet">
	</head>
	<body>
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" style="color:#DD686C;">Carpe Diem</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Login</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
		<div class="container">

		    <div class="row vertical-offset-100">
		    	<div class="col-md-4 col-md-offset-4">
		    		<div class="panel panel-default">
					  	<div class="panel-heading">
					    	<h3 class="panel-title">Please sign in</h3>
					 	</div>
					  	<div class="panel-body">
					    	<form accept-charset="UTF-8" role="form" action="log.php" method="POST">
		                    <fieldset>
					    	  	<div class="form-group">
					    		    <input class="form-control" placeholder="Username" name="user" type="text">
					    		</div>
					    		<div class="form-group">
					    			<input class="form-control" placeholder="Password" name="password" type="password" value="">
					    		</div>
					    		<input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
					    	</fieldset>
					      	</form>
					      	<?php if(isset($_GET['err'])){?>
					      		<br><div class="alert alert-danger">Oops! Invalid Unsername/Password!</div>
					      	<?php }

					      	if(isset($_SESSION['id'])){
					      		header('location:index.php');
					      	}

					      	?>
					      	
					    </div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>