<?php ob_start()?>
    <h1> CRÉER UN PERSONNAGE</h1>
    <div><?=$error?></div>
    <form action="" method="post"  enctype="multipart/form-data">
        <label for="nom_personnage">Saisir le nom de votre personnage :</label>
        <input type="text" name="nom_personnage">
        <label for="histoire_personnage">Décrivez l'histoire de votre personnage :</label>
        <textarea cols="60" rows="10" type="text" name="histoire_personnage" id="histoire_input">Ici commence la légende ...
        </textarea>
        <label for="equipement_personnage">Que possède votre personnage ?</label>
        <textarea cols="60" rows="10" type="text" name="equipement_personnage" >Vérifie que t'as tes clefs,ton portefeuille et ton cracheur ...
        </textarea>
        <label for="photo_personnage">A quoi ressemble votre personnage ?</label>
        <input type="file" name="photo_personnage">
        <input id="submit" type="submit" value="Création" name="submit">
    </form> 
<?php $content = ob_get_clean()?>