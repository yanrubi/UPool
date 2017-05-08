<?php
	declare(strict_types=1);
	//require_once("database.php");
	
	$page = <<<PAGE
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
		<script src="search_rider.js"></script>
	</head>
PAGE;

	if (isset($_POST['submit']) && isset($_POST['start']) && isset($_POST['destination']) && isset($_POST['date'])
		&& isset($_POST['starttime']) && isset($_POST['arrivaltime'])) {
		$start = $_POST['start'];
		$destination = $_POST['destination'];
		$date = $_POST['date'];
		$starttime = $_POST['starttime'];
		$arrivaltime = $_POST['arrivaltime'];
		
		$page .=  <<<PAGE
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
						<li class="active"><a href="searchRiders.php">Riders</a></li>
						<li><a href="search.html">Drivers</a></li>
					</ul>
					
					<div class="dropdown navbar-right">
						<button class="dropbtn">Profile &#9660;</button>
						<div class="dropdown-content">
						  <a href="#">My UPOOL</a>
						  <a href="#">Settings</a>
						  <a href="#">Log out</a>
						</div>
					</div>
				</div>
			</div>
		</nav>
		<div class="sidebar">
			<br />
				&nbsp;&nbsp;<input type="search" id="start" name="start" placeholder="Choose starting location..." value="$start">
				<div class="error" id="starterror">&nbsp;</div>
				&nbsp;&nbsp;<input type="search" id="destination" name="destination" placeholder="Choose destination..." value="$destination">
				<div class="error" id="destinationerror">&nbsp;</div>
				&nbsp;&nbsp;Date:&nbsp;<input type="date" id="date" min="2017-5-1" value="$date">&nbsp;&nbsp;
				<div class="error" id="dateerror">&nbsp;</div>
				&nbsp;&nbsp;Start Time:&nbsp;<input type="time" id="starttime" value="$starttime" step="300">
				&nbsp;&nbsp;Arrival Time:&nbsp;<input type="time" id="arrivaltime" value="$arrivaltime" step="300"><br />
				<div class="error" id="timeerror">&nbsp;</div>
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
				<input name="submit" type="submit" onclick="processData();" value="Search Carpools"/>
				
				<div id="carpools" name="carpools">
PAGE;

        $page .= '<div class="container"><br/><h3><strong>Carpools</strong></h3><hr/><ul id="list" style="padding: 0; list-style: none;">';
        
        for ($i = 0; $i < 7; $i++) {
            $page .= "<li id='$i'>";
            $page .= '<strong>From: </strong><span id="start'.$i.'">'.$start.'</span>';
			$page .= '<br/><strong>To: </strong><span id="destination'.$i.'">'.$destination."</span><br/><strong>Seats: </strong>3<br/>";
			$page .= '<input id="join'.$i.'" type="button" value="Join"/>';
            $page .= '<hr/></li>';
        }

		$page .= <<<PAGE1
				</ul></div>
			</div>
		</div>

		<div class="body">
			<div id="map"></div>
		</div>
		
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGf2V7XQSqJgEyp4oinoyA3dCyzb-CHn4&callback=initMap"></script>
	</body>
</html>
PAGE1;
	} else {
		$page .= <<<PAGE
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
						<li class="active"><a href="searchRiders.php">Riders</a></li>
						<li><a href="search.html">Drivers</a></li>
					</ul>
					
					<div class="dropdown navbar-right">
						<button class="dropbtn">Profile &#9660;</button>
						<div class="dropdown-content">
						  <a href="#">My UPOOL</a>
						  <a href="#">Settings</a>
						  <a href="#">Log out</a>
						</div>
					</div>
				</div>
			</div>
		</nav>
		<div class="sidebar">
			<br />
			<form action="{$_SERVER["PHP_SELF"]}" method="post">
				&nbsp;&nbsp;<input type="search" id="start" name="start" placeholder="Choose starting location...">
				<div class="error" id="starterror">&nbsp;</div>
				&nbsp;&nbsp;<input type="search" id="destination" name="destination" placeholder="Choose destination...">
				<div class="error" id="destinationerror">&nbsp;</div>
				&nbsp;&nbsp;Date:&nbsp;<input type="date" id="date" name="date" min="2017-5-1">&nbsp;&nbsp;
				<div class="error" id="dateerror">&nbsp;</div>
				&nbsp;&nbsp;Start Time:&nbsp;<input type="time" id="starttime" name="starttime" step="300">
				&nbsp;&nbsp;Arrival Time:&nbsp;<input type="time" id="arrivaltime" name="arrivaltime" step="300"><br />
				<div class="error" id="timeerror">&nbsp;</div>
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
				<input name="submit" type="submit" onclick="processData();" value="Search Carpools"/>
			</form>
		</div>

		<div class="body">
			<div id="map"></div>
		</div>
		
		<script async defer
				src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGf2V7XQSqJgEyp4oinoyA3dCyzb-CHn4&callback=initMap">
		</script>
	</body>
</html>
PAGE;
	}
	
	echo $page;
?>
