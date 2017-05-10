<?php 
//////////////////////////////////////////////////////////////////////////////////////////////////   
require_once("classe-mysql-2017-mm-jj.php");
require_once("librairies-communes-2017-02-17.php");
require_once("classe-mysql-2017-mm-jj.php");
require_once("424w-cgodin-qc-ca.php");
//require_once("Librairie-G Doyon.php");
//require_once("Classe-mysql.php");
require_once("Doyon.php");
//////////////////////////////////////////////////////////////////////////////////////////////////
$strUtilisateur = $_SESSION["NoUtilisateur"];    
$strInfosSensibles="424w-cgodin-qc-ca.php";
$testmySQL = new mysql($strNomBD, $strInfosSensibles); 
$testmySQL->selectQuery("SELECT * FROM utilisateurs where NoUtilisateur = '$strUtilisateur'");
////////////////////////////////////////////////////////////////////////////////////////////////// 
?>
<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<link rel="stylesheet" href="styleSheet.css">
<script language="javascript" type="text/javascript" src="generalScript.js"></script>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////////////////////// 
function verifier(element,strValue)
{
	var boolVerification = false;
    var rgxTelephone = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
    var rgxNom = /^[A-Z][a-z]+$/;
    var rgxNombre = /^\d{1,11}$/;
    var arrayId = ["Prenom",rgxNom,"Nom",rgxNom,"NoTelMaison",rgxTelephone,"NoTelTravail",rgxTelephone,"NoTelCellulaire",rgxTelephone,"NoEmpl",rgxNombre];

    for(var i=0;i<arrayId.length;i++)
    {
    	if(arrayId[i+1].test(document.getElementById(arrayId[i]).value))
    	{
    		document.getElementById(arrayId[i]).style.backgroundColor = "#98FB98";
    	}
    	else
    	{
    		if(   (arrayId[i]=="NoTelMaison" || arrayId[i]=="NoTelTravail" || arrayId[i]=="NoTelCellulaire")&&(document.getElementById(arrayId[i]).value==""))
    		{
    		
    		document.getElementById(arrayId[i]).style.backgroundColor = "#98FB98";
    		}
    		else
    		{
    			boolVerification = true;
			document.getElementById(arrayId[i]).style.backgroundColor = "#fb9898";
			}
    	}
    	i++;
    }

    if(boolVerification)
    {
    	document.getElementById("btnModifier").style.backgroundColor = "#D3D3D3";
    	document.getElementById("btnModifier").disabled = true;
    }
    else
   	{
   		document.getElementById("btnModifier").style.backgroundColor = "rgb(0,166,253)";
   		document.getElementById("btnModifier").disabled = false;
   	}
}
//////////////////////////////////////////////////////////////////////////////////////////////////
function modifier()
{
	var idUtilisateur = "<?php echo $testmySQL->contenuChamp(0 , "NoUtilisateur");?>"
	var Prenom = document.getElementById("Prenom").value;
	var Nom = document.getElementById("Nom").value;
	var NoTelMaison = document.getElementById("NoTelMaison").value;
	var NoTelTravail = document.getElementById("NoTelTravail").value;
	var NoTelCellulaire = document.getElementById("NoTelCellulaire").value;
	var NoEmpl = document.getElementById("NoEmpl").value;

	var data = "index="+idUtilisateur+"&Prenom="+Prenom+"&Nom="+Nom+"&NoTelMaison="+NoTelMaison+"&NoTelTravail="+NoTelTravail+"&NoTelCellulaire="+NoTelCellulaire+"&NoEmpl="+NoEmpl;
	var isActiveX = !!window.ActiveXObject,
    xhr = isActiveX ? new ActiveXObject("Microsoft.XMLHTTP"): new XMLHttpRequest();

	xhr.open("POST","modifierUtilisateurAPI.php",true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(data);

	xhr.onreadystatechange = function () 
	{
	    if (this.readyState === 4 && this.status === 200)
	    {
	        //var response = JSON.parse(this.responseText);
	        modifierMessage(this.responseText);
	    }
	};
}
//////////////////////////////////////////////////////////////////////////////////////////////////
function modifierMessage(strReponse)
{
	alert(strReponse);
	changePage('profilUtilisateur.php');
}
////////////////////////////////////////////////////////////////////////////////////////////////// 
</script>
<body>
<?php require_once("En-tete.php"); ?>
<div align="center" style="padding-top:40px">
<table>
	<tr>
		<td colspan="3" style="text-align:center"><br><span style="font-weight:bold;font-size: 60px;">Votre profil</span><br></td><td rowspan="9"></td>
	</tr>
	<tr>
		<td style="vertical-align:middle;font-weight:bold;padding-top: 40px;">Courriel: </td>
		<td style="padding-top: 40px;"> <input id="Courriel" type="text" class="textbox" disabled valign="bottom" placeholder="Courriel" value="<?php echo $testmySQL->contenuChamp(0 , "Courriel");?>"><br></td> 
	</tr>
	<tr>
		<td style="vertical-align:middle;font-weight:bold;">Prénom: </td>
		<td><input id="Prenom" type="text" class="textbox" placeholder="Prénom" value="<?php echo $testmySQL->contenuChamp(0 , "Prenom");?>" onInput="verifier(this,this.value)"><br></td> 
	</tr>
	<tr>
		<td style="vertical-align:middle;font-weight:bold;">Nom de famille: </td>
		<td><input id="Nom" type="text" class="textbox" placeholder="Nom de famille" value="<?php echo $testmySQL->contenuChamp(0 , "Nom");?>" onInput="verifier(this,this.value)"><br></td> 
	</tr>
	<tr>
		<td style="vertical-align:middle;font-weight:bold;">Téléphone à domicile: </td>
		<td><input id="NoTelMaison" type="text" class="textbox" placeholder="Téléphone à domicile" value="<?php echo $testmySQL->contenuChamp(0 , "NoTelMaison");?>" onInput="verifier(this,this.value)"><br></td> 
	</tr>
	<tr>
		<td style="vertical-align:middle;font-weight:bold;">Téléphone de travail: </td>
		<td><input id="NoTelTravail" type="text" class="textbox" placeholder="Téléphone de travail" value="<?php echo $testmySQL->contenuChamp(0 , "NoTelTravail");?>" onInput="verifier(this,this.value)"><br></td> 
	</tr>
	<tr>
		<td style="vertical-align:middle;font-weight:bold;">Téléphone portable: </td>
		<td><input id="NoTelCellulaire" type="text" class="textbox" placeholder="Téléphone portable" value="<?php echo $testmySQL->contenuChamp(0 , "NoTelCellulaire");?>" onInput="verifier(this,this.value)"><br></td> 
	</tr>
	<tr>
		<td style="vertical-align:middle;font-weight:bold;">Numéro employé: </td>
		<td><input id="NoEmpl" type="text" class="textbox" placeholder="Numéro employé" value="<?php echo $testmySQL->contenuChamp(0 , "NoEmpl");?>" onInput="verifier(this,this.value)"><br></td> 
	</tr>
	<tr>
		<td colspan="3" style="padding: 40px;"><input id="btnModifier" type="button" align="center"style="font-weight:bold;margin-right:80px;" class="btn" value="J'accepte les modifications" onClick="modifier()">
		<input type="button" align="center"style="font-weight:bold" class="btn" value="Annuler les modifications" onClick="changePage('profilUtilisateur.php')"></td>
	</tr>
</table>
</div>
<?php require_once("footer.php"); ?>
</body>
</html>
