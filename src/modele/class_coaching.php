<?php
class Coaching{    
    private $db;  // Étape 1
    private $insert; 
    private $select; 
    private $selectById;  
    private $update;
    private $delete;
    
    public function __construct($db){        // Étape 2 
        $this->db = $db; 
        $this->insert = $this->db->prepare("insert into coaching(nomJeux, nbrHeure, idUtilisateur)values (:nomJeux, :nbrHeure, :utilisateur)");  
        $this->select = $db->prepare("select c.id, nomJeux, nbrHeure, u.nom as nomutilisateur from utilisateur u, coaching c where c.idUtilisateur = u.idUtilisateur order by nomJeux");
        $this->selectById  =  $db->prepare("select  nomJeux, nbrHeure,  idUtilisateur  from  coaching  where id=:id");
        $this->update  =  $db->prepare("update  coaching  set  nomJeux=:nom,  nbrHeure=:heure,  idUtilisateur=:utilisateur where id=:id");
        $this->delete = $db->prepare("delete from coaching where id=:id");
    }

    public function insert($utilisateur, $nom, $nbr){ // Étape 3         
        $r = true;        
        $this->insert->execute(array(':nomJeux'=>$nom, ':nbrHeure'=>$nbr, ':utilisateur'=>$utilisateur));        
        if ($this->insert->errorCode()!=0){             
            print_r($this->insert->errorInfo());               
            $r=false;        
        }        
        return $r;    
    }
    public function select(){        
        $this->select->execute();        
        if ($this->select->errorCode()!=0){             
            print_r($this->select->errorInfo());          
        }        
        return $this->select->fetchAll();    
    }
    public function selectById($id){          
        $this->selectById->execute(array(':id'=>$id));        
        if ($this->selectById->errorCode()!=0){             
            print_r($this->selectById->errorInfo());          
        }        
        return $this->selectById->fetch(); 
    }
    public function update($id, $utilisateur, $nom, $nbr){        
        $r = true;        
        $this->update->execute(array(':id'=>$id, ':utilisateur'=>$utilisateur, ':nomJeux'=>$nom, ':nbr'=>$nbr));        
        if ($this->update->errorCode()!=0){             
            print_r($this->update->errorInfo());               
            $r=false;       
        }        
    return $r;
    }
    public function delete($id){   
        $r = true;
        $this->delete->execute(array(':id'=>$id));        
        if ($this->delete->errorCode()!=0){             
            print_r($this->delete->errorInfo());               
            $r=false;        
        }return $r;    
    }
}?>