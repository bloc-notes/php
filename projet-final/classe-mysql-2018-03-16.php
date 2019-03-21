<?php
   /*
   |----------------------------------------------------------------------------------------|
   | class mysql
   |----------------------------------------------------------------------------------------|
   */
   class mysql {
      /*
      |----------------------------------------------------------------------------------|
      | Attributs
      |----------------------------------------------------------------------------------|
      */
      public $cBD = null;                       /* Identifiant de connexion */
      public $listeEnregistrements = null;      /* Liste des enregistrements retournés */
      public $nomFichierInfosSensibles = "";    /* Nom du fichier 'InfosSensibles' */
      public $nomBD = "";                       /* Nom de la base de données */
      public $OK = false;                       /* Opération réussie ou non */
      public $requete = "";                     /* Requête exécutée */
      
      private $strErrConnect = "Connexion impossible à la base de données !!! Veuillez contacter votre administrateur système !!!";
      private $strErrSelectDB = "Impossible de sélectionner la base de données Veuillez contacter votre administrateur système !!!";
      private $strErrSuppresion = "Impossible de supprimer la table ou les données de la base de données !!! Veuillez contacter votre administrateur système !!!";
      private $strErrCreation = "Impossible de créer une table dans la base de données !!! Veuillez contacter votre administrateur système !!!";
      private $strErrInsertion = "Impossible d'insérer la ou les données à la table dans la base de données !!! Veuillez contacter votre administrateur système !!!";
      private $strErrDeconnexion = "Impossible de se déconnecter de la base de données !!! Veuillez contacter votre administrateur système !!!";
      private $strErrSelect = "Table vide dans la base de données !!! Veuillez contacter votre administrateur système !!!";
      private $strErrUpdate = "Impossible de mettre à jour la table dans la base de données !!! Veuillez contacter votre administrateur système !!!";
      /*
      |----------------------------------------------------------------------------------|
      | __construct
      |----------------------------------------------------------------------------------|
      */
      function __construct($strNomBD, $strNomFichierInfosSensibles) {
          $this->nomBD = $strNomBD;
          $this->nomFichierInfosSensibles = $strNomFichierInfosSensibles;
                    
          $this->connexion();
          
          $this->selectionneBD();
      }
      /*
      |----------------------------------------------------------------------------------|
      | connexion()
      |----------------------------------------------------------------------------------|
      */
      function connexion() {
          require_once $this->nomFichierInfosSensibles;
          
          return $this->cBD = mysqli_connect("localhost", $strNomAdmin, $strMotPasseAdmin, $this->nomBD) or die(str_repeat("<br/><br/>", 10)."<strong>".$this->strErrConnect."</strong>".str_repeat("<br/><br/>", 10));
      }
      /*
      |----------------------------------------------------------------------------------|
      | copieEnregistrements
      |----------------------------------------------------------------------------------|
      */
      function copieEnregistrements($strNomTableSource, $strListeChampsSource, $strNomTableCible, $strListeChampsCible, $strListeConditions="") {
         /* Réf.: www.lecoindunet.com/dupliquer-ou-copier-des-lignes-d-une-table-vers-une-autre-avec-mysql-175 */
      }
      /*
      |----------------------------------------------------------------------------------|
      | creeTableNormale
      |----------------------------------------------------------------------------------|
      */
      function creeTableNormale($strNomTable, $strContenu) {
          $this->requete = "create table if not exists ".$strNomTable." (".$strContenu.(func_num_args()>2 ? ", ".func_get_arg(2) : "").") ENGINE=InnoDB";
          return $this->OK = mysqli_query($this->cBD, $this->requete) or die(str_repeat("<br/><br/>", 10)."<strong>".$strNomTable.", ".$this->requete."<br/><br/>".$this->strErrCreation."</strong>".str_repeat("<br/><br/>", 10));
      }
      
      /*
      |----------------------------------------------------------------------------------|
      | creeTable
      |----------------------------------------------------------------------------------|
      */
      function creeTable($strNomTable) {
          $this->requete = "";
          
          for ($i=0; $i<func_num_args(); $i++) {
              if ($i==0) {
                  $this->requete .= "CREATE TABLE ".func_get_arg($i)." (";
              }
              else if ($i==func_num_args()-1) {
                  $this->requete .= func_get_arg($i).") ENGINE=InnoDB";
              }
              else if ($i%2==0) {
                  $this->requete .= func_get_arg($i).", ";
              }
              else {
                  $this->requete .= func_get_arg($i)." ";
              }
          }
          
          return $this->OK = mysqli_query($this->cBD, $this->requete);
      }
      /*
      |----------------------------------------------------------------------------------|
      | creeTableGenerique()
      |----------------------------------------------------------------------------------|
      */
      function creeTableGenerique($strNomTable, $strDefinitions, $strCles) {
          $arrDefinition = explode(";", $strDefinitions);
          $arrCles = explode(",", $strCles);
          
          $this->requete = "CREATE TABLE ".$strNomTable." (";
          for ($i=0; $i<count($arrDefinition); $i++) {
              list($strType, $strNom) = explode(",", $arrDefinition[$i]);
          
              switch (substr($strType, 0, 1)) {
                  case "B": $this->requete .= $strNom." BOOL, ";                      break;
                  case "C": $this->requete .= $strNom." DECIMAL(".str_replace(".", ",", substr($strType,1,strlen($strType)))."), ";                      break;
                  case "D": $this->requete .= $strNom." DATE, ";                      break;
                  case "E": $this->requete .= $strNom." INT, ";                      break;
                  case "F": $this->requete .= $strNom." CHAR(".substr($strType,1,strlen($strType))."), ";                      break;
                  case "M": $this->requete .= $strNom." DECIMAL("./*str_replace(".", ",", substr($strType,1,strlen($strType))).*/"10,2), ";                      break;
                  case "N": $this->requete .= $strNom." INT NOT NULL, ";                      break;
                  case "V": $this->requete .= $strNom." VARCHAR(".substr($strType,1,strlen($strType))."), ";                      break;
              }
          }
          
          /*$this->requete .= "PRIMARY KEY(";
          for ($y=0; $y<count($arrCles); $y++) {
              $this->requete .= ($i==0) ? $strCles : ", ".$strCles;
          }
          $this->requete .= ") ENGINE=InnoDB";*/
          
          $this->requete .= "PRIMARY KEY(".$strCles.")) ENGINE=InnoDB";
          
          return $this->OK = mysqli_query($this->cBD, $this->requete);
      }
      /*
      |----------------------------------------------------------------------------------|
      | deconnexion
      |----------------------------------------------------------------------------------|
      */
      function deconnexion() {
          return $this->OK = mysqli_close($this->cBD) or die(str_repeat("<br/><br/>", 10)."<strong>".$this->strErrDeconnexion."</strong>".str_repeat("<br/><br/>", 10));
      }
      /*
      |----------------------------------------------------------------------------------|
      | effaceDonnees
      |----------------------------------------------------------------------------------|
      */
      function effaceDonnees($strNomTable, $strRequete) {
          $this->requete = "delete from ".$strNomTable." where ".$strRequete;
          return $this->OK = mysqli_query($this->cBD, $this->requete) or die(str_repeat("<br/><br/>", 10)."<strong>".$strNomTable.", ".$this->requete."<br/><br/>".$this->strErrSuppresion."</strong>".str_repeat("<br/><br/>", 10));
      }
      /*
      |----------------------------------------------------------------------------------|
      | insereEnregistrement
      |----------------------------------------------------------------------------------|
      */
      function insereDonnees($strNomTable) {
          if (func_num_args()>2) $this->requete = "insert into ".$strNomTable." (". func_get_arg(1).") values (". func_get_arg(2).")";
          else $this->requete = "insert into ".$strNomTable." values (". func_get_arg(1).")";
              
          return $this->OK = mysqli_query($this->cBD, $this->requete) or die(str_repeat("<br/><br/>", 10)."<strong>".$strNomTable.", ".$this->requete."<br/><br/>".$this->strErrInsertion."</strong>".str_repeat("<br/><br/>", 10));
      }
      /*
      |----------------------------------------------------------------------------------|
      | insereEnregistrement
      |----------------------------------------------------------------------------------|
      */
      function insereEnregistrement($strNomTable) {         
          $this->requete = "INSERT INTO ";
          for ($i=0; $i<func_num_args(); $i++) {
              // http://us3.php.net/manual/en/function.assert.php#78176
              
              if ($i==0) {
                  $this->requete .= func_get_arg($i)." VALUES (";
              }
              else {
                  $this->requete .= 
                          (strcasecmp(func_get_arg($i), "true")!=0 && strcasecmp(func_get_arg($i), "false")!=0 ? // IFF
                            (is_string(func_get_arg($i))===true ? // IFF
                                "'".str_replace("'", "\\'", func_get_arg($i))."'" : 
                                (empty(func_get_arg($i))===true ? // IFF
                                        "NULL" : 
                                        func_get_arg($i))) : 
                            func_get_arg($i));
                  $this->requete .= ($i==func_num_args()-1) ? ")" : ",";
              }
          }
          
          return $this->OK = mysqli_query($this->cBD, $this->requete);
      }
      /*
      |----------------------------------------------------------------------------------|
      | modifieDonnees
      |----------------------------------------------------------------------------------|
      */
      function modifieDonnees($strNomTable, $strDonnees) {
          $this->requete = "update ".$strNomTable." set ".$strDonnees.(func_num_args()>2 ? " where ".func_get_arg(2) : "");
          return $this->OK = mysqli_query($this->cBD, $this->requete) or die(str_repeat("<br/><br/>", 10)."<strong>".$strNomTable.", ".$this->requete."<br/><br/>".$this->strErrUpdate."</strong>".str_repeat("<br/><br/>", 10));
      }
      /*
      |----------------------------------------------------------------------------------|
      | modifieChamp
      |----------------------------------------------------------------------------------|
      */
      function modifieChamp($strNomTable, $strNomChamp, $strNouvelleDefinition) {
      }
      /*
      |----------------------------------------------------------------------------------|
      | retourneQuery()
      |----------------------------------------------------------------------------------|
      */
      function retourneSelect($strNomTable, $strDonnees) {
          $arrDonnees = explode(",", str_replace(" ", "", $strDonnees));
          $this->requete = "select ".$strDonnees." from ".$strNomTable.(func_num_args()>2 ? " ".func_get_arg(2) : "");
          $this->OK = mysqli_query($this->cBD, $this->requete) or die(str_repeat("<br/><br/>", 10)."<strong>".$strNomTable.", ".$this->requete."<br/><br/>".$this->strErrSelect."</strong>".str_repeat("<br/><br/>", 10));
          
          $arrReturn = array();
          if ($this->OK && mysqli_num_rows($this->OK)>0) {
              while($row = mysqli_fetch_assoc($this->OK)) {
                $strResultat = "";
                for ($i=0; $i<count($arrDonnees); $i++) {
                    $strResultat .= $row[$arrDonnees[$i]].";";
                }
                array_push($arrReturn, substr($strResultat, 0, -1));
                //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
              }
          }
          /*else {
              return $arrReturn; //0 resultats
          }*/
          
          return $arrReturn;
      }
      /*
      |----------------------------------------------------------------------------------|
      | selectionneBD()
      |----------------------------------------------------------------------------------|
      */
      function selectionneBD() {
          return $this->OK = mysqli_select_db($this->cBD, $this->nomBD) or die(str_repeat("<br/><br/>", 10)."<strong>".$this->strErrSelectDB."</strong>".str_repeat("<br/><br/>", 10));
      }
      /*
      |----------------------------------------------------------------------------------|
      | supprimeDonnees
      |----------------------------------------------------------------------------------|
      */
      function supprimeDonnees($strNomTable) {
          if (func_num_args()==1) {
              $this->requete = "delete from ".$strNomTable;
              return $this->OK = mysqli_query($this->cBD, $this->requete);
          }
          else {
              $this->requete = "delete from ".$strNomTable." where ".func_get_arg(1);
              return $this->OK = mysqli_query($this->cBD, $this->requete) or die(str_repeat("<br/><br/>", 10)."<strong>".$strNomTable.", ".$this->requete."<br/><br/>".$this->strErrSuppresion."</strong>".str_repeat("<br/><br/>", 10));
          }
      }
      /*
      |----------------------------------------------------------------------------------|
      | supprimeEnregistrements
      |----------------------------------------------------------------------------------|
      */
      function supprimeEnregistrements($strNomTable, $strListeConditions="") {
      }
      /*
      |----------------------------------------------------------------------------------|
      | supprimeTable()
      |----------------------------------------------------------------------------------|
      */
      function supprimeTable($strNomTable) {
          if (func_num_args()==1) {
              $this->requete = "DROP TABLE if exists ".$strNomTable;
              return $this->OK = mysqli_query($this->cBD, $this->requete);
          }
          else {
              mysqli_query($this->cBD, "set FOREIGN_KEY_CHECKS = 0; ");
              for ($i=0; $i<func_num_args(); $i++) {
                  mysqli_query($this->cBD, "drop table if exists ".func_get_arg($i)."; ");
              }
              mysqli_query($this->cBD, "set FOREIGN_KEY_CHECKS = 1; ") or die(str_repeat("<br/><br/>", 10)."<strong>".$strNomTable.", ".$this->requete."<br/><br/>".$this->strErrSuppresion."</strong>".str_repeat("<br/><br/>", 10));
          }
      }
      /*
      |----------------------------------------------------------------------------------|
      | afficheInformationsSurBD()
      | Affiche la structure et le contenu de chaque table de la base de données recherchée
      |----------------------------------------------------------------------------------|
      */
      function afficheInformationsSurBD()
      {
        /* Si applicable, récupération du nom de la table recherchée */
        $strNomTableRecherchee = "";
        if (func_num_args() == 3) {
           $strNomTableRecherchee = func_get_arg(2);
        }

        /* Variables de base pour les styles */
        $strTable = "border-collapse:collapse;";
        $strCommande = "font-family:verdana; font-size:12pt; font-weight:bold; color:black; border:solid 1px black; padding:3px;";
        $strMessage = "font-family:verdana; font-size:10pt; font-weight:bold; color:red;";
        $strBorduresMessage = "border:solid 1px red; padding:3px;";
        $strContenu = "font-family:verdana; font-size:10pt; color:blue;";
        $strBorduresContenu = "border:solid 1px red; padding:3px;";
        $strTypeADefinir = "color:red;font-weight:bold;";
        $strDetails = "color:magenta;";

        /* Application des styles */
        $sTable = "style=\"$strTable\"";
        $sCommande = "style=\"$strCommande\"";
        $sMessage = "style=\"$strMessage\"";
        $sMessageAvecBordures = "style=\"$strMessage $strBorduresMessage\"";
        $sContenu = "style=\"$strContenu\"";
        $sContenuAvecBordures = "style=\"$strContenu $strBorduresContenu\"";
        $sTypeADefinir = "style=\"$strTypeADefinir\"";
        $sDetails = "style=\"$strDetails\"";

        /* --- Entreposage des noms de table --- */
        $ListeTablesBD = array_column(mysqli_fetch_all(mysqli_query($this->cBD, 'SHOW TABLES')),0);
        $intNbTables = count($ListeTablesBD);

        /* --- Parcours de chacune des tables --- */
        echo "<span $sCommande>Informations sur " . (!empty($strNomTableRecherchee) ? "la table '$strNomTableRecherchee' de " : "") . "la base de données '"/*$strNomBDRecherche*/."$this->nomBD'</span><br />";
        $binTablePresente = false;
        for ($i=0; $i<$intNbTables; $i++)
        {
           /* Récupération du nom de la table courante */
           $strNomTable = $ListeTablesBD[$i];
           if (empty($strNomTableRecherchee) || strtolower($strNomTable) == strtolower($strNomTableRecherchee)) {
              $binTablePresente = true;
              echo "<p $sMessage>Table no ".strval($i+1)." : ".$strNomTable."</p>";

              /* Récupération des enregistrements de la table courante */
              $ListeEnregistrements = mysqli_query($this->cBD, "SELECT * FROM $strNomTable");

              /* Décompte du nombre de champs et d'enregistrements de la table courante */
              $NbChamps = mysqli_field_count($this->cBD);
              $NbEnregistrements = mysqli_num_rows($ListeEnregistrements);
              echo "<p $sContenu>$NbChamps champs ont été détectés dans la table.<br />";
              echo "    $NbEnregistrements enregistrements ont été détectés dans la table.</p>";

              /* Affichage de la structure de table courante */
              echo "<p $sContenu>";
              $j=0;
              $tabNomChamp = array();
              while ($champCourant = $ListeEnregistrements->fetch_field()) {
                 $intDivAjustement = 1;
                 $tabNomChamp[$j] = $champCourant->name;
                 $strType = $champCourant->type;
                 switch ($strType) {
                    case 1   : $strType = "BOOL"; break;
                    case 3   : $strType = "INTEGER"; break;
                    case 10  : $strType = "DATE"; break;
                    case 12  : $strType = "DATETIME"; break;
                    case 246 : $strType = "DECIMAL"; break;
                    case 253 : $strType = "VARCHAR"; break;
                    case 254 : $strType = "CHAR"; break;
                    default  : $strType = "<span $sTypeADefinir>$strType à définir</span>"; break;
                 }
                 $strLongueur = intval($champCourant->length) / $intDivAjustement;
                 $intDetails = $champCourant->flags;
                 $strDetails = "";
                 if ($intDetails & 1     ) $strDetails .= "[NOT_NULL] ";
                 if ($intDetails & 2     ) $strDetails .= "<span style=\"font-weight:bold;\">[PRI_KEY]</span> ";
                 if ($intDetails & 4     ) $strDetails .= "[UNIQUE_KEY] ";
                 if ($intDetails & 16    ) $strDetails .= "[BLOB] ";
                 if ($intDetails & 32    ) $strDetails .= "[UNSIGNED] ";
                 if ($intDetails & 64    ) $strDetails .= "[ZEROFILL] ";
                 if ($intDetails & 128   ) $strDetails .= "[BINARY] ";
                 if ($intDetails & 256   ) $strDetails .= "[ENUM] ";
                 if ($intDetails & 512   ) $strDetails .= "[AUTO_INCREMENT] ";
                 if ($intDetails & 1024  ) $strDetails .= "[TIMESTAMP] ";
                 if ($intDetails & 2048  ) $strDetails .= "[SET] ";
                 if ($intDetails & 32768 ) $strDetails .= "[NUM] ";
                 if ($intDetails & 16384 ) $strDetails .= "[PART_KEY] ";
                 if ($intDetails & 32768 ) $strDetails .= "[GROUP] "; 
                 if ($intDetails & 65536 ) $strDetails .= "[UNIQUE] ";
                 echo ($j+1).". $tabNomChamp[$j], $strType($strLongueur) <span $sDetails>$strDetails</span><br />";
                 $j++;
              }
              echo "</p>";

              /* Affichage des enregistrements composant la table courante */
              echo "<table $sTable>";
              echo "<tr>";
              for ($k=0; $k<$NbChamps; $k++)
                 echo "<td $sMessageAvecBordures>" . $tabNomChamp[$k] . "</td>";
              echo "</tr>";               
              if (empty($NbEnregistrements)) {
                 echo "<tr>";
                 echo "<td $sContenuAvecBordures colspan=\"$NbChamps\">";
                 echo " Aucun enregistrement";
                 echo "</td>";
                 echo "</tr>";
              }
              while ($listeChampsEnregistrement = $ListeEnregistrements->fetch_row()) {
                 echo "<tr>";
                 echo "<tr>";
                 for ($j=0; $j<count($listeChampsEnregistrement); $j++)
                    echo "      <td $sContenuAvecBordures>" . $listeChampsEnregistrement[$j] . "</td>";
                 echo "   </tr>";
              }
              echo "</table>";
              $ListeEnregistrements->free();
           }
        }
        if (!$binTablePresente)
           echo "<p $sMessage>Aucune table !</p>";
        }
   }
?>