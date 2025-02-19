<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Ecoride</title>
    </head>
    <body>
        <nav>
            <button onclick="window.location.href = 'http://localhost/Projet/ecoride/index.php';">Accueil</button>
            <button onclick="window.location.href = 'http://localhost/Projet/ecoride/covoiturages.php';">Covoiturages</button>
            <button onclick="window.location.href = 'http://localhost/Projet/ecoride/creation-compte.php';">Connexion</button>
            <button onclick="window.location.href = 'http://localhost/Projet/ecoride/index.php';">Contact</button>
        </nav>
        <img src="image.jpg" width="100%" height="800px">
        <div>
            <form action="index.php" method="GET">
                <DIV>
                    <label for="depart">Adresse de départ</label>
                    <input type="text" id="depart" name ="depart" size="10" required>
                    <label for="arrivee">Adresse d'arrivée</label>
                    <input type="text" id="arrivee" name ="arrivee" size="10" required>
                    <label for="date">Date de départ</label>
                    <input type="date" id="date" name ="date" required>
                    <input type="submit" value="Rechercher">
                </DIV>
            </form>
            	
            <script type="text/javascript">
            /* Voici la fonction javascript qui change la propriété "display"
            pour afficher ou non le div selon que ce soit "none" ou "block". */
 
            function AfficherMasquer()
            {
                divInfo = document.getElementById('divacacher');
 
                if (divInfo.style.display == 'none')
                    divInfo.style.display = 'block';
                else
                    divInfo.style.display = 'none';
                }
            </script>
 
 
            <!-- Ca c'est le div en question qui possède l'id indiqué dans
            la fonction. -->
            <div id="divacacher" style="display:none;">        
                    <label for="voyage_ecologique">Voyage écologique</label>
                    <input type="checkbox" id="voyage_ecologique" name ="voyage_ecologique">
                    <label for="prix">Prix maximum</label>
                    <input type="number" id="prix" name ="prix">
                    <label for="duree">Durée maximum</label>
                    <input type="number" id="duree" name ="duree">
                    <label for="note">Note</label>
                    <input type="range" id="note" name ="note" min="1" max="5">
                    
                    <!-- La c'est le bouton qui va afficher le div en cliquant dessus. -->
            </DIV>
            <input type="button" value="Filtre" onClick="AfficherMasquer()" />
        </div>

        <?php

            if (isset($_GET['depart'])) {

                $departForm = $_GET['depart'];
                $arriveeForm = $_GET['arrivee'];
                $dateForm = $_GET['date'];

                require_once 'pdoconfig.php';
            
                try {
                    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                    echo "Connected to $dbname at $host successfully.";

                    $stmt = $conn->prepare("SELECT *
                    FROM covoiturage, depose
                    JOIN utilisateur ON utilisateur.utilisateur_id = depose.utilisateur_id
                    JOIN voiture ON voiture.voiture_id = voiture_id
                    JOIN avis ON avis.avis_id = depose.avis_id
                    WHERE lieu_depart=:depart AND lieu_arrivee=:arrivee AND date_depart=:date"
                    );


                    $stmt->bindParam(':depart', $departForm);
                    $stmt->bindParam(':arrivee', $arriveeForm);
                    $stmt->bindParam(':date', $dateForm);
                    $stmt->execute();

                    $res = $stmt->fetchAll();
                    foreach ( $res as $row ) {
                        echo "<DIV><FORM action='detail-voyage.php' method='GET'>Pseudo : ".$row['pseudo']."Photo : ".$row['photo']."Note : ".$row['note']."Nombre de place restante : 
".$row['nb_place']."Prix : ".$row['prix_personne']."Date de départ : ".$row['date_depart']."Heure de départ : ".$row['heure_depart']."Date d'arrivée : ".$row['date_arrivee']."Heure arrivee : ".$row['heure_arrivee']."Voyage écologique : ".$row['energie']."<button>Détail</button></FORM></DIV>";
                    }

                    } catch (PDOException $pe) {
                        die ("Message d'erreur $dbname :" . $pe->getMessage()."à la ligne ".$pe->getLine());
                    }
                }

        ?>
        <DIV>
            <footer>
                <a href="ecoride@ecoride.fr">E-mail Ecoride</a>
                <a href="mentions@ecoride.fr">Mentions légales</a>
            </footer>
        </DIV>
    </body>
</html>
