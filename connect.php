<!-- login & register compte utilisateur -->
<?php
session_start();
function connect()
{
    $servername = 'localhost';
    $username = 'root';
    $dbname = 'data_utilisateurs';
    $password = '';

    try {
        $db = new PDO("mysql:host=$servername;port=3307;dbname=$dbname", $username, $password);
        echo 'Connexion réussie! ' . '<br>';
        return $db;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}

function connect2()
{
    $servername = 'localhost';
    $username = 'root';
    $dbname = 'crud_concierge';
    $password = '';

    try {
        $db = new PDO("mysql:host=$servername;port=3307;dbname=$dbname", $username, $password);
        echo 'Connexion réussie! ' . '<br>';
        return $db;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}

function register()
{
    $pass = password_hash($_POST['password'],  PASSWORD_DEFAULT);
    $login = $_POST['username'];
    $name = $_POST['fullname'];

    $ajouter = connect()->prepare('INSERT INTO data_utilisateurs (login_user, password_user, nom ) VALUES (:login_user, :password_user, :nom)');
    $ajouter->bindParam(
        ':login_user',
        $login,
        PDO::PARAM_STR
    );
    $ajouter->bindParam(
        ':password_user',
        $pass,
        PDO::PARAM_STR
    );
    $ajouter->bindParam(
        ':nom',
        $name,
        PDO::PARAM_STR
    );
    $estceok = $ajouter->execute();
    $ajouter->debugDumpParams();
    if ($estceok) {
        header('Location: ./index.php');
    } else {
        echo 'Erreur enregistrement';
    }
}

function login()
{

    // login bb code 1234

    $findUser = connect()->prepare('SELECT * FROM data_utilisateurs WHERE login_user = :login_user');
    $findUser->bindParam(':login_user', $_POST['username'], PDO::PARAM_STR);
    $findUser->execute();
    $user = $findUser->fetch();

    if ($user && password_verify($_POST['password'], $user['password_user'])) {
        $_SESSION['nom_user'] = $user['nom'];
        header('Location: ./index.php');
    } else {
        echo 'Erreur username ou password';
        var_dump($user);
        echo password_verify($_POST['password'], $user['password_user']);
    }
}

if (isset($_POST['action']) && !empty($_POST['username'])  && !empty($_POST['password'])  && $_POST['action'] == "register") {
    register();
}

if (isset($_POST['action']) && !empty($_POST['username'])  && !empty($_POST['password'])  && $_POST['action'] == "login") {
    login();
}

function logout()
{
    session_start();
    session_destroy();
    header('Location: ./index.php');
}
