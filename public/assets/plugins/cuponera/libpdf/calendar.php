<?php
// Get values from query string
$dias=array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
$meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	
	$fecha1=date('Y').strftime("%m").strftime("%d");
	$count = 0;
	$dia = strftime("%d");
	if (!isset($fecactual))
	{
		$fecactual="S";
	}
	
		if ($fecactual=="S")
		{
			$mes = strftime("%m");
			$anio = date('Y');
			$fecha=strftime("%Y/%m/%d");
			$diasel="";
			$currentTimeStamp = strtotime("$anio-$mes-$dia");
			$NomMes = $meses[intval(date("m"))-1];
			$titufecha=$dias[intval(date("w"))].", ".strftime("%d")." de ".$meses[intval(date("m"))]." del ".date('Y')."  Semana ".strftime("%U");
		}
		else
		{	$anio = $anio;
			$currentTimeStamp = strtotime("$anio-$mes-$diasel");
			$NomMes = $meses[intval($mes)-1];
			$fecha=$anio."/".$mes."/".$diasel;
			$titufecha=$dias[intval(date("w",$currentTimeStamp))].", ".$diasel." de ".$NomMes." del ".$anio."  Semana ".strftime("%U");
		}
	
	
	$NumDias = date("t", $currentTimeStamp);
	$field = $_GET["field"];
	$form = $_GET["form"];

/*$numEventsThisMonth = 0;
$hasEvent = false;
$todaysEvents = "";*/
?>

<html>
<head>
<title>...</title>
<script language="javascript">
    function goLastMonth(month,year,form,field)
    {
        // If the month is January, decrement the year.
        if(month == 1)
    {
    --year;
    month = 13;
    }       
        document.location.href = 'calendar.php?month='+(month-1)+'&year='+year+'&form='+form+'&field='+field;
    }
   
    function goNextMonth(month,year,form,field)
    {
        // If the month is December, increment the year.
        if(month == 12)
    {
    ++year;
    month = 0;
    }   
        document.location.href = 'calendar.php?month='+(month+1)+'&year='+year+'&form='+form+'&field='+field;
    }
   
    function sendToForm(val,field,form)
    {
        // Send back the date value to the form caller.
		//alert("opener.document." + form + "." + field + ".value='" + val + "'");
        eval("opener.document." + form + "." + field + ".value='" + val + "'");
        window.close();
    }
</script>
<link href="calendario.css" rel="stylesheet" type="text/css">
</head>
<body style="margin:0px 0px 0px 0px" class="body">
<table width="100%" height="0%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr>
    <?php
					
					switch(intval($mes))
					{
						case "1":
							$mesA=12;
							$mesS=$mes+1;
							$anioA=$anio-1;
							$anioS=$anio;
							break;
						case "12":
							$mesA=$mes-1;
							$mesS=1;
							$anioS=$anio+1;
							$anioA=$anio;
							break;
						default:
							$mesA=$mes-1;
							$mesS=$mes+1;
							$anioS=$anio;
							$anioA=$anio;
							break;
					}
					if ($mesA==intval(date("m")))
						$diaA=intval(date("d"));
					else
						$diaA=1;
					if ($mesS==intval(date("m")))
						$diaS=intval(date("d"));
					else
						$diaS=1;
			  ?>
    <td width="0%"  class="textM10 bg"></td>
    <td width="13%"   class="textM10 bg"><?php echo "<a href='calendar.php?mes=$mesA&anio=$anioA&diasel=$diaA&fecactual=N&field=$field&form=$form' ><img border='0' src='images/calendar_izq.gif'></a>"; ?></td>
    <td width="70%" class="textM10 bg"><?php echo $NomMes." ".$anio; ?></td>
    <td width="13%"  class="textM10 bg"><?php echo "<a href='calendar.php?mes=$mesS&anio=$anioS&diasel=$diaS&fecactual=N&field=$field&form=$form' ><img border='0' src='images/calendar_der.gif'></a>"; ?></td>
    <td width="4%"  class="textM10 bg"></td>
  </tr>
  <tr>
    <td height="52%" background="../../imagenes/cua_izq_lat.gif"></td>
    <td colspan="3"><!--begin contenido  -->
        <img src="../../imagenes/grl_gisp/spacio.gif" height="5"><br>
        <table border="0" cellpadding="1" cellspacing="0" width="100%" bordercolor="#FFFFFF">
          <tr bgcolor="#CCCCCC" bordercolor="#CCCCCC">
            <td class="text10">Lu</td>
            <td class="text10">Ma</td>
            <td class="text10">Mi</td>
            <td class="text10">Ju</td>
            <td class="text10">Vi</td>
            <td class="text10">Sa</td>
            <td class="text10">Do</td>
          </tr>
          <tr>
            <?php
						 
					    for($i = 1; $i < $NumDias+1; $i++, $count++)
					    {
					        $timeStamp = strtotime("$anio-$mes-$i");
					        if($i == 1)
					        {
					        // Workout when the first day of the month is
						        $PrimerDia = date("w", $timeStamp)-1;
       
					        for($j = 0; $j < $PrimerDia; $j++, $count++)
					        	echo "<td> </td>";
					        }
       
					        if($count % 7 == 0)
					    	    echo "</tr><tr>";
       				        if(date("w", $timeStamp) == 0 )
						        if ($i!=$dia)
									$class = "class='finsemana'";
								else
									$class = "class='finsemanahoy'";
					        else
									
						        if($i == date("d") && $mes == date("m") && $anio == date("Y"))
							        $class = "class='hoy'";
						        else
							        $class = "class='normal'";
							
       						if($mashora==1)
					        echo "<td class='tr' bgcolor='#ffffff' align='center' width='25'><a href='#' onclick=\"sendToForm('".sprintf("%02d/%02d/%04d", $i, $mes, $anio)."','$field','$form');\" ><font $class>$i</font></a></td>";
							else
							echo "<td class='tr' bgcolor='#ffffff' align='center' width='25'><a href='#' onclick=\"sendToForm('".sprintf("%02d/%02d/%04d", $i, $mes, $anio)."','$field','$form');\" ><font $class>$i</font></a></td>";
    						}
						?>
          </tr>
        </table>
        <!--fin calendario  -->
    </td>
    <td background="../../imagenes/grl_gisp/cua_der_lat.gif"></td>
  </tr>
  <tr>
    <td height="9%" background="../../imagenes/grl_gisp/cua_izq_down.gif"></td>
    <td height="9%" colspan="3" background="../../imagenes/grl_gisp/cua_foot.gif"></td>
    <td height="9%" background="../../imagenes/grl_gisp/cua_der_down.gif"></td>
  </tr>
