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