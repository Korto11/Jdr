<?php
namespace App\Model;
use App\Utils\BddConnect;
class Personnage extends BddConnect{
    //attributs
    private ?int $id_fiche_personnage;
    private ?string $nom_personnage;
    private ?string $histoire_personnage;
    private ?string $photo_personnage;
    private ?string $equipement_personnage;
    public function __construct(){
        $this->auteur_personnage = New Utilisateur();
    }
    //Getters et Setters
    public function getId():?int{
        return $this->id_fiche_personnage;
    }
    public function setId(?int $id){
        $this->id_fiche_personnage= $id;
    }
    public function getNom():?string{
        return $this->nom_personnage;
    }
    public function setNom(?string $nom){
        $this->nom_personnage = $nom;
    }
    public function getHistoire():?string{
        return $this->histoire_personnage;
    }
    public function setHistoire(?string $histoire){
        $this->histoire_personnage = $histoire;
    }
    public function getPhoto():?string{
        return $this->photo_personnage;
    }
    public function setPhoto(?string $photo){
        $this->photo_personnage = $photo;
    }
    public function getEquipement():?string{
        return $this->equipement_personnage;
    }
    public function setEquipement(?string $equipement){
        $this->equipement_personnage = $equipement;
    }
    public function getStatut():?bool{
        return $this->statut_personnage;
    }
    public function setStatut(?bool $statut){
        $this->statut_personnage = $statut;
    }
    public function getAuteur():?Utilisateur{
        return $this->auteur_personnage;
    }
    public function setAuteur(?Utilisateur $auteur):void{
        $this->auteur_personnage = $auteur;
    }
  
