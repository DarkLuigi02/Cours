<?php
class Produit{    
    private $db;  // Étape 1
    private $insert; 
    private $select; 
    private $selectById;  
    private $update;
    private $updateMdp;
    private $delete;
    
    public function __construct($db){        // Étape 2 
        $this->db = $db; 
        $this->insert = $this->db->prepare("insert into produit(designation, description, prix, idType)values (:designation, :description, :prix, :type)");  
        $this->select = $db->prepare("select p.id, designation, idType, description, prix, t.libelle as libelletype from produit p, type t where p.idType = t.id order by nom");
        $this->selectById  =  $db->prepare("select  id, designation, idType, description, prix, from  produit  where id=:id");
        $this->update  =  $db->prepare("update  produit  set  designation=:designation,  description=:description,  idType=:type where id=:id");
        $this->delete = $db->prepare("delete from produit where id=:id");
    }

    public function insert($design, $descrip, $type, $prix){ // Étape 3         
        $r = true;        
        $this->insert->execute(array(':designation'=>$design, ':description'=>$descrip, ':type'=>$type, ':prix'=>$prix));        
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
    public function update($id, $type, $designation, $descrip, $prix){        
        $r = true;        
        $this->update->execute(array(':id'=>$id, ':type'=>$type, ':designation'=>$designation, ':description'=>$descrip, ':prix'=>$prix));        
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