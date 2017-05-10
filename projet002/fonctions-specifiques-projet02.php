<?php
require_once("librairies-communes-2017-03-21.php");
require_once("classe-fichier-2017-03-21.php");
require_once("classe-mysql-2017-03-31.php");


function creeTableTypesLivraison($oBD,$strNomTableTypesLivraison)
{
    $strCle = "NoTypeLivraison";
    $strDefinition ="N,NoTypeLivraison;".
    "F20,DescriptionFournisseurLivraison;".
    "M,CoutLivraison;".
    "N,DelaiLivraison;";
    $oBD->creeTableGenerique($strNomTableTypesLivraison,$strDefinition,$strCle);
}

function remplitTableTypesLivraison($oBD,$strNomTableTypesLivraison,$strNomFichierTypesLivraison)
{
    $fichier = new fichier($strNomFichierTypesLivraison);
    $fichier->ouvre();
    for($i = 0 ;$i<$fichier->compteLignes();$i++)
       {
        $tValeurs = array();
        $fichier->litDonneesLigne($tValeurs,";","NoTypeLivraison",
                  "DescriptionFournisseurLivraison","CoutLivraison","DelaiLivraison");
        $oBD->insereEnregistrement($strNomTableTypesLivraison,$tValeurs["NoTypeLivraison"],
                  $tValeurs["DescriptionFournisseurLivraison"],$tValeurs["CoutLivraison"],
                $tValeurs["DelaiLivraison"]);
       }
}

function creeTableCommandes($oBD,$strNomTableCommandes)
{
    $strDefinition="N,NoCommande;".
                "N,NoClient;".
                "N,NoVendeur;".
                "D,DateCommande;".
                "D,DateLivraison;".
                "D,DateAnnulation;".
                "M,MontantAvTaxes;".
                "M,CoutLivraison;".
                "M,CoutTPS;".
                "M,CoutTVQ;".
                "N,TypeLivraison;".
                "N,Statut;".
                "N,NoAutorisation;";
    $strCle = "NoAutorisation";
    $oBD->creeTableGenerique($strNomTableCommandes,$strDefinition,$strCle);
}

function remplitTableCommandes($oBD,$strNomTableCommandes,$strNomFichierCommandes)
{
    
    $fichier = new fichier($strNomFichierCommandes);
    $fichier->ouvre();
     
    for($i = 0 ;$i<$fichier->compteLignes();$i++)
       {   
        $tValeurs = array();
        $fichier->litDonneesLigne($tValeurs,";","NoCommande","NoClient","NoVendeur",
                "DateCommande","DateLivraison","DateAnnulation","MontantAvTaxes",
                "CoutLivraison","CoutTPS","CoutTVQ","TypeLivraison","Statut",
                "NoAutorisation");
        $oBD->insereEnregistrement($strNomTableCommandes,$tValeurs["NoCommande"],
                $tValeurs["NoClient"],$tValeurs["NoVendeur"],
                $tValeurs["DateCommande"],$tValeurs["DateLivraison"],$tValeurs["DateAnnulation"],
                $tValeurs["MontantAvTaxes"],$tValeurs["CoutLivraison"],
                $tValeurs["CoutTPS"],$tValeurs["CoutTVQ"],$tValeurs["TypeLivraison"],
                $tValeurs["Statut"],$tValeurs["NoAutorisation"]); 
        
       }
}

function creeTableHistoriqueCommandes($oBD,$strNomTableHistoriqueCommandes)
{
        $strDefinition="N,NoHistorique;".
                "D,DateArchivage;".
                "N,NoVendeur;".
                "N,NoClient;".
                "N,NoCommande;".
                "N,NoAutorisation;".
                "D,DateVente;".
                "M,MontantAvTaxes;".
                "M,FraisLivraison;".
                "M,FraisTPS;".
                "M,FraisTVQ;".
                "M,Redevances;".
                "M,FraisLESI;";
        $strCle = "NoAutorisation";
        $oBD->creeTableGenerique($strNomTableHistoriqueCommandes,$strDefinition,$strCle);
}
function ajouteCommande($oBD,$strNomTableCommandes)
{
    $NoCommande = $oBD->selectionneMax($strNomTableCommandes,'NoCommande')+1;
    //$oBD->selectionneEnregistrements($strNomTableCommandes,"C=Statut=1 AND DateAnnulation='0000-00-00'","T=DateCommande ASC, MontantAvTaxes DESC");
    $oBD->insereEnregistrement($strNomTableCommandes,$NoCommande,get("tbNoClient"),get("tbNoVendeur"),
                get("tbDateCommande"),"0000-00-00","0000-00-00",get("tbMontantAvTaxes"),get("hidCoutLivraison"),
                get("hidTPS"),get("hidTVQ"),get("ddlTypesLivraison"),1,get("hidNoAutorisation")); 
}

