
<?php 
session_start();
require_once 'config/Database.php';

$database = new Database();
$conn = $database->getConnection();

$message["etat"] = true;
$message['message'] = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $pseudo = htmlspecialchars($_POST["pseudo"]);
    $mot_de_passe = $_POST["mot_de_passe"];
    $confirmation = $_POST["confirmation"];

    if (!empty($pseudo) && !empty($mot_de_passe) && !empty($confirmation)) {

        if ($mot_de_passe === $confirmation) {

            
            $sql = "SELECT id FROM users WHERE username = :pseudo";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":pseudo", $pseudo,PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {

                $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (username, password) VALUES (:pseudo, :password)";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(":pseudo", $pseudo);
                $stmt->bindValue(":password", $mot_de_passe_hash);

                if ($stmt->execute()==true) {
                 
                    $message["message"] = "Inscription réussie !";
                    $message["etat"] = true;

                    
                } else {
                    $message["message"] = "Erreur lors de l'inscription";
                    $message["etat"] = false;

                }

             }else {
                $message["message"] = "Ce pseudo existe déjà";
                $message["etat"] = false;
                
            }

        } else {
            $message["message"] = "Les mots de passe ne correspondent pas";
            $message["etat"] = false;
            
        }

    } else {
        $message["message"] = "Veuillez remplir tous les champs";
        $message["etat"] = false;
        
    }
}
?>

<?php require_once 'views/header.php'; ?>

<main class="contenu-principal">

    <div class="rectangle-formulaire">

        <h2 class="titre-formulaire">S'inscrire</h2>

        <form method="POST">

            <label>Pseudo</label>
            <input type="text" name="pseudo">

            <label>Mot de passe</label>
            <input type="password" name="mot_de_passe">

            <label>Confirmer le mot de passe</label>
            <input type="password" name="confirmation">

            <button type="submit">S'inscrire</button>

        </form>

        <p class="message-erreur"><?php
            if($message['etat'] == false) echo $message['message']; ?></p>
        <p class="message-reussie"><?php 
            if($message['etat'] == true) echo $message['message']; ?></p>

        <p class="texte-connexion">
            Déjà un compte ?
            <a href="login.php">Se connecter</a>
        </p>

    </div>

</main>

<?php require_once 'views/footer.php'; ?>


?>




