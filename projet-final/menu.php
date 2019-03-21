<?php
$strNomUtilisateur = "Louis-Marie Brousseau";

require_once "en-tete.php";

session_destroy();

$_SESSION["pageAvant"] = "menu.php";
?>

<div>
    <h1 class="sCentre">
        Fonctionnalité des professeurs
    </h1>
    <ul class="sCentre sMenu">
        <li class="">
            <a href="#">
                Mettre à jour la liste des documents
            </a>
            <p>
                Cliquez sur le lien ci-dessus si vous désirez ajoutez/modifier/retirer un ou plusieurs documents.
            </p>
        </li>
        <li class="">
            <a onclick="soumettrePageEtat(0,'option2.php');">
                Mettre à jour les tables de référence
            </a>
            <p>
                Cliquez sur le lien ci-dessus si vous désirez ajouter/modifier/retirer une ou plusieurs sessions, cours, catégories de document et/ou utilisateurs.
            </p>
        </li>
        <li class="">
            <a onclick="window.location.href = 'option3.php'">
                Assigner les privilèges d'accès aux documents
            </a>
            <p>
                Cliquez sur le lien ci-dessus pour assigner les privilèges d'accès aux documents pour un ou plusieurs utilisateurs.
            </p>
        </li>
        <li class="">
            <a onclick="window.location.href = 'option4.php'">
                Assigner un groupe d'utillisateur à un cours-session
            </a>
            <p>
                Clliquez sur le lien ci-dessus si vous désirez ajouter une série d'utilisateurs et les assigner à un cours-session existant.
            </p>
        </li>
        <li class="">
            <a href="#">
                Reconstruire l'arborescence des documents
            </a>
            <p>
                Cliquez sur le lien ci-dessus si vous désirez effectuer du ménage dans les listes de documents enregistrés.
            </p>
        </li>
        <li class="">
            <a href="#">
                Terminer l'application
            </a>
            <p>
                Que dire de plus?
            </p>
        </li>
    </ul>
</div>

<?php
require_once "pied-page.php";