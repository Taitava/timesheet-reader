<?php

/**
 * Class TaskBreak
 * @property $breakId
 * @property $taskId
 * @property $description
 * @property $startDate
 * @property $endDate
 * @property $deleted
 * @property $lastUpdate
 * @property $startTime
 * @property $endTime
 */
class TaskBreak extends BaseClass
{
	protected static $xml_element = 'breaks';
	protected static $instances = array();
	protected $fields = array(
		'breakId' => null,
		'taskId' => null,
		'description' => null,
		'startDate' => null,
		'endDate' => null,
		'deleted' => null,
		'lastUpdate' => null,
		'startTime' => null,
		'endTime' => null,
	);
	
	public static function getByTask(Task $task)
	{
		return TaskBreak::getManyByField('taskId', $task->taskId);
	}
	
	public function getDurationSeconds()
	{
		return strtotime($this->endDate) - strtotime($this->startDate);
	}
}