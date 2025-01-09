---
cover: broken-reference
coverY: 71
layout:
  cover:
    visible: false
    size: full
  title:
    visible: true
  description:
    visible: false
  tableOfContents:
    visible: true
  outline:
    visible: true
  pagination:
    visible: true
---

# 📝 Release notes

All notable changes to [Games Gallery](https://www.games-gallery.alexis-gousseau.com/) are documented on this page :

{% hint style="info" %}
* The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
* This project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html),
* Commits respect [Conventionnal commits](https://www.conventionalcommits.org/en/v1.0.0/) & use [Gitmoji](https://gitmoji.dev/).
{% endhint %}

## **\[v5.2.0] - 10.01.25**

### Added

* feat: ✨ add a list of related games at the bottom of each game page
* feat: ✨ logout all unpublished users
* feat: ✨ update all backend layout
* feat: ✨ add laravel/telescope for local development
* feat: ✨ add activity-logs via alexis-gss/laravel-activity-logs
* feat: ✨ add default picture for each games
* feat: ✨ add pagination on related games
* style: 💄 add shadow behind the front navigation

### Changed

* refactor: ♻️ use laravel collection function
* refactor: ♻️ move all modules/partials files in laravel components
* refactor: ♻️ resolve some phpcs/phpstan errors refactor: ♻️ replace saving theme/pagination/lang in cache by session
* ci: 👷 update github issue templates & workflows
* test: ✅ resolve tests errors

### Fixed

* fix: 💄 update front pagination in the navigation
* fix: 💄 update the visibility of the modal to view a picture
* fix: 💄 update scrollable images content in the backend showing page
* fix: 🌐 update & clean all translations
* fix: 🚸 show 404 page when the game slug not exist
* fix: 🚸 resolve some w3c errors/warnings
* fix: 🚸 add warning if javascript is disable
* fix: 🩹 update redirect url after login
* fix: 🐛 update user policies (all only show/update & conceptor on others)
* fix: 🐛 remove useless alt/title on user model

Full changelog: [https://github.com/alexis-gss/games-gallery/compare/v5.1.0...v5.2.0](https://github.com/alexis-gss/games-gallery/compare/v5.1.0...v5.2.0)

***

## **\[v5.1.0] - 15.07.24**

### Added

* feat: ✨ add a visit page counter in the front header of a game page
* feat: ✨ add visits statistics in back office
* feat: ✨ add loading screen on front pages
* feat: 🚸 add the targeted model in sweetalert message
* feat: ✅ extend tests to all the project

### Changed

* docs: 📄 update license
* fix: 🐛 show message when there isn't rating or visit recorded
* fix: 💄 update maintenance page in front/back
* fix: 💄 fix the margin at the bottom of the front game page

Full changelog: [https://github.com/alexis-gss/games-gallery/compare/v5.0.0...v5.1.0](https://github.com/alexis-gss/games-gallery/compare/v5.0.0...v5.1.0)

***

## **\[v5.0.0] - 26.06.24**

### Added

* ci: 👷 update ci/cd (validations & deployment)
* feat: ✨ add unit tests via [alexis-gss/laravel-unit-tests](https://app.gitbook.com/o/teLlPYsR5WTBpd0PxleD/s/SJULvZ9iKnfqFF6afSUo/)
* feat: ✨ add sitemap - issue [#42](https://github.com/alexis-gss/games-gallery/issues/42)
* feat: ✨ add user filter on activity log
* feat: ✨ add a showing page for CRUDs
* feat: ✨ replace old scrollbar by overlayscrollbars-vue package in front navigation
* feat: ✨ add scroll pagination on games list in front navigation
* feat: ✨ add emoji in the title of issue templates
* feat: 🎨 upgrade getters to sort all models collection
* feat: 🚸 update front style (upgrade layout, colors affinity and margin/padding)
* feat: ♿️ update back cards style
* feat: ♿️ upgrade front navigation to improve accessibility
* feat: 🌐 use translations string in request validations
* docs: 📝 synchronization of the Games Gallery GitBook content

### Changed

* chore: 📦 bump project to laravel 11
* chore: ⬆️ update npm/composer dependencies
* refactor: ♻️ use default laravel helpers in blade file
* refactor: ♻️ use default blade directives in blade file
* refactor: ♻️ use cache laravel helper in blade filess
* refactor: ♻️ use helpers laravel trans in php files
* refactor: ♻️ rewrite all vue components into composition style
* refactor: ♻️ rewrite toast message functionnality when guest like a picture
* refactor: ♻️ replace model->id by the primary key

### Fixed

* fix: 🚨 export sass safelist for purge css in vite.config.ts
* fix: 🐛 use universal unique identifier to rate a picture
* fix: 🐛 use cookie to save rating uuid locally
* fix: 🐛 restrict games ranks only for published games
* fix: ♿️ update messages when loading pictures

### Removed

* chore: ➖ remove unused jscolor package

Full changelog: [https://github.com/alexis-gss/games-gallery/compare/v4.2.0...v5.0.0](https://github.com/alexis-gss/games-gallery/compare/v4.2.0...v5.0.0)

***

## \[v4.2.0] - 08/03/2024 <a href="#v2.0.0-19-06-2024" id="v2.0.0-19-06-2024"></a>

### Added

* Add mandatory folders
* Add pictures/ratings seeder
* Add on update/on delete action on foreign keys
* Add administrable translations fields
* Add vite plugin purge css
* Add warning sweetalert popup on action event

### Fixed

* Fix responsive front
* Remove unused opacity on folder color (rgba to hex)
* Clean blades/sass files

Full changelog: [https://github.com/alexis-gss/games-gallery/compare/v4.1.1...v4.2.0](https://github.com/alexis-gss/games-gallery/compare/v4.1.1...v4.2.0)

***

## \[v4.1.1] - 15/02/2024 <a href="#v2.0.0-19-06-2024" id="v2.0.0-19-06-2024"></a>

### Added

* Add previous query when redirect on delete model

### Changed

* Update depedencies
* Update github actions/issue templates

### Fixed

* Fix navigation responsive
* Fix translation of the toast message
* Fix sass component
* Minor fixes/bugs

Full changelog: [https://github.com/alexis-gss/games-gallery/compare/v4.1.0...v4.1.1](https://github.com/alexis-gss/games-gallery/compare/v4.1.0...v4.1.1)

***

## \[v4.1.0] - 12/02/2024 <a href="#v2.0.0-19-06-2024" id="v2.0.0-19-06-2024"></a>

### Added

* Add static pages for home and ranking pages
* Add micro data - issue [#33](https://github.com/alexis-gss/games-gallery/issues/33)
* Add ratings functionnality on pictures
* Add statistics on ratings pictures
* Add reset password functionnality

### Changed

* Update bo navigation - issue [#37](https://github.com/alexis-gss/games-gallery/issues/37)
* Update front responsive - issue [#38](https://github.com/alexis-gss/games-gallery/issues/38) [#39](https://github.com/alexis-gss/games-gallery/issues/39)
* Update folder color functionality

### Fixed

* Minor fixes/bugs

Full changelog: [https://github.com/alexis-gss/games-gallery/compare/v4.0.0...v4.1.0](https://github.com/alexis-gss/games-gallery/compare/v4.0.0...v4.1.0)

***

## \[v4.0.0] - 18/01/2024 <a href="#v2.0.0-19-06-2024" id="v2.0.0-19-06-2024"></a>

### Added

* Add ranking of games - [#29](https://github.com/alexis-gss/games-gallery/issues/29)
* Add DeleteUnassociatedPictures job - issue [#30](https://github.com/alexis-gss/games-gallery/issues/)
* Add translations in front & back - issue [#31](https://github.com/alexis-gss/games-gallery/issues/)
* Add range dates for activities statistics

### Changed

* Update statistics data
* Update accessibility - issue [#32](https://github.com/alexis-gss/games-gallery/issues/)
* Clean project (docblock, prototype, indentation)
* Clean upload images method + optimize images with the .webp type mime

Full changelog: [https://github.com/alexis-gss/games-gallery/compare/v3.0.0...v4.0.0](https://github.com/alexis-gss/games-gallery/compare/v3.0.0...v4.0.0)

***

## \[v3.0.0] - 14/10/2023 <a href="#v2.0.0-19-06-2024" id="v2.0.0-19-06-2024"></a>

### Added

* Bump laravel 8.75->10.\* + bump others depedencies - issue [#20](https://github.com/alexis-gss/gamesgallery/issues/20)
* Add bootstrap themes - issue [#13](https://github.com/alexis-gss/gamesgallery/issues/13)
* Add statistics - issue [#23](https://github.com/alexis-gss/gamesgallery/issues/23)
* Add activity logs - issue [#28](https://github.com/alexis-gss/gamesgallery/issues/28)
* Add mail test command
* Add back-end search on relation and enum

### Changed

* Update saving images functionnality - issue [#3](https://github.com/alexis-gss/gamesgallery/issues/3)
* Update all translations
* Update login back-end
* Update users role/permissions

Full changelog: [https://github.com/alexis-gss/games-gallery/compare/v2.5.0...v3.0.0](https://github.com/alexis-gss/games-gallery/compare/v2.5.0...v3.0.0)

***

## \[v2.5.0] - 18/09/2023 <a href="#v2.0.0-19-06-2024" id="v2.0.0-19-06-2024"></a>

### Added

* Add duplicate model functionnality
* Add latest games on homepage
* Add Community Standards
* Add composer data in the footer

### Changed

* Update README.md - issue [#15](https://github.com/alexis-gss/gamesgallery/issues/15)
* Update Github ISSUE\_TEMPLATE - issue [#16](https://github.com/alexis-gss/gamesgallery/issues/16)
* Update module pagination
* Update back-office home page
* Update btn actions on model

### Fixed

* Fix user's picture when run the command user:create

Full changelog: [https://github.com/alexis-gss/games-gallery/compare/v2.4.0...v2.5.0](https://github.com/alexis-gss/games-gallery/compare/v2.4.0...v2.5.0)

***

## \[v2.4.0] - 22/05/2023 <a href="#v2.0.0-19-06-2024" id="v2.0.0-19-06-2024"></a>

### Added

* Add glightbox
* Add simplebar
* Add folder's color
* Add github's icon

### Changed

* Update breadcrumbs bo
* Update index filters
* Update search bo
* Update access rights

### Fixed

* Minor fixes/bugs

Full changelog: [https://github.com/alexis-gss/games-gallery/compare/v2.3.0...v2.4.0](https://github.com/alexis-gss/games-gallery/compare/v2.3.0...v2.4.0)

***

## \[v2.3.0] - 04/04/2023 <a href="#v2.0.0-19-06-2024" id="v2.0.0-19-06-2024"></a>

### Added

* Add github-actions/github-issue-templates
* Add status for tags and folders
* Add breadcrumbs

### Changed

* Update migrations/seeders

### Fixed

* Minor fixes

Full changelog: [https://github.com/alexis-gss/games-gallery/compare/v2.2.1...v2.3.0](https://github.com/alexis-gss/games-gallery/compare/v2.2.1...v2.3.0)

***

## \[v2.2.1] - 24/01/2023 <a href="#v2.0.0-19-06-2024" id="v2.0.0-19-06-2024"></a>

### Changed

* Update new method for saving images

Full changelog: [https://github.com/alexis-gss/games-gallery/compare/v2.2.0...v2.2.1](https://github.com/alexis-gss/games-gallery/compare/v2.2.0...v2.2.1)

***

## \[v2.2.0] - 11/09/2022 <a href="#v2.0.0-19-06-2024" id="v2.0.0-19-06-2024"></a>

### Added

* Adding tags for games

Full changelog: [https://github.com/alexis-gss/games-gallery/compare/v2.1.0...v2.2.0](https://github.com/alexis-gss/games-gallery/compare/v2.1.0...v2.2.0)

***

## \[v2.1.0] - 10/10/2022 <a href="#v2.0.0-19-06-2024" id="v2.0.0-19-06-2024"></a>

### Added

* Adding a users administration

Full changelog: [https://github.com/alexis-gss/games-gallery/compare/v2.0.0...v2.1.0](https://github.com/alexis-gss/games-gallery/compare/v2.0.0...v2.1.0)

***

## \[v2.0.0] - 12/08/2022 <a href="#v2.0.0-19-06-2024" id="v2.0.0-19-06-2024"></a>

### Changed

* Total redesign of the project under Laravel
* Separation of the front/back office
* Addition of an administration interface with authentication

Full changelog: [https://github.com/alexis-gss/games-gallery/compare/v1.0.0...v2.0.0](https://github.com/alexis-gss/games-gallery/compare/v1.0.0...v2.0.0)

***

## \[v1.0.0] - 17/02/2022 <a href="#v2.0.0-19-06-2024" id="v2.0.0-19-06-2024"></a>

### Added

* Working project