</table>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr>
    <td width="41%">&nbsp;</td>
    <td width="59%">&nbsp;</td>
  </tr>
  <tr>
    <td class="text6">Ir aL mes </td>
    <td><select name="cbomesagenda" class="text6" id="cbomesagenda"   onChange="location=cbomesagenda.options[cbomesagenda.selectedIndex].value">
        <option value="<?php echo "calendar.php?page=$page&anio=$anio&mes=1&diasel=1&fecactual=N&form=$form&field=$field"; ?>" <?php if ($mes== "1") {echo "SELECTED";} ?>>ENERO</option>
        <option value="<?php echo "calendar.php?page=$page&anio=$anio&mes=2&diasel=1&fecactual=N&form=$form&field=$field"; ?>" <?php if ($mes=="2") {echo "SELECTED";} ?>>FEBRERO</option>
        <option value="<?php echo "calendar.php?page=$page&anio=$anio&mes=3&diasel=1&fecactual=N&form=$form&field=$field"; ?>" <?php if ($mes=="3") {echo "SELECTED";} ?>>MARZO</option>
        <option value="<?php echo "calendar.php?page=$page&anio=$anio&mes=4&diasel=1&fecactual=N&form=$form&field=$field"; ?>" <?php if ($mes=="4") {echo "SELECTED";} ?>>ABRIL</option>
        <option value="<?php echo "calendar.php?page=$page&anio=$anio&mes=5&diasel=1&fecactual=N&form=$form&field=$field"; ?>" <?php if ($mes=="5") {echo "SELECTED";} ?>>MAYO</option>
        <option value="<?php echo "calendar.php?page=$page&anio=$anio&mes=6&diasel=1&fecactual=N&form=$form&field=$field"; ?>" <?php if ($mes=="6") {echo "SELECTED";} ?>>JUNIO</option>
        <option value="<?php echo "calendar.php?page=$page&anio=$anio&mes=7&diasel=1&fecactual=N&form=$form&field=$field"; ?>" <?php if ($mes=="7") {echo "SELECTED";} ?>>JULIO</option>
        <option value="<?php echo "calendar.php?page=$page&anio=$anio&mes=8&diasel=1&fecactual=N&form=$form&field=$field"; ?>" <?php if ($mes=="8") {echo "SELECTED";} ?>>AGOSTO</option>
        <option value="<?php echo "calendar.php?page=$page&anio=$anio&mes=9&diasel=1&fecactual=N&form=$form&field=$field"; ?>" <?php if ($mes=="9") {echo "SELECTED";} ?>>SEPTIEMBRE</option>
        <option value="<?php echo "calendar.php?page=$page&anio=$anio&mes=10&diasel=1&fecactual=N&form=$form&field=$field"; ?>" <?php if ($mes=="10") {echo "SELECTED";} ?>>OCTUBRE</option>
        <option value="<?php echo "calendar.php?page=$page&anio=$anio&mes=11&diasel=1&fecactual=N&form=$form&field=$field"; ?>" <?php if ($mes=="11") {echo "SELECTED";} ?>>NOVIEMBRE</option>
        <option value="<?php echo "calendar.php?page=$page&anio=$anio&mes=12&diasel=1&fecactual=N&form=$form&field=$field"; ?>"<?php if ($mes=="12") {echo "SELECTED";} ?>>DICIEMBRE</option>
    </select></td>
  </tr>
  <tr>
    <td class="text6">Ir al a&ntilde;o </td>
    <td><select name="cboanioagenda" class="text6" id="cboanioagenda"   onChange="location=cboanioagenda.options[cboanioagenda.selectedIndex].value">
        <?php
		  $f=date("Y")-60;
		  while ($f<=2030)
		  {
		  ?>
        <option  class="text6" value="<?php echo "calendar.php?page=$page&anio=$f&mes=$mes&diasel=1&fecactual=N&form=$form&field=$field"; ?>" <?php if ($anio== $f) {echo "SELECTED";} ?>><?php echo $f; ?></option>
        <?php
		  $f++;
		  }
		  
		  ?>
    </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br>
<br>
<br>
</body>
</html>