<?php

require_once 'classe-mysql-2018-03-16.php';
require_once 'librairies-communes-2018-03-16.php';

$strModeTransmission = "post";
$strNomUtilisateur = "Non connecté"; //doit etre une variable de session
require_once './en-tete.php';

$strBtnInitTables = "creeInitTable";

$strNomBD="pjf_microvox";

function creeTable($strNomBD) {
    $strMonIP = "";
    $strIPServeur = "";
    $strNomServeur = "";
    $strInfosSensibles = "";
    detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);

    /* --- Initialisation des variables de travail --- */
    //$strNomBD="pjf_microvox";
    $strLocalHost = "localhost";

    /* --- Création de l'instance, connexion avec mySQL et sélection de la base de données --- */
    $BDProjetFinalGestionTables = new mysql($strNomBD, $strInfosSensibles);

    /* --- Création de la structure des tables --- */
    $strTableUtilisateur = "Utilisateur";
    $strTableCours = "Cours";
    $strTableCategorie = "Categorie";
    $strTableDocument = "Document";
    $strTableSession = "PF_Session";
    $strTableCoursSession = "CoursSession";
    
    $strTableCheck1ereConnexion = "Check1ereConnexion";

    //suppression des toutes les tables si elles existent
    $BDProjetFinalGestionTables->supprimeTable($strTableCheck1ereConnexion, $strTableUtilisateur, $strTableCours, $strTableCategorie, $strTableDocument, $strTableSession, $strTableCoursSession);

    //table Utilisateur
    $strContenuUtilisateur = "nomUtil varchar(25), " //PK_nomUtil
            . "pass varchar(15) not null, "
            . "statutAdmin bit not null, "
            . "nomComplet varchar(30) not null, "
            . "courriel varchar(50) not null";
    $strClefsUtilisateur = "constraint PK_nomUtil primary key(nomUtil)";
    $BDProjetFinalGestionTables->creeTableNormale($strTableUtilisateur, $strContenuUtilisateur, $strClefsUtilisateur);

    //table Cours
    $strContenuCours = "sigleCours varchar(7), " //PK_sigleCours
            . "titre varchar(50) not null";
            //. "nomUtilCours varchar(50) not null"; //FK_nomUtilCours
    $strClefsCours = "constraint PK_sigleCours primary key(sigleCours)";
            //. "constraint FK_nomUtilCours foreign key(nomUtilCours) references Utilisateur(nomUtil)";
    $BDProjetFinalGestionTables->creeTableNormale($strTableCours, $strContenuCours, $strClefsCours);

    //table Categorie
    $strContenuCategorie = "cat_nomCategorie varchar(15)";
    $strClefsCategorie = "constraint PK_Categorie primary key(cat_nomCategorie)";
    $BDProjetFinalGestionTables->creeTableNormale($strTableCategorie, $strContenuCategorie, $strClefsCategorie);

    //table Document
    $strContenuDocument = "sessionDoc varchar(6) not null, "
            . "sigleCoursDoc varchar(7) not null, " //FK_sigleCoursDoc
            . "dateCours date not null, "
            . "noSequence int not null, "
            . "dateAccesDebut date not null, "
            . "dateAccesFin date not null, "
            . "titre varchar(100) not null, "
            . "description varchar(255) not null, "
            . "nbPages int not null, "
            . "doc_Categorie varchar(15) not null, " //FK_nomCategorieDoc
            . "noVersion int not null, "
            . "dateVersion date not null, "
            . "hyperLien varchar(255) not null, "
            . "ajoutePar varchar(25) not null, " //FK_nomUtilDoc
            . "suppressionFinale int not null";
    $strClefsDocument = "constraint FK_sigleCoursDoc foreign key(sigleCoursDoc) references Cours(sigleCours) ON UPDATE CASCADE, "
            . "constraint FK_nomCategorieDoc foreign key(doc_Categorie) references Categorie(cat_nomCategorie) ON UPDATE CASCADE, "
            . "constraint FK_nomUtilDoc foreign key(ajoutePar) references Utilisateur(nomUtil) ON UPDATE CASCADE";
    $BDProjetFinalGestionTables->creeTableNormale($strTableDocument, $strContenuDocument, $strClefsDocument);

    //table Session
    $strContenuSession = "session varchar(6), " //PK_session
            . "dateDebut date not null, "
            . "dateFin date not null";
    $strClefsSession = "constraint PK_session primary key(session)";
    $BDProjetFinalGestionTables->creeTableNormale($strTableSession, $strContenuSession, $strClefsSession);

    //table CoursSession
    $strContenuCoursSession = "sessionCoursSession varchar(6) not null, " //FK_sessionCoursSession
            . "sigleCoursCoursSession varchar(7) not null, " //FK_sigleCoursCoursSession
            . "nomUtilCoursSession varchar(25) not null"; //FK_nomUtilCoursSession
    $strClefsCoursSession = "constraint FK_sessionCoursSession foreign key(sessionCoursSession) references PF_Session(session) ON UPDATE CASCADE, "
            . "constraint FK_sigleCoursCoursSession foreign key(sigleCoursCoursSession) references Cours(sigleCours) ON UPDATE CASCADE, "
            . "constraint FK_nomUtilCoursSession foreign key(nomUtilCoursSession) references Utilisateur(nomUtil) ON UPDATE CASCADE, "
            . "constraint PK_PrimaryKey primary key(sessionCoursSession, sigleCoursCoursSession)";
    $BDProjetFinalGestionTables->creeTableNormale($strTableCoursSession, $strContenuCoursSession, $strClefsCoursSession);

    $strValuesNomUtil = "'admin', 'admin', 1, 'adminAdmin', 'admin@cgodin.qc.ca'";
    $BDProjetFinalGestionTables->insereDonnees($strTableUtilisateur, $strValuesNomUtil); //insertion initiale

    /*$strRequeteUtilisateur = "nomUtil='admin'";
    $BDProjetFinalGestionTables->supprimeDonnees($strTableUtilisateur);*/

    /*$strU = "";
    $strP = "";
    list($strU, $strP, $strNC) = explode(",", $BDProjetFinalGestionTables->retourneSelect($strTableUtilisateur, "nomUtil, pass, nomComplet"));
    echo $strU." user, ".$strP." pass, ".$strNC;
    $strVerdict = "Select de la table <span class=\"sGras\">'".$strTableUtilisateur."'</span> " . ($BDProjetFinalGestionTables->OK ? "confirmée" : "impossible");
    requeteExecutee("retourneSelect()", $BDProjetFinalGestionTables->requete, $strVerdict);*/
    
    //table Check1ereConnexion pour savoir si c'est la 1ere fois que l'utilisateur se connecte
    $strContenuCheck1ereConnexion = "id bit not null";
    $BDProjetFinalGestionTables->creeTableNormale($strTableCheck1ereConnexion, $strContenuCheck1ereConnexion);
    
    $strValueCheck1ereConnexion = "b'1'";
    $BDProjetFinalGestionTables->insereDonnees($strTableCheck1ereConnexion, $strValueCheck1ereConnexion); //insertion initiale

    $BDProjetFinalGestionTables->deconnexion(); //deconnexion de la BD
}

//debug_to_console($_SERVER['REQUEST_METHOD']);

if (isset($_POST[$strBtnInitTables])) {
    //debug_to_console("inside function");
    creeTable($strNomBD);
}
?>

<div>
    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    <h1 class="sCentre">
        Initialiser les tables de la base de donnée '<?php echo $strNomBD; ?>'
    </h1>
    <ul class="sCentre sMenu">
        <button id="<?php echo $strBtnInitTables ?>" type="submit" name="<?php echo $strBtnInitTables ?>" onclick="return confirm('Êtes-vous sûr de créer à nouveau toutes les tables de la base de données \'<?php echo $strNomBD; ?>\' ?')"><strong>Initialiser</strong></button><br />
    </ul>
    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
</div>

<?php
require_once './pied-page.php';