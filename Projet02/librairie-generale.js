/*
|----------------------------------------------------------------------------------------|
| arronditEtFormate (28-mai-2011)
|----------------------------------------------------------------------------------------|
*/
function arronditEtFormate(dblNombre, intDecimales) {
   var strNombre;
   if (intDecimales >= 0 && intDecimales <= 14) {
      strNombre = (Math.round(dblNombre * Math.pow(10, intDecimales)) /
   Math.pow(10, intDecimales)).toFixed(intDecimales);
   }
   else {
      strNombre = '<span style="color:red">' + dblNombre + '</span>';
   }
   return (strNombre);
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
|--------------------------------------------------------------------------------------------------------------|
| Number.dansIntervalle (28-mai-2011; 08-jan-2015)
|--------------------------------------------------------------------------------------------------------------|
| BorneInf : Borne inférieure de l'intervalle
| BorneSup : Borne supérieure de l'intervalle
|--------------------------------------------------------------------------------------------------------------|
| Ex.: 10.dansIntervalle(1,10) retourne TRUE
|      15.dansIntervalle(1,10) retourne FALSE
|      b('tbAge').dansIntervalle(18,120) provoque une erreur
|      parseInt(Balise('tbAge'),10).dansIntervalle(18,120) retourne TRUE ou FALSE
|--------------------------------------------------------------------------------------------------------------|
*/
Number.prototype.dansIntervalle =
	function(BorneInf, BorneSup) {
		return parseInt(this, 10) >= BorneInf && parseInt(this, 10) <= BorneSup;
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
|----------------------------------------------------------------------------|
| genereNombre (19-mar-2015)
|----------------------------------------------------------------------------|
*/
function genereNombre(intMinimum, intMaximum) {
   var intNombre = -1;
   while (intNombre < intMinimum || intNombre > intMaximum) {
      intNombre = Math.floor(Math.random()*intMaximum) + 1;
   }
   return intNombre;
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
|----------------------------------------------------------------------------------------|
| valideDateMinimalement (pour le projet 2)
|----------------------------------------------------------------------------------------|
*/
function valideDateMinimalement(strDate) {
   var Syntaxe = /^\d{4}\-\d{2}\-\d{2}$/;
   return Syntaxe.test(strDate) && strDate != '0000-00-00';
}
