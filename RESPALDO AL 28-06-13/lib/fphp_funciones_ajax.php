<?php
include("fphp.php");
//mysql_select_db($database_conexion, $conexion);

if ($accion == "requerimiento_detalles_insertar") {
	if ($Tipo == "item") {
		
		$readonly = "readonly";
		$sql = "SELECT * FROM productos";
		$disabled_descripcion = "disabled";
		$CodItem = $Codigo;
		
	} 
	
	$query = mysql_query($sql) or die($sql.mysql_error());
	
	if (mysql_num_rows($query) != 0) {
		$field_detalles = mysql_fetch_array($query);
		if ($Tipo == "item" ) $nombre = $field_detalles['nombre'];
		
		?>
        <tr class="trListaBody" onclick="mClk(this, 'sel_detalles');" id="detalles_<?=$nrodetalle?>">
            <th align="center">
                <?=$nrodetalle?>
            </th>
            <td align="center">
            	<?=$Codigo?>
                <input type="hidden" name="CodItem" class="cell2" style="text-align:center;" value="<?=$CodItem?>" readonly />
                <input type="hidden" name="CommoditySub" class="cell2" style="text-align:center;" value="<?=$CommoditySub?>" readonly />
            </td>
            <td align="center">
                <textarea name="Descripcion" style="height:30px;" class="cell" onBlur="this.style.height='30px';" onFocus="this.style.height='60px';" ><?=($nombre)?></textarea>
            </td>
            <td align="center">
                <input type="text" name="CantidadPedida" class="cell" style="text-align:right; font-weight:bold;" value="0" onBlur="numeroBlur(this);" onFocus="numeroFocus(this);" />
            </td>
		</tr>
       <?
	}
}

//	--------------------------
elseif ($accion == "orden_compra_detalles_insertar") {
	if (!afectaTipoServicio($CodTipoServicio)) { $dFlagExonerado = "disabled"; $cFlagExonerado = "checked"; }
	$FechaPrometida = formatFechaAMD(getFechaFin(formatFechaDMA(substr($Ahora, 0, 10)), $_PARAMETRO['DIAENTOC']));
	if ($Tipo == "item") {
		$readonly = "readonly";
		$sql = "SELECT *, CtaGasto AS CodCuenta, PartidaPresupuestal AS cod_partida
				FROM lg_itemmast
				WHERE CodItem = '".$Codigo."'";
		$disabled_descripcion = "disabled";
		$CodItem = $Codigo;
	} else {
		$sql = "SELECT
					cs.*,
					cm.Clasificacion,
					cm.Descripcion AS NomCommodity
				FROM
					lg_commoditysub cs
					INNER JOIN lg_commoditymast cm ON (cs.CommodityMast = cm.CommodityMast)
				WHERE cs.Codigo = '".$Codigo."'";
		$CommoditySub = $Codigo;
	}
	$query = mysql_query($sql) or die(getErrorSql(mysql_errno(), mysql_error(), $sql));
	if (mysql_num_rows($query) != 0) {
		$field_detalles = mysql_fetch_array($query);
		if ($Tipo == "item" ) $Descripcion = $field_detalles['Descripcion'];
		else $Descripcion = strtoupper($field_detalles['NomCommodity']."-".$field_detalles['Descripcion']);
		echo "$field_detalles[Clasificacion]|";
		?>
        <tr class="trListaBody" onclick="mClk(this, 'sel_detalles');" id="detalles_<?=$nrodetalles?>">
			<th align="center">
				<?=$nrodetalles?>
            </th>
			<td align="center">
            	<?=$Codigo?>
                <input type="hidden" name="CodItem" class="cell2" style="text-align:center;" value="<?=$field_detalles['CodItem']?>" readonly />
                <input type="hidden" name="CommoditySub" class="cell2" style="text-align:center;" value="<?=$field_detalles['Codigo']?>" readonly />
            </td>
			<td align="center">
				<textarea name="Descripcion" style="height:30px;" class="cell"><?=($Descripcion)?></textarea>
			</td>
			<td align="center">
            	<input type="text" name="CodUnidad" value="<?=$field_detalles['CodUnidad']?>" class="cell2" style="text-align:center;" readonly />		
            </td>
			<td align="center">
            	<input type="text" name="CantidadPedida" class="cell" style="text-align:right;" value="0,00" onBlur="numeroBlur(this);" onFocus="numeroFocus(this);" onchange="setMontosOrdenCompra(this.form);" />
            </td>
			<td align="center">
            	<input type="text" name="PrecioUnit" class="cell" style="text-align:right;" value="0,00" onBlur="numeroBlur(this);" onFocus="numeroFocus(this);" onchange="setMontosOrdenCompra(this.form);" />
            </td>
			<td align="center">
            	<input type="text" name="DescuentoPorcentaje" class="cell" style="text-align:right;" value="0,00" onBlur="numeroBlur(this);" onFocus="numeroFocus(this);" onchange="setMontosOrdenCompra(this.form);" />
            </td>
			<td align="center">
            	<input type="text" name="DescuentoFijo" class="cell" style="text-align:right;" value="0,00" onBlur="numeroBlur(this);" onFocus="numeroFocus(this);" onchange="setMontosOrdenCompra(this.form);" />
            </td>
			<td align="center">
            	<input type="checkbox" name="FlagExonerado" class="FlagExonerado" onchange="setMontosOrdenCompra(this.form);" <?=$dFlagExonerado?> <?=$cFlagExonerado?> />
            </td>
			<td align="center">
            	<input type="text" name="PrecioUnitTotal" class="cell2" style="text-align:right;" value="0,00" readonly="readonly" />
            </td>
			<td align="center">
            	<input type="text" name="Total" class="cell2" style="text-align:right;" value="0,00" readonly="readonly" />
            </td>
			<td align="center">
            	<input type="text" name="FechaPrometida" value="<?=formatFechaDMA($FechaPrometida)?>" maxlength="10" style="text-align:center;" class="datepicker cell" onkeyup="setFechaDMA(this);" />
            </td>
			<td align="right">
				0,00
			</td>
			<td align="center">
				<input type="text" name="CodCentroCosto" id="CodCentroCosto_<?=$nrodetalles?>" class="cell" style="text-align:center;" value="<?=$_PARAMETRO["CCOSTOCOMPRA"]?>" />
				<input type="hidden" name="NomCentroCosto" id="NomCentroCosto_<?=$nrodetalles?>" value="<?=($field_detalles['NomCentroCosto'])?>" />
			</td>
			<td align="center">
				<?=printValoresGeneral("ESTADO-COMPRA-DETALLE", "PR")?>
            </td>
			<td align="center">
				<?=$field_detalles['cod_partida']?>
				<input type="hidden" name="cod_partida" value="<?=$field_detalles['cod_partida']?>" />
			</td>
			<td align="center">
				<?=$field_detalles['CodCuenta']?>
				<input type="hidden" name="CodCuenta" value="<?=$field_detalles['CodCuenta']?>" />
			</td>
			<td align="center">
				<textarea name="Comentarios" style="height:30px;" class="cell"></textarea>
				<input type="hidden" name="CodRequerimiento" />
				<input type="hidden" name="Secuencia" />
			</td>
		</tr>
       <?
	}
}

