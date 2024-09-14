<?php
namespace App\Controller;
use App\vue\Template;
use App\Model\Utilisateur;
use App\Utils\Utilitaire;
use App\Model\Personnage;
class PersonnageController extends Personnage{
    public function addPersonnage(){
        $error ="";
        if(isset($_POST['submit']) AND !empty($_POST['nom_personnage']) AND !empty($_POST['histoire_personnage'])){
                $this->setNom(Utilitaire::cleanInput($_POST['nom_personnage']));
                $this->setHistoire(Utilitaire::cleanInput($_POST['histoire_personnage']));
                $this->setEquipement(Utilitaire::cleanInput($_POST['equipement_personnage']));
                $this->setStatut(true);
                $this->getAuteur()->setId(Utilitaire::cleanInput($_SESSION['id']));
                $check = Utilitaire::checkPhoto($_FILES['photo_personnage']['tmp_name']);
                if($_FILES['photo_personnage']['tmp_name'] != "" AND $check==true){
                    $this->setPhoto($_FILES['photo_personnage']['name']);
                    move_uploaded_file($_FILES['photo_personnage']['tmp_name'], './Public/asset/images/'.$_FILES['photo_personnage']['name']);
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
        ['script.js'],['style.css', 'form.css','perso.css'],$error,);
    }

    public function getAllPersonnage(){
        $error = "";
        $persos = $this->findAll();
        if(empty($persos)){
            $error = "Il n'y à pas de personnages sur le site";
        }
        Template::render('navbar.php','footer.php','vueAllPersonnages.php','Tous les Personnages', 
        ['script.js'],['style.css', 'perso.css'],$error,$persos);
    }

    public function getOwnPersonnage(){
        $error = "";
        $this->getAuteur()->setId(Utilitaire::cleanInput($_SESSION['id']));
        $persos = $this->findOwn();
        if(empty($persos)){
            $error = "Vous n'avez pas créé de personnages";
        }
        Template::render('navbar.php','footer.php','vueOwnPersonnages.php','Mes Personnages', 
        ['script.js'],['style.css', 'perso.css'],$error,$persos);
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
        ['script.js'],['style.css', 'form.css','perso.css'],$error,);
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
        ['script.js'],['style.css', 'perso.css'],$error,$data);
    }



    public function updatePersonnage(){
        $error ="";
        //Tester si les paramètres $_GET['id_personnage'] et $_GET['auteur_personnage'] existent]
        if(isset($_GET['id_fiche_personnage']) AND isset($_GET['auteur_personnage'])){
            if($_SESSION['id'] == $_GET['auteur_personnage']){
                $this->setId(Utilitaire::cleanInput($_GET['id_fiche_personnage']));
                $perso = $this->find();
                //test si le personnage existe
                if($perso){
                    //injection des valeurs du personnage dans le tableau $data que l'on passe à la vue
                    $data = [];
                    $data[1] = $perso;
                    $persotab = (array)$perso;
                    $indexed = array_values($persotab);
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
                                    if($ext == 'png' OR $ext == 'PNG' OR $ext == 'jpg' OR $ext == 'JPG'OR $ext == 'jpeg' OR $ext == 'JPEG' OR $ext == 'bmp' OR $ext == 'BMP'){
                                        $size = $_FILES['photo_personnage']['size'];
                                        $maxsize = 300000;
                                        $compare = $size < $maxsize;
                                        if($compare){
                                            $uniqueName = uniqid('',true);
                                            $_FILES['photo_personnage']['name'] = $uniqueName.".".$ext;
                                            $this->setPhoto($_FILES['photo_personnage']['name']);
                                            move_uploaded_file($_FILES['photo_personnage']['tmp_name'], './Public/asset/images/'.$_FILES['photo_personnage']['name']);
                                        }
                                        else {
                                            $error ='le fichier est trop lourd ( taille de fichier max 300 ko )';
                                            header("Refresh:2; url=./ownpersonnages");
                                        }
                                    }
                                    else{
                                        $error = 'format incorrect';
                                    }
                            }
                            else if($_FILES['photo_personnage']['tmp_name'] == ""){
                                $this->setPhoto($indexed[3]);
                            }
                            $this->setNom($nom);
                            $this->setHistoire($histoire);
                            $this->setEquipement($equipement);
                            $this->getAuteur()->setId($_SESSION['id']);
                            $this->update();
                            $error = "Le personnage a été mis jour";
                            header("Refresh:2; url=./ownpersonnages");
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
        ['script.js'],['style.css','perso.css', 'form.css'],$error,$data);
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
        ['script.js'], ['style.css', 'perso.css'],$error, $persos);
    }
}