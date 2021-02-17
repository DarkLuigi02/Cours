<?php
class Contact{    
    private $db;  // Étape 1
    private $insert; 
    
    public function __construct($db){        // Étape 2 
        $this->db = $db; 
        $this->insert = $this->db->prepare("insert into contact(email, nom, prenom, message)values (:email, :nom, :prenom, :message)");  
        }

    public function insert($email, $nom, $prenom, $message){ // Étape 3         
        $r = true;        
        $this->insert->execute(array(':email'=>$email, ':nom'=>$nom, ':prenom'=>$prenom, ':message'=>$message));        
        if ($this->insert->errorCode()!=0){             
            print_r($this->insert->errorInfo());               
            $r=false;        
        }        
        return $r;    
    }
 
}?>