console.log("Wrabbit Settings Script loaded");
		function uriSelector(){
			if(document.getElementById("wrabbitc_amqp_uri").style.display === 'none'){
				document.getElementById("wrabbitc_manual_setting").style.display = "none";
				document.getElementById("wrabbitc_amqp_uri").style.display = "block";
			}else{
				document.getElementById("wrabbitc_manual_setting").style.display = "block";
				document.getElementById("wrabbitc_amqp_uri").style.display = "none";
			}
		}