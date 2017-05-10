<?php require_once("Doyon.php"); ?>
<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<link rel="stylesheet" href="styleSheet.css">
<script language="javascript" type="text/javascript" src="generalScript.js"></script>
<body>
<?php require_once("En-tete"); ?>
<div align="right">
	<table > <input type="text" class="textbox" placeholder="Termes de recherche" style="margin-right:20px">
  <input type="button" style="font-weight:bold;margin-top:10px;margin-right:40px" class="btn" value="Rechercher produit" onClick="changePage('AffichageCompletAnnonceCreer.php')">
             <select>
            <option disabled selected hidden> Trié par</option>
            <option value="DateParution">Date Parution (Croissant)</option>
            <option value="DateParution">Date Parution (Déroissant)</option>
            <option value="Categorie">Catégorie (Croissant)</option>
            <option value="Categorie">Catégorie (Déroissant)</option>
            <option value="DescriptionAbregee">Description Abrégée (Croissant)</option>
            <option value="DescriptionAbregee">Description Abrégée (Déroissant)</option>
             </select>
          
            Nb Résultats
             <select>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
             </select> 
              <input type="button" style="font-weight:bold;margin-top:10px;margin-left:120px" class="btn" value="Ajouter produit" onClick="changePage('AffichageCompletAnnonceCreer.php')">
    </table>

<div align="center" style="margin-top: 10px;">
  <table  border="0">
    <tr>
        <td style="vertical-align:middle;font-weight:bold;font-weight:bold;font-size: 60px;" rowspan="5">01</td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;" rowspan="5"> <img src="144png.png"></td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 30px;" colspan="1">$635.89 CAD </td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 20px;text-align:right;padding-right: 15px;" colspan="1">Catégorie: Produit électronique</td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 20px;text-align:left;padding-left: 0px;" rowspan="1">No. 00784</td>

        <td rowspan="5" style="min-width: 100px;">   
          <br>
          <br>

        </td>
    </tr>
    <tr>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;" colspan="2" rowspan="1"><a href="contacterAuteur.php">Hubert, Saint</a> </td>
        <td style="vertical-align:bottom;font-weight:bold;text-align:left;" rowspan="4">2017/01/07<br>13:42 EST</td>
        <tr>
            <td colspan="2" style="min-width: 600px;" rowspan="3"><a href="affichageCompletAnnonce.php">Ceci est une petite description du produit en question.</td>
        </tr>
    </tr>
  </table>   
</div>  

<div align="center" style="margin-top: 10px;">
  <table  border="0">
    <tr>
        <td style="vertical-align:middle;font-weight:bold;font-weight:bold;font-size: 60px;" rowspan="5">02</td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;" rowspan="5"> <img src="144png.png"></td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 30px;" colspan="1">$635.89 CAD </td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 20px;text-align:right;padding-right: 15px;" colspan="1">Catégorie: Produit électronique</td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 20px;text-align:left;padding-left: 0px;" rowspan="1">No. 00784</td>

        <td rowspan="5" style="min-width: 100px;">   
          <br>
          <br>

        </td>
    </tr>
    <tr>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;" colspan="2" rowspan="1"><a href="contacterAuteur.php">Hubert, Saint</a> </td>
        <td style="vertical-align:bottom;font-weight:bold;text-align:left;" rowspan="4">2017/01/07<br>13:42 EST</td>
        <tr>
            <td colspan="2" style="min-width: 600px;" rowspan="3"><a href="affichageCompletAnnonce.php">Ceci est une petite description du produit en question.</td>
        </tr>
    </tr>
  </table>   
</div>  

<div align="center" style="margin-top: 10px;">
  <table  border="0">
    <tr>
        <td style="vertical-align:middle;font-weight:bold;font-weight:bold;font-size: 60px;" rowspan="5">03</td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;" rowspan="5"> <img src="144png.png"></td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 30px;" colspan="1">$748.22 CAD </td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 20px;text-align:right;padding-right: 15px;" colspan="1">Catégorie: Produit de santé</td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 20px;text-align:left;padding-left: 0px;" rowspan="1">No. 00783</td>

        <td rowspan="5" style="min-width: 100px;">   
          <input type="button" style="font-weight:bold;margin-top:20px;" class="btn" value="Modifier" onClick="changePage('AffichageCompletAnnonceModifier.php')"><br>
          <input type="button" style="font-weight:bold;margin-top:10px;" class="btn" value="Supprimer" onClick="changePage('AffichageCompletAnnonceModifierSupprimer.php')"><br>
          <input type="button" style="font-weight:bold;margin-top:10px;" class="btn" value="Désactiver" onClick="changePage('affichageAnnonceUtilisateur.php')">
        </td>
    </tr>
    <tr>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;" colspan="2" rowspan="1">Jean, Pierre </td>
        <td style="vertical-align:bottom;font-weight:bold;text-align:left;" rowspan="4">2017/01/07<br>13:42 EST</td>
        <tr>
            <td colspan="2" style="min-width: 600px;" rowspan="3"><a href="AffichageCompletAnnonceModifier.php">Ceci est une petite description du produit en question.</td>
        </tr>
    </tr>
  </table>   
