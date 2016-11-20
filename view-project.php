<?php

require_once 'code/initialize.php';

$project_id = $_GET['id'];
	
/** @var Project $project */
$project = Project::byID($project_id);
echo new HTMLElement('h1', $project->name.' ('.$project->CountTasks().' tasks)');

echo '<table><thead><tr>'.Task::Dummy()->HTML()->many('th',true).'</tr></thead><tbody>';
/** @var Task $task */
foreach ($project->CombinedTasks()->items() as $task)
{
	echo '<tr>'.$task->HTML()->many('td').'</tr>';
}
echo '</tbody></table>';
