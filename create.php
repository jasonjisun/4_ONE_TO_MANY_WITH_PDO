<?php
require 'db.php';

function marketerExists($pdo, $email) {
    $sql = "SELECT COUNT(*) FROM marketers WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

function createMarketer($pdo, $name, $email) {
    if (marketerExists($pdo, $email)) {
        echo "Error: A marketer with this email already exists.";
        return false;
    }
    $sql = "INSERT INTO marketers (name, email) VALUES (:name, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);

    try {
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function createClient($pdo, $marketer_id, $client_name, $campaign_name, $budget) {
    $sql = "INSERT INTO clients (marketer_id, client_name, campaign_name, budget) VALUES (:marketer_id, :client_name, :campaign_name, :budget)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':marketer_id', $marketer_id, PDO::PARAM_INT);
    $stmt->bindParam(':client_name', $client_name);
    $stmt->bindParam(':campaign_name', $campaign_name);
    $stmt->bindParam(':budget', $budget);
    return $stmt->execute();
}
?>
