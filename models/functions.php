<?php
//models/models.php
#region DATABASE 				//Database connect, close
function open_database_connection()
{
	require('models/db_config.php');
    $db = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname . ';charset=utf8', $dbuser, $dbpass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    return $db;
}
function close_database_connection($db)
{
    $db = null;
}

#end
#region MOVIES					//Movies list, show, rating, categories
function get_movie($id)
{
	$db = open_database_connection();
	$stmt = $db->prepare("SELECT DateTime, video, user.name as author,
						movie.name as title, text
						FROM movie, movie_category, user
						WHERE movie.userID = user.userID 
						AND movie.movieID = :id");
	$stmt->execute(array(':id' => $id));
	$movie = $stmt->fetchAll(PDO::FETCH_ASSOC);
    close_database_connection($db);
    return $movie[0];
}

function check_movie_exists($id)
{
	$movies = get_all_movies();
	$movieID = array();
	foreach ($movies as $row) {
		$movieID[] = $row['movieID'];
	}
	if (in_array($id, $movieID)) {
		return true;
	} else {
		return false;
	}
	
}

function get_all_movies()
{
	$db = open_database_connection();
	$stmt = $db->prepare("SELECT movieID, name as title, text FROM movie ORDER BY DateTime");
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$movies = array();
	foreach ($rows as $row) {
		$movies[] = $row;
	}
    close_database_connection($db);
    return $movies;
}

function get_all_categories()
{
	$db = open_database_connection();
	$stmt = $db->prepare("SELECT categoryID, catName FROM category");
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data = array();
	foreach ($rows as $row) {
		$data[] = $row;
		//echo $row['categoryID'];
		//echo $row['catName'];
	}
    close_database_connection($db);
    return $data;
}

function get_movie_categories($id)
{
	$db = open_database_connection();
	$stmt = $db->prepare("SELECT category.categoryID, catName 
						FROM category, movie_category 
						WHERE movieID = :id 
						AND category.categoryID = movie_category.categoryID");
	$stmt->execute(array(':id' => $id));
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    close_database_connection($db);
    return $data;
}

function get_movie_rating($id)
{
	$db = open_database_connection();
	$stmt = $db->prepare("SELECT AVG(rating) as 'rating' FROM rating WHERE movieID = :id");
	$stmt->execute(array(':id' => $id));
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    close_database_connection($db);
	$rating = intval($data[0]['rating']);
    return $rating;
}

#end


function convert_datetime_to_view($mysqldate) {
	$phpdate = strtotime( $mysqldate );
	$mysqldate = date( 'd.m.Y H:i:s', $phpdate );
	return $mysqldate;
}
function draw_score_stars($score) {
	for($i = 0;$i<$score;$i++){
		echo "<img src='images/star_on.png'>";
	}
	for($i = 0;$i<(5-$score);$i++){
		echo "<img src='images/star_off.png'>";
	}
}
?>