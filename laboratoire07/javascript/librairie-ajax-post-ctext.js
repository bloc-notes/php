var cTEXT = 1;
var cXML = 2;
/*
|--------------------------------------------------------------------------------------------|
| Nom : requeteServeur (07-jun-2010; 06-jan-2014)
|--------------------------------------------------------------------------------------------|
*/
function requeteServeur(strNomApplication, strLigneParametres, fonctionTraitante, binAttente, cTEXTouXML) {
   /* 06-jan-2014 : Validation de la présence d'un cinquième paramètre (cTEXTouXML);
                    Validation plus détaillée des quatrième (binAttente) et cinquième paramètres */
   var binErreur = false;
   var strMessage = '';
   if (binAttente == null) {
      binErreur = true;
      strMessage = '\n\nParamètre "binAttente" absent !';
   }
   else {
      if (binAttente != true && binAttente != false) {
         binErreur = true;
         strMessage = '\n\nParamètre "binAttente" doit avoir la valeur "true" ou "false"';
      }
   };
   if (cTEXTouXML == null) {
      binErreur = true;
      strMessage += '\n\nParamètre "cTEXTouXML" absent !';
   }
   else {
      binTEXT = (cTEXTouXML == cTEXT ? true : (cTEXTouXML == cXML ? false : null));
   };
   if (binTEXT == null) {
      binErreur = true;
      strMessage += '\n\nParamètre "cTEXTouXML" doit avoir la valeur "cTEXT" ou "cXML"';
   };
   if (binErreur) {
      alert('Message(s) retourné(s) par la fonction "requeteServeur"' + strMessage);
   }
   else {
      this.objPointeur = creeObjetXMLHttpRequest();
      transmetRequeteAuServeur(this.objPointeur, strNomApplication, strLigneParametres, fonctionTraitante, binAttente, cTEXTouXML);
   }
   /*
   |--------------------------------------------------------------------------------------------|
   | Nom : creeObjetXMLHttpRequest (07-jun-2010)
   | But : Création de l'objet XMLHttpRequest
   |--------------------------------------------------------------------------------------------|
   */
   function creeObjetXMLHttpRequest() {
      var xmlHttp;
      /* IE */
      if (window.ActiveXObject) {
         try { xmlHttp = new ActiveXObject('Microsoft.XMLHTTP'); } catch (e) { xmlHttp = false; }
      }
      /* Mozilla et autres navigateurs */
      else {
         try { xmlHttp = new XMLHttpRequest(); } catch (e) { xmlHttp = false; }
      }
      /* Retourne l'objet créé ou affiche un message d'erreur */
      if (!xmlHttp) {
         alert('L\'objet XMLHttpRequest n\'a pas pu étre créé !');
      }
      else {
         return xmlHttp;
      }
   }
   /*
   |--------------------------------------------------------------------------------------------|
   | Nom : transmetRequeteAuServeur (24-avr-2011; 25-mai-2011; 06-jan-2014)
   | But : Transmet la requête à l'application serveur (exécutée par la fonction porteuse)
   |--------------------------------------------------------------------------------------------|
   */
   function transmetRequeteAuServeur(xmlHttp, strApplication, strLigneParametres, fonctionTraitante, binAttente, cTEXTouXML) {
      /* Poursuite du traitement seulement si l'objet xmlHttp est disponible */
      if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0) {
         /* Préparation de la requête qui sera transmise à l'application serveur */
         xmlHttp.open('POST', strApplication, !binAttente);
         xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
         // 15-jul-2011 : Les deux lignes ci-dessous provoque des avertissements en Google Chrome
         // Les retirer ne semble pas créer de problème (pour le moment du moins !)
         //xmlHttp.setRequestHeader("Content-length", strLigneParametres.length);
         //xmlHttp.setRequestHeader("Connection", "close");
         /* Identification de la fonction qui traitera la réponse du serveur et transmission
         du nom de la fonction qui traitera les données */
         xmlHttp.onreadystatechange = function () { recoitInfoServeur(xmlHttp, fonctionTraitante, cTEXTouXML); };
         /* Transmission de la requête au serveur */
         xmlHttp.send(strLigneParametres);
      }
      else {
         /* Si le serveur n'est pas disponible, nouvelle transmission de la requête dans une seconde */
         setTimeout('transmetRequeteAuServeur(xmlHttp,strApplication,strLigneParametres,fonctionTraitante, binAttente, cTEXTouXML)', 1000);
      }
   }
   /*
   |--------------------------------------------------------------------------------------------|
   | Nom : recoitInfoServeur (07-jun-2010; 06-jan-2014)
   | But : Récupère les informations transmises par le serveur pour les traiter, puis exécute
   |       la fonctiontraitante
   |--------------------------------------------------------------------------------------------|
   */
   function recoitInfoServeur(xmlHttp, fonctionTraitante, cTEXTouXML) {
      /* Poursuite du traitement seulement si la transaction est complétée */
      if (xmlHttp.readyState == 4) {
         /* Le statut 200 confirme une transaction compléte réussie */
         if (xmlHttp.status == 200) {
            /* Extrait la réponse du serveur */
            /* 06-jan-2014 : Deux réponses possibles soit texte ou xml (dernière option à explorer éventuellement) */
            var TEXTouXMLRetourneParServeur = cTEXTouXML == cTEXT ? xmlHttp.responseText : xmlHttp.responseXML;
            /* Exécution de la fonction qui traitera la réponse */
            fonctionTraitante(TEXTouXMLRetourneParServeur);
         }
         else {
            alert('Problème d\'accès au serveur : ' + xmlHttp.statusText);
         }
      }
   }
}
/*
SYNTAXE À RESPECTER POUR LA FONCTION TRAITANTE :

function fonctionTraitante(TEXTouXMLRetourneParServeur) {
Insérer le code source ici
}

SYNTAXE POUR L'APPEL :

var strNomApplication = 'Nom de l'application serveur';
var strLigneParametres = 'Liste des paramètres à transmettre';
new requeteServeur(strNomApplication, strLigneParametres, fonctionTraitante, true, cTEXT|cXML);
*/