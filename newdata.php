<!-- ajouter data: -->

<?php
include 'connect.php';

// verif formulaire rempli
if (isset($_POST['date']) && isset($_POST['intervention']) && isset($_POST['etage'])) {

    $date = $_POST['date'];
    $intervention = $_POST['intervention'];
    $etage = $_POST['etage'];

    // envoi des donnees
    $sth = connect2()->prepare("
            INSERT INTO crud_concierge_i (id, date, intervention, etage)
            VALUES (NULL, :date, :intervention, :etage)");

    $sth->bindParam(':date', $date,  PDO::PARAM_STR);
    $sth->bindParam(':intervention', $intervention,  PDO::PARAM_STR);
    $sth->bindParam(':etage', $etage,  PDO::PARAM_STR);
    $sth->execute();
    // $sth->debugDumpParams();
}

header('Location: index.php');

?>