<?php

require_once 'classe-mysql-2018-03-16.php';
require_once 'librairies-communes-2018-03-16.php';

$strNomUtilisateur = "Connectez-vous S.V.P."; //doit etre une variable de session
require_once "en-tete.php"; 

if (isset($_SESSION["nomComplet"])) {
    session_unset(); 
    session_destroy();
}

$strIdNomUtil = "nomUtil";
$strIdPass = "pass";

//$intEtat = post("hidEtat");

if (post($strIdNomUtil) && post($strIdPass)) { // la pers a ecrit qqchose dans les deux inputs
    //ouverture de la BD
    $strMonIP = "";
    $strIPServeur = "";
    $strNomServeur = "";
    $strInfosSensibles = "";
    detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);
	
	debug_to_console($strInfosSensibles);

    /* --- Initialisation des variables de travail --- */
    $strNomBD="pjf_microvox";
    $strLocalHost = "localhost";

    /* --- Création de l'instance, connexion avec mySQL et sélection de la base de données --- */
    $BDConnexion = new mysql($strNomBD, $strInfosSensibles);
    
    $strTableUtilisateur = "Utilisateur";
    $strRequeteUtilisateur = "nomUtil, pass, statutAdmin, nomComplet";
    $arrLogin = $BDConnexion->retourneSelect($strTableUtilisateur, $strRequeteUtilisateur);
    
    $strTableCheck1ereConnexion = "Check1ereConnexion";
    $strRequeteCheck1ereConnexion = "id";
    $arrCheck1ereConnexion = $BDConnexion->retourneSelect($strTableCheck1ereConnexion, $strRequeteCheck1ereConnexion);
    $BDConnexion->deconnexion();
    
    //debug_to_console($arrLogin[0].", ".$arrLogin[1]);
    
    if (empty($arrLogin) || empty($arrCheck1ereConnexion)) { // rien dans la table Utilisateur
        die(str_repeat("<br/><br/>", 10)."<strong>Table vide dans la base de données !!! Veuillez contacter votre administrateur système !!!</strong>".str_repeat("<br/><br/>", 10));
    }
    else { // qqchose dans la table Utilisateur
        $blnTrouve = false;
        $blnCheck1ereConnexion = $arrCheck1ereConnexion[0]==="0" ? false : true;
        
        foreach ($arrLogin as $value) { //parcours la array qui contient les champs nomUtil et pass
            list($strBDUser, $strBDPass, $strStatutAdmin, $strNomComplet) = explode(";", $value);
            if (post($strIdNomUtil)==$strBDUser && post($strIdPass)==$strBDPass) { //
                //debug_to_console(post("hidEtat"));
                $blnTrouve = true;
                break;
            }
        }
        
        if (!$blnTrouve) { //les champs du login ne match pas
            //debug_to_console("bug inexplicable. "); //echo sans raison ???????????????????????????????????????????????????????
            ?>

            <script type="text/javascript">alert("Votre nom utilisateur ou votre mot de passe n\'est pas dans la base de données");</script>
            
            <?php
            //debug_to_console("apres");
        }
        else { //match
            if ($blnCheck1ereConnexion) { //si 1ere connexion
                //$BDConnexion->OK = mysqli_query($BDConnexion->cBD, "flush tables");
                
                header("Location: identificationAdmin.php");
                exit();
            }
            else {
                session_start();
                list($strNom, $strPrenom) = explode(",", $strNomComplet);
                $_SESSION["nomComplet"] = $strPrenom." ".$strNom;
                $_SESSION["pageAvant"] = null;
                $_SESSION["etatPageAvant"] = 0;
                //debug_to_console($strNomComplet);
                
                //debug_to_console($strStatutAdmin);
                
                if ($strStatutAdmin==="1") { //la pers est admin
                    header("Location: menuAdmin.php");
                }
                else { //la pers est utilisateur normal
                    header("Location: moduleUtilisateur.php");
                }
                
                exit();
            }
        }
    }
}
?>

<!--https://codepen.io/10tribu/pen/FzGdK-->
<div id="warp">
    <div class="admin">
      <div class="rota">
          <h1 class="h1Connexion">MICRO</h1>
          <input class="inputConnexion" id="<?php echo $strIdNomUtil; ?>" type="text" name="<?php echo $strIdNomUtil; ?>" pattern=".{3,25}" title="3 à 25 charactères" value="<?php echo post($strIdNomUtil); ?>" placeholder="Nom utilisateur" required autofocus/><br />
          <input class="inputConnexion" id="<?php echo $strIdPass; ?>" type="password" name="<?php echo $strIdPass; ?>" pattern=".{3,15}" title="3 à 15 charactères" value="" placeholder="Mot de passe" required/>
      </div>
    </div>
    <div class="cms">
      <div class="roti">
        <h1 class="h1Connexion">VOX</h1>
        <button class="btnConnexion" id="connexion" type="submit" name="connexion" style="border-radius: 0px;">Connexion</button><br />
      </div>
    </div>
</div>

<?php
require_once "pied-page.php";
