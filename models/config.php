<?php
//models/config.php

//
$website_name = "MuuvieDB";

//views ja admin_views taulukkoa käytetään rajoittamaan väärille sivuille pääsyä + title
$views = array(
	"viewMovie" 	=> "Show Movie",
	"viewMovieBeta" => "Show Movie Javascript (beta)",
	"listMovies" 	=> "List Movies",
	"login" 		=> "Login",
	"logout" 		=> "Logout",
	"error"			=> "Page not found"
);

//jos sivu tässä taulukossa, tarkistetaan sessio muuttujasta pääsy ehto
$admin_views = array(
	"adminMovies" 	=> "Manage Movies",
	"addMovie" 		=> "Add Movie",
	"editMovie" 	=> "Edit Movie",
	"rateMovie" 	=> "Rate Movie",
	"listUsers" 	=> "Manage Users",
	"addUser" 		=> "Add User",
	"editUser" 		=> "",
	"deleteUser" 	=> "",
	"addMovieDemo" 	=> "Add Movie HTML5 regex",
);
?>