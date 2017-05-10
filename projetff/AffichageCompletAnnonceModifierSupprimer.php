
<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<link rel="stylesheet" href="styleSheet.css">
<script language="javascript" type="text/javascript" src="generalScript.js"></script>
<body>
<?php
$intLongueurTANormal = 25;
$intLongueurTAReduit = 15;

$booModeAdmin = true;

$intLongueurTAAffficher = $booModeAdmin == true?$intLongueurTAReduit:$intLongueurTANormal;
?>
<?php require_once("header.php"); ?>
<div  align="center" style="padding-top:40px">
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
                       <img src="600png.png" alt="imageProduit"/>   
                    </th>
                </tr>
                <tr>
                    <td>
                        <input id="tbNumero" name="tbNumero" class="textbox" type="text" maxlength="10" value="01" style="width: 100px"class="sTitreCentree"/>
                    </td>
                    <td>
                        <input id="tbCategorie" name="tbCategorie" class="textbox" type="text" maxlength="25" class="sTitreCentree" value="Jeux-Vidéo" style="width: 200px;"/>
                    </td>
                    <td>
                        <input id="radActif" name="radEtat" type="radio" value="A" checked="checked" />
                        <label for="radActif"> Actif</label>
                        <input id="radInactif" name="radEtat" type="radio" value="I" />
                        <label for="radInactif"> Inatif</label>
                    </td>
                </tr>

                                <tr >
                    <th style="padding-top: 25px;padding-left: 20px;vertical-align:middle;">
                        Prix : 
                    </th>
                    <td colspan="2" style="padding-top: 25px;padding-left: 20px;">
                        <input id="tbPrix" class="textbox" name="tbPrix" type="text" maxlength="50" class="sTitreCentree"  value="50,00$" style="width: 200px;"/>
                    </td>
                </tr>
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
                        01-05-2015 13:42 EST
                    </td>
                    <td>
                        16-06-2016 18:15 EST
                    </td>
                </tr> 


                <tr>
                <td colspan="3">

                    
            <p style="color: #18A3FA;">Description longue</p>
            <textarea rows="5" style="resize: none;width: 500px;  margin-left: 10px;" class="textbox" >La pomme de terre est un aliment qui a permis aux générations passées de pouvoir survivre au dur hiver québécois!
            </textarea> 

                </td>
                </tr>

            <tr>
                <td colspan="3">
                 <p style="color: #18A3FA;">Description courte</p>
                    <textarea class="textbox" rows="3" cols="77" style="resize: none;width: 500px;  margin-left: 10px;margin-left: 10px;" >La pomme de terre est un aliment qui a permis aux générations passées de pouvoir survivre au dur hiver québécois!
                    </textarea>
                </td>
            </tr>
                            <tr>
                    <td  colspan="1" rowspan="3">
                        <input id="btnAjouter" name="btnAjouter" type="button" value="Ajouter" class="btn" style="visibility:hidden" onclick="afficherMessages()" />
                    </td>
                    <td  colspan="1" rowspan="3">
                        <input id="btnModifier" name="btnModifier" type="button" value="Modifier" class="btn" style="visibility:hidden"  onclick="afficherMessages()" />
                    </td>
                    <td  colspan="1" rowspan="3">
                        <input id="btnSupprimer" name="btnSupprimer" type="button" value="Confirmer supprimation" class="btn"  onclick="affichageAnnonceUtilisateur()" />
                    </td>
                </tr>
</table>
</div>



<?php require_once("footer.php"); ?>
</body>


