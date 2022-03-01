<script>
    V = {
        //Élaboration des variables
        jeux: <?php echo $tabSrc; ?>,
        i: undefined,
        j: undefined,
        srcJson: undefined,
        jeuxContentListeTitre: undefined,
        jeuxContentLiSpan: undefined,
        newA: undefined,
        newLi: undefined,
        newDiv: undefined,
        newImg: undefined,
        newP: undefined,
        newSpan: undefined,
        responsive: false,
        nameFolders: [],
        folders: [],
        search: undefined,
        searchClear: undefined,
        regex: /^[0-9]/g,
        viewerAutoTime: 4000,
        viewerAutoLoop: undefined,
        viewerProgressBarWidth: 0,
        heightLi: 23,
        idGameActivated: 0,

        //Initialise les premières actions
        init: function(){
            V.bindsEvent()
            V.createListGames()
            V.determinateWhichGames()
            V.styleListeAndTitle(0)
            V.viewerBtn()
            V.searchGame()
        },
        //Évènements
        bindsEvent: function(){
            window.addEventListener("scroll", V.lazyLoad)
            if(document.body.clientWidth < 900){
                this.responsive = true;
                document.querySelector(".galerieBtnMenuIconContent").innerHTML = ""
            }
            else{
                this.responsive = false;
                document.querySelector(".galerieBtnMenuIconContent").innerHTML = "MENU"
            }
            document.querySelector(".filtre").addEventListener("click", V.menuNormal)
            document.querySelector(".jeuxContentBtnMenuClose").addEventListener("click", V.menuNormal)
            document.querySelector('.galerieBtnMenu').addEventListener("click", V.menuActivated)
            document.querySelector(".footerDetailDate").innerHTML = new Date().getFullYear()
            document.querySelector(".viewerBtnPlay").addEventListener("click", V.viewerAuto)
            document.querySelector(".viewerBtnFullScreen").addEventListener("click", V.viewerFullScreen)
            document.querySelector(".viewerBtnWindowed").addEventListener("click", V.viewerWindowed)
            document.querySelector(".footerTitre").addEventListener("click", function(){
                V.transitionGame(V.idGameActivated)
            })
        },
        //Responsive du menu
        menuNormal: function(){
            document.querySelector('.galerie').classList.remove("translateX");
            document.querySelector(".galerieBtnMenu").classList.remove("galerieBtnMenuActivated");
            document.querySelector("html").classList.remove("overflowHtml")
            document.querySelector("body").classList.remove("overflowBody")
            document.querySelector(".filtre").classList.remove("filtreActivated")
            setTimeout(function(){
                document.querySelector(".filtre").classList.add("display")
            }, 300)
        },
        //Responsive du menu
        menuActivated: function(){
            document.querySelector('.galerie').classList.add("translateX");
            document.querySelector(".galerieBtnMenu").classList.add("galerieBtnMenuActivated");
            document.querySelector("html").classList.add("overflowHtml")
            document.querySelector("body").classList.add("overflowBody")
            document.querySelector(".filtre").classList.remove("display")
            setTimeout(function(){
                document.querySelector(".filtre").classList.add("filtreActivated")
            }, 1)
        },
        //Pré-chargement des images
        lazyLoad: function(){
            var lazyImage = document.getElementsByClassName('imagesGridContentImage')
            for (let i = 0 ; i < lazyImage.length ; i ++) {
                if(V.elementInViewport(lazyImage[i])){
                    lazyImage[i].setAttribute('src', lazyImage[i].getAttribute('data-src'))
                }
            }
        },
        //Détection de la position d'une image
        elementInViewport: function(el){
            var rect = el.getBoundingClientRect();
            return (
                rect.top >= 0 && rect.left >= 0 && (rect.bottom - rect.height) <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            )
        },
        //Récupère que le titre du jeu (et non le nom du dossier)
        onlyName: function(name){
            return name.split('£')[1]
        },
        //Suppression des premiers chiffres (indiquant l'ordre des jeux dans un dossier)
        remplacementRegex: function(target){
            return target.replace(V.regex, '')
        },
        //Renomme la catégorie ".all games" en "all games" de manière a être en 1ère position
        renameAllGames: function(name, j){
            if(name === ".all games"){
                V.jeux[j].name = name.replace('.', '')
            }
        },
        //Créer la liste de jeux
        createListGames: function(){
            for (let j = 0 ; j < V.jeux.length ; j ++) {
                V.renameAllGames(V.jeux[j].name, j)
                V.nameFolders.push(V.jeux[j].name)
                if(V.jeux[j].folder != false){
                    V.jeux[j].name = V.remplacementRegex(V.onlyName(V.jeux[j].name))
                    if (!V.folders.includes(V.jeux[j].folder) && !V.folders.includes(V.jeux[j].folder.split(' ')[V.jeux[j].folder.split(' ').length - 1])){
                        if (V.jeux[j].folder.includes(" ")) {
                            V.folders.push(V.jeux[j].folder.split(' ')[V.jeux[j].folder.split(' ').length - 1])
                        }
                        else{
                            V.folders.push(V.jeux[j].folder)
                        }
                    }
                } 
                if(V.jeux[j].folder === false){
                    V.newLi = document.createElement("li");
                    V.newLi.classList.add("jeuxContentUlLi")
                    document.querySelector(".jeuxContentUl").appendChild(V.newLi);
                    V.newA = document.createElement("a");
                    V.newA.classList.add("jeuxContentUlLiTitre")
                    V.newLi.appendChild(V.newA);
                    V.newA.textContent = V.jeux[j].name
                }
                else{
                    //Création des dossiers
                    for (let k = 0 ; k < V.folders.length ; k ++) {
                        if(V.nameFolders[j].includes(V.folders[k])){
                            if(document.querySelectorAll(".jeuxContentUlFolder").length < V.folders.length){
                                V.newLi = document.createElement("li");
                                V.newLi.classList.add("jeuxContentTitleFolder")
                                document.querySelector(".jeuxContentUl").appendChild(V.newLi);
                                for (let f = 0 ; f < V.jeux[j].folder.length ; f ++) {
                                    if(f === V.jeux[j].folder.length - 1){
                                        V.newLi.textContent += V.jeux[j].folder[f]
                                    }
                                    else{
                                        if(V.jeux[j].folder[f+1][0] === "'"){
                                            V.newLi.textContent += V.jeux[j].folder[f]
                                        }
                                        else{
                                            V.newLi.textContent += V.jeux[j].folder[f]
                                        }
                                    }
                                }
                                V.newUl = document.createElement("ol");
                                V.newUl.classList.add("jeuxContentUlFolder")
                                V.newUl.classList.add(V.folders[k])
                                document.querySelector(".jeuxContentUl").appendChild(V.newUl);
                            }
                            V.newLi = document.createElement("li");
                            V.newLi.classList.add("jeuxContentUlLi")
                            V.newLi.classList.add("jeuxContentUlLiFolder")
                            document.querySelector("." + V.folders[k]).appendChild(V.newLi);
                            V.newA = document.createElement("a");
                            V.newA.classList.add("jeuxContentUlLiTitre")
                            V.newLi.appendChild(V.newA);
                            V.newA.textContent = V.jeux[j].name
                        }
                    }
                }
            }
            V.numberImages()
            V.unrollFolder()
        },
        // Déroule le dossier
        unrollFolder: function(){
            var foldersTitle = document.querySelectorAll(".jeuxContentTitleFolder");
            var foldersList = document.querySelectorAll(".jeuxContentUlFolder");
            for (let i = 0 ; i < foldersTitle.length ; i ++) {
                foldersTitle[i].addEventListener("click", function(){
                    V.rollFolder()
                    if(foldersList[i].clientHeight != 0){
                        V.rollFolder()
                    }
                    else{
                        var heightList = 0;
                        for (let h = 0 ; h < foldersList[i].children.length ; h ++) {
                            if (foldersList[i].children[h].clientHeight === V.heightLi) heightList += V.heightLi + 10
                            else if(foldersList[i].children[h].clientHeight === V.heightLi * 2) heightList += V.heightLi * 2 + 10
                            else heightList += 79
                        }
                        foldersList[i].style.height = (heightList + 10 + "px")
                        foldersTitle[i].classList.toggle("folderTitleActive")
                    }
                })
            }
        },
        // Roule le dossier
        rollFolder: function(){
            var foldersTitle = document.querySelectorAll(".jeuxContentTitleFolder");
            var foldersList = document.querySelectorAll(".jeuxContentUlFolder");
            for (let j = 0 ; j < foldersTitle.length ; j ++) {
                foldersList[j].style.height = 0
                foldersTitle[j].classList.remove("folderTitleActive")
            }
        },
        // Ajoute le nombre d'images dans la liste
        numberImages: function(){
            for (let d = 0 ; d < document.querySelectorAll(".jeuxContentUlLi").length ; d ++) {
                V.newSpan = document.createElement("span");
                V.newSpan.classList.add("jeuxContentUlLiSpan")
                V.newSpan.textContent = " (" + V.jeuSrcImage(d).length + ")"
                document.querySelectorAll(".jeuxContentUlLi")[d].appendChild(V.newSpan);
            }
        },
        // Transition lors d'un changement de jeu
        transitionGame: function(i){
            document.querySelector(".imagesContent").classList.add("transition")
            document.querySelector(".imagesTitre").classList.add("transition")
            setTimeout(function(){
                V.styleListeAndTitle(i)
                V.scrollTop(0)
                document.querySelector(".imagesContent").classList.remove("transition")
                document.querySelector(".imagesTitre").classList.remove("transition")
            }, 300)
        },
        // Stylise la liste des jeux et le titre du jeu concerné
        styleListeAndTitle: function(j){
            V.idGameActivated = j;
            setTimeout(function(){
                for (let i = 0 ; i < V.jeuxContentListeTitre.length ; i ++){
                    V.jeuxContentListeTitre[i].classList.remove("jeuxContentUlLiTitreActive")
                    V.jeuxContentLiSpan[i].classList.remove("jeuxContentUlLiSpanActive")
                }
                V.jeuxContentListeTitre[j].classList.add("jeuxContentUlLiTitreActive")
                V.jeuxContentLiSpan[j].classList.add("jeuxContentUlLiSpanActive")
                V.jeuxContentUlFolder = document.querySelectorAll(".jeuxContentUlFolder")
                V.jeuxContentTitleFolder = document.querySelectorAll(".jeuxContentTitleFolder")
                for (let index = 0 ; index < V.jeuxContentUlFolder.length; index++) {
                    V.jeuxContentTitleFolder[index].classList.remove("jeuxContentTitleFolderActive")
                    if (V.jeuxContentListeTitre[j].textContent.includes(V.jeuxContentUlFolder[index].classList[1])) {
                        V.jeuxContentTitleFolder[index].classList.add("jeuxContentTitleFolderActive")
                    }
                }
            }, 200)
            if(V.jeuxContentListeTitre[j].textContent === V.jeux[j].name){
                document.querySelector(".imagesContent").innerHTML = ""
                document.querySelector(".imagesTitre").textContent = V.jeux[j].name
                V.srcJson = V.jeuSrcImage(j)
                V.updateImgs(V.jeux[j].name)
            }
        },
        // Retourne un tableau des urls des images de la catégorie sélectionnée
        jeuSrcImage: function(i){
            return JSON.parse(JSON.stringify(V.jeux[i].src.split(';')))
        },
        // Création d'une nouvelle div et une nouvelle balise img
        newImgs: function(i, name){
            V.newA = document.createElement("a");
            V.newA.classList.add("imagesGridContent");
            V.newDiv.appendChild(V.newA);
            V.newDivDetail = document.createElement("div");
            V.newDivDetail.classList.add("imagesGridDetail");
            V.newA.appendChild(V.newDivDetail);
            V.newImg = document.createElement("img");
            V.newImg.classList.add("imagesGridContentImage");
            V.newImg.src = "data/load.gif"
            V.newImg.setAttribute('data-src', this.srcJson[i])
            V.newDivDetail.appendChild(V.newImg);
        },
        // Création d'une nouvelle div comprenant le titre du jeu concerné
        newTitleGame: function(i){
            V.newP = document.createElement("span");
            V.newP.classList.add("imagesGridContentTitle")
            V.newA.appendChild(V.newP);
            V.newP.textContent = V.jeux[i].name
        },
        // Définir quel jeu à été sélectionné
        determinateWhichGames: function(){
            V.jeuxContentListeTitre = document.querySelectorAll(".jeuxContentUlLiTitre")
            V.jeuxContentLiSpan = document.querySelectorAll(".jeuxContentUlLiSpan")
            for (let i = 0 ; i < V.jeuxContentListeTitre.length ; i ++){
                V.jeuxContentListeTitre[i].addEventListener("click", function(){
                    V.menuNormal()
                    V.transitionGame(i)
                })
            }
        },
        // Scroll en haut de la page
        scrollTop: function(time){
            setTimeout(() => {
                window.scrollTo({
                    top: 0,
                });
            }, time);
        },
        // Affiche les images correspondants au jeu
        updateImgs: function(name){
            for (this.i = 0 ; this.i < this.srcJson.length ; this.i ++){
                V.newDiv = document.createElement("div");
                V.newDiv.classList.add("imagesGrid")
                V.newDiv.setAttribute('data-aos', "fade-up");
                document.querySelector(".imagesContent").appendChild(V.newDiv);
                V.newImgs(this.i, name)
                //Titre à gauche
                if(name === "all games"){
                    V.newTitleGame(this.i + 1)
                }
                if(V.responsive != true){
                    V.doubleImagesInOneLine(name)
                }      
            }
            V.eventCategories(name)
        },
        //Responsive des images
        doubleImagesInOneLine: function(name){
            this.i = this.i + 1
            //Titre à droite
            if(V.srcJson[this.i] != undefined){
                V.newImgs(this.i, name)
                if(name === "all games"){
                    V.newTitleGame(this.i + 1)
                }
            }
        },
        //Évènements des catégories
        eventCategories: function(name){
            var imagesGridContentImage = document.querySelectorAll(".imagesGridContentImage")
            for (let k = 0 ; k < imagesGridContentImage.length ; k ++){
                imagesGridContentImage[k].classList.add("imagesGridContentImageActive")
            }
            if(name === "all games"){
                var imagesGridContent = document.querySelectorAll(".imagesGridContent")
                for (let j = 0 ; j < imagesGridContent.length ; j ++){
                    imagesGridContent[j].addEventListener("click", function(){
                        if(V.jeux[j + 1].folder != false){
                            var foldersTitle = document.querySelectorAll(".jeuxContentTitleFolder")
                            var foldersList = document.querySelectorAll(".jeuxContentUlFolder")
                        }
                        V.transitionGame(j + 1)
                    })
                }
            }
            else{
                document.querySelector(".viewerBtnClose").addEventListener("click", function(){
                    V.viewerStopAuto()
                    document.querySelector(".viewer").classList.remove("viewerOpacity")
                    document.querySelector(".viewerPhoto").classList.remove("viewerActivated")
                    document.querySelector("html").classList.remove("overflowHtml")
                    document.querySelector("body").classList.remove("overflowBody")
                    V.removeOpacityBtnViewer()
                })
                var imagesGridDetail = document.querySelectorAll(".imagesGridDetail")
                for (let j = 0 ; j < imagesGridDetail.length ; j ++){
                    imagesGridDetail[j].addEventListener("click", function(){
                        document.querySelector("body").classList.add("overflowBody")
                        document.querySelector(".viewer").classList.add("viewerOpacity")
                        document.querySelector(".viewerPhoto").classList.add("viewerActivated")
                        document.querySelector(".viewerPhotoImg").src = V.srcJson[j]
                        V.j = j
                        if(V.j === 0){
                            document.querySelector(".viewerBtnLeft").classList.add("opacity")
                        }
                        if(V.j === V.srcJson.length - 1){
                            document.querySelector(".viewerBtnRight").classList.add("opacity")
                        }
                    }) 
                }
            }
            setTimeout(function(){
                V.lazyLoad()
            }, 100)
        },
        //Event arrow buttons
        viewerBtn: function(){
            document.querySelector(".viewerBtnLeft").addEventListener("click", function(){
                V.viewerPrevious()
                V.viewerStopAuto()
            })
            document.querySelector(".viewerBtnRight").addEventListener("click", function(){
                V.viewerNext()
                V.viewerStopAuto()
            })
        },
        //Stylise les bouttons du viewer
        viewerPrevious: function(){
            if(V.j > 0){
                V.j = V.j - 1
                document.querySelector(".viewerPhotoImg").src = V.srcJson[V.j]
                document.querySelector(".viewerBtnLeft").classList.remove("opacity")
                document.querySelector(".viewerBtnRight").classList.remove("opacity")
            }
            if(V.j === 0){
                document.querySelector(".viewerBtnLeft").classList.add("opacity")
            }
        },
        //Stylise les bouttons du viewer
        viewerNext: function(){
            if(V.j < V.srcJson.length - 1){
                V.j = V.j + 1
                document.querySelector(".viewerPhotoImg").src = V.srcJson[V.j]
                document.querySelector(".viewerBtnRight").classList.remove("opacity")
                document.querySelector(".viewerBtnLeft").classList.remove("opacity")
            }
            if(V.j === V.srcJson.length - 1){
                V.viewerStopAuto(V.viewerAutoLoop)
                document.querySelector(".viewerBtnRight").classList.add("opacity")
            }
        },
        //Automatise le viewer
        viewerAuto: function(){
            if(V.j != V.srcJson.length - 1){
                document.querySelector(".viewerBtnPlay").style.display = "none"
                document.querySelector(".viewerBtnPause").style.display = "flex"
                V.viewerAutoLoop = setInterval(viewerAutoLoopframe, (V.viewerAutoTime/100));
                function viewerAutoLoopframe() {
                    if (V.viewerProgressBarWidth >= 100) {
                        V.viewerProgressBarWidth = 0
                        document.querySelector(".viewerProgressBarContent").style.width = "0"
                        V.viewerNext()
                    } else {
                        V.viewerProgressBarWidth ++
                        document.querySelector(".viewerProgressBarContent").style.width = V.viewerProgressBarWidth + "%";
                    }
                }
            }
            document.querySelector(".viewerBtnPause").addEventListener("click", function() {
                V.viewerStopAuto()
            })
        },
        //Stop le viewer
        viewerStopAuto: function(){
            clearInterval(V.viewerAutoLoop);
            V.viewerProgressBarWidth = 0
            document.querySelector(".viewerProgressBarContent").style.width = "0"
            document.querySelector(".viewerBtnPlay").style.display = "flex"
            document.querySelector(".viewerBtnPause").style.display = "none"
        },
        //Mets en plein écran
        viewerFullScreen: function(){
            document.querySelector(".viewerBtnFullScreen").style.display = "none"
            document.querySelector(".viewerBtnWindowed").style.display = "flex"
            document.documentElement.requestFullscreen()
        },
        //Sort du plein écran
        viewerWindowed: function(){
            document.querySelector(".viewerBtnFullScreen").style.display = "flex"
            document.querySelector(".viewerBtnWindowed").style.display = "none"
            document.exitFullscreen()
        },
        //Stylise les boutons du viewer en fonction de l'image affichée
        removeOpacityBtnViewer: function(){
            document.querySelector(".viewerBtnRight").classList.remove("opacity")
            document.querySelector(".viewerBtnLeft").classList.remove("opacity")
        },
        //Récupère le formulaire de recherches
        searchGame: function(){
            V.search = document.querySelector(".jeuxContentSearch")
            V.search.addEventListener("keyup", V.searchTextChange)
            V.search.addEventListener("click", V.rollFolder)
            V.searchClear = document.querySelector(".jeuxContentSearchClear")
            V.searchClear.addEventListener("click", V.searchTextClear)
        },
        //Ré-initialise la liste des jeux
        searchGameClear: function(){
            for (let i = 0 ; i < V.jeux.length ; i ++) {
                document.querySelectorAll(".jeuxContentUlLi")[i].classList.remove("jeuxContentSearchDisplay")
            }
            for (let i = 0 ; i < document.querySelectorAll(".jeuxContentUlFolder").length ; i ++){
                document.querySelectorAll(".jeuxContentUlFolder")[i].classList.remove("jeuxContentSearchDisplay")
                document.querySelectorAll(".jeuxContentTitleFolder")[i].classList.remove("jeuxContentSearchDisplay")
            }
        },
        //Supprime la recherche
        searchTextClear: function(){
            V.search.value = "";
            V.searchGameClear()
        },
        //Ajuste la liste des jeux en fonction de la recherche
        searchTextChange: function(){
            V.searchGameClear()
            for (let i = 0 ; i < V.jeux.length ; i ++) {
                if(!V.jeux[i].name.includes(V.search.value.toLowerCase())){
                    document.querySelectorAll(".jeuxContentUlLi")[i].classList.add("jeuxContentSearchDisplay")
                }
            }
            for (let i = 0 ; i < document.querySelectorAll(".jeuxContentUlFolder").length ; i ++){
                let count = 0;
                for (let j = 0 ; j < document.querySelectorAll(".jeuxContentUlFolder")[i].children.length ; j ++) {
                    if(document.querySelectorAll(".jeuxContentUlFolder")[i].children[j].classList.contains("jeuxContentSearchDisplay")){
                        count ++
                    }
                }
                if(document.querySelectorAll(".jeuxContentUlFolder")[i].children.length === count){
                    document.querySelectorAll(".jeuxContentUlFolder")[i].classList.add("jeuxContentSearchDisplay")
                    document.querySelectorAll(".jeuxContentTitleFolder")[i].classList.add("jeuxContentSearchDisplay")
                }
            }
        }
    }
    V.init()
</script>