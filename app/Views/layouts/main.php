<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'BNC', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<header class="topbar">
    <a href="/" class="brand">BNC</a>
    <nav>
        <a href="/feed">Feed</a>
        <a href="/network">Réseau</a>
        <a href="/messages">Messages</a>
        <a href="/companies">Entreprises</a>
        <a href="/jobs">Jobs</a>
        <?php if ($authUser): ?>
            <a href="/profile">Profil</a>
            <form method="post" action="/logout" class="inline-form">
                <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8') ?>">
                <button type="submit">Déconnexion</button>
            </form>
        <?php else: ?>
            <a href="/login">Connexion</a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">
    <?php if (!empty($flash)): ?><div class="flash"><?= htmlspecialchars($flash, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
    <?php require $templatePath; ?>
</main>
<script src="/assets/js/app.js"></script>
</body>
</html>
