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
            <button onclick="window.location.href = 'http://localhost/Projet/contact.php';">Contact</button>
        </nav>

        <?php

        if (isset($_GET['email'])) {

        $emailForm = $_GET['email'];
        $passwordForm = $_GET['password'];

        require_once 'pdoconfig.php';

        try {

        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        echo "Connected to $dbname at $host successfully.";

        // PDO instantiation here
        $stmt = $conn->prepare('SELECT COUNT(email) AS EmailCount FROM utilisateur WHERE email = :email');
        $stmt->execute(array('email' => $_GET['email']));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['EmailCount'] == 0) {
            echo "Vous n'avez pas de compte";
        } else {
            echo "Vous êtes sur votre compte";
            ?>
        <div>
            <form action="mon-compte.php" method="GET">
                <DIV>
                    <label for="immatriculation">Plaque d'immatriculation</label>
                    <input type="text" id="immatriculation" name ="immatriculation" size="10">
                    <label for="date_premiere_immatriculation">Date de première immatriculation</label>
                    <input type="text" id="date_premiere_immatriculation" name ="date_premiere_immatriculation" size="10">
                    <label for="modele">Modèle</label>
                    <input type="text" id="modele" name ="modele">


                    <label for="couleur">Couleur</label>
                    <input type="text" id="couleur" name ="couleur" size="10">
                    <label for="marque">Marque</label>
                    <input type="text" id="marque" name ="marque" size="10">
                    <label for="nb_place">Nombre de places</label>
                    <input type="text" id="nb_place" name ="nb_place">
                </DIV>
                <DIV>
                    <label for="fumeur">Fumeur / non-fumeur</label>
                    <input type="checkbox" id="fumeur" name ="fumeur">
                    <label for="animal">Animal / pas d'animal</label>
                    <input type="checkbox" id="animal" name ="animal">
                    <input type="submit" value="Ajouter véhicule">
                </DIV>
                
            </form>


        </div>
        <?php
        }
        } catch (PDOException $pe) {
            die ("Message d'erreur $dbname :" . $pe->getMessage()."à la ligne ".$pe->getLine());
        }
    }
        ?>

        <?php


        require_once 'pdoconfig.php';

        if(isset($_GET['modele'])) {

        try {

            

            $modeleForm = $_GET['modele'];
            $immatriculationForm = $_GET['immatriculation'];
            $couleurForm = $_GET['couleur'];
            $datePremiereImmatriculationForm = $_GET['date_premiere_immatriculation'];

            $marqueForm = $_GET['marque'];

            $nombreDePlacesForm = $_GET['nb_place'];
            

            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            echo "Connected to $dbname at $host successfully.";

            // PDO instantiation here
            $stmt = $conn->prepare("INSERT INTO voiture (modele, immatriculation, couleur, date_premiere_immatriculation, utilisateur_id, marque_id) VALUES(:modele, :immatriculation, :couleur, :date_premiere_immatriculation, 1, 1)");
            $stmt->bindParam(':modele', $modeleForm);
            $stmt->bindParam(':immatriculation', $immatriculationForm);
            $stmt->bindParam(':couleur', $couleurForm);
            $stmt->bindParam(':date_premiere_immatriculation', $datePremiereImmatriculationForm);
            $stmt->execute();

            $stmt = $conn->prepare("INSERT INTO marque (libelle) VALUES(:marque)");
            $stmt->bindParam(':marque', $marqueForm);
            $stmt->execute();

            $stmt = $conn->prepare("UPDATE covoiturage SET nb_place = :nb_place");
            $stmt->bindParam(':nb_place', $nombreDePlacesForm);
            $stmt->execute();
        
        } catch (PDOException $pe) {
            die ("Message d'erreur $dbname :" . $pe->getMessage()."à la ligne ".$pe->getLine());
        }
    }
        ?>

<div>
            <form action="mon-compte.php" method="GET">
                <DIV>
                    <label for="lieu_depart">Adresse de départ</label>
                    <input type="text" id="lieu_depart" name ="lieu_depart" size="10" required>
                    <label for="lieu_arrivee">Adressse d'arrivee</label>
                    <input type="text" id="lieu_arrivee" name ="lieu_arrivee" size="10" required>
                    <label for="prix_personne">Prix</label>
                    <input type="number" id="prix_personne" name ="prix_personne" min="2" required>
                    <select>
                        <?php 
                
                            require_once 'pdoconfig.php';
                        
                            try {
                                $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                                echo "Connected to $dbname at $host successfully.";
            
                                $stmt = $conn->prepare("SELECT CONCAT(m.libelle, ' ', v.modele) AS CONCAT
                                FROM marque AS m
                                JOIN voiture AS v ON v.marque_id = m.marque_id
                                JOIN covoiturage AS c ON c.voiture_id = v.voiture_id;"
                                );
            
                                $stmt->execute();
            
                                $res = $stmt->fetchAll();

                                echo "Test";
                                foreach ($res as $row ) {
                                    echo $row['CONCAT'];
                                    echo "<OPTION>".$row['CONCAT']."</OPTION>";
                                }
            
                                } catch (PDOException $pe) {
                                    die ("Message d'erreur $dbname :" . $pe->getMessage()."à la ligne ".$pe->getLine());
                                }
                        ?>
                    </select>
                    <input type="submit" value="Ajouter trajet">
                </DIV>      
            </form>

            <?php


        require_once 'pdoconfig.php';

        if (isset($_GET['lieu_depart'])) {

        try {

            $lieuDepartForm = $_GET['lieu_depart'];
            $lieuArriveeForm = $_GET['lieu_arrivee'];
            $prixPersonneForm = $_GET['prix_personne'];
            

            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            echo "Connected to $dbname at $host successfully.";

            // PDO instantiation here
            $stmt = $conn->prepare("INSERT INTO covoiturage (lieu_depart, lieu_arrivee, prix_personne) VALUES(:lieu_depart, :lieu_arrivee, :prix_personne)");
            $stmt->bindParam(':lieu_depart', $lieuDepartForm);
            $stmt->bindParam(':lieu_arrivee', $lieuArriveeForm);
            $stmt->bindParam(':prix_personne', $prixPersonneForm);
            $stmt->execute();

        
        } catch (PDOException $pe) {
            die ("Message d'erreur $dbname :" . $pe->getMessage()."à la ligne ".$pe->getLine());
        }
    }
        ?>


        </div>

    
        <footer>
            <a href="ecoride@ecoride.fr">E-mail Ecoride</a>
            <a href="mentions@ecoride.fr">Mentions légales</a>
        </footer>
    </body>
</html>




