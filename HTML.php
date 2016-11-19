<?php


class HTML
{
	/**
	 * @var BaseClass
	 */
	private $instance;
	
	public function __construct(BaseClass $instance)
	{
		$this->instance = $instance;
	}
	
	/**
	 * @param $tag
	 * @param array $attributes
	 * @return HTMLSet
	 */
	public function many($tag, $field_label_as_value=false, array $attributes = array())
	{
		$elements = array();
		foreach ($this->instance->getOutputFields() as $field => $value)
		{
			$element = new HTMLElement($tag, $field_label_as_value ? $field : $value);
			$elements[] = $element->setAttributes($attributes);
		}
		return new HTMLSet($elements);
	}
	
	/**
	 * @param $tag
	 * @param array $attributes
	 * @return HTMLElement
	 */
	public function one($tag, array $attributes = array())
	{
		$value = $this->instance->Value();
		$element = new HTMLElement($tag, $value);
		return $element->setAttributes($attributes);
	}
	
}

class HTMLSet
{
	private $elements = array();
	
	public function __construct($elements)
	{
		$this->elements = $elements;
	}
	
	public function __toString()
	{
		$result = '';
		/** @var HTMLElement $element */
		foreach ($this->elements as $element)
		{
			$result .= (string) $element;
		}
		return $result;
	}
}

class HTMLElement
{
	private $tag;
	private $attributes;
	private $innerHTML;
	
	public function __construct($tag, $innerHTML)
	{
		$this->tag = $tag;
		$this->innerHTML = $innerHTML;
	}
	
	public function __toString()
	{
		$element = "<$this->tag";
		foreach ($this->attributes as $attribute => $value)
		{
			$value = self::escape($value);
			$element .= " $attribute=\"$value\"";
		}
		$element .= '>';
		if ($this->innerHTML)
		{
			$element .= self::escape($this->innerHTML) . "</$this->tag>";
		}
		return $element;
	}
	
	private static function escape($string)
	{
		return htmlspecialchars($string);
	}
	
	/**
	 * @param mixed $attributes
	 * @return $this
	 */
	public function setAttributes($attributes)
	{
		$this->attributes = $attributes;
		return $this;
	}
}