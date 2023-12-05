<?php
namespace App\Controller;
use App\Model\Utilisateur;
use App\Utils\Utilitaire;
use App\vue\Template;
class UtilisateurController extends Utilisateur{
    public function addUser(){
        $error = "";
        //tester si le formulaire
        if(isset($_POST['submit'])){
            //test si les champs sont remplis
            if(!empty($_POST['pseudo_utilisateur']) 
            AND !empty($_POST['mail_utilisateur']) AND !empty($_POST['password_utilisateur']) 
            AND !empty($_POST['repeat_password_utilisateur'])){
                //Test si les mots de passe correspondent
                if($_POST['password_utilisateur']==$_POST['repeat_password_utilisateur']){
                    //setter les valeurs à l'objet UtilisateurController
                    $this->setPseudo(Utilitaire::cleanInput($_POST['pseudo_utilisateur']));
                    $this->setMail(Utilitaire::cleanInput($_POST['mail_utilisateur']));
                    //tester si le compte existe
                    if(!$this->findOneBy()){
                        //hashser le mot de passe
                        $this->setPassword(password_hash(Utilitaire::cleanInput($_POST['password_utilisateur']), PASSWORD_DEFAULT));
                        //Ajouter le compte en BDD
                        $this->add();
                        $error = "Le compte a été ajouté en BDD";
                        header("Refresh:2; url=./userconnexion");
                    }    
                    else{
                        $error = "Le compte existe déja";
                    }
                }else{
                    $error = "Les mots de passe ne correspondent pas";
                }
            }else{
                $error = "Veuillez renseigner tous les champs du formulaire";
            }
        }
        Template::render('navbar.php','footer.php','vueAddUser.php','Inscription', 
        ['script.js'],['style.css'],$error);
    }
    public function connexionUser(){   
        $error ="";
        //tester si le formulaire est submit
        if(isset($_POST['submit'])){
            //tester si les champs sont remplis
            if(!empty($_POST['mail_utilisateur']) AND !empty($_POST['password_utilisateur'])){
                //tester si le compte existe (findOneBy du model)
                $this->setMail(Utilitaire::cleanInput($_POST['mail_utilisateur']));
                $user = $this->findOneBy();
                if($user){
                        //tester si le mot de passe correspond (password_verify)
                        if(password_verify(Utilitaire::cleanInput($_POST['password_utilisateur']), $user->getPassword())){
                            $error = "Connecté";
                            $_SESSION['connected'] = true;
                            $_SESSION['id'] = $user->getId();
                            $_SESSION['pseudo'] = $user->getPseudo();
                            header('Location: ./');
                        }else {
                            $error = "Les informations de connexion ne sont pas valides";
                        }
                }else{
                    $error = "Les informations de connexion ne sont pas valides";
                }
            //Test les champs sont vides
            }else{
                $error = "Veuillez renseigner tous les champs du formulaire";
            }
        }
        Template::render('navbar.php','footer.php','vueConnexionUser.php','Connexion', 
        ['script.js', 'main.js'], ['style.css', 'main.css'],$error);
    }
    public function deconnexionUser(){
        unset($_COOKIE['PHPSESSID']);
        session_destroy();
        header('Location: ./');
    }
    public function activateUser(){
        $error = "";
        $url = "";
        //tester si le paramètre existe
        if(isset($_GET['mail'])){
            //tester si le paramètre $_GET['mail'] est rempli
            if(!empty(($_GET['mail']))){
                //setter la valeur de $_GET['mail'] à l'attribut mail_utilisateur
                $this->setMail(Utilitaire::cleanInput($_GET['mail']));
                //appeler la fonction findOneBy qui va retourner un compte (objet) 
                //qui existe ou false
                if($this->findOneBy()){
                    $this->update();
                    $error = 'le compte a été activé';
                    $url = "./userconnexion";
                }
                //Test le compte n'existe pas
                else{
                    $error = 'Aucun compte trouvé';
                    $url = "./useradd";
                }
            }
            //tester si le paramètre $_GET['mail'] est vide
            else{
               $error = 'le mail n\'est pas renseigné';
               $url = "./useradd";
            }
        }
        //le paramètre $_GET['mail'] n'existe pas
        else{
            $error = 'le paramètre n\'existe pas';
            $url = "./useradd";
        }
        //appel de la vue (page html)
        Template::render('navbar.php','footer.php','vueActivateUser.php','Activation', 
        ['script.js', 'main.js'], ['style.css', 'main.css'],$error);
        //redirection
        header("Refresh:2; url=$url");
    }
}