<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Ecoride</title>
        <link href="style.css" rel="stylesheet" type="text/css" />
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
        <details>
            <summary>Détails des éléments du voyage</summary>
        </details>
        </div>

        <?php

                require_once 'pdoconfig.php';
            
                try {
                    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

                    $sql = "SELECT *
                    FROM covoiturage, depose
                    LEFT JOIN utilisateur ON utilisateur.utilisateur_id = depose.utilisateur_id
                    LEFT JOIN voiture ON voiture.voiture_id = voiture_id 
                    LEFT JOIN avis ON avis.avis_id = depose.avis_id
                    LEFT JOIN marque ON marque.marque_id = voiture.marque_id";

                    foreach  ($conn->query($sql) as $row) {
                        print "Avis du conducteur : ".$row['commentaire'] . "\t";
                        print "Date de départ : ".$row['date_depart'] . "\t";
                        print "Date d'arrivée : ".$row['date_arrivee'] . "\t";
                        print "Modèle du véhicule : ".$row['modele'] . "\t";
                        print "Marque du véhicule : ".$row['libelle'] . "\n";
                        print "Energie utilisée : ".$row['energie'] . "\t";
                        echo "<FORM action='mon-compte.php' method='GET'><BUTTON>Participer</BUTTON></FORM>";
                    }

                    } catch (PDOException $pe) {
                        die ("Message d'erreur $dbname :" . $pe->getMessage()."à la ligne ".$pe->getLine());
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