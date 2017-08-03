<?php
session_start();
$_SESSION['serveur'] = 'localhost';
$_SESSION['loginBDD'] = 'root';
$_SESSION['password'] = 'formation';
$_SESSION['database'] = 'search';
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Recherche des infos</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" 
              integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" 
              crossorigin="anonymous">
    </head>
    <body onload="Id()">
        <div id="DivClignotante" style="color: RED"><center><h2>Version Lingo3G</h2></center></div>

        <script>
            function Id() {
                document.search_box.search.focus();
            }

        </script>

        <style>
            body{
                margin: 12%;
            }

        </style>

        <form name="search_box" action="vue/template.php" method="GET" style="margin-top:40px">
            <center>
                <img src="logo/search_hat.png" height="150px" class="img-responsive" alt="Search">
                <input type="text" class="form-control" name="query" style="width:60%; margin-top: 20px">
                <select class="form-control" name="langueResultat" style=" width:60%; margin-top: 10px;" >
                    <option>Francais</option>
                    <option>Anglais</option>
                </select>
                <input type="text" class= "form-control" name="maxResult" style=" width:60%; margin-top: 10px" placeholder="nombre de resultat demandé">
                <select class="form-control" name="moteur" style=" width:60%; margin-top: 10px;" >
                    <option>Recherche interne</option>
                    <option>Recherche MetaMoteur</option>
                    <option>Recherche google</option>

                </select>
                <input type="number" class="form-control" name="deep" style="width:60%; margin-top: 10px;" placeholder="niveau de profondeur de 1 à 5" min="1" max="5" />
                <select class="form-control" name="paysRecherche" style="width:60%; margin-top: 10px">
                    <option>Recherche en France</option>
                    <option>Recherche dans le Monde</option>
                </select>
                <input type="submit" class="btn btn-warning" value="Rechercher" name="search_button" style="margin-top: 20px;">
            </center>
        </form>

        <br>
        <br>
        <div>
            <center>
                <a href="donnee.php" target='_blank'><input type='button' class='btn btn-info' name='search_complete' value='Réfèrencez vos infos'></a>
                <!-- <a href="connect.php" target='_blank'><input type='button' class='btn btn-warning' name='acces_stagiaire' value='Acces suivi stagiaire'></a> -->
                <!-- <a href="resultatGoogle.php"><input type='button' class='btn btn-warning' name='search_googleAPI' value='Recherche Google'></a> -->
            </center>
        </div>

        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" 
                integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" 
        crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" 
                integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" 
        crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" 
                integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" 
        crossorigin="anonymous"></script>
        
        <script type="text/javascript"> 
var clignotement = function(){ 
   if (document.getElementById('DivClignotante').style.visibility=='visible'){ 
      document.getElementById('DivClignotante').style.visibility='hidden'; 
   } 
   else{ 
   document.getElementById('DivClignotante').style.visibility='visible'; 
   } 
}; 

periode = setInterval(clignotement, 400); 
</script>
    </body>

</html>