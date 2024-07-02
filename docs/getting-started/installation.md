---
layout:
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

# 📥 Installation

{% hint style="info" %}
[Games gallery](https://games-gallery.alexis-gousseau.com/) requires [PHP 8.3+](https://www.php.net/releases/).
{% endhint %}

Download the project through the github repository :

```
git clone https://github.com/alexis-gss/games-gallery.git
```

Copy the .env.example file to .env in the project root and fill in the data according to your environment :

```
cp .env.example .env
```

Install the Composer/Node.js dependencies :

```
composer i/npm i
```

Compile sass/ts files :

```
npm run prod
```

Fill the database with fictitious data :

```
php artisan migrate:fresh --seed
```

Create a new user (visitor or admin) to login to the back-end :

```
php artisan user:create
```

Link locally saved files to your project :

```
php artisan storage:link
```

Run the serve :

```
php artisan serve
```

Run all tests :

```
php artisan run test
```

You can now use and customize project parameters.
