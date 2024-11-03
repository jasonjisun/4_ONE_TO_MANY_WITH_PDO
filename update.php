<?php
require 'db.php';

function updateClient($pdo, $client_id, $marketer_id, $client_name, $campaign_name, $budget) {
    $sql = "UPDATE clients SET marketer_id = :marketer_id, client_name = :client_name, campaign_name = :campaign_name, budget = :budget WHERE id = :client_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':marketer_id', $marketer_id, PDO::PARAM_INT);
    $stmt->bindParam(':client_name', $client_name);
    $stmt->bindParam(':campaign_name', $campaign_name);
    $stmt->bindParam(':budget', $budget);
    $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
    return $stmt->execute();
}
?>
