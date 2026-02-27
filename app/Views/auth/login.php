<section class="card">
<h2>Connexion</h2>
<form data-ajax method="post" action="/login">
<input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8') ?>">
<input required type="email" name="email" placeholder="Email">
<input required type="password" name="password" placeholder="Mot de passe">
<button type="submit">Se connecter</button>
</form>
</section>
