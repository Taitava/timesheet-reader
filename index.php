<?php

require_once 'code/initialize.php';

/** @var Project $project */
echo '<table><thead><tr>'.Project::Dummy()->HTML()->many('th',true).'</tr></thead><tbody>';
foreach (Project::All() as $project)
{
	echo '<tr>';
	/** @var HTMLElement $td */
	$first = true;
	foreach ($project->HTML()->many('td')->elements() as $td)
	{
		if ($first)
		{
			$td->setInnerHTML('<a href="view-project.php?id='.$project->projectId.'">'.$td->getInnerHTML().'</a>');
			$first = false;
		}
		echo $td;
	}
		
	echo '</tr>';
}
echo '</tbody></table>';