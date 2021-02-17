<?php
function typeControleur($twig, $db){    
    $form = array();  
    $type = new type($db);    
    $liste = $type->select();    
    echo $twig->render('type.html.twig', array('form'=>$form,'liste'=>$liste));
}
?>