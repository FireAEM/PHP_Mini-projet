<?php
    session_start();
    require 'config.php'; // Inclut le fichier de configuration de la base de données

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupère les données du formulaire
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Validation des champs
        if (!empty($username) && !empty($password)) {
            // Vérifie la longueur du mot de passe
            if (strlen($password) < 5) {
                $_SESSION['error'] = "Le mot de passe doit contenir au moins 5 caractères.";
            } else {
                // Hachage du mot de passe avant de le stocker
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Préparation et exécution de la requête pour insérer l'utilisateur
                $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                if ($stmt->execute([$username, $hashedPassword])) {
                    $_SESSION['message'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                    header('Location: login.php');
                    exit;
                } else {
                    $_SESSION['error'] = "Une erreur est survenue lors de l'inscription.";
                }
            }
        } else {
            $_SESSION['error'] = "Tous les champs doivent être remplis.";
        }
    }
?>

<!-- Formulaire d'inscription -->
<p><a href="index.php">Retour à l'accueil</a> | <a href="login.php">Se connecter</a></p>

<form method="POST" action="">
    <input type="text" name="username" placeholder="Nom d'utilisateur" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">S'inscrire</button>
</form>

<!-- Affichage des erreurs d'inscription -->
<?php if (isset($_SESSION['error'])): ?>
    <p style="color:red;"><?= htmlspecialchars($_SESSION['error']); ?></p>
    <?php unset($_SESSION['error']); // Efface l'erreur après l'affichage ?>
<?php endif; ?>