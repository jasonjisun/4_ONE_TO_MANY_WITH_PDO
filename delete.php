<?php
require 'db.php';

function deleteClient($pdo, $client_id) {
    $sql = "DELETE FROM clients WHERE id = :client_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
    return $stmt->execute();
}
?>
