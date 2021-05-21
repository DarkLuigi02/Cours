<?php

function CreatypeControleur($twig,$db){        
        $produit = new Type($db);      
        $designation = $_POST['nom'];           
        $exec=$produit->insert($designation);      
        if (!$exec){        
            $form['valide'] = false;          
            $form['message'] = 'Problème d\'insertion dans la table produit ';       
        }else{        
            $form['valide'] = true;  
            $form['designation']=$designation;      
        }  
 
    echo $twig->render('creatype.html.twig', array('form'=>$form));
}

function typeControleur($twig, $db){    
    $form = array();  
    $type = new type($db);    

    if(isset($_POST['btCreation'])){  
        header('Location: index.php?page=creaproduit');      
        exit;    
    } 
    
    if(isset($_POST['btSupprimer'])){      
        $cocher = $_POST['cocher'];      
        $form['valide'] = true;      
        $etat = true;      
        foreach ( $cocher as $id){        
            $exec=$utilisateur->delete($id);         
            if (!$exec){           
                $etat = false;          
            }      
        }      
        header('Location: index.php?page=type&etat='.$etat);      
        exit;    
    }

    if(isset($_GET['id'])){      
        $exec=$utilisateur->delete($_GET['id']);         
    } 
    if(isset($_GET['etat'])){       
        $form['etat'] = $_GET['etat'];     
    }

    $liste = $type->select();    
    echo $twig->render('type.html.twig', array('form'=>$form,'liste'=>$liste));
}

function typeModifControleur($twig, $db){ 
    $form = array();    
    if(isset($_GET['id'])){    
        $type = new type($db);    
        $untype = $type->selectById($_GET['id']);      
        if ($untype!=null){      
            $form['type'] = $untype;       
        }else{      
            $form['message'] = 'type incorrect';      
        } 
    }else{        
        if(isset($_POST['btModifier'])){       
            $type = new Type($db);       
            $libelle = $_POST['libelle'];
            $id = $_POST['id'];            
            $exec=$type->update($id,$libelle);              
            if(!$exec){         
                $form['valide'] = false;           
                $form['message'] = 'Echec de la modification';        
            }else{ 
                $form['valide'] = true;           
                $form['message'] = 'Modification réussie';         
            }
        }
        else{
            $form['message'] = 'type non précisé';
        }
    }
echo $twig->render('type-modif.html.twig', array('form'=>$form));}
?>
