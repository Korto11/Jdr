<?php ob_start()?>
<h1>MES PERSONNAGES</h1>
<div class = "main">
    
    <?php foreach($tab as $personnage):?>
    <div class="personnage">
        <img class="mini" src="./Public/asset/images/<?=$personnage->getPhoto()?>">
        <div class="infos">
            <p><?=$personnage->getNom()?></p>
            <div class="boutons">
                <a href='./personnagedisplay?id_fiche_personnage=<?=$personnage->getId()?>'><button>afficher</button></a>
                <a href='./personnageupdate?id_fiche_personnage=<?=$personnage->getId()?>&auteur_personnage=<?=$personnage->auteur_personnage?>'><button>modifier</button></a>
                <a href='./personnagedelete?id_fiche_personnage=<?=$personnage->getId()?>'><button>supprimer</button></a>
            </div>
        </div>
    </div>
    <?php endforeach?>
    <p><?=$error?></p>
</div>
<div class="span-footer"></div>
<?php $content = ob_get_clean()?>