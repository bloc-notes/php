<!DOCTYPE html>
<html>
<head>
    <title>Création des équipes pour le projet final</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="index.css" />
    <script type="text/javascript">
        function confirmationDemandee() {
            if (confirm("Cliquer sur OK pour reconstruire les tables; autrement ANNULER.")) {
               window.location = 'index.php?Reinitialisation=Oui';
            }
        }
    </script>
</head>
<body>
    <form id="frmSaisie" method="post" action="">
        <input id="Matricule" name="Matricule" type="hidden" value="1378673" />
        <input id="Trace" name="Trace" type="hidden" value="0" />

        <div id="divEntete" class="sDivEntete">
            <p class="sTitreApplication">
                Projet 2 : Création des équipes pour le projet final
                <span class="sTitreSection">
                    <br />par <span class="sRouge">Philippe Doyon</span>
                    <a class="sConsigne sBleu" href="index.php?Deconnexion=Oui&Matricule=1378673&Trace=0">Déconnexion</a>
                    <a class="sConsigne sBleu" href="javascript:confirmationDemandee()">Réinitialisation des tables</a>
                    <br />
                </span>
            </p>
        </div>

