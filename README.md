<div align="center">

![Banner of the github account](./resources/assets/images/github-visual.png)

![GitHub latest commit](https://img.shields.io/github/last-commit/alexis-gss/gamesgallery/develop?color=212529&style=for-the-badge) ![GitHub tag](https://img.shields.io/github/tag/alexis-gss/gamesgallery?style=for-the-badge&color=212529) ![GitHub open issues](https://img.shields.io/github/issues-raw/alexis-gss/gamesgallery?style=for-the-badge&color=212529)

</div>

# Games Gallery
Games Gallery is, as its name suggests, a gallery of images from a multitude of video games I've played. Each game is listed and associated with a folder to sort them by license or universe.

Each element (name, image, folder, color, etc.) can be managed in the back-office (/bo) and accessed via authentication.

# Table of contents

- [Games Gallery](#games-gallery)
- [Table of contents](#table-of-contents)
- [Frameworks, Platforms and Libraries](#frameworks-platforms-and-libraries)
- [Documentation](#documentation)
- [Contributing](#contributing)
    - [Introduction](#introduction)
    - [Fixing a Bug](#fixing-a-bug)
    - [Proposing a Change](#proposing-a-change)
- [Changelog](#changelog)
- [Copyright and License](#copyright-and-license)

# Frameworks, Platforms and Libraries
![SASS](https://img.shields.io/badge/SASS-hotpink.svg?style=for-the-badge&logo=SASS&logoColor=white) ![TypeScript](https://img.shields.io/badge/typescript-%23007ACC.svg?style=for-the-badge&logo=typescript&logoColor=white) ![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white) ![Bootstrap](https://img.shields.io/badge/bootstrap-%23563D7C.svg?style=for-the-badge&logo=bootstrap&logoColor=white) ![Vue.js](https://img.shields.io/badge/vuejs-%2335495e.svg?style=for-the-badge&logo=vuedotjs&logoColor=%234FC08D) ![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)

# Documentation

Download the project :

    git clone https://github.com/alexis-gss/gamesgallery.git

Install the Composer/Node.js dependencies :

    composer i/npm i

Run the serve :

    php artisan serve

Compile sass/ts files :

    npm run prod

Create a new user (visitor or admin) to login to the back-end : 

    php artisan user:create

# Contributing

### Introduction 

You can create a [new issue](https://github.com/alexis-gss/gamesgallery/issues/new/choose) with a specific templates : bug or feature.

Once your code is working, please run the following commands `npm run stylelint`, `npm run eslint` and check `phpcs errors` to verify that your code is following the same coding standards.

### Fixing a Bug

When fixing a bug please make sure to test it in several browsers including ie11. If you are not able to do so, mention that in a PR comment, so other contributors can do it.

### Proposing a Change

When implementing a feature please create an issue first explaining your idea and asking whether there's need for such a feature. Remember the script's core philosophy is to stay simple and minimal, doing one thing and doing it right.

# Changelog

Latest version v2.4.

See the [CHANGELOG.md](CHANGELOG.md) file for details.

# Copyright and License

[gamesgallery](https://github.com/alexis-gss/gamesgallery) was written by [Alexis Gousseau](https://github.com/alexis-gss).

Copyright (c) 2022 and beyond Alexis Gousseau.
