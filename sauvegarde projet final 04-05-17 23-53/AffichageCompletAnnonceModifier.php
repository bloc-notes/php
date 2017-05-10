<?php
require_once("librairies-communes-2017-03-21(francis).php");
require_once("classe-fichier-2017-03-21(francis).php");
require_once("classe-mysql-2017-03-31(francis).php");
$strUtilisateur = $_SESSION["NoUtilisateur"];
$intLongueurTANormal = 25;
$intLongueurTAReduit = 15;
$booModeAdmin = true;
$intLongueurTAAffficher = $booModeAdmin == true?$intLongueurTAReduit:$intLongueurTANormal;

$strLocalHost = "localhost";
$strNomBD = "annonces_qwerty";
$strMonIP = "";
$strIPServeur = "";
$strNomServeur = "";
$strInfosSensibles = "";
detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);
$BDProjet = new mysql($strNomBD, $strInfosSensibles);

$intNoAnnonce = 100;
$intNoUtil = $strUtilisateur;
$Requete="SELECT Description FROM categories INNER JOIN annonces ON annonces.Categorie=categories.NoCategorie WHERE NoAnnonce=$intNoAnnonce AND NoUtilisateur=$intNoUtil";
                        $BDProjet->_listeEnregistrements= mysqli_query($BDProjet->_cBD,$Requete);
                        $Nocategorie = $BDProjet->contenuChamp(0,0);
                        $Requete="SELECT * FROM annonces WHERE NoAnnonce=$intNoAnnonce";
                        $BDProjet->_listeEnregistrements= mysqli_query($BDProjet->_cBD,$Requete);
                        $NoEtat = $BDProjet->contenuChamp(0,9);
                        $Prix = $BDProjet->contenuChamp(0,6);
                        $DateParution = $BDProjet->contenuChamp(0,2);
                        $DateMaj = $BDProjet->contenuChamp(0,8);
                        $DescriptionCourt = $BDProjet->contenuChamp(0,4);
                        $DescriptionLong = $BDProjet->contenuChamp(0,5);
                        $photo = $BDProjet->contenuChamp(0,7);
                        
$blnGET = get("btnModifier");
 if($blnGET =="Modifier")
    {
            $NouveauPrix = str_replace(',','.',get("TbPrix"));
            if(get("radEtat")=='I')
                {
                $NouvelEtat = 2;
                }
             else
                {
                 $NouvelEtat = 1;
                }
             $NouvelleDateMaj = date("Y-m-d H:i:s");
             $NouvelleDescCourte = get("tbDescCourt");
             $NouvelleDescLongue = get("tbDescLong");
             $Requete= "UPDATE annonces SET Etat=$NouvelEtat,Prix=$NouveauPrix,MiseAJour='$NouvelleDateMaj',DescriptionAbregee='$NouvelleDescCourte',DescriptionComplete='$NouvelleDescLongue' WHERE NoAnnonce=$intNoAnnonce";
             mysqli_query($BDProjet->_cBD,$Requete);
             //changePage('affichageAnnonce');          
    }
if($NoEtat==3)
    {
    echo "Cette page ne devrait pas s'afficher";
    }
else
{
?>
<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<link rel="stylesheet" href="styleSheet.css">
<script language="javascript" type="text/javascript" src="generalScript.js"></script>
<script type="text/javascript">
    function verifier()
    {
        var prix = document.getElementById("tbPrix").value;
        prix = prix.replace(",", ".");
        if(!(prix>0) || !(prix<100000))
        {
            document.getElementById("tbPrix").style.backgroundColor = "#fb9898";
            alert("Le prix doit être entre 0 et 100000!");
        }
        var frm;
               frm = document.getElementById('frmSaisieGET');
               frm.action = 'AffichageCompletAnnonceModifier.php';
               frm.submit();
    }
    
    function Supprimer()
    {
        <?php  
    $Requete= "UPDATE annonces SET Etat=3 WHERE NoAnnonce=$intNoAnnonce";
    mysqli_query($BDProjet->_cBD,$Requete);
    $Requete= "UPDATE annonces SET MiseAJour=NOW() WHERE NoAnnonce=$intNoAnnonce";
    mysqli_query($BDProjet->_cBD,$Requete);
        ?> 
    //changePage('affichageAnnonce');  
    }
    ////////A ALTERER, POURRAIT ETRE DU PLAGIAT SI CE N'EST PAS LE CAS'
    var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var imageProduit = document.getElementById('imageProduit');
      alert(imageProduit);
      imageProduit.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
    imageProduit.style.height = '600px';
    imageProduit.style.width = '600px';
  };
