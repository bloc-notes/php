<?php
require_once "Librairie-G Doyon.php";

/*Méthode de transmission de donnée*/

$strMethode = get( "btnEnvoiGET" ) ? "get" : ( post( "btnEnvoiPOST" ) ? "post" : "" );
$strMethodeMajus = strtoupper( $strMethode );

/*Récupération des paramètres*/
$strMatricule = $strMethode == "" ? "" : $strMethode( "tbMatricule$strMethodeMajus" );
$strNom = $strMethode == "" ? "" : $strMethode( "tbNom$strMethodeMajus" );
$strPrenom = $strMethode == "" ? "" : $strMethode( "tbPrenom$strMethodeMajus" );
$chrSexe = $strMethode == "" ? "" : $strMethode( "Sexe$strMethodeMajus" );
$chrEtatCivil = $strMethode == "" ? "" : $strMethode( "ddlEtatCivil$strMethodeMajus" );
$strDateNaissance = $strMethode == "" ? "" : $strMethode( "tbDateNaissance$strMethodeMajus" );
$strFrancais = $strMethode == "" ? "" : $strMethode( "cbFrancais$strMethodeMajus" );
$strAnglais = $strMethode == "" ? "" : $strMethode( "cbAnglais$strMethodeMajus" );
$strEspagnol = $strMethode == "" ? "" : $strMethode( "cbEspagnol$strMethodeMajus" );

$strStyleMatricule = "";
$strStyleNom = "";
$strStylePrenom ="";
$strStyleEtatC = "";
$strStyleDateNaissance = "";

$binMatriculeOk = false;
$binNomOK = false;
$binPrenomOK = false;
$binEtatCOK = false;
$binDateNaissanceOK = false;



if($strMethode != ""){
	/*Validation du matricule*/
	

	if ( $strMatricule == "" ) {
		$strStyleMatricule = "sAbsent";
	} 
	elseif ( !estNumerique( $strMatricule ) ) {
		$strStyleMatricule = "sNonNumerique";
	}
	elseif ( !dansIntervalle( $strMatricule, 10000, 9999999 )) {
		$strStyleMatricule = "sHorsPlage";
	}
	else {
		$binMatriculeOk = true;
		$strMatricule = ajouteZero( $strMatricule, 7 );
	}

	/*valide Nom*/
	
	if ( $strNom == "" ) {
		$strStyleNom = "sAbsent";
	} else {
		$binNomOK = true;
	}

	/*Valide prénom*/
	
	if ( $strPrenom == "" ) {
		$strStylePrenom = "sAbsent";
	} else {
		$binPrenomOK = true;
	}

	/*Valide État civile*/
	
	/*
	if ( etatCivilValide( $chrEtatCivil, $chrSexe, $strEtatCivil ) ) {
		$strStyleEtatC = "sAbsent";
	} else {
		$strStyleEtatC = "";
		$binEtatCOK = true;
	}
	*/
	if($chrEtatCivil == ""){
		$strStyleEtatC = "sAbsent";
	}
	else{
		$binEtatCOK = true;
	}

	/*Validation de la date de naissance*/
	
	if($strDateNaissance == ""){
		$strStyleDateNaissance = "sAbsent";
	}
	else if(!dateValide($strDateNaissance)){
		$strStyleDateNaissance = "sNonNumerique";
	} 
	else{
		$intJour = $intMois = $intAnnee = null;
		extraitJJMMAAAA($intJour,$intMois,$intAnnee,$strDateNaissance);
		$intAnnee +=18;
		$intDateMajorite = strtotime(JJMMAAAA($intJour,$intMois,$intAnnee));
		$intDateAujourdhui = strtotime(date("d-m-Y"));
		if($intDateMajorite > $intDateAujourdhui){
			$strStyleDateNaissance = "sHorsPlage";
		}
		else{
			$binDateNaissanceOK =true;
		}
	}
}
/*
if($binMajusculeOk && $binNomOK && $binPrenomOK && $binEtatCOK && $binDateNaissanceOK){
	echo "Soumission du formulaire...";
	die();
}
*/
?>
<!DOCTYPE html>
<html>

