<section class="card">
<h2>Publier</h2>
<form data-ajax method="post" action="/feed">
<input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8') ?>">
<textarea name="content" required placeholder="Partagez une actualité..."></textarea>
<select name="visibility"><option value="public">Public</option><option value="connections">Connexions</option><option value="private">Privé</option></select>
<button type="submit">Publier</button>
</form>
</section>
<section>
<?php foreach ($posts as $post): ?>
<article class="card">
<strong><?= htmlspecialchars($post['email'], ENT_QUOTES, 'UTF-8') ?></strong>
<p><?= nl2br(htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8')) ?></p>
<small>👍 <?= (int) $post['like_count'] ?> · 💬 <?= (int) $post['comment_count'] ?> · <?= htmlspecialchars($post['created_at'], ENT_QUOTES, 'UTF-8') ?></small>
</article>
<?php endforeach; ?>
</section>
