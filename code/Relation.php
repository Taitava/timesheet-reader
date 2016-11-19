<?php


class Relation_1toN
{
	private $relation_1 = null;
	
	private $relation_n = array();
	
	public function __construct($relation_1, array $relation_n)
	{
		$this->relation_1 = $relation_1;
		$this->relation_n = $relation_n;
	}
	
	public function count()
	{
		return count($this->relation_n);
	}
	
	public function Sort($field, $order = 'ASC')
	{
		$sort_instances = $this->relation_n;
		uasort($sort_instances, function (BaseClass $instance_a, BaseClass $instance_b) use ($field, $order)
		{
			return BaseClass::SortComparisonMethod($instance_a, $instance_b, $field, $order);
		});
		return $sort_instances;
	}
	
	public function items()
	{
		return $this->relation_n;
	}
}