import { config, dom, library } from "@fortawesome/fontawesome-svg-core";
import { faGithub } from "@fortawesome/free-brands-svg-icons";
import {
    faArrowLeft,
    faArrowUp,
    faBars,
    faGlobe,
    faRankingStar,
    faThumbsUp,
    faXmark,
} from "@fortawesome/free-solid-svg-icons";
import {
    faThumbsUp as farThumbsUp,
} from "@fortawesome/free-regular-svg-icons";

config.autoReplaceSvg = false;

// @ts-ignore
library.add( faArrowUp, faXmark, faBars, faArrowLeft, faGithub, faRankingStar, faGlobe, faThumbsUp, farThumbsUp);
dom.watch();
