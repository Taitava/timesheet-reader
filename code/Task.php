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
	
	protected static $default_sort = array('description', 'ASC');
	
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
		return gmdate('H:i', $this->get_duration_seconds());
	}
	
	public function Hours()
	{
		return round($this->get_duration_seconds() / 60 / 60,2);
	}
	
	private function get_duration_seconds()
	{
		return strtotime($this->endDate) - strtotime($this->startDate);
	}
}