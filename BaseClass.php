<?php


class BaseClass
{
	protected static $instances = array();
	protected static $id_field = 'none';
	
	protected $fields = array();
	protected $printable_fields = array();
	
	private $html = null;
	
	
	public function __get($name)
	{
		if (isset($this->fields[$name]))
		{
			return $this->fields[$name];
		}
		elseif (is_callable(array($this, $name)))
		{
			return $this->$name();
		}
		return null;
	}
	
	public function __isset($name)
	{
		return isset($this->fields[$name]) || is_callable(array($this, $name));
	}
	
	public static function All()
	{
		return static::$instances;
	}
	
	public static function First()
	{
		//static::$instances has associative indexes. Convert them to integers starting from 0;
		$instances = array_values(static::$instances);
		return isset($instances[0]) ? $instances[0] : null;
	}
	
	public static function Dummy()
	{
		return new static();
	}
	
	public function HTML()
	{
		if (!$this->html)
		{
			$this->html = new HTML($this);
		}
		return $this->html;
	}
	
	public function Value()
	{
		if (isset($this->name))
		{
			return $this->name;
		}
		else
		{
			$id_field = self::$id_field;
			return $this->$id_field;
		}
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
	
	/**
	 * @return array
	 */
	public function getFields()
	{
		return $this->fields;
	}
	
	public function getOutputFields()
	{
		$fields = $this->getFields();
		if (empty($this->printable_fields))
		{
			return $fields;
		}
		else
		{
			$fields = array();
			foreach ($this->printable_fields as $printable_field)
			{
				$fields[$printable_field] = $this->$printable_field;
			}
			return $fields;
		}
		
	}
	
	public static function byID($id)
	{
		if (isset(static::$instances[$id]))
		{
			return static::$instances[$id];
		}
		return null;
	}
}