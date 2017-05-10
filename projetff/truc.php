<?php
$booAdmin = true;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
   <title>QWERTY</title>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <link rel="stylesheet" href="styleSheet.css">
<script language="javascript" type="text/javascript" src="generalScript.js"></script>
</head>
<body>
   <form id="frmSaisie" method="" action="">
      <div id="divEntete" class="sEntete">
         <p class="sTitreApplication" >
            QWERTY
         </p>
<?php
if($booAdmin){
?>
         <p>
         <a href="Page 1" >
            AFFICHAGE ANNONCES
         </a>
         <a href="Page 2" >
            AFFICHAGE UTILISATEURS
         </a> 
         <a href="Page 3" >
            OPTION BASE DE DONNÉES
         </a> 
         <span class="sNomUtilisateur">
             (administrateur) Philippe
         </span>    
         </p>
      </div>
<?php
}
else{
?>
         <p>
         <a href="Page 1" >
            ANNONCE
         </a>
         <a href="Page 2" >
            GESTION DES ANNONCES PERSONNELS
         </a> 
         <a href="Page 3" >
            GESTION PROFIL
         </a> 
         <a href="Page 4" >
            DÉCONNEXION
         </a>
         <span class="sNomUtilisateur">
             (utilisateur) Philippe
         </span>    
         </p>
      </div>
<?php
}
?>