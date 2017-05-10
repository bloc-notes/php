
<?php
    
    $strNomAuteur = "Andy Chen";
    
    function ajouteZeros($numValeur, $intLargeur)
    {
        $strFormat = "%0" . $intLargeur . "d";
        return(sprintf($strFormat,$numValeur));
    }
    
    function aujourdhui($binAAAMMJJ=true)
    {
        $strDate = date("Y-m-d")."<br /><br />";
          
        if(!($binAAAMMJJ))
        {
            $strDate = date("m-d-Y")."<br /><br />";
        }
    
        return $strDate;
    }
    
    function bissextile($intAnnee)
    {
        $intAnnee = date("L",  strtotime("$intAnnee-1-1"));
     
        if($intAnnee==1)
        {
            return true;
        }
        
        else
        {
            return false;
        }
    }
    
    function convertitSousChaineEnEntier($strChaine, $intDepart, $intLongeur)
    {
        $intEntier = intval(substr($strChaine, $intDepart, $intLongeur));
        return $intEntier;
    }
    
    function dansIntervalle($numValeur,$intMin, $intMax)
    {
        return (($numValeur >= $intMin) & ($numValeur <= $intMax));
    }
    
    function dateValide($strDate)
    {
        extraitJSJJMMAAAAv2($intJourSemaine, $intJour, $intMois, $intAnnee,$strDate);
        
       return checkdate($intMois, $intJour, $intAnnee);
    }
    
    function decomposeURL($strURL, &$strChemin, &$strNom, &$strSuffixe)
    {
        $path_parts = pathinfo($strURL);
        
        $strChemin = $path_parts['dirname'];
        $strNom = $path_parts['filename'];
        $strSuffixe = $path_parts['extension'];
    }
    
    function detecteServeur(&$strMonIP, &$strIPServeur, &$strNomServeur, &$strInfosSensibles) 
    {
        $strMonIP = $_SERVER["REMOTE_ADDR"];
        $strIPServeur = $_SERVER["SERVER_ADDR"];
        $strNomServeur = $_SERVER["SERVER_NAME"];
        $strInfosSensibles = str_replace(".", "-", $strNomServeur) . ".php";
   }
    
    function dollar($dblNombre) 
    {
        return number_format($dblNombre, 2, ",", " ") . " $";
    }
    
    function droite($strChaine, $intLargeur)
    {
       return substr($strChaine, -1*$intLargeur);
    }
    
    function ecrit($strChaine,$intNbBR=0)
    {
        echo "$strChaine";
        
        for($i=0; $i<$intNbBR; $i++)
        {
            echo "<br/>";
        }
    }
    
    function encadre($strChaine, $strCaracteres)
    {
        if(strlen($strCaracteres) == 2)
        {
           echo substr($strCaracteres, 0, 1). $strChaine . substr($strCaracteres, 1, 1);  
        }
        
        else if(strlen($strCaracteres) == 1)
        {
             echo substr($strCaracteres, 0, 1). $strChaine . substr($strCaracteres, 0, 1);  
        }
    }
    
    function er($intEntier, $binExposant=true)
    {
        return $intEntier . ($intEntier == 1 ? ($binExposant ? "<sup>er</sup>" : "er") : "");
    }
    
    function estNumerique($strValeur)
    {
        return is_numeric($strValeur);
    }
    
    function etatCivilValide($chrEtat, $chrSexe, &$strEtatCivil)
    {
        $bool = true;
        $strEtatCivil;
        
        $chrSexe = strtolower($chrSexe);
        $chrEtat = strtolower($chrEtat);
        
        switch($chrEtat)
        {
            case "c" :  
                $strEtatCivil= "Célibataire";
                break;

            case "f" :
                $strEtatCivil = $chrSexe=="h" ? "Conjoint de fait": "Conjointe de fait";
                break;

            case "m":
                $strEtatCivil= $chrSexe=="h" ? $strEtatCivil = "Marié": $strEtatCivil = "Mariée";
                break;

            case "s":
                $strEtatCivil= $chrSexe=="h" ? $strEtatCivil = "Séparé": $strEtatCivil = "Séparée";
                break;

            case "d":
                $strEtatCivil= $chrSexe=="h" ? $strEtatCivil = "Divorcé": $strEtatCivil = "Divorcée";
                break;

            case "v":
                $strEtatCivil= $chrSexe=="h" ? $strEtatCivil = "Veuf": $strEtatCivil = "Veuve";
                break;

            default: 
                $bool = false;
                break;
            
        }
        return $bool;
    }
    
     function extraitJJMMAAA(&$intJour, &$intMois, &$intAnnee) 
     {
        if(func_num_args() == 3)
        {
           $strDate = date("d-m-Y");
        }

        else   
        {
           $strDate = func_get_arg(3);
        }

        $intJour = intval(substr($strDate, 0, 2));
        $intMois = intval(substr($strDate, 3, 2));
        $intAnnee = intval(substr($strDate, 6, 4));
    }
    
    function extraitJSJJMMAAAA(&$intJourSemaine, &$intJour, &$intMois, &$intAnnee)
    {
        if(func_num_args() == 4)
        {
            $strDate = date("d-m-Y"); 
            $intJourSemaine = date("N"); 
        }

        else
        {
            $strDate = func_get_arg(4);
            $intJourSemaine = date("N", strtotime($strDate)); 
        }

        $intJour = intval(substr($strDate, 0, 2));
        $intMois = intval(substr($strDate, 3, 2));
        $intAnnee = intval(substr($strDate, 6, 4));
    }
       
    function extraitJSJJMMAAAAv2(&$intJourSemaine, &$intJour, &$intMois, &$intAnnee)
    {
        if(func_num_args() == 4)
        {
            $strDate = $intJour."-".$intMois."-".$intAnnee;

            if(substr($strDate, 2)=="-")
            {
                 $strDate = date("d-m-Y"); 
            }

            else
            {
                 $strDate = date("Y-m-d"); 
            }

            $intJourSemaine = date("N"); 
         }

         else
         {
            $strDate = func_get_arg(4);
            $intJourSemaine = date("N", strtotime($strDate)); 
         }

            if(substr($strDate, 2)=="-")
            {
                 $intJour = intval(substr($strDate, 0, 2));
                 $intMois = intval(substr($strDate, 3, 2));
                 $intAnnee = intval(substr($strDate, 6, 4));
            }

            else
            {
                $intJour = intval(substr($strDate, 8, 2));
                $intMois = intval(substr($strDate, 5, 2));
                $intAnnee = intval(substr($strDate, 0, 4));
            }
    }
    
    function get($strNomParametre)
    {
        return isset($_GET[$strNomParametre]) ? $_GET[$strNomParametre]: null;
    }
    
     function JJMMAAAA($intJour,$intMois,$intAnnee)
    {
        $intAnnee = $intAnnee <= 20 ? 2000+ $intAnnee : 
                   ($intAnnee <= 99? 1900 + $intAnnee: 
                    $intAnnee);

        return ajouteZeros($intJour,2)."-".
               ajouteZeros($intMois,2)."-".
               ajouteZeros($intAnnee,4)." ";
    }
    
    function jourSemaineEnLitteral($intNoJour, $binMajuscule=false)
    {
         $strJour = 'N/A';
      
         switch ($intNoJour) 
         {
            case 1: $strJour = "Lundi"; break;
            case 2: $strJour = "Mardi"; break;
            case 3: $strJour = "Mercredi"; break;
            case 4: $strJour = "Jeudi"; break;
            case 5: $strJour = "Vendredi"; break;
            case 6: $strJour = "Samedi"; break;
            case 7: $strJour = "Dimanche"; break;
         }

         $strJour = $binMajuscule ? ucfirst($intNoJour) : $strJour;
         return $strJour;
    }
    
    function majuscules($strChaine)
    {
        echo strtoupper($strChaine);
    }
    
    function minuscules($strChaine)
    {
        echo strtolower($strChaine);
    }
    
    function moisEnLitteral($intMois, $binMajuscule = false)
    {
      $strMois = "N/A";
      
      switch ($intMois) 
      {
            case 1: $strMois = "janvier"; break;
            case 2: $strMois = "f&eacute;vrier"; break;
            case 3: $strMois = "mars"; break;
            case 4: $strMois = "avril"; break;
            case 5: $strMois = "mai"; break;
            case 6: $strMois = "juin"; break;
            case 7: $strMois = "juillet"; break;
            case 8: $strMois = "ao&ucirc;t"; break;
            case 9: $strMois = "septembre"; break;
            case 10: $strMois = "octobre"; break;
            case 11: $strMois = "novembre"; break;
            case 12: $strMois = "d&eacute;cembre"; break;
      }
      
      $strMois = $binMajuscule ? ucfirst($strMois) : $strMois;
      return $strMois;
    }
    
    function nombreJoursAnnee($intAnnee)
    {
        if(bissextile($intAnnee))
        {
            return "366";
        }
        
        else
        {
            return "365";
        }
    }
    
    function nombreJoursEntreDeuxDates($strDate1, $strDate2)
    {
        $strDate1 = strtotime($strDate1);
        $strDate2 = strtotime($strDate2);
        
        return round($strDate2-$strDate1)/(24*60*60);
        
    }
    
    function nombreJoursMois($intMois, $intAnnee)
    {
        if(bissextile($intAnnee) & $intMois ==2)
        {
            return "29";
        }
       
        return $intMois = date("t",strtotime("1-$intMois-$intAnnee"));    
    }
    
    function post($strNomParametre)
    {
        return isset($_POST[$strNomParametre]) ? $_POST[$strNomParametre] : null;
    }
?>
