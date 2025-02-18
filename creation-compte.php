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

        <div>
            <form action="creation-compte.php" method="GET">
            <label for="pseudo">Pseudo</label>
            <input type="text" id="pseudo" name ="pseudo" size="10" required>
            <label for="email">E-mail</label>
            <input type="text" id="email" name ="email" size="10" required>
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name ="password" required>
            <input type="submit" value="S'inscrire">
            </form>
        </div>

        <?php


        require_once 'pdoconfig.php';

        try {
            
            if(isset($_GET['pseudo'])) {

                $pseudoForm = $_GET['pseudo'];
                $emailForm = $_GET['email'];
                $passwordForm = $_GET['password'];

                echo "Pseudo :".$pseudoForm;
        
                $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                echo "Connected to $dbname at $host successfully.";

                // PDO instantiation here
                $stmt = $conn->prepare('SELECT COUNT(email) AS EmailCount FROM utilisateur WHERE email = :email');
                $stmt->execute(array('email' => $_GET['email']));
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result['EmailCount'] == 0) {
                    $stmt = $conn->prepare("INSERT INTO utilisateur (pseudo, email, password) VALUES(:pseudo,:email,:password)");
                    $stmt->bindParam(':pseudo', $pseudoForm);
                    $stmt->bindParam(':email', $emailForm);
                    $stmt->bindParam(':password', $passwordForm);
                    $stmt->execute();
                    echo 'Merci de vous être inscrit.';
                } else {
                    echo "L'Email existe!";
                }
            }
        } catch (PDOException $pe) {
            die ("Message d'erreur $dbname :" . $pe->getMessage()."à la ligne ".$pe->getLine());
        }
        ?>

        <div>
            <form action="mon-compte.php" method="GET">
            <label for="email">E-mail</label>
            <input type="text" id="email" name ="email" size="10" required>
            <label for="password">Mot de passe</label>
            <input type="text" id="password" name ="password" size="10" required>
            <input type="submit" value="Se connecter">
            </form>
        </div>


        



    
        <footer>
            <a href="ecoride@ecoride.fr">E-mail Ecoride</a>
            <a href="mentions@ecoride.fr">Mentions légales</a>
        </footer>
    </body>
</html>