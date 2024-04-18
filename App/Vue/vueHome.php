<?php ob_start()?>
<div class = 'main'>
    <h1>RED TOOLS</h1>
    <div class="home">
        <h2>Bienvenue dans l'ère du Rouge !</h2>
        <p>Ce site s'adresse à tout les amateurs du jeu de rôle: Cyberpunk RED, souhaitant partager des idées de personnages et de scénarios. Le site permet la création et le partage de personnages, qu'ils s'agissent de personnage joueur à incarner ou non joueurs pour animer vos scénarios. <br><br>Une partie permet aussi de partager différent scénario auxquels vous auriez déja participer afin de donner des idées à d'autres joueurs ou de trouver de nouvelles aventures pour vous et vos amis. Enfin, des outils pour les maîtres du jeu, comme le générateur de noms d'objet, afin de facilement rendre les parties plus immersives en trouvant facilement des intitulés d'armes ou autres et ne pas se contenter d'appelations générique.  </p>
        <a  href="./allpersonnages"><button class="home-button" >LES PERSONNAGES</button></a>
        <a  href="" ><button class="home-button">LES SCENARIOS</button></a>
        <a  href=""><button class="home-button" >GÉNÉRATEUR D'OBJETS</button></a>
    </div>
    <div class="span-footer"></div>  
</div>

<?php $content = ob_get_clean()?>