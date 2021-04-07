<?php
function produitCreaControleur($twig,$db){  
    $form = array();   
    if (isset($_POST['newproduit'])){    
        $photo =null;      
        $produit = new Produit($db);      
        $designation = $_POST['inputProduit'];      
        $description = $_POST['inputDescription'];      
        $prix = $_POST['inputPrix'];      
        $idType = $_POST['type'];  
        $upload = new Upload(array('png', 'gif', 'jpg', 'jpeg'), 'images', 500000);     
        $photo = $upload->enregistrer('photo');      
        $exec=$produit->insert($designation, $description, $prix, $idType, $photo['nom']);      
        if (!$exec){        
            $form['valide'] = false;          
            $form['message'] = 'Problème d\'insertion dans la table produit ';       
        }else{        
            $form['valide'] = true;  
            $form['designation']=$designation;      
        }  

    }  
    echo $twig->render('creaproduit.html.twig', array('form'=>$form));
}

function produitControleur($twig, $db){    
    $form = array();  
    $produit = new Produit($db);   

    if(isset($_POST['btSupprimer'])){      
        $cocher = $_POST['cocher'];      
        $form['valide'] = true;      
        $etat = true;      
        foreach ( $cocher as $id){        
            $exec=$produit->delete($id);         
            if (!$exec){           
                $etat = false;          
            }      
        }      
        header('Location: index.php?page=produit&etat='.$etat);      
        exit;    
    }
    
    if(isset($_GET['id'])){      
        $exec=$produit->delete($_GET['id']);      
        if (!$exec){        
            $etat = false;      
        }else{        
            $etat = true;      
        }
        header('Location: index.php?page=produit&etat='.$etat);      
        exit;    
    }    
    if(isset($_GET['etat'])){       
        $form['etat'] = $_GET['etat'];     
    }
    $liste = $produit->select();    
    echo $twig->render('produit.html.twig', array('form'=>$form,'liste'=>$liste));
}

function produitModifControleur($twig, $db){ 
    $form = array();    
    if(isset($_GET['id'])){    
        $produit = new Produit($db);    
        $unProduit = $produit->selectById($_GET['id']);      
        if ($unProduit!=null){      
            $form['produit'] = $unProduit; 
            $type = new Type($db);      
            $liste = $type->select();      
            $form['type']=$liste;   
        }else{      
            $form['message'] = 'Produit incorrect';      
        } 
    }else{        
        if(isset($_POST['btModifier'])){       
            $produit = new Produit($db);       
            $design = $_POST['designation'];  
            $descrip = $_POST['description'];     
            $prix = $_POST['prix'];       
            $type = $_POST['type'];       
            $id = $_POST['id'];       
            $exec=$produit->update($id, $design, $descrip, $prix, $type);  
            if(!$exec){         
                $form['valide'] = false;           
                $form['message'] = 'Echec de la modification';        
            }else{ 
                $form['valide'] = true;           
                $form['message'] = 'Modification réussie';         
            }
        }
        else{
            $form['message'] = 'Produit non précisé';
        }
    }
echo $twig->render('produit-modif.html.twig', array('form'=>$form));}


?>

