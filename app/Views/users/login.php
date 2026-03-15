<?php

session_start();
require_once 'config/Database.php';

$database = new Database();
$conn = $database->getConnection();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $pseudo = htmlspecialchars($_POST["pseudo"]);
    $mot_de_passe = $_POST["mot_de_passe"];

    if (!empty($pseudo) && !empty($mot_de_passe)) {

        $sql = "SELECT * FROM users WHERE username = :pseudo";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":pseudo", $pseudo);
        $stmt->execute();

        $user = $stmt->fetch();

        if ($user && password_verify($mot_de_passe, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];

            header("Location: index.php");
            exit();

        } else {
            $message = "Pseudo ou mot de passe incorrect";
        }

    } else {
        $message = "Veuillez remplir tous les champs";
    }
}
?>

<?php require_once 'views/header.php'; ?>

<main class="contenu-principal">

    <div class="rectangle-formulaire">
        <h2 class="titre-formulaire">Se connecter</h2>

        <form method="POST">

            <label>Pseudo</label>
            <input type="text" name="pseudo">

            <label>Mot de passe</label>
            <input type="password" name="mot_de_passe">

            <button type="submit">Se connecter</button>

        </form>

        <p class="message-erreur"><?php echo $message; ?></p>
    </div>

</main>

<?php require_once 'views/footer.php'; ?>


?>