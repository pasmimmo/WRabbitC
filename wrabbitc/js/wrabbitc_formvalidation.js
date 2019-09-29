console.log("wrabbitc_formvalidation loaded");

function aggiungiCodici() {
    var codice = prompt("Please enter a code:", "");
    if (inputValidate(codice)){
        if(document.getElementById("wrabbitc_proteins").value.length<50){
        var stringa = codice.toLowerCase() + "-";
        document.getElementById("wrabbitc_proteins").value += stringa;}
        else{
            alert('too many pdbs')
        }
    } else {
        alert("pls enter a valid input");
    }
}
function inputValidate(codice) {
    var test = false;
    if (codice != "" && codice.length == 4) {
        var patt = /^.{0}[0-9].{1,}[a-z0-9A-Z]/;
        var res = patt.test(codice);
        test = res;
    }
    return test;
}