<?php
namespace App\Model;
use App\Utils\BddConnect;
class TypeUtilisateur extends BddConnect{
    //Attributs
    private ?int $id_type_utilisateur;
    private ?string $nom_type_utilisateur;
    //constructeur
    //Getters et Setters
    public function getId():?int{
        return $this->id_type_utilisateur;
    }
    public function setId(?int $id){
        $this->id_type_utilisateur = $id;
    }
    public function getNom():?string{
        return $this->nom_type_utilisateur;
    }
    public function setNom(?string $nom){
        $this->nom_type_utilisateur = $nom;
    }
    //Méthodes
    //Ajouter un roles en BDD
    public function add(){
        try {
            $nom = $this->getNom();
            $req = $this->connexion()->prepare('INSERT INTO type_utilisateur(nom_type_utilisateur)VALUES(?)');
            $req->bindParam(1, $nom, \PDO::PARAM_STR);
            $req->execute();
        } 
        catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }
    //Chercher un roles par son nom en BDD
    public function findOneBy(){
        try {
            $nom = $this->getNom();
            $req = $this->connexion()->prepare('SELECT id_type_utilisateur, nom_type_utilisateur FROM
            type_utilisateur WHERE type_utilisateur = ?');
            $req->bindParam(1, $nom, \PDO::PARAM_STR);
            $req->execute();
            $req->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Roles::class);
            return $req->fetch();
        } 
        catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }
}
?>