</div>  

<div align="center" style="margin-top: 10px;">
  <table  border="0">
    <tr>
        <td style="vertical-align:middle;font-weight:bold;font-weight:bold;font-size: 60px;" rowspan="5">04</td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;" rowspan="5"> <img src="144png.png"></td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 30px;" colspan="1">$635.89 CAD </td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 20px;text-align:right;padding-right: 15px;" colspan="1">Catégorie: Produit électronique</td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 20px;text-align:left;padding-left: 0px;" rowspan="1">No. 00784</td>

        <td rowspan="5" style="min-width: 100px;">   
          <br>
          <br>

        </td>
    </tr>
    <tr>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;" colspan="2" rowspan="1"><a href="contacterAuteur.php">Hubert, Saint</a> </td>
        <td style="vertical-align:bottom;font-weight:bold;text-align:left;" rowspan="4">2017/01/07<br>13:42 EST</td>
        <tr>
            <td colspan="2" style="min-width: 600px;" rowspan="3"><a href="affichageCompletAnnonce.php">Ceci est une petite description du produit en question.</td>
        </tr>
    </tr>
  </table>   
</div>  

<div align="center" style="margin-top: 10px;">
  <table  border="0">
    <tr>
        <td style="vertical-align:middle;font-weight:bold;font-weight:bold;font-size: 60px;" rowspan="5">05</td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;" rowspan="5"> <img src="144png.png"></td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 30px;" colspan="1">$635.89 CAD </td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 20px;text-align:right;padding-right: 15px;" colspan="1">Catégorie: Produit électronique</td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 20px;text-align:left;padding-left: 0px;" rowspan="1">No. 00784</td>

        <td rowspan="5" style="min-width: 100px;">   
          <br>
          <br>

        </td>
    </tr>
    <tr>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;" colspan="2" rowspan="1"><a href="contacterAuteur.php">Hubert, Saint</a> </td>
        <td style="vertical-align:bottom;font-weight:bold;text-align:left;" rowspan="4">2017/01/07<br>13:42 EST</td>
        <tr>
            <td colspan="2" style="min-width: 600px;" rowspan="3"><a href="affichageCompletAnnonce.php">Ceci est une petite description du produit en question.</td>
        </tr>
    </tr>
  </table>   
</div>  

<div align="center" style="margin-top: 10px;">
  <table  border="0">
    <tr>
        <td style="vertical-align:middle;font-weight:bold;font-weight:bold;font-size: 60px;" rowspan="5">06</td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;" rowspan="5"> <img src="144png.png"></td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 30px;" colspan="1">$635.89 CAD </td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 20px;text-align:right;padding-right: 15px;" colspan="1">Catégorie: Produit électronique</td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 20px;text-align:left;padding-left: 0px;" rowspan="1">No. 00784</td>

        <td rowspan="5" style="min-width: 100px;">   
          <br>
          <br>

        </td>
    </tr>
    <tr>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;" colspan="2" rowspan="1"><a href="contacterAuteur.php">Hubert, Saint</a> </td>
        <td style="vertical-align:bottom;font-weight:bold;text-align:left;" rowspan="4">2017/01/07<br>13:42 EST</td>
        <tr>
            <td colspan="2" style="min-width: 600px;" rowspan="3"><a href="affichageCompletAnnonce.php">Ceci est une petite description du produit en question.</td>
        </tr>
    </tr>
  </table>   
</div>  

<div align="center" style="margin-top: 10px;">
  <table  border="0">
    <tr>
        <td style="vertical-align:middle;font-weight:bold;font-weight:bold;font-size: 60px;" rowspan="5">07</td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;" rowspan="5"> <img src="144png.png"></td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 30px;" colspan="1">$635.89 CAD </td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 20px;text-align:right;padding-right: 15px;" colspan="1">Catégorie: Produit électronique</td>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;font-size: 20px;text-align:left;padding-left: 0px;" rowspan="1">No. 00784</td>

        <td rowspan="5" style="min-width: 100px;">   
          <br>
          <br>

        </td>
    </tr>
    <tr>
        <td style="vertical-align:middle;font-weight:bold;padding-top: 15px;" colspan="2" rowspan="1"><a href="contacterAuteur.php">Hubert, Saint</a> </td>
        <td style="vertical-align:bottom;font-weight:bold;text-align:left;" rowspan="4">2017/01/07<br>13:42 EST</td>
        <tr>
            <td colspan="2" style="min-width: 600px;" rowspan="3"><a href="affichageCompletAnnonce.php">Ceci est une petite description du produit en question.</td>
        </tr>
    </tr>
  </table>   
</div>  




            

</div>
<?php require_once("footer.php"); ?>
</body>
</html>