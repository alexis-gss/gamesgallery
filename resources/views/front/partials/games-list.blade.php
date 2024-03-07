@php
    $dataGame = [
        'games' => $gameModels,
        'gamesCount' => count($gameModels),
        'allFolders' => $folderModels,
        'allTags' => $tagModels,
    ];
@endphp
<div class="games-list @if (request()->routeIs('fo.games.index')) bg-secondary rounded-2 p-2 @else mt-2 @endif"
    data-json='@json($dataGame)'></div>
