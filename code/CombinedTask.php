<?php


class CombinedTask extends Task
{
	protected static $instances = array();
	
	/**
	 * @var Relation_1toN
	 */
	private $tasks;
	
	public function __construct(array $tasks)
	{
		$this->tasks = new Relation_1toN($this, $tasks);
		$this->description = $this->FirstTask()->description;
	}
	
	public function Duration()
	{
		return gmdate('H:i', $this->tasks->sum('getDurationSeconds'));
	}
	
	public function Hours()
	{
		$seconds = $this->tasks->sum('getDurationSeconds');
		return round($seconds / 60 / 60, 2);
	}
	
	/**
	 * @return Task
	 */
	public function FirstTask()
	{
		return $this->tasks->First();
	}
	
	public static function CombineProjectTasks(Project $project)
	{
		$project_tasks = $project->Tasks()->Sort('description');
		$combine_tasks = array();
		$collections = array();
		$old_description = '';
		/** @var Task $task */
		foreach ($project_tasks as $task)
		{
			if ($old_description != $task->description && !empty($combine_tasks))
			{
				$collections[] = new self($combine_tasks);
				$combine_tasks = array();
			}
			$old_description = $task->description;
			$combine_tasks[] = $task;
		}
		if (!empty($combine_tasks))
		{
			$collections[] = new self($combine_tasks);
		}
		return $collections;
	}
}