<?php

$Config = array(
	'TimesheetDataFile' => 'Timesheet.xml',

);

require_once 'BaseClass.php';
require_once 'DataFile.php';
require_once 'Project.php';
//require_once 'Task.php';

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