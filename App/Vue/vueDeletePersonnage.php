<?php ob_start()?>
    <form action="" method="post">
        <p> Etes vous sûr de vouloir supprimer le personnage ?</p>
        <input id="submit" type="submit" value="Confirmer" name="delete">
        <input id="submit" type="submit" value="Annuler" name="cancel">
        <div class="span-footer"></div>
        <div><?=$error?></div>
    </form>
    <div class="span-footer"></div>
<?php $content = ob_get_clean()?>