# Platform Manage

- [Find Platform(s)](#finding)
 - [Find All](#finding-all)
 - [Find By ID](#finding-by-id)
 - [Find By Name](#finding-by-name)
 - [Find By Abbreviation](#finding-by-abbr)
- [Managing Platforms](#manage)
 - [Create a Platform](#manage-create)
 - [Update a Platform](#manage-update)
 - [Delete a Platform](#manage-delete)
- [Helpers](#)

<a name="finding"></a>
## Finding Platforms

Finding Platforms can 

**Exceptions**

`Bluebanner\Core\PlatformNotFoundException`

If the provided platform was not found, this exception will be thrown.

<a name="finding-all"></a>
**Find All the Platforms**

This will return all Platforms with the type `Illuminate\Database\Eloquent\Builder`, so U can easily use it for pagination.

**Example**

	$platforms = Core::platformList();
	
	$forPagination = $platformList->pagination();

<a name="finding-be-id"></a>
**Find Platform By ID**

...

**Example**

	try
	{
		$platform = Core::platformFind(1);
	}
	catch (Bluebanner\Core\PlatformNotFoundException $e)
	{
		echo 'Platform was not found.';
	}

<a name="finding-by-name"></a>
**Find Platform By Name**

...

**Example**

	try
	{
		$platform = Core::platformFindByName('eBay');
	}
	catch (Bluebanner\Core\PlatformNotFoundException $e)
	{
		echo 'Platform was not found.';
	}

<a name="finding-by-abbr"></a>
**Find Platform By Abbreviation**

find a platform by the abbreviation

**Example**

	try
	{
		$platform = Core::platformFindByAbbr('EBAY');
	}
	catch (Bluebanner\Core\PlatformNotFoundException $e)
	{
		echo 'Platform was not found.';
	}
	
<a name="manage"></a>
## Managing Platform

<a name="manage-create"></a>
**Create a Platform**

To create a new Platform you need to pass an `array()` of Platform fields 
into the `platformCreate()` method, 
please note, that the `name` field and the `abbreviation` are required.

**Exceptions**

`Bluebanner\Core\PlatformNameRequiredException`

When you don't provide the `name` field, this exception will be thrown.

`Bluebanner\Core\PlatformDuplicateException`

When you provide a duplicated `name` field, this exception will be thrown.

**Example**

	try
	{
		$platform = Core::platformCreate(array(
			'name'	=> 'eBay',
			'abbreviation' => 'EBAY',
		));
	}
	catch (Bluebanner\Core\PlatformNameRequiredException $e)
	{
		echo 'Name field is required.';
	}
	catch (Bluebanner\Core\PlatformDuplicateException $e)
	{
		echo 'Name field is duplicated.';
	}

<a name="manage-update"></a>
**Update a Platform**

...

**Exceptions**

`Bluebanner\Core\PlatformNotFoundException`

**Example**

	try
	{
		$platform = Core::platformFind(1);
		
		$platform->name = 'name';
		
		if ($platform->save())
		{
			// Platform was updated
		}
		else
		{
			// Platform was not updated
		}
	}
	catch (Bluebanner\Core\PlatformNotFoundException $e)
	{
		echo 'Platform was not found.';
	}

<a name="manage-delete"></a>
**Delete a Platform**

...

**Exceptions**

`Bluebanner\Core\PlatformNotFoundException`

**Example**

	try
	{
		$platform = Coer::platformFind(1);
		
		$platform->delete();
	}
	catch (Bluebanner\Core\PlatformNotFoundException $e)
	{
		echo 'Platform was not found.';
	}
