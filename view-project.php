<?php

require_once 'initialize.php';

//$project_id = $_GET['project_id'];
$project_id = 'b4b9190e014c403a9980b42e8ac91b95';
	
/** @var Project $project */
$project = Project::byID($project_id);
echo new HTMLElement('h1', $project->name.' ('.$project->CountTasks().' tasks)');

echo '<table><thead><tr>'.Task::Dummy()->HTML()->many('th',true).'</tr></thead><tbody>';
/** @var Task $task */
foreach ($project->Tasks()->items() as $task)
{
	echo '<tr>'.$task->HTML()->many('td').'</tr>';
}
echo '</tbody></table>';
