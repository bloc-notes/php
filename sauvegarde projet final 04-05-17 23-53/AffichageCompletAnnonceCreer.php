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

$intNoUtil = $strUtilisateur;
$NoAnnonce = $BDProjet->selectionneMax("annonces", "NoAnnonce")+1;
$blnGET = get("tbCategorie");
 if($blnGET !="")
    {
            if(get("radEtat")=='I')
                {
                $NouvelEtat = 2;
                }
             else
                {
                 $NouvelEtat = 1;
                }
            /*if(get("userFile")!='')
            {
                 $file = get("userFile");
                 $remote_file = '/image/test.txt';
                 $ftp_server = "ftp://424w.cgodin.qc.ca/qwerty/";
                 $ftp_user_name = "f.chartrand";
                 $ftp_user_pass = "Password1";
                 // set up basic connection
                 $conn_id = ftp_connect($ftp_server);
                 // login with username and password
                 $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                 // upload a file
                 if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
                  echo "successfully uploaded $file\n";
                 } else {
                  echo "There was a problem while uploading $file\n";
                 }
                 // close the connection
                 ftp_close($conn_id);
            }*/
            /*$host = 'ftp://424w.cgodin.qc.ca/qwerty/';
            $usr = 'f.chartrand';
            $pwd = 'Password1';
            $local_file = get("userFile");
            $ftp_path = '/PhotosAnnonces';
            $conn_id = ftp_connect($host);
            ftp_login($conn_id, $usr, $pwd);
            $upload = ftp_put($conn_id, $ftp_path, $local_file, FTP_ASCII);
            ftp_close($conn_id);  */
             $NouveauPrix = str_replace(',','.',get("TbPrix"));
             $NouvelleDateParution = date("Y-m-d H:i:s");
             $NouvelleDescCourte = get("TbDescCourte");
             $NouvelleDescLongue = get("TbDescLongue");
             $nouvellePhoto = get("userFile");
             $NouvelleCat = get("tbCategorie")+1;
             $Requete="INSERT INTO annonces (NoAnnonce, NoUtilisateur, Parution, Categorie, DescriptionAbregee, DescriptionComplete, Prix, Photo, MiseAJour, Etat) 
                     VALUES ($NoAnnonce, $intNoUtil, '$NouvelleDateParution', $NouvelleCat, '$NouvelleDescCourte', '$NouvelleDescLongue', $NouveauPrix, '$nouvellePhoto', '$NouvelleDateParution', $NouvelEtat);";
             
             echo $Requete;
             mysqli_query($BDProjet->_cBD,$Requete);
             //changePage('affichageAnnonce');         
      }
?>
<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<link rel="stylesheet" href="styleSheet.css">
<script language="javascript" type="text/javascript" src="generalScript.js"></script>
<script type="text/javascript">
    function soumetFormulaire(){
               var frm;
               frm = document.getElementById('frmSaisieGET');
               frm.action = 'AffichageCompletAnnonceModifier.php';
               frm.submit();
           }
    function verifier()
    {
        var prix = document.getElementById("tbPrix").value;
        prix = prix.replace(",", ".");
        if(!(prix>0) || !(prix<100000))
        {
            document.getElementById("tbPrix").style.backgroundColor = "#fb9898";
            alert("Le prix doit être entre 0 et 100000!");
        }
        else
        {
            document.getElementById("tbPrix").style.backgroundColor = "#98FB98";
            var frm;
            frm = document.getElementById('frmSaisieGET');
            frm.action = 'AffichageCompletAnnonceCreer.php';
            frm.submit();
        }        
    }
    ////////A ALTERER, POURRAIT ETRE DU PLAGIAT SI CE N'EST PAS LE CAS'
    var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var imageProduit = document.getElementById('imageProduit');
      imageProduit.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
    imageProduit.style.height = '600px';
    imageProduit.style.width = '600px';
  };
    
</script>
<body>
<?php
$intLongueurTANormal = 25;
$intLongueurTAReduit = 15;

$booModeAdmin = true;

$intLongueurTAAffficher = $booModeAdmin == true?$intLongueurTAReduit:$intLongueurTANormal;


?>
<?php require_once("header.php");require_once("Doyon.php"); ?>
<div  align="center" style="padding-top:40px">
<form id="frmSaisieGET" method="get" action="">
<table border="0">
                <tr>
                    <th style="padding-top: 20px;padding-left: 20px;">
  
                    </th>
                    <th style="padding-top: 20px;padding-left: 20px;">

                    </th>
                    <th style="padding-top: 20px;padding-left: 20px;">
                    </th>
                                        <th rowspan="10">
                       <img src="600png.png" alt="imageProduit" id="imageProduit"/>   
                    </th>
                </tr>
                <tr>
                    <th style="padding-top: 10px;padding-left: 20px;">
                        Categorie : 
                    </th>
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
                    <td style="padding-top: 10px;">
                        <input id="radActif" name="radEtat" type="radio" value="A" checked="checked" />
                        <label for="radActif"> Actif</label>
                        <input id="radInactif" name="radEtat" type="radio" value="I" />
                        <label for="radInactif"> Inactif</label>
                    </td>
                </tr>

                                <tr >
                    <th style="padding-top: 25px;padding-left: 20px;vertical-align:middle;">
                        Prix : 
                    </th>
                    <td colspan="2" style="padding-top: 25px;padding-left: 20px;">
                        <input id="tbPrix" class="textbox" name="tbPrix" type="number" maxlength="50" class="sTitreCentree"  value="" style="width: 200px;"/> $ CAD
                    </td>
                </tr>
                 <tr>
                    <th style="padding-top: 25px;padding-left: 20px;">
                            Image:
                    </th>
                    <th style="padding-top: 15px;padding-left: 20px;">
                    <input type='file' class="btn" name='userFile' accept="image/*" onchange="loadFile(event)"><br>
                    </th>
                </tr>
                
                <tr>
                    <td></td>
                    <td></td>
                </tr> 
                <tr>
                <td colspan="3">

                    
            <p style="color: #18A3FA;">Description longue</p>
            <textarea rows="5" name="TbDescLongue" maxlength="250" style="resize: none;width: 500px;  margin-left: 10px;" class="textbox" ></textarea> 

                </td>
                </tr>

            <tr>
                <td colspan="3">
                 <p style="color: #18A3FA;">Description courte</p>
                    <textarea class="textbox" name="TbDescCourte" rows="3" cols="77" maxlength="50" style="resize: none;width: 500px;  margin-left: 10px;margin-left: 10px;" ></textarea>
                </td>
            </tr>
                            <tr>
                    <td  colspan="1" rowspan="3">
                    <input id="btnAjouter" name="btnAjouter" type="button" onclick="verifier();" value="Ajouter" class="btn" />
                    </td>
                    <td  colspan="1" rowspan="3">
                    </td>
                    <td  colspan="1" rowspan="3">
                    </td>
                </tr>
</table>
</form>
</div>



<?php require_once("footer.php"); ?>
</body>


