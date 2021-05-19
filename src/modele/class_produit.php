<?php
class Produit{    
    // Étape 1
    private $db;  
    private $insert; 
    private $select; 
    private $selectById;  
    private $update;
    private $delete;
    private $selectLimit;
    private $selectCount;
    private $recherche;
    // Étape 2 
    public function __construct($db){ 
        $this->db = $db; 
        $this->insert = $this->db->prepare("insert into produit(designation, description, prix, photo, idType)values (:designation, :description, :prix, :photo, :type)");  
        $this->select = $db->prepare("select p.id, designation, idType, description, prix, photo, t.libelle as libelletype from produit p, type t where p.idType = t.id order by id");
        $this->selectById  =  $db->prepare("select  id, designation, idType, description, prix, photo from  produit  where id=:id");
        $this->update  =  $db->prepare("update  produit  set  designation=:designation,  description=:description,  idType=:type where id=:id");
        $this->delete = $db->prepare("delete from produit where id=:id");
        $this->selectLimit = $db->prepare("select id, designation, description, prix, idType from produit order by designation limit :inf,:limite");
        $this->selectCount =$db->prepare("select count(*) as nb from produit");
        $this->recherche = $db->prepare("select p.id, designation, description, prix, photo, t.libelle as type from produit p, type t where p.idType = t.id and designation like :recherche order by designation");    }
    // Étape 3 
    public function insert($design, $descrip, $prix, $type, $photo){        
        $r = true;        
        $this->insert->execute(array(':designation'=>$design, ':description'=>$descrip, ':type'=>$type, ':prix'=>$prix, ':photo'=>$photo));        
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
    public function update($id, $type, $designation, $descrip, $prix, $photo){        
        $r = true;        
        $this->update->execute(array(':id'=>$id, ':type'=>$type, ':designation'=>$designation, ':description'=>$descrip, ':prix'=>$prix, ':photo'=>$photo));        
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
    public function selectLimit($inf, $limite){
        $this->selectLimit->bindParam(':inf', $inf, PDO::PARAM_INT);
        $this->selectLimit->bindParam(':limite', $limite, PDO::PARAM_INT);
        $this->selectLimit->execute();
        if ($this->selectLimit->errorCode()!=0){
            print_r($this->selectLimit->errorInfo());
        }
        return $this->selectLimit->fetchAll();
    }
    public function selectCount(){
        $this->selectCount->execute();
        if ($this->selectCount->errorCode()!=0){
            print_r($this->selectCount->errorInfo());
        }
        return $this->selectCount->fetch();
    } 
    public function recherche($recherche){
        $this->recherche->execute(array('recherche'=>'%'.$recherche.'%'));
        if ($this->recherche->errorCode()!=0){
            print_r($this->recherche->errorInfo());
        }
        return $this->recherche->fetchAll();
    } 
}?>