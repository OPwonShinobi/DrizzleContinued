<?php session_start();
/* This file is used by many .js files to get/set data from the database. 
Do not call any of the functions here directly, send an ajax call with Querydata set as one of the cases, eg 
    $.ajax({
        type: "POST",
        url: "/querydata.php",
        data: {
            QueryData: 'getAllSchoolsByCity'
        },

*/
require_once('config.php');
if (!isset($_SESSION['Userid']))
	header('Location: /login.php');
 */
if ($_POST) {
	$query = $_POST['QueryData'];

	/* Queries can be perform without login */
	if (!isset($_SESSION['Userid'])
		&& !isset($_SESSION['admin'])) {

		switch($query) {
		case 'getAllSchoolsByCity':
			getAllSchoolsByCity();
			break;
		default:
			echo "unauthorized";
		}
	} else {
		/* Queries must be perform after login */
		switch($query) {
		case 'getAllActions':
			getAllActions();
			break;
		case 'getAllSchoolsByCity':
			getAllSchoolsByCity();
			break;
		case 'myActionsWithUserIndication':
			getMyActionsWithUserIndication();
			break;

		case 'getAllActionsWithUserIndication':
			getAllActionsWithUserIndication();
			break;

		case 'addUserAction':
			addUserAction($_POST['ActionId']);
			break;

		case 'deleteUserAction':
			deleteUserAction($_POST['ActionId']);
			break;

		case 'getTop10WithinSchool':
			getTop10WithinSchool();
			break;

		case 'addSchool':
			addSchool();
			break;

		case 'addRegion':
			addRegion();
			break;

		case 'getUserScore':
			getUserScore();
			break;

		case 'finishAction':
			addComplishment($_POST['ActionId']);
			break;

		case 'getUserSchool':
			getUserSchool();
			break;

		case 'myComplishment':
			myComplishment();
			break;

		case 'getUserRankInSchool':
			getUserRankInSchool();
			break;

		case 'getUserRankInCity':
			getUserRankInCity();
			break;
		case 'getUserCity':
			getUserCity();
			break;
		case 'getSchoolRankInCity':
			getSchoolRankInCity();
			break;
		case 'modifySchool':
			modifySchool();
			break;
		case 'deleteSchool':
			deleteSchool();
			break;
		case 'deleteRegion':
			deleteRegion();
			break;
		case 'addAction':
			addAction();
			break;
		case 'addCategory':
			addCategory();
			break;
		case 'getAllCategory':
			getAllCategory();
			break;
		case 'modifyAction':
			modifyAction();
			break;
		case 'toggleAction':
			toggleAction();
			break;
		case 'getAllStudentScore':
			getAllStudentScore();
			break;
		case 'getUserState':
			getUserState();
			break;
		case 'getAllImages':
			getAllImages();
			break;
		case 'getAllRegion':
			getAllRegion();
			break;
		case 'getUserRankInState':
			getUserRankInState();
			break;
		case 'getUserCountry':
			getUserCountry();
			break;
		case 'getUserRankInCountry':
			getUserRankInCountry();
			break;
		case 'myNotification':
			getMyNotification();
			break;
		case 'deleteMyNotification':
			deleteMyNotification();
			break;
		case 'getSchoolRankInState':
			getSchoolRankInState();
			break;
		case 'getSchoolRankInCountry':
			getSchoolRankInCountry();
			break;
		case 'archiveOldAccomplishment':
			archiveOldAccomplishment();
			break;
		case 'checkMyactionfinish':
			checkMyactionfinish();
			break;
		case 'modifyStudentRecord':
			modifyStudentRecord();
			break;
		case 'deleteStudentRecord':
			deleteStudentRecord();
			break;
		case 'modifyImageRecord':
			modifyImageRecord();
			break;
		case 'deleteImageRecord':
			deleteImageRecord();
			break;
		case 'getAllAdmins':
			getAllAdmins();
			break;
		case 'addAdmin':
			addAdmin();
			break;
		case 'modifyAdmin':
			modifyAdmin();
			break;
		case 'deleteAdmin':
			deleteAdmin();
			break;
		case 'saveUploadedImage':
			saveUploadedImage();
			break;
			/* Add more more query operation by matching the $query string if needed. */
		default:
		}

	}

}
/*
function establishDbConnection() {
	require_once('config.php');
	try {
		$conn = new PDO("mysql:host=$DB_HOST;dbname=$DB_DATABASE", $DB_USER, $DB_PASSWORD);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
		//echo "Connected successfully";
	} catch(PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}
}
 */

