<?php
function produitControleur($twig,$db){  
    $form = array();   
    if (isset($_POST['newproduit'])){    
        $inputProduit = $_POST['libelle'];      
        $inputdescription = $_POST['inputdescrip'];       
        $prix = $_POST['prix'];       
            $produit = new Produit($db);         
            $exec = $utilisateur->insert($inputProduit,$role, $nom, $prenom);        
            if (!$exec){          
                $form['valide'] = false;            
                $form['message'] = 'Problème d\'insertion dans la table utilisateur ';          
            }
        $form['prix'] = $prix;      
        $form['libelle'] = $inputProduit;  
    }  
    echo $twig->render('creaproduit.html.twig', array('form'=>$form));
}

function produitModifControleur($twig, $db){ 
    $form = array();    
    if(isset($_GET['id'])){    
        $produit = new Produit($db);    
        $unUtilisateur = $utilisateur->selectById($_GET['id']);      
        if ($unProduit!=null){      
            $form['produit'] = $unProduit; 
            $type = new Type($db);      
            $liste = $role->select();      
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
