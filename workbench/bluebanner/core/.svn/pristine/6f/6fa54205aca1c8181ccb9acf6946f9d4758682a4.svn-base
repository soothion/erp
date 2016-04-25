<?php namespace Bluebanner\Core\Model;

use Bluebanner\Core\AccountNameRequiredException;
use Bluebanner\Core\AccountPlatformRequiredException;
use Bluebanner\Core\PlatformNotFoundException;
use Bluebanner\Core\AccountNameDuplicatedException;

class Account extends BaseModel
{
	
	protected $table = 'core_platform_account';
	
	protected $guarded = array('id');
	
	protected $softDelete = true;
	
	public $rules = array(
		'platform_id' => 'required|integer',
		'name' => 'required|unique:core_platform_account',
	);
	
	public function validate() {
		
		if ( ! $name = $this->name)
			throw new AccountNameRequiredException('A name is required for a Account, none given.');
		
		if ( ! $pid = $this->platform_id)
			throw new AccountPlatformRequiredException('A platform is required for a Account, none given.');
			
		if ( ! $platform = Platform::find($pid))
			throw new PlatformNotFoundException("A platform_id is required for a Account, the given [$pid] can not found.");
			
		$query = $this->newQuery();
		$persistedAccount = $query->where('name', '=', $name)->first();
		
		if ($persistedAccount && $persistedAccount->getKey() != $this->getKey())
			throw new AccountNameDuplicatedException("A account already exists with name [$name], name must be unique for accounts.");

		return true;
	}
	
	public function platform()
	{
		return $this->belongsTo('Bluebanner\Core\Model\Platform');
	}
}