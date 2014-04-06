# Favorites Plugin for CakePHP #

Version 1.1

Favorites plugin allows to associate users to any record in your database through human readable tags or categories.

## Installation ##

1. Place the favorites folder into any of your plugin directories for your app (for example `app/Plugin` or `root_dir/plugins`)
2. Create the required database tables using either the schema shell or the migrations plugin:

		cake schema create --plugin Favorites --name favorites
		cake Migrations.migration run all --plugin Favorites

 3. This plugin requires that you setup some parameters in global Configure storage:
 1. `Favorites.types contains supported objects that allowed to be stored as favorites.
 2. `Favorites.modelCategories allow to list all models and required contains for it.
 3. `Favorites.defaultTexts sets the default text for the helper toggleFavorite method

## Configure ##

1. Go to your-site.tld/admin/settings 
2. Add a value to __FAVORITES_FAVORITE_SETTINGS

ex.
	types[favorite] = "Post"
	types[watch] = "Post"
	defaultTexts[favorite] = "Favorite it"
	defaultTexts[watch] = "Watch it"
	modelCategories[] = "Post"

## Usage ##

Add the Favorites helper to your controller:

	public $helpers = array('Favorites.Favorites');

Attach the Favorite behavior to your models via the `$actsAs` variable or dynamically using the `BehaviorsCollection` object methods:

	public $actsAs = array('Favorites.Favorite');
	// Or
	$this->Behaviors->attach('Favorites.Favorite');

You can achieve this result using with method `getAllFavorites` in `Favorite` model :

	$Favorite = ClassRegistry::init('Favorites.favorite');
	$this->set('userFavorites', $Favorite->getAllFavorites($this->Session->read('Auth.User.id')));

You can then show the link to toggle a record as favorite with this FavoritesHelper generated link : 

	<?php echo $this->Favorites->toggleFavorite('watch', $property['Property']['id'], 'Add to watchlist', 'Remove from watchlist', array('class' => 'btn btn-default'), $userFavorites);
	
Example function you might use to list favorites 
```
/**
 * List of properties you're watching (have favorited) 
 */
	public function watch() {
		$this->paginate = array(
			'joins' => array(array(
					'table' => 'favorites',
			        'alias' => 'Favorite',
			        'type' => 'INNER',
			        'conditions' => array(
			            'Favorite.foreign_key = Property.id',
			            'Favorite.user_id' => $this->Session->read('Auth.User.id')
			        )
			    ))
			);
		$this->set('properties', $properties = $this->paginate());
	}
```

## Configuration Options ##

The Favorite behavior has some configuration options to adapt to your apps needs.

The configuration array accepts the following keys:

* `favoriteAlias` - The name of the association to be created with the model the Behavior is attached to and the favoriteClass model. Default: Favorite
* `favoriteClass` - If you need to extend the Favorite model or override it with your own implementation set this key to the model you want to use
* `foreignKey` - the field in your table that serves as reference for the primary key of the model it is attached to. (Used for own implementations of Favorite model)
* `counter_cache` - the name of the field that will hold the number of times the model record has been favorited

## Callbacks ##

Additionally the behavior provides two callbacks to implement in your model:

* `beforeSaveFavorite` - called before save favorite. Should return boolean value.
* `afterSaveFavorite` - called after save favorite.

## Requirements ##

* PHP version: PHP 5.2+
* CakePHP version: 2.x Stable

## Side Notes ##

<?php echo $this->Favorites->toggleFavorite('favorite-type1', $property['Property']['id'], 'Add to watchlist', 'Remove from watchlist', array('class' => 'btn btn-default'), $userFavorites);
 will toggle the "favorite-type1" tag for this user and model record.

If you want the helper to distinguish whether it needs to activate or deactivate the favorite flag in for the user, you need to pass to the view the variable `userFavorites` containing an associative array of user favorites per favorite type. The following structure is needed:

	array(
		'favorite-type1' => array(
			'favorite-id1' => 'model-foreignKey-1',
			'favorite-id2' => 'model-foreignKey-3'
			'favorite-id3' => 'model-foreignKey-2'
		),
		'favorite-type2' => array(
			'favorite-id4' => 'model-foreignKey-1',
			'favorite-id5' => 'model-foreignKey-3'
			'favorite-id6' => 'model-foreignKey-2'
		)
	);

## Support ##

For support and feature request, please visit the [Favorites Plugin Support Site](http://cakedc.lighthouseapp.com/projects/59901-favourites-plugin/).

For more information about our Professional CakePHP Services please visit the [Cake Development Corporation website](http://cakedc.com).

## License ##

Copyright 2009-2012, [Cake Development Corporation](http://cakedc.com)

Licensed under [The MIT License](http://www.opensource.org/licenses/mit-license.php)<br/>
Redistributions of files must retain the above copyright notice.

## Copyright ###

Copyright 2009-2012<br/>
[Cake Development Corporation](http://cakedc.com)<br/>
1785 E. Sahara Avenue, Suite 490-423<br/>
Las Vegas, Nevada 89104<br/>
http://cakedc.com<br/>
