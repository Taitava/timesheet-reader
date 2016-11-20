<?php


/**
 * Class Project
 * @property $projectId
 * @property $name
 * @property $description
 * @property $employer
 * @property $location
 * @property $status
 * @property $salary
 * @property $color
 * @property $order
 * @property $deleted
 * @property $lastUpdate
 * @property $tracking
 * @property $network
 */
class Project extends BaseClass
{
	protected static $instances = array();
	protected static $xml_element = 'projects';
	protected static $id_field = 'projectId';
	
	/**
	 * @var null|Relation_1toN
	 */
	private $tasks = null;
	
	/**
	 * @var null|Relation_1toN
	 */
	private $combined_tasks = null;
	
	protected $fields = array(
		'projectId' => null,
		'name' => null,
		'description' => null,
		'employer' => null,
		'location' => null,
		'status' => null,
		'salary' => null,
		'color' => null,
		'order' => null,
		'deleted' => null,
		'lastUpdate' => null,
		'tracking' => null,
		'network' => null,
	);
	
	protected $printable_fields = array(
		//'projectId',
		'name',
		'description',
		'employer',
		'location',
		'status',
		'salary',
		'lastUpdateFormatted',
		'CountTasks',
	);
	
	public function lastUpdateFormatted($format = 'j.n.Y')
	{
		$seconds = $this->lastUpdate / 1000;
		return date($format, $seconds);
	}
	
	/**
	 * @return null|Relation_1toN
	 */
	public function Tasks()
	{
		if (!$this->tasks)
		{
			$this->tasks = new Relation_1toN($this, Task::getByProject($this));
		}
		return $this->tasks;
	}
	
	/**
	 * @return null|Relation_1toN
	 */
	public function CombinedTasks()
	{
		if (!$this->combined_tasks)
		{
			$this->combined_tasks = new Relation_1toN($this, CombinedTask::CombineProjectTasks($this));
		}
		return $this->combined_tasks;
	}
	
	public function CountTasks()
	{
		return $this->Tasks()->count();
	}
	
}