<head>
	<title>Transmission de paramètres par GET et POST</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
		BODY {
			padding-left: 15px;
			padding-top: 15px;
		}
		
		BODY,
		INPUT,
		SELECT {
			font-family: arial;
			font-size: 16px;
		}
		
		.sTitreApplication {
			font-size: 32px;
			line-height: 26px;
			font-weight: bold;
			margin-top: 0px;
		}
		
		.sTitreSection {
			font-size: 24px;
			line-height: 18px;
			font-weight: bold;
		}
		
		.sDivTransmission {
			width: 300px;
			border: solid 1px black;
			padding: 20px;
			padding-top: 0px;
			float: left;
			margin-right: 20px;
		}
		
		.sMatricule,
		.sNom,
		.sPrenom,
		.sSexe,
		.sEtatCivil,
		.sDateNaissance,
		.sLangue {
			color: blue;
			font-weight: bold;
		}
		
		.sMatricule {
			width: 70px;
		}
		
		.sNom,
		.sPrenom {
			width: 200px;
		}
		
		.sDateNaissance {
			width: 90px;
		}
		
		.sDroits {
			font-size: 12px;
			clear: both;
		}
		
		.sRouge {
			color: red;
		}
		/*Nouveau Style Lab5*/
		
		.sAbsent {
			background-color: orange;
			color: white;
		}
		
		.sHorsPlage {
			background-color: magenta;
			color: white;
		}
		
		.sNonNumerique {
			background-color: red;
			color: white;
		}
	</style>

	<script type="text/javascript">
		<?php 
		$binSoumetFormulaire = false;
		if($binMatriculeOk && $binNomOK && $binPrenomOK && $binEtatCOK && $binDateNaissanceOK){
			$binSoumetFormulaire = true;
		?>
		function soumetFormulaire(){
			var frm;
			frm = document.getElementById('frmSaisie<?php echo $strMethodeMajus;?>');
			frm.action = 'laboratoire05.php';
			frm.submit();
		}
		
		<?php
		}
		?>
		
		function preserveValeursTransmises(){
			<?php
			if($strMethode == null){
			?>
				document.getElementById('ddlEtatCivilGET').value = '<?php echo $chrEtatCivil;?>';
				document.getElementById('ddlEtatCivilPOST').value = '<?php echo $chrEtatCivil;?>';
			<?php
			}
			?>
			
			<?php
			if($strMethode == 'get'){
				?>
				switch ('<?php echo $chrSexe;?>'){
				case 'F':
					rbFemmeGET.checked = true;
					break;
				case 'H':
					rbHommeGET.checked = true;
					break;
				case 'N':
					rbNonSpecifieGET.checked = true;
					break;
				}
			
				cbFrancaisGET.checked = <?php echo $strFrancais == 'on' ? "true" : "false";?>;
				cbAnglaisGET.checked = <?php echo $strAnglais == 'on' ? "true" : "false";?>;
				cbEspagnolGET.checked = <?php  echo $strEspagnol == 'on' ? "true" : "false";?>;
			<?php
			}
			else if($strMethode == 'post'){
			?>	
				switch ('<?php echo $chrSexe;?>'){
				case 'F':
					rbFemmePOST.checked = true;
					break;
				case 'H':
					rbHommePOST.checked = true;
					break;
				case 'N':
					rbNonSpecifiePOST.checked = true;
					break;
				}

				cbFrancaisPOST.checked = <?php echo $strFrancais == 'on' ? "true" : "false";?>;
				cbAnglaisPOST.checked = <?php echo $strAnglais == 'on' ? "true" : "false";?>;
				cbEspagnolPOST.checked = <?php  echo $strEspagnol == 'on' ? "true" : "false";?>;
			<?php
			}
			?>
		}
		
	</script>
</head>

