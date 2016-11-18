<?php


/**
 * Class Project
 * @property $projectId
 * @property $name
 * @property $description
 * @property $employer
 * @property $location
 * @property $status
 * @property $salary
 * @property $color
 * @property $order
 * @property $deleted
 * @property $lastUpdate
 * @property $tracking
 * @property $network
 */
class Project extends BaseClass
{
	protected static $instances = array();
	
	protected static $id_field = 'projectId';
	
	protected $fields = array(
		'projectId' => null,
		'name' => null,
		'description' => null,
		'employer' => null,
		'location' => null,
		'status' => null,
		'salary' => null,
		'color' => null,
		'order' => null,
		'deleted' => null,
		'lastUpdate' => null,
		'tracking' => null,
		'network' => null,
	);
	
	public static function LoadProjects()
	{
		/** @var SimpleXMLElement $project */
		foreach (DataFile::Projects()->children() as $project)
		{
			self::load_from_xml($project);
		}
	}
	
	
	
	
	
}