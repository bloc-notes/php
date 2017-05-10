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
      public $_nbEnregistrements = -1;
      
      /*
      |----------------------------------------------------------------------------------|
      | __construct
      |----------------------------------------------------------------------------------|
      */
      function afficheInformationsSurBD()
      {
      $strNomTableRecherchee = "";
        
      if (func_num_args() == 1) 
      {
         $strNomTableRecherchee = func_get_arg(0);
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
      $ListeTablesBD = array_column(mysqli_fetch_all(mysqli_query($this->_cBD, 'SHOW TABLES')),0);
      $intNbTables = count($ListeTablesBD);
      
      /* Version alternative en attendant que mon site personnel soit fonctionnel */
      //$intNbTables = get_tables($cBD, $ListeTablesBD);

      /* --- Parcours de chacune des tables --- */
      echo "<span $sCommande>Informations sur " . (!empty($strNomTableRecherchee) ? "la table '$strNomTableRecherchee' de " : "") . "la base de données '$this->_nomBD'</span><br />";
      $binTablePresente = false;
      for ($i=0; $i<$intNbTables; $i++)
      {
         /* Récupération du nom de la table courante */
         $strNomTable = $ListeTablesBD[$i];
         if (empty($strNomTableRecherchee) || strtolower($strNomTable) == strtolower($strNomTableRecherchee)) {
            $binTablePresente = true;
            echo "<p $sMessage>Table no ".strval($i+1)." : ".$strNomTable."</p>";
         
            /* Récupération des enregistrements de la table courante */
            $ListeEnregistrements = mysqli_query($this->_cBD, "SELECT * FROM $strNomTable");

            /* Décompte du nombre de champs et d'enregistrements de la table courante */
            $NbChamps = mysqli_field_count($this->_cBD);
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
         
      function __construct($strNomBD, $strNomFichierInfosSensibles) {
          
          $this->_nomBD = $strNomBD;
          $this->_nomFichierInfosSensibles = $strNomFichierInfosSensibles;
          $this->connexion();
          $this->selectionneBD();
      }
      /*
      |----------------------------------------------------------------------------------|
      | connexion()
      |----------------------------------------------------------------------------------|
      */
      function connexion() 
      {
          require_once($this->_nomFichierInfosSensibles);
          $this->_cBD = mysqli_connect("localhost",$strNomAdmin ,$strMotPasseAdmin )
           or die("Problème de connexion ...".  mysql_error());
      }
      /*
      |----------------------------------------------------------------------------------|
      | copieEnregistrements
      |----------------------------------------------------------------------------------|
      */
      function copieEnregistrements($strNomTableSource, $strListeChampsSource, $strNomTableCible, $strListeChampsCible, $strListeConditions="") 
      {
            if($strListeChampsCible == "")
            {
                $strListeChampsCible = $strListeChampsSource;
            }

            $this->_requete  = "INSERT INTO $strNomTableCible(";
            $this->_requete .= "$strListeChampsCible)";
            $this->_requete .= "SELECT $strListeChampsSource FROM ";
            $this->_requete .= "$strNomTableSource";

            if($strListeConditions != "")
            {
                $this->_requete .= " WHERE $strListeConditions";
            }
            
            return $this->_OK = mysqli_query($this->_cBD, $this->_requete);
      }
      /*
      |----------------------------------------------------------------------------------|
      | creeTable
      |----------------------------------------------------------------------------------|
      */
      function creeTable($strNomTable) {
          
        $this->_requete  = "CREATE TABLE $strNomTable (";
        
        for($i =1; $i<func_num_args()-1; $i+=2)
        {
            $this->_requete .= func_get_arg($i) . " ";
            $this->_requete .= func_get_arg($i+1) . ", ";
        }
        
        $this->_requete .= func_get_arg(func_num_args()-1).") ENGINE=InnoDB";
        
        return $this->_OK = mysqli_query($this->_cBD, $this->_requete);
      }
      /*
      |----------------------------------------------------------------------------------|
      | creeTableGenerique()
      |----------------------------------------------------------------------------------|
      */
      function creeTableGenerique($strNomTable, $strDefinitions, $strCles) 
      {
        $this->_requete  = "CREATE TABLE $strNomTable (";
        
        $strExplode = explode(";",$strDefinitions);
            
        for($i = 0; $i<count($strExplode);$i++)
        {
            $strExplode2 = explode(",",$strExplode[$i]);
            
            switch(substr($strExplode2[0],0,1))
            {
                case "B":
                    $this->_requete .= $strExplode2[1] . " BOOL, ";
                    break;
                
                case "C": 
                   $strReplace = str_replace(".", ",", $strExplode2[0]);
                   $this->_requete .= $strExplode2[1] . " DECIMAL(".substr($strReplace,1)."), ";
                    break;
                
                case "D":
                    $this->_requete .= $strExplode2[1] . " DATETIME, ";
                    break;
                
                case "E": 
                    $this->_requete .= $strExplode2[1] . " INT, ";
                    break;
                
                case "F": 
                   $this->_requete .= $strExplode2[1] . " CHAR(".substr($strExplode2[0],1)."), ";
                    break;
                
                case "M": 
                   $this->_requete .= $strExplode2[1] . " DECIMAL(".substr($strExplode2[0],1,strlen($strExplode2[0]-1))."10,2), ";
                    break;
                
                case "N": 
                    $this->_requete .= $strExplode2[1] . " INT NOT NULL, ";
                    break;
                
                case "V": 
                 $this->_requete .= $strExplode2[1] . " VARCHAR(".substr($strExplode2[0],1,strlen($strExplode2[0]-1))."), ";
                    break;
            }
        }
        
        $this->_requete .= "PRIMARY KEY(" .$strCles.")) ENGINE=InnoDB";
        /*
        echo $this->_requete."<br/>";
        echo "<br/>";
        */
        return $this->_OK = mysqli_query($this->_cBD, $this->_requete);
      }
      /*
      |----------------------------------------------------------------------------------|
      | deconnexion
      |----------------------------------------------------------------------------------|
      */
      function deconnexion() 
      {
           $this->_OK = mysqli_close($this->_cBD);
      }
      /*
      |----------------------------------------------------------------------------------|
      | insereEnregistrement
      |----------------------------------------------------------------------------------|
      */
      function insereEnregistrement($strNomTable) 
      {
            $this->_requete  = "INSERT INTO $strNomTable VALUES (";

            for($i =1; $i<func_num_args(); $i++)
            {
                $strValeur = func_get_arg($i);
                
                if($strValeur == 'true')
                {
                    $this->_requete .= "1";
                }
                
                else if($strValeur == 'false')
                {
                    $this->_requete .= "0";
                }
                
                else if(gettype($strValeur) == "string")
                {
                    $this->_requete .= "'" . str_replace("'", "\'", $strValeur) . "'";
                }
                
                else if(is_null($strValeur))
                { 
                    $this->_requete .= "NULL";
                }
                
                else
                {
                    $this->_requete .= $strValeur;
                }
                
                if($i != func_num_args()-1)
                {
                   $this->_requete .= ","; 
                }
            }
            
              $this->_requete .= ")";
              
            return $this->_OK = mysqli_query($this->_cBD, $this->_requete);
      }
      /*
      |----------------------------------------------------------------------------------|
      | modifieChamp
      |----------------------------------------------------------------------------------|
      */
      function modifieChamp($strNomTable, $strNomChamp, $strNouvelleDefinition) 
      {
           $this->_requete  = "ALTER TABLE $strNomTable CHANGE " ."$strNomChamp $strNouvelleDefinition";
           
           return $this->_OK = mysqli_query($this->_cBD, $this->_requete);
      }
      
      /*
      |----------------------------------------------------------------------------------|
      | selectionneBD()
      |----------------------------------------------------------------------------------|
      */
      function selectionneBD() 
      {
          return $this->_OK = mysqli_select_db($this->_cBD, $this->_nomBD); 
      }
      /*
      |----------------------------------------------------------------------------------|
      | supprimeEnregistrements
      |----------------------------------------------------------------------------------|
      */
      
      function selectionneMax($strChamp,$strTable)
      {
          $this->_requete = "Select MAX(". $strChamp. ") as " .$strChamp. " FROM " . $strTable;
          
          $this->_listeEnregistrements = mysqli_query($this->_cBD, $this->_requete);
        
          return $this->contenuChamp(0, 0);
      }
      
      function supprimeEnregistrements($strNomTable, $strListeConditions="")        
      {
          
          $this->_requete  = "DELETE FROM $strNomTable ";
          
          if($strListeConditions !="") 
          {
                $this->_requete .= " WHERE $strListeConditions";
          }
          
         // echo $this->_requete;
          
          return $this->_OK = mysqli_query($this->_cBD, $this->_requete);
      }
      /*
      |----------------------------------------------------------------------------------|
      | supprimeTable()
      |----------------------------------------------------------------------------------|
      */
      function supprimeTable($strNomTable) 
      {
          $this->_requete = "DROP TABLE $strNomTable";
          
          return $this->_OK = mysqli_query($this->_cBD, $this->_requete);
      }
      /*
      |----------------------------------------------------------------------------------|
      | afficheInformationsSurBD()
      | Affiche la structure et le contenu de chaque table de la base de données recherchée
      |----------------------------------------------------------------------------------|
      */
      
      function tableExiste($strTable)
      {
          return $boolExiste = $strTable[0] == null? true:false;
      }
      
      
       function selectionneCount($strNomTable1,$strNomTable2)
      {
          $this->_requete = "SELECT count(*) FROM $strNomTable1 a INNER JOIN $strNomTable2 b on a.NoUtilisateur=b.NoUtilisateur";
          
          for($i =2; $i<func_num_args(); $i++)
          {
              if(substr(func_get_arg($i),0,1) == "C")
              {
                  $this->_requete .= " WHERE " . substr(func_get_arg($i),2);
              }
              
              else if(substr(func_get_arg($i),0,1) == "D")
              {
                  $this->_requete .= " GROUP BY ". substr(func_get_arg($i),2);
              }
              
              else
              {
                  $this->_requete .= " ORDER BY ". substr(func_get_arg($i),2);
              }
          }
          
          $this->_requete .= " GROUP BY NOM";
                  
          $this->_listeEnregistrements = mysqli_query($this->_cBD, $this->_requete);
          
          if($this->_listeEnregistrements != null)
          {
              $this->_nbEnregistrements = mysqli_num_rows($this->_listeEnregistrements);
          }
          
          //echo $this->_requete."<br/><br/>";
          
          return $this-> _nbEnregistrements;
      }
      
      function selectionneEnregistrements($strNomTable)
      {
          $this->_requete = "SELECT * FROM $strNomTable";
          
          for($i =1; $i<func_num_args(); $i++)
          {
              if(substr(func_get_arg($i),0,1) == "C")
              {
                  $this->_requete .= " WHERE " . substr(func_get_arg($i),2);
              }
              
              else if(substr(func_get_arg($i),0,1) == "D")
              {
                  $this->_requete .= " GROUP BY ". substr(func_get_arg($i),2);
              }
              
              else
              {
                  $this->_requete .= " ORDER BY ". substr(func_get_arg($i),2);
              }
          }
          
          $this->_listeEnregistrements = mysqli_query($this->_cBD, $this->_requete);
          
          if($this->_listeEnregistrements != null)
          {
              $this->_nbEnregistrements = mysqli_num_rows($this->_listeEnregistrements);
          }
          
        // echo $this->_requete."<br/><br/>";
          
          return $this-> _nbEnregistrements;
      }
      
       function selectionneStatut($strNomTable)
      {
          $this->_requete = "SELECT statut FROM $strNomTable";
          
          for($i =1; $i<func_num_args(); $i++)
          {
              if(substr(func_get_arg($i),0,1) == "C")
              {
                  $this->_requete .= " WHERE " . substr(func_get_arg($i),2);
              }
              
              else if(substr(func_get_arg($i),0,1) == "D")
              {
                  $this->_requete .= " GROUP BY ". substr(func_get_arg($i),2);
              }
              
              else
              {
                  $this->_requete .= " ORDER BY ". substr(func_get_arg($i),2);
              }
          }
          
          $this->_listeEnregistrements = mysqli_query($this->_cBD, $this->_requete);
          
          if($this->_listeEnregistrements != null)
          {
              $this->_nbEnregistrements = mysqli_num_rows($this->_listeEnregistrements);
          }
          
       //  echo $this->_requete."<br/><br/>";
          
          return $this-> _nbEnregistrements;
      }
      
       function selectionneConnexion($strNomTable)
      {
          $this->_requete = "SELECT connexion FROM $strNomTable a inner join utilisateurs b on a.noutilisateur=b.noutilisateur";
          
          for($i =1; $i<func_num_args(); $i++)
          {
              if(substr(func_get_arg($i),0,1) == "C")
              { 
                   $this->_requete .= " WHERE " . substr(func_get_arg($i),2);
              }
              
              else if(substr(func_get_arg($i),0,1) == "D")
              {
                  $this->_requete .= " GROUP BY ". substr(func_get_arg($i),2);
              }
              
              else
              {
                  $this->_requete .= " ORDER BY ". substr(func_get_arg($i),2);
              }
          }
          
          $this->_requete .=" LIMIT 5";
          
          $this->_listeEnregistrements = mysqli_query($this->_cBD, $this->_requete);
          
          if($this->_listeEnregistrements != null)
          {
              $this->_nbEnregistrements = mysqli_num_rows($this->_listeEnregistrements);
          }
          
          return $this-> _nbEnregistrements;
      }
      
     function contenuChamp($intNo, $strNomChamp)
     {
         $intValeurChamp = $this->mysqli_result($this->_listeEnregistrements, $intNo, $strNomChamp);
         return $intValeurChamp;
     }
     
     function creeTableConnexion($oBD, $strNomTableUtilisateur)
    {
        $strDefinitions = "N,NoConnexion;".
                          "N,NoUtilisateur;".
                          "D,Connexion;".
                          "D,Deconnexion;";
                
        $strCles = "NoConnexion";
        $oBD->creeTableGenerique($strNomTableUtilisateur, $strDefinitions, $strCles);
    }
    
    function creeTableAnnonce($oBD, $strNomTableUtilisateur)
    {
        $strDefinitions = "N,NoAnnonce;".
                          "N,NoUtilisateur;".
                          "D,Parution;".
                          "N,Categorie;".
                          "V50,DescriptionAbregee;".
                          "V25,DescriptionComplete;".
                          "M,Prix;".
                          "V50,Photo;".
                          "D,MiseAJour;".
                          "N,Etat";
                
        $strCles = "NoAnnonce";
        $oBD->creeTableGenerique($strNomTableUtilisateur, $strDefinitions, $strCles);
    }
    
    function creeTableCategorie($oBD, $strNomTableUtilisateur)
    {
        $strDefinitions = "N,NoCategorie;".
                          "V20,Description;";
                
        $strCles = "NoCategorie";
        $oBD->creeTableGenerique($strNomTableUtilisateur, $strDefinitions, $strCles);
    }
    
    function creeTableUtilisateur($oBD, $strNomTableUtilisateur)
    {
        $strDefinitions = "N AUTO_INCREMENT,NoUtilisateur;".
                          "V50 NOT NULL,Courriel;".
                          "V50 NOT NULL,MotDePasse;".
                          "D NOT NULL,Creation;".
                          "N,NbConnexions;".
                          "N,Statut;".
                          "N,NoEmpl;".
                          "V25,Nom;".
                          "V20,Prenom;".
                          "V16,NoTelMaison;".
                          "V22,NoTelTravail;".
                          "V16,NoTelCellulaire;".
                          "D,Modification;".
                          "V50, AutresInfos;";
                
        $strCles = "NoUtilisateur";
        
        
        $oBD->creeTableGenerique($strNomTableUtilisateur, $strDefinitions, $strCles);
    }
    
      function remplitTableUtilisateur($oBD, $strNomTableTypesLivraison,$strFichierTypesLivraison)
    {   
        $fp = new fichier($strFichierTypesLivraison);
        $fp->ouvre();
        $tv=array();
        
        while(!$fp->detecteFin())
        {
            $fp->litDonneesLigne($tv, ",",
                          "NoUtilisateur",
                          "Courriel",
                          "MotDePasse",
                          "Creation",
                          "NbConnexions",
                          "Statut",
                          "NoEmpl",
                          "Nom",
                          "Prenom",
                          "NoTelMaison",
                          "NoTelTravail",
                          "NoTelCell",
                          "Modification",
                          "AutresInfos");
            
            $oBD-> insereEnregistrement($strNomTableTypesLivraison,
                                        $tv["NoUtilisateur"],
                                        $tv["Courriel"],
                                        $tv["MotDePasse"],
                                        $tv["Creation"],
                                        $tv["NbConnexions"],   
                                        $tv["Statut"],
                                        $tv["NoEmpl"],
                                        $tv["Nom"],
                                        $tv["Prenom"],
                                        $tv["NoTelMaison"],
                                        $tv["NoTelTravail"],
                                        $tv["NoTelCell"],
                                        $tv["Modification"],
                                        $tv["AutresInfos"]);
            
          //  ECHO $this->_requete."<br/>"."<br/>";
        }
        $fp->ferme();
    }
    
      function remplitTableConnexions($oBD, $strNomTableTypesLivraison,$strFichierTypesLivraison)
    {   
        $fp = new fichier($strFichierTypesLivraison);
        $fp->ouvre();
        $tv=array();
        
        while(!$fp->detecteFin())
        {
            $fp->litDonneesLigne($tv, ",",
                          "NoConnexion",
                          "NoUtilisateur",
                          "Connexion",
                          "Deconnexion");
            
            $oBD-> insereEnregistrement($strNomTableTypesLivraison,
                                        $tv["NoConnexion"],
                                        $tv["NoUtilisateur"],
                                        $tv["Connexion"],
                                        $tv["Deconnexion"]);
        }
        
        // ECHO $this->_requete."<br/>"."<br/>";
         
        $fp->ferme();
    }
    
      function remplitTableAnnonces($oBD, $strNomTableTypesLivraison,$strFichierTypesLivraison)
    {   
        $fp = new fichier($strFichierTypesLivraison);
        $fp->ouvre();
        $tv=array();
        
        while(!$fp->detecteFin())
        {
            $fp->litDonneesLigne($tv, ",",
                          "NoAnnonce",
                          "NoUtilisateur",
                          "Parution",
                          "Categorie",
                          "DescriptionAbregee",
                          "DescriptionComplete",
                          "Prix",
                          "Photo",
                          "MiseAJour",
                          "Etat");
            
            $oBD-> insereEnregistrement($strNomTableTypesLivraison,
                                        $tv["NoAnnonce"],
                                        $tv["NoUtilisateur"],
                                        $tv["Parution"],
                                        $tv["Categorie"],
                                        $tv["DescriptionAbregee"],   
                                        $tv["DescriptionComplete"],
                                        $tv["Prix"],
                                        $tv["Photo"],
                                        $tv["MiseAJour"],
                                        $tv["Etat"]);
            // ECHO $this->_requete."<br/>"."<br/>";
             
        }
        $fp->ferme();
    }
    
    function remplitTableCategories($oBD, $strNomTableTypesLivraison,$strFichierTypesLivraison)
    {   
        $fp = new fichier($strFichierTypesLivraison);
        $fp->ouvre();
        $tv=array();
        
        while(!$fp->detecteFin())
        {
            $fp->litDonneesLigne($tv, ",",
                          "NoCategorie",
                          "Description");
            
            $oBD-> insereEnregistrement($strNomTableTypesLivraison,
                                        $tv["NoCategorie"],
                                        $tv["Description"]);
            // ECHO $this->_requete."<br/>"."<br/>";
             
        }
        $fp->ferme();
    }
    
      function modifieChampAjouterForeignKey($strNomTable,$strNomTable2,$strNomContrainte, $strNomChamp1,$strNomChamp2) 
      {
          //ALTER TABLE TESTANNUELLES ADD CONSTRAINT FK_SOLEIL FOREIGN KEY(SOLEIL) REFERENCES TESTSOLEIL(CODE);
          
           $this->_requete  = "ALTER TABLE $strNomTable ADD CONSTRAINT $strNomContrainte 
                              FOREIGN KEY(" ."$strNomChamp1".") REFERENCES ".$strNomTable2."($strNomChamp2)";
           /*
           echo $this->_requete;
            echo "<br/>";
           echo "<br/>";
           */
           
           return $this->_OK = mysqli_query($this->_cBD, $this->_requete);
      }
     
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
   }
   
?>