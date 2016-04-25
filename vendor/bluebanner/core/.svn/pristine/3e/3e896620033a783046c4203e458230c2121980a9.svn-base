<?php namespace Bluebanner\Core\Model;

use Bluebanner\Core\PlatformNameRequiredException;
use Bluebanner\Core\PlatformDuplicateException;

class Platform extends BaseModel
{
	
	protected $table = 'core_platform_master';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public static $rules = array(
		'name' => 'required|unique:core_platform_master',
	);
	
	public function validate()
	{
		
		if ( ! $name = $this->name)
			throw new PlatformNameRequiredException('A name is required for a platform, none given.');
		
		$query = $this->newQuery();
		$persistedPlatform = $query->where('name', '=', $name)->first();

		if ($persistedPlatform && $persistedPlatform->getKey() != $this->getKey())
			throw new PlatformDuplicateException("A platform already exists with name [$name], name must be unique for platforms.");
			
		return true;
	}
	
}