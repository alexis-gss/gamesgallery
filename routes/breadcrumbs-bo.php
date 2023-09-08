<?php

use App\Models\ActivityLog;
use App\Models\Folder;
use App\Models\Game;
use App\Models\Tag;
use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator;

// * AUTH
Breadcrumbs::for('login', function ($trail) {
    $trail->parent('fo.homepage');
    $trail->push(__('Connection'), route('bo.login'));
});

// * HOMEPAGE
Breadcrumbs::for('bo.homepage', function (Generator $trail) {
    $trail->push(trans('Homepage'), route('bo.homepage'));
});

// * STATISTIQUES
Breadcrumbs::for('bo.statistics', function (Generator $trail) {
    $trail->push(trans('models.stats'), route('bo.statistics'));
});

// * GAMES
Breadcrumbs::for('bo.games.index', function (Generator $trail) {
    $trail->push(
        trans('models.games'),
        route('bo.games.index', ['sort_col' => 'updated_at', 'sort_way' => 'desc'])
    );
});
Breadcrumbs::for('bo.games.create', function (Generator $trail) {
    $trail->parent('bo.games.index');
    $trail->push(trans('crud.actions.create'), route('bo.games.create'));
});
Breadcrumbs::for('bo.games.edit', function (Generator $trail, Game $game) {
    $trail->parent('bo.games.index');
    $trail->push(trans('crud.actions.edit'), route('bo.games.edit', $game->slug));
});
Breadcrumbs::for('bo.games.duplicate', function (Generator $trail, Game $game) {
    $trail->parent('bo.games.index');
    $trail->push(trans('crud.actions.duplicate'), route('bo.games.duplicate', $game->slug));
});

// * FOLDERS
Breadcrumbs::for('bo.folders.index', function (Generator $trail) {
    $trail->push(
        trans('models.folders'),
        route('bo.folders.index', ['sort_col' => 'updated_at', 'sort_way' => 'desc'])
    );
});
Breadcrumbs::for('bo.folders.create', function (Generator $trail) {
    $trail->parent('bo.folders.index');
    $trail->push(trans('crud.actions.create'), route('bo.folders.create'));
});
Breadcrumbs::for('bo.folders.edit', function (Generator $trail, Folder $folder) {
    $trail->parent('bo.folders.index');
    $trail->push(trans('crud.actions.edit'), route('bo.folders.edit', $folder->slug));
});
Breadcrumbs::for('bo.folders.duplicate', function (Generator $trail, Folder $folder) {
    $trail->parent('bo.folders.index');
    $trail->push(trans('crud.actions.duplicate'), route('bo.folders.duplicate', $folder->slug));
});

// * TAGS
Breadcrumbs::for('bo.tags.index', function (Generator $trail) {
    $trail->push(
        trans('models.tags'),
        route('bo.tags.index', ['sort_col' => 'updated_at', 'sort_way' => 'desc'])
    );
});
Breadcrumbs::for('bo.tags.create', function (Generator $trail) {
    $trail->parent('bo.tags.index');
    $trail->push(trans('crud.actions.create'), route('bo.tags.create'));
});
Breadcrumbs::for('bo.tags.edit', function (Generator $trail, Tag $tag) {
    $trail->parent('bo.tags.index');
    $trail->push(trans('crud.actions.edit'), route('bo.tags.edit', $tag->slug));
});
Breadcrumbs::for('bo.tags.duplicate', function (Generator $trail, Tag $tag) {
    $trail->parent('bo.tags.index');
    $trail->push(trans('crud.actions.duplicate'), route('bo.tags.duplicate', $tag->slug));
});

// * USERS
Breadcrumbs::for('bo.users.index', function (Generator $trail) {
    $trail->push(
        trans('models.users'),
        route('bo.users.index', ['sort_col' => 'updated_at', 'sort_way' => 'desc'])
    );
});
Breadcrumbs::for('bo.users.create', function (Generator $trail) {
    $trail->parent('bo.users.index');
    $trail->push(trans('crud.actions.create'), route('bo.users.create'));
});
Breadcrumbs::for('bo.users.edit', function (Generator $trail, User $user) {
    $trail->parent('bo.users.index');
    $trail->push(trans('crud.actions.edit'), route('bo.users.edit', $user->slug));
});
Breadcrumbs::for('bo.users.duplicate', function (Generator $trail, User $user) {
    $trail->parent('bo.users.index');
    $trail->push(trans('crud.actions.duplicate'), route('bo.users.duplicate', $user->slug));
});

// * ACTIVITY_LOGS
Breadcrumbs::for('bo.activity_logs.index', function (Generator $trail) {
    $trail->push(
        trans_choice('models.activities', 2),
        route('bo.activity_logs.index', ['sort_col' => 'created_at', 'sort_way' => 'desc'])
    );
});
Breadcrumbs::for('bo.activity_logs.show', function (Generator $trail, ActivityLog $activity_log) {
    $trail->parent('bo.activity_logs.index');
    $trail->push(trans('crud.actions.show'), route('bo.activity_logs.show', $activity_log->id));
});