//	--------------------------
elseif ($accion == "orden_servicio_detalles_insertar") {
	if (!afectaTipoServicio($CodTipoServicio)) { $dFlagExonerado = "disabled"; $cFlagExonerado = "checked"; }
	$FechaEsperadaTermino = formatFechaAMD(getFechaFin(formatFechaDMA(substr($Ahora, 0, 10)), $_PARAMETRO['DIAENTOC']));
	$sql = "SELECT
				cs.*,
				cm.Clasificacion,
				cm.Descripcion AS NomCommodity
			FROM
				lg_commoditysub cs
				INNER JOIN lg_commoditymast cm ON (cs.CommodityMast = cm.CommodityMast)
			WHERE cs.Codigo = '".$Codigo."'";
	$query = mysql_query($sql) or die(getErrorSql(mysql_errno(), mysql_error(), $sql));
	if (mysql_num_rows($query) != 0) {
		$field_detalles = mysql_fetch_array($query);
		$Descripcion = strtoupper($field_detalles['NomCommodity']."-".$field_detalles['Descripcion'])
		?>
        <tr class="trListaBody" onclick="mClk(this, 'sel_detalles');" id="detalles_<?=$nrodetalles?>">
			<th align="center">
				<?=$nrodetalles?>
            </th>
			<td align="center">
            	<?=$field_detalles['Codigo']?>
                <input type="hidden" name="CodItem" />
                <input type="hidden" name="CommoditySub" class="cell2" style="text-align:center;" value="<?=$field_detalles['Codigo']?>" readonly />
            </td>
			<td align="center">
				<textarea name="Descripcion" style="height:30px;" class="cell"><?=($Descripcion)?></textarea>
			</td>
			<td align="center">
            	<input type="text" name="CantidadPedida" class="cell" style="text-align:right;" value="0,00" onBlur="numeroBlur(this);" onFocus="numeroFocus(this);" onchange="setMontosOrdenServicio(this.form);" />
            </td>
			<td align="center">
            	<input type="text" name="PrecioUnit" class="cell" style="text-align:right;" value="0,00" onBlur="numeroBlur(this);" onFocus="numeroFocus(this);" onchange="setMontosOrdenServicio(this.form);" />
            </td>
			<td align="center">
            	<input type="checkbox" name="FlagExonerado" class="FlagExonerado" onchange="setMontosOrdenServicio(this.form);" <?=$cFlagExonerado?> <?=$dFlagExonerado?> />
            </td>
			<td align="center">
            	<input type="text" name="Total" class="cell2" style="text-align:right;" value="0,00" readonly="readonly" />
            </td>
			<td align="center">
            	<input type="text" name="FechaEsperadaTermino" value="<?=formatFechaDMA($FechaEsperadaTermino)?>" maxlength="10" style="text-align:center;" class="datepicker cell" onkeyup="setFechaDMA(this);" />
            </td>
			<td align="center">
            	<input type="text" name="FechaTermino" value="<?=formatFechaDMA($FechaEsperadaTermino)?>" maxlength="10" style="text-align:center;" class="datepicker cell" onkeyup="setFechaDMA(this);" />
            </td>
			<td align="right">
				0,00
			</td>
			<td align="center">
				<input type="text" name="CodCentroCosto" id="CodCentroCosto_<?=$nrodetalles?>" maxlength="4" class="cell" style="text-align:center;" value="<?=$CodCentroCosto?>" />
				<input type="hidden" name="NomCentroCosto" id="NomCentroCosto_<?=$nrodetalles?>" />
			</td>
			<td align="center">
				<input type="hidden" name="NroActivo" />
			</td>
			<td align="center">
            	<input type="checkbox" name="FlagTerminado" <?=chkFlag("N")?> disabled="disabled" />
            </td>
			<td align="center">
				<?=$field_detalles['cod_partida']?>
				<input type="hidden" name="cod_partida" value="<?=$field_detalles['cod_partida']?>" />
			</td>
			<td align="center">
				<?=$field_detalles['CodCuenta']?>
				<input type="hidden" name="CodCuenta" value="<?=$field_detalles['CodCuenta']?>" />
			</td>
			<td align="center">
				<textarea name="Comentarios" style="height:30px;" class="cell"></textarea>
			</td>
		</tr>
       <?
	}
}

