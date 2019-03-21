<?php

/* Réf.: http://fr.openclassrooms.com/informatique/cours/ajax-et-l-echange-de-donnees-en-javascript/l-access-control-1 */
header("Access-Control-Allow-Origin: *");

require_once ("librairies-communes-2018-03-29-Doyon.php");
require_once ("classe-mysql-2018-04-30-Doyon.php");
require_once("librairie-pour-gere-prenoms.php");
/*
  |-------------------------------------------------------------------------------------|
  | class reponseAJAX
  |-------------------------------------------------------------------------------------|
 */

class reponseAJAX {

    public $binErreurFatale = false;
    public $strAction = null;
    public $binActionSaisie = false;
    public $binActionValide = false;
    public $strPrenom = "";
    public $binPrenomSaisi = false;
    public $binPrenomPresent = false;
    public $strNouveauPrenom = "";
    public $binNouveauPrenomSaisi = true;
    public $binNouveauPrenomPresent = false;
    public $tListePrenoms = array();
    public $intNbPrenoms = "N/A";

    /*
      |----------------------------------------------------------------------------------|
      | construct
      |----------------------------------------------------------------------------------|
     */

    function __construct() {
        $this->strAction = request("Action");
        $this->strPrenom = request("Prenom");
        $this->strNouveauPrenom = request("NouveauPrenom");

        //Empêche le traitement inutile de donnée absente ou inutilisable
        //Un booléen est associer à chaque donnée recue
        //Action saisie?
        if ($this->strAction) {
            $this->binActionSaisie = true;
            //Action valide?
            if (trouveDansChaine($this->strAction, "ajouter,renommer,retirer,afficher,valider,vider", $intPos)) {
                $this->binActionValide = true;
                //Prénom présent?
                if ($this->strPrenom || $this->strAction == "afficher" || $this->strAction == "vider") {
                    $this->binPrenomSaisi = true;
                    //Prénom présent lors renommer?
                    if ($this->strAction == "renommer" && !$this->strNouveauPrenom) {
                        $this->binNouveauPrenomSaisi = false;
                    }
                    //Connexion à mySQL et sélection de la BD si possible
                    if ($this->binNouveauPrenomSaisi) {
                        $strMonIP = $strIPServeur = $strNomServeur = $strInfosSensibles = "";
                        detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);
                        $strNomBD = "bdh18_doyon";
                        $BDLabo07 = new mysql($strNomBD, $strInfosSensibles, true);
                        $this->binErreurFatale = !$BDLabo07->OK;

                        //Début traitement de la requête
                        if (!$this->binErreurFatale) {
                            //Seulement pour démonstration, création auto de 'labo07_prenoms' si n'existe pas
                            $strNomTable = "labo07_prenoms";
                            $strDefinitions = "N,no;" . "V20,prenom";
                            $strCles = "no";

                            $BDLabo07->creeTableGenerique($strNomTable, $strDefinitions, $strCles);
                        }

                        //Prénom présent dans 'labo07_prenoms'?
                        $this->binPrenomPresent = $BDLabo07->selectionneEnregistrements($strNomTable, "C=prenom='$this->strPrenom'");
                        
                        //Vérification sensible à la case
                        if ($this->binPrenomPresent) {
                            $this->binPrenomPresent = (strcmp($BDLabo07->contenuChamp(0, "prenom"), $this->strPrenom) === 0);
                        }

                        //Traitement demandé ...
                        switch ($this->strAction) {
                            case "ajouter" :
                                //Ajoute ...........................
                                //Prénom doit être unique
                                if (!$this->binPrenomPresent) {
                                    //Dernier numéro enregistrement généré
                                    $intDernierNo = $BDLabo07->retourneDernierNo($strNomTable, "no");
                                    //Ajout et confirmation de réussite de l'opération
                                    $this->binErreurFatale = !$BDLabo07->insereEnregistrement($strNomTable, $intDernierNo + 1, $this->strPrenom);
                                }
                                break;
                            case "retirer" :
                                //Retrait ..............................
                                //Prénom doit exister
                                if ($this->binPrenomPresent) {
                                    //Supression et confirmation de réussite de l'opération
                                    $this->binErreurFatale = !$BDLabo07->supprimeEnregistrements($strNomTable, "prenom='$this->strPrenom'");
                                }
                                break;
                            case "renommer":
                                //Changer le prénom
                                //Prénom doit exister
                                if ($this->binPrenomPresent) {
                                    //Nouveau prénom ne doit pas exister
                                    $this->binNouveauPrenomPresent = $BDLabo07->selectionneEnregistrements($strNomTable, "C=prenom='$this->strNouveauPrenom'");
                                    
                                    if (!$this->binNouveauPrenomPresent) {
                                        //Changement de prénom et confirmation de réussite de l'opération
                                        $this->binErreurFatale = 
                                                !$BDLabo07->metAJourEnregistrements($strNomTable, "prenom='$this->strNouveauPrenom'", "prenom='$this->strPrenom'");
                                    }
                                }
                                break;
                            case "afficher":
                                //Affichage de tous les prénoms
                                $this->intNbPrenoms = $BDLabo07->selectionneEnregistrements($strNomTable);
                                for ($i=0; $i < $this->intNbPrenoms; $i++) {
                                    $this->tListePrenoms[$i] = $BDLabo07->contenuChamp($i, "prenom");
                                }
                                break;
                            case "vider":
                                //Supprime tous les prénoms
                                //Supression des prénoms et confirmation de réussite de l'opération
                                $this->intNbPrenoms = $BDLabo07->selectionneEnregistrements($strNomTable);
                                $this->binErreurFatale = !$BDLabo07->supprimeEnregistrements($strNomTable);
                                break;
                        }
                    }
                }
            }
        }
    }

    /*
      |----------------------------------------------------------------------------------|
      | retourneFluxJSON
      |----------------------------------------------------------------------------------|
     */

    function retourneFluxJSON() {
        echo json_encode($this);
    }

}

/*
  |-------------------------------------------------------------------------------------|
  | Module directeur
  |-------------------------------------------------------------------------------------|
 */
$objReponseAJAX = new reponseAJAX();
$objReponseAJAX->retourneFluxJSON();
?>