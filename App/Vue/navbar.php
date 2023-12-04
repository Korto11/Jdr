<?php ob_start()?>
<?php if(isset($_SESSION['connected'])):?>
<header>
<div id="navbar">
    <div class ="navbar-item">
        <a href="./">Accueil</a>
    </div>
    <div class ="navbar-item">
        <a href="./ownpersonnages">Mes Personnages</a>
    </div>     
    <div class ="navbar-item">
        <a href="./personnageadd">Créer un personnage</a>
    </div>   
    <div class ="navbar-item">
        <?=$_SESSION['pseudo']?>
    </div>
    <div class ="navbar-item">
        <a href="./userdeconnexion">Deconnexion</a>
    </div>  
</div>
<?php else:?>
<div id="navbar">
    <a class ="navbar-item" id="lobby" href="./">Accueil</a>
    <div class ="navbar-item" id="sign-in">
        <a href="./useradd">Inscription</a>
        <a href="./userconnexion">Connexion</a>
    </div>
</div>
</header>
<?php endif;?>
<?php $navbar = ob_get_clean()?>