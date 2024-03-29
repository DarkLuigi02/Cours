<?php
class Type{    
    private $db;  // Étape 1
    private $insert; 
    private $select; 
    private $selectById;  
    private $update;
    private $updateMdp;
    private $delete;
    
    public function __construct($db){        // Étape 2 
        $this->db = $db; 
        $this->insert = $this->db->prepare("insert into type(libelle)values (:libelle)");  
        $this->select = $db->prepare("select t.id, libelle from type t order by libelle");
        $this->selectById  =  $db->prepare("select  id, libelle  from  type where id=:id");
        $this->update  =  $db->prepare("update  type  set  libelle=:libelle, photo=:photo where id=:id");
        $this->delete = $db->prepare("delete from type where id=:id");
    }

    public function insert($libelle){ // Étape 3         
        $r = true;        
        $this->insert->execute(array(':libelle'=>$libelle));        
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
    public function update($id, $libelle, $photo){        
        $r = true;        
        $this->update->execute(array(':id'=>$id, ':libelle'=>$libelle, ':photo'=>$photo));        
        if ($this->update->errorCode()!=0){             
            print_r($this->update->errorInfo());               
            $r=false;       
        }        
    return $r;
    }
    public function delete($id){   
        $r = true;
        $this->delete->execute(array(':id'=>$id));  
        //si il y a un produit dans le type tu ne peux pas supprimer le type      
        if ($this->delete->errorCode()!=0){             
            print_r($this->delete->errorInfo());               
            $r=false;        
        }return $r;    
    }
}?>