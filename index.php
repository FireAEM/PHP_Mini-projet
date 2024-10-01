<?php
    session_start();
    require 'config.php'; // Inclut le fichier de configuration de la base de données

    // Soumission d'un message
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
        $message = trim($_POST['message']); // Récupère le message

        if (!empty($message)) {
            // Préparation et exécution de la requête pour insérer le message
            $stmt = $pdo->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
            $stmt->execute([$_SESSION['user_id'], $message]);
        } else {
            $_SESSION['error'] = "Le message ne peut pas être vide.";
        }
    }

    // Affichage des messages
    $stmt = $pdo->query("SELECT messages.*, users.username FROM messages JOIN users ON messages.user_id = users.id ORDER BY created_at DESC");
    $messages = $stmt->fetchAll(); // Récupère tous les messages
?>

<h1><a href="index.php" style="text-decoration : none; color : black;">Livre d'or</a></h1>

<?php if (isset($_SESSION['username'])): ?>
    <p>Connecté en tant que <strong><?= htmlspecialchars($_SESSION['username']); ?></strong></p>
    <!-- Formulaire pour soumettre un message -->
    <form method="POST" action="">
        <textarea name="message" placeholder="Écrivez votre message ici..." required></textarea>
        <button type="submit">Soumettre</button>
    </form>
    <a href="logout.php">Se déconnecter</a>
<?php else: ?>
    <a href="login.php">Se connecter</a> | <a href="register.php">S'inscrire</a>
<?php endif; ?>

<!-- Affichage des erreurs lors de la soumission de message -->
<?php if (isset($_SESSION['error'])): ?>
    <p style="color:red;"><?= htmlspecialchars($_SESSION['error']); ?></p>
    <?php unset($_SESSION['error']); // Efface l'erreur après l'affichage ?>
<?php endif; ?>

<!-- Affichage des messages -->
<?php foreach ($messages as $msg): ?>
    <p><strong><?= htmlspecialchars($msg['username']) ?> :</strong> <?= htmlspecialchars($msg['message']) ?> <em>(<?= $msg['created_at'] ?>)</em></p>
<?php endforeach; ?>