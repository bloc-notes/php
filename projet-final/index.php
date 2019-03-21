<?php

$strTitreApplication = "Microvox";
$strNomFichierCSS = "index.css";
$strNomAuteur = "Équipe Microvox";
$strModeTransmission = "get";
$intEtat = 11;

require_once "en-tete.php";

?>
<nav class="sMenuGauche">
    <ul class="sMenu">
        <li class="">
            <a href="#">
                Mettre à jour la liste des documents
            </a>
        </li>
        <li class="">
            <a href="#">
                Mettre à jour les tables de référence
            </a>
        </li>
        <li class="">
            <a href="#">
                Assigner les privilèges d'accès aux documents
            </a>
        </li>
        <li class="">
            <a href="#">
                Assigner un groupe d'utillisateur à un cours-session
            </a>
        </li>
        <li class="">
            <a href="#">
                Reconstruire l'arborescence des documents
            </a>
        </li>
    </ul>
</nav>
<?php

switch ($intEtat) {
    case 0:
?>

<div class="sCentre">
    <h1>
        Option disponible pour les tables de références
    </h1>
    <ul class="sMenu">
        <li class="sOption">
            <a href='#'>
                Gestion des sessions d'étude
            </a>
        </li>
        <li class="sOption">
            <a href='#'>
                Gestion des cours
            </a>
        </li>
        <li class="sOption">
            <a href='#'>
                Gestion des cours-sessions
            </a>
        </li>
        <li class="sOption">
            <a href='#'>
                Gestion des catégories de document
            </a>
        </li>
        <li class="sOption">
            <a href='#'>
                Gestion des utilisateurs
            </a>
        </li>
    </ul>
</div>

<?php
        break;
    case 1:
?>
<section class="sCentre">
    <header>
        <p>
            Gestion des sessions d'étude
        </p>
    </header>
    <article>
        <h2>
            Liste des sessions
        </h2>
        
    </article>
    <footer>
        <button>Ajouter</button>
        <button>Modifier</button>
        <button>Retirer</button>
    </footer>
</section>

<?php
        break;
    case 11:
    case 12:
    case 13:
?>
<        
<div class="sCentre">
    <p>
        Session d'étude
    </p>
    <p>
        Période dans l'année
    </p>
    <select id="ddlPeriodeAnnee" name="ddlPeriodeAnnee">
        <option value="A">Automne</option>
        <option value="E">Été</option>
        <option value="H">Hiver</option>
    </select>
    <p>
        Année de la session
    </p>
    <select id="ddlAnnee" name="ddlAnnee">
        <option value="2018">2018</option>
        <option value="2019">2019</option>
        <option value="2020">2020</option>
        <option value="2021">2021</option>
    </select>
    <label for="dtDebut">Date de début de la session</label>
    <input id="dtDebut" name="dtDebut" type="date" min="2018-01-01" max="2021-12-31"/>
    <label for="dtFin">Date de fin de la session</label>
    <input id="dtFin" name="dtfin" type="date" min="2018-01-01" max="2021-12-31"/>
    <button><?php echo $intEtat != 13 ? "Soumettre" : "Retirer";?></button>
    <button>Annuler</button>
</div>    

<?php
        break;
    case 41;
    case 42:
    case 43:
?>
<div class="sCentre">
    <p>
        Nom de la catégorie
    </p>
    <input id="tbCategorie" name="tbCategorie" type="text" max="15"/>
    <button><?php echo $intEtat != 43 ? "Soumettre" : "Retirer";?></button>
    <button>Annuler</button>
</div>
<?php
        break;
    case 51:
    case 52:
    case 53:
?>
<div class="sCentre">
    <p>
        Nom d'utilisateur
    </p>
    <input id="tbNomUtil" name="tbNomUtil" type="text" max="25"/>
    <p>
        Mot de passe
    </p>
    <input id="tbMDP" name="tbMDP" type="text" max="15"/>
    <input id="cbAffMDP" name="cbAffMDP" type="checkbox"/>
    <label for="cbAffMDP">Affiche le mot de passe</label>
    <input id="rbStatutUtilli" name="rbStatut" type="radio"/>
    <label for="rbStatutUtilli">Utilisateur</label>
    <input id="rbStatutAdmin" name="rbStatut" type="radio" checked/>
    <label for="rbStatutAdmin">Administrateur</label>
    <p>
        Nom complet
    </p>
    <input id="tbNomComplet" name="tbNomComplet" type="text" max="30"/>
    <p>
        Adresse de courriel
    </p>
    <input id="tbCourriel" name="tbCourriel" type="text" max="50"/>
    <button><?php echo $intEtat != 53 ? "Soumettre" : "Retirer";?></button>
    <button>Annuler</button>
</div>
<?php
        break;
}

require_once "pied-page.php";
