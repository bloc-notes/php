<?php
session_start();
$strNomUtilisateur = $_SESSION["nomComplet"];

require_once "en-tete.php";
$intDocsEffaces=0;
?>
<script language="JavaScript">
function cochetout(source) {
  cases = document.getElementsByName('case');
  for(var i=0, n=cases.length;i<n;i++) {
    cases[i].checked = source.checked;
  }
}
function supprimer() {
  cases = document.getElementsByName('case');
  for(var i=0, n=cases.length;i<n;i++) {
    if(cases[i].checked){
	document.getElementById('etatDoc'+(i+1)).textContent="Supprimé";
	}
  }
  document.getElementById("docsEtatApresSuppression").style.display = 'block';
    document.getElementById("Resultats").style.display = 'block';
  document.getElementById("arboDocASupprimer").style.display = 'none';
}

function triTable(n) {
  var table, rangees, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("tableDocPossiblementEffaces");
  switching = true;
  //Met la direction en ascendant
  dir = "asc"; 
  /*Crée une loop qui continue jusqu'à ce que aucun tri n'est fait:*/
  while (switching) {
    //commence en disant qu'aucun tri n'est fait:
    switching = false;
    rangees = table.getElementsByTagName("TR");
    /*Loop À travers toutes les rangées sauf les premières:*/
    for (i = 1; i < (rangees.length - 1); i++) {
      //commence en disant qu'il ne doit pas avoir de tri:
      shouldSwitch = false;
      /*Reçoit les 2 éléments à comparer :
       * Un de la première rangée, l'autre de la seconde*/
      x = rangees[i].getElementsByTagName("TD")[n];
      y = rangees[i + 1].getElementsByTagName("TD")[n];
      /*vérifie si les 2 colonnes doivent s'échanger de place:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //si oui
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //si oui:
          shouldSwitch= true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rangees[i].parentNode.insertBefore(rangees[i + 1], rangees[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

</script>
<div id="Option 5" class="sComprime30 sCentre">
    <header>
        <h1>Arborescence des Documents</h1>
    </header>

<div id="arboDocASupprimer">
    <table id="tableDocPossiblementEffaces">
        <tr>
        <th onclick="triTable(0)">#</th>
        <th onclick="triTable(1)">Session</th>
        <th>Sigle</th>
        <th onclick="triTable(3)">Professeur</th>
        <th>Date du cours</th>
        <th onclick="triTable(5)">Titre du document</th>
        <th><input type="checkbox" onClick="cochetout(this)" /></th>
        </tr>
        <tr>
            <td>1</td>
            <td>H-2017</td>
            <td>420-3B4</td>
            <td>Brousseau, Louis-Marie</td>
            <td>2017-11-15</td>
            <td>Fichier à copier sur P</td>
            <td><input type="checkbox" name="case" value="case1"></td>
        </tr>
        <tr>
            <td>2</td>
            <td>H-2018</td>
            <td>420-4B4</td>
            <td>Cherief, Ferroudja</td>
            <td>2018-03-01</td>
            <td>SQL</td>
            <td><input type="checkbox" name="case" value="case2"></td>
        </tr>
    </table>
    
    <button id="Action" name="Action" type="button" value="Supprimer" onclick='supprimer();'>Supprimer</button>
    <button id="Action" name="Action" type="button" value="Annuler" >Annuler</button>
</div>

<div id="docsEtatApresSuppression">
<table id="tableDocsApresTraitement">
        <tr>
        <th>#</th>
        <th>Session</th>
        <th>Sigle</th>
        <th>Professeur</th>
        <th>Date du cours</th>
        <th>Titre du document</th>
        <th>Verdict</th>
        </tr>
        <tr>
            <td>1</td>
            <td>H-2017</td>
            <td>420-3B4</td>
            <td>Brousseau, Louis-Marie</td>
            <td>2017-11-15</td>
            <td>Fichier à copier sur P</td>
            <td><span id="etatDoc1"></span></td>
        </tr>
        <tr>
            <td>2</td>
            <td>H-2018</td>
            <td>420-4B4</td>
            <td>Cherief, Ferroudja</td>
            <td>2018-03-01</td>
            <td>SQL</td>
            <td><span id="etatDoc2"></span></td>
        </tr>
    </table>
</div>
<div id="Resultats">
    <table id="tableResultats">
     <th>No</th> 
     <th>Nom</th> 
     <th>Verdict</th>
     <tr>
     <td>1</td>
     <td>SQL2</td>
     <td>Effacé</td>
     </tr>
    </table>
    Documents effacés:<?php echo $intDocsEffaces ?>
</div>
</div>
    <script type="text/javascript">
    var div1 = document.getElementById("docsEtatApresSuppression");
    div1.style.display = 'none';
    document.getElementById("Resultats").style.display = 'none';
    </script>
<?php
require_once "pied-page.php";

