<?php ob_start()?>
    <form action="" method="post"  enctype="multipart/form-data">
        <label for="nom_personnage">Saisir le nom de votre personnage :</label>
        <input type="text" name="nom_personnage">
        <label for="histoire_personnage">Décrivez l'histoire de votre personnage :</label>
        <input type="text" name="histoire_personnage" id="histoire_input">
        <label for="equipement_personnage">Que possède votre personnage ?</label>
        <input type="text" name="equipement_personnage">
        <label for="photo_personnage">A quoi ressemble votre personnage ?</label>
        <input type="file" name="photo_personnage">
        <input type="submit" value="Création" name="submit">
        <div><?=$error?></div>
 
    </form>
<?php $content = ob_get_clean()?>