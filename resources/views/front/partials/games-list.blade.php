@php
$dataGame = [
    'games'      => $gameModels->map(function($game) {
        $game['countpictures'] = count($game->pictures);
        return $game;
    }),
    'gamesCount' => count($gameModels),
    'allFolders' => $folderModels,
    'allTags'    => $tagModels,
];
@endphp
<div class="games-list @if (Route::is('fo.homepage')) bg-secondary rounded-2 p-2 @else mt-2 @endif" data-json='@json($dataGame)'></div>
