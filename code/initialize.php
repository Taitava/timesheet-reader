<?php

ini_set('display_errors', true);

require_once 'config.php';
require_once 'BaseClass.php';
require_once 'DataFile.php';
require_once 'Project.php';
require_once 'Task.php';
require_once 'CombinedTask.php';
require_once 'TaskBreak.php';
require_once 'HTML.php';
require_once 'Relation.php';

DataFile::Load();
Task::Load();
TaskBreak::Load();
Project::Load();

function footer()
{
	include 'code/footer.php';
}

function display_hours($total_seconds, $show_seconds=false)
{
	$hours = floor($total_seconds / 3600);
	$minutes = floor(($total_seconds / 60) % 60);
	$seconds = $total_seconds % 60;
	if ($show_seconds)
	{
		return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
	}
	else
	{
		return sprintf("%02d:%02d", $hours, $minutes);
	}
}