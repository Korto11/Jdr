<?php
namespace App\Controller;
use App\vue\Template;
use App\Model\Utilisateur;
use App\Utils\Utilitaire;
use App\Model\Personnage;
class PersonnageController extends Personnage{
    public function addPersonnage(){
        $error ="";
        if(isset($_POST['submit'])){
            if(!empty($_POST['nom_personnage']) AND !empty($_POST['histoire_personnage'])){
                $this->setNom(Utilitaire::cleanInput($_POST['nom_personnage']));
                $this->setHistoire(Utilitaire::cleanInput($_POST['histoire_personnage']));
                $this->setEquipement(Utilitaire::cleanInput($_POST['equipement_personnage']));
                $this->setStatut(true);
                $this->getAuteur()->setId(Utilitaire::cleanInput($_SESSION['id']));
                if($_FILES['photo_personnage']['tmp_name'] != ""){
                    $ext = Utilitaire::getFileExtension($_FILES['photo_personnage']['name']);
                        if($ext=='png' OR $ext =='PNG' OR $ext = 'jpg' OR $ext =='JPG'OR $ext =='jpeg' OR $ext == 'JPEG' OR $ext=='bmp' OR $ext=='BMP'){
                            $size = $_FILES['photo_personnage']['size'];
                            $maxsize = 300000;
                            if($size < $maxsize){
                                $uniqueName = uniqid('',true);
                                $_FILES['photo_personnage']['name'] = $uniqueName.".".$ext;
                                $this->setPhoto($_FILES['photo_personnage']['name']);
                                move_uploaded_file($_FILES['photo_personnage']['tmp_name'], './Public/asset/images/'.$_FILES['photo_personnage']['name']);
                            }
                            else {
                                $error ='le fichier est trop lourd ( taille de fichier max 300 ko )';
                            }
                        }
                        else{
                            $error = 'format incorrect';
                        }
                }
                else{
                    $this->setPhoto('test.png');
                }
                $perso = $this->findOneBy();
                if($perso){
                    $error = "Le personnage existe déja";
                }
                else{
                    $this->add();
                    $error = "Le personnage a été ajouté en BDD";
                }
            }
            else{
                $error = "Veuillez remplir tous les champs du formulaire";
            }
        }
        Template::render('navbar.php', 'footer.php','vueAddPersonnage.php','Création de Personnage',   
        ['script.js', 'main.js'],['style.css', 'form.css'],$error,);
    }
    public function getAllPersonnage(){
        $error = "";
        $persos = $this->findAll();
        if(empty($persos)){
            $error = "Il n'y à pas de personnages sur le site";
        }
        Template::render('navbar.php','footer.php','vueAllPersonnages.php','Tous les Personnages', 
        ['script.js', 'main.js'],['style.css', 'main.css'],$error,$persos);
    }

    public function getOwnPersonnage(){
        $error = "";
        $this->getAuteur()->setId(Utilitaire::cleanInput($_SESSION['id']));
        $persos = $this->findOwn();
        if(empty($persos)){
            $error = "Vous n'avez pas créé de personnages";
        }
        Template::render('navbar.php','footer.php','vueOwnPersonnages.php','Mes Personnages', 
        ['script.js', 'main.js'],['style.css', 'main.css'],$error,$persos);
    }


    public function deletePersonnage(){
        $error ="";
        //Tester si les paramètres $_GET['id_personnage'] et $_GET['auteur_id'] existes
        if(isset($_GET['id_fiche_personnage'])){
            if(!empty($_GET['id_fiche_personnage']) ){
                $this->setId(Utilitaire::cleanInput($_GET['id_fiche_personnage']));
                $perso = $this->find();
                if($perso){
                    //test si le formulaire est submit
                    if(isset($_POST['delete'])){
                        $this->delete();
                        $error = "le personnage à bien été supprimé";
                        header("Refresh:2; url=./ownpersonnages");
                    } else if (isset($_POST['cancel'])){
                        header("Refresh:2; url=./ownpersonnages");
                    }
                } else {
                    $error = "le personnage n'existe pas";
                }
            } else{
                $error = "Les valeurs des paramètres sont vides";
            }
        } else{
            $error = "Les paramètres sont invalides";
        }     
        Template::render('navbar.php','footer.php','vueDeletePersonnage.php','Supprimer le personnage',
        ['script.js', 'main.js'],['style.css', 'form.css'],$error,);
    }


