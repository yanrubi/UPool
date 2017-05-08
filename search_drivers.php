<?php
	declare(strict_types=1);
	include 'database.php';
	
	$userid = $_SESSION["userid"];
	$page = "";
	$page .= <<<PAGE
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>UPool</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="search.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="search_drivers.js"></script>
	</head>
	<body>
PAGE;
if (isset($_POST["submit"])) {
				$page .= <<<EOBODY
				<div id="note">
					Succesfully Submitted <a id="close">[close]</a>
				</div>
EOBODY;
			}
$page .= <<<PAGE
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
						<li class="active"><a href="search_drivers.php">Drivers</a></li>
					</ul>
					
					<div class="dropdown navbar-right">
						<button class="dropbtn">Profile &#9660;</button>
						<div class="dropdown-content">
						  <a href="profile.php">My UPOOL</a>
						  <a href="#">Settings</a>
						  <a href="logout.php">Log out</a>
						</div>
					</div>
				</div>
			</div>
		</nav>
		
			<div class="sidebar">
				<br />
				<form action="{$_SERVER['PHP_SELF']}" method="post">
					&nbsp;&nbsp;<input type="search" id="start" name="start" placeholder="Choose starting location...">
					<div class="error" id="starterror">&nbsp;</div>
					&nbsp;&nbsp;<input type="search" id="destination" name="destination" placeholder="Choose destination...">
					<div class="error" id="destinationerror">&nbsp;</div>
					&nbsp;&nbsp;Date:&nbsp;<input type="date" id="date" name="date" min="2017-5-1">&nbsp;&nbsp;
					&nbsp;&nbsp;<input type="checkbox" id="repeat" name="repeat" value="repeat">&nbsp;&nbsp;Repeat Weekly?
					<div class="error" id="dateerror">&nbsp;</div>
					&nbsp;&nbsp;Start Time:&nbsp;<input type="time" id="starttime" name="starttime" step="300">
					&nbsp;&nbsp;Arrival Time:&nbsp;<input type="time" id="arrivaltime" name="arrivaltime" step="300"><br />
					<div class="error" id="timeerror">&nbsp;</div>
					&nbsp;&nbsp;&nbsp;&nbsp;# of seats&nbsp;<input type="number" name="seats" id="seats" min="1" max="6">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
					<input name="submit" type="submit" onclick="return processData();" value="Make Carpool"/><br />
					<div class="error" id="seatserror">&nbsp;</div>
				</form>
PAGE;
$page .= '<div class="container"><h3><strong>Carpools</strong></h3><hr/><ul id="list" style="padding: 0; list-style: none;">';
$carpools = getAllCarpoolRecordsForUser($userid);
if($carpools) {
	$size = count($carpools);
	if ($size > 7) {
		$size = 7;
	}
	for($i = 0 ; $i < $size ; $i++) {
		$line = "";
		$carpool = $carpools[$i];
		$from = $carpool['start'];
		$to = $carpool['destination'];
		$fromtime = $carpool['starttime'];
		$totime = $carpool['arrivaltime'];
		$day = $carpool['date'];
		$line .= "<div id='carpool'>";
		$line .= "<b>From:</b> ".$from;
		$line .= "<br /><b>To:</b> ".$to;
		$line .= "<br /><b>On:</b> ".$day."&emsp;&emsp;&emsp;&emsp;";
		$line .= "<div>";
		$page .= $line;
	}
}
	
$page .= <<<PAGE
			</div>
	
			<div class="body">
				<div id="map"></div>
			</div>
		
		<script async defer
				src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGf2V7XQSqJgEyp4oinoyA3dCyzb-CHn4&callback=initMap">
		</script>
		<script>
			close = document.getElementById("close");
			close.addEventListener('click', function() {
				note = document.getElementById("note");
				note.style.display = 'none';
			}, false);
		</script>
	</body>
</html>
PAGE;
	
	echo $page;
?>