<?php
function draw_score_stars_admin($score) {
	for($i = 0;$i<$score;$i++){
		echo "<img src='images/star_on.png'>";
	}
	for($i = 0;$i<(5-$score);$i++){
		echo "<img src='images/star_off.png'>";
	}
}
#region MOVIES_ADMIN_EDITOR		//Movies add, edit, delete
function get_movie_table_columns()
{
	$db = open_database_connection();
	$stmt = $db->prepare("DESCRIBE movie");
	$stmt->execute();
	$columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    close_database_connection($db);
    return $columns;
}
function add_movie($movies)
{
	$db = open_database_connection();
	$stmt = $db->prepare("INSERT INTO `movie` 
	(`movieID`, `name`, `text`, `DateTime`, `editDateTime`, `video`, `userID`, `editUserID`) 
	VALUES (NULL, :name, :text, :dateTime, NULL, :video, :userID, NULL)");
	$stmt->execute(array(':name' => $movies['name'],':text' => $movies['text'],
						':dateTime' => $movies['dateTime'],':video' => $movies['video'],
						':userID' => $movies['userID']));
						
	//last inserted auto increment movieID
	$last_insert_id = $db->lastInsertId();
	
	//add selected categories for movie
	foreach ($movies['categories'] as $row) {
		$stmt = $db->prepare("INSERT INTO `movie_category` (`categoryID`, `movieID`) VALUES (:cid, :mid)");
		$stmt->execute(array(':cid' => $row, ':mid' => $last_insert_id));
	}
	close_database_connection($db);
}
	
function delete_movie($id)
{
	$db = open_database_connection();
	//korjattu
	/*$stmt = $db->prepare("DELETE FROM `movie_category` WHERE `movieID` = :id");
	$stmt->execute(array(':id' => $id));
	$stmt = $db->prepare("DELETE FROM `rating` WHERE `movieID` = :id");
	$stmt->execute(array(':id' => $id));*/
	$stmt = $db->prepare("DELETE FROM `movie` WHERE `movieID` = :id");
	$stmt->execute(array(':id' => $id));
	close_database_connection($db);
}

function edit_movie($movie)
{
	
	$db = open_database_connection();
	
	//päivitä elokuvan tiedot
	$stmt = $db->prepare("UPDATE  `movie` SET  `name` =  :name, 
			`text` =  :text, `editDateTime` =  :dateTime,
			`video` =  :video, `editUserID` =  :uid 
			WHERE  `movieID` = :id");
			
	$stmt->execute(array(':id' => $movie['id'],':name' => $movie['name'],
				':text' => $movie['text'],':dateTime' => $movie['editDateTime'],
				':video' => $movie['video'],':uid' => $movie['editUserId']));
	
	//poista kaikki kategoria viittaukset elokuvaan
	$stmt = $db->prepare("DELETE FROM `movie_category` WHERE `movieID` = :id");
	$stmt->execute(array(':id' => $movie['id']));
	
	//luo uudet kategoria viittaukset elokuvaan
	foreach ($movie['categories'] as $row) {
		$stmt = $db->prepare("INSERT INTO `movie_category` (`categoryID`, `movieID`) VALUES (:cid, :mid)");
		$stmt->execute(array(':cid' => $row, ':mid' => $movie['id']));
	}
	close_database_connection($db);
}

function rate_movie($rating){
	$db = open_database_connection();
	$stmt = $db->prepare("SELECT * FROM `rating` WHERE `userID` = :userID AND `movieID` = :movieID");
	$stmt->execute(array(':userID' => $rating['userID'], ':movieID' => $rating['movieID']));
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	if (!$result) {
		$stmt = $db->prepare("INSERT INTO rating (`userId`, `movieID`, `rating`)
								VALUES (:userID, :movieID, :rating)");
		$stmt->execute(array(':userID' => $rating['userID'], ':movieID' => $rating['movieID'], ':rating' => $rating['rating']));
		
	} else {
		$stmt = $db->prepare("UPDATE `rating`
								SET `rating` = :rating
								WHERE `userID` = :userID 
								AND `movieID` = :movieID");
		$stmt->execute(array(':userID' => $rating['userID'], ':movieID' => $rating['movieID'], ':rating' => $rating['rating']));
	}
	close_database_connection($db);
}

function extract_youtube_id($link)
{
	parse_str( parse_url( $link, PHP_URL_QUERY ), $youtube_parameters );
	return $youtube_parameters['v']; 
}
#end
#region USERS_ADMIN_(*EDITOR)	//Users add, edit, delete, list *EDITOR voi editoida vain omia tietoja
function get_all_users()
{
	$db = open_database_connection();
	$stmt = $db->prepare("SELECT userID, name as title, name, roleID FROM user ORDER BY roleID");
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$users = array();
	foreach ($rows as $row) {
		$users[] = $row;
	}
    close_database_connection($db);
    return $users;
}

function check_user_exists($id)
{
	$users = get_all_users();
	$userID = array();
	foreach ($users as $row) {
		$userID[] = $row['userID'];
	}
	if (in_array($id, $userID)) {
		return true;
	} else {
		return false;
	}
	
}

function get_user($id)
{
	$db = open_database_connection();
	$stmt = $db->prepare("SELECT userID, name, login, pass
						FROM user
						WHERE userID = :id");
	$stmt->execute(array(':id' => $id));
	$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    close_database_connection($db);
    return $users[0];
}

function add_user($user)
{
	$db = open_database_connection();
	$stmt = $db->prepare("INSERT INTO `user` 
	(`userID`, `name`, `login`, `pass`, `roleID`) 
	VALUES (NULL, :name, :login, :pass, 2)");
	$stmt->execute(array(':name' => $user['name'],':login' => $user['login'],
						':pass' => $user['pass']));
						
	//last inserted auto increment userID
	$last_insert_id = $db->lastInsertId();
	
	close_database_connection($db);
}

function edit_user($user)
{
	
	$db = open_database_connection();
	
	//päivitä elokuvan tiedot
	$stmt = $db->prepare("UPDATE  `user` SET  `name` =  :name, 
			`login` =  :login, `pass` =  :pass
			WHERE  `userID` = :userID");
			
	$stmt->execute(array(':userID' => $user['userID'], ':name' => $user['name'],
				':login' => $user['login'],':pass' => $user['pass']));
	close_database_connection($db);
}

function delete_user($id)
{
	$db = open_database_connection();
	$stmt = $db->prepare("DELETE FROM `user` WHERE `userID` = :id");
	$stmt->execute(array(':id' => $id));
	close_database_connection($db);
}
#end
#region AUTH					//Admin/editor login, logout
function check_login_from_db($user, $pass)
{
	$db = open_database_connection();
	$stmt = $db->prepare("SELECT userID, name, login, pass
						FROM user
						WHERE login = :user AND pass = :pass");
	$stmt->execute(array(':user' => $user,':pass' => $pass));
	$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    close_database_connection($db);
    return empty($users);
}
function check_admin_login()
{
	if (!isset($_SESSION['Login']) || $_SESSION['Login'] != 'TRUE'){
		header("Location: index.php");
		exit();
	}
}
function check_editor_login()
{
}
function login($user, $pass)
{
	if (!check_login_from_db($user, $pass)) {
		$_SESSION['Login'] = 'TRUE';
		header('Location: index.php?p=adminMovies');
	}
	else {
		$_SESSION['Login'] = 'FALSE';
		echo "<h1>Username and/or password didn't match.</h1>";
	}
}
function logout()
{
	$_SESSION['Login'] = 'FALSE';
	header('Location: index.php');
	exit();
}
#end

?>