<nav class="nav position-fixed start-50 translate-middle-x d-flex flex-column justify-content-center align-items-center bg-fourth rounded-3 p-1 pt-0">
    <!-- List of games -->
    <div class="nav-modal nav-modal-hidden col bg-third rounded-3 w-100 mt-1 p-3">
        <div class="nav-games nav-games-hidden">
            <form class="input-group p-1">
                <input name="search"
                    class="form-control bg-transparent text-first border-0"
                    placeholder="{{ __('nav.search', ['games' => isset($games) ? array_sum(array_map('count', $games)) : '0']) }}"
                    title="{{ __('nav.search_title') }}"
                    type="text"
                    maxlength="60"
                    autocomplete="off">
                <input type="submit"
                    value="submit"
                    class="d-none"
                    disabled>
                <button class="btn btn-outline-secondary d-flex align-items-center border-0" type="button" id="a">
                    <svg width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                    </svg>
                </button>
            </form>
            <div class="nav-games-list">
                @if (isset($games))
                    <ul class="list-group rounded-0" id="collapseGroup">
                        @foreach ($games as $key => $folder)
                            @if(count($folder) > 1)
                                <li class="list-group-item bg-transparent border-0 p-0"
                                    role="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collpase{{ str_slug($key) }}"
                                    aria-controls="collpase{{ str_slug($key) }}">
                                    <button class="btn d-flex justify-content-between align-items-center bg-second bg-transparent text-first border-0 rounded-0 px-2 w-100" type="button">
                                        <div>
                                            <svg width="18" height="16" fill="currentColor" class="bi bi-folder" viewBox="0 0 16 16">
                                                <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z"/>
                                            </svg>
                                            <span>{{ $key }}</span>
                                        </div>
                                        <span class="badge rounded-4">{{ count($folder) }}</span>
                                    </button>
                                    <ul class="list-group position-relative overflow-hidden rounded-0 collapse border-0 py-0 pe-0" id="collpase{{ str_slug($key) }}" data-bs-parent="#collapseGroup">
                                        @include('front.layouts.nav-list', ['inFolder' => true])
                                    </ul>
                                </li>
                            @else
                                @include('front.layouts.nav-list', ['inFolder' => false])
                            @endif
                        @endforeach
                    </ul>
                @endif
                <p class="no-result @if (isset($games)) d-none @endif">{{ __('nav.no_result') }}</p>
            </div>
        </div>
        <div class="nav-options nav-options-hidden">YO LES GENS</div>
    </div>
    <!-- Buttons -->
    <div class="d-flex flex-row justify-content-center align-items-center mx-auto w-100 mt-1">
        <button class="btn btn-options text-first bg-third border-0 p-3 me-1">
            <svg width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
            </svg>
        </button>
        <button class="btn btn-games d-flex flex-row justify-content-between align-items-center text-first text-start text-lowercase bg-third border-0 p-3">
            <span class="overflow-hidden">{{ $game->name }}</span>
        </button>
        <button class="btn btn-scroll text-first bg-third border-0 p-3 ms-1">
            <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
            </svg>
        </button>
    </div>
</nav>
