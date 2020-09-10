<?php
//créer une classe Account pour pouvoir acceder et ajouter a la base de donées
// Mettre 2 underscore avant l'objet construct = __construct pour le faire executer en premier
// et dans les () on fait appel a la variable qui fait appel a la base de donées $con

class Account
{
    //creer une varianle private $con pour assigner en valeur a __construct
    //$this= acceder a l'instance de la class via la variable con(private $con) =$con(construct) 
    private $con;
    //creer un array pour les erreur
    private $errorArray = array();

    public function __construct($con)
    {
        $this->con = $con;
    }

    //valider les entrée des utilisateur
    public function register($fn, $ln, $un, $em, $em2, $pw, $pw2)
    {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUserName($un);
        $this->validateEmails($em, $em2);
        $this->validatePassword($pw, $pw2);

        //verifier que l'erreurArray est vide avant d'inserer les donées des utilisateur
        if (empty($this->errorArray)) {
            return $this->insertUserDetails($fn, $ln, $un, $em, $pw);
        }

        return false; //quand il y a des erreur dans l'array

    }

    public function login($pwd, $un) {
        $pwd = hash("sha512", $pwd);
    
        $stmt = $this->con->prepare("SELECT * FROM users WHERE username = :username AND pwd = :pwd");
        $stmt->bindParam(":username", $un);
        $stmt->bindParam(":pwd", $pwd);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($result) {
            return $stmt->execute();
        } else {
            array_push($this->errorArray, Constants::$notCorrect);
            return false;
        }
    }

    //inseré les donées des utilisateur dans la base de donées
    private function insertUserDetails($fn, $ln, $un, $em, $pw)
    {

        //hash the password = convertir en string crypté le mots de passe
        $pw = hash("sha512", $pw);
        // $pw = password_hash($pw, PASSWORD_DEFAULT);
        $query = $this->con->prepare("INSERT INTO users (firstname,lastname,username,email,pwd)
                                 VALUES (:fn, :ln, :un, :em, :pw)");
        $query->bindValue(":fn", $fn);
        $query->bindValue(":ln", $ln);
        $query->bindValue(":un", $un);
        $query->bindValue(":em", $em);
        $query->bindValue(":pw", $pw);
        // $query->execute();
        //executer et retourner la valeur en boolean
        return $query->execute();
    }

    //conction pour la validité firstname plus que 2 lettres et plus petit que 25
    private function validateFirstName($fn)
    {
        if (strlen($fn) < 2 || strlen($fn) > 25) {
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    private function validateLastName($ln)
    {
        if (strlen($ln) < 2 || strlen($ln) > 25) {
            array_push($this->errorArray, Constants::$lastNameCharacters);
        }
    }

    private function validateUserName($un)
    {
        if (strlen($un) < 2 || strlen($un) > 25) {
            array_push($this->errorArray, Constants::$userNameCharacters);
            return;
        }
        //controle si l'username existe
        $query = $this->con->prepare("SELECT * FROM users WHERE username=:un");
        $query->bindValue(":un", $un);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$usernameTaken);
        }
    }
    //fonction pour verifier que les email match
    private function validateEmails($em, $em2)
    {
        if ($em != $em2) {
            array_push($this->errorArray, Constants::$emailsDontMatch);
            return;
        }
        //filtre pour verifier que l'email est valide
        if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }
        //controle si l'email existe
        $query = $this->con->prepare("SELECT * FROM users WHERE email=:em");
        $query->bindValue(":em", $em);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }
    //fonction pour verifier que les mots de passe match
    private function validatePassword($pw, $pw2)
    {
        if ($pw != $pw2) {
            array_push($this->errorArray, Constants::$passwordsDontMatch);
            return;
        }
        if (strlen($pw) < 5 || strlen($pw) > 25) {
            array_push($this->errorArray, Constants::$passwordLength);
        }
    }

   

    public function getError($error)
    {
        if (in_array($error, $this->errorArray)) {
            return "<span class ='errorMessage'>$error</span>";
        }
    }
}