//	--------------------------
elseif ($accion == "almacen_detalles_insertar") {
	if ($FlagManual != "S") $dPrecioUnit = "disabled";
	##	consulto
	$sql = "SELECT
				i.CodItem,
				i.Descripcion,
				i.CodUnidad,
				iai.StockActual
			FROM
				lg_itemmast i
				LEFT JOIN lg_itemalmaceninv iai ON (iai.CodItem = i.CodItem AND
													iai.CodAlmacen = '".$CodAlmacen."')
			WHERE i.CodItem = '".$CodItem."'";
	$query = mysql_query($sql) or die(getErrorSql(mysql_errno(), mysql_error(), $sql));
	if (mysql_num_rows($query) != 0) {
		$field_detalle = mysql_fetch_array($query);
		?>
        <tr class="trListaBody" onclick="mClk(this, 'sel_detalles');" id="detalles_<?=$nrodetalles?>">
			<th align="center">
				<?=$nrodetalles?>
            </th>
			<td align="center">
                <input type="text" name="CodItem" class="cell2" style="text-align:center;" value="<?=$field_detalle['CodItem']?>" readonly />
            </td>
			<td align="center">
				<textarea name="Descripcion" style="height:30px;" class="cell" readonly="readonly"><?=($field_detalle['Descripcion'])?></textarea>
			</td>
			<td align="center">
            	<input type="text" name="CodUnidad" value="<?=$field_detalle['CodUnidad']?>" class="cell2" style="text-align:center;" readonly />		
            </td>
			<td align="center">
            	<input type="text" name="StockActual" class="cell2" style="text-align:right;" value="<?=number_format($field_detalle['StockActual'], 2, ',', '.')?>" readonly="readonly" />
            </td>
			<td align="center">
            	<input type="text" name="CantidadRecibida" class="cell" style="text-align:right;" value="0,00" onBlur="numeroBlur(this);" onFocus="numeroFocus(this);" onchange="setMontosAlmacen(this.form);" />
            </td>
			<td align="center">
            	<input type="text" name="PrecioUnit" class="cell PrecioUnit" style="text-align:right;" value="0,00" onBlur="numeroBlur(this);" onFocus="numeroFocus(this);" onchange="setMontosAlmacen(this.form);" <?=$dPrecioUnit?> />
            </td>
			<td align="center">
            	<input type="text" name="Total" class="cell2" style="text-align:right;" value="0,00" readonly="readonly" />
            </td>
			<td align="center">
            	<input type="hidden" name="CodCentroCosto" value="<?=$CodCentroCosto?>" />
            	<input type="text" name="ReferenciaCodDocumento" value="<?=$CodDocumentoReferencia?>" class="cell" style="text-align:center; width:15%;" />
            	<input type="text" name="ReferenciaNroDocumento" value="<?=$NroDocumentoReferencia?>" class="cell" style="width:65%;" />
            	<input type="text" name="ReferenciaSecuencia" value="<?=$nrodetalles?>" class="cell" style="text-align:center; width:10%;" />
			</td>
		</tr>
       <?
	}
}

