<?php

namespace App\Traits;

use Carbon\Carbon;

trait FechaTrait
{

	/**retorna el mes en texto segun el mes*/
	public function getMesText($value)
	{

		$value = (int) $value;

		$meses = array(
			"enero", "febrero", "marzo", "abril",
			"mayo", "junio", "julio", "agosto",
			"septiembre", "octubre", "noviembre", "diciembre"
		);

		return $meses[($value) - 1];
	}
	/**retorna el mes en texto segun el mes*/
	public function translateInglesToSpainNameDay($value)
	{
		$value = strtoupper($value);
		$dias = [
			"MONDAY" => "Lunes", "TUESDAY" => "Martes",
			"WEDNESDAY" => "Miercoles", "THURSDAY" => "Jueves",
			"FRIDAY" => "Viernes", "SATURDAY" => "Sabado", "SUNDAY" => "Domingo"
		];
		return $dias[$value];
	}

	/** retorna el ultimo dia segun el mes y año**/
	function getLastMonthDay($year, $month)
	{

		$day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));

		return date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
	}

	/** retorna el primer dia segun mes y año **/
	function getFirstMonthDay($year, $month)
	{

		return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
	}

	function getMonthDays($year, $month)
	{

		return date("t", mktime(0, 0, 0, $month, 1, $year));
	}

	public function getRangoMonthYear($fecha_inicio, $meses)
	{

		$meses_vacacion = [];

		$i = 0;

		while ($i < $meses) {

			$periodo = $fecha_inicio->format('Y');
			$mes = $fecha_inicio->format('m');

			$value = ['id' => $periodo . $mes, 'descripcion' => strtoupper($this->getMesText($mes)) . '-' . $periodo];
			array_push($meses_vacacion, $value);
			$fecha_inicio->addMonths(1);
			$i++;
		}

		return $meses_vacacion;
	}

	// metodos generales con fechas

	/**
	 * Retorna una fecha formateada para guardar en base de datos.
	 *
	 * @param  \Date  $value formato 'd/m/Y'
	 * @return \Date  $value formato 'Y-m-d'
	 */

	public function getCreateFromFormatByDBTrait($value)
	{
		return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
	}

	/**
	 * Retorna una fecha formateada.
	 *
	 * @param  \Date  	$value
	 * @param  \String  $format
	 * @return \Date  	$value formateado
	 */

	public function getFormatTrait($value, $format)
	{
		return Carbon::parse($value)->format($format);
	}

	/**
	 * Retorna la edad a partir de una fecha.
	 *
	 * @param  \Date  $value
	 * @return int  $edad	 
	 */
	public function getAgeTrait($value)
	{
		$value = $this->getFormatTrait($value, 'Y-m-d');
		return Carbon::parse($value)->age;
	}

	/**
	 * Retorna la fecha actual.
	 *
	 * @return \Date  $fecha_actual
	 */

	public function getFechaActualTrait()
	{
		return Carbon::now()->format('Y-m-d');
	}

	/**
	 * Retorna la fecha hora actual.
	 *
	 * @return \Carbon\Carbon 
	 */

	public function getFechaHoraActualTrait()
	{
		return Carbon::now();
	}

	/**
	 * Retorna parseado.
	 *
	 * @return \Carbon\Carbon
	 */
	public function getParseTrait($value)
	{
		return Carbon::parse($value);
	}

	/**
	 * Retorna arreglo de todos los días entre las fechas indicadas.
	 *
	 * @return \Array 
	 */
	public function getEntreFechas($fechaInicio, $fechaFin)
	{
		$fechaInicio = Carbon::parse($fechaInicio);
		$fechaFin = Carbon::parse($fechaFin);
		$fechas = [];
		while ($fechaInicio <= $fechaFin) {
			$fechas[] = [
				'fecha' => $fechaInicio->toDateString(),
				'dia' => $this->translateInglesToSpainNameDay($fechaInicio->formatLocalized('%A')),
			];
			$fechaInicio->addDay();
		}
		return $fechas;
	}
}