    public function displayPersonnage(){
        $error ="";
        //Tester si les paramètres $_GET['id_personnage'] et $_GET['auteur_id'] existes
        if(isset($_GET['id_fiche_personnage'])){
            if(!empty($_GET['id_fiche_personnage']) ){
                $this->setId(Utilitaire::cleanInput($_GET['id_fiche_personnage']));
                $perso = $this->find();
                if($perso){
                   $data = [];
                   $data[0] = $perso;
                } else {
                    $error = "le personnage n'existe pas";
                }
            } else{
                $error = "Les valeurs des paramètres sont vides";
            }
        } else{
            $error = "Les paramètres sont invalides";
        }     
        Template::render('navbar.php','footer.php','vueDisplayPersonnage.php','Afficher le personnage',
        ['script.js', 'main.js'],['style.css', 'main.css'],$error,$data);
    }



    public function updatePersonnage(){
        $error ="";
        //tableau $data que l'on passe à la vue
        //Tester si les paramètres $_GET['id_personnage'] et $_GET['auteur_id'] existes
        if(isset($_GET['id_fiche_personnage'])){
            if(!empty($_GET['id_fiche_personnage'])){
                $this->setId(Utilitaire::cleanInput($_GET['id_fiche_personnage']));
                $perso = $this->find();
                //test si le personnage existe
                if($perso){
                    //injection des valeurs du personnage dans le tableau $data que l'on passe à la vue
                    $data[1] = $perso;
                    //test si le formulaire est submit
                    if(isset($_POST['submit'])){
                        //test si tous les champs sont bien remplis
                        if(!empty($_POST['nom_personnage']) AND !empty($_POST['histoire_personnage']) 
                        AND !empty($_POST['equipement_personnage'])){
                            $nom = Utilitaire::cleanInput($_POST['nom_personnage']);
                            $histoire = Utilitaire::cleanInput($_POST['histoire_personnage']);
                            $equipement = Utilitaire::cleanInput($_POST['equipement_personnage']);
                            if($_FILES['photo_personnage']['tmp_name'] != ""){
                                $ext = Utilitaire::getFileExtension($_FILES['photo_personnage']['name']);
                                    if($ext=='png' OR $ext =='PNG' OR $ext = 'jpg' OR $ext =='JPG'OR $ext =='jpeg' OR $ext == 'JPEG' OR $ext=='bmp' OR $ext=='BMP'){
                                        $size = $_FILES['photo_personnage']['size'];
                                        $maxsize = 300000;
                                        if($size < $maxsize){
                                            $uniqueName = uniqid('',true);
                                            $_FILES['photo_personnage']['name'] = $uniqueName.".".$ext;
                                            $this->setPhoto($_FILES['photo_personnage']['name']);
                                            move_uploaded_file($_FILES['photo_personnage']['tmp_name'], './Public/asset/images/'.$_FILES['photo_personnage']['name']);
                                        }
                                        else {
                                            $error ='le fichier est trop lourd ( taille de fichier max 300 ko )';
                                        }
                                    }
                                    else{
                                        $error = 'format incorrect';
                                    }
                            }
                            $this->setNom($nom);
                            $this->setHistoire($histoire);
                            $this->setEquipement($equipement);
                            $this->getAuteur()->setId($_SESSION['id']);
                            $this->update();
                            $error = "Le personnage a été mis jour";
                        }
                        //test les champs ne sont pas remplis
                        else{
                            $error = "Veuillez remplir tous les champs du formulaire";
                        }
                    }
                }
                //test le chocoblast n'existe pas
                else{
                    $error = "Le personnage n'existe pas";
                }
            }
            //Test les valeurs de paramètres $_GET sont vides
            else{
                $error = "Les valeurs des paramètres sont vides";
            } 
        }
        //Test les paramètres $_GET sont invalides
        else{
            $error = "Les paramètres sont invalides";
        }
        Template::render('navbar.php','footer.php','vueUpdatePersonnage.php','mise à jour de Personnage', 
        ['script.js', 'main.js'],['style.css', 'form.css'],$error,$data);
    }
    public function filterPersonnage(){
        $error = "";
        $persos = $this->filterAll(3);
        if($persos){
            if(isset($_POST['submit'])){
                if(!empty($_POST['filter'])){
                    $persos = $this->filterAll(Utilitaire::cleanInput($_POST['filter']));
                }
            }
        }
        else{
            $error = "La liste des chocoblast est vide ";
        }
        Template::render('navbar.php','footer.php','vueFilterAllPersonnages.php','Filtrer chocoblasts', 
        ['script.js', 'main.js'], ['style.css', 'main.css'],$error, $persos);
    }
}