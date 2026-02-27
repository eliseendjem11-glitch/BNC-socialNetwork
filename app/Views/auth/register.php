<section class="card">
<h2>Inscription</h2>
<form data-ajax method="post" action="/register">
<input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8') ?>">
<input required type="email" name="email" placeholder="Email">
<input required type="password" name="password" placeholder="Mot de passe (8+)" minlength="8">
<select name="role"><option value="user">Utilisateur</option><option value="recruiter">Recruteur</option></select>
<button type="submit">Créer mon compte</button>
</form>
</section>
