<?php
// Include database connection and CRUD functions
require 'db.php';
require 'create.php';
require 'read.php';
require 'update.php';
require 'delete.php';

// Handle form submissions for creating marketer and client
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create_marketer'])) {
        // Create new marketer with name and email
        createMarketer($pdo, $_POST['name'], $_POST['email']);
    } elseif (isset($_POST['create_client'])) {
        // Create new client
        createClient(
            $pdo,
            $_POST['marketer_id'],
            $_POST['client_name'],
            $_POST['campaign_name'],
            $_POST['budget']
        );
    } elseif (isset($_POST['update_client'])) {
        // Update client details
        updateClient(
            $pdo,
            $_POST['id'],
            $_POST['marketer_id'],
            $_POST['client_name'],
            $_POST['campaign_name'],
            $_POST['budget']
        );
    }
}

// Handle delete requests for clients
if (isset($_GET['delete_client'])) {
    deleteClient($pdo, $_GET['delete_client']);
}

// Fetch all marketers and clients
$marketers = getAllMarketers($pdo);
$clients = getAllClients($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Business App</title>
</head>
<body>

<h1>Business Application</h1>

<!-- Marketer Addition Form -->
<h2>Add New Marketer</h2>
<form method="POST" action="index.php">
    <label for="name">Marketer Name:</label>
    <input type="text" name="name" required><br>
    
    <label for="email">Marketer Email:</label>
    <input type="email" name="email" required><br><br>

    <button type="submit" name="create_marketer">Add Marketer</button>
</form>

<!-- Client Addition Form -->
<h2>Add New Client</h2>
<form method="POST" action="index.php">
    <label for="marketer_id">Select Marketer:</label>
    <select name="marketer_id" required>
        <?php foreach ($marketers as $marketer): ?>
            <option value="<?php echo htmlspecialchars($marketer['id']); ?>">
                <?php echo htmlspecialchars($marketer['name']); ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <label for="client_name">Client Name:</label>
    <input type="text" name="client_name" required><br>
    
    <label for="campaign_name">Campaign Name:</label>
    <input type="text" name="campaign_name" required><br>
    
    <label for="budget">Budget:</label>
    <input type="number" step="0.01" name="budget" required><br><br>
    
    <button type="submit" name="create_client">Add Client</button>
</form>

<!-- List of Clients with Delete and Update Options -->
<h2>Client List</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Client Name</th>
            <th>Campaign Name</th>
            <th>Budget</th>
            <th>Marketer</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients as $client): ?>
            <tr>
                <td><?php echo htmlspecialchars($client['id']); ?></td>
                <td><?php echo htmlspecialchars($client['client_name']); ?></td>
                <td><?php echo htmlspecialchars($client['campaign_name']); ?></td>
                <td><?php echo htmlspecialchars($client['budget']); ?></td>
                <td><?php echo htmlspecialchars($client['marketer_name']); ?></td>
                <td>
                    <a href="index.php?edit_client=<?php echo $client['id']; ?>">Edit</a>
                    |
                    <a href="index.php?delete_client=<?php echo $client['id']; ?>" onclick="return confirm('Are you sure you want to delete this client?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
