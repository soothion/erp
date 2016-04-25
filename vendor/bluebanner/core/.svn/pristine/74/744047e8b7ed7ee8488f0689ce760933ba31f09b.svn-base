# Channel Manage

- [Find Channel(s)](#finding)
 - [Find All](#finding-all)
 - [Find By ID](#finding-by-id)
 - [Find By Name](#finding-by-name)
 - [Find By Abbreviation](#finding-by-abbr)
- [Managing Channel](#manage)
 - [Create a Channel](#manage-create)
 - [Update a Channel](#manage-update)
 - [Delete a Channel](#manage-delete)
- [Helpers](#)

<a name="finding"></a>
## Find Channel(s)

Finding Channels.

**Exceptions**

`Bluebanner\Core\AccountNotFoundException`

If the provided channel was not found, this exception will be thrown.

<a name="finding-all"></a>
**Find All**

This will return all Channels with the type `Illuminate\Database\Eloquent\Builder`, so U can easily use it for pagination.

**Example**

	$channels = Core::accountList();
	
	$channels = Core::accountListByPlatform(1);
	
	$forPagination = $channels->pagination();

<a name="finding-by-id"></a>
**Find By ID**

Find Channel by channel ID.

**Example**

	try
	{
		$channel = Core::accountFind(1);
	}
	catch (Bluebanner\Core\AccountNotFoundException $e)
	{
		echo 'Channel was not found.';
	}

<a name="finding-by-name"></a>
**Find By Name**

Find Channel by channel name.

**Example**

	try
	{
		$channel = Core::accountFindByName('better stuff');
	}
	catch (Bluebanner\Core\AccountNotFoundException $e)
	{
		echo 'Channel was not found.';
	}

<a name="finding-by-abbr"></a>
**Find By Abbreviation**

Find Channel by channel Abbreviation.

**Example**

	try
	{
		$channel = Core::accountFindByAbbr('AMBL');
	}
	catch (Bluebanner\Core\AccountNotFoundException $e)
	{
		echo 'Channel was not found.';
	}

<a name="manage"></a>
## Managing Channel

<a name="manage-create"></a>
**Create a Channel**

To create a new Channel you need to pass an `array()` of Channel fields 
into the `accountCreate()` method, 
please note, that the `name` field and the `platform_id` are required.

**Exceptions**

`Bluebanner\Core\AccountNameRequiredException`

`Bluebanner\Core\AccountPlatformRequiredException`

`Bluebanner\Core\AccountNameDuplicatedException`

**Example**

	try
	{
		$array = array('name' => 'name', 'platform_id' => 1, 'abbreviation' => 'abbr');
		
		Core::accountCreate($array);
	}
	catch (Bluebanner\Core\AccountNameRequiredException $e)
	{
		echo 'Name field is required.';
	}
	catch (Bluebanner\Core\AccountPlatformRequiredException $e)
	{
		echo 'Platform_id field is required.';
	}
	catch (Bluebanner\Core\AccountNameDuplicatedException $e)
	{
		echo 'Name field should be unique.';
	}

<a name="manage-update"></a>
**Update a Channel**

**Exceptions**

`Bluebanner\Core\AccountNotFoundException`

**Example**

	try
	{
		$account = Core::accountFind(1);
		
		$account->name = 'name';
		
		if ($platform->save())
		{
			// Account was updated
		}
		else
		{
			// Account was not updated
		}
	}
	catch (Bluebanner\Core\AccountNotFoundException $e)
	{
		echo 'Account was not found.';
	}

<a name="manage-delete"></a>
**Delete a Channel**

**Exceptions**

`Bluebanner\Core\AccountNotFoundException`

**Example**

	try
	{
		$account = Coer::accountFind(1);
		
		$account->delete();
	}
	catch (Bluebanner\Core\AccountNotFoundException $e)
	{
		echo 'Account was not found.';
	}
