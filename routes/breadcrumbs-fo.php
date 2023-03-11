<?php

use App\Models\Game;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator;

// * HOMEPAGE
Breadcrumbs::for('fo.homepage', function (Generator $trail) {
    $trail->push(trans('Homepage'), route('fo.homepage'));
});

// * SPECIFIC GAME
Breadcrumbs::for('fo.games.specific', function (Generator $trail, Game $game) {
    $trail->parent('fo.homepage');
    $trail->push($game->name, route('fo.games.specific', ['slug' => $game->slug]));
});
