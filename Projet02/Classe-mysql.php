<?php
    require_once("Librairie-G Doyon.php");

   /*
   |----------------------------------------------------------------------------------------|
   | class mysql v.12-04-2017
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
      public $_nbEnregistrements = 0;            /* Nombre d'enregistrement dans un select*/ 
      /*
      |----------------------------------------------------------------------------------|
      | __construct
      |----------------------------------------------------------------------------------|
      */
      function __construct($strNomBD, $strNomFichierInfosSensibles) {
          $this->_nomBD = $strNomBD;
          $this->_nomFichierInfosSensibles = $strNomFichierInfosSensibles;
          
          $this->connexion();
          $this->selectionneBD();
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

        /* --- Entreposage des noms de table --- */
        $ListeTablesBD = array_column(mysqli_fetch_all(mysqli_query($this->_cBD, 'SHOW TABLES')), 0);
        $intNbTables = count($ListeTablesBD);
        
        /* --- Parcours de chacune des tables --- */
        echo "<span>Informations sur " . (!empty($strNomTableRecherchee) ?
                "la table '$strNomTableRecherchee' de " : "") . "la base de données '$this->_nomBD'</span><br />";
        $binTablePresente = false;
        for ($i = 0; $i < $intNbTables; $i++) {
            /* Récupération du nom de la table courante */
            $strNomTable = $ListeTablesBD[$i];
            if (empty($strNomTableRecherchee) || strtolower($strNomTable) == strtolower($strNomTableRecherchee)) {
                $binTablePresente = true;
                echo "<p>Table no " . strval($i + 1) . " : " . $strNomTable . "</p>";

                /* Récupération des enregistrements de la table courante */
                $ListeEnregistrements = mysqli_query($this->_cBD, "SELECT * FROM $strNomTable");
                /* Décompte du nombre de champs et d'enregistrements de la table courante */
                $NbChamps = mysqli_field_count($this->_cBD);
                $NbEnregistrements = mysqli_num_rows($ListeEnregistrements);
                echo "<p>$NbChamps champs ont été détectés dans la table.<br />";
                echo " $NbEnregistrements enregistrements ont été détectés dans la table.</p>";

                /* Affichage de la structure de table courante */
                echo "<p>";
                $j = 0;
                $tabNomChamp = array();
                while ($champCourant = $ListeEnregistrements->fetch_field()) {
                    $tabNomChamp[$j] = $champCourant->name;
                    $strType = $champCourant->type;
                    switch ($strType) {
                        case 1 : $strType = "BOOL";
                            break;
                        case 3 : $strType = "INTEGER";
                            break;
                        case 10 : $strType = "DATE";
                            break;
                        case 12 : $strType = "DATETIME";
                            break;
                        case 246 : $strType = "DECIMAL";
                            break;
                        case 253 : $strType = "VARCHAR";
                            break;
                        case 254 : $strType = "CHAR";
                            break;
                        default : $strType = "<span $sTypeADefinir>$strType à définir</span>";
                            break;
                    }
                    $strLongueur = $champCourant->length;
                    $intDetails = $champCourant->flags;
                    $strDetails = "";
                    if ($intDetails & 1) $strDetails .= "[NOT_NULL] ";
                    if ($intDetails & 2)
                        $strDetails .= "<span style=\"font-weight:bold;\">[PRI_KEY]</span> ";
                    if ($intDetails & 4)
                        $strDetails .= "[UNIQUE_KEY] ";
                    if ($intDetails & 16)
                        $strDetails .= "[BLOB] ";
                    if ($intDetails & 32)
                        $strDetails .= "[UNSIGNED] ";
                    if ($intDetails & 64 ) $strDetails .= "[ZEROFILL] ";
                    if ($intDetails & 128)
                        $strDetails .= "[BINARY] ";
                    if ($intDetails & 256)
                        $strDetails .= "[ENUM] ";
                    if ($intDetails & 512)
                        $strDetails .= "[AUTO_INCREMENT] ";
                    if ($intDetails & 1024)
                        $strDetails .= "[TIMESTAMP] ";
                    if ($intDetails & 2048)
                        $strDetails .= "[SET] ";
                    if ($intDetails & 32768)
                        $strDetails .= "[NUM] ";
                    if ($intDetails & 16384)
                        $strDetails .= "[PART_KEY] ";
                    if ($intDetails & 32768)
                        $strDetails .= "[GROUP] ";
                    if ($intDetails & 65536)
                        $strDetails .= "[UNIQUE] ";
                    echo ($j + 1) . ". $tabNomChamp[$j], $strType($strLongueur) <span>$strDetails</span><br />";
                    $j++;
                }
                echo "</p>";
                /* Affichage des enregistrements composant la table courante */
                echo "<table>";
                echo "<tr>";
                for ($k = 0; $k < $NbChamps; $k++)
                    echo "<td>" . $tabNomChamp[$k] . "</td>";
                echo "</tr>";
                if (empty($NbEnregistrements)) {
                    echo "<tr>";
                    echo "<td colspan=\"$NbChamps\">";
                    echo " Aucun enregistrement";
                    echo "</td>";
                    echo "</tr>";
                }
                while ($listeChampsEnregistrement = $ListeEnregistrements->fetch_row()) {
                    echo "<tr>";
                    echo "<tr>";
                    for ($j = 0; $j < count($listeChampsEnregistrement); $j++)
                        echo " <td>" . $listeChampsEnregistrement[$j] . "</td>";
                    echo " </tr>";
                }
                echo "</table>";
                $ListeEnregistrements->free();
            }
        }
        if (!$binTablePresente)
            echo "<p>Aucune table !</p>";
       } 
       
      /*
      |----------------------------------------------------------------------------------|
      | connexion()
      |----------------------------------------------------------------------------------|
      */
      function connexion() {
          require($this->_nomFichierInfosSensibles);
          
          $this->_cBD = mysqli_connect("localhost",$strNomAdmin, $strMotPasseAdmin, $this->_nomBD);
          
          if(mysqli_connect_errno()){
              echo "<br />" . "Problème de connection... " . "Erreur no: " 
                      . mysqli_connect_errno() . " (" . mysqli_connect_error() . ")";
          }
        
          return $this->_cBD;
      }
      
      /*
       * contenuChamp
       * $intNo = Numéro enregistrement
       * $strNomChamp = Nom du champs dans la table
       */
      function contenuChamp($intNo,$strNomChamp){   
          return $this->mysqli_result($this->_listeEnregistrements, $intNo, $strNomChamp);
      }
      
      /*
      |----------------------------------------------------------------------------------|
      | copieEnregistrements
      |----------------------------------------------------------------------------------|
      */
      function copieEnregistrements($strNomTableSource, $strListeChampsSource, $strNomTableCible, $strListeChampsCible, $strListeConditions="") {
         /* Réf.: www.lecoindunet.com/dupliquer-ou-copier-des-lignes-d-une-table-vers-une-autre-avec-mysql-175 */
          if(empty($strListeChampsCible)){
              $strListeChampsCible = $strListeChampsSource;
          }
          
          $strRequete = "INSERT INTO " . $strNomTableCible . " (" . $strListeChampsSource . ") SELECT "
                  . $strListeChampsCible . " FROM " . $strNomTableSource;
          
          if(!empty($strListeConditions)){
              $strRequete .= " WHERE " . $strListeConditions;
              
          }
          
          $this->_requete  =$strRequete;
          $this->_OK= mysqli_query($this->_cBD, $this->_requete);
          
          return $this->_OK;
      }
      /*
      |----------------------------------------------------------------------------------|
      | creeTable
      |----------------------------------------------------------------------------------|
      */
      function creeTable($strNomTable) {
        $strCommande = "";
        $NbParametre=func_num_args();  
        
        $strCommande = "CREATE TABLE " . $strNomTable . " (";
        for ($i = 1; $i <= $NbParametre - 1; $i++) {
            $strParametre = func_get_arg($i);
            if ($i % 2 == 0) {
                $strCommande .= " " . $strParametre;
            } else if (($i % 2 != 0) && ($i == 1)) {
                $strCommande .= " " . $strParametre;
            } else {
                $strCommande .= "," . $strParametre;
            }
        }
        $strCommande .= ") ENGINE=InnoDB";

         /* 
          $strCommande = "";

        if (func_num_args() > 2) {
            $strCommande = "CREATE TABLE " . $strNomTable . " (";
            $strtruc = func_get_args();
            for ($intIndex = 1; $intIndex < $strtruc; $intIndex++) {
                if (strstr(func_get_arg($intIndex), "PRIMARY KEY")) {
                    $strCommande .= func_get_arg($intIndex);
                } else {
                    $strCommande .= func_get_arg($intIndex) . func_get_arg($intIndex + 1);
                    $intIndex++;
                }
                echo $intIndex;
            }
            $strCommande .= ") ENGINE=InnoDB";
        }*/
          
          $this->_requete = $strCommande;
          
          $this->_OK = mysqli_query($this->_cBD, $this->_requete);
          
          return $this->_OK;
      }
      /*
      |----------------------------------------------------------------------------------|
      | creeTableGenerique()
      |----------------------------------------------------------------------------------|
      */
      function creeTableGenerique($strNomTable, $strDefinitions, $strCles) {
          $strCommande = "";
          $tValeurs = explode(";",$strDefinitions);
          
          $strCommande = "CREATE TABLE " . $strNomTable . " ( ";
          
          //Lecture $strDefinitions (Nom/Type)
          for($intIndex = 0;$intIndex<count($tValeurs);$intIndex++){
              $tColonne = explode(",",$tValeurs[$intIndex]);             
              $strAjout = $tColonne[1] . " ";
              
              switch (substr($tColonne[0], 0, 1)){
                  case 'B':
                      $strAjout .= "BOOL";
                      break;
                  case 'C':
                      $strComplement = str_replace('.', ',', substr($tColonne[0], 1, strlen($tColonne[0]) - 1));
                      $strAjout .= "DECIMAL(" . $strComplement . ")";
                      break;
                  case 'D':
                      $strAjout .= "DATE";
                      break;
                  case 'E':
                      $strAjout .= "INT";
                      break;
                  case 'F':
                      $strAjout .= "CHAR(" . substr($tColonne[0], 1, strlen($tColonne[0]) - 1) . ")";
                      break;
                  case 'M';
                      $strAjout .= "DECIMAL(10,2)";
                      break;
                  case 'N':
                      $strAjout .= "INT NOT NULL";
                      break;
                  case 'V':
                      $strAjout .=  "VARCHAR(" . substr($tColonne[0], 1, strlen($tColonne[0]) - 1) . ")";
                      break;
              }
              
              if(($intIndex + 1) < count($tValeurs)){
                  $strAjout .= ",";
              }
              
              $strCommande .= $strAjout;
            }
          
        //Lecture Clé Primaire
        if(!empty($strCles)){
            $strCommande .= ",PRIMARY KEY(" . $strCles . "))";
        }
        else{
            $strCommande .= ")";
        }
        
        $strCommande .= " ENGINE=InnoDB";
        
        $this->_requete = $strCommande;
        
        $this->_OK = mysqli_query($this->_cBD, $this->_requete);
         
        return $this->_OK;
      }
      /*
      |----------------------------------------------------------------------------------|
      | deconnexion
      |----------------------------------------------------------------------------------|
      */
      function deconnexion() {
          $this->_OK = mysqli_close($this->_cBD);
      }
      /*
      |----------------------------------------------------------------------------------|
      | insereEnregistrement
      |----------------------------------------------------------------------------------|
      */
      function insereEnregistrement($strNomTable) {
        $strCommande = "INSERT INTO " . $strNomTable . " VALUES (";

        $NbParametre = func_num_args();
        
        for ($i = 1; $i <= $NbParametre - 1; $i++) {
            $strParametre = func_get_arg($i);
            
            //$argValue = $this->_cBD->real_escape_string($argValue)
            //Si Apostrophe
            
            if(mb_substr_count($strParametre,"'") > 0){
                $intNbApostrophe = mb_substr_count($strParametre,"'");
                
                for($intIndex = 0;$intIndex < $intNbApostrophe;$intIndex++){
                    $pos = strpos($strParametre, "'");
                    
                    $strParametre = substr($strParametre, 0, $pos) . "\\" . substr($strParametre, $pos);
                }
            }
            
            if(!estNumerique($strParametre) and ! is_bool($strParametre)){
                $strCommande .= encadre($strParametre, "'");
            }
            else{
                $strCommande .= $strParametre;
            }
            
            if($i < $NbParametre - 1){
                $strCommande .= ",";
            }
        }
        
        $strCommande .= ")";
        
        $this->_requete = $strCommande;
        $this->_OK = mysqli_query($this->_cBD, $this->_requete);
        
        return $this->_OK;
    }

    /*
      |----------------------------------------------------------------------------------|
      | modifieChamp
      |----------------------------------------------------------------------------------|
      */
      function modifieChamp($strNomTable, $strNomChamp, $strNouvelleDefinition) {
          $strRequete = "ALTER TABLE " . $strNomTable . " CHANGE " . $strNomChamp . 
                  " " . $strNouvelleDefinition;
          
           $this->_requete = $strRequete;
           $this->_OK = mysqli_query($this->_cBD, $this->_requete);
        
           return $this->_OK;
      }
      /*
      |----------------------------------------------------------------------------------|
      | selectionneBD()
      |----------------------------------------------------------------------------------|
      */
      function selectionneBD() {
          $this->_OK = mysqli_select_db($this->_cBD, $this->_nomBD);
          
          return $this->_OK;
      }
      
      /*
       * selectionneEnregistrements()
       * selectionne enregistrement de la table $strNomTable
       */
      function selectionneEnregistrements($strNomTable){
          $this->_nbEnregistrements = 0;
          
          $strRequete = "SELECT * FROM " . $strNomTable;
          
          if(func_num_args() > 0){
              $intNbParametre = func_num_args();
              
              for($intIndex = 1;$intIndex<$intNbParametre;$intIndex++){
                  switch (substr(func_get_arg($intIndex), 0, 1)) {
                      case 'C':
                          $strRequete .= " WHERE " ;      
                          break;
                      case 'D':
                          $strRequete .= " GROUP BY ";
                          break;
                      case 'T':
                          $strRequete .= " ORDER BY ";
                          break;
                  }
                  
                  $strRequete .= substr(func_get_arg($intIndex), 2);
              }
          }
          $this->_requete = $strRequete;
          
          $this->_listeEnregistrements = mysqli_query($this->_cBD, $this->_requete);
          $this->_nbEnregistrements = $this->_listeEnregistrements === FALSE ? 0: mysqli_num_rows($this->_listeEnregistrements);
          //$this->_nbEnregistrements = mysqli_num_rows($this->_listeEnregistrements);
          
          return !is_null($this->_listeEnregistrements)?$this->_nbEnregistrements:-1;
      }
      
      /*
        |-------------------------------------------------------------------------------------|
        | mysqli_resulte
        | Réf.: http://php.net/manual/fr/class.mysqli-result.php User Contributed Notes (Marc17)
        |
        | Exemple d'appel : echo mysqli_result($ListeEnregistrements, 0, "TotalVentes");
        |                   Affiche le champ "TotalVentes" du 1er enregistrement de la liste
        |                   d'enregistrements.
        |-------------------------------------------------------------------------------------|
        */
        function mysqli_result($result, $row, $field=0) {
           if ($result === false) return false;
           if ($row >= mysqli_num_rows($result)) return false;
           if (is_string($field) && !(strpos($field, ".")===false)) {
              $t_field = explode(".", $field);
              $field = -1;
              $t_fields = mysqli_fetch_fields($result);
              for ($id=0; $id < mysqli_num_fields($result); $id++) {
                 if ($t_fields[$id]->table == $t_field[0] && $t_fields[$id]->name == $t_field[1]) {
                    $field=$id;
                    break;
                 }
              }
              if ($field == -1) return false;
           }
           mysqli_data_seek($result,$row);
           $line = mysqli_fetch_array($result);
           return isset($line[$field]) ? $line[$field] : false;
        }
      
      /*
      |----------------------------------------------------------------------------------|
      | supprimeEnregistrements
      |----------------------------------------------------------------------------------|
      */
      function supprimeEnregistrements($strNomTable, $strListeConditions="") {
          $strRequete = "DELETE FROM " . $strNomTable;
          
          if(!empty($strListeConditions)){
              $strRequete .= " WHERE " . $strListeConditions;
          }
          
          $this->_requete = $strRequete;
        
          $this->_OK = mysqli_query($this->_cBD, $this->_requete);
        
          return $this->_OK;
          
          
      }
      /*
      |----------------------------------------------------------------------------------|
      | supprimeTable()
      |----------------------------------------------------------------------------------|
      */
      function supprimeTable($strNomTable) {
          $this->_requete = "DROP TABLE $strNomTable";
          $this->_OK = mysqli_query($this->_cBD, $this->_requete);
          
          return $this->_OK;
      }
      
      /*
       * tableExiste()
       * vérifie si $strNomtable existe
       */
      function tableExiste($strNomTable){
          //$tabTableBD = tableau_ExtraitColonne(mysqli_fetch_all(mysqli_query($this->_cBD, 'SHOW TABLES')),0);
          
          $tabTableBD = array_column(mysqli_fetch_all(mysqli_query($this->_cBD, 'SHOW TABLES')),0);
          
          return in_array($strNomTable, $tabTableBD);
      } 

    }
?>