<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Ecoride</title>
    </head>
    <body>
        <nav>
            <button onclick="window.location.href = 'http://localhost/Projet/index.php';">Accueil</button>
            <button onclick="window.location.href = 'http://localhost/Projet/covoiturages.php';">Covoiturages</button>
            <button onclick="window.location.href = 'http://localhost/Projet/creation-compte.php';">Connexion</button>
            <button onclick="window.location.href = 'http://localhost/Projet/index.php';">Contact</button>
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
                <DIV>
                    <label for="pseudo">Pseudo</label>
                    <input type="text" id="pseudo" name ="pseudo" size="10">
                    <label for="photo">Photo</label>
                    <input type="file" id="photo" name ="photo" size="10">
                    <label for="note">Note</label>
                    <input type="range" id="note" name ="note" min="1" max="5">
                    <label for="nb_place">Nombre de places</label>
                    <input type="number" id="nb_place" name ="nb_place">
                    <label for="prix">Prix</label>
                    <input type="number" id="prix" name ="prix">
                </DIV>
                <DIV>
                    <label for="date_depart">Date de départ</label>
                    <input type="date" id="date_depart" name ="date_depart">
                    <label for="heure_depart">Heure de départ</label>
                    <input type="date" id="heure_depart" name ="heure_depart">
                    <label for="date_arrivee">Date d'arrivée</label>
                    <input type="date" id="date_arrivee" name ="date_arrivee">
                    <label for="heure_arrivee">Heure d'arrivée</label>
                    <input type="text" id="heure_arrivee" name ="heure_arrivee">
                    <label for="voyage_ecologique">Voyage écologique</label>
                    <input type="checkbox" id="voyage_ecologique" name ="voyage_ecologique">
                </DIV>
            </form>
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
                    LEFT JOIN utilisateur ON utilisateur.utilisateur_id = depose.utilisateur_id
                    LEFT JOIN voiture ON voiture.voiture_id = voiture_id 
                    LEFT JOIN avis ON avis.avis_id = depose.avis_id
                    WHERE covoiturage.lieu_depart=:depart AND covoiturage.lieu_arrivee=:arrivee AND covoiturage.date_depart=:date"
                    );


                    $stmt->bindParam(':depart', $departForm);
                    $stmt->bindParam(':arrivee', $arriveeForm);
                    $stmt->bindParam(':date', $dateForm);
                    $stmt->execute();

                    $res = $stmt->fetchAll();
                    foreach ( $res as $row ) {
                        echo "<DIV><FORM action='detail-voyage.php' method='GET'><button>Détail</button></FORM></DIV>";
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