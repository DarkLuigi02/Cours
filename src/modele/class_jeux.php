<?php
class Jeux{    
    // Étape 1
    private $db;  
    private $insert; 
    private $select; 
    private $selectById;  
    private $update;
    private $delete;
    private $selectLimit;
    private $selectCount;
    // Étape 2 
    public function __construct($db){ 
        $this->db = $db; 
        $this->insert = $this->db->prepare("insert into Jeux(Nom, Prixparh, photo)values (:nom, :prix, :photo)");  
        $this->select = $db->prepare("select j.id, Nom, Prixparh, photo from Jeux j order by id");
        $this->selectById  =  $db->prepare("select  id, Nom, Prixparh, photo from  Jeux  where id=:id");
        $this->update  =  $db->prepare("update  Jeux  set  Nom=:designation,  Prix/h=:prix, photo=:photo where id=:id");
        $this->delete = $db->prepare("delete from Jeux where id=:id");
        $this->selectLimit = $db->prepare("select id, Nom, Prixparh, from Jeux order by Nom limit :inf,:limite");
        $this->selectCount =$db->prepare("select count(*) as nb from Jeux");
    }
    // Étape 3 
    public function insert($design, $prix, $photo){        
        $r = true;        
        $this->insert->execute(array(':nom'=>$design, ':prix'=>$prix, ':photo'=>$photo));        
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
    public function update($id, $designation, $prix, $photo){        
        $r = true;        
        $this->update->execute(array(':id'=>$id, ':nom'=>$designation, ':prix'=>$prix, ':photo'=>$photo));        
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
}?>