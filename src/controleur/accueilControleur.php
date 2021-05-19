<?php

function accueilControleur($twig){    
    echo $twig->render('Accueil.html.twig', array());
}

function MentionControleur($twig){
    echo $twig->render('Mentions.html.twig', array());
}

function AproposControleur($twig){
    echo $twig->render('A propos.html.twig', array());
}

function maintenanceControleur($twig){
    echo $twig->render('maintenance.html.twig', array());
}

function rechercheControleur($twig, $db){
    $form = array();
    $produit = new Produit($db); 
    if (isset($_POST['BtRecherche'])){   
        $recherche = $_POST['recherche'];
        if ($recherche == null){
            $form['valide']=false;
            $form['message']='il n\'y a pas de recherche tappé';       
        }else{ 
            $liste = $produit->recherche($recherche);
            if (!$liste){
                $form['valide'] = false;
                $form['message'] = 'il n\'y a pas de produit';      
            }else{        
                $form['valide'] = true;     
            }
        }             
    $limite=5;
    if(!isset($_GET['nopage'])){
        $inf=0;
        $nopage=0;
    }else{
        $nopage=$_GET['nopage'];
        $inf=$nopage * $limite;
    }
    $r = $produit->selectCount();
    $nb = $r['nb'];
    $liste = $produit->recherche($recherche);
    $form['nbpages'] = ceil($nb/$limite);
    $form['nopage'] = $nopage;
    echo $twig->render('recherche.html.twig', array('form'=>$form,'liste'=>$liste));
    }
}


function inscrireControleur($twig,$db){  
    $form = array();   
    if (isset($_POST['btInscrire'])){    
        $inputEmail = $_POST['inputEmail'];      
        $inputPassword = $_POST['inputPassword'];       
        $inputPassword2 =$_POST['inputPassword2']; 
        $nom = $_POST['nom'];       
        $prenom = $_POST['prenom'];        
        $role = $_POST['role'];
        $form['valide'] = true;
        if ($inputPassword!=$inputPassword2){        
            $form['valide'] = false;          
            $form['message'] = 'Les mots de passe sont différents';      
        }else{$form = array();
            $utilisateur = new Utilisateur($db);         
            $exec = $utilisateur->insert($inputEmail, password_hash($inputPassword, PASSWORD_DEFAULT), $role, $nom, $prenom);        
            if (!$exec){          
                $form['valide'] = false;            
                $form['message'] = 'Problème d\'insertion dans la table utilisateur ';          
            }
        }
        $form['email'] = $inputEmail;      
        $form['role'] = $role;    
    }
    echo $twig->render('inscrire.html.twig', array('form'=>$form));
}

function connexionControleur($twig,$db){ 
    $form = array();   
    if (isset($_POST['btConnecter'])){        
        $form['valide'] = true;        
        $inputEmail = $_POST['inputEmail'];        
        $inputPassword = $_POST['inputPassword'];
        $utilisateur = new Utilisateur($db);         
        $unUtilisateur = $utilisateur->connect($inputEmail);        
        if ($unUtilisateur!=null){          
            if(!password_verify($inputPassword,$unUtilisateur['mdp'])){              
               $form['valide'] = false;              
              $form['message'] = 'Login ou mot de passe incorrect';          
            }else{      
                $_SESSION['login'] = $inputEmail;                
                $_SESSION['role'] = $unUtilisateur['idRole'];     
                header("Location:index.php");          
            }         
        }else{           
            $form['valide'] = false;           
            $form['message'] = 'Login ou mot de passe incorrect';        
        }
        if ($form['valide']=false){
            $form['message']='vous avez recu un email';
            $serveur = $_SERVER['HTTP_HOST']; // Adresse du serveur
            $script = $_SERVER["SCRIPT_NAME"]; // Nom du fichier PHP exécuté
            $email = $inputEmail;
            $message = " <html>
            <head></head>
            <body>
            Bienvenue sur Shop-Shop. pour confirmer votre inscription, veuillez cliquer sur le lien suivant :
            <a href=\"http://$serveur$script?page=validation&email=$email&idgenere=$idgenere\">Valider votre inscription</a>
            </body>
            </html>";
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=utf-8';
            mail($email, 'Inscription sur SHOP-SHOP', $message, implode("\n", $headers));
        }
    }
    echo $twig->render('connexion.html.twig', array('form'=>$form));
}

function mdplostControleur($twig,$db){
    $form = array();   
    if (isset($_POST['btConnecter'])){        
        $form['valide'] = true;        
        $inputEmail = $_POST['inputEmail'];        
        $inputPassword = $_POST['inputPassword'];
        $utilisateur = new Utilisateur($db);         
        $unUtilisateur = $utilisateur->connect($inputEmail);    
        $inputPassword = $utilisateur->updateMdp();    
        if ($unUtilisateur!=null){            
                $_SESSION['login'] = $inputEmail;                
                $_SESSION['role'] = $unUtilisateur['idRole'];     
                header("Location:index.php");          
            }         
        }else{           
            $form['valide'] = false;           
            $form['message'] = 'email ou mot de passe non defini';        
        }
    echo $twig->render('mdplost.html.twig', array());
}

function deconnexionControleur($twig, $db){ 
    session_unset();    
    session_destroy();    
    header("Location:index.php");
}
?>