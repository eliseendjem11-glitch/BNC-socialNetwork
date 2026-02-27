<section class="card"><h2>Suggestions de connexions</h2>
<ul><?php foreach ($suggestions as $u): ?><li><?= htmlspecialchars($u['email'], ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($u['headline'] ?? '', ENT_QUOTES, 'UTF-8') ?></li><?php endforeach; ?></ul>
</section>
