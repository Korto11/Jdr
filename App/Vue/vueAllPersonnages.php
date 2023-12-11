<?php ob_start()?>
<h1>LES PERSONNAGES</h1>
<div class = "main">
    
    <?php foreach($tab as $personnage):?>
        <div class="personnage">
            <img class="mini" src="./Public/asset/images/<?=$personnage->getPhoto()?>">
            <div class ="infos">
                <p><?=$personnage->getNom()?></p>
                <div class ="boutons">
                    <p>Auteur : <?= $personnage->auteur_pseudo?></p>
                    <a id="afficher" href='./personnagedisplay?id_fiche_personnage=<?=$personnage->getId()?>'><button>afficher</button></a>
                </div>
            </div>
        </div>
    <?php endforeach?>
    <p><?=$error?></p>
</div>
<div class="span-footer"></div>
<?php $content = ob_get_clean()?>