    //Méthodes
    public function add(){
        try {
            //récupérer les données de l'objet
            $nom = $this->nom_personnage;
            $histoire = $this->histoire_personnage;
            $photo = $this->photo_personnage;
            $equipement = $this->equipement_personnage;
            $statut = $this->statut_personnage;
            $auteur = $this->getAuteur()->getId();
            $req = $this->connexion()->prepare(
                "INSERT INTO fiche_personnage(nom_personnage, 
                histoire_personnage, photo_personnage, equipement_personnage,statut_personnage,auteur_personnage ) VALUES(?,?,?,?,?,?)");
            $req->bindParam(1, $nom, \PDO::PARAM_STR);
            $req->bindParam(2, $histoire, \PDO::PARAM_STR);
            $req->bindParam(3, $photo, \PDO::PARAM_STR);
            $req->bindParam(4, $equipement, \PDO::PARAM_STR);
            $req->bindParam(5, $statut, \PDO::PARAM_BOOL);    
            $req->bindParam(6, $auteur, \PDO::PARAM_INT);
            $req->execute();
        } catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }
    public function findOneBy(){
        try {
            //récupérer les données de l'objet
            $nom = $this->getNom();
            $histoire = $this->getHistoire();
            $photo = $this->getPhoto();
            $equipement = $this->getEquipement();
            $auteur = $this->getAuteur()->getId();
            $req = $this->connexion()->prepare(
                "SELECT id_fiche_personnage, nom_personnage, 
                histoire_personnage, photo_personnage, equipement_personnage, auteur_personnage
                FROM fiche_personnage WHERE nom_personnage = ? AND histoire_personnage = ? AND photo_personnage = ? AND equipement_personnage = ? AND auteur_personnage = ? AND statut_personnage = true ");
            $req->bindParam(1, $nom, \PDO::PARAM_STR);
            $req->bindParam(2, $histoire, \PDO::PARAM_STR);
            $req->bindParam(3, $photo, \PDO::PARAM_STR);
            $req->bindParam(4, $equipement, \PDO::PARAM_STR);
            $req->bindParam(5, $auteur, \PDO::PARAM_INT);
            $req->setFetchMode(\PDO::FETCH_CLASS| \PDO::FETCH_PROPS_LATE, Personnage::class);
            $req->execute();
            return $req->fetch();
        } catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }

    public function find(){
        try {
            $requete = 'SELECT id_fiche_personnage FROM fiche_personnage WHERE id_fiche_personnage = ?';
            $requete2 = 'SELECT id_fiche_personnage, nom_personnage,
            histoire_personnage, photo_personnage, equipement_personnage, auteur_personnage AS auteur_id, auteur.pseudo_utilisateur AS auteur_pseudo
            FROM fiche_personnage 
            INNER JOIN utilisateur AS auteur ON fiche_personnage.auteur_personnage = auteur.id_utilisateur
            WHERE id_fiche_personnage = ? AND statut_personnage = true ';
            $id = $this->getId();
            $req = $this->connexion()->prepare($requete);
            $req->bindParam(1, $id , \PDO::PARAM_INT);
            $req->execute();
            //test si la requête renvoi un enregistrement
            if($req->fetch()){
                $req2 = $this->connexion()->prepare($requete2);
                $req2->bindParam(1, $id , \PDO::PARAM_INT);
                $req2->execute();
                $req2->setFetchMode(\PDO::FETCH_CLASS| \PDO::FETCH_PROPS_LATE, Personnage::class);
                $perso = $req2->fetch();
                $perso->getAuteur()->setId($perso->auteur_id);
                $perso->getAuteur()->setPseudo($perso->auteur_pseudo);
            }
            else{
                $perso = null;
            }
            return $perso;
        } catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }


    public function findAll(){
        try {
            $req = $this->connexion()->prepare('SELECT 
            id_fiche_personnage, nom_personnage, histoire_personnage, photo_personnage, equipement_personnage,
            auteur.pseudo_utilisateur AS auteur_pseudo, auteur.id_utilisateur AS auteur_id
            FROM fiche_personnage
            INNER JOIN utilisateur AS auteur ON fiche_personnage.auteur_personnage = auteur.id_utilisateur
            WHERE statut_personnage = true ');
            $req->execute();
            return $req->fetchAll(\PDO::FETCH_CLASS| \PDO::FETCH_PROPS_LATE, Personnage::class);
        } catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }

    public function findOwn(){
        try {
            $id = $this->getAuteur()->getId();
            $req = $this->connexion()->prepare('SELECT 
            id_fiche_personnage, nom_personnage, histoire_personnage, photo_personnage, equipement_personnage
            FROM fiche_personnage
            WHERE statut_personnage = true AND auteur_personnage = ?');
            $req->bindParam(1, $id, \PDO::PARAM_INT);
            $req->execute();
            return $req->fetchAll(\PDO::FETCH_CLASS| \PDO::FETCH_PROPS_LATE, Personnage::class);
        } catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }


    public function update(){
        try {
            $id = $this->id_fiche_personnage;
            $nom = $this->nom_personnage;
            $histoire = $this->histoire_personnage;
            $photo = $this->photo_personnage;
            $equipement = $this->equipement_personnage;
            $auteur = $this->getAuteur()->getId();
            $req = $this->connexion()->prepare('UPDATE fiche_personnage SET nom_personnage = ?, 
            histoire_personnage = ?, photo_personnage = ?, equipement_personnage = ? WHERE id_fiche_personnage = ? AND auteur_personnage = ?');
            $req->bindParam(1, $nom, \PDO::PARAM_STR);
            $req->bindParam(2, $histoire, \PDO::PARAM_STR);
            $req->bindParam(3, $photo, \PDO::PARAM_STR);
            $req->bindParam(4, $equipement, \PDO::PARAM_STR);
            $req->bindParam(5, $id, \PDO::PARAM_INT);
            $req->bindParam(6, $auteur, \PDO::PARAM_INT);
            $req->execute();
        } catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }

    public function delete(){
        try {
            $id = $this->id_fiche_personnage;
            $req = $this->connexion()->prepare('UPDATE fiche_personnage SET statut_personnage = false
            WHERE id_fiche_personnage = ?');
            $req->bindParam(1, $id, \PDO::PARAM_INT);
            $req->execute();
        } catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }


    public function filterAll($filter){
        try {
            $requete = 'SELECT id_fiche_personnage, nom_personnage, histoire_personnage, photo_personnage, equipement_personnage
            auteur.pseudo_utilisateur AS auteur_pseudo, auteur.id_utilisateur AS auteur_id
            FROM fiche_personnage 
            INNER JOIN utilisateur AS auteur ON fiche_personnage.auteur_personnage = auteur.id_utilisateur ';
           
            switch ($filter) {
                case 1:
                    $order = 'ORDER BY nom_personnage ASC';
                    break;
                case 2:
                    $order = 'ORDER BY nom_personnage DESC';
                    break;
                default:
                    $order = "";
                    break;
            }
            $requete .= $order;
            $req = $this->connexion()->prepare($requete);
            $req->execute();
            return $req->fetchAll(\PDO::FETCH_CLASS| \PDO::FETCH_PROPS_LATE, Personnage::class);
        } catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }
}
?> 