<?php
$intLongueurTANormal = 25;
$intLongueurTAReduit = 15;

$booModeAdmin = false;

$intLongueurTAAffficher = $booModeAdmin == true?$intLongueurTAReduit:$intLongueurTANormal;
?>
<div id="divAnnonceDetaillee" class="sAnnonceDetaillee">
    <div id="divDetailleeHaut" class="sAnnonceHaut">
        
        <div id="divDetailleeInformation" class="sAnnonceDetailleeHautGauche">
            <table class="sDetailleeTableau">
                <tr>
                    <th>
                        Numéro
                    </th>
                    <th>
                        Catégorie
                    </th>
                    <th>
                        État
                    </th>
                </tr>
                <tr>
                    <td>
                        <input id="tbNumero" name="tbNumero" type="text" maxlength="10" value="01" style="width: 100px"class="sTitreCentree"/>
                    </td>
                    <td>
                        <input id="tbCategorie" name="tbCategorie" type="text" maxlength="25" class="sTitreCentree" value="Jeux-Vidéo"/>
                    </td>
                    <td>
                        <input id="radActif" name="radEtat" type="radio" value="A" checked="checked" />
						<label for="radActif"> Actif</label>
                        <input id="radInactif" name="radEtat" type="radio" value="I" />
						<label for="radInactif"> Inatif</label>
                    </td>
                </tr>
            </table>    
            <table class="sDetailleeTableau">    
                <tr >
                    <th>
                        Prix : 
                    </th>
                    <td colspan="2">
                        <input id="tbPrix" name="tbPrix" type="text" maxlength="50" class="sTitreCentree"  value="50,00$" style="width: 200px;"/>
                    </td>
                </tr>
            </table>    
            <table class="sDetailleeTableau">    
                <tr>
                    <th>
                        Date de Parusion
                    </th>
                    <th>
                        Date de mise à jour
                    </th>
                </tr>
                
                <tr>
                    <td>
                        <input id="tdDatePa" name="tdDatePa" type="text" maxlength="10" class="sTitreCentree" style="width: 130px" value="01-05-2015"/>
                    </td>
                    <td>
                        <input id="tbDateMAJ" name="tbDateMAJ" type="text" maxlength="10" class="sTitreCentree" style="width: 140px" value="16-06-2016"/>
                    </td>
                </tr>  
            </table>
            
            <p class="sTitreCentree" style="color: #18A3FA;">Description longue</p>
            <textarea rows="<?php echo $intLongueurTAAffficher;?>" cols="77" style="resize: none; border-color: #18A3FA;  margin-left: 10px;" >La pomme de terre est un aliment qui a permis aux générations passées de pouvoir survivre au dur hiver québécois!
            </textarea>            
            <!-- si modification -->
<?php
if($booModeAdmin){
?>
            <table>
            <tr>
                <th style="padding: 2%; color: #18A3FA;">
                    Description courte
                </th>
            </tr>
            <tr>
                <td>
                    <textarea rows="3" cols="77" style="resize: none; border-color: #18A3FA;  margin-left: 10px;" >La pomme de terre est un aliment qui a permis aux générations passées de pouvoir survivre au dur hiver québécois!
                    </textarea>
                </td>
            </tr>
            </table>
            <table style="margin: 6pt;width:580px; text-align: center;">
                <tr>
                    <td>
                        <input id="btnAjouter" name="btnAjouter" type="button" value="Ajouter"  onclick="afficherMessages()" />
                    </td>
                    <td>
                        <input id="btnModifier" name="btnModifier" type="button" value="Modifier"  onclick="afficherMessages()" />
                    </td>
                    <td>
                        <input id="btnSupprimer" name="btnSupprimer" type="button" value="Supprimer"  onclick="afficherMessages()" />
                    </td>
                </tr>
                
            </table>
<?php
}
?>
        </div>
        <div id="divDetailleeImage" class="sAnnonceDetailleImage sBordureDivision">
            <img src="image600x600.jpg" alt="chevreil"/>   
        </div>
    </div>
</div>



