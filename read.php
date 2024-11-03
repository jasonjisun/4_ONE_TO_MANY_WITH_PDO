<?php
require 'db.php';

function getAllMarketers($pdo) {
    $sql = "SELECT * FROM marketers";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllClients($pdo) {
    $sql = "SELECT clients.*, marketers.name AS marketer_name FROM clients 
            JOIN marketers ON clients.marketer_id = marketers.id";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getClientById($pdo, $client_id) {
    $sql = "SELECT * FROM clients WHERE id = :client_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
