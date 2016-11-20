<?php

/**
 * Class Task
 * @property $taskId
 * @property $projectId
 * @property $description
 * @property $location
 * @property $startDate
 * @property $endDate
 * @property $distance
 * @property $feeling
 * @property $billable
 * @property $paid
 * @property $rateId
 * @property $deleted
 * @property $lastUpdate
 * @property $type
 * @property $startTime
 * @property $endTime
 */
class Task extends BaseClass
{
	protected static $id_field = 'none';
	protected static $instances = array();
	
	protected $fields = array(
		'taskId' => null,
		'projectId' => null,
		'description' => null,
		'location' => null,
		'startDate' => null,
		'endDate' => null,
		'distance' => null,
		'feeling' => null,
		'billable' => null,
		'paid' => null,
		'rateId' => null,
		'deleted' => null,
		'lastUpdate' => null,
		'type' => null,
		'startTime' => null,
		'endTime' => null,
	);
	
	protected $printable_fields = array(
		'description',
		'Duration',
		'Hours',
		
	);
	
	protected static $xml_element = 'tasks';
	
	protected static $default_sort = 'startDate';
	
	/**
	 * @var Relation_1toN
	 */
	private $breaks;
	
	public static function getByProject(Project $project)
	{
		return static::getManyByField('projectId', $project->projectId);
	}
	
	public function Duration()
	{
		return gmdate('H:i', $this->getDurationSeconds());
	}
	
	public function Hours()
	{
		return round($this->getDurationSeconds() / 60 / 60,2);
	}
	
	public function getDurationSeconds($subtract_breaks = true)
	{
		$seconds = strtotime($this->endDate) - strtotime($this->startDate);
		if ($subtract_breaks) $seconds -= $this->getBreakSeconds();
		return $seconds;
	}
	
	public function getBreakSeconds()
	{
		return $this->Breaks()->sum('getDurationSeconds');
	}
	
	/**
	 * @return null|Relation_1toN
	 */
	public function Breaks()
	{
		if (!$this->breaks)
		{
			$this->breaks = new Relation_1toN($this, TaskBreak::getByTask($this));
		}
		return $this->breaks;
	}
}