<?php
$movies = get_all_movies();

$categories = get_all_categories();

echo "
<div class='left'>
</div>
<div class='middle'>
<H2>$views[$view]</H2>
<div class='list' id='movie'>
</div>
<script>
var movies = new Array();

";
$i = 0;
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
		movies[$i] = 
		\"<div class='list_left'>\"
		+ \"<img class='poster_list' src='images/$image.jpg' align='right'>\"
		+ \"</div>\"
		+ \"<div class='list_right'>\"
		+ \"<H3><a href='index.php?p=viewMovie&id=$movieID'>$title</a></H3>\"
		+ \"<p>Score: ";                                                       
			$rating = get_movie_rating($movieID);                                  
			draw_score_stars($rating);                                             
			echo"<br>\"
		+ \"</p><p><a href='javascript:change_movie(" . ($i - 1) . ");'>previous</a>\"
		+ \"<a> | </a><a href='javascript:change_movie(" . ($i + 1) . ");'>next</a></p>\"
		+ \"</div>\";
	";
	$i++;
}

echo "
document.getElementById('movie').innerHTML=movies[0];
var last_element = movies.length -1;
function change_movie(i) {
	if (i === -1) {
		document.getElementById('movie').innerHTML=movies[movies.length-1];
	} else if(movies.length > i) {
		document.getElementById('movie').innerHTML=movies[i];
	} else {
		document.getElementById('movie').innerHTML=movies[0];
	}
}
</script>
<br><br>
</div>";
?>