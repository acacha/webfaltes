var obj;

function ProcessXML(url) {
		//alert(url);
		  // native  object
		if (window.XMLHttpRequest) {
		    // obtain new object
		    obj = new XMLHttpRequest();
		    // set the callback function
		    obj.onreadystatechange = processChange;
		    // we will do a GET with the url; "true" for asynch
		    obj.open("GET", url, true);
		    // null for GET with native object
		    obj.send(null);
		  // IE/Windows ActiveX object
		  } else if (window.ActiveXObject) {
		    obj = new ActiveXObject("Microsoft.XMLHTTP");
		    if (obj) {
		      obj.onreadystatechange = processChange;
		      obj.open("GET", url, true);
		      // don't send null for ActiveX
		      obj.send();
		    }
		  } else {
		    alert("Your browser does not support AJAX");
		  }
}

function ProcessXML2(url,srt,value) {
		//alert(url);
		  // native  object
		if (window.XMLHttpRequest) {
		    // obtain new object
		    obj = new XMLHttpRequest();
			xmlhttp2=new XMLHttpRequest();
		    // set the callback function
		    obj.onreadystatechange = processChange;
		    // we will do a GET with the url; "true" for asynch
		    obj.open("GET", url, true);
		    // null for GET with native object
		    obj.send(null);
		  // IE/Windows ActiveX object
		  } else if (window.ActiveXObject) {
		    obj = new ActiveXObject("Microsoft.XMLHTTP");
		    if (obj) {
		      obj.onreadystatechange = processChange;
		      obj.open("GET", url, true);
		      // don't send null for ActiveX
		      obj.send();
		    }
		  } else {
		    alert("Your browser does not support AJAX");
		  }
		  
		xmlhttp2.onreadystatechange=function(){
		  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
			{
					document.getElementById("div"+srt).innerHTML=xmlhttp2.responseText;
			}
		  }
		xmlhttp2.open("GET","getObservacions.php?obser="+value,true);
		xmlhttp2.send();
		  
}


function processChange() {
    // 4 means the response has been returned and ready to be processed
    if (obj.readyState == 4) {
        // 200 means "OK"
        if (obj.status == 200) {
            // process whatever has been sent back here:
        // anything else means a problem
        } else {
            alert("There was a problem in the returned data:\n");
        }
    }
}

function ProcessXMLmail(url,vari) {
	
	
	if(document.getElementById(vari).value == 0)
	{
		//alert(vari);
	}
	else
	{
		if(confirm("Està segur que vol notificar la incidencia?"))
		{
				//alert(url);
				  // native  object
				if (window.XMLHttpRequest) {
				    // obtain new object
				    obj = new XMLHttpRequest();
				    // set the callback function
				    obj.onreadystatechange = processChangeMail;
				    // we will do a GET with the url; "true" for asynch
				    obj.open("GET", url, true);
			
				    // null for GET with native object
				    obj.send(null);
				  // IE/Windows ActiveX object
				  } else if (window.ActiveXObject) {
				    obj = new ActiveXObject("Microsoft.XMLHTTP");
				    if (obj) {
				      obj.onreadystatechange = processChangeMail;
				      obj.open("GET", url, true);
				      // don't send null for ActiveX
				      obj.send();
				    }
				  } else {
				    alert("Your browser does not support AJAX");
				  }
		}
	}

    
}

function processChangeMail() {
    // 4 means the response has been returned and ready to be processed
    if (obj.readyState == 4) {
        // 200 means "OK"
        if (obj.status == 200) {
            // process whatever has been sent back here:
        // anything else means a problem
        	
        } else {
            //alert("There was a problem in the returned data:\n");
        }
    }
}

function ho_envio(){
	//alert("Hola");
	missatge = "";
	if(!(document.tipus_informe.codi_grup.value || document.tipus_informe.codi_assignatura.value)){
		alert("Has de seleccionar grup i cr�dit");
		return;
	}
	if ((document.tipus_informe.codi_grup.value != -1) && (document.tipus_informe.codi_assignatura.value != -1)){
		document.tipus_informe.Enviar.value='True';
		document.tipus_informe.action='informe_resum_credit_di_df_2.php'
	}else{
		if(document.tipus_informe.codi_grup.value == -1){
			missatge = "Has de seleccionar un grup \n"
		}
		if(document.tipus_informe.codi_assignatura.value == -1){
			missatge = missatge + "Has de seleccionar un cr�dit"
		}
		alert(missatge);
	}
}