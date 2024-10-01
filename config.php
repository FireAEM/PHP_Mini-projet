<?php
    // Configuration de la connexion à la base de données
    $host = 'localhost'; // Nom d'hôte, généralement localhost
    $db = 'guestbook';   // Nom de la base de données
    $user = 'php';       // Nom d'utilisateur de la base de données
    $pass = 'php';       // Mot de passe de la base de données

    try {
        // Création d'une nouvelle connexion PDO à la base de données
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        // Définir le mode d'erreur PDO pour lancer des exceptions
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Si la connexion échoue, afficher un message d'erreur
        die("Could not connect to the database: " . $e->getMessage());
    }
?>