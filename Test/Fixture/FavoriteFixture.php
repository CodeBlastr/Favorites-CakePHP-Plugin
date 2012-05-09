<?php
/**
 * Copyright 2009-2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2009-2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Favorite Fixture
 *
 * @package favorites
 * @subpackage favorites.tests.fixtures
 */
class FavoriteFixture extends CakeTestFixture {

/**
 * Model name
 *
 * @var string $model
 */
	public $name = 'Favorite';

/**
 * Table name
 *
 * @var string $useTable
 */
	public $table = 'favorites';
	
/**
 * Import
 *
 * @var array
 */
	public $import = array('config' => 'Favorites.Favorite');

/**
 * record set
 *
 * @var array $records
 */
	public $records = array();
}
