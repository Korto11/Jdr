<?php ob_start()?>
<?php if(isset($_SESSION['connected'])):?>
<div id="navbar">
    <a id="lobby" href="./"><img id="d20" src="./Public/asset/images/d20.png" alt="d20"></a>
    <div class ="navbar-menu">
        <a class ="navbar-item" href="./personnageadd">Créer un personnage</a>
        <a class ="navbar-item" href="./ownpersonnages">Mes Personnages</a>
        <a class ="navbar-item" href="./allpersonnages">Tout les Personnages</a>
    </div>
    <div id ="log">  
        <div id= "user"><?=$_SESSION['pseudo']?> </div>
        <a id= "sign-in" href="./userdeconnexion">DECONNEXION</a>
    </div>   
</div>
<?php else:?>
<div id="navbar">
    <a id="lobby" href="./"><img id="d20" src="./Public/asset/images/d20.png" alt="d20"></a>
    <div id="log">
        <a id= "sign-in" href="./useradd">INSCRIPTION</a>
        <a id= "sign-in" href="./userconnexion">CONNEXION</a>
    </div>
</div>
<?php endif;?>
<?php $navbar = ob_get_clean()?>