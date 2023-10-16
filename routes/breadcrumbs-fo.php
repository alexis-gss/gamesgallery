<?php

use App\Models\Game;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator;

// * HOMEPAGE
Breadcrumbs::for('fo.homepage', function (Generator $trail) {
    $trail->push(trans('Homepage'), route('fo.homepage'));
});

// * GAMES
Breadcrumbs::for('fo.games.show', function (Generator $trail, Game $game) {
    $trail->parent('fo.homepage');
    $trail->push($game->name, route('fo.games.show', $game));
});

// * RANKS
Breadcrumbs::for('fo.ranks.index', function (Generator $trail) {
    $trail->parent('fo.homepage');
    $trail->push(trans('Ranking'));
});
