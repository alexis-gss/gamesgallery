<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Games Gallery</title>
    <link rel="icon" href="data/screenshot.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@200&family=Fjalla+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pathway+Gothic+One&display=swap" rel="stylesheet">
    <!-- Scroll animation -->
    <link href="https://unpkg.com/aos@next/dist/aos.css" rel="stylesheet">
</head>
<body>
    <section class="galerie">
        <div class="filtre display"></div>
        <button class="galerieBtnMenu">
            <svg class="galerieBtnMenuIcon galerieBtnMenuIconOpen">
                <use href="#icon-menu"></use>
            </svg>
            <p class="galerieBtnMenuIconContent">menu</p>
        </button>
        <section class="jeux">
            <div class="jeuxContent">
                <button class="jeuxContentBtnMenuClose">
                    <svg class="galerieBtnMenuIcon galerieBtnMenuIconClose">
                        <use href="#icon-cross"></use>
                    </svg>
                    <p class="galerieBtnMenuIconContent">close</p>
                </button>
                <h1 class="jeuxContentTitre">games gallery</h1>
                <form class="jeuxContentForm" method="post" action="">
                    <input class="jeuxContentSearch" name="search" placeholder="Search a game" type="text" maxlength="60" autocomplete="off">
                    <input class="jeuxContentSearchClear" type="button" value="X">
                    <input class="display" type="submit" value="submit" disabled>
                </form> 
                <ul class="jeuxContentUl"></ul>
            </div>
        </section>
        <section class="images">
            <div class="imagesCategories">
                <h2 class="imagesTitre"></h2>
                <div class="imagesContent"></div>
            </div>
            <div class="footer">
                <a class="footerTitre">back to the top</a>
                <p class="footerDetail">© copyright <span class="footerDetailDate">1999</span> | alexis gousseau</p>
            </div>
        </section>
        <section class="viewer">
            <div class="viewerBackground"></div>
            <div class="viewerBtns">
                <div class="viewerProgressBar">
                    <div class="viewerProgressBarContent"></div>
                </div>
                <span class="viewerBtn viewerBtnClose">
                    <svg class="viewerBtnContent">
                        <use href="#icon-cross"></use>
                    </svg>
                </span>
                <span class="viewerBtn viewerBtnPlay">
                    <svg class="viewerBtnContent">
                        <use href="#icon-play"></use>
                    </svg>
                </span>
                <span class="viewerBtn viewerBtnPause">
                    <svg class="viewerBtnContent">
                        <use href="#icon-pause"></use>
                    </svg>
                </span>
                <span class="viewerBtn viewerBtnFullScreen">
                    <svg class="viewerBtnContent">
                        <use href="#icon-full-screen"></use>
                    </svg>
                </span>
                <span class="viewerBtn viewerBtnWindowed">
                    <svg class="viewerBtnContent">
                        <use href="#icon-windowed"></use>
                    </svg>
                </span>
                <div class="viewerBtnsImg">
                    <span class="viewerBtn viewerBtnLeft">
                        <svg class="viewerBtnContent">
                            <use href="#icon-arrow-left"></use>
                        </svg>
                    </span>
                    <span class="viewerBtn viewerBtnRight">
                        <svg class="viewerBtnContent">
                            <use href="#icon-arrow-right"></use>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="viewerPhoto">
                <img class="viewerPhotoImg" src="">
            </div>
        </section>
    </section>

    <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <symbol id="icon-menu" viewBox="0 0 24 24">
                <rect y="4" width="24" height="2"/><rect y="9" width="24" height="2"/><rect y="19" width="24" height="2"/><rect y="14" width="24" height="2"/>
            </symbol>
        </defs>
    </svg>

    <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <symbol id="icon-cross" viewBox="0 0 24 24">
                <path d="M23.707.293h0a1,1,0,0,0-1.414,0L12,10.586,1.707.293a1,1,0,0,0-1.414,0h0a1,1,0,0,0,0,1.414L10.586,12,.293,22.293a1,1,0,0,0,0,1.414h0a1,1,0,0,0,1.414,0L12,13.414,22.293,23.707a1,1,0,0,0,1.414,0h0a1,1,0,0,0,0-1.414L13.414,12,23.707,1.707A1,1,0,0,0,23.707.293Z"/>
            </symbol>
        </defs>
    </svg>

    <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <g id="icon-arrow-left" viewBox="0 0 24 24">
                <path d="M17.17,24a1,1,0,0,1-.71-.29L8.29,15.54a5,5,0,0,1,0-7.08L16.46.29a1,1,0,1,1,1.42,1.42L9.71,9.88a3,3,0,0,0,0,4.24l8.17,8.17a1,1,0,0,1,0,1.42A1,1,0,0,1,17.17,24Z"/>
            </g>
        </defs>
    </svg>
  
    <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <g id="icon-arrow-right" viewBox="0 0 24 24">
                <path d="M7,24a1,1,0,0,1-.71-.29,1,1,0,0,1,0-1.42l8.17-8.17a3,3,0,0,0,0-4.24L6.29,1.71A1,1,0,0,1,7.71.29l8.17,8.17a5,5,0,0,1,0,7.08L7.71,23.71A1,1,0,0,1,7,24Z"/>
            </g>
        </defs>
    </svg>

    <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <g id="icon-play" viewBox="0 0 24 24">
                <path d="M20.494,7.968l-9.54-7A5,5,0,0,0,3,5V19a5,5,0,0,0,7.957,4.031l9.54-7a5,5,0,0,0,0-8.064Zm-1.184,6.45-9.54,7A3,3,0,0,1,5,19V5A2.948,2.948,0,0,1,6.641,2.328,3.018,3.018,0,0,1,8.006,2a2.97,2.97,0,0,1,1.764.589l9.54,7a3,3,0,0,1,0,4.836Z"/>
            </g>
        </defs>
    </svg>

    <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <g id="icon-pause" viewBox="0 0 24 24">
                <path d="M6.5,0A3.5,3.5,0,0,0,3,3.5v17a3.5,3.5,0,0,0,7,0V3.5A3.5,3.5,0,0,0,6.5,0ZM8,20.5a1.5,1.5,0,0,1-3,0V3.5a1.5,1.5,0,0,1,3,0Z"/>
                <path d="M17.5,0A3.5,3.5,0,0,0,14,3.5v17a3.5,3.5,0,0,0,7,0V3.5A3.5,3.5,0,0,0,17.5,0ZM19,20.5a1.5,1.5,0,0,1-3,0V3.5a1.5,1.5,0,0,1,3,0Z"/>
            </g>
        </defs>
    </svg>

    <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <g id="icon-full-screen" viewBox="0 0 24 24">
                <path d="M19,24H17a1,1,0,0,1,0-2h2a3,3,0,0,0,3-3V17a1,1,0,0,1,2,0v2A5.006,5.006,0,0,1,19,24Z"/>
                <path d="M1,8A1,1,0,0,1,0,7V5A5.006,5.006,0,0,1,5,0H7A1,1,0,0,1,7,2H5A3,3,0,0,0,2,5V7A1,1,0,0,1,1,8Z"/>
                <path d="M7,24H5a5.006,5.006,0,0,1-5-5V17a1,1,0,0,1,2,0v2a3,3,0,0,0,3,3H7a1,1,0,0,1,0,2Z"/>
                <path d="M23,8a1,1,0,0,1-1-1V5a3,3,0,0,0-3-3H17a1,1,0,0,1,0-2h2a5.006,5.006,0,0,1,5,5V7A1,1,0,0,1,23,8Z"/>
            </g>
        </defs>
    </svg>

    <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <g id="icon-windowed" viewBox="0 0 24 24">
                <path d="M7,0A1,1,0,0,0,6,1V3A3,3,0,0,1,3,6H1A1,1,0,0,0,1,8H3A5.006,5.006,0,0,0,8,3V1A1,1,0,0,0,7,0Z"/>
                <path d="M23,16H21a5.006,5.006,0,0,0-5,5v2a1,1,0,0,0,2,0V21a3,3,0,0,1,3-3h2a1,1,0,0,0,0-2Z"/>
                <path d="M21,8h2a1,1,0,0,0,0-2H21a3,3,0,0,1-3-3V1a1,1,0,0,0-2,0V3A5.006,5.006,0,0,0,21,8Z"/>
                <path d="M3,16H1a1,1,0,0,0,0,2H3a3,3,0,0,1,3,3v2a1,1,0,0,0,2,0V21A5.006,5.006,0,0,0,3,16Z"/>
            </g>
        </defs>
    </svg>

    <?php
        include 'php/data.php';
    ?>

    <script src="js/aos.js"></script>
    <script src="js/aos-init.js"></script>
</body>
</html>