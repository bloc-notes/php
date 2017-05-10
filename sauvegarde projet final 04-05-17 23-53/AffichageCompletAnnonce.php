
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
<?php require_once("Doyon.php"); require_once("header.php");?>
<div  align="center" style="padding-top:40px">
<table border="0">
                <tr >
                    <th style="padding-top: 20px;padding-left: 20px;">
                        Numéro:
                    </th>
                    <th style="padding-top: 20px;padding-left: 20px;">
                        Catégorie:
                    </th>
                    <th style="padding-top: 20px;padding-left: 20px;">
                        État:
                    </th>
                                        <th rowspan="13">
                       <img src="600png.png" alt="imageProduit"/>   
                    </th>
                </tr>
                <tr >
                    <td >
                        00348
                    </td>
                    <td>
                        Jeux-Vidéo
                    </td>
                    <td>
                        Actif
                    </td>
                </tr>

                                <tr >
                    <th style="padding-top: 40px;padding-left: 20px;">
                        Prix: 
                    </th>
                    <td colspan="2" style="padding-top: 40px">
                        $58.99 CAD
                    </td>
                </tr>

                 <tr >
                    <th style="padding-top: 10px;padding-left: 20px;">
                        Tel. Maison: 
                    </th>
                    <td colspan="2" style="padding-top: 10px">
                        (514) 514-5145 EXT: #514
                    </td>
                </tr>
                                 <tr >
                    <th style="padding-top: 10px;padding-left: 20px;">
                        Tel. Travail: 
                    </th>
                    <td colspan="2" style="padding-top: 10px">
                        (514) 514-5145 EXT: #514
                    </td>
                </tr>
                                 <tr >
                    <th style="padding-top: 10px;padding-left: 20px;">
                        Tel. Cellulaire: 
                    </th>
                    <td colspan="2" style="padding-top: 10px">
                        (514) 514-5145 EXT: #514
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
                        01-05-2015
                    </td>
                    <td>
                        16-06-2016
                    </td>
                </tr> 


                <tr>
                <td colspan="3">

                    
            <p style="color: #18A3FA;">Description longue:</p>
            <textarea rows="5" disabled style="resize: none;width: 500px;  margin-left: 10px;" class="textbox" >La pomme de terre est un aliment qui a permis aux générations passées de pouvoir survivre au dur hiver québécois!
            </textarea> 

                </td>
                </tr>

            <tr>
                <td colspan="3">
                 <p style="color: #18A3FA;visibility:hidden;">Description courte</p>
                    <textarea class="textbox" rows="3" style="visibility:hidden"  cols="77" style="resize: none;width: 500px;  margin-left: 10px;margin-left: 10px;" >La pomme de terre est un aliment qui a permis aux générations passées de pouvoir survivre au dur hiver québécois!
                    </textarea>
                </td>
            </tr>
                            <tr>
                    <td  colspan="1" rowspan="3">
                        <input id="btnAjouter" name="btnAjouter" type="button" value="Contacter le fournisseur" class="btn"  onclick="changePage('ContacterAuteur.php')"/>
                    </td>
                    <td  colspan="1" rowspan="3">
                        <input id="btnModifier" name="btnModifier" type="button" value="Modifier" class="btn"  style="visibility:hidden"  onclick="afficherMessages()" />
                    </td>
                    <td  colspan="1" rowspan="3">
                        <input id="btnSupprimer" name="btnSupprimer" type="button" value="Supprimer" class="btn" style="visibility:hidden"  onclick="afficherMessages()" />
                    </td>
                </tr>
</table>
</div>



<?php require_once("footer.php"); ?>
</body>


