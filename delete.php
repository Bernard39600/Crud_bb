<?php

// function delete()
// {
    include 'connect.php';
    $ToDelete=$_GET["ToDelete"];
    
    $query = connect2()->prepare("DELETE FROM crud_concierge_i WHERE id=:id_delete");
    $query->bindValue("id_delete", $ToDelete, PDO::PARAM_INT);
    $query->execute();
    $query->debugDumpParams();
    header('Location: index.php');
// }
?>