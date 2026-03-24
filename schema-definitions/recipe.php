<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

return array(
    array(
        'key' => '@type',
        'label' => 'Type',
        'type' => 'hidden',
        'default' => 'Recipe',
        'required' => true,
    ),
    array(
        'key' => 'name',
        'label' => 'Recipe Name',
        'type' => 'text',
        'placeholder' => 'Chocolate Chip Cookies',
        'required' => true,
    ),
    array(
        'key' => 'description',
        'label' => 'Description',
        'type' => 'textarea',
        'placeholder' => 'A delicious recipe for...',
        'required' => true,
    ),
    array(
        'key' => 'image',
        'label' => 'Recipe Image URL',
        'type' => 'url',
        'placeholder' => 'https://example.com/recipe.jpg',
        'required' => false,
    ),
    array(
        'key' => 'recipeIngredient',
        'label' => 'Ingredients',
        'type' => 'repeater',
        'required' => true,
        'fields' => array(
            array(
                'key' => 'ingredient',
                'label' => 'Ingredient',
                'type' => 'text',
                'placeholder' => '2 cups flour',
                'required' => true,
            ),
        ),
    ),
    array(
        'key' => 'recipeInstructions',
        'label' => 'Instructions',
        'type' => 'repeater',
        'required' => true,
        'fields' => array(
            array(
                'key' => 'text',
                'label' => 'Step',
                'type' => 'textarea',
                'placeholder' => 'Preheat oven to 350°F',
                'required' => true,
            ),
        ),
    ),
    array(
        'key' => 'prepTime',
        'label' => 'Prep Time',
        'type' => 'text',
        'placeholder' => 'PT15M',
        'required' => false,
        'help' => 'ISO 8601 duration (e.g., PT15M for 15 minutes)',
    ),
    array(
        'key' => 'cookTime',
        'label' => 'Cook Time',
        'type' => 'text',
        'placeholder' => 'PT30M',
        'required' => false,
        'help' => 'ISO 8601 duration',
    ),
    array(
        'key' => 'recipeYield',
        'label' => 'Yield',
        'type' => 'text',
        'placeholder' => '24 cookies',
        'required' => false,
    ),
);
