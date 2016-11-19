<?php

require_once 'initialize.php';

echo "Count projects: ".count(Project::All())."<br>";


/** @var Project $project */
echo '<table><thead><tr>'.Project::Dummy()->HTML()->many('th',true).'</tr></thead><tbody>';
foreach (Project::All() as $project)
{
	echo '<tr>'.$project->HTML()->many('td').'</tr>';
}
echo '</tbody></table>';