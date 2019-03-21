<!DOCTYPE html>
<html>
<head>
    <title>Microvox</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="index.css" />
    <script type="text/javascript">
        var intAncienneColonneSelectionne = 1;
        function soumettrePage(strNomPage, strNomForm) {
            var frm;
            frm = document.getElementById(strNomForm);
            frm.action = strNomPage;
            frm.submit();
        }
        
        function soumettrePageEtat(intEtat,strNomPageDestination) {
            document.getElementById('hidEtat').value = intEtat;
            document.getElementById('hidIdElement').value = intAncienneColonneSelectionne;
            var frm;
            frm = document.getElementById('frmEtat');
            frm.action = strNomPageDestination;
            frm.submit();
        }
        
        function soumettrePageElementInactif() {
            document.querySelectorAll('select').forEach(i => i.disabled = false);
            document.getElementById('frmSaisie').submit();
        }
        
        //https://stackoverflow.com/questions/14226803/javascript-wait-5-seconds-before-executing-next-line
        const attendre = (ms) => {
            return new Promise((tente) => {
                setTimeout(tente, ms);
            });
        };

        async function erreur() {
            await attendre(1000);
            alert('Action dans la Base de donnée impossible!');
        }
    </script>
</head>
<body class="sBeigeFont">
    <?php
        function debug_to_console( $data ) {
            $output = $data;
            if ( is_array( $output ) )
                $output = explode( ',', $output);

            echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
        }
        
        /*function post($strNomParametre) {
            return isset($_POST[$strNomParametre]) ? $_POST[$strNomParametre] : null;
        }*/
    ?>
    
    <form id="frmSaisie" method="post" action="<?php isset($_SESSION["actionFrmSaisie"]) ? $_SESSION["actionFrmSaisie"] : ""; ?>">
        <header id="divEntete" class="sEntete">
            <p class="sTitreApplication sBeigePolice">
                Microvox
                <span style="float: left; position: relative; left: 50%;" class="sPolice15">
                    <span style="float: left; position: relative; left: -50%;">
                        <label><?php echo ($strNomUtilisateur!="Connectez-vous S.V.P.") ? "Bienvenue ".$strNomUtilisateur : $strNomUtilisateur;?></label>
                    </span>
                    <!--<a id="aDeco" href="connexion.php">Déconnexion</a>-->
                </span>

                <?php //debug_to_console("etat ".$_SESSION["etatPageAvant"].", page ".$_SESSION["pageAvant"]); //debug_to_console(post("hidEtat").", ".basename($_SERVER["REQUEST_URI"])); ?>
                <?php //debug_to_console(basename($_SERVER["REQUEST_URI"])); ?>
                
                <span style="margin-right: 45px; float: left;" class="<?php echo (!isset($_SESSION["pageAvant"]) || basename($_SERVER["REQUEST_URI"])=="connexion.php" || basename($_SERVER["REQUEST_URI"])=="moduleUtilisateur.php") ? "arrowLeftNotWorking" : "arrowLeftWorking"; ?> sContenuDroite" <?php if (isset($_SESSION["pageAvant"]) && isset($_SESSION["etatPageAvant"]) && basename($_SERVER["REQUEST_URI"])!="connexion.php" && basename($_SERVER["REQUEST_URI"])!="moduleUtilisateur.php") echo 'onclick="soumettrePageEtat('.$_SESSION["etatPageAvant"].', \''.((basename($_SERVER["REQUEST_URI"])==$_SESSION["pageAvant"] && post("hidEtat")=="0") ? "menuAdmin.php" : $_SESSION["pageAvant"]).'\');"'; ?>></span>
                
                <span style="float: left;" class="<?php echo (basename($_SERVER["REQUEST_URI"])=="connexion.php") ? "arrowUpNotWorking" : "arrowUpWorking"; ?> sContenuDroite" onclick="<?php if (basename($_SERVER["REQUEST_URI"])!="connexion.php") echo "location='connexion.php'"; ?>"></span>
            </p>
        </header>