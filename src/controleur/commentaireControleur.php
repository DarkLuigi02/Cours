<?php
function commentaireControleur($twig, $db){    
    $form = array();  
    $commentaire = new Commentaire($db);     
    if(isset($_GET['etat'])){       
        $form['etat'] = $_GET['etat'];     
    }
    $liste = $commentaire->select();    
    echo $twig->render('Commentaire.html.twig', array('form'=>$form,'liste'=>$liste));
}

function commentaireModifControleur($twig,$db){    
    $form = array();   
    if(isset($_GET['id'])){     
        $commentaire = new Commentaire($db);    
        $unCommentaire = $commentaire->selectById($_GET['id']);      
        if ($unCommentaire!=null){      
            $form['commentaire'] = $unCommentaire;  
        }else{      
            $form['message'] = 'Commentaire incorrect';      
        } 
    }else{       
        if(isset($_POST['btModifier'])){   
            $commentaire = new Commentaire($db);            
            $message = $_POST['message'];          
            $id = $_POST['id'];       
            $exec=$commentaire->update($id, $message);  
            if(!$exec){         
                $form['valide'] = false;           
                $form['message'] = 'Echec de la modification';        
            }else{ 
                $form['valide'] = true;           
                $form['message'] = 'Modification réussie';         
            }
        }
        else{
            $form['message'] = 'Commentaire non précisé';
        }
    }
    if(isset($_GET['etat'])){       
        $form['etat'] = $_GET['etat'];     
    }
    $liste=$commentaire->select();
    echo $twig->render('commentaire-modif.html.twig', array('form'=>$form,'liste'=>$liste));
}
?>