//	--------------------------
elseif ($accion == "commodity_detalles_insertar") {
	if ($FlagManual != "S") $dPrecioUnit = "disabled";
	##	consulto
	$sql = "SELECT
				i.Codigo AS CommoditySub,
				i.Descripcion,
				i.CodUnidad,
				iai.Cantidad AS StockActual
			FROM
				lg_commoditysub i
				LEFT JOIN lg_commoditystock iai ON (iai.CommoditySub = i.CommoditySub AND
													iai.CodAlmacen = '".$CodAlmacen."')
			WHERE i.Codigo = '".$CommoditySub."'";
	$query = mysql_query($sql) or die(getErrorSql(mysql_errno(), mysql_error(), $sql));
	if (mysql_num_rows($query) != 0) {
		$field_detalle = mysql_fetch_array($query);
		?>
        <tr class="trListaBody" onclick="mClk(this, 'sel_detalles');" id="detalles_<?=$nrodetalles?>">
			<th align="center">
				<?=$nrodetalles?>
            </th>
			<td align="center">
                <input type="text" name="CommoditySub" class="cell2" style="text-align:center;" value="<?=$field_detalle['CommoditySub']?>" readonly />
            </td>
			<td align="center">
				<textarea name="Descripcion" style="height:30px;" class="cell" readonly="readonly"><?=($field_detalle['Descripcion'])?></textarea>
			</td>
			<td align="center">
            	<input type="text" name="CodUnidad" value="<?=$field_detalle['CodUnidad']?>" class="cell2" style="text-align:center;" readonly />		
            </td>
			<td align="center">
            	<input type="text" name="StockActual" class="cell2" style="text-align:right;" value="<?=number_format($field_detalle['StockActual'], 2, ',', '.')?>" readonly="readonly" />
            </td>
			<td align="center">
            	<input type="text" name="CantidadRecibida" class="cell" style="text-align:right;" value="0,00" onBlur="numeroBlur(this);" onFocus="numeroFocus(this);" onchange="setMontosAlmacen(this.form);" />
            </td>
			<td align="center">
            	<input type="text" name="PrecioUnit" class="cell PrecioUnit" style="text-align:right;" value="0,00" onBlur="numeroBlur(this);" onFocus="numeroFocus(this);" onchange="setMontosAlmacen(this.form);" <?=$dPrecioUnit?> />
            </td>
			<td align="center">
            	<input type="text" name="Total" class="cell2" style="text-align:right;" value="0,00" readonly="readonly" />
            </td>
			<td align="center">
            	<input type="hidden" name="CodCentroCosto" value="<?=$CodCentroCosto?>" />
            	<input type="text" name="ReferenciaCodDocumento" value="<?=$CodDocumentoReferencia?>" class="cell" style="text-align:center; width:15%;" />
            	<input type="text" name="ReferenciaNroDocumento" value="<?=$NroDocumentoReferencia?>" class="cell" style="width:65%;" />
            	<input type="text" name="ReferenciaSecuencia" value="<?=$nrodetalles?>" class="cell" style="text-align:center; width:10%;" />
			</td>
		</tr>
       <?
	}
}

//	--------------------------
elseif ($accion == "fideicomiso_calculo_empleado_sel") {
	list($Anio, $Mes, $Dia) = split("[/.-]", substr($Ahora, 0, 10));
	//	consulto los datos del empleado
	$sql = "SELECT
				mp.CodPersona,
				mp.NomCompleto,
				mp.Ndocumento,
				me.CodEmpleado,
				me.Fingreso
			FROM
				mastpersonas mp
				INNER JOIN mastempleado me ON (mp.CodPersona = me.CodPersona)
			WHERE mp.CodPersona = '".$CodPersona."'";
	$query = mysql_query($sql) or die(getErrorSql(mysql_errno(), mysql_error(), $sql));
	if (mysql_num_rows($query) != 0) $field = mysql_fetch_array($query);
	list($Anios, $Meses, $Dias) = getTiempo(formatFechaDMA($field['Fingreso']), "$Dia-$Mes-$Anio");
	echo "$field[CodEmpleado]|$field[CodPersona]|$field[NomCompleto]|$field[Ndocumento]|$Anios|$Meses|$Dias|".formatFechaDMA($field['Fingreso']);
}

