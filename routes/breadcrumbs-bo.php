<?php

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

// * GAMES
Breadcrumbs::for('bo.games.index', function (Generator $trail) {
    $trail->push(trans('Games'), route('bo.games.index'));
});
Breadcrumbs::for('bo.games.create', function (Generator $trail) {
    $trail->parent('bo.games.index');
    $trail->push(trans('Create'), route('bo.games.create'));
});
Breadcrumbs::for('bo.games.edit', function (Generator $trail, Game $game) {
    $trail->parent('bo.games.index');
    $trail->push(trans('Edit'), route('bo.games.edit', $game->slug));
});
Breadcrumbs::for('bo.games.duplicate', function (Generator $trail, Game $game) {
    $trail->parent('bo.games.index');
    $trail->push(trans('Duplicate'), route('bo.games.duplicate', $game->slug));
});

// * FOLDERS
Breadcrumbs::for('bo.folders.index', function (Generator $trail) {
    $trail->push(trans('Folders'), route('bo.folders.index'));
});
Breadcrumbs::for('bo.folders.create', function (Generator $trail) {
    $trail->parent('bo.folders.index');
    $trail->push(trans('Create'), route('bo.folders.create'));
});
Breadcrumbs::for('bo.folders.edit', function (Generator $trail, Folder $folder) {
    $trail->parent('bo.folders.index');
    $trail->push(trans('Edit'), route('bo.folders.edit', $folder->slug));
});
Breadcrumbs::for('bo.folders.duplicate', function (Generator $trail, Folder $folder) {
    $trail->parent('bo.folders.index');
    $trail->push(trans('Duplicate'), route('bo.folders.duplicate', $folder->slug));
});

// * TAGS
Breadcrumbs::for('bo.tags.index', function (Generator $trail) {
    $trail->push(trans('Tags'), route('bo.tags.index'));
});
Breadcrumbs::for('bo.tags.create', function (Generator $trail) {
    $trail->parent('bo.tags.index');
    $trail->push(trans('Create'), route('bo.tags.create'));
});
Breadcrumbs::for('bo.tags.edit', function (Generator $trail, Tag $tag) {
    $trail->parent('bo.tags.index');
    $trail->push(trans('Edit'), route('bo.tags.edit', $tag->slug));
});
Breadcrumbs::for('bo.tags.duplicate', function (Generator $trail, Tag $tag) {
    $trail->parent('bo.tags.index');
    $trail->push(trans('Duplicate'), route('bo.tags.duplicate', $tag->slug));
});

// * USERS
Breadcrumbs::for('bo.users.index', function (Generator $trail) {
    $trail->push(trans('Users'), route('bo.users.index'));
});
Breadcrumbs::for('bo.users.create', function (Generator $trail) {
    $trail->parent('bo.users.index');
    $trail->push(trans('Create'), route('bo.users.create'));
});
Breadcrumbs::for('bo.users.edit', function (Generator $trail, User $user) {
    $trail->parent('bo.users.index');
    $trail->push(trans('Edit'), route('bo.users.edit', $user->slug));
});
Breadcrumbs::for('bo.users.duplicate', function (Generator $trail, User $user) {
    $trail->parent('bo.users.index');
    $trail->push(trans('Duplicate'), route('bo.users.duplicate', $user->slug));
});
