<?php


class BaseClass
{
	protected static $instances = array();
	
	protected $fields = array();
	
	protected static $id_field = 'none';
	
	public function __get($name)
	{
		return $this->fields[$name];
	}
	
	public static function All()
	{
		return static::$instances;
	}
	
	protected static function load_from_xml(SimpleXMLElement $xml)
	{
		$instance = new static;
		/** @var SimpleXMLElement $node */
		foreach ($xml->children() as $node)
		{
			$key = $node->getName();
			$value = (string) $node;
			$instance->fields[$key] = $value;
		}
		$id_field = static::$id_field;
		if ($instance->$id_field)
		{
			static::$instances[$instance->$id_field] = $instance;
		}
		else
		{
			static::$instances[] = $instance;
		}
	}
}