//	--------------------------
elseif ($accion == "vacaciones_insertar_linea") {
	if ($UltimaFechaTermino != "") {
		$NroDias = $NroDias - $TotalDias;
		$FechaSalida = getFechaFinHabiles($UltimaFechaTermino, 2);
	}
	if ($NroDias > $Pendientes) {
		$Dias = $Pendientes;
		$FechaTermino = getFechaFinHabiles($FechaSalida, $Dias);
	} else {
		$Dias = $NroDias;
	}
	?>
	<tr class="trListaBody" onclick="mClk(this, 'sel_detalles');" id="<?=$NroPeriodo?>">
		<th>
           <input type="text" name="NroPeriodo" id="NroPeriodo_<?=$i?>" class="cell2" style="text-align:center;" value="<?=$NroPeriodo?>" readonly />
		</th>
		<td align="center">
           <input type="checkbox" name="FlagUtlizarPeriodo" checked="checked" disabled="disabled" />
		</td>
        <td align="center"><?=$Anio?> - <?=$Anio+1?></td>
		<td>
           <input type="text" name="NroDias" id="NroDias_<?=$i?>" class="cell" style="text-align:right;" value="<?=number_format($Dias, 2, ',', '.')?>" onchange="obtenerFechaTerminoVacacionDetalle('<?=$i?>');" onfocus="numeroFocus(this);" onblur="numeroBlur(this);" />
		</td>
		<td>
           <input type="text" name="FechaInicio" id="FechaInicio_<?=$i?>" maxlength="10" style="text-align:center;" class="cell datepicker" onkeyup="setFechaDMA(this);" value="<?=$FechaSalida?>" onchange="obtenerFechaTerminoVacacionDetalle('<?=$i?>');" />
		</td>
		<td>
           <input type="text" name="FechaFin" id="FechaFin_<?=$i?>" maxlength="10" style="text-align:center;" class="cell datepicker" onkeyup="setFechaDMA(this);" value="<?=$FechaTermino?>" />
		</td>
		<td>
           <input type="text" name="Derecho" id="Derecho_<?=$i?>" class="cell2" style="text-align:right;" value="<?=number_format($Derecho, 2, ',', '.')?>" readonly />
		</td>
		<td>
           <input type="text" name="TotalUtilizados" id="TotalUtilizados_<?=$i?>" class="cell2" style="text-align:right;" value="<?=number_format($TotalUtilizados, 2, ',', '.')?>" readonly />
		</td>
		<td>
           <input type="text" name="Pendientes" id="Pendientes_<?=$i?>" class="cell2" style="text-align:right;" value="<?=number_format($Pendientes, 2, ',', '.')?>" readonly />
		</td>
		<td>
			<textarea name="Observaciones" class="cell" style="height:20px;" disabled="disabled"></textarea>
			<input type="hidden" name="Secuencia" />
		</td>
	</tr>
   <?
}

