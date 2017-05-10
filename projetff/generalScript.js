/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function changePage(strLocation){
    window.location = strLocation;
}

function soumetFormulaire(strNomPageAction, strFormulaire){
    var frm;
    frm = document.getElementById(strFormulaire);
    frm.action = strNomPageAction;
    frm.submit();
}