<?php
session_start();
//Si la personne n'a pas le doit d'être sur cette page
if(!(basename($_SERVER['SCRIPT_NAME']) == "index.php" || basename($_SERVER['SCRIPT_NAME']) == "enregistrement.php"  
        || basename($_SERVER['SCRIPT_NAME']) == "PleaseValidate.php" || basename($_SERVER['SCRIPT_NAME']) == "emailValidate.php" 
        || basename($_SERVER['SCRIPT_NAME']) == 'changerPasswordAnonyme.php') && (isset($_SESSION["NoUtilisateur"]) != 1)){
?>
<script>location.href = 'index.php';</script>
<?php
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Si manque prénom ou nom
if(basename($_SERVER['SCRIPT_NAME']) == "modifierUtilisateur.php" && ($_SESSION["Prenon"] == "" || $_SESSION["Nom"] == "")){ ////Rajoute la condition
    echo "<script>alert(\"Vous devez inscrire un prénom et un nom obligatoirement!\")</script>";
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if((isset($_SESSION["NoUtilisateur"]) == true ) && (($_SESSION["Prenon"] == "" || $_SESSION["Nom"] == ""))
        && !((basename($_SERVER['SCRIPT_NAME']) == "modifierUtilisateur.php" || basename($_SERVER['SCRIPT_NAME']) == "deconnexion.php"))){  
?>
<script>location.href = 'modifierUtilisateur.php';</script>
<?php
}