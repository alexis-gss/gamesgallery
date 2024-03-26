<?php

use App\Models\ActivityLog;
use App\Models\Folder;
use App\Models\Game;
use App\Models\StaticPage;
use App\Models\Tag;
use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator;
use Illuminate\Support\Str;

// * AUTH
Breadcrumbs::for('bo.login', function ($trail) {
    $trail->parent('fo.games.index');
    $trail->push(__('Connection'), route('bo.login'));
});

// * HOMEPAGE
Breadcrumbs::for('bo.home', function (Generator $trail) {
    $trail->push(__('Homepage'), route('bo.home'));
});

// * STATISTIQUES
Breadcrumbs::for('bo.statistics.index', function (Generator $trail) {
    $trail->push(Str::of(__('models.statistic'))->plural()->ucfirst(), route('bo.statistics.index'));
});
Breadcrumbs::for('bo.statistics.update', function (Generator $trail) {
    $trail->push(Str::of(__('models.statistic'))->plural()->ucfirst(), route('bo.statistics.index'));
});

// * GAMES
Breadcrumbs::for('bo.games.index', function (Generator $trail) {
    $trail->push(
        Str::of(trans_choice('models.game', 2))->ucfirst(),
        route('bo.games.index')
    );
});
Breadcrumbs::for('bo.games.show', function (Generator $trail, Game $game) {
    $trail->parent('bo.games.index');
    $trail->push(Str::of(trans('crud.actions.show'))->ucfirst(), route('bo.games.show', $game));
});
Breadcrumbs::for('bo.games.create', function (Generator $trail) {
    $trail->parent('bo.games.index');
    $trail->push(Str::of(trans('crud.actions.create'))->ucfirst(), route('bo.games.create'));
});
Breadcrumbs::for('bo.games.edit', function (Generator $trail, Game $game) {
    $trail->parent('bo.games.index');
    $trail->push(Str::of(trans('crud.actions.edit'))->ucfirst(), route('bo.games.edit', $game));
});
Breadcrumbs::for('bo.games.duplicate', function (Generator $trail) {
    $trail->parent('bo.games.index');
    $trail->push(Str::of(trans('crud.actions.duplicate'))->ucfirst());
});

// * FOLDERS
Breadcrumbs::for('bo.folders.index', function (Generator $trail) {
    $trail->push(
        Str::of(trans('models.folder'))->plural()->ucfirst(),
        route('bo.folders.index')
    );
});
Breadcrumbs::for('bo.folders.show', function (Generator $trail, Folder $folder) {
    $trail->parent('bo.folders.index');
    $trail->push(Str::of(trans('crud.actions.show'))->ucfirst(), route('bo.folders.show', $folder));
});
Breadcrumbs::for('bo.folders.create', function (Generator $trail) {
    $trail->parent('bo.folders.index');
    $trail->push(Str::of(trans('crud.actions.create'))->ucfirst(), route('bo.folders.create'));
});
Breadcrumbs::for('bo.folders.edit', function (Generator $trail, Folder $folder) {
    $trail->parent('bo.folders.index');
    $trail->push(Str::of(trans('crud.actions.edit'))->ucfirst(), route('bo.folders.edit', $folder));
});
Breadcrumbs::for('bo.folders.duplicate', function (Generator $trail) {
    $trail->parent('bo.folders.index');
    $trail->push(Str::of(trans('crud.actions.duplicate'))->ucfirst());
});

// * TAGS
Breadcrumbs::for('bo.tags.index', function (Generator $trail) {
    $trail->push(
        Str::of(trans('models.tag'))->plural()->ucfirst(),
        route('bo.tags.index')
    );
});
Breadcrumbs::for('bo.tags.show', function (Generator $trail, Tag $tag) {
    $trail->parent('bo.tags.index');
    $trail->push(Str::of(trans('crud.actions.show'))->ucfirst(), route('bo.tags.show', $tag));
});
Breadcrumbs::for('bo.tags.create', function (Generator $trail) {
    $trail->parent('bo.tags.index');
    $trail->push(Str::of(trans('crud.actions.create'))->ucfirst(), route('bo.tags.create'));
});
Breadcrumbs::for('bo.tags.edit', function (Generator $trail, Tag $tag) {
    $trail->parent('bo.tags.index');
    $trail->push(Str::of(trans('crud.actions.edit'))->ucfirst(), route('bo.tags.edit', $tag));
});
Breadcrumbs::for('bo.tags.duplicate', function (Generator $trail) {
    $trail->parent('bo.tags.index');
    $trail->push(Str::of(trans('crud.actions.duplicate'))->ucfirst());
});

// * USERS
Breadcrumbs::for('bo.users.index', function (Generator $trail) {
    $trail->push(
        Str::of(trans('models.user'))->plural()->ucfirst(),
        route('bo.users.index')
    );
});
Breadcrumbs::for('bo.users.show', function (Generator $trail, User $user) {
    $trail->parent('bo.users.index');
    $trail->push(Str::of(trans('crud.actions.show'))->ucfirst(), route('bo.users.show', $user));
});
Breadcrumbs::for('bo.users.create', function (Generator $trail) {
    $trail->parent('bo.users.index');
    $trail->push(Str::of(trans('crud.actions.create'))->ucfirst(), route('bo.users.create'));
});
Breadcrumbs::for('bo.users.edit', function (Generator $trail, User $user) {
    $trail->parent('bo.users.index');
    $trail->push(Str::of(trans('crud.actions.edit'))->ucfirst(), route('bo.users.edit', $user));
});
Breadcrumbs::for('bo.users.duplicate', function (Generator $trail) {
    $trail->parent('bo.users.index');
    $trail->push(Str::of(trans('crud.actions.duplicate'))->ucfirst());
});

// * ACTIVITY_LOGS
Breadcrumbs::for('bo.activity_logs.index', function (Generator $trail) {
    $trail->push(
        Str::of(trans_choice('models.activity_log', 2))->ucfirst(),
        route('bo.activity_logs.index')
    );
});
Breadcrumbs::for('bo.activity_logs.show', function (Generator $trail, ActivityLog $activity_log) {
    $trail->parent('bo.activity_logs.index');
    $trail->push(Str::of(trans('crud.actions.show'))->ucfirst(), route('bo.activity_logs.show', $activity_log));
});

// * RANKS
Breadcrumbs::for('bo.ranks.index', function (Generator $trail) {
    $trail->push(
        Str::of(trans('models.rank'))->plural()->ucfirst(),
        route('bo.ranks.index')
    );
});

// * STATIC_PAGES
Breadcrumbs::for('bo.static_pages.index', function (Generator $trail) {
    $trail->push(
        Str::of(trans_choice('models.static_page', 2))->ucfirst(),
        route('bo.static_pages.index')
    );
});
Breadcrumbs::for('bo.static_pages.show', function (Generator $trail, StaticPage $static_page) {
    $trail->parent('bo.static_pages.index');
    $trail->push(Str::of(trans('crud.actions.show'))->ucfirst(), route('bo.static_pages.show', $static_page));
});
Breadcrumbs::for('bo.static_pages.edit', function (Generator $trail, StaticPage $static_page) {
    $trail->parent('bo.static_pages.index');
    $trail->push(Str::of(trans('crud.actions.edit'))->ucfirst(), route('bo.static_pages.edit', $static_page));
});
Breadcrumbs::for('bo.static_pages.duplicate', function (Generator $trail) {
    $trail->parent('bo.static_pages.index');
    $trail->push(Str::of(trans('crud.actions.duplicate'))->ucfirst());
});
