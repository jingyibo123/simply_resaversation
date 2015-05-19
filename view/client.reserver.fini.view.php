<?php

/* ------------------------------------------------------------------------- /
                        
    Ce fichier est une vue, elle affiche se que l'utilisateur voit.
    Ici se trouve le strict minimum, du code html et un peu de php
    pour les traitements des erreurs par exemple.

    Si la page necessite du javascript ou du css, il faudra le rentré 
    dans la variable $sScript.  

/ ------------------------------------------------------------------------- */


    //Si il y a besoin de rajouter du code javascript pour cette vue
    $sScript="";

    include 'include/header.inc.php';

?>


<body>
	<p>Votre réservation a bien été enregistrée </br>
	Vous allez recevoir un email de confirmation dans lequel vous trouverez un lien pour modifier votre réservation </p>
</body>


<?php

include 'include/footer.inc.php';
?>