//	--------------------------
elseif ($accion == "selListadoVacacionPeriodo") {
	$sql = "SELECT
				(SUM(vp.Derecho) - SUM(vp.DiasGozados) + SUM(vp.DiasInterrumpidos)) AS Pendientes,
				o.CodOrganismo,
				o.Organismo,
				d.CodDependencia,
				d.Dependencia
			FROM
				rh_vacacionperiodo vp
				LEFT JOIN mastpersonas p ON (p.CodPersona = vp.CodPersona)
				LEFT JOIN mastempleado e ON (e.CodPersona = p.CodPersona)
				LEFT JOIN mastdependencias d ON (d.CodDependencia = e.CodDependencia)
				LEFT JOIN mastorganismos o ON (o.CodOrganismo = d.CodOrganismo)
			WHERE vp.CodPersona = '".$CodPersona."'
			GROUP BY vp.CodPersona";
	$query = mysql_query($sql) or die(getErrorSql(mysql_errno(), mysql_error(), $sql));
	if (mysql_num_rows($query) != 0) $field = mysql_fetch_array($query);
	echo number_format($field['Pendientes'], 2, ',', '.')."|"."<option value='$field[CodOrganismo]'>$field[Organismo]</option>"."|"."<option value='$field[CodDependencia]'>$field[Dependencia]</option>|";
	//	---------------------
	$NroDias = $field['Pendientes'];
	//	empleado
	$sql = "SELECT Fingreso
			FROM mastempleado
			WHERE CodPersona = '".$CodPersona."'";
	$query_empleado = mysql_query($sql) or die(getErrorSql(mysql_errno(), mysql_error(), $sql));
	if (mysql_num_rows($query_empleado)) $field_empleado = mysql_fetch_array($query_empleado);
	
	//	obtengo los valores almacenados del empleado para el periodo
	$sql = "SELECT
				NroPeriodo,
				Anio,
				Mes,
				Derecho,
				PendientePeriodo,
				DiasGozados,
				DiasTrabajados,
				DiasInterrumpidos,
				DiasNoGozados,
				TotalUtilizados,
				Pendientes
			FROM rh_vacacionperiodo
			WHERE CodPersona = '".$CodPersona."'";
	$query_periodo = mysql_query($sql) or die(getErrorSql(mysql_errno(), mysql_error(), $sql));	$i=0;
	while ($field_periodo = mysql_fetch_array($query_periodo)) {
		$NroPeriodo[$i] = $field_periodo['NroPeriodo'];
		$Anio[$i] = $field_periodo['Anio'];
		$Mes[$i] = $field_periodo['Mes'];
		$Derecho[$i] = $field_periodo['Derecho'];
		$PendientePeriodo[$i] = $field_periodo['PendientePeriodo'];
		$DiasGozados[$i] = $field_periodo['DiasGozados'];
		$DiasTrabajados[$i] = $field_periodo['DiasTrabajados'];
		$DiasInterrumpidos[$i] = $field_periodo['DiasInterrumpidos'];
		$DiasNoGozados[$i] = $field_periodo['DiasNoGozados'];
		$TotalUtilizados[$i] = $DiasGozados[$i] - $DiasInterrumpidos[$i];		//$field_periodo['TotalUtilizados'];
		$Pendientes[$i] = $field_periodo['Pendientes'];
		$i++;
	}
	
	//	tiempo de servicio
	list($AnioActual, $MesActual, $DiaActual) = split("[/.-]", substr($Ahora, 0, 10));
	list($AnioIngreso, $MesIngreso, $DiaIngreso) = split("[/.-]", $field_empleado['Fingreso']);
	list($Anios, $Meses, $Dias) = getTiempo(formatFechaDMA($field_empleado['Fingreso']), "$DiaActual-$MesActual-$AnioActual");
	$NroPeriodos = $Anios;
	
	//	recorro los periodos y almaceno
	$FechaInicio = $FechaSalida;
	$Distribucion = $NroDias;
	$Quinquenios = 0;
	$Pendiente = 0;
	$Seleccionable = false;
	for($i=0; $i<$NroPeriodos; $i++) {
		$Anio[$i] = $AnioIngreso + $i;
		if ($NroPeriodo[$i] == "") {
			$NroPeriodo[$i] = $i + 1;
			$Mes[$i] = $MesIngreso;
			##	obtengo los dias de derecho
			if ($i > 0 && $i % 5 == 0) ++$Quinquenios;
			$Derecho[$i] = $_PARAMETRO['DERECHO'] + $i + $Quinquenios;
			$PendientePeriodo[$i] += $Pendientes[$i-1];
			$DiasGozados[$i] = 0;
			$DiasTrabajados[$i] = 0;
			$DiasInterrumpidos[$i] = 0;
			$TotalUtilizados[$i] = 0;
		}
		$Pendientes[$i] = $Derecho[$i] - $TotalUtilizados[$i];
		if ($Pendientes[$i] > 0 && $Distribucion > 0) {
			if ($Pendientes[$i] > $Distribucion) $Dias = $Distribucion; else $Dias = $Pendientes[$i];
			$Distribucion -= $Dias;
			$FechaFin = getFechaFinHabiles($FechaInicio, $Dias);
			?>
			<tr class="trListaBody" onclick="mClk(this, 'sel_detalles');" id="<?=$NroPeriodo[$i]?>">
				<th>
				   <input type="text" name="NroPeriodo" id="NroPeriodo_<?=$i?>" class="cell2" style="text-align:center;" value="<?=$NroPeriodo[$i]?>" readonly />
				</th>
				<td align="center">
				   <input type="checkbox" name="FlagUtlizarPeriodo" checked="checked" disabled="disabled" />
				</td>
				<td align="center"><?=$Anio[$i]?> - <?=$Anio[$i]+1?></td>
				<td>
				   <input type="text" name="NroDias" id="NroDias_<?=$i?>" class="cell" style="text-align:right;" value="<?=number_format($Dias, 2, ',', '.')?>" onchange="obtenerFechaTerminoVacacionDetalle('<?=$i?>');" onfocus="numeroFocus(this);" onblur="numeroBlur(this);" disabled="disabled" />
				</td>
				<td>
				   <input type="text" name="FechaInicio" id="FechaInicio_<?=$i?>" maxlength="10" style="text-align:center;" class="cell datepicker" onkeyup="setFechaDMA(this);" value="<?=$FechaInicio?>" onchange="obtenerFechaTerminoVacacionDetalle('<?=$i?>');" disabled="disabled" />
				</td>
				<td>
				   <input type="text" name="FechaFin" id="FechaFin_<?=$i?>" maxlength="10" style="text-align:center;" class="cell datepicker" onkeyup="setFechaDMA(this);" value="<?=$FechaFin?>" disabled="disabled" />
				</td>
				<td>
				   <input type="text" name="Derecho" id="Derecho_<?=$i?>" class="cell2" style="text-align:right;" value="<?=number_format($Derecho[$i], 2, ',', '.')?>" readonly />
				</td>
				<td>
				   <input type="text" name="TotalUtilizados" id="TotalUtilizados_<?=$i?>" class="cell2" style="text-align:right;" value="<?=number_format($v, 2, ',', '.')?>" readonly />
				</td>
				<td>
				   <input type="text" name="Pendientes" id="Pendientes_<?=$i?>" class="cell2" style="text-align:right;" value="<?=number_format($Pendientes[$i], 2, ',', '.')?>" readonly />
				</td>
				<td>
					<textarea name="Observaciones" class="cell" style="height:20px;" disabled="disabled"></textarea>
					<input type="hidden" name="Secuencia" />
				</td>
			</tr>
			<?
			$FechaInicio = getFechaFinHabiles($FechaFin, 2);
		}
	}
	$FechaIncorporacion = getFechaFinHabiles($FechaFin, 2);
	echo "|$FechaFin|$FechaIncorporacion";
}

