<?php
$movies = get_all_movies();

$categories = get_all_categories();

echo "
<div class='left'>
</div>
<div class='middle'>
<H2>$views[$view]</H2>";

foreach ($movies as $movie) {
	$movieID = $movie['movieID'];
	$title = $movie['title'];
	$text = $movie['text'];
if (file_exists("images/" . $movie['movieID'] . ".jpg")) {
	$image = $movie['movieID'];
} else {
	$image = 0;
}
echo "
<div class='list'>
	<div class='list_left'>
		<img class='poster_list' src='images/$image.jpg' align='right'>
	</div>
	<div class='list_right'>
		<H3><a href='index.php?p=viewMovie&id=$movieID'>$title</a></H3>
		<p>Score: ";
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