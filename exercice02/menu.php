<?php
   $strTitreApplication = "Validation de l'exercice 2 (Menu)";
   $strNomFichierCSS = "index.css";
   $strNomAuteur = "Louis-Marie Brousseau";

   require_once "en-tete.php";
?>
<div id="divMenu" class="">
   <p class="sTitreSection">
      Menu
   </p>
   <ul>
      <li>
         <a href="probleme1.php">probleme1.php</a>
         <br /><br />
      </li>
      <li>
         <a href="probleme2.php?Probleme=2"           >probleme2.php</a><br /><br />
         <a href="probleme2.php?DateDuJour=2018-02-09">probleme2.php?DateDuJour=2018-02-09</a><br />
         <a href="probleme2.php?DateDuJour=2019-03-27">probleme2.php?DateDuJour=2019-03-27</a><br />
         <a href="probleme2.php?DateDuJour=2020-06-21">probleme2.php?DateDuJour=2020-06-21</a><br />
         <a href="probleme2.php?DateDuJour=2021-04-12">probleme2.php?DateDuJour=2021-04-12</a><br />
         <br />
      </li>
      <li>
         <a href="probleme3.php"               >probleme3.php</a><br /><br />
         <a href="probleme3.php?MoisCourant=1" >probleme3.php?MoisCourant=1</a><br />
         <a href="probleme3.php?MoisCourant=2" >probleme3.php?MoisCourant=2</a><br />
         <a href="probleme3.php?MoisCourant=3" >probleme3.php?MoisCourant=3</a><br />
         <a href="probleme3.php?MoisCourant=4" >probleme3.php?MoisCourant=4</a><br />
         <a href="probleme3.php?MoisCourant=5" >probleme3.php?MoisCourant=5</a><br />
         <a href="probleme3.php?MoisCourant=6" >probleme3.php?MoisCourant=6</a><br />
         <a href="probleme3.php?MoisCourant=7" >probleme3.php?MoisCourant=7</a><br />
         <a href="probleme3.php?MoisCourant=8" >probleme3.php?MoisCourant=8</a><br />
         <a href="probleme3.php?MoisCourant=9" >probleme3.php?MoisCourant=9</a><br />
         <a href="probleme3.php?MoisCourant=10">probleme3.php?MoisCourant=10</a><br />
         <a href="probleme3.php?MoisCourant=11">probleme3.php?MoisCourant=11</a><br />
         <a href="probleme3.php?MoisCourant=12">probleme3.php?MoisCourant=12</a><br />
         <br />
         
      </li>
      <li>
         <a href="probleme4.php"                         >probleme4.php</a><br /><br />
      </li>
   </ul>
<?php
   require_once "pied-page.php";
?>