<?php

function getPage($db){
    // Inscrire vos contrôleurs ici 
    $lesPages['accueil'] = "accueilControleur";
    $lesPages['contact'] = "contactControleur";
    $lesPages['Mentions_legales'] = "MentionControleur";
    $lesPages['apropos'] = "AproposControleur";
    $lesPages['inscrire'] = "inscrireControleur";
    $lesPages['maintenance'] = "maintenanceControleur";
    $lesPages['connexion'] = "connexionControleur";
    $lesPages['utilisateur'] = "utilisateurControleur";
    $lesPages['utilisateurModif'] = "utilisateurModifControleur";
    $lesPages['creaproduit'] = "produitCreaControleur";
    $lesPages['produit'] = "produitControleur";
    $lesPages['produitModif'] = "produitModifControleur";
    $lesPages['typemodif'] = "typeModifControleur";
    $lesPages['coaching'] = "coachingControleur";
    $lesPages['commentaire'] = "commentaireControleur";
    $lesPages['commentaireModif'] = "commentaireModifControleur";

    
    if ($db!=null){
        if (isset($_GET['page'])){
           $page = $_GET['page'];    
        }else{ 
        $page = 'accueil';
        }   
        if (isset($lesPages[$page])){
            $contenu = $lesPages[$page];    
        }else{        
            $contenu = $lesPages['accueil'];    
        }    
    }else{
       $contenu = $lesPages['maintenance'];
    }
    // La fonction envoie le contenu return $contenu; 
    return $contenu;
}
?>