//	--------------------------
elseif ($accion == "requerimientos_cargo_selector") {
	//	evaluacion
	$sql = "SELECT
				e.Descripcion,
				e.Plantilla,
				ce.Etapa,
				ce.Evaluacion
			FROM
				rh_cargoevaluacion ce
				INNER JOIN rh_evaluacion e ON (e.Evaluacion = ce.Evaluacion)
			WHERE ce.CodCargo = '".$CodCargo."'";
    $query_evaluacion = mysql_query($sql) or die ($sql.mysql_error());	$nro_evaluacion=0;
    while ($field_evaluacion = mysql_fetch_array($query_evaluacion)) {	$nro_evaluacion++;
        ?>
        <tr class="trListaBody" onclick="mClk(this, 'sel_evaluacion');" id="evaluacion_<?=$field_evaluacion['Evaluacion']?>">
            <th>
            	<input type="hidden" name="Secuencia" value="<?=$nro_evaluacion?>" />
            	<input type="hidden" name="Evaluacion" value="<?=$field_evaluacion['Evaluacion']?>" />
            	<input type="hidden" name="Etapa" value="<?=$field_evaluacion['Etapa']?>" />
            	<input type="hidden" name="PlantillaEvaluacion" value="<?=$field_evaluacion['Plantilla']?>" />
				<?=$nro_evaluacion?>
            </th>
            <td>
                <?=$field_evaluacion['Descripcion']?>
            </td>
            <td align="center">
                <?=$field_evaluacion['Etapa']?>
            </td>
        </tr>
        <?
    }
	echo "|$nro_evaluacion|";
	printBodyCompetenciasCargo($CodCargo, "E", 150, 8);
}

//	--------------------------
elseif ($accion == "insertar_linea_evaluacion") {
	//	evaluacion
	$sql = "SELECT * FROM rh_evaluacion WHERE Evaluacion = '".$Evaluacion."'";
    $query_evaluacion = mysql_query($sql) or die ($sql.mysql_error());
    while ($field_evaluacion = mysql_fetch_array($query_evaluacion)) {
        ?>
        <tr class="trListaBody" onclick="mClk(this, 'sel_evaluacion');" id="evaluacion_<?=$field_evaluacion['Evaluacion']?>">
            <th>
            	<input type="hidden" name="Secuencia" value="<?=$nro_detalles?>" />
            	<input type="hidden" name="Evaluacion" value="<?=$field_evaluacion['Evaluacion']?>" />
            	<input type="hidden" name="Etapa" value="<?=$field_evaluacion['Etapa']?>" />
            	<input type="hidden" name="PlantillaEvaluacion" value="<?=$field_evaluacion['Plantilla']?>" />
				<?=$nro_detalles?>
            </th>
            <td>
                <?=$field_evaluacion['Descripcion']?>
            </td>
            <td align="center">
                <?=$field_evaluacion['Etapa']?>
            </td>
        </tr>
        <?
    }
}

