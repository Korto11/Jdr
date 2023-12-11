<?php ob_start()?>
<div class = "main">
    <?php foreach($tab as $personnage):?>
        <div class="personnage-afficher">
            <div class = "perso">
                <img class = "tall" src="./Public/asset/images/<?=$personnage->getPhoto()?>">
                <div class ="infos-afficher">
                    <p><?=$personnage->getNom()?></p>
                    <p>Equipement du personnage : <?=$personnage->getEquipement()?></p>
                </div>
            </div> 
            <p>Histoire du personnage : <?=$personnage->getHistoire()?></p>
            <a href="javascript:history.back()"><button>Retour</button></a>
        </div>
       
    <?php endforeach?>
    <p><?=$error?></p>
</div>
<div class="span-footer"></div>
<?php $content = ob_get_clean()?>