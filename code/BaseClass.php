<?php


abstract class BaseClass
{
	protected static $id_field = 'none';
	protected static $xml_element = '';
	protected static $default_sort = null;
	
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
			$id_field = static::$id_field;
			return $this->$id_field;
		}
	}
	
	public static function Load()
	{
		foreach (DataFile::getElement(static::$xml_element)->children() as $instance)
		{
			static::load_from_xml($instance);
		}
		if (static::$default_sort)
		{
			if (is_array(static::$default_sort))
			{
				static::$instances = static::Sort(static::$default_sort[0], static::$default_sort[1]);
			}
			else
			{
				static::$instances = static::Sort(static::$default_sort);
			}
		}
	}
	
	private static function load_from_xml(SimpleXMLElement $xml)
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
		return $instance;
	}
	
	public function ClassName()
	{
		return get_class($this);
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
	
	public static function Sort($field, $order = 'ASC')
	{
		$sort_instances = static::$instances;
		uasort($sort_instances, function (BaseClass $instance_a, BaseClass $instance_b) use ($field, $order)
		{
			return BaseClass::SortComparisonMethod($instance_a, $instance_b, $field, $order);
		});
		return $sort_instances;
	}
	
	public static function SortComparisonMethod(BaseClass $instance_a, BaseClass $instance_b, $field, $order)
	{
		$order = strtoupper($order);
		$value_a = $instance_a->$field;
		$value_b = $instance_b->$field;
		$direction = ($order == 'ASC') ? 1 : -1;
		if ($value_a > $value_b)
		{
			return $direction;
		}
		elseif ($value_a < $value_b)
		{
			return -$direction;
		}
		else
		{
			return 0;
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
	
	public static function getManyByField($field, $value)
	{
		$instances = array();
		/** @var BaseClass $instance */
		foreach (static::$instances as $instance)
		{
			if ($instance->$field == $value)
			{
				$instances[] = $instance;
			}
		}
		return $instances;
	}
	
	public static function getOneByField($field, $value)
	{
		$instances = static::getManyByField($field, $value);
		return empty($instances) ? null : $instances[0];
	}
}