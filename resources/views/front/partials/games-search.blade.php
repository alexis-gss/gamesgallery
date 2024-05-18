@php
    $dataGame = [
        'games' => $gameModels,
        'gamesCount' => count($gameModels),
        'allFolders' => $folderModels,
        'allTags' => $tagModels,
    ];
@endphp
<div data-json='@json($dataGame)' @class([
    'games-search',
    'bg-secondary rounded-2 p-2' => request()->routeIs('fo.games.index'),
    'mt-2' => !request()->routeIs('fo.games.index'),
])></div>
