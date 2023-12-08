<?php ob_start()?>
    <h1>INSCRIPTION</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="nom_utilisateur">Saisir le pseudo:</label>
        <input type="text" name="pseudo_utilisateur">
        <label for="mail_utilisateur">Saisir le mail:</label>
        <input type="email" name="mail_utilisateur">
        <label for="password_utilisateur">Saisir le Password:</label>
        <input type="password" name="password_utilisateur">
        <label for="repeat_password_utilisateur">Re saisir le Password:</label>
        <input type="password" name="repeat_password_utilisateur">
        <input id="submit" type="submit" value="Ajouter" name="submit">
    </form>
    <div><?=$error?></div>
<?php $content = ob_get_clean()?>