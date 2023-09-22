<?php

return [
    'actions' => [
        'show'      => 'Show',
        'edit'      => 'Edit',
        'save'      => 'Save',
        'delete'    => 'Delete',
        'create'    => 'Create',
        'duplicate' => 'Duplicate',
    ],

    'actions_model' => [
        'show'      => 'Show this :model',
        'edit'      => 'Edit this :model',
        'save'      => 'Save this :model',
        'delete'    => 'Delete this :model',
        'create'    => 'Create a new :model',
        'duplicate' => 'Duplicate this :model',
        'list_all'  => 'List all :model',
    ],

    'changes' => [
        'creation_saved'       => 'Creation saved !',
        'creation_failed'      => 'Creation failed !',
        'modification_saved'   => 'Registered changes !',
        'modification_failed'  => 'Changes failed !',
        'deletion_failed'      => 'Failed deletion !',
        'deletion_successful'  => 'Successful deletion !',
        'deletion_associated'  => 'Game(s) are still associated with this folder !',
        'publish_status_saved' => 'Publishment of status changes !',
        'order_changed'        => 'The order has been changed !',
        'order_not_changed'    => 'The order could not be changed !',
        'right'                => 'You do not have the rights to access this page !',
        'theme_updated'        => 'The theme has been updated !',
    ],

    'pagination' => [
        "previous"      => "Previous page",
        "next"          => "Next page",
        "specific_page" => "Access to page :id",
        'paginate_list' => 'Number of items per page',
    ],

    'search' => [
        'keywords'      => 'Your keywords here...',
        'apply_search'  => 'Apply a search',
        'remove_search' => 'Remove the search'
    ],

    'filter' => [
        'sort_ascending'  => 'Sort :name in ascending order',
        'sort_descending' => 'Sort :name in descending order',
        'sort_delete'     => 'Delete sorting',
        'sort_arrow'      => 'Here, the arrows are used to sort and not to filter',
    ],

    'sweetalert' => [
        'confirm'      => 'Confirm',
        'cancel'       => 'Cancel',
        'are_you_sure' => 'Are you sure ?',
        'data_lost'    => 'All data will be lost.',
    ],

    'meta' => [
        'all_models'          => 'All :model',
        'all_models_list'     => 'Listing of all :model.',
        'creation_model'      => 'Creating a :model',
        'creation_model_desc' => 'Form for entering information to create a new :model',
        'edition_model'       => 'Editing a :model',
        'edition_model_desc'  => 'Editing information of a previously saved :model',
    ],

    'other' => [
        'no_model_found' => 'No :model found',
        'up'             => 'Change the order of appearance upwards',
        'down'           => 'Change the order of appearance downwards',
        'user-right'     => 'You do not have the rights',
        'publish'        => 'Publish',
        'unpublish'      => 'Unpublish',
    ],
];
