<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator;

// * HOMEPAGE
Breadcrumbs::for('fo.games.index', function (Generator $trail) {
    $trail->push(trans('fo_homepage'), route('fo.games.index'));
});

// * GAMES
Breadcrumbs::for('fo.games.show', function (Generator $trail) {
    $trail->parent('fo.games.index');
});

// * RANKS
Breadcrumbs::for('fo.ranks.index', function (Generator $trail) {
    $trail->parent('fo.games.index');
    $trail->push(trans('fo_ranking'));
});
