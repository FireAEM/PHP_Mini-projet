<?php
    session_start(); // Démarre ou reprend une session existante
    session_unset(); // Libère toutes les variables de session
    session_destroy(); // Détruit la session
    header('Location: index.php'); // Redirection vers la page d'accueil
    exit;
?>