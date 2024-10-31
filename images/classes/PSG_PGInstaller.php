<?php
/**
 * PGInstaller takes care of setting up slideshow setting values and transferring to newer version without
 * losing any settings.
 *
 * @since 1.0.0
 * @author Amin Yasser
 */
class PSG_PGInstaller
{
	/** @var string $versionKey Version option key */
	private static $versionKey = 'portfolio-gallery-plugin-version';

	/**
	 * Determines whether or not to perform an update to the plugin.
	 * Checks are only performed when on admin pages as not to slow down the website.
	 *
	 * @since 2.1.20
	 */
	static function init()
	{
		// Only check versions in admin
		if (!is_admin())
		{
			return;
		}

		// Transfer if no version number is set, or the new version number is greater than the current one saved in the database
		$currentVersion = get_option(self::$versionKey, null);

		if ($currentVersion == null ||
			self::firstVersionGreaterThanSecond(PSG_PGMain::$version, $currentVersion))
		{
			self::update($currentVersion);
		}

		// New installation
		if ($currentVersion == null)
		{
			// Set up capabilities
			self::setCapabilities();
		}
	}
private static function setCapabilities()
	{
	return true;	
		
	}
	/**
	 * Updates user to correct version
	 *
	 * @since 1.0.0
	 * @param string $currentVersion
	 */
	private static function update($currentVersion)
	{
		
	}








	/**
	 * Checks if the version input first is greater than the version input second.
	 *
	 * Version numbers are noted as such: x.x.x
	 *
	 * @since 2.1.22
	 * @param String $firstVersion
	 * @param String $secondVersion
	 * @return boolean $firstGreaterThanSecond
	 */
	private static function firstVersionGreaterThanSecond($firstVersion, $secondVersion)
	{
		// Return false if $firstVersion is not set
		if (empty($firstVersion) ||
			!is_string($firstVersion))
		{
			return false;
		}

		// Return true if $secondVersion is not set
		if (empty($secondVersion) ||
			!is_string($secondVersion))
		{
			return true;
		}

		// Separate main, sub and bug-fix version number from one another.
		$firstVersion  = explode('.', $firstVersion);
		$secondVersion = explode('.', $secondVersion);

		// Compare version numbers per piece
		for ($i = 0; $i < count($firstVersion); $i++)
		{
			if (isset($firstVersion[$i], $secondVersion[$i]))
			{
				if ($firstVersion[$i] > $secondVersion[$i])
				{
					return true;
				}
				elseif ($firstVersion[$i] < $secondVersion[$i])
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		// Return false by default
		return false;
	}
}