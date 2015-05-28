# Favorites Plugin for CakePHP #

Version 1.1

Favorites plugin allows to associate users to any record in your database through human readable tags or categories.

## Zuha Installation ##

 - Login as the admin and go to [yoursite.com]/admin/settings 
 - Add a value to __FAVORITES_FAVORITE_SETTINGS

ex 1.
```
types[favorite] = "BlogPost"
defaultTexts[favorite] = "Favorite it"
modelCategories[] = "Blogs"
```

ex 2.
```
types[favorite] = "Post"
types[watch] = "Post"
defaultTexts[favorite] = "Favorite it"
defaultTexts[watch] = "Watch it"
modelCategories[] = "Post"
```

 -  Attach the behavior to your model that you will be favoriting.

ex 1. 
```
class BlogPost extends AppBlogPost {
	// order is important
	public function __construct($id = false, $table = null, $ds = null) {
		if (CakePlugin::loaded('Favorites')) {
            		$this->actsAs[] = 'Favorites.Favorite';
        	}
		parent::__construct($id, $table, $ds);
	}
}
```
 - Add the Helper to your Controller

ex 1. 
```
public function __construct($request = null, $response = null) {
	// order is important
	if (CakePlugin::loaded('Favorites')) {
		$this->helpers[] = 'Favorites.Favorites';
	}
	parent::__construct($request, $response);
}
```

 - Get the user's favorites by adding the following to the action where the Toggle Button will show. 

ex. 1
```
class BlogPostsController extends AppBlogPostsController {
	public function view($id) {
		parent::view($id);
		
		// get their favorite articles
		$Favorite = ClassRegistry::init('Favorites.Favorite');
		$this->set('userFavorites', $userFavorites = $Favorite->getAllFavorites($this->Session->read('Auth.User.id')));
	}
}
```
 - You can now show the link to toggle a record as favorite with this FavoritesHelper generated link : 
	 - **IMPORTANT - You WILL need to edit this code.** 
	 - param 1 = types['watch'] from the config step
	 - param 2 = the foreign key that you want to add to favorites
	 - param 3 = Text of link when adding a favorite.
	 - param 4 = Text of link when removing a favorite.
	 - param 5 = link options
	 - param 6 = the data, so that this link can decide which link to show
	
```
<?php echo $this->Favorites->toggleFavorite('favorite', $blogPost['BlogPost']['id'], 'Add to favorites', 'Remove from favorites', array('class' => 'btn btn-default'), $userFavorites);
```


	
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

```
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
```

