<section class="card">
<h2>Mon profil</h2>
<form data-ajax method="post" action="/profile">
<input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8') ?>">
<input type="text" name="headline" value="<?= htmlspecialchars($profile['headline'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Titre professionnel">
<textarea name="bio" placeholder="Bio"><?= htmlspecialchars($profile['bio'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
<input type="text" name="location" value="<?= htmlspecialchars($profile['location'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Localisation">
<input type="url" name="website" value="<?= htmlspecialchars($profile['website'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Site web">
<button type="submit">Mettre à jour</button>
</form>
</section>
