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
      public $_cBD = null;                       /* Identifiant de connexion */
      public $_listeEnregistrements = null;      /* Liste des enregistrements retournés */
      public $_nomFichierInfosSensibles = "";    /* Nom du fichier 'InfosSensibles' */
      public $_nomBD = "";                       /* Nom de la base de données */
      public $_OK = false;                       /* Opération réussie ou non */
      public $_requete = "";                     /* Requête exécutée */
      public $_nbEnregistrements = 0;
      /*
      |----------------------------------------------------------------------------------|
      | __construct
      |----------------------------------------------------------------------------------|
      */
      function __construct($strNomBD, $strNomFichierInfosSensibles) {
          $this->_nomBD=$strNomBD;
          $this->_nomFichierInfosSensibles=$strNomFichierInfosSensibles;
          $this->connexion();
          $this->selectionneBD();
      }
      /*
      |----------------------------------------------------------------------------------|
      | connexion()
      |----------------------------------------------------------------------------------|
      */
      function connexion() {
          require_once($this->_nomFichierInfosSensibles);
          $this->_cBD = mysqli_connect("localhost", $strNomAdmin,$strMotPasseAdmin, $this->_nomBD);
          return $this->_cBD;
      }
       /*
      |----------------------------------------------------------------------------------|
      | tableExiste()
      |----------------------------------------------------------------------------------|
      */
      function tableExiste($strNomTable) {
        $result = mysqli_query($this->_cBD,"select 1 from $strNomTable LIMIT 1");
        if($result !== FALSE)
        {
           return true;
        }
        else
        {
           return false;
        }
      }
      
      /*
      |----------------------------------------------------------------------------------|
      | copieEnregistrements
      |----------------------------------------------------------------------------------|
      */
      function copieEnregistrements($strNomTableSource, $strListeChampsSource, $strNomTableCible, $strListeChampsCible, $strListeConditions="") {
         /* Réf.: www.lecoindunet.com/dupliquer-ou-copier-des-lignes-d-une-table-vers-une-autre-avec-mysql-175 */
          $this->_requete = "INSERT INTO $strNomTableCible (";
          if($strListeChampsCible=="")
            {
              $strListeChampsCible = $strListeChampsSource;
            }
          $this->_requete.=$strListeChampsCible.") SELECT ".$strListeChampsSource." FROM ".$strNomTableSource;
          if($strListeConditions!="")
          {
              $this->_requete.=" WHERE ".$strListeConditions;
          }
          $this->_OK = mysqli_query($this->_cBD,$this->_requete);
          return $this->_OK;
      }
      /*
      |----------------------------------------------------------------------------------|
      | creeTable
      |----------------------------------------------------------------------------------|
      */      
      function creeTable($strNomTable) {
          $this->_requete = "CREATE TABLE $strNomTable (";
          for($i=1;$i<func_num_args()-1;$i=$i+2)
          {
              if($i != func_num_args()-2)
                $this->_requete.=func_get_arg($i)." ".func_get_arg($i+1).",";
            else 
                $this->_requete.=func_get_arg($i)." ".func_get_arg($i+1);
          }
          $this->_requete.=" ".func_get_arg(func_num_args()-1);
          $this->_requete.=")ENGINE=InnoDB";
          $this->_OK = mysqli_query($this->_cBD,$this->_requete);
          return $this->_OK;
      }
      /*
      |----------------------------------------------------------------------------------|
      | creeTableGenerique()
      |----------------------------------------------------------------------------------|
      */
      function creeTableGenerique($strNomTable, $strDefinitions, $strCles) {
          $this->_requete = "CREATE TABLE $strNomTable ( ";
          $TbDefinition = explode(";", $strDefinitions);
          for($i=0;$i<count($TbDefinition);$i++)
          {
              $TbUneDefinition = explode(",",$TbDefinition[$i]);
              switch(substr($TbUneDefinition[0],0,1))
              {
                     case 'B':
                           $this->_requete.=$TbUneDefinition[1]." BOOL,";
                           break;
                     case 'C':
                            $this->_requete.=$TbUneDefinition[1]." DECIMAL(".str_replace(",",".",substr($TbUneDefinition[0],1))."),";
                            break;
                     case 'D':
                            $this->_requete.=$TbUneDefinition[1]." DATE,";
                            break;
                     case 'E':
                            $this->_requete.=$TbUneDefinition[1]." INT,";
                            break;
                     case 'F':
                             $this->_requete.=$TbUneDefinition[1]." CHAR(".substr($TbUneDefinition[0],1)."),";
                            break;
                     case 'M':
                             $this->_requete.=$TbUneDefinition[1]." DECIMAL(10,2),";
                            break;
                     case 'N':
                            $this->_requete.=$TbUneDefinition[1]." INT NOT NULL,";
                            break;
                     case 'V':
                            $this->_requete.=$TbUneDefinition[1]." VARCHAR(".substr($TbUneDefinition[0],1)."),";
                            break;
              }
          }
          if($strCles != "");
          {
            $this->_requete.="PRIMARY KEY($strCles)";
          }
          $this->_requete.=")ENGINE=InnoDB";
          $this->_OK = mysqli_query($this->_cBD,$this->_requete);
          return $this->_OK;
      }
      /*
      |----------------------------------------------------------------------------------|
      | deconnexion
      |----------------------------------------------------------------------------------|
      */
      function deconnexion() {
          mysqli_close($this->_cBD);
      }
      /*
      |----------------------------------------------------------------------------------|
      | insereEnregistrement
      |----------------------------------------------------------------------------------|
      */
      function insereEnregistrement($strNomTable) {
          $this->_requete="INSERT INTO $strNomTable VALUES(";
          for($i=1;$i<func_num_args();$i++)
          {
              if(func_get_arg($i)=="")
              {
                  $this->_requete.='\'\''.',';
              }
              else if(func_get_arg($i)=='true')
                {
                  $this->_requete.='1'.',';
                }
              else if(func_get_arg($i)=='false')
                {
                  $this->_requete.='0'.',';
                }
               else if(is_string(func_get_arg($i)))
               {
                $strStringAAjouter= str_replace("'", "\'", func_get_arg($i));
                $this->_requete.='\''.$strStringAAjouter.'\',';
               }
               else
               {
                $this->_requete.=func_get_arg($i).',';
               }
          }
          $this->_requete = substr($this->_requete, 0, -1);
          $this->_requete.=")";
          $this->_OK = mysqli_query($this->_cBD,$this->_requete);
          return $this->_OK;
          
      }
      /*
      |----------------------------------------------------------------------------------|
      | modifieChamp
      |----------------------------------------------------------------------------------|
      */
      function modifieChamp($strNomTable, $strNomChamp, $strNouvelleDefinition) {
          $this->_requete = "ALTER TABLE " .$strNomTable." CHANGE ".$strNomChamp." ".$strNouvelleDefinition;
          $this->_OK = mysqli_query($this->_cBD,$this->_requete);
          return $this->_OK;
      }
      /*
      |----------------------------------------------------------------------------------|
      | selectionneBD()
      |----------------------------------------------------------------------------------|
      */
      function selectionneBD() {
          $this->_OK = mysqli_select_db($this->_cBD,$this->_nomBD);                  
          return $this->_OK;
      }
      /*
      |----------------------------------------------------------------------------------|
      | supprimeEnregistrements
      |----------------------------------------------------------------------------------|
      */
      function supprimeEnregistrements($strNomTable, $strListeConditions="") {
          $this->_requete = "DELETE FROM $strNomTable ";
          if($strListeConditions!="")
          {
              $this->_requete.="WHERE ".$strListeConditions;
          }
          $this->_OK = mysqli_query($this->_cBD,$this->_requete);
          return $this->_OK;
      }
      /*
      |----------------------------------------------------------------------------------|
      | supprimeTable()
      |----------------------------------------------------------------------------------|
      */
      function supprimeTable($strNomTable) {
           $this->_requete = "DROP TABLE $strNomTable";
           RETURN $this->_OK = mysqli_query($this->_cBD,$this->_requete);
      }
      /*
      |----------------------------------------------------------------------------------|
      | selectionneEnregistrements()
      |----------------------------------------------------------------------------------|
      */
      function selectionneEnregistrements($strNomTable)
      {
          $this->_listeEnregistrements=null;
          $this->_requete = "SELECT * FROM $strNomTable";
          for($i=1;$i<func_num_args();$i++)
          {
              if(substr(func_get_arg($i),0,2)=="C=")
              {
                  $this->_requete.= " WHERE ".substr(func_get_arg($i),2);
              }
              else if(substr(func_get_arg($i),0,2)=="D=")
              {
                  $this->_requete.= " GROUP BY ".substr(func_get_arg($i),2);
              }
              else if (substr(func_get_arg($i),0,2)=="T=") 
              {
                  $this->_requete.= " ORDER BY ".substr(func_get_arg($i),2);
              }
          }
          $this->_listeEnregistrements = mysqli_query($this->_cBD,$this->_requete);
          if($this->_listeEnregistrements==null)
              return -1;
          else
              return $this->_nbEnregistrements=$this->_listeEnregistrements->num_rows;
      }
      /*
      |----------------------------------------------------------------------------------|
      | recupere le maximum d'une valeur d'une colonne()
      |----------------------------------------------------------------------------------|
      */
      function selectionneMax($strNomTable,$strColonne)
      {
              $this->_requete = "SELECT MAX($strColonne) FROM $strNomTable";
              $this->_listeEnregistrements=mysqli_query($this->_cBD,$this->_requete);              
              return $this->contenuChamp(0,0);       
      }
      /*
        |-------------------------------------------------------------------------------------|
        | contenuChamp
        | Réf.: http://php.net/manual/fr/class.mysqli-result.php User Contributed Notes (Marc17)
        |
        | Exemple d'appel : echo contenuChamp($ListeEnregistrements, 0, "TotalVentes");
        |                   Affiche le champ "TotalVentes" du 1er enregistrement de la liste
        |                   d'enregistrements.
        |-------------------------------------------------------------------------------------|
        */
        function contenuChamp($intNo,$strNomChamp) {
           if ($this->_listeEnregistrements === false) return false;
           if ($intNo >= mysqli_num_rows($this->_listeEnregistrements)) return false;
           if (is_string($strNomChamp) && !(strpos($strNomChamp, ".")===false))
           {
              $t_field = explode(".", $strNomChamp);
              $strNomChamp = -1;
              $t_fields = mysqli_fetch_fields($this->_listeEnregistrements);
              for ($id=0; $id < mysqli_num_fields($this->_listeEnregistrements); $id++) {
                 if ($t_fields[$id]->table == $t_field[0] && $t_fields[$id]->name == $t_field[1]) {
                    $strNomChamp=$id;
                    break;
                 }
              }
              if ($strNomChamp == -1) return false;
           }
           mysqli_data_seek($this->_listeEnregistrements,$intNo);
           $line = mysqli_fetch_array($this->_listeEnregistrements);
           return isset($line[$strNomChamp]) ? $line[$strNomChamp] : false;
        }
      /*
      |----------------------------------------------------------------------------------|
      | afficheInformationsSurBD()
      | Affiche la structure et le contenu de chaque table de la base de données recherchée
      |----------------------------------------------------------------------------------|
      */
      function afficheInformationsSurBD()
      {
       $cBD=  $this->_cBD;
       $strNomBDRecherche = $this->_nomBD;
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
      $ListeTablesBD = array_column(mysqli_fetch_all(mysqli_query($cBD, 'SHOW TABLES')),0);
      $intNbTables = count($ListeTablesBD);
      
      /* Version alternative en attendant que mon site personnel soit fonctionnel */
      //$intNbTables = get_tables($cBD, $ListeTablesBD);

      /* --- Parcours de chacune des tables --- */
      echo "<span $sCommande>Informations sur " . (!empty($strNomTableRecherchee) ? "la table '$strNomTableRecherchee' de " : "") . "la base de données '$strNomBDRecherche'</span><br />";
      $binTablePresente = false;
      for ($i=0; $i<$intNbTables; $i++)
      {
         /* Récupération du nom de la table courante */
         $strNomTable = $ListeTablesBD[$i];
         if (empty($strNomTableRecherchee) || strtolower($strNomTable) == strtolower($strNomTableRecherchee)) {
            $binTablePresente = true;
            echo "<p $sMessage>Table no ".strval($i+1)." : ".$strNomTable."</p>";
         
            /* Récupération des enregistrements de la table courante */
            $ListeEnregistrements = mysqli_query($cBD, "SELECT * FROM $strNomTable");

            /* Décompte du nombre de champs et d'enregistrements de la table courante */
            $NbChamps = mysqli_field_count($cBD);
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
                  case 253 : $strType = "VARCHAR"; 
                             /* Ajustement temporaire */
                             if ($_SERVER["SERVER_NAME"] == "lmbrousseau.ca") { $intDivAjustement = 3; }
                             break;
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
   function detecteServeur(&$strMonIP, &$strIPServeur, &$strNomServeur, &$strInfosSensibles) {
      $strMonIP = $_SERVER["REMOTE_ADDR"];
      $strIPServeur = $_SERVER["SERVER_ADDR"];
      $strNomServeur = $_SERVER["SERVER_NAME"];
      $strInfosSensibles = str_replace(".", "-", $strNomServeur) . ".php";
   }
   
?>