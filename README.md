# MuuvieDB

## Rakenne

```mdb
│   index.php - index sivu jonka kautta kaikki sisältö ladataan
│   
├───css
│       style.css - tyylitiedosto
│       
├───images - kuvat
│       0.jpg - error kuva, jos elokuvan julistetta ei löydy
│       star_off.png - arvostelutähti pois päältä
│       star_on.png - päällä
│       
├───libraries (WWW-tekniikat opintojakso)
│       jquery-1.11.0.js - jquery 
│       
├───models
│       .htaccess - estää kansion suoran käytön
│       admin.php - admin funktioita
│       config.php - sivuston asetuksia
│       db_config.php - tietokannan asetuksia
│       functions.php - sivuston funktioita
│       parameters.php - parametrien käsittely
│
├───Shadowbox - lightbox efektissä käytettävä kirjasto
│       
├───templates
│       .htaccess - estää kansion suoran käytön
│       header.php - sivuston header
│       layout.php - sivuston pohja
│       
└───views
        .htaccess - estää kansion suoran käytön
        addMovie.php - Lisää elokuva
        addMovieDemo.php - Lisää elokuva (html5 regex form)
        adminMovies.php - Admin sivu elokuvien listaus
        deleteMovie.php - poista elokuva
        editMovie.php - muokkaa elokuvaa
        error.php - error sivu
        listMovies.php - listaa elokuvat
        login.php - login sivu
        rateMovie.php - anna arvosana elokuvalle
        viewMovie.php - näytä elokuva
        viewMovieBeta.php - näytä elokuva javascript demo
				editUser.php - muokkaa profiilia
				listUsers.php - listaa editor profiilit
```
	
        
