<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../config/google_oauth.php';

// Générer un state aléatoire anti-CSRF
$state = bin2hex(random_bytes(16));
$_SESSION['oauth_state'] = $state;

// Construire l'URL d'autorisation Google
$params = http_build_query([
    'client_id'     => GOOGLE_CLIENT_ID,
    'redirect_uri'  => GOOGLE_REDIRECT_URI,
    'response_type' => 'code',
    'scope'         => 'openid email profile',
    'state'         => $state,
    'prompt'        => 'select_account',
]);

header('Location: ' . GOOGLE_AUTH_URL . '?' . $params);
exit;
