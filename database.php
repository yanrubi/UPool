<?php
    session_start();
    function connectToDB() {
	    $host = "localhost";
	    $user = "upooluser";
	    $password = "pass";
	    $database = "upooldb";
	    $db = mysqli_connect($host, $user, $password, $database);
	    if (mysqli_connect_errno()) {
		    echo "Connect failed.\n".mysqli_connect_error();
		    exit();
	    }
	    return $db;
    }
	function emailAlreadyInUse($email) {
		$db = connectToDB();
		$query = sprintf("select * from %s where email='%s'", "usertable", $email);
		$selectResult = mysqli_query($db, $query);
		if ($selectResult) {
			$bool = mysqli_num_rows($selectResult) != 0;
			mysqli_free_result($selectResult);
			mysqli_close($db);
			return $bool;
		}
		mysqli_free_result($selectResult);
		mysqli_close($db);
		return false;
	}
	
	function registerNewAccount($email, $password, $firstname, $lastname) {
		if (emailAlreadyInUse($email)) {
            header('Location: main.html');
		}
		else {
			$db = connectToDB();
			$query = sprintf("insert into %s (email, password, firstname, lastname) values ('%s', '%s', '%s', '%s')",
							"usertable", $email, $password, $firstname, $lastname);
			$insertResult = mysqli_query($db, $query);
			if ($insertResult) {
				login($email, $password);
				return true;
			}
		}
		return false;
	}
	
	function login($email, $password) {
		$db = connectToDB();
		$query = sprintf("select * from %s where email='%s'", "usertable", $email);
		$selectResult = mysqli_query($db, $query);
		if ($selectResult) {
			if (mysqli_num_rows($selectResult) != 0) {
				$record = mysqli_fetch_array($selectResult, MYSQLI_ASSOC);
				if ($record['password'] == $password) {
					session_start();
					$_SESSION["userid"] = $record['userid'];
					mysqli_free_result($selectResult);
					mysqli_close($db);
					return true;
				}
			}
		}
		mysqli_free_result($selectResult);
		mysqli_close($db);
		return false;
	}
	
	function createCarpool($userid, $start, $destination, $date, $starttime, $arrivaltime, $repeatweekly, $seats) {
		$db = connectToDB();
		$query = sprintf("insert into %s (userid, start, destination, date, starttime, arrivaltime, repeatweekly, seats) values ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
						"carpooltable", $userid, $start, $destination, $date, $starttime, $arrivaltime, $repeatweekly, $seats);
		$insertResult = mysqli_query($db, $query);
		if ($insertResult) {
			return true;
		}
		return false;
	}
	
	function getAllCarpoolRecordsForUser($userid) {
		$array = array();
		$db = connectToDB();
		$query = sprintf("select * from %s where userid='%s'", "carpooltable", $userid);
		$selectResult = mysqli_query($db, $query);
		if ($selectResult) {
			while ($record = mysqli_fetch_array($selectResult, MYSQLI_ASSOC)) {
				array_push($array, $record);
			}
			return $array;
		}
		mysqli_free_result($selectResult);
		mysqli_close($db);
		return false;
	}
	
	function getACarpoolRecord($carpoolid) {
		$array = array();
		$db = connectToDB();
		$query = sprintf("select * from %s where carpoolid='%s'", "carpooltable", $carpoolid);
		$selectResult = mysqli_query($db, $query);
		if ($selectResult) {
			while ($record = mysqli_fetch_array($selectResult, MYSQLI_ASSOC)) {
				array_push($array, $record);
			}
			return $array;
		}
		mysqli_free_result($selectResult);
		mysqli_close($db);
		return false;
	}
	
	function getAllPassengersForCar($carpoolid){
		$array = array();
		$db = connectToDB();
		$query = sprintf("select * from %s where carpoolid='%s'", "passengertable", $carpoolid);
		$selectResult = mysqli_query($db, $query);
		if ($selectResult) {
			while ($record = mysqli_fetch_array($selectResult, MYSQLI_ASSOC)) {
				array_push($array, $record);
			}
			return $array;
		}
		mysqli_free_result($selectResult);
		mysqli_close($db);
		return false;
	}
	
	function getAllCarpoolRecordsForUserAsPassenger($userid) {
		$array = array();
		$db = connectToDB();
		$query = sprintf("select * from %s where passengeruserid='%s'", "passengertable", $userid);
		$selectResult = mysqli_query($db, $query);
		if ($selectResult) {
			while ($record = mysqli_fetch_array($selectResult, MYSQLI_ASSOC)) {
				$query2 = sprintf("select * from %s where carpoolid='%s'", "carpooltable", $record["carpoolid"]);
				$selectResult2 = mysqli_query($db, $query2);
				while ($record2 = mysqli_fetch_array($selectResult2, MYSQLI_ASSOC)) {
					array_push($array, $record2);
				}
			}
			return $array;
		}
		mysqli_free_result($selectResult);
		mysqli_close($db);
		return false;
	}
	
	function getAllCarpoolRecords() {
		$array = array();
		$db = connectToDB();
		$query = sprintf("select * from %s", "carpooltable");
		$selectResult = mysqli_query($db, $query);
		if ($selectResult) {
			while ($record = mysqli_fetch_array($selectResult, MYSQLI_ASSOC)) {
				array_push($array, $record);
			}
			return $array;
		}
		mysqli_free_result($selectResult);
		mysqli_close($db);
		return false;
	}
	
	function getNumPassengers($carpoolid) {
		$db = connectToDB();
		$query = sprintf("select * from %s where carpoolid='%s'", "passengertable", $carpoolid);
		$selectResult = mysqli_query($db, $query);
		if ($selectResult) {
			$num = mysqli_num_rows($selectResult);
			mysqli_free_result($selectResult);
			mysqli_close($db);
			return $num;
		}
		mysqli_free_result($selectResult);
		mysqli_close($db);
		return false;		
	}
	
	function getNumFreeSeats($carpoolid) {
		$db = connectToDB();
		$query = sprintf("select * from %s where carpoolid='%s'", "carpooltable", $carpoolid);
		$selectResult = mysqli_query($db, $query);
		if ($selectResult) {
			if (mysqli_num_rows($selectResult) != 0) {
				$record = mysqli_fetch_array($selectResult, MYSQLI_ASSOC);
				if ($record['carpoolid'] == $carpoolid) {
					mysqli_free_result($selectResult);
					mysqli_close($db);
					return $record['seats'] - getNumPassengers($carpoolid);
				}
			}
		}
		mysqli_free_result($selectResult);
		mysqli_close($db);
		return false;			
	}
	
	function isPassenger($carpoolid, $passengeruserid) {
		$db = connectToDB();
		$query = sprintf("select * from %s where carpoolid='%s'", "passengertable", $carpoolid);
		$selectResult = mysqli_query($db, $query);
		if ($selectResult) {
			while ($record = mysqli_fetch_array($selectResult, MYSQLI_ASSOC)) {
				if ($record["passengeruserid"] == $passengeruserid)
					return true;
			}
		}
		mysqli_free_result($selectResult);
		mysqli_close($db);
		return false;
	}
	function getEmail($userid){
		$array = array();
		$db = connectToDB();
		$query = sprintf("select %s from %s where userid='%s'", "email", "usertable", $userid);
		$selectResult = mysqli_query($db, $query);
		if ($selectResult) {
			while ($record = mysqli_fetch_array($selectResult, MYSQLI_ASSOC)) {
				array_push($array, $record);
			}
			return $array[0]["email"];
		}
	}
	function getLastName($userid){
		$array = array();
		$db = connectToDB();
		$query = sprintf("select %s from %s where userid='%s'", "lastname", "usertable", $userid);
		$selectResult = mysqli_query($db, $query);
		if ($selectResult) {
			while ($record = mysqli_fetch_array($selectResult, MYSQLI_ASSOC)) {
				array_push($array, $record);
			}
			return $array[0]["lastname"];
		}
	}
	function getFirstName($userid){
		$array = array();
		$db = connectToDB();
		$query = sprintf("select %s from %s where userid='%s'", "firstname", "usertable", $userid);
		$selectResult = mysqli_query($db, $query);
		if ($selectResult) {
			while ($record = mysqli_fetch_array($selectResult, MYSQLI_ASSOC)) {
				array_push($array, $record);
			}
			return $array[0]["firstname"];
		}
	}
	function updatePass($old, $new, $userid){
		$db = connectToDB();
		$query = sprintf("select * from %s where userid='%s'", "usertable", $userid);
		$selectResult = mysqli_query($db, $query);
		if ($selectResult) {
			if (mysqli_num_rows($selectResult) != 0) {
				$record = mysqli_fetch_array($selectResult, MYSQLI_ASSOC);
				if ($record['password'] == $old) {
					$query2 = sprintf("update %s set password='%s' where userid='%s'", "usertable", $new, $userid);
					$updateResult = mysqli_query($db, $query2);
					mysqli_free_result($selectResult);
					mysqli_close($db);
					return true;
				}
			}
		}
		mysqli_free_result($selectResult);
		mysqli_close($db);
		return false;
	}
	function addPassenger($carpoolid, $passengeruserid) {
		if (getNumFreeSeats($carpoolid) <= 0 || isPassenger($carpoolid, $passengeruserid)) {
			return false;
		}
		
		$db = connectToDB();
		$query = sprintf("insert into %s (carpoolid, passengeruserid) values ('%s', '%s')",
						"passengertable", $carpoolid, $passengeruserid);
		$insertResult = mysqli_query($db, $query);
		if ($insertResult) {
			return true;
		}
		return false;
	}
	
    if (isset($_POST["register"]) && isset($_POST["email"]) && isset($_POST["firstname"])
		&& isset($_POST["lastname"]) && isset($_POST["password"]) && isset($_POST["cpassword"])) {
		$email = trim($_POST["email"]);
		$firstname = trim($_POST["firstname"]);
		$lastname = trim($_POST["lastname"]);
		$password = trim($_POST["password"]);
		$cpassword = trim($_POST["cpassword"]);
		
		if ($password != $cpassword) {
			header('Location: main.html');
		}
		else {
			if (registerNewAccount($email, $password, $firstname, $lastname)) {
				header('Location: search_riders.php');
			}
			else {
				header('Location: main.html');
			}
		}
    }
    elseif (isset($_POST["login"]) && isset($_POST["email"]) && isset($_POST["password"])) {
		$email = trim($_POST["email"]);
		$password = trim($_POST["password"]);
		if (login($email, $password)) {
			header('Location: search_riders.php');
		}
		else {
			header('Location: main.html');
		}
    }
	elseif (isset($_POST["start"]) && isset($_POST["destination"]) && isset($_POST["date"])
			&& isset($_POST["starttime"]) && isset($_POST["arrivaltime"]) && isset($_POST["seats"])) {
		$userid = $_SESSION["userid"];
		$start = trim($_POST["start"]);
		$destination = trim($_POST["destination"]);
		$date = trim($_POST["date"]);
		$starttime = trim($_POST["starttime"]);
		$arrivaltime = trim($_POST["arrivaltime"]);
		$seats = trim($_POST["seats"]);
		if (isset($_POST["repeatweekly"]))
			$repeatweekly = true;
		else
			$repeatweekly = false;
			
		createCarpool($userid, $start, $destination, $date, $starttime, $arrivaltime, $repeatweekly, $seats);
	}
	else if (!isset($_SESSION['userid'])){
		header('Location: main.html');
	}
?>
