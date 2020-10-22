<?php
function generateMdp(){
    $chaine = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $mdp = "";
       
        $mdp .= $chaine[rand(0,25)];
        $mdp .= $chaine[rand(0,25)];
        
        $mdp .= $chaine[rand(26,51)];
        $mdp .= $chaine[rand(26,51)];
        
        $mdp .= $chaine[rand(52,60)];
        $mdp .= $chaine[rand(52,60)];
        
        $mdp = str_shuffle($mdp);
    
        return $mdp;
}

function connectBDD($nameBdd, $root, $host, $mdpBdd){
    try{//connection bdd
        $bdd = new PDO("mysql:host=".$host.";dbname=".$nameBdd."","".$root."","".$mdpBdd."");
    }catch(Exception $e){//erreur de connection
        die("erreur connection bdd");
    }
    
    return $bdd;
}

?>