function getAllActions(){
	$conn = get_db_connection();
	if ($conn) {
		$stmt = $conn->prepare("SELECT ID, Description, Points, Active, Category FROM Action");
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($result);
	}
}

function getMyActionsWithUserIndication() {
	$conn = get_db_connection();
	if ($conn) {
		// pulls the last completed time of an
		$stmt = $conn->prepare("
			UPDATE UserAction 
			SET CompleteTime = NULL
			WHERE DATEDIFF(CURRENT_TIMESTAMP, CompleteTime) >= 1; 
			");
		$stmt->bindParam(":theUser", $_SESSION['Userid']);
		$stmt->execute();

		$stmt = $conn->prepare("
			SELECT ua.UserID, ua.ActionID, ua.CompleteTime, a.Description, a.Points, a.Category
			FROM UserAction ua
			INNER JOIN Action a On ua.ActionID = a.ID
			WHERE UserID=:theUser AND a.Active=TRUE;
			");
		$stmt->bindParam(":theUser", $_SESSION['Userid']);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($result);
	}
}


function  getAllActionsWithUserIndication() {
	$conn = get_db_connection();
	if ($conn) {
		//like getMyActionsWithUserIndication, refreshes useraction date has passed
		$stmt = $conn->prepare("
			UPDATE UserAction 
			SET CompleteTime = NULL
			WHERE DATEDIFF(CURRENT_TIMESTAMP, CompleteTime) >= 1; 
			");
		$stmt->bindParam(":theUser", $_SESSION['Userid']);
		$stmt->execute();
		// gets all active actions by category, and a completion timestamp if user has already submitted it today  
		$stmt = $conn->prepare("
			SELECT a.ID, a.Description, a.Points, a.Category ,ua.UserID, ac.CategoryDescription, ua.CompleteTime
			FROM Action a 
			LEFT JOIN (
				SELECT * FROM UserAction WHERE UserID=:theUser
			) ua ON a.ID=ua.ActionID
			LEFT JOIN ActionCategory ac on a.Category = ac.CategoryName
			WHERE a.Active=TRUE;
		");
		$stmt->bindParam(":theUser", $_SESSION['Userid']);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($result);
	}
}

function getAllSchoolsByCity() {
	$country = $_POST['Country'];
	$stateProvince = $_POST['StateProvince'];
	$city = $_POST['City'];

	$conn = get_db_connection();
	if ($conn) {
		$stmt = $conn->prepare("SELECT *
			FROM School
			WHERE Country=:theCountry AND StateProvince=:theStateProvince AND City=:theCity");
		$stmt->bindParam(":theCountry", $country);
		$stmt->bindParam(":theStateProvince", $stateProvince);
		$stmt->bindParam(":theCity", $city);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($result);
	}
}

function getAllRegion() {

	$conn = get_db_connection();
	if ($conn) {
		$stmt = $conn->prepare("SELECT *
			FROM RegionLock");
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($result);
	}
}

function addSchool() {
	$country = $_POST['Country'];
	$stateProvince = $_POST['StateProvince'];
	$city = $_POST['City'];
	$schoolName = $_POST['SchoolName'];

	$conn = get_db_connection();
	$stmt = $conn->prepare("INSERT INTO School
		VALUES (NULL, :theSchoolName, :theCountry, :theStateProvince, :theCity)");
	$stmt->bindParam(":theSchoolName", $schoolName);
	$stmt->bindParam(":theCountry", $country);
	$stmt->bindParam(":theStateProvince", $stateProvince);
	$stmt->bindParam(":theCity", $city);
	$stmt->execute();
	getAllSchoolsByCity();
}

function addRegion() {
	$country = $_POST['Country'];
	$stateProvince = $_POST['StateProvince'];

	$conn = get_db_connection();
	$stmt = $conn->prepare("INSERT INTO RegionLock
		VALUES (:theCountryName, :theRegionName)");
	$stmt->bindParam(":theCountryName", $country);
	$stmt->bindParam(":theRegionName", $stateProvince);
	$stmt->execute();
	getAllRegion();
}

function modifySchool() {
	$conn = get_db_connection();
	$stmt = $conn->prepare("
		UPDATE School
		SET SchoolName=:theSchoolName
		WHERE ID=:theSchoolId
	");

	$stmt->bindParam(":theSchoolName", $_POST['SchoolName']);
	$stmt->bindParam(":theSchoolId", $_POST['SchoolId']);
	$result = $stmt->execute();
	if ($result) {
		$response = array("Result"=>"Success");
		echo json_encode($response);
	}
}

function deleteSchool() {
	$conn = get_db_connection();
	$stmt = $conn->prepare("
		DELETE FROM School
		WHERE ID=:theDeleteSchoolId
	");
	$stmt->bindParam(":theDeleteSchoolId", $_POST['SchoolId']);
	$result = $stmt->execute();
	if ($result) {
		$response = array("Result"=>"Success");
		echo json_encode($response);
	}
}

function deleteRegion() {
	$conn = get_db_connection();
	$stmt = $conn->prepare("
		DELETE FROM RegionLock
		WHERE CountryName=:countryName AND RegionName=:regionName
	");
	$stmt->bindParam(":countryName", $_POST['CountryName']);
	$stmt->bindParam(":regionName", $_POST['RegionName']);
	$result = $stmt->execute();
	if ($result) {
		getAllRegion();
	}
}

function ModifyStudentRecord(){
	$conn = get_db_connection();
	$stmt = $conn->prepare("
		UPDATE User
		SET LastName=:theLastName,
		FirstName=:theFirstName,
		NickName=:theNickName,
		Email=:theEmail
		WHERE ID=:theUserID;
	");

	$stmt->bindParam(":theLastName", $_POST['LastName']);
	$stmt->bindParam(":theFirstName", $_POST['FirstName']);
	$stmt->bindParam(":theNickName", $_POST['NickName']);
	$stmt->bindParam(":theEmail", $_POST['Email']);
	$stmt->bindParam(":theUserID", $_POST['UserID']);

	$result = $stmt->execute();
	if ($result) {
		$response = array("Result"=>"Success");
		echo json_encode($response);
	}
}

function deleteStudentRecord()
{
	$conn = get_db_connection();
	$stmt = $conn->prepare("
		DELETE FROM User
		WHERE ID=:selectedUserID;
	");
	$stmt->bindParam(":selectedUserID", $_POST['UserID']);

	$result = $stmt->execute();
	if ($result) {
		$response = array("Result"=>"Success");
		echo json_encode($response);
	}

}

function modifyImageRecord() {
	$conn = get_db_connection();
	$stmt = $conn->prepare("
		UPDATE Images
		SET favflag=:favflagID,
		description=:description
		WHERE id=:imageID
	");

	$stmt->bindParam(":imageID", $_POST['ImageID']);
	$stmt->bindParam(":favflagID", $_POST['FavFlagID']);
	$stmt->bindParam(":description", $_POST['Description']);

	$result = $stmt->execute();
	if ($result) {
		$response = array("Result"=>"Success");
		echo json_encode($response);
	}
}

function deleteImageRecord() {
	$conn = get_db_connection();
	$stmt = $conn->prepare("
		DELETE FROM Images
		WHERE id=:imageID
	");

	$stmt->bindParam(":imageID", $_POST['ImageID']);

	$result = $stmt->execute();
	if ($result) {
		$response = array("Result"=>"Success");
		echo json_encode($response);
	}
}

function addAction() {
	$conn = get_db_connection();
	$stmt = $conn->prepare("INSERT INTO Action VALUES(NULL, :actionDescription, :points, TRUE)");
	$stmt->bindParam(":actionDescription", $_POST['Description']);
	$stmt->bindParam(":points", $_POST['Points']);
	$result = $stmt->execute();
	if ($result) {
		getAllActions();
	}
}

function addCategory() {
	$conn = get_db_connection();
	$stmt = $conn->prepare("INSERT INTO ActionCategory VALUES(:categoryName, :categoryDescription)");
	$stmt->bindParam(":categoryName", $_POST['Name']);
	$stmt->bindParam(":categoryDescription", $_POST['Description']);
	$result = $stmt->execute();
	if ($result) {
		getAllActions();
	}
}

function getAllCategory() {
	$conn = get_db_connection();
	$stmt = $conn->prepare("SELECT categoryName FROM ActionCategory");
	$result = $stmt->execute();
	if ($result) {
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($result);
	}
}

function modifyAction() {
	$conn = get_db_connection();
	$stmt = $conn->prepare("
		UPDATE Action
		SET Description=:actionDescription, Points=:points, Category=:category
		WHERE ID=:theActionId
	");

	$stmt->bindParam(":actionDescription", $_POST['Description']);
	$stmt->bindParam(":points", $_POST['Points']);
	$stmt->bindParam(":theActionId", $_POST['ActionId']);
	$stmt->bindParam(":category", $_POST['Category']);

	$result = $stmt->execute();
	if ($result) {
		$response = array("Result"=>"Success");
		echo json_encode($response);
	}
}

function toggleAction() {
	$conn = get_db_connection();
	try {
		$conn->beginTransaction();
		$stmt = $conn->prepare("
			UPDATE Action
			SET Active=NOT Active
			WHERE ID=:theToggleActionId
		");
		$stmt->bindParam(":theToggleActionId", $_POST['ActionId']);
		$result = $stmt->execute();

		if (!$result)
			return;

		$stmt = $conn->prepare("
			DELETE FROM UserAction
			WHERE ActionId IN (
			    SELECT ID FROM Action
			    WHERE Active = FALSE)
		");

		$result = $stmt->execute();
		$conn->commit();
		$response = array("Result"=>"Success");
		echo json_encode($response);
	} catch(Exception $e){
		$conn->rollBack();
		echo "Failed:" . $e->getMessage();
	}
}

function addUserAction($actionId) {
	$conn = get_db_connection();
	$stmt = $conn->prepare("INSERT INTO UserAction VALUES (:theUserId, :theActionId, NULL)");
	$stmt->bindParam("theUserId", $_SESSION['Userid']);
	$stmt->bindParam("theActionId", $actionId);
	$result = $stmt->execute();
	if ($result) {
		$response = array("Result"=>"Success");
		echo json_encode($response);
	}
}

function addComplishment($actionId) {
	$conn = get_db_connection();
	$stmt = $conn->prepare("INSERT INTO Accomplishment VALUES (:theUserId, :theActionId, CURRENT_TIMESTAMP)");
	$stmt->bindParam("theUserId", $_SESSION['Userid']);
	$stmt->bindParam("theActionId", $actionId);
	$result = $stmt->execute();

	$stmt = $conn->prepare("UPDATE UserAction SET CompleteTime = CURRENT_TIMESTAMP WHERE Userid = :theUserId AND ActionID = :theActionId;");
	$stmt->bindParam("theUserId", $_SESSION['Userid']);
	$stmt->bindParam("theActionId", $actionId);
	$result = $stmt->execute();

	if ($result) {
		$response = array("Result"=>"Success");
		echo json_encode($response);
	}
}

function deleteUserAction($actionId) {
	$conn = get_db_connection();
	$stmt = $conn->prepare("DELETE FROM UserAction WHERE UserID=:theUserId AND ActionID=:theActionId");
	$stmt->bindParam("theUserId", $_SESSION['Userid']);
	$stmt->bindParam("theActionId", $actionId);
	$result = $stmt->execute();
	if ($result) {
		$response = array("Result"=>"Success");
		echo json_encode($response);
	}
}

function getTop10WithinSchool(){
	$conn = get_db_connection();

	$stmt = $conn->prepare("
		SELECT u.Nickname, SUM(a.Points) AS Score
		FROM School s
		JOIN User u ON u.SchoolID=s.ID
		JOIN Accomplishment ac ON u.ID=ac.UserID
		JOIN Action  a ON ac.ActionID=a.ID
		WHERE s.ID IN (
			SELECT SchoolID FROM User WHERE ID=:theUserId
		)
		GROUP BY u.Nickname
		ORDER BY Score DESC
		LIMIT 10
	");
	$stmt->bindParam("theUserId", $_SESSION['Userid']);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);
}

function getUserScore() {
	$conn = get_db_connection();

	$stmt = $conn->prepare("
		SELECT u.Nickname, SUM(a.Points) AS Score
		FROM User u
		JOIN Accomplishment ac ON ac.UserID=u.ID
		JOIN Action a ON ac.ActionID=a.ID
		WHERE u.ID=:theUserId ");
	$stmt->bindParam("theUserId", $_SESSION['Userid']);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);
}

function getUserRankInSchool() {
	$conn = get_db_connection();
/*
	$stmt = $conn->prepare("
	 SELECT @rank:=case when Score=@s then @rank else @rank+1 end AS `Rank`,
			@s:=Score AS Score,
			ID,
			NickName
	 FROM (
		SELECT u.ID,
			   u.NickName,
			   SUM(a.Points) AS Score,
			   @rank:=0,
			   @s:=0
		FROM School s
			JOIN User u ON u.SchoolID=s.ID
			JOIN Accomplishment ac ON u.ID=ac.UserID
			JOIN Action  a ON ac.ActionID=a.ID
		WHERE s.ID IN (
			 SELECT SchoolID FROM User WHERE ID=:theUserId)
	 GROUP BY u.ID
	 ORDER BY Score DESC
	 ) As t
	");
 */

	$stmt = $conn->prepare("
		SELECT ID, NickName, Score, `Rank`, :theUserId AS MyId
		FROM (
			SELECT ID,
				NickName,
				Score,
				@rank:=case when Score=@s then @rank else @rank + @repeat + 1 end AS `Rank`,
				@repeat:= case when Score =@s then @repeat + 1 else 0 end,
				@s:=Score
			FROM (
				   SELECT  su.ID,
						   su.NickName,
						   SUM(a.Points) AS Score,
						   @rank:=0,
						   @repeat:=0,
						   @s:=0
					FROM School s
					   JOIN (
						 SELECT ID, NickName, SchoolID
						 FROM User u
						 WHERE u.SchoolID IN (
							  SELECT SchoolID
							  FROM User
							  WHERE ID=:theUserId
						 )
						) AS su ON su.SchoolID=s.ID
						JOIN Accomplishment ac ON ac.UserID=su.ID
						JOIN Action a ON ac.ActionID=a.ID
						GROUP BY su.ID, su.NickName
						ORDER BY Score DESC
			) AS tt1
		) AS tt2
	");

	$stmt->bindParam("theUserId", $_SESSION['Userid']);

	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);

}

function getUserSchool() {
	$conn = get_db_connection();
	$stmt = $conn->prepare("SELECT s.SchoolName
		FROM School s
		JOIN User u ON u.SchoolID=s.ID
		WHERE u.ID=:theUserId");
	$stmt->bindParam("theUserId", $_SESSION['Userid']);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);

}

function myComplishment(){
	$conn = get_db_connection();
	if ($conn) {
		$stmt = $conn->prepare("SELECT ac.UserID, ac.CompleteTime, a.Description
			FROM Accomplishment ac
			INNER JOIN Action a On ac.ActionID = a.ID
			WHERE UserID=:theUser
			ORDER BY ac.CompleteTime DESC
					");
		$stmt->bindParam(":theUser", $_SESSION['Userid']);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($result);
	}

}

function getUserRankInCity(){
	$conn = get_db_connection();
	$stmt = $conn->prepare("
	SELECT ID, NickName, Score, City, SchoolName, `Rank`, :theUserId AS MyId
	FROM (
		SELECT ID, NickName, Score, City, SchoolName,
		   @rank:=case when Score=@s then @rank else @rank + @repeat + 1 end AS `Rank`,
		   @repeat:= case when Score =@s then @repeat + 1 else 0 end,
		   @s:=Score
		FROM (
		   SELECT cs.ID,
				cs.NickName,
				SUM(a.Points) AS Score,
				cs.City, cs.SchoolName,
				@rank:=0,
				@repeat:=0,
				@s:=0
			FROM (
				SELECT u.ID, u.NickName, s.City, s.SchoolName
				FROM School s
					JOIN User u ON u.SchoolID=s.ID
				WHERE City IN (
					SELECT City
					FROM School s
						JOIN User u ON u.SchoolID=s.ID
						WHERE u.ID=:theUserId)
				) AS cs
				JOIN Accomplishment ac ON ac.UserID=cs.ID
				JOIN Action a ON ac.ActionID=a.ID
				GROUP BY cs.ID
				ORDER BY Score DESC
		) AS tt1
	) AS tt2
	");
	$stmt->bindParam(":theUserId", $_SESSION['Userid']);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);


}

function getUserCity(){
	$conn = get_db_connection();
	$stmt = $conn->prepare("
	SELECT s.City
	FROM School s
		JOIN User u ON u.SchoolID=s.ID
	WHERE u.ID=:theUserId
	");
	$stmt->bindParam(":theUserId", $_SESSION['Userid']);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);
}

function getSchoolRankInCity(){
	$conn = get_db_connection();
	$stmt = $conn->prepare("
	SELECT @myschoolid:=SchoolID FROM User WHERE ID=:theUserId
	");
	$stmt->bindParam(":theUserId", $_SESSION['Userid']);
	$stmt->execute();

	$stmt = $conn->prepare("
	SELECT `Rank`, SchoolID, SchoolName, Score, MySchoolId, :theUserId AS MyId
	FROM
	(
		SELECT SchoolID, SchoolName, Score,
			@rank:=case when Score=@s then @rank else @rank + @repeat + 1 end AS `Rank`,
			@repeat:= case when Score =@s then @repeat + 1 else 0 end,
			@s:=Score,
			MySchoolId
		FROM
		(
		SELECT cs.SchoolID,
			cs.SchoolName,
			SUM(a.Points) AS Score,
			@rank:=0,
			@repeat:=0,
			@s:=0,
			@myschoolid AS MySchoolId
		FROM (
			SELECT u.ID, u.NickName, u.SchoolID, s.City, s.SchoolName,
			@myschoolid:=case when u.ID=:theUserId then SchoolID else @myschoolid end
			FROM School s
			JOIN User u ON u.SchoolID=s.ID
			WHERE City IN (
			SELECT City
			FROM School s
			JOIN User u ON u.SchoolID=s.ID
			WHERE u.ID=:theUserId
			)
		) AS cs
		JOIN Accomplishment ac ON ac.UserID=cs.ID
		JOIN Action a ON ac.ActionID=a.ID
		GROUP BY cs.SchoolID
		ORDER BY Score DESC
		) AS tt1
	) AS tt2
	");
	$stmt->bindParam(":theUserId", $_SESSION['Userid']);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);

}

function getSchoolRankInState() {
	$conn = get_db_connection();
	$stmt = $conn->prepare("
	SELECT @myschoolid:=SchoolID FROM User WHERE ID=:theUserId
	");
	$stmt->bindParam(":theUserId", $_SESSION['Userid']);
	$stmt->execute();

	$stmt = $conn->prepare("
	SELECT `Rank`, SchoolID, SchoolName, Score, City, MySchoolId, :theUserId AS MyId
	FROM
	(
		SELECT SchoolID, SchoolName, Score, City,
			@rank:=case when Score=@s then @rank else @rank + @repeat + 1 end AS `Rank`,
			@repeat:= case when Score =@s then @repeat + 1 else 0 end,
			@s:=Score,
			MySchoolId
		FROM
		(
		SELECT cs.SchoolID,
			cs.SchoolName,
			cs.City,
			SUM(a.Points) AS Score,
			@rank:=0,
			@repeat:=0,
			@s:=0,
			@myschoolid AS MySchoolId
		FROM (
			SELECT u.ID, u.NickName, u.SchoolID, s.City, s.SchoolName,
			@myschoolid:=case when u.ID=:theUserId then SchoolID else @myschoolid end
			FROM School s
			JOIN User u ON u.SchoolID=s.ID
			WHERE StateProvince IN (
			SELECT StateProvince 
			FROM School s
			JOIN User u ON u.SchoolID=s.ID
			WHERE u.ID=:theUserId
			)
		) AS cs
		JOIN Accomplishment ac ON ac.UserID=cs.ID
		JOIN Action a ON ac.ActionID=a.ID
		GROUP BY cs.SchoolID
		ORDER BY Score DESC
		) AS tt1
	) AS tt2
	");
	$stmt->bindParam(":theUserId", $_SESSION['Userid']);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);

}

function getSchoolRankInCountry() {
	$conn = get_db_connection();
	$stmt = $conn->prepare("
	SELECT @myschoolid:=SchoolID FROM User WHERE ID=:theUserId
	");
	$stmt->bindParam(":theUserId", $_SESSION['Userid']);
	$stmt->execute();

	$stmt = $conn->prepare("
	SELECT `Rank`, SchoolID, SchoolName, Score, City, StateProvince, MySchoolId, :theUserId AS MyId
	FROM
	(
		SELECT SchoolID, SchoolName, Score,City, StateProvince,
			@rank:=case when Score=@s then @rank else @rank + @repeat + 1 end AS `Rank`,
			@repeat:= case when Score =@s then @repeat + 1 else 0 end,
			@s:=Score,
			MySchoolId
		FROM
		(
		SELECT cs.SchoolID,
			cs.SchoolName,
			cs.City,
			cs.StateProvince,
			SUM(a.Points) AS Score,
			@rank:=0,
			@repeat:=0,
			@s:=0,
			@myschoolid AS MySchoolId
		FROM (
			SELECT u.ID, u.NickName, u.SchoolID, s.StateProvince, s.City, s.SchoolName,
			@myschoolid:=case when u.ID=:theUserId then SchoolID else @myschoolid end
			FROM School s
			JOIN User u ON u.SchoolID=s.ID
			WHERE Country IN (
			SELECT Country 
			FROM School s
			JOIN User u ON u.SchoolID=s.ID
			WHERE u.ID=:theUserId
			)
		) AS cs
		JOIN Accomplishment ac ON ac.UserID=cs.ID
		JOIN Action a ON ac.ActionID=a.ID
		GROUP BY cs.SchoolID
		ORDER BY Score DESC
		) AS tt1
	) AS tt2
	");
	$stmt->bindParam(":theUserId", $_SESSION['Userid']);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);
}

function getAllStudentScore() {
	$conn = get_db_connection();
	$stmt = $conn->prepare("
		SELECT  s.Country,
				s.StateProvince,
				s.City,
				s.SchoolName,
				u.ID AS UserID,
				u.FirstName,
				u.LastName,
				u.NickName,
				u.Email,
				SUM(a.Points) As Score
		FROM School s
		JOIN User u ON u.SchoolID=s.ID
		JOIN Accomplishment ac ON ac.UserID=u.ID
		JOIN Action a ON ac.ActionID=a.ID
		GROUP BY UserID
		ORDER BY Score DESC
	");
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);

}

function getAllImages() {
	$conn = get_db_connection();
	$stmt = $conn->prepare("
	SELECT id, favflag, userID, description
	FROM Images
	");
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);
}

function getUserState() {
	$conn = get_db_connection();
	$stmt = $conn->prepare("
	SELECT s.StateProvince
	FROM School s
		JOIN User u ON u.SchoolID=s.ID
	WHERE u.ID=:theUserId
	");
	$stmt->bindParam(":theUserId", $_SESSION['Userid']);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);

}
function getUserCountry() {
	$conn = get_db_connection();
	$stmt = $conn->prepare("
	SELECT s.Country
	FROM School s
		JOIN User u ON u.SchoolID=s.ID
	WHERE u.ID=:theUserId
	");
	$stmt->bindParam(":theUserId", $_SESSION['Userid']);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);
}

function getUserRankInState() {
	$conn = get_db_connection();
	$stmt = $conn->prepare("
	SELECT ID, NickName, Score, City, SchoolName, `Rank`, :theUserId AS MyId
	FROM (
		SELECT ID, NickName, Score, City, SchoolName,
		   @rank:=case when Score=@s then @rank else @rank + @repeat + 1 end AS `Rank`,
		   @repeat:= case when Score =@s then @repeat + 1 else 0 end,
		   @s:=Score
		FROM (
		   SELECT cs.ID,
				cs.NickName,
				SUM(a.Points) AS Score,
				cs.City, cs.SchoolName,
				@rank:=0,
				@repeat:=0,
				@s:=0
			FROM (
				SELECT u.ID, u.NickName, s.City, s.SchoolName
				FROM School s
					JOIN User u ON u.SchoolID=s.ID
				WHERE StateProvince IN (
					SELECT StateProvince
					FROM School s
						JOIN User u ON u.SchoolID=s.ID
						WHERE u.ID=:theUserId)
				) AS cs
				JOIN Accomplishment ac ON ac.UserID=cs.ID
				JOIN Action a ON ac.ActionID=a.ID
				GROUP BY cs.ID
				ORDER BY Score DESC
		) AS tt1
	) AS tt2
	");
	$stmt->bindParam(":theUserId", $_SESSION['Userid']);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);

}

function getUserRankInCountry() {
	$conn = get_db_connection();
	$stmt = $conn->prepare("
	SELECT ID, NickName, Score, StateProvince, City, SchoolName, `Rank`, :theUserId AS MyId
	FROM (
		SELECT ID, NickName, Score, StateProvince, City, SchoolName,
		   @rank:=case when Score=@s then @rank else @rank + @repeat + 1 end AS `Rank`,
		   @repeat:= case when Score =@s then @repeat + 1 else 0 end,
		   @s:=Score
		FROM (
		   SELECT cs.ID,
				cs.NickName,
				SUM(a.Points) AS Score,
				cs.StateProvince,
				cs.City,
				cs.SchoolName,
				@rank:=0,
				@repeat:=0,
				@s:=0
			FROM (
				SELECT u.ID,
					   u.NickName,
					   s.StateProvince,
					   s.City,
					   s.SchoolName
				FROM School s
					JOIN User u ON u.SchoolID=s.ID
				WHERE Country IN (
					SELECT Country
					FROM School s
						JOIN User u ON u.SchoolID=s.ID
						WHERE u.ID=:theUserId)
				) AS cs
				JOIN Accomplishment ac ON ac.UserID=cs.ID
				JOIN Action a ON ac.ActionID=a.ID
				GROUP BY cs.ID
				ORDER BY Score DESC
		) AS tt1
	) AS tt2
	");
	$stmt->bindParam(":theUserId", $_SESSION['Userid']);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($result);

}

function getMyNotification() {
	$conn = get_db_connection();
	if ($conn) {
		$stmt = $conn->prepare("SELECT n.Message, n.PostTime
			FROM Notification n
					");
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($result);
	}
}

function deleteMyNotification() {
	$conn = get_db_connection();
	if ($conn) {
		$stmt = $conn->prepare("DELETE FROM Notification");
		$result = $stmt->execute();
		if ($result) {
			$response = array("Result"=>"Success");
			echo json_encode($response);
		}
	}
}

function archiveOldAccomplishment() {
	$conn = get_db_connection();
	//echo $_POST['Date'];
	$date = $_POST['Date'];

	if ($conn) {
		try {
			$conn->beginTransaction();
			$stmt = $conn->prepare("
				INSERT INTO OldAccomplishment
					SELECT * 
					FROM Accomplishment
					WHERE CompleteTime < DATE :date
			");
			
			$stmt->bindValue(":date", $date, PDO::PARAM_STR);
			$stmt->execute();

			$stmt = $conn->prepare("
				DELETE FROM Accomplishment
					WHERE CompleteTime < DATE :date
			");
			$stmt->bindValue(":date", $date, PDO::PARAM_STR);

			$stmt->execute();

			$conn->commit();

			$response = array("Result"=>"Success");
			echo json_encode($response);
		} catch (Exception $e) {
			$conn->rollBack();
			echo "Failed:" . $e->getMessage();
		}
	}
}


function checkMyactionfinish() {
    $conn = get_db_connection();
    $stmt = $conn->prepare("
	SELECT t1.UserId, t1.ActionID, t2.ActionID AS CompleteActionID
		FROM
		(
		SELECT * 
		FROM UserAction 
		WHERE UserID=:theUserId
		) AS t1
		LEFT JOIN 
		(
		SELECT *
		FROM Accomplishment  
		WHERE UserID= :theUserId AND DATE(CompleteTime)=CURDATE()
		) AS t2 ON t1.ActionID = t2.ActionID;
	");
    $stmt->bindParam(":theUserId", $_SESSION['Userid']);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
}

//Roger changed administrator to administrator
function getAllAdmins() {
	$conn = get_db_connection();
	if ($conn) {
		$stmt = $conn->prepare("
			SELECT ID, Username, Email, Authorization
			FROM Administrator
			WHERE Authorization < (
				SELECT Authorization 
				FROM Administrator
				WHERE Username=:theAdmin
			) OR Username=:theAdmin
			ORDER BY Authorization DESC, Username ASC
		");
		$stmt->bindParam("theAdmin", $_SESSION['admin']);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($result);
	}
}

function addAdmin() {
	$options = ['cost'=>12,];
	$password_hash = password_hash($_POST['Password'],PASSWORD_BCRYPT, $options);
	$conn = get_db_connection();
	if ($conn) {
		$stmt = $conn->prepare("
			INSERT INTO Administrator VALUES(NULL, :username, :password, :email, :authorization) 
		");
		$stmt->bindParam(":username", $_POST['Username']);
		$stmt->bindParam(":password", $password_hash) ;
		$stmt->bindParam(":email", $_POST['Email']);
		$stmt->bindParam(":authorization", $_POST['Authorization']);
		$result=$stmt->execute();
		if ($result) {
			getAllAdmins();
		}
	}
}

function modifyAdmin() {
	$options = ['cost'=>12,];
	$password_hash = password_hash($_POST['Password'],PASSWORD_BCRYPT, $options);
	$conn = get_db_connection();
	if ($conn) {
		$stmt = $conn->prepare("
			UPDATE Administrator 
			SET Username=:username, Password=:password
			WHERE ID=:adminId
		");
		$stmt->bindParam(":username", $_POST['Username']);
		$stmt->bindParam(":password", $password_hash) ;
		$stmt->bindParam(":adminId", $_POST['AdminId']);
		$result=$stmt->execute();
		if ($result) {
			$response = array("Result"=>"Success");
			echo json_encode($response);
		}
	}
}

function deleteAdmin() {
	$conn = get_db_connection();
	if ($conn) {
		$stmt = $conn->prepare("
			DELETE FROM Administrator
			WHERE ID=:adminId 
		");
		$stmt->bindParam(":adminId", $_POST['AdminId']);
		$result=$stmt->execute();
		if ($result) {
			getAllAdmins();
		}
	}
}

/* Only call this when image uploaded via ajax. Inserts new image with current timestamp into images table. Decodes the image from a base64 url(the ajax side will need to encode an image as this to work) into a file/longblob.*/
/* Special thanks to drew010 at https://stackoverflow.com/questions/11511511/how-to-save-a-png-image-server-side-from-a-base64-data-string*/
function saveUploadedImage() 
{
	$conn = get_db_connection();
	if ($conn) 
	{
		$data = $_POST["image"];
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);

		$stmt = $conn->prepare("INSERT into Images (image, created, userID, description) VALUES (:image, NOW(), :Userid, :description)");
		$stmt->bindValue("image", $data);
		$stmt->bindParam("Userid", $_SESSION['Userid']);
		$stmt->bindParam("description", $_POST["description"]);
		$result = $stmt->execute();
		if ($result) 
		{
			echo json_encode($result);
		} else {
			$response = array("ImageUploadResult"=>"Fail");
			echo json_encode($response);			
		}
	}
}
?>
