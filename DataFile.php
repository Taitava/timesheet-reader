<?php


/**
 * Class DataFile
 * @method static SimpleXMLElement Projects()
 */
class DataFile
{
	/**
	 * @var null|SimpleXMLElement
	 */
	private static $xml = null;
	
	public static function Load()
	{
		$loaded_xml = simplexml_load_file(Config::TimesheetDataFile());
		if (is_object($loaded_xml))
		{
			self::$xml = $loaded_xml;
			return true;
		}
		else
		{
			self::$xml = null;
			return false;
		}
	}
	
	public static function __callStatic($name, $arguments)
	{
		if (!is_object(self::$xml)) throw new Exception('XML DataFile must be loaded before accessing data records.');
		$name = strtolower($name);
		return self::$xml->$name;
	}
	
	public static function xml()
	{
		return self::$xml;
	}
}