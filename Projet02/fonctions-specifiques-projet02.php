<?php
//Philippe Doyon

require_once("Classe-mysql.php");
require_once("Librairie-G Doyon.php");
require_once("Classe-fichier.php");

//1)
function creeTableTypesLivraison($oBD,$strNomTableTypesLivraison){
    $strChamps ="N,NoTypeLivraison;"."F20,DescriptionFournisseurLivraison;".
            "M,CoutLivraison;"."N,DelaiLivraison";
    $strCle = "NoTypeLivraison";
    $oBD->creeTableGenerique($strNomTableTypesLivraison,$strChamps,$strCle);
}

//2)
function remplitTableTypesLivraison($oBD,$strNomTableTypesLivraison,$strNomFichierTypesLivraison){
    $fchTypeLi = new fichier($strNomFichierTypesLivraison);
    
    $fchTypeLi->ouvre();
    
    while(!$fchTypeLi->detecteFin()){
        $tabValeurs = array();
        
        $fchTypeLi->litDonneesLigne($tabValeurs,";","NoTypeLivraison",
                  "DescriptionFournisseurLivraison","CoutLivraison","DelaiLivraison");
        
        $oBD->insereEnregistrement($strNomTableTypesLivraison, $tabValeurs["NoTypeLivraison"],
                $tabValeurs["DescriptionFournisseurLivraison"], $tabValeurs["CoutLivraison"],
                $tabValeurs["DelaiLivraison"]);
    }
    $fchTypeLi->ferme();
}

//3)
function creeTableCommandes($oBD,$strNomTableCommandes){
    $strChamp = "N,NoCommande;"."N,NoClient;". "N,NoVendeur;"."D,DateCommande;".
                "D,DateLivraison;"."D,DateAnnulation;"."M,MontantAvTaxes;".
                "M,CoutLivraison;"."M,CoutTPS;"."M,CoutTVQ;"."N,TypeLivraison;".
                "N,Statut;"."N,NoAutorisation";
    
    $strCle = "NoAutorisation";
    
    $oBD->creeTableGenerique($strNomTableCommandes,$strChamp,$strCle);  
}

//4)
function  remplitTableCommandes($oBD,$strNomTableCommandes,$strNomFichierCommandes){
    $fchComm = new fichier($strNomFichierCommandes);
    $fchComm->ouvre();

    while(!$fchComm->detecteFin()){
        $tabValeurs = array();
        $fchComm->litDonneesLigne($tabValeurs,";","NoCommande","NoClient","NoVendeur",
                "DateCommande","DateLivraison","DateAnnulation","MontantAvTaxes",
                "CoutLivraison","CoutTPS","CoutTVQ","TypeLivraison","Statut",
                "NoAutorisation");
        
        $oBD->insereEnregistrement($strNomTableCommandes, $tabValeurs["NoCommande"],
                $tabValeurs["NoClient"],$tabValeurs["NoVendeur"],$tabValeurs["DateCommande"],
                $tabValeurs["DateLivraison"],$tabValeurs["DateAnnulation"],
                $tabValeurs["MontantAvTaxes"],$tabValeurs["CoutLivraison"],
                $tabValeurs["CoutTPS"],$tabValeurs["CoutTVQ"],$tabValeurs["TypeLivraison"],
                $tabValeurs["Statut"],$tabValeurs["NoAutorisation"]);
    }
    $fchComm->ferme();
}

//5)
function creeTableHistoriqueCommandes($oBD,$strNomTableHistoriqueCommandes){
    $strDefinition="N,NoHistorique;"."D,DateArchivage;"."N,NoVendeur;"."N,NoClient;".
                "N,NoCommande;"."N,NoAutorisation;"."D,DateVente;"."M,MontantAvTaxes;".
                "M,FraisLivraison;"."M,FraisTPS;"."M,FraisTVQ;"."M,Redevances;".
                "M,FraisLESI";
    $strCle = "NoAutorisation";
    
    $oBD->creeTableGenerique($strNomTableHistoriqueCommandes,$strDefinition,$strCle);
}

