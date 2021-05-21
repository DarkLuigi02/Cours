<?php

function getPage($db){
    // Inscrire vos contrôleurs ici 
    $lesPages['accueil'] = "accueilControleur;0";
    $lesPages['contact'] = "contactControleur;0";
    $lesPages['Mentions_legales'] = "MentionControleur;0";
    $lesPages['apropos'] = "AproposControleur;0";
    $lesPages['inscrire'] = "inscrireControleur;0";
    $lesPages['maintenance'] = "maintenanceControleur;0";
    $lesPages['connexion'] = "connexionControleur;0";
    $lesPages['utilisateur'] = "utilisateurControleur;1";
    $lesPages['utilisateurModif'] = "utilisateurModifControleur;1";
    $lesPages['creaproduit'] = "produitCreaControleur;1";
    $lesPages['produit'] = "produitControleur;1";
    $lesPages['produitModif'] = "produitModifControleur;1";
    $lesPages['type'] = "typeControleur;1";
    $lesPages['creatype'] = "CreatypeControleur;1";
    $lesPages['typemodif'] = "typeModifControleur;1";
    $lesPages['coaching'] = "coachingControleur;0";
    $lesPages['rendez-vous'] = "rendezvousControleur;2";
    $lesPages['jeu'] = "jeuControleur;1";
    $lesPages['creajeu'] = "CreajeuControleur;1";
    $lesPages['jeuModif'] = "produitModifControleur;1";
    $lesPages['commentaire'] = "commentaireControleur;0";
    $lesPages['commentaireModif'] = "commentaireModifControleur;1";
    $lesPages['recherche'] = "rechercheControleur;0";
    $lesPages['boutique'] = "boutiqueControleur;0";
    $lesPages['mdplost'] = "mdplostControleur;0";
    
    if ($db!=null){
        if (isset($_GET['page'])){
            $page = $_GET['page'];
        }
        else{
            $page = 'accueil';
        }
        if (!isset($lesPages[$page])){
        // Nous rentrons ici si cela n'existe pas, ainsi nous redirigeons l'utilisateur sur la page d'accueil
            $page = 'accueil';
        }
       
        $explose = explode(";",$lesPages[$page]);
        // Nous découpons la ligne du tableau sur le
        //caractère « ; » Le résultat est stocké dans le tableau $explose
       
        $role = $explose[1]; // Le rôle est dans la 2ème partie du tableau $explose
       
        if ($role != 0){ // Si mon rôle nécessite une vérification
            if(isset($_SESSION['login'])){ // Si je me suis authentifié
                if(isset($_SESSION['role'])){ // Si j’ai bien un rôle
                    if($role!=$_SESSION['role']){ // Si mon rôle ne correspond pas à celui qui est nécessaire pour voir la page
                        $contenu = 'accueilControleur'; // Je le redirige vers l’accueil, car il n’a pas le bon rôle
                    }else{
                        $contenu = $explose[0]; // Je récupère le nom du contrôleur, car il a le bon rôle
                    }
                }else{
                $contenu = 'accueilControleur';;
                }
            }else{
            $contenu = 'accueilControleur';; // Page d’accueil, car il n’est pas authentifié
            }
        }else{
        $contenu = $explose[0]; // Je récupère le contrôleur, car il n’a pas besoin d’avoir un rôle
        }
    }else{
       $contenu = $lesPages['maintenance'];
    }
    return $contenu;
}
?>