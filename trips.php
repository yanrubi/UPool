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
			.profilecon table{
				border-collapse: collapse;
				width: 100%;
			}
			.profilecon th{
				padding: 8px;
				text-align: left;
				border-bottom: 1px solid #ddd;
			}
			.profilecon td{
				padding: 8px;
				text-align: left;
				
			}
			tr.header
			{
				cursor:pointer;
			}
			.tab {
				overflow: hidden;
				border: 1px solid #ccc;
				background-color: #f1f1f1;
			}
			.tab button {
				background-color: inherit;
				float: left;
				border: none;
				outline: none;
				cursor: pointer;
				width:50%;
				padding: 14px 16px;
				transition: 0.3s;
				font-size: 17px;
			}
			.tab button:hover {
				background-color: #ddd;
			}
			div.tab button.active {
				background-color: #ccc;
			}
			.tabcontent {
				display: none;
				-webkit-animation: fadeEffect 1s;
				animation: fadeEffect 1s;
			}
			@-webkit-keyframes fadeEffect {
				from {opacity: 0;}
				to {opacity: 1;}
			}

			@keyframes fadeEffect {
				from {opacity: 0;}
				to {opacity: 1;}
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
			<h1>MY TRIPS</h1>
			<div class="tab">
				<button class="tablinks" onclick="openTab(event, 'As Driver')" id="defaultOpen">As Driver</button>
				<button class="tablinks" onclick="openTab(event, 'As Rider')">As Rider</button>
			</div>
			<div id="As Driver" class="tabcontent">
				<table>
					<tr>
						<th>Driver</th>
						<th>Date</th>
						<th>Start Time</th>
						<th>Arrival Time</th>
					</tr>
					<?php
						$records = array();
						$records = getAllCarpoolRecordsForUser($_SESSION["userid"]);
						foreach($records as &$record){
							echo("<tr class = 'header'>");
							echo("<th>");
							echo(getFirstName($_SESSION["userid"]));
							echo(" ");
							echo(getLastName($_SESSION["userid"]));
							echo("</th>");
							echo("<th>");
							echo($record["date"]);
							echo("</th>");
							echo("<th>");
							echo($record["starttime"]);
							echo("</th>");
							echo("<th>");
							echo($record["arrivaltime"]);
							echo("</th>");
							echo("<tr>");
							echo("<td>Strat:</td>");
							echo("<td colspan='3'>");
							echo($record["start"]);
							echo("</td>");
							echo("</tr>");
							echo("<tr>");
							echo("<td>Destination:</td>");
							echo("<td colspan='3'>");
							echo($record["destination"]);
							echo("</td>");
							echo("</tr>");
							echo("<tr>");
							echo("<td>Passengers:</td>");
							$passengers = array();
							$passengers = getAllPassengersForCar($record["carpoolid"]);
							foreach($passengers as &$passenger){
								echo("<td>");
								echo(getFirstName($passenger["passengeruserid"]));
								echo(" ");
								echo(getLastName($passenger["passengeruserid"]));
								echo("</td>");
							}
							
							echo("</tr>");
						}
					?>
				</table>
			</div>
			<div id="As Rider" class="tabcontent">
				<table>
					<tr>
						<th>Driver</th>
						<th>Date</th>
						<th>Start Time</th>
						<th>Arrival Time</th>
					</tr>
					<?php
						$records = array();
						$records = getAllCarpoolRecordsForUserAsPassenger($_SESSION["userid"]);
						foreach($records as &$record){
							echo("<tr class = 'header'>");
							echo("<th>");
							echo(getFirstName($record["userid"]));
							echo(" ");
							echo(getLastName($record["userid"]));
							echo("</th>");
							echo("<th>");
							echo($record["date"]);
							echo("</th>");
							echo("<th>");
							echo($record["starttime"]);
							echo("</th>");
							echo("<th>");
							echo($record["arrivaltime"]);
							echo("</th>");
							echo("<tr>");
							echo("<td>Strat:</td>");
							echo("<td colspan='3'>");
							echo($record["start"]);
							echo("</td>");
							echo("</tr>");
							echo("<tr>");
							echo("<td>Destination:</td>");
							echo("<td colspan='3'>");
							echo($record["destination"]);
							echo("</td>");
							echo("</tr>");
						}
					?>
				</table>
			</div>
		</div>
		
		<script async defer
				src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGf2V7XQSqJgEyp4oinoyA3dCyzb-CHn4&callback=initMap">
			
		</script>
		<script>
			$('.header').click(function(){
			$(this).toggleClass('expand').nextUntil('tr.header').slideToggle(100);
			});
			document.getElementById("defaultOpen").click();
			function openTab(evt, tabName) {
				var i, tabcontent, tablinks;
				tabcontent = document.getElementsByClassName("tabcontent");
				for (i = 0; i < tabcontent.length; i++) {
					tabcontent[i].style.display = "none";
				}
				tablinks = document.getElementsByClassName("tablinks");
				for (i = 0; i < tablinks.length; i++) {
					tablinks[i].className = tablinks[i].className.replace(" active", "");
				}
				document.getElementById(tabName).style.display = "block";
				evt.currentTarget.className += " active";
			}
		</script>
	</body>
</html>