</script>
<body>
<?php require_once("header.php");require_once("Doyon.php"); ?>
<div  align="center" style="padding-top:40px">
<form id="frmSaisieGET" method="get" action="">
<table border="0">
                <tr>
                    <th style="padding-top: 20px;padding-left: 20px;">
                        Numéro
                    </th>
                    <th style="padding-top: 20px;padding-left: 20px;">
                        Catégorie
                    </th>
                    <th style="padding-top: 20px;padding-left: 20px;">
                        État
                    </th>
                                        <th rowspan="10">
                       <img src="600png.png" alt="imageProduit" id="imageProduit"/>   
                    </th>
                </tr>
                <tr>
                    <td>
                        <span style="width: 100px"class="sTitreCentree"><?php echo $intNoAnnonce ?></span>
                    </td>
                    <td>
                        <SELECT name="tbCategorie" size="1">
                        <?php
                     $TableauCat = array();
                     for ($i = 0; $i < $BDProjet->selectionneEnregistrements("categories"); $i++) {
                         ?>                          
                            <option value= <?php echo $i?>><?php echo $BDProjet->contenuChamp($i, "Description"); ?></option>
                     <?php
                     } ?>
                        </SELECT>                      
                    </td>
                    <td>
                        <?php 
                        if($NoEtat==1)
                            {
                        ?>
                        <input id="radActif" name="radEtat" type="radio" value="A" checked="checked" />
                        <label for="radActif"> Actif</label>
                        <input id="radInactif" name="radEtat" type="radio" value="I" />
                        <label for="radInactif"> Inatif</label>
                        <?php
                            }
                        else
                            {
                        ?>
                        <input id="radActif" name="radEtat" type="radio" value="A"/>
                        <label for="radActif"> Actif</label>
                        <input id="radInactif" name="radEtat" type="radio" value="I" checked="checked"/>
                        <label for="radInactif"> Inatif</label>
                        <?php
                            }
                        ?>
                    </td>
                </tr>

                
                <tr >
                    <th style="padding-top: 25px;padding-left: 20px;vertical-align:middle;">
                        Prix : 
                    </th>
                    <td colspan="2" style="padding-top: 25px;padding-left: 20px;">
                        <input id="tbPrix" class="textbox" name="tbPrix" type="number" maxlength="50" class="sTitreCentree"  value="<?php echo str_replace('.',',',$Prix) ?>" style="width: 200px;"/>$
                    </td>
                </tr>
                <th style="padding-top: 25px;padding-left: 20px;">
                            Image:
                    </th>
                    <th style="padding-top: 15px;padding-left: 20px;">
                    <input type='file' class="btn" name='userFile' accept="image/*" onchange="loadFile(event)"><br>
                    </th>
                                <tr>
                    <th style="padding-top: 40px;padding-left: 20px;">
                        Date de Parution:
                    </th>
                    <th style="padding-top: 40px;padding-left: 20px;">
                        Date de mise à jour:
                    </th>
                </tr>
                
                <tr>
                    <td>
                        <?php echo $DateParution ; ?> EST
                    </td>
                    <td>
                        <?php echo $DateMaj ?> EST
                    </td>
                </tr> 


                <tr>
                <td colspan="3">                    
            <p style="color: #18A3FA;">Description longue</p>
            <textarea rows="5" name="tbDescLong" style="resize: none;width: 500px;  margin-left: 10px;" maxlength="250" class="textbox" ><?php echo $DescriptionLong ?></textarea> 
                </td>
                </tr>

            <tr>
                <td colspan="3">
                 <p style="color: #18A3FA;">Description courte</p>
                    <textarea class="textbox" name="tbDescCourt" rows="3" cols="77" maxlength="50" style="resize: none;width: 500px;  margin-left: 10px;margin-left: 10px;" ><?php echo $DescriptionCourt ?></textarea>
                </td>
            </tr>
                            <tr>
                    <td  colspan="1" rowspan="3">
                        <input id="btnAjouter" name="btnAjouter" type="button" value="Ajouter" class="btn" style="visibility:hidden" onclick="afficherMessages()" />
                    </td>
                    <td  colspan="1" rowspan="3">
                        <input id="btnModifier" name="btnModifier" type="button" value="Modifier" onclick="verifier();" class="btn" />
                    </td>
                    <td  colspan="1" rowspan="3">
                        <input id="btnSupprimer" name="btnSupprimer" type="button" value="Supprimer" class="btn"  onclick="Supprimer()" />
                    </td>
                </tr>
</table>
</form>
</div>
<?php require_once("footer.php"); ?>
</body>
<?php } ?>

