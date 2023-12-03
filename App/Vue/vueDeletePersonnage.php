<?php ob_start()?>
    <form action="" method="post">
        <p> Etes vous sûr de vouloir supprimer le personnage ?</p>
        <input type="submit" value="Confirmer" name="delete">
        <input type="submit" value="Annuler" name="cancel">
        <div><?=$error?></div>
    </form>
<?php $content = ob_get_clean()?>