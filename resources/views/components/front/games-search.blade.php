@php
    $dataGame = [
        'games' => $gameModels,
        'allFolders' => $folderModels,
        'allTags' => $tagModels,
        'params' => [
            'text' => request()->text,
            'folder' => request()->folder,
            'tag' => request()->tag,
        ]
    ];
@endphp
<div data-json='@json($dataGame)' @class([
    'games-search',
    'bg-secondary shadow rounded-3 p-2' => request()->routeIs('fo.games.index'),
    'mt-2' => !request()->routeIs('fo.games.index'),
])></div>