//	--------------------------
elseif ($accion == "insertar_linea_postulante") {
	//	evaluacion
	$sql = "SELECT
				e.CodEmpleado,
				p.CodPersona,
				p.NomCompleto
			FROM
				mastpersonas p
				INNER JOIN mastempleado e ON (e.CodPersona = p.CodPersona)
			WHERE
				CodPersona = '".$CodPersona."'";
    $query_candidato = mysql_query($sql) or die ($sql.mysql_error());
    while ($field_candidato = mysql_fetch_array($query_candidato)) {
        ?>
        <tr class="trListaBody" onclick="mClk(this, 'sel_candidato');" id="I-<?=$field_candidato['CodPersona']?>">
            <th>
            	<input type="hidden" name="TipoPostulante" value="I" />
            	<input type="hidden" name="Postulante" value="<?=$field_candidato['CodPersona']?>" />
				<?=$nro_detalles?>
            </th>
            <td align="center">
                <?=$field_candidato['CodPersona']?>
            </td>
            <td>
                <?=$field_candidato['NomCompleto']?>
            </td>
        </tr>
        <?
    }
}

//	-------------------------------
//	obtener la edad a partir de una fecha
elseif ($accion == "getEdad") {
	list($Anios, $Meses, $Dias) = getEdad($FechaDesde, $FechaHasta);
	echo "$Anios|$Meses|$Dias";
}

//	-------------------------------
//	eliminar
elseif ($accion == "unlink") {
	unlink($url);
}

//	-------------------------------
//	inserto linea de participante en capacitaciones
elseif ($accion == "insertar_linea_participantes") {
	//	persona
	$sql = "SELECT
				p.CodPersona,
				p.NomCompleto,
				e.CodEmpleado,
				e.CodDependencia
			FROM
				mastpersonas p 
				INNER JOIN mastempleado e ON (e.CodPersona = p.CodPersona)
			WHERE p.CodPersona = '".$CodPersona."'";
	$query = mysql_query($sql) or die(getErrorSql(mysql_errno(), mysql_error(), $sql));
    while ($field = mysql_fetch_array($query)) {
        ?>
        <tr class="trListaBody" onclick="mClk(this, 'sel');" id="participantes_<?=$nro_detalles?>">
            <th>
            	<input type="hidden" name="CodPersona" value="<?=$field['CodPersona']?>" />
            	<input type="hidden" name="CodDependencia" value="<?=$field['CodDependencia']?>" />
				<?=$nro_detalles?>
            </th>
            <td align="center">
                <?=$field['CodEmpleado']?>
            </td>
            <td>
                <?=htmlentities($field['NomCompleto'])?>
            </td>
            <td align="center">
            	0
            </td>
            <td align="center">
            	0
            </td>
            <td align="center">
            	0
            </td>
            <td align="center">
            	<?=printFlag("N")?>
            </td>
            <td align="center">
            	0
            </td>
            <td align="right">
            	0,00
            </td>
        </tr>
        <?
    }
}

//	-------------------------------
//	obtener fecha fin a partir de una fecha inicial + dias
elseif ($accion == "obtenerFechaFin") {
	die(obtenerFechaFin($FechaInicial, $Dias));
}

//	-------------------------------
//	inserto linea
elseif ($accion == "competencias_plantilla_insertar") {
	//	persona
	$sql = "SELECT Competencia, Descripcion FROM rh_evaluacionfactores WHERE Competencia = '".$Competencia."'";
	$query = mysql_query($sql) or die(getErrorSql(mysql_errno(), mysql_error(), $sql));
    while ($field = mysql_fetch_array($query)) {
        ?>
        <tr class="trListaBody" onclick="mClk(this, 'sel_competencias');" id="competencias_<?=$field['Competencia']?>">
            <th>
				<?=$nro_detalles?>
            </th>
            <td>
            	<input type="text" name="Competencia" class="cell" style="text-align:center;" value="<?=$field['Competencia']?>" />
            </td>
            <td>
            	<?=$field['Descripcion']?>
            </td>
            <td>
            	<input type="text" name="Peso" class="cell" style="text-align:center;" maxlength="4" />
            </td>
            <td>
            	<input type="text" name="FactorParticipacion" class="cell" style="text-align:center;" maxlength="4" />
            </td>
            <td align="center">
            	<input type="checkbox" name="FlagPotencial" <?=chkFlag('N')?> />
            </td>
            <td align="center">
            	<input type="checkbox" name="FlagCompetencia" <?=chkFlag('N')?> />
            </td>
            <td align="center">
            	<input type="checkbox" name="FlagConceptual" <?=chkFlag('N')?> />
            </td>
        </tr>
        <?
    }
}
?>