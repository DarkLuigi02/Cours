<?php
function ContactControleur($twig, $db){             
    $form = array();   
    if (isset($_POST['btEnvoyer'])){    
        $inputEmail1 = $_POST['inputEmailC'];     
        $nom1 = $_POST['nomC'];       
        $prenom1 = $_POST['prenomC'];        
        $message = $_POST['message'];
        $form['valide'] = true; 
        $contact = new Contact($db); //verifie dans la classe Conctact
        $exec = $contact->insert($inputEmail1, $message, $nom1, $prenom1);        
            if (!$exec){          
                $form['valide'] = false;            
                $form['message'] = 'Problème d\'insertion dans la table conctact ';          
            }              
        $form['email'] = $inputEmail1;
        $form['nom'] = $nom1;
        $form['message'] = $message;
    } 
    echo $twig->render('Contact.html.twig', array('form'=>$form));
}
?>