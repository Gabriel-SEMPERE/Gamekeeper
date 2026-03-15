<?php
$url = $_GET['url'] ?? 'home';

$url = explode('/', $url);

$controller = ucfirst($url[0]) . 'Controller';
$method = $url[1] ?? 'index';
$controllerFile = "../app/Controllers/$Controller.php";
if (file_exists($controllerFile)) {
    require $controllerFile;

    $controllerObject = new $controller();

    if (method_exists($controllerObject, $method)) {
        $controllerObject->$method();
    } else {
        echo "Méthode introuvable";
    }

} else {
    echo "Controller introuvable";
}
?>
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=H, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <a href="/users/register">s'inscrire</a>
        <a href="/users/login">connexion</a>
    </header>
    <main>
    <div class =" titre">
        <h1>Bienvenue sur Gamekeeper</h1>
    </div>
    <section class = "button">
        <a href="">
            <button class="btn" name="btn">commencer</button>
        </a>
    </section>
</main>
    <footer></footer>
</body>
</html>