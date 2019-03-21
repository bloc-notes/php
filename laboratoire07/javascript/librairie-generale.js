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
|----------------------------------------------------------------------------|
| estNumerique (04-avr-2009; 19-jan-2015)
|----------------------------------------------------------------------------|
*/
function estNumerique(strChaine) {
   return !(isNaN(strChaine) || isNaN(parseFloat(strChaine, 10)));
}
/*
|----------------------------------------------------------------------------------|
| Object.initialise (28-mai-2011; 08-jan-2015)
|----------------------------------------------------------------------------------|
*/
Object.prototype.initialise =
   function (strChaine) {
      if (strChaine == undefined) {
         strChaine = '';
      }
      this.texte = strChaine;
      this.longueur = this.texte.length;
   }
/*
|----------------------------------------------------------------------------------|
| Object.ajoute (28-mai-2011; 08-jan-2015)
|----------------------------------------------------------------------------------|
*/
Object.prototype.ajoute =
   function (strChaine) {
      this.texte += strChaine;
      this.longueur = this.texte.length;
   }
/*
|----------------------------------------------------------------------------------|
| Object.attache (28-mai-2011; 08-jan-2015)
|----------------------------------------------------------------------------------|
*/
Object.prototype.attache =
   function (strIDBalise, binAjoute) {
      if (binAjoute) {
         b(strIDBalise, b(strIDBalise) + this.texte);
      }
      else {
         b(strIDBalise, this.texte);
      }
   }
/*
|-------------------------------------------------------------------------------------|
| objetBalise (28-mai-2011; 02-jan-2014)
|-------------------------------------------------------------------------------------|
*/
function objetBalise(strIDBalise) {
   var objBalise = document.getElementById(strIDBalise);
   if (!objBalise) {
      alert('Attention... balise "' + strIDBalise + '" inexistante !');
   }
   return (objBalise);
}
/*
|----------------------------------------------------------------------------------------|
| s (05-fév-2014)
|----------------------------------------------------------------------------------------|
*/
function s(strIDBalise_objBalise, strStyles) {
   var objBalise = typeof (strIDBalise_objBalise) == 'string' ? 
      document.getElementById(strIDBalise_objBalise) : strIDBalise_objBalise;
   objBalise.className = strStyles;
}
/*
|----------------------------------------------------------------------------------|
| spluriel
|----------------------------------------------------------------------------------|
*/
function spluriel(intNombre) {
   return intNombre > 1 ? 's' : '';
}
