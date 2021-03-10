<?php
class Role{    
    private $db;  // Étape 1
    private $select; 
    
    public function __construct($db){        // Étape 2 
        $this->db = $db; 
        $this->select = $db->prepare("select r.id, r.libelle from role r");  
        }

    public function select(){ // Étape 3              
        $this->select->execute();        
        if ($this->select->errorCode()!=0){             
            print_r($this->select->errorInfo());               
              
        }        
        return $this->select->fetchAll();    
    }
 
}?>