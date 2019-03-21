<?php
   /*
   |-------------------------------------------------------------------------------------|
   | trouveDansChaine : 12-avr-2014
   | Scénarios        : trouveDansChaine($strSousChaine, $strChaine, &$intPos)
   |                    trouveDansChaine($strSousChaine, $strChaine, &$intPos, $intDebut)
   |-------------------------------------------------------------------------------------|
   */
   function trouveDansChaine($strSousChaine, $strChaine, &$intPos) {
      if (func_num_args() == 3) {
         $intPos = strpos($strChaine, $strSousChaine);
      }
      else {
         $intDebut = func_get_arg(3);
         $intPos = stripos($strChaine, $strSousChaine, $intDebut);
      }
      return !($intPos === false);
   }
?>