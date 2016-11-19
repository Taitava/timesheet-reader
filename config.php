<?php

$Config = array(
	'TimesheetDataFile' => 'Timesheet.xml',

);

/**
 * Class Config
 * @method static string TimesheetDataFile()
 */
class Config
{
	public static function __callStatic($name, $arguments)
	{
		global $Config;
		return isset($Config[$name]) ? $Config[$name] : null;
	}
}