<body onload="preserveValeursTransmises();<?php echo $binSoumetFormulaire ? "soumetFormulaire();": "";?>">
	<div id="divEntete" class="">
		<p class="sTitreApplication">
			Transmission de paramètres par GET et POST
			<span class="sTitreSection">
            <br />par <span class="sRouge">Louis-Marie Brousseau</span>
		
			</span>
		</p>
	</div>

	<div id="divTransmissionGET" class="sDivTransmission">
		<form id="frmSaisieGET" method="get" action="">
			<p class="sTitreSection">
				Transmission par GET
			</p>
			Matricule<br/>
			<input id="tbMatriculeGET" name="tbMatriculeGET" type="text" maxlength="7" value="<?php echo $strMatricule;?>" class="sMatricule <?php echo $strStyleMatricule;?>"/>
			<br/><br/> Nom
			<br/>
			<input id="tbNomGET" name="tbNomGET" type="text" maxlength="20" value="<?php echo $strNom;?>" class="sNom <?php echo $strStyleNom;?>"/>
			<br/><br/> Prénom
			<br/>
			<input id="tbPrenomGET" name="tbPrenomGET" type="text" maxlength="15" value="<?php echo $strPrenom;?>" class="sPrenom <?php echo $strStylePrenom;?>"/>
			<br/><br/> Sexe
			<br/>
			<span class="sSexe">
            <input id="rbFemmeGET" name="SexeGET" type="radio" value="F" />Femme
            <input id="rbHommeGET" name="SexeGET" type="radio" value="H" />Homme
            <input id="rbNonSpecifieGET" name="SexeGET" type="radio" value="N" checked="checked"/>Non spécifié
         </span>
		
			<br/><br/> État civil<br/>
			<select id="ddlEtatCivilGET" name="ddlEtatCivilGET" class="sEtatCivil <?php echo $strStyleEtatC;?>">
				<option value=""></option>
				<option value="C">Célibataire</option>
				<option value="F">Conjoint.e de fait</option>
				<option value="M">Marié.e</option>
				<option value="S">Séparé.e</option>
				<option value="D">Divorcé.e</option>
				<option value="V">Veuf.ve</option>
			</select>
			<br/><br/> Date de naissance<br/>
			<input id="tbDateNaissanceGET" name="tbDateNaissanceGET" type="text" maxlength="10" value="<?php echo $strDateNaissance;?>" class="sDateNaissance <?php echo $strStyleDateNaissance;?>"/>
			<br/><br/> Langue(s) parlée(s)<br/>
			<span class="sLangue">
            <input id="cbFrancaisGET" name="cbFrancaisGET" type="checkbox" />Français
            <input id="cbAnglaisGET" name="cbAnglaisGET" type="checkbox" />Anglais
            <input id="cbEspagnolGET" name="cbEspagnolGET" type="checkbox" />Espagnol
         </span>
		
			<br/><br/>
			<input id="btnEnvoiGET" name="btnEnvoiGET" type="submit" value="Envoi via la barre d'adresse (GET)" class=""/>
		</form>
	</div>

	<div id="divTransmissionPOST" class="sDivTransmission">
		<form id="frmSaisiePOST" method="post" action="">
			<p class="sTitreSection">
				Transmission par POST
			</p>
			Matricule<br/>
			<input id="tbMatriculePOST" name="tbMatriculePOST" type="text" maxlength="7" value="<?php echo $strMatricule;?>" class="sMatricule 
			<?php echo $strStyleMatricule;?>"/>
			<br/><br/> Nom
			<br/>
			<input id="tbNomPOST" name="tbNomPOST" type="text" maxlength="20" value="<?php echo $strNom;?>" class="sNom <?php echo $strStyleNom;?>"/>
			<br/><br/> Prénom
			<br/>
			<input id="tbPrenomPOST" name="tbPrenomPOST" type="text" maxlength="15" value="<?php echo $strPrenom;?>" class="sPrenom <?php echo $strStylePrenom;?>"/>
			<br/><br/> Sexe
			<br/>
			<span class="sSexe">
            <input id="rbFemmePOST" name="SexePOST" type="radio" value="F" />Femme
            <input id="rbHommePOST" name="SexePOST" type="radio" value="H" />Homme
            <input id="rbNonSpecifiePOST" name="SexePOST" type="radio" value="N" checked="checked"/>Non spécifié
         </span>
		
			<br/><br/> État civil<br/>
			<select id="ddlEtatCivilPOST" name="ddlEtatCivilPOST" class="sEtatCivil <?php echo $strStyleEtatC;?>">
				<option value=""></option>
				<option value="C">Célibataire</option>
				<option value="F">Conjoint.e de fait</option>
				<option value="M">Marié.e</option>
				<option value="S">Séparé.e</option>
				<option value="D">Divorcé.e</option>
				<option value="V">Veuf.ve</option>
			</select>
			<br/><br/> Date de naissance<br/>
			<input id="tbDateNaissancePOST" name="tbDateNaissancePOST" type="text" maxlength="10" value="<?php echo $strDateNaissance;?>" class="sDateNaissance 
			<?php echo $strStyleDateNaissance;?>"/>
			<br/><br/> Langue(s) parlée(s)<br/>
			<span class="sLangue">
            <input id="cbFrancaisPOST" name="cbFrancaisPOST" type="checkbox" />Français
            <input id="cbAnglaisPOST" name="cbAnglaisPOST" type="checkbox" />Anglais
            <input id="cbEspagnolPOST" name="cbEspagnolPOST" type="checkbox" />Espagnol
         </span>
		
			<br/><br/>
			<input id="btnEnvoiPOST" name="btnEnvoiPOST" type="submit" value="Envoi via l'en-tête (POST)" class=""/>
		</form>
	</div>

	<div id="divPiedPage">
		<p class="sDroits">
			<br/> &copy; Département d'informatique G.-G.
		</p>
	</div>

</html>