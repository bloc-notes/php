<?php
$booAdmin = true;
?>
<header>
   <form id="frmSaisie" method="" action="">
      <div id="divEntete" class="sEntete">
         <p class="sTitreApplication" >
            QWERTY
         </p>
                   <p class=" rainbow" >
            L
         </p>
<?php
if($booAdmin){
?>
         <p>
         <a href="affichageAnnonceAdministrateur.php" >
            AFFICHAGE ANNONCES
         </a>
         <a href="affichageUtilisateur.php" >
            AFFICHAGE UTILISATEURS
         </a> 
         <a href="nettoyageBaseDonnee.php" >
            OPTION BASE DE DONNÉES
         </a> 
                  <a href="index.php" >
            DÉCONNEXION
         </a>
         <span class="sNomUtilisateur">
             (administrateur) Philippe Doyon
         </span>    
         </p>
      </div>
           </header>
<?php
}
else{
?>
         <p>
         <a href="affichageAnnonce.php" >
            ANNONCE
         </a>
         <a href="affichageAnnonceUtilisateur.php" >
            GESTION DES ANNONCES PERSONNELS
         </a> 
         <a href="profilUtilisateur.php" >
            GESTION PROFIL
         </a> 
         <a href="index.php" >
            DÉCONNEXION
         </a>
         <span class="sNomUtilisateur">
             (utilisateur) Philippe Doyon
         </span>    
         </p>
      </div>
     </form>
     </header>
<?php
}
?>