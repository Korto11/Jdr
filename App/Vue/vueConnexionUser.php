<?php ob_start()?>
    <h1>CONNEXION</h1>
    <form action="" method="post">
        <label for="mail_utilisateur">Saisir son email</label>
        <input type="email" name="mail_utilisateur">
        <label for="password_utilisateur">Saisir son mot de passe</label>
        <input type="password" name="password_utilisateur">
        <input id="submit" type="submit" value="Connexion" name="submit">
    </form>
    <?=$error?>
    <div class="span-footer"></div>
<?php $content = ob_get_clean()?>