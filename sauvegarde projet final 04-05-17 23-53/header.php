<?php
//session_start();

//1 = Administrateur
//2 = le reste des utilisateurs
//3 = Pas encore connecter
$intTypeAffichage = null;

$strPrenom ="Inconnu";
$strNom = "";

//Page de non-connection
if((basename($_SERVER['SCRIPT_NAME']) == "index.php" || basename($_SERVER['SCRIPT_NAME']) == "enregistrement.php"  
        || basename($_SERVER['SCRIPT_NAME']) == "PleaseValidate.php" || basename($_SERVER['SCRIPT_NAME']) == "emailValidate.php" 
        || basename($_SERVER['SCRIPT_NAME']) == 'changerPasswordAnonyme.php' || basename($_SERVER['SCRIPT_NAME']) == "deconnexion.php")){ 
    $intTypeAffichage = 3;
}

if(empty($intTypeAffichage)){
    $intTypeAffichage = $_SESSION["Statut"] == 1 ? 1: 2;
    $strPrenom = $_SESSION["Prenon"];
    $strNom = $_SESSION["Nom"];
}
?>

<?php
if($intTypeAffichage == 1){
?>
<header>
    <form id="frmSaisie" method="" action="">
    <div id="divEntete" class="sEntete">
        <p class="sTitreApplication red-orange-brown" >
            QWERTY
        </p>
        <p class=" rainbow" >
            L
        </p>
        <p>
        <a href="affichageAnnonce.php" >
            AFFICHAGE ANNONCES
        </a>
        <a href="affichageUtilisateur.php" >
            AFFICHAGE UTILISATEURS
        </a> 
        <a href="nettoyageBaseDonnee.php" >
            OPTION BASE DE DONNÉES
        </a> 
                  <a href="deconnexion.php" >
            DÉCONNEXION
        </a>
        <span class="sNomUtilisateur">
             (administrateur) <?php echo $strPrenom . " " . $strNom; ?>  
        </span>    
        </p>
    </div>
    </from>
</header>
<?php
}
else if($intTypeAffichage == 2){
?>
<header>
    <form id="frmSaisie" method="" action="">
    <div id="divEntete" class="sEntete">
        <p class="sTitreApplication red-orange-brown" >
            QWERTY
         </p>
        <p class=" rainbow" >
            L
        </p>
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
        <a href="deconnexion.php" >
            DÉCONNEXION
        </a>

        <span class="sNomUtilisateur">
             (utilisateur) <?php echo $strPrenom . " " . $strNom; ?>  
        </span>    
        </p>
    </div>
    </from>
</header>
<?php
}
else{
?>     
<header>
<div id="divEntete" class="sEntete"> 
    <p class="sTitreApplication" >
        QWERTY
    </p>
    <p class=" rainbow" >
            L
    </p>      
</div>
</header>
<?php
}
