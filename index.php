<?php
    //import du fichier de configuration
    include './env.php';
    //import de l'autoloader des classes
    require_once './autoload.php';
    require_once './vendor/autoload.php';
    use App\Controller\UtilisateurController;
    use App\Controller\HomeController;
    use App\Controller\PersonnageController;
    $userController = new UtilisateurController(); 
    $homeController = new HomeController();
    $persoController = new PersonnageController(); 
    //utilisation de session_start(pour gérer la connexion au serveur)
    session_start();
    //Analyse de l'URL avec parse_url() et retourne ses composants
    $url = parse_url($_SERVER['REQUEST_URI']);
    //test si l'url posséde une route sinon on renvoi à la racine
    $path = isset($url['path']) ? $url['path'] : '/';
    //version connecté
    if(isset($_SESSION['connected'])){
        //routeur
        switch ($path) {
            case '/jdr/':
                $homeController->getHome();
                break;
            case '/jdr/userdeconnexion':
                $userController->deconnexionUser();
                break;
            case '/jdr/personnageadd':
                $persoController->addPersonnage();
                break;
            case '/jdr/allpersonnages':
                $persoController->getAllPersonnage();
                break;
            case '/jdr/ownpersonnages':
                $persoController->getOwnPersonnage();
                break;
            case '/jdr/personnageupdate':
                $persoController->updatePersonnage();
                break;
            case '/jdr/personnagedelete':
                $persoController->deletePersonnage();
                break;
            case '/jdr/personnagedisplay':
                $persoController->displayPersonnage();
                break;
            default:
                $homeController->get404();
                break;
        }
    }
    else{
        switch ($path) {
            case '/jdr/':
                $homeController->getHome();
                break;
            case '/jdr/useradd':
                $userController->addUser();
                break;
            case '/jdr/userconnexion':
                $userController->connexionUser();
                break;
            default:
                $homeController->get404();
                break;
        }
    }
?>