function livreCommande($oBD,$strNomTableCommandes,$intNoCommandeATraiter)
{
    $Requete="UPDATE $strNomTableCommandes SET Statut=2,DateLivraison='".date("Y-m-d")."' WHERE NoCommande=$intNoCommandeATraiter";
    echo $Requete;
    mysqli_query($oBD->_cBD,$Requete);
}
function annuleLivraisonCommande($oBD,$strNomTableCommandes,$intNoCommandeATraiter)
{
    $Requete="UPDATE $strNomTableCommandes SET Statut=1,DateLivraison='0000-00-00' WHERE NoCommande=$intNoCommandeATraiter";
    echo $Requete;
    mysqli_query($oBD->_cBD,$Requete);
}
function annuleCommande($oBD,$strNomTableCommandes,$intNoCommandeATraiter)
{
    $Requete="UPDATE $strNomTableCommandes SET DateAnnulation='".date("Y-m-d")."' WHERE NoCommande=$intNoCommandeATraiter";
    echo $Requete;
    mysqli_query($oBD->_cBD,$Requete);
}
function reactiveCommande($oBD,$strNomTableCommandes,$intNoCommandeATraiter)
{
    $Requete="UPDATE $strNomTableCommandes SET DateAnnulation='0000-00-00' WHERE NoCommande=$intNoCommandeATraiter";
    echo $Requete;
    mysqli_query($oBD->_cBD,$Requete);
}
function supprimeCommande($oBD,$strNomTableCommandes,$intNoCommandeATraiter)
{
    $Requete="DELETE FROM $strNomTableCommandes WHERE NoCommande=$intNoCommandeATraiter";
    echo $Requete;
    mysqli_query($oBD->_cBD,$Requete);
}
function archiveCommande($oBD,$strNomTableCommandes,$strNomTableHistoriqueCommandes,$intNoCommandeATraiter)
{
    $NoHistorique = $oBD->selectionneMax($strNomTableHistoriqueCommandes,'NoHistorique')+1;
    $DateArchivage = aujourdhui();
    $oBD->selectionneEnregistrements($strNomTableCommandes,"C=NoCommande=$intNoCommandeATraiter");
    $NoVendeur = $oBD->mysqli_result(0,"NoVendeur");
    $NoClient = $oBD->mysqli_result(0,"NoClient");
    $NoCommande = $oBD->mysqli_result(0,"NoCommande");
    $NoAutorisation = $oBD->mysqli_result(0,"NoAutorisation");
    $DateLivraison = $oBD->mysqli_result(0,"DateLivraison");
    $MontantAvTaxes = $oBD->mysqli_result(0,"MontantAvTaxes");
    $CoutLivraison = $oBD->mysqli_result(0,"CoutLivraison");
    $CoutTPS = $oBD->mysqli_result(0,"CoutTPS");
    $CoutTVQ = $oBD->mysqli_result(0,"CoutTVQ");
    $Redevances = $MontantAvTaxes*0.05;
    $FraisLESI = $MontantAvTaxes*0.025;
    if($FraisLESI<5){ $FraisLESI=5; }
    if($FraisLESI>50){ $FraisLESI=50; }
    $Requete="UPDATE $strNomTableCommandes SET Statut=3 WHERE NoCommande=$intNoCommandeATraiter"; 
    echo $Requete;
    mysqli_query($oBD->_cBD,$Requete);
    $oBD->insereEnregistrement($strNomTableHistoriqueCommandes,$NoHistorique,$DateArchivage,$NoVendeur,
                $NoClient,$NoCommande,$NoAutorisation,$DateLivraison,$MontantAvTaxes,
                $CoutLivraison,$CoutTPS,$CoutTVQ,$Redevances,$FraisLESI);    
}
?>
