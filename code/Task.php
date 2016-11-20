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
	
	protected static $default_sort = 'description';
	
	public static function getByProject(Project $project)
	{
		$tasks = array();
		/** @var Task $task */
		foreach (self::$instances as $task)
		{
			if ($project->projectId == $task->projectId) $tasks[] = $task;
		}
		return $tasks;
	}
	
	public function Duration()
	{
		return gmdate('H:i', $this->getDurationSeconds());
	}
	
	public function Hours()
	{
		return round($this->getDurationSeconds() / 60 / 60,2);
	}
	
	public function getDurationSeconds()
	{
		return strtotime($this->endDate) - strtotime($this->startDate);
	}
}