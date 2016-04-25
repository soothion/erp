<?php namespace Bluebanner\Core;

Use Bluebanner\Core\Model\Platform;
use Bluebanner\Core\Model\Account;

class CoreService
{
	
	const VERSION = '1.0-alpha-1-SNAPSHOT';
	
	/**
	 * @return $version of this module
	 */
	public function version()
	{
		return self::VERSION;
	}
	
	public function platformList()
	{
		return Platform::where('id', '>', 0);
	}
	
	public function platformFind($id)
	{
		if ( ! $platform = Platform::find($id))
			throw new PlatformNotFoundException("Platform [$id] was not found.");
			
		return $platform;
	}
	
	public function platformFindByName($name)
	{
		if ( ! $platform = Platform::where('name', '=', $name)->first())
			throw new PlatformNotFoundException("Platform [$name] was not found.");
			
		return $platform;
	}
	
	public function platformFindByAbbr($abbr)
	{
		if ( ! $platform = Platform::where('abbreviation', '=', $abbr)->first())
			throw new PlatformNotFoundException("Platform [$abbr] was not found.");
			
		return $platform;
	}
	
	public function platformCreate($array)
	{
		return Platform::create($array);
	}
	
	public function accountList()
	{
		return Account::where('id', '>', 0);
	}
	
	public function accountListByPlatform($platform_id)
	{
		return Account::where('platform_id', '=', $platform_id);
	}
	
	public function accountFind($id)
	{
		if ( ! $account = Account::find($id))
			throw new AccountNotFoundException("Account [$id] was not found.");
		
		return $account;
	}
	
	public function accountFindByName($name)
	{
		if ( ! $account = Account::where('name', '=', $name)->first())
			throw new AccountNotFoundException("Account [$name] was not found.");
		return $account;
	}
	
	public function accountFindByAbbr($abbr)
	{
		if ( ! $account = Account::where('abbreviation', '=', $abbr)->first())
			throw new AccountNotFoundException("Account [$abbr] was not found.");
		
		return $account;
	}
	
	public function accountCreate($array)
	{
		return Account::create($array);
	}
}