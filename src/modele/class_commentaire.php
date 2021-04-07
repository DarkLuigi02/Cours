<?php
class Commentaire{    
    private $db;  // Étape 1 
    private $select; 
    private $selectById;  
    private $update;
    private $delete;
    
    public function __construct($db){        // Étape 2 
        $this->db = $db; 
        $this->select = $db->prepare("select c.id, c.idUtilisateur, idProduit, message, u.nom as nomutilisateur, u.prenom as prenomutilisateur, p.designation as designationproduit from commentaire c, produit p, utilisateur u where c.idProduit = p.id and c.idUtilisateur = u.idUtilisateur order by id");
        $this->selectById  =  $db->prepare("select  id, message, idProduit, idUtilisateur from  commentaire  where id=:id");
        $this->update  =  $db->prepare("update  commentaire  set  message=:message where id=:id");
        $this->delete = $db->prepare("delete from produit where id=:id");
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
    public function update($id, $message){        
        $r = true;        
        $this->update->execute(array(':id'=>$id,':message'=>$message,));        
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