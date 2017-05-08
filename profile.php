<?php
	//$_SESSION["userid"] = "1";
	require_once("database.php");
	
	?>
<html lang="en">
	<head>
		
		<title>UPool</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="search.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<style>
			.navbar{
				z-index: 2;
			}
			.sidenav {
				height: 100%;
				width: 20%;
				position: fixed;
				z-index: 1;
				top: 0px;
				left: 0;
				background-color: #222;
				
				transition: 0.5s;
				padding-top: 60px;
			}
			.penal{
				z-index: 2;
				width: 20%;
				position: fixed;
				top: 40%;
			}
			.sidenav a {
				padding: 20px 0px 8px 0px;
				text-decoration: none;
				font-size: 25px;
				color: #818181;
				display: block;
				text-align:center;
				transition: 0.3s;
			}
			.sidenav a:hover, .offcanvas a:focus{
			color: #f1f1f1;
			}
			.profilecon{
				height: 100%;
				width: 60%;
				position: relative;
				left:30%;
				z-index: 1;
				top: 20px;
				align:center;
			}
			.profilecon h1{
				text-align:center;
			}
			.profilecon h2{
				
			}
			.profilecon p{
				padding: 20px 20px 20px 20px;
			}
			.profilecon input[type=password]{
				position: relative;
				left: 20px;
				padding: 12px 0px;
				margin: 8px 0;
				width: 90%;
			}
			.profilecon input[type=button], input[type=submit], input[type=reset] {
				background-color: #222;
				border: none;
				width: 100%;
				color: white;
				padding: 16px 32px;
				text-decoration: none;
				margin: 4px 2px;
				cursor: pointer;
				position: relative;
				top:20px;
}

		</style>
	</head>
	<body>
  
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					</button>
					<a class="navbar-brand" href="main.html">UPool</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li><a href="search_riders.php">Riders</a></li>
						<li><a href="search_drivers.php">Drivers</a></li>
					</ul>
					
					<div class="dropdown navbar-right">
					<button class="dropbtn">Profile &#9660;</button>
					<div class="dropdown-content">
					  <a href="profile.php">My UPOOL</a>
					  <a href="trips.php">Trips</a>
					  <a href="logout.php">Log out</a>
					</div>
				  </div>
				</div>
			</div>
		</nav>
		
		<div id="mySidenav" class="sidenav">
			<div class="penal">
				<a href="trips.php"> My Trips</a>
				<a href="profile.php"> My Profile</a>
				<a href="logout.php"> Logout</a>
			</div>
		</div>
		
		<div id="profilecon" class="profilecon">
			<h1>PROFILE</h1>
			<?php
				if(isset($_POST["oldPassWord"])&&isset($_POST["newPassWord"])){
					if(updatePass($_POST["oldPassWord"],$_POST["newPassWord"],$_SESSION["userid"])){
						echo("<p>Password updated!</p>");
					}else {
						echo("<p><font color='red'>The information provided was wrong.</font></p>");
					}
				}
			?>
			<h2>General Information</h2>
			<h3>Name</h3>
			<p>
			<?php
				echo(getFirstName($_SESSION["userid"]));
				echo(" ");
				echo(getLastName($_SESSION["userid"]));
			?>
			</p>
			<h3>E-mail</h3>
			<p>
			<?php
				echo(getEmail($_SESSION["userid"]));
				
			?>
			</p>
			<h2>Change Password</h2>
			<form action="profile.php" method="post" id ="form">
				<p>Old Password:</p>
				<input type="password" name="oldPassWord" id = "oldPassWord" required/><br/>
				<p>New Password:</p>
				<input type="password" name="newPassWord" id = "newPassWord" required/><br/>
				<p>Password Confirm:</p>
				<input type="password" name="n2PassWord" id = "n2PassWord" required/><br/>
				<input type="submit" value="Submit">
			</form>
			
		</div>
		
		<script async defer
				src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGf2V7XQSqJgEyp4oinoyA3dCyzb-CHn4&callback=initMap">
			
		</script>
		<script>
			$('#form').submit(function(){
				if(document.getElementById("newPassWord").value===document.getElementById("n2PassWord").value){
					return true;
				}else{
					alert("The Passwords were not identical!");
					return false;
				}
			});
		</script>
	</body>
</html>
