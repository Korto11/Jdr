<?php ob_start()?>
<div class = "main">
    <?php foreach($tab as $personnage):?>
        <div class="personnage">
            <img  src="./Public/asset/images/<?=$personnage->getPhoto()?>">
            <p><?=$personnage->getNom()?></p>
            <p>Histoire du personnage : <?=$personnage->getHistoire()?></p>
            <p>Equipement du personnage : <?=$personnage->getEquipement()?></p>
            <a href="javascript:history.back()"><button>Retour</button></a>
        </div>
    <?php endforeach?>
    <p><?=$error?></p>
</div>
<?php $content = ob_get_clean()?>