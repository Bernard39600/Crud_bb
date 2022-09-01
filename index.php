<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page principale</title>
    <link href="style2.css" rel="stylesheet" type="text/css">
</head>

<body>
    <nav class="navtop">
        <div>
            <h1>CRUD conciergerie</h1>
            <?php
            session_start();
            if (isset($_SESSION['nom_user'])) {
                echo " <a href='./logout.php'>Se déconnecter</a>";
            } else {
                header('Location: ./login.php');
            }
            ?>
        </div>
    </nav>
    <?php
    // connexion à la fonction: load base de donnees
    $DB = new connexionDB();
    ?>
</body>

<?php

class connexionDB
{
    private $host    = 'localhost';
    private $name    = 'crud_concierge';
    private $user    = 'root';
    private $pass    = '';
    private $connexion;

    function __construct($host = null, $name = null, $user = null, $pass = null)
    {
        if ($host != null) {
            $this->host = $host;
            $this->name = $name;
            $this->user = $user;
            $this->pass = $pass;
        }
        try {
            // sans 'port=3307' :
            // $this->connexion = new PDO("mysql:host=$host;dbname=$name", $user, $pass);

            $this->connexion = new PDO(
                'mysql:host=' . $this->host . ';port=3307;dbname=' . $this->name,
                $this->user,
                $this->pass,
                array(
                    // PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
                    PDO::FETCH_ASSOC => 'id, date, intervention, etage'
                )
            );
        } catch (PDOException $e) {
            echo 'Erreur: Impossible de se connecter à la BDD !';
            die();
        }
    }
    public function query($sql, $data = array())
    {
        $req = $this->connexion->prepare($sql);
        $req->execute($data);

        return $req;
    }
}
// trier par colonne, order by id par defaut
// recup valeur $modeDeTri recup ds menu deroulant: ORDER BY $modeDeTri

// if ($ModeDeTri=="") {
//     $req = $DB->query("SELECT * FROM crud_concierge_i ORDER BY id");
//     $req = $req->fetchAll();
//     effacer: $modeDeTri=""
// } else {
//     echo $ModeDeTri;
//     $req = $DB->query($ModeDeTri); 
// }

// $ModeDeTri = "SELECT * FROM crud_concierge_i ORDER BY id";
// $req = $DB->query($ModeDeTri);
$req = $DB->query("SELECT * FROM crud_concierge_i ORDER BY id");
$req = $req->fetchAll();

?>

<div class="content read">
    <h2>Tableau des interventions de <?= $_SESSION['nom_user'] ?> </h2>

    <table>
        <thead>
            <tr>
                <td>Index</td>
                <td>Date</td>
                <td>Type d'intervention</td>
                <td>Etage</td>
                <td>
                    <nav class="MenuD1">
                        <ul>
                            <li class="deroulant"><a>Trier par</a>
                                <ul class="sous">
                                    <li><a href="index.php" <?= $ModeDeTri="SELECT * FROM crud_concierge_i ORDER BY id" ?>>Index</a></li>
                                    <li><a href="index.php" <?= $ModeDeTri="date" ?>>Date</a></li>
                                    <li><a href="index.php" <?= $ModeDeTri="intervention" ?>>Intervention</a></li>
                                    <li><a href="index.php" <?= $ModeDeTri="etage" ?>>Etage</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </td>
            </tr>
        </thead>

        <tbody>

            <!-- affichage tableau -->
            <?php for ($i = 0; $i < count($req); $i++) {
                $index = strval($i);
            ?>
                <tr>
                    <td><?= $req[$i]['id'] ?></td>
                    <td><?= $req[$i]['date'] ?></td>
                    <td><?= $req[$i]['intervention'] ?></td>
                    <td><?= $req[$i]['etage'] ?></td>

                    <form action="delete.php" method="get">
                        <td class="btn_delete"><button class="trash"><a href="delete.php?ToDelete=<?= $req[$i]['id'] ?>">Supprimer</a></button></td>
                    </form>
                </tr>
            <?php }
            ?>

        </tbody>
    </table>

    <table>

        <form action="newdata.php" method="post">
            <h2>Ajouter une intervention</h2>
            <input type="date" name="date" placeholder="Date">
            <input type="text" name="intervention" placeholder="Intervention">
            <input type="number" name="etage" placeholder="Etage">
            <br>
            <button class="create"> Ajouter </button>
        </form>
    </table>

</div>

</html>