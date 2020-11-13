<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" >
  <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <title>Uploade image</title>
</head>
<body>

<div id="reponse">
  
</div>

<div id="voir">



</div>

<form action="" method="POST" enctype="multipart/form-data">
	<input type="file" name="photo[]" id="photo[]" multiple="" value="Choisit ta photo"/>
	<button type="button" id="pre" class="btn btn-primary" onClick="clic()"/>Prévisualiser</button>
	<button type="button" name="ok" onClick="envoyer()" class="btn btn-success">Soumettre <span id="spinner"><i class="fa fa-spinner fa-spin" title="button-loader"></i></span></button>
	<button type="reset" id="dismiss" class="btn btn-danger" onClick="fermeture()">Retirer</button>
</form>

<br/>

<div id="show">
	<div class="progress">
	  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" id="bar" style=''></div>
	</div>
	<strong id="status"></strong>
	<span id="byte"> </span>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
$("#spinner").hide();

function clic(){
	var fichier = document.getElementById("photo[]").files;
		for(var i = 0; i < fichier.length ; i++)
		{
		create(fichier[i],"monchamp"+i);
		$("#pre").hide();
		}
}

function fermeture()
{
	$("img").remove();
	$("#pre").show();
}

function create(file,id) {
  var reader = new FileReader();
  reader.readAsDataURL(file);
  var img = document.getElementById("voir");
  reader.onloadend = function () {
  var div = document.createElement("div");
  var imgcr = document.createElement("img");
  imgcr.src = reader.result;
  imgcr.style.width = "150px";
  imgcr.style.height = "150px";
  imgcr.setAttribute("name",file.name);
  imgcr.setAttribute("id",id);
  
  imgcr.addEventListener("mousemove",function(e){
	var width,height,mouseX,mouseY;
	// width = imgcr.offsetWidth;
	// height = imgcr.offsetHeight;
	// mouseX = e.offsetX;
	// mouseY = e.offsetY;
	// grosX = (mouseX/width)*100;
	// grosY = (mouseY/height)*100;
	imgcr.style.width = "300px";
	imgcr.style.height = "300px";
  });
  
  imgcr.addEventListener("mouseout", function(e){
	imgcr.style.width = "150px";
	imgcr.style.height = "150px";
  });
  
  img.appendChild(div);
  div.appendChild(imgcr);
  } 
}

function envoyer()
{
	var fichier = document.getElementById("photo[]").files;
	for(var i = 0 ; i < fichier.length ; i++)
	{
		var data = new FormData();
		data.append("photo", fichier[i]);
		var ajax = new XMLHttpRequest();
		ajax.upload.addEventListener("progress", progress, false);
		ajax.addEventListener("load", finish, false);
		ajax.open("POST","envoie.php");
		ajax.send(data);
		ajax.onreadystatechange = function() {
		  if (this.readyState == 4 && this.status == 200) {
			document.getElementById("reponse").innerHTML = this.responseText;
		  }	
	}
}
	
	function progress(e){
		$("#spinner").fadeIn("fast");
		document.getElementById("byte").innerHTML = e.loaded + " octets chargé / "+ e.total;
		var pourcentage = (e.loaded/e.total)*100;
		document.getElementById("status").innerHTML = Math.round(pourcentage) + " % Uploadé.";
		document.getElementById("bar").innerHTML = Math.round(pourcentage)+"%";
		document.getElementById("bar").style.width = Math.round(pourcentage)+"%";
	}
	
	function finish(){
		$("#spinner").fadeOut("fast");
		$("#dismiss").click();
		$("#pre").show();
		document.getElementById("status").innerHTML = "Chargement terminé";
	}
}
</script>
</body>
</html>