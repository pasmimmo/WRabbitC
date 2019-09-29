<!DOCTYPE html>
<html>
<body>

Name: <input type="text" id="myText" disabled>

<p>Click the button to disable the text field.</p>

<button onclick="myFunction()">Add PDBs</button>

<script>
function myFunction() {
maxPDBs=3;
if(document.getElementById("myText").value.length< maxPDBs*5){
document.getElementById("myText").value+='ciao#';
}else{
alert('max value exceed')}
}
</script>

</body>
</html>
