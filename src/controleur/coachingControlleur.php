<?php
function coachingControleur($twig, $db){ 
    $form = array();  
    $jeu = new Jeux($db);
    $liste = $jeu->select();
    if(isset($_GET['id'])){      
        $exec=$jeu->selectById($_GET['id']);      
        if (!$exec){        
            $etat = false;      
        }else{        
            $etat = true;      
        }
        header('Location: index.php?page=jeu&etat='.$etat);      
        exit;    
    }    
    if(isset($_GET['etat'])){       
        $form['etat'] = $_GET['etat'];     
    }
    echo $twig->render('Coaching.html.twig', array('form'=>$form,'liste'=>$liste));
}
function jeuControleur($twig, $db){
    $form = array();  
    $jeu = new Jeux($db);
    $liste = $jeu->select();

        if(isset($_GET['id'])){      
            $exec=$jeu->selectById($_GET['id']);      
            if (!$exec){        
                $etat = false;      
            }else{        
                $etat = true;      
            }
            header('Location: index.php?page=jeu');      
            exit;    
        }    
        if(isset($_POST['btCreation'])){  
            header('Location: index.php?page=creajeu');      
            exit;    
        }
    echo $twig->render('jeu.html.twig', array('form'=>$form,'liste'=>$liste));
}

function CreajeuControleur($twig,$db){  
    if (isset($_POST['newjeu'])){    
        $photo =null;      
        $produit = new Jeux($db);      
        $designation = $_POST['nom'];        
        $prix = $_POST['prix'];        
        $upload = new Upload(array('png', 'gif', 'jpg', 'jpeg'), 'images', 500000);     
        $photo = $upload->enregistrer('photo');      
        $exec=$produit->insert($designation, $prix, $photo['nom']);      
        if (!$exec){        
            $form['valide'] = false;          
            $form['message'] = 'Problème d\'insertion dans la table produit ';       
        }else{        
            $form['valide'] = true;  
            $form['nom']=$designation;      
        }  
    }  
    echo $twig->render('creajeu.html.twig', array('form'=>$form));
}
function rendezvousControleur($twig,$db){
    $form = array();    
    if(isset($_GET['id'])){
    $jeu = new Jeux($db);    
        $unjeu = $jeu->selectById($_GET['id']);      
        if ($unjeu!=null){      
            $form['jeu'] = $unjeu; 
            $coach = new Coaching($db);      
            $liste = $coach->select();      
            $form['coaching']=$liste;   
        }else{      
            $form['message'] = 'Produit incorrect';      
        }
    } 
}
?>