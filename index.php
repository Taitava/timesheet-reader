<?php

require_once 'config.php';

DataFile::Load();

Project::LoadProjects();

echo "Count projects: ".count(Project::All())."<br>";


/** @var Project $project */
foreach (Project::All() as $project)
{
	echo $project->name;
}