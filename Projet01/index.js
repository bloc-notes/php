/*
|----------------------------------------------------------------------------------------|
| afficheOuMasqueBalise (02-aoû-2011; 02-jan-2014)
|----------------------------------------------------------------------------------------|
*/
function afficheOuMasqueBalise(strIDBalise_objBalise, binVisible) {
   var objBalise = typeof (strIDBalise_objBalise) == 'string' ? 
      document.getElementById(strIDBalise_objBalise) : strIDBalise_objBalise;
   objBalise.style.display = binVisible ? 'inline' : 'none';
}
/*
|----------------------------------------------------------------------------------------|
| ajouteZeros (28-mai-2011)
|----------------------------------------------------------------------------------------|
*/
function ajouteZeros(intEntier, intLargeur) {
   var strEntier='';
   if (!estNumerique(intEntier)) {
      strEntier = 'ERREUR';
   }
   else {
      for (var i=1; i<=intLargeur - intEntier.toString().length;i++) {
         strEntier += '0';
      }
      strEntier += intEntier.toString();
   }
   return(strEntier);
}
/*
|----------------------------------------------------------------------------------------|
| attacheBalise (10-jan-2012; 07-jan-2013; 02-jan-2014)
|----------------------------------------------------------------------------------------|
*/
function attacheBalise(objBalise, strIDAttache_objAttache) {
   /*
   |-------------------------------------------------------------------------------------|
   | objb    : 28-mai-2011
   | Fichier : librairie-generale.js
   |-------------------------------------------------------------------------------------|
   */
   function objb(strIDBalise) {
      var objBalise = document.getElementById(strIDBalise);
      if (!objBalise) {
         alert('Attention... balise ' + strIDBalise + ' inexistante !');
      }
      return (objBalise);
   }
   /*
   |-------------------------------------------------------------------------------------|
   | Module directeur (attacheBalise)
   |-------------------------------------------------------------------------------------|
   */
   if (typeof(strIDAttache_objAttache) == 'string') {
      if (strIDAttache_objAttache == '') {
         /* Attachement à la balise BODY */
         document.body.appendChild(objBalise);
      }
      else {
         /* Attachement à la balise spécifiée sous forme de chaîne */
         objb(strIDAttache_objAttache).appendChild(objBalise);
      }
   }
   else {
      /* Attachement à la balise spécifiée sous forme d'objet */
      strIDAttache_objAttache.appendChild(objBalise);
   }
}
/*
|----------------------------------------------------------------------------------------|
| b (04-aoû-2009; 28-mai-2011)
|----------------------------------------------------------------------------------------|
*/
function b(strIDBalise,strValeur) {
	var objBalise = document.getElementById(strIDBalise);
	if (!objBalise) {
		alert('Attention... balise ' + strIDBalise + ' inexistante !');
	}
	else {
		if (objBalise.value != undefined) {
			/* Balise INPUT */
			if (strValeur != undefined) {
				objBalise.value = strValeur;
			}
			else {
				return(objBalise.value);
			}
		}
		else {
			if (objBalise.src != undefined) {
				/* Balise IMG */
				if (strValeur != undefined) {
					objBalise.src = strValeur;
				}
				else {
					return(objBalise.src);
				}
			}
			else {
				/* Balise P ou SPAN */
				if (strValeur != undefined) {
					objBalise.innerHTML = strValeur;
				}
				else {
					return(objBalise.innerHTML);
				}
			}
		}
	}
}
/*
|----------------------------------------------------------------------------------------|
| brDYN (07-jul-2011; 04-jan-2012; 10-jan-2012; 03-jan-2014)
|----------------------------------------------------------------------------------------|
*/
function brDYN(intNbBR, strIDAttache_objAttache, strCLASS) {
   for (var i=1; i<=intNbBR; i++) {
      var objBR = document.createElement('br');
      /* Attachement de la balise enfant à la balise parent */
      attacheBalise(objBR, strIDAttache_objAttache);
      /* Assignation d'un style à la balise, si applicable */
      if (strCLASS != null) {
         objBR.className = strCLASS;
      }
   }
}
/*
|----------------------------------------------------------------------------------------|
| estNumerique (28-mai-2011)
|----------------------------------------------------------------------------------------|
*/
function estNumerique(strChaine) {
   return !(isNaN(strChaine) || isNaN(parseFloat(strChaine, 10)));
}
/*
|----------------------------------------------------------------------------------------|
| inputDYN (11-jul-2011; 20-jan-2012; 15-fév-2014)
|----------------------------------------------------------------------------------------|
*/
function inputDYN(strID, strIDAttache_objAttache, strCLASS, strVALUE, strMAXLENGTH, binActif, binVisible) {
   /* Création d'une instance de la balise */
   var objINPUT = document.createElement('input');
   /* Assignation des différents attributs */
   with (objINPUT) {
      /* Assignation d'un ID et d'une NAME à la balise */
      id = strID;
      name = strID;
      /* Définition du type de balise INPUT */
      type = 'text';
      /* Assignation d'un style à la balise, si applicable */
      if (strCLASS != null && strCLASS != '') {
         className = strCLASS;
      }
      /* Assignation d'une valeur à la balise, si applicable */
      if (strVALUE != null && strVALUE != '') {
         value = strVALUE;
      }
      /* Assignation d'une largeur maximum au contenu de la balise, si applicable */
      if (strMAXLENGTH != null && strMAXLENGTH != '') {
         maxLength = strMAXLENGTH;
      }
      /* Activation ou désactivation de la zone */
      if (binActif != null) { disabled = !binActif; }
   }
   /* Attachement de la balise enfant à la balise parent */
   attacheBalise(objINPUT, strIDAttache_objAttache);
   /* Affichage ou masquage de la balise nouvellement créée, si applicable */
   if (strID != '' && binVisible != null) {
      afficheOuMasqueBalise(strID, binVisible);
   }
   /* Retour d'une référence sur l'instance de la balise */
   return(objINPUT);
}
/*
|----------------------------------------------------------------------------------------|
| peupleListeDeroulante (12-jan-2014)4
| 08-mar-2014 : Le tableau tListeVALUE peut démarrer à la position 0 ou 1
|----------------------------------------------------------------------------------------|
*/
function peupleListeDeroulante(objSELECT, tListeVALUE, strVALUEDefaut) {
   var intNbValeurs = tListeVALUE.length;
   var intValeurDepart = tListeVALUE[0] == null ? 1 : 0;
   for (var i=intValeurDepart; i<intNbValeurs; i++) {
      var objOptionDDL = document.createElement('option');
      var tValueTexte = tListeVALUE[i].split('|*|');
      objOptionDDL.value = tValueTexte[0];
      objOptionDDL.text = tValueTexte[1];
      if (objOptionDDL.value == strVALUEDefaut) {
         objOptionDDL.selected = 'selected';
      }
      /* Ajout de l'option à la liste déroulante en fonction du navigateur détecté */
      try {
         objSELECT.add(objOptionDDL, null);
      }
      catch (ex) {
         objSELECT.add(objOptionDDL);
      }
   }
}
/*
|----------------------------------------------------------------------------------------|
| selectDYN (04-fév-2012; 12-jan-2014; 08-mar-2014)
| 08-mar-2014 : Le tableau tListeVALUE peut démarrer à la position 0 ou 1
|----------------------------------------------------------------------------------------|
*/
function selectDYN(strID, strIDAttache_objAttache, strCLASS, tListeVALUE, strVALUEDefaut, binActif, binVisible, fonctionOnChange) {
   /* Création d'une instance de la balise */
   var objSELECT = document.createElement('select');
   /* Assignation des différents attributs */
   with (objSELECT) {
      /* Assignation d'un ID et d'un NAME à la balise, si applicable */
      if (strID != '') {
         id = strID;
         name = strID;
      };
      /* Assignation d'un style à la balise, si applicable */
      if (strCLASS != null && strCLASS != '') {
         className = strCLASS; 
      };
      /* Activation ou désactivation de la liste */
      if (binActif != null) {
         disabled = !binActif;
      };
      /* Assignation d'une fonction pour ONCHANGE */
      if (fonctionOnChange != null) {
         onchange = function() {
            fonctionOnChange(this);
         }
      };
   }
   /* Remplissage de la liste déroulante */
   if (tListeVALUE != null) {
      peupleListeDeroulante(objSELECT, tListeVALUE, strVALUEDefaut);
   }
   /* Attachement de la balise enfant à la balise parent */
   attacheBalise(objSELECT, strIDAttache_objAttache);
   /* Affichage ou masquage de la balise nouvellement créée, si applicable */
   if (strID != '' && binVisible != null) {
      afficheOuMasqueBalise(strID, binVisible);
   }
   /* Retour d'une référence sur l'instance de la balise */
   return(objSELECT);
}
/*
|----------------------------------------------------------------------------------------|
| spanDYN (07-jul-2011; 04-jan-2012; 10-jan-2012; 13-jan-2012; 03-jan-2014)
|----------------------------------------------------------------------------------------|
*/
function spanDYN(strID, strIDAttache_objAttache, strCLASS, binVisible, strContenu) {
   /* Création d'une instance de la balise */
   var objSPAN = document.createElement('span');
   /* Assignation des différents attributs */
   with (objSPAN) {
      /* Assignation d'un ID à la balise, si applicable */
      if (strID != '') {
         id = strID;
      }
      /* Assignation d'un style à la balise, si applicable */
      if (strCLASS != null && strCLASS != '') {
         className = strCLASS;
      }
      /* Assignation d'un contenu, si applicable */
      if (strContenu != null) {
         innerHTML = strContenu;
      }
   }
   /* Attachement de la balise enfant à la balise parent */
   attacheBalise(objSPAN, strIDAttache_objAttache);
   /* Affichage ou masquage de la balise nouvellement créée, si applicable */
   if (strID != '' && binVisible != null) {
      afficheOuMasqueBalise(strID, binVisible);
   }
   /* Retour d'une référence sur l'instance de la balise */
   return(objSPAN);
}
/*
|----------------------------------------------------------------------------------------|
| tableDYN (07-jul-2011; 13-jan-2012; 03-jan-2014) EXERCICE 2
|----------------------------------------------------------------------------------------|
*/
function tableDYN(strID, strIDAttache_objAttache, strCLASS, binVisible) {
   /* Création d'une instance de balise */
   var objTABLE = document.createElement('table');
   /* Assignation des différents attributs */
   with (objTABLE) {
      /* Assignation d'un ID à la balise, si applicable */
      if (strID != '') {
         id = strID;
      }
      /* Assignation d'un style à la balise, si applicable */
      if (strCLASS != null && strCLASS != '') {
         className = strCLASS;
      }
   }
   /* Attachement de la balise enfant à la balise parent */
   attacheBalise(objTABLE, strIDAttache_objAttache);
   /* Affichage ou masquage de la balise nouvellement créée, si applicable */
   if (strID != '' && binVisible != null) {
      afficheOuMasqueBaliseTable(strID, binVisible);
   }
   /* Retour d'une référence sur l'instance de la balise */
   return(objTABLE);
}
/*
|----------------------------------------------------------------------------------------|
| tdDYN (07-jul-2011; 14-jan-2012; 03-jan-2014) EXERCICE 2
|----------------------------------------------------------------------------------------|
*/
function tdDYN(strID, strIDAttache_objAttache, strCLASS, binVisible, strContenu) {
   /* Création d'une instance de balise */
   var objTD = document.createElement('td');
   /* Assignation des différents attributs */
   with (objTD) {
      /* Assignation d'un ID à la balise, si applicable */
      if (strID != '') {
         id = strID;
      }
      /* Assignation d'un style à la balise, si applicable */
      if (strCLASS != null && strCLASS != '') {
         className = strCLASS;
      }
      /* Assignation d'un contenu, si applicable */
      if (strContenu != null) {
         innerHTML = strContenu;
      }
   }
   /* Attachement de la balise enfant à la balise parent */
   attacheBalise(objTD, strIDAttache_objAttache);
   /* Affichage ou masquage de la balise nouvellement créée, si applicable */
   if (strID != '' && binVisible != null) {
      afficheOuMasqueBaliseTable(strID, binVisible);
   }
   /* Retour d'une référence sur l'instance de la balise */
   return objTD;
}
/*
|----------------------------------------------------------------------------------------|
| trDYN (07-jul-2011; 13-jan-2012; 03-jan-2014) EXERCICE 2
|----------------------------------------------------------------------------------------|
*/
function trDYN(strID, strIDAttache_objAttache, strCLASS, binVisible) {
   /* Création d'une instance de balise */
   var objTR = document.createElement('tr');
   /* Assignation des différents attributs */
   with (objTR) {
      /* Assignation d'un ID à la balise, si applicable */
      if (strID != '') {
         id = strID;
      }
      /* Assignation d'un style à la balise, si applicable */
      if (strCLASS != null && strCLASS != '') {
         className = strCLASS;
      }
   }
   /* Attachement de la balise enfant à la balise parent */
   attacheBalise(objTR, strIDAttache_objAttache);
   /* Affichage ou masquage de la balise nouvellement créée, si applicable */
   if (strID != '' && binVisible != null) {
      afficheOuMasqueBaliseTable(strID, binVisible);
   }
   /* Retour d'une référence sur l'instance de la balise */
   return objTR;
}