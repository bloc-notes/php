<?php 
require_once 'classe-mysql-2018-03-16.php';
require_once "librairies-communes-2018-03-16.php";

session_start();
$strNomUtilisateur = $_SESSION["nomComplet"];
require_once './en-tete.php';

$strIdNomUtilModifie = "nomUtilModifie";
$strIdPassModifie = "passModifie";
$strIDNomComplet = "nomComplet";
$strIDCourriel = "courriel";

if (post($strIdNomUtilModifie) && post($strIdPassModifie) && post($strIDNomComplet) && post($strIDCourriel)) { // qqchose a ete ecris dans les inputs 
    $blnToutOK = true;

    if (post($strIdNomUtilModifie)=="admin" || post($strIdPassModifie)=="admin") {
        $blnToutOK = false;
        //debug_to_console("bug inexplicable. "); //echo sans raison ???????????????????????????????????????????????????????
        echo "<script type=\"text/javascript\"> alert('Votre nom utilisateur ou votre mot de passe ne doit pas contenir le champs \'admin\''); </script>";
    }

    if (!filter_var(filter_var(post($strIDCourriel), FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL)) { //check email
        $blnToutOK = false;
        debug_to_console("bug inexplicable. "); //echo sans raison ???????????????????????????????????????????????????????
        echo "<script type=\"text/javascript\"> alert('Votre courriel n\'est pas valide'); </script>";
    }

    if ($blnToutOK) { //connexion a la bd et redirection vers la page de connexion
        //ouverture de la BD
        $strMonIP = "";
        $strIPServeur = "";
        $strNomServeur = "";
        $strInfosSensibles = "";
        detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);

        /* --- Initialisation des variables de travail --- */
        $strNomBD="pjf_microvox";
        $strLocalHost = "localhost";

        /* --- Création de l'instance, connexion avec mySQL et sélection de la base de données --- */
        $BDIdentificationAdmin = new mysql($strNomBD, $strInfosSensibles);

        $strTableCheck1ereConnexion = "Check1ereConnexion";
        $strRequeteCheck1ereConnexion = "id";
        $arrCheck1ereConnexion = $BDIdentificationAdmin->retourneSelect($strTableCheck1ereConnexion, $strRequeteCheck1ereConnexion);
        //$BDIdentificationAdmin->deconnexion();

        if (empty($arrCheck1ereConnexion)) {
            die(str_repeat("<br/><br/>", 10)."<strong>Table vide dans la base de données !!! Veuillez contacter votre administrateur système !!!</strong>".str_repeat("<br/><br/>", 10));
        }
        else {
            $strTableUtilisateur = "Utilisateur";

            $blnCheck1ereConnexion = $arrCheck1ereConnexion[0]==="0" ? false : true;

            if ($blnCheck1ereConnexion) { //si 1ere fois, efface le admin utilisateur et le id check1ereconnexion
                $strRequeteCheck1ereConnexion = "id=b'0'";
                $BDIdentificationAdmin->modifieDonnees($strTableCheck1ereConnexion, $strRequeteCheck1ereConnexion) ;

                $strRequeteUtilisateur = "nomUtil='admin' && pass='admin'";
                $BDIdentificationAdmin->effaceDonnees($strTableUtilisateur, $strRequeteUtilisateur);
            }


            $strRequeteUtilisateur = "'".post($strIdNomUtilModifie)."', '".post($strIdPassModifie)."', 1, '".post($strIDNomComplet)."', '".post($strIDCourriel)."'";
            $BDIdentificationAdmin->insereDonnees($strTableUtilisateur, $strRequeteUtilisateur);

            header("Location: connexion.php");
            exit();
        }
    }
}
?>

<div align="center">
    <h1 class="sCentre">
        Veillez remplir les champs obligatoires suivants<br /><br />
    </h1>
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td>
                Nouveau nom utilisateur:
            </td>
            <td>
                <input id="<?php echo $strIdNomUtilModifie; ?>" name="<?php echo $strIdNomUtilModifie; ?>" type="text" pattern=".{3,25}" title="3 à 25 charactères" value="<?php echo post($strIdNomUtilModifie); ?>" required autofocus/>
            </td>
        </tr>
        <tr>
            <td>
                Nouveau mot de passe:
            </td>
            <td>
                <input id="<?php echo $strIdPassModifie; ?>" name="<?php echo $strIdPassModifie; ?>" type="password" pattern=".{3,15}" title="3 à 15 charactères" value="" required/>
            </td>
            <td>
                <input type="checkbox" onclick="voirMotDePasse()"/>Voir le mot de passe
            </td>
        </tr>
        <!--add input for adminStatus-->
        <tr>
            <td>
                Nom complet:
            </td>
            <td>
                <input id="<?php echo $strIDNomComplet; ?>" name="<?php echo $strIDNomComplet; ?>" type="text" pattern=".{5,30}" title="5 à 30 charactères" value="<?php echo post($strIDNomComplet); ?>" required/>
            </td>
        </tr>
        <tr>
            <td>
                Courriel:
            </td>
            <td>
                <input id="<?php echo $strIDCourriel; ?>" name="<?php echo $strIDCourriel; ?>" type="text" pattern=".{10,50}" title="10 à 50 charactères" value="<?php echo post($strIDCourriel); ?>" required/>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> 
                <input id ="btnSoumettre" name="btnSoumettre" type="submit" value="Connexion"/><br/><br/>
            </td>
        </tr>
    </table>
</div>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

<!--https://www.w3schools.com/howto/howto_js_toggle_password.asp-->
<script type="text/javascript">
    function voirMotDePasse() {
        var x = document.getElementById(<?php echo json_encode($strIdPassModifie); ?>);
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

<?php
require_once './pied-page.php';