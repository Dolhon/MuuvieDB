
<?php
check_admin_login();
//delete
$deleted_title = "";
if (isset($_GET['delete']) && preg_match("/^\d+$/", trim($_GET['delete']), $matches)) {
	$exists = check_movie_exists($id);
	if ($exists) {
		$deleteID = $matches[0];
		$movie = get_movie($deleteID);
		$deleted_title = $movie['title'];
		$deleted_title = "<p><a>$deleted_title deleted</a></p>";
		delete_movie($deleteID);
	}
}

//list movies
$movies = get_all_movies();
$categories = get_all_categories();

echo "
<div class='left'>";

//admin linkit
echo"<p>
<ul><h4>Admin menu</h4>";
foreach ($admin_views as $admin_menu_view => $admin_menu_text) {
	echo "<li><a href='index.php?p=$admin_menu_view'>$admin_menu_text</a></li>";
}
echo "</ul></p>";

echo "
</div>
<div class='middle'>
<H2>$admin_views[$view]</H2>$deleted_title";

foreach ($movies as $movie) {
	$movieID = $movie['movieID'];
	$title = $movie['title'];
	$text = $movie['text'];
if (file_exists("images/" . $movie['movieID'] . ".jpg")) {
	$image = $movie['movieID'];
} else {
	$image = 0;
}
echo "</p>
<div class='list'>
	<div class='list_left'>
		<img class='poster_list' src='images/$image.jpg' align='right'>
	</div>
	<div class='list_right'>
		<H3><a href='index.php?p=viewMovie&id=$movieID'>$title</a>
		<br><a href='index.php?p=editMovie&id=$movieID'>edit</a>
		<a> | </a><a href='index.php?p=adminMovies&delete=$movieID'>delete</a>
		<a> | </a><a href='index.php?p=rateMovie&id=$movieID'>rate</a>
		</H3>
		<p>
		
		Score: ";
		$rating = get_movie_rating($movieID);
		draw_score_stars($rating);
		echo"<br>
		$text
		</p>
	</div>
</div>";
}

echo "
<br><br>
</div>";
?>