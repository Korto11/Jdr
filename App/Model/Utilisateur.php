<?php
namespace App\Model;
use App\Utils\BddConnect;
use App\Model\TypeUtilisateur;
class Utilisateur extends BddConnect{
    //attributs
    private ?int $id_utilisateur;
    private ?string $pseudo_utilisateur;
    private ?string $password_utilisateur;
    private ?string $mail_utilisateur;
    private TypeUtilisateur $type_utilisateur;
    //constructeur
    public function __construct(){
        $this->type_utilisateur = new TypeUtilisateur();
    }
    //Getters et Setters
    public function getId():?int{
        return $this->id_utilisateur;
    }
    public function setId(?int $id){
        $this->id_utilisateur = $id;
    }
    public function getPseudo():?string{
        return $this->pseudo_utilisateur;
    }
    public function setPseudo(?string $pseudo){
        $this->pseudo_utilisateur = $pseudo;
    }
    public function getPassword():?string{
        return $this->password_utilisateur;
    }
    public function setPassword(?string $password){
        $this->password_utilisateur = $password;
    }
    public function getMail():?string{
        return $this->mail_utilisateur;
    }
    public function setMail(?string $mail){
        $this->mail_utilisateur = $mail;
    }
    public function getTypeUtilisateur():?TypeUtilisateur{
        return $this->type_utilisateur;
    }
    public function setTypeUtilisateur(?TypeUtilisateur $type_utilisateur){
        $this->type_utilisateur = $type_utilisateur;
    }
    //Méthodes
    public function add(){
        try {
            //récupérer les données de l'objet
            $pseudo = $this->pseudo_utilisateur;
            $mail = $this->mail_utilisateur;
            $password = $this->password_utilisateur;
            $type = $this->type_utilisateur;
            $req = $this->connexion()->prepare(
                "INSERT INTO utilisateur(pseudo_utilisateur, 
                mail_utilisateur, password_utilisateur) VALUES(?,?,?)");
            $req->bindParam(1, $pseudo, \PDO::PARAM_STR);
            $req->bindParam(2, $mail, \PDO::PARAM_STR);
            $req->bindParam(3, $password, \PDO::PARAM_STR);
            $req->execute();
        } catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }
    public function findOneBy(){
        try {
            //récupérer les données de l'objet
            $mail = $this->mail_utilisateur;
            $req = $this->connexion()->prepare(
                "SELECT id_utilisateur,pseudo_utilisateur, 
                mail_utilisateur,password_utilisateur
                FROM utilisateur WHERE mail_utilisateur = ?");
            $req->bindParam(1, $mail, \PDO::PARAM_STR);
            $req->setFetchMode(\PDO::FETCH_CLASS| \PDO::FETCH_PROPS_LATE, Utilisateur::class);
            $req->execute();
            return $req->fetch();
        } catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }
    public function findAll(){
        try {
            $id = $this->getId();
            $req = $this->connexion()->prepare(
                "SELECT id_utilisateur, pseudo_utilisateur, 
                mail_utilisateur FROM utilisateur WHERE id_utilisateur != ?");
            $req->bindParam(1, $id, \PDO::PARAM_INT);
            $req->execute();
            return $req->fetchAll(\PDO::FETCH_CLASS| \PDO::FETCH_PROPS_LATE, Utilisateur::class);
        } catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }

}
?> 