//6)
function ajouteCommande($oBD,$strNomTableCommandes){          
    //https://openclassrooms.com/forum/sujet/mysql-obtenir-le-max-d-une-colonne-58164          
              
    $oBD->_listeEnregistrements = mysqli_query($oBD->_cBD,"SELECT MAX(NoCommande) AS valmax FROM " 
            . $strNomTableCommandes);
    $tabresultat = mysqli_fetch_array($oBD->_listeEnregistrements);
 
    $NoCommande = $tabresultat['valmax'] + 1;
    
    $strDateVide = "0000-00-00";
    
    echo "test";
    
    $oBD->insereEnregistrement($strNomTableCommandes, $NoCommande,get("tbNoClient"),
            get("tbNoVendeur"),get("tbDateCommande"), $strDateVide, $strDateVide,
            get("tbMontantAvTaxes"),get("hidCoutLivraison"), get("hidTPS"),
            get("hidTVQ"), get("ddlTypesLivraison"),"1",get("hidNoAutorisation"));
}

//7)
function livreCommande($oBD,$strNomTableCommandes,$intNoCommandeATraiter){
    $oBD->_requete = "UPDATE $strNomTableCommandes SET Statut=2,DateLivraison='".
            date("Y-m-d")."' WHERE NoCommande=$intNoCommandeATraiter";
    mysqli_query($oBD->_cBD,$oBD->_requete);
    
}

//8)
function annuleLivraisonCommande($oBD,$strNomTableCommandes,$intNoCommandeATraiter){
    $oBD->_requete = "UPDATE $strNomTableCommandes SET Statut=1,DateLivraison='0000-00-00'"
            . " WHERE NoCommande=$intNoCommandeATraiter";
    mysqli_query($oBD->_cBD,$oBD->_requete);
}

//9)
function annuleCommande($oBD,$strNomTableCommandes,$intNoCommandeATraiter){
    $oBD->_requete = "UPDATE $strNomTableCommandes SET DateAnnulation='".date("Y-m-d").
            "' WHERE NoCommande=$intNoCommandeATraiter";
    mysqli_query($oBD->_cBD,$oBD->_requete);
}

//10)
function reactiveCommande($oBD,$strNomTableCommandes,$intNoCommandeATraiter){
    $oBD->_requete = "UPDATE $strNomTableCommandes SET DateAnnulation='0000-00-00'"
            . " WHERE NoCommande=$intNoCommandeATraiter";
    mysqli_query($oBD->_cBD,$oBD->_requete);
}

//11)
function supprimeCommande($oBD,$strNomTableCommandes,$intNoCommandeATraiter){
    $oBD->supprimeEnregistrements($strNomTableCommandes, "NoCommande=$intNoCommandeATraiter");
}

//12)
function archiveCommande($oBD,$strNomTableCommandes,$strNomTableHistoriqueCommandes,
        $intNoCommandeATraiter){
    //Maximum pour NoHistorique
    //https://openclassrooms.com/forum/sujet/mysql-obtenir-le-max-d-une-colonne-58164          
             
    $oBD->_listeEnregistrements = mysqli_query($oBD->_cBD,"SELECT MAX(NoCommande) AS valmax FROM " 
            . $strNomTableHistoriqueCommandes);
    $tabresultat = mysqli_fetch_array($oBD->_listeEnregistrements);
    $NoHistorique = $tabresultat['valmax'] + 1;
    
    //Donnée de la table commande
    $intPoubelle = $oBD->selectionneEnregistrements($strNomTableCommandes,"C=NoCommande = $intNoCommandeATraiter");
    $ResultatRequete = mysqli_fetch_array($oBD->_listeEnregistrements);
    
    //Inserée les données dans la table historique
    $FraisLESI = ($ResultatRequete["MontantAvTaxes"] < 5) ? "5.00": 
            ($ResultatRequete["MontantAvTaxes"] > 50) ? "50.00": ($ResultatRequete["MontantAvTaxes"] * 1.025);
    $oBD->insereEnregistrement($strNomTableHistoriqueCommandes,$NoHistorique,date("Y-m-d"),
                                $ResultatRequete["NoVendeur"],$ResultatRequete["NoClient"],
                                $ResultatRequete["NoCommande"], $ResultatRequete["NoAutorisation"],
                                $ResultatRequete["DateLivraison"], $ResultatRequete["MontantAvTaxes"],
                                $ResultatRequete["CoutLivraison"], $ResultatRequete["CoutTPS"],
                                $ResultatRequete["CoutTVQ"], ($ResultatRequete["MontantAvTaxes"] * 1.05),
                                $FraisLESI);
    
    //Met à jour la table commande
    $oBD->_requete = "UPDATE $strNomTableCommandes SET Statut=3"
        . " WHERE NoCommande=$intNoCommandeATraiter";
    mysqli_query($oBD->_cBD,$oBD->_requete);
}


