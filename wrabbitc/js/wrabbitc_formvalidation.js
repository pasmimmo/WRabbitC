console.log("wrabbitc_formvalidation loaded");

function aggiungiCodici() {
    var codice = prompt("Please enter a code:", "");
    if (inputValidate(codice)) {
        var stringa = codice.toUpperCase() + "#";
        document.getElementById("wrabbitc_proteins").value += stringa;
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