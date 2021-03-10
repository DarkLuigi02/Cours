<?php
function utilisateurControleur($twig, $db){    
    $form = array();  
    $utilisateur = new Utilisateur($db);   
    
    if(isset($_GET['id'])){      
        $exec=$utilisateur->delete($_GET['id']);      
        if (!$exec){        
            $etat = false;      
        }else{        
            $etat = true;      
        }
        header('Location: index.php?page=utilisateur&etat='.$etat);      
        exit;    
    }    
    if(isset($_GET['etat'])){       
        $form['etat'] = $_GET['etat'];     
    }
    $liste = $utilisateur->select();    
    echo $twig->render('utilisateur.html.twig', array('form'=>$form,'liste'=>$liste));
}
?>