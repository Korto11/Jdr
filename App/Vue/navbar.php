<?php ob_start()?>
<?php if(isset($_SESSION['connected'])):?>
<header>
<ul>
    <li><a href="./">Accueil</a></li>
    <li><a href="./allpersonnages">Personnages</a></li>
    <li><a href="./ownpersonnages">Mes Personnages</a></li>
    <li><a href="./personnageadd">Créer un personnage</a></li>
    <li><?=$_SESSION['pseudo']?></li>
    <li><a href="./userdeconnexion">Deconnexion</a></li>
</ul>
<?php else:?>
<ul>
    <li><a href="./">Accueil</a></li>
    <li><a href="./useradd">Inscription</a></li>
    <li><a href="./userconnexion">Connexion</a></li>
</ul>
</header>
<?php endif;?>
<?php $navbar = ob_get_clean()?>