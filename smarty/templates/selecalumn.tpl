
{******************************************************************************* 
selecalumn Template 
@ author: sergi.tur@upc.edu 
@ maintainer: sergi.tur@upc.edu
Variables 
 @ ACTION_URL			  Action form URL 
 @ GROUP_CODE		      Group's name
 @ SUBJECT		      	  Subject
 @ N_GROUP_STUDENTS		  Number of students at group 
 @ SELECTED_DATE		  Selected date
 @ SELECTED_TIME_INTERVAL Selected time interval
 @ results				  Associative array with student data
  @ results.url1          First part of URL to insert incident
  @ results.url2          Second part of URL to insert incident
  @ results.selected      Array with options to select
  @ results.i             Number of student (alfabetical order)
  @ results.student_name  Students name
  @ results.student_code  Student database code 
*******************************************************************************}
<link href="css/cupertino/jquery-ui-1.10.0.custom.css" rel="stylesheet">

<script language="javascript" type="text/javascript" src="/javascript/jquery-ui/jquery-ui.js"></script>

<script language="javascript" type="text/javascript" src="/javascript/jquery-ui/ui/jquery-ui-1.8.18.custom.js"></script>

<script>
{literal}
	$(function() {
		
		$( "#accordion" ).accordion();	
		var availableTags = [
			"ActionScript",
			"AppleScript",
			"Asp",
			"BASIC",
			"C",
			"C++",
			"Clojure",
			"COBOL",
			"ColdFusion",
			"Erlang",
			"Fortran",
			"Groovy",
			"Haskell",
			"Java",
			"JavaScript",
			"Lisp",
			"Perl",
			"PHP",
			"Python",
			"Ruby",
			"Scala",
			"Scheme"
		];
		
		$( "#button" ).button();
		$( "#radioset" ).buttonset();
		
		 $(function() {
		$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
		});
				

	});


	function showGrup(str, codi_grup_act, codi_ass){
	

		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
					document.getElementById("textAlumnes").innerHTML=xmlhttp.responseText;
			}
		  }
		
		xmlhttp.open("GET","afegir_alumne.php?codi_grup="+str+"&codi_ass_act="+codi_ass+"&codi_grup_act="+codi_grup_act,true);
		xmlhttp.send();
		
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp2=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp2.onreadystatechange=function()
		  {
		  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
			{
					document.getElementById("AddAlumne").innerHTML=xmlhttp2.responseText;
			}
		  }
		
		xmlhttp2.open("GET","afegir_alumne2.php?codi_grup="+str+"&codi_ass_act="+codi_ass+"&codi_grup_act="+codi_grup_act,true);
		xmlhttp2.send();

	}
	
	function procesIntLdap(nom, sn1, sn2, dni, codi, grup, ass){
		
		

		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
					document.getElementById("prova").innerHTML=xmlhttp.responseText;
			}
		  }
		 for(i=0;i<=500;i++)
			{
			setTimeout('return 0',1);
			
			} 

		
		xmlhttp.open("GET","controlador1.php?nom="+nom+"&sn1="+sn1+"&sn2="+sn2+"&dni="+dni+"&codi="+codi+"&grup="+grup+"&ass="+ass,true);
		xmlhttp.send();
		
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp2=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp2.onreadystatechange=function()
		  {
		  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
			{
					document.getElementById("AddAlumne").innerHTML=xmlhttp2.responseText;
			}
		  }
		
		xmlhttp2.open("GET","afegir_alumne2.php?codi_ass_act="+ass+"&codi_grup_act="+grup,true);
		xmlhttp2.send();
	}
	function procesEliminarldap(eliminar, grup, assignatura, codi_alumne){
		
		
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
					document.getElementById("prova").innerHTML=xmlhttp.responseText;
			}
		  }
		
		xmlhttp.open("GET","controlador1.php?eliminar="+eliminar+"&grup="+grup+"&assignatura="+assignatura+"&codi_alumne="+codi_alumne,true);
		xmlhttp.send();
		
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp2=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp2.onreadystatechange=function()
		  {
		  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
			{
					document.getElementById("AddAlumne").innerHTML=xmlhttp2.responseText;
			}
		  }
		
		xmlhttp2.open("GET","afegir_alumne2.php?codi_ass_act="+assignatura+"&codi_grup_act="+grup,true);
		xmlhttp2.send();
	}
	
	{/literal}
</script>
    
    <style>
	{literal}
	 .ui-tabs-vertical { width: 55em; }
	.ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 8em; }
	.ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
	.ui-tabs-vertical .ui-tabs-nav li a { display:block; }
	.ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px;  }
	.ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: right; width: 760px;}
	#icons li {
		margin: 2px;
		position: relative;
		padding: 4px 0;
		cursor: pointer;
		float: left;
		list-style: none;
	}
	a:link{
	border-bottom:none;
	}
	
	{/literal}
	</style>

<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes"  style="overflow:scroll; min-height:760px; height:auto;">
<br />

<div id="tabs">
	<ul>
		<li><a href="#tabs-1"><font size="1">Passar Llista</font></a></li>
		<li><a href="#tabs-2"><font size="1">Llistats pdf</font></a></li>
        <li><a href="#tabs-4"><font size="1">Ocultar Alumnes</font></a></li>
        <!--<li><a href="#tabs-5"><font size="1">Afegir Alumnes</font></a></li>-->
        	<li><a href="#tabs-3"><font size="1">Ajuda</font></a></li>
	</ul>
	<div id="tabs-1"> 
    <form name="form1" method="post" action="{$ACTION_URL}">
	 <center>   
     
     
     
 {assign var="boolea" value="false"}          
 <table width="1000" >
	    <thead>
		 <tr>

          <th colspan="8">{t}Check Attendance{/t}.
		   <br>
		    {t}Group{/t}: {$GROUP_CODE} {$SUBJECT} ({$N_GROUP_STUDENTS} {t}students{/t})
		    <br>
		    {t}Date{/t}: {$SELECTED_DATE} ({$SELECTED_TIME_INTERVAL})
		  
		 </tr>
		 </thead>
      <tbody>
  <tr>
  <td>ALUMNES:</td>
   {foreach from=$hores item=h}	
   <td>{$h.hora_inici}</td>
   {/foreach}
   <td>OBSERVACIONS:</td>
  </tr>
{assign var="comptador" value=0}
{assign var="comp" value=0}	
        {foreach from=$results item=i}
        {assign var="comp" value=$comp+9}
          {assign var="comptador" value=$comptador+1}	 
		{if $i.ocultar eq "false"}	
          <tr class="{cycle values='tr0,tr1'}" >
		   <td  rowspan="2" scope="col"> 
           {if $i.student_jpegPhotoName eq NULL}<img alt="Foto Perfil" title="Foto Perfil" src="imatges/default_small.jpg" height="32px" width="32px"></img> {else}<img alt="Foto Perfil" title="Foto Perfil" src="view_jpeg_photo.php?file={$i.student_jpegPhotoName}" height="61px" width="48px"></img>{/if} <a href="profile_student.php?codi_alumne={$i.student_code}">{counter}. {$i.student_name} ({$i.student_code}) </a> 
		    </td>
		   
            {foreach from=$hores item=h}	
           <td >
  
          {foreach from=$count_ass item=control}
           		{if $h.codi_hora eq $control.codi_hora}

      <select name="tipus_incidencia1"  onChange="javascript:ProcessXML('{$i.url1}'+this.value+'{$i.url6}{$control.codi_hora}{$i.url2}'+document.form1.obs{$comptador}.value);"  >
                       
            <option value="0" {$i.selected[$i.student_code][$control.hora_inici][0]} > </option>
            <option value="1" {$i.selected[$i.student_code][$control.hora_inici][1]} >F</option>
            <option value="2" {$i.selected[$i.student_code][$control.hora_inici][2]} >FJ</option>
            <option value="3" {$i.selected[$i.student_code][$control.hora_inici][3]} >R</option>
            <option value="4" {$i.selected[$i.student_code][$control.hora_inici][4]} >RJ</option>
            <option value="5" {$i.selected[$i.student_code][$control.hora_inici][5]} >E</option>
        </select>
        		 {assign var="boolea" value="true"} 	                
                {/if}
            {/foreach}
            
           {if $boolea eq "false"}
                {foreach from=$result_inci item=in}
                       {if $in.codi_alumne eq $i.student_code}
                        {if $in.hora_inici eq $h.hora_inici}
                       	 <center><b>{$in.motiu_curt}</b></center>
                        {/if} 
                       {/if} 
                 {/foreach}
           {else}
              {assign var="boolea" value="false"} 
           {/if}
            
          
           </td>
           {/foreach}
           <td> 
           <textarea name="obs{$comptador}" cols="14" rows="2" id="obs{$comptador}"></textarea>
           <!--<button id="obs{$comptador}" onclick="javascript:ProcessXML('{$i.url1}10{$i.url2}'+document.form1.obs{$comptador}.value);">Desar</button>-->
           
           <INPUT TYPE="button" value="Desar" NAME="oc{$comp+8}" align="middle" id="oc{$comp+8}" onClick=
 "javascript:ProcessXML('{$i.url1}10{$i.url6}{$control.codi_hora}{$i.url2}'+document.form1.obs{$comptador}.value);"  >          
            </td>
		 
		 </tr>
         <tr><td colspan="7" scope="col" style="line-height:0.2">
        
         <dd>{$observacions[$i.student_code]}</dd>
		 </td></tr>
         
    	{/if}
		 {/foreach}
         
         
		 </tbody>
		 <tfoot>
		 <tfoot>
		
		<tr>
				<th colspan="8" align="center">
				<input type="submit" name="enviat"
			value="{t}Return{/t}">
				</th>
			</tr>
		</tfoot>
		 </tfoot> 
		</table></center>
		</form>
  
    </div>
	<div id="tabs-2">
        <div align="center"><h4><a class="titol_taronja" href="reports/Llistat_alumnes_grup.php?codi_grup={$GROUP_CODE}&optativa={$OPTATIVA}&assignatura={$ASSIGNATURA}">{t}List of all students in this group (with photo){/t}</a></h4></div>
        <div align="center"><h4><a class="titol_taronja" href="reports/Llistat_alumnes_grup_sense_foto.php?codi_grup={$GROUP_CODE}&optativa={$OPTATIVA}&assignatura={$ASSIGNATURA}">{t}List of all students in this group (without photo){/t}</a></h4></div>
        <div align="center"><h4><a class="titol_taronja" href="reports/Llencol_estudiants_grup.php?codi_grup={$GROUP_CODE}&optativa={$OPTATIVA}&assignatura={$ASSIGNATURA}">{t}Sheet of this group of students{/t}</a></h4></div>
</div>

	<div id="tabs-3">
    
    <b> - Passar Llista: </b>
     
    <b> - Ocultar </b>
   
    
     <div align="right"><a class="imatge" target="_blank" href="http://www.iesebre.com/webfaltes_wiki/index.php/Projectes_de_s%C3%ADntesi/sms_correus#Enviar_correus_electr.C3.B2nics_i.2Fo_sms_al_passar_llista.2A"><img src="/webfaltes/imatges/Ajuda.gif" border="0"></img></a></div>
    </div>


<div id="tabs-4">
<form name="ocultarUser" id="ocultarUser" action="selecalum.php" method="get">



<input type="hidden" value="{$GROUP_CODE}" name="codi_grup"/>
<input type="hidden" value="{$ASSIGNATURA}" name="codi_ass"/>
<input type="hidden" value="{$roles}" name="roles"/>
<input type="hidden" value="{$OPTATIVA}" name="optativa"/>
<input type="hidden" value="{$SELECTED_TIME_INTERVAL}" name="time_interval"/>

 <center>
<table width="550" >
<thead>
	<tr>
    <th>OCULTAR:</th>
    <th>ALUMNE:</th>
    </tr>
</thead>
      <tbody>
		 {foreach from=$results item=i}		 
          <tr class="{cycle values='tr0,tr1'}">
          <td>
          {if $i.ocultar eq "false"}
          <input type="checkbox" id="check" value="{$i.student_code}"   onChange="javascript:ProcessXML('{$i.url5}');" />
          {else}
          <input type="checkbox" id="check" value="{$i.student_code}" checked  onChange="javascript:ProcessXML('{$i.url5}');" />
          {/if}
          </td>
		    <td> <label>
             {if $i.student_jpegPhotoName eq NULL}<img alt="Foto Perfil" title="Foto Perfil" src="imatges/default_small.jpg" height="32px" width="32px"></img> {else}<img alt="Foto Perfil" title="Foto Perfil" src="view_jpeg_photo.php?file={$i.student_jpegPhotoName}" height="61px" width="48px"></img>{/if} <a href="profile_student.php?codi_alumne={$i.student_code}">{$i.i}. {$i.student_name} ({$i.student_code})</a>
             
             
              </label>
		    </td>
		 </tr>

		 {/foreach}
		 </tbody>
         <tr>
         <td><input type="submit" id="Desar canvis" name="Desar canvis" value="Desar canvis"/></td>
         </tr>
</table>
</center>

</form>
</div>
<!--
<div id="tabs-5">


<table id="table3" align="center" style=" background:#C2DBEB; -moz-border-radius: 50px;
border-radius: 20px; width:600px;">
 
    <tr>
    <td></td>
    <td><b>Seleccioneu un grup: </b>
    <select name="grup" id="grup" onChange="showGrup(this.value,'{$grup_act}','{$ass_act}');">
       <option value="" selected></option>
	   {foreach from=$result_grup item=i}		
        <option value="{$i.codi_grup}"> {$i.codi_grup}</option>;
	    {/foreach}	
     
    </select></td>
    
    </tr>
</table>

<form name="ocultarUser" id="afegirAlumnes" action="selecalum.php" method="get">

<input type="hidden" value="{$GROUP_CODE}" name="codi_grup"/>
<input type="hidden" value="{$ASSIGNATURA}" name="codi_ass"/>
<input type="hidden" value="{$roles}" name="roles"/>
<input type="hidden" value="{$OPTATIVA}" name="optativa"/>
<input type="hidden" value="{$SELECTED_TIME_INTERVAL}" name="time_interval"/>

<table style=" width:800px; min-height:700px; overflow:inherit;" align="center">
<thead>
<tr>
<th colspan="2">Afegir Alumnes a La llista de classe:</th></tr> 
</thead>
<tr>
<td style="width:400px;"><div id="textAlumnes" class="textAlumnes"></div></td>
<td style="width:400px;" valign="top" style="vertical-align:top;"><div id="AddAlumne" class="AddAlumne">

</div></td>
</tr>
<tfoot>	
<tr>
    <th colspan="2" align="center">
    <input type="submit" name="enviat" value="Desar canvis">
    </th>
</tr>
</tfoot>

</table>
</form>

</div>-->



</div>







</div>
	

