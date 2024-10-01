<?php
    session_start();
    require 'config.php'; // Inclut le fichier de configuration de la base de données

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupère les données du formulaire
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Préparation et exécution de la requête pour récupérer l'utilisateur
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(); // Récupère l'utilisateur

        // Vérifie si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($password, $user['password'])) {
            // Stocke les informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
            exit;
        } else {
            $_SESSION['error'] = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }
?>

<!-- Formulaire de connexion -->
<p><a href="index.php">Retour à l'accueil</a> | <a href="register.php">S'inscrire</a></p>

<form method="POST" action="">
    <input type="text" name="username" placeholder="Nom d'utilisateur" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
</form>

<!-- Affichage des erreurs de connexion -->
<?php if (isset($_SESSION['error'])): ?>
    <p style="color:red;"><?= htmlspecialchars($_SESSION['error']); ?></p>
    <?php unset($_SESSION['error']); // Efface l'erreur après l'affichage ?>
<?php endif; ?>