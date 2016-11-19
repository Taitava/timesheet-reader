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
		//'description',
		//'Duration',
	);
	
	public static function LoadTasks()
	{
		/** @var SimpleXMLElement $task */
		foreach (DataFile::Tasks()->children() as $task)
		{
			self::load_from_xml($task);
		}
	}
	
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
		//$seconds = $this->st
	}
}