<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie Jeux-vidéo</title>
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
        <section class="viewer display">
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
                        <use href="#icon-arrow-left"></use>
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
                <polygon points="24 1.414 22.586 0 12 10.586 1.414 0 0 1.414 10.586 12 0 22.586 1.414 24 12 13.414 22.586 24 24 22.586 13.414 12 24 1.414"/>
            </symbol>
        </defs>
    </svg>

    <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <g id="icon-arrow-left" viewBox="0 0 24 24">
                <path d="M16.752,23.994,6.879,14.121a3,3,0,0,1,0-4.242L16.746.012,18.16,1.426,8.293,11.293a1,1,0,0,0,0,1.414l9.873,9.873Z"/>
            </g>
        </defs>
    </svg>
  
    <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <g id="icon-arrow-right" viewBox="0 0 24 24">
                <path d="M7.412,24,6,22.588l9.881-9.881a1,1,0,0,0,0-1.414L6.017,1.431,7.431.017l9.862,9.862a3,3,0,0,1,0,4.242Z"/>
            </g>
        </defs>
    </svg>

    <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <g id="icon-play" viewBox="0 0 12 23">
                <path d="M11.501 11C11.501 12 2.00025 22 1.50104 22C1.00183 22 1.00034 0.5 1.50025 0.5C2.00016 0.5 11.501 10 11.501 11Z" fill="black" stroke="black"/>
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