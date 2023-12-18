import { config, dom, library } from "@fortawesome/fontawesome-svg-core";
import { faGithub } from "@fortawesome/free-brands-svg-icons";
import {
    faArrowLeft,
    faArrowUp,
    faBars,
    faGlobe,
    faRankingStar,
    faXmark,
} from "@fortawesome/free-solid-svg-icons";

config.autoReplaceSvg = false;
library.add(faArrowUp);
library.add(faXmark);
library.add(faBars);
library.add(faArrowLeft);
library.add(faGithub);
library.add(faRankingStar);
library.add(faGlobe);
dom.watch();
