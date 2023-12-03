<?php ob_start()?>
<form action="" method="post"  enctype="multipart/form-data">
        <label for="nom_personnage">Saisir le nom de votre personnage :</label>
        <input type="text" name="nom_personnage" value="<?= $tab[1]->getNom() ?>">
        <label for="histoire_personnage">Décrivez l'histoire de votre personnage :</label>
        <input type="text" name="histoire_personnage" value="<?= $tab[1]->getHistoire() ?>" id="big_input">
        <label for="equipement_personnage">Que possède votre personnage ?</label>
        <input type="text" name="equipement_personnage"value="<?= $tab[1]->getEquipement() ?>">
        <label for="photo_personnage">A quoi ressemble votre personnage ?</label>
        <input type="file" name="photo_personnage" value="<?= $tab[1]->getPhoto() ?>">
        <input type="submit" value="Modification" name="submit">
        <div><?=$error?></div>
    </form>
<?php $content = ob_get_clean()?>