# bb protect

#### Content
- [Lenguajes](#Lenguajes)
- [Tecnologías](#Tecnologías)
- [Dependencies](#Dependencies)
- [Install](#Install)
- [Run](#Run)
- [Credits](#Credits)

##### Languages
- [PHP](http://php.net/downloads.php)
- [HTML](https://www.w3.org/html/)
- [CSS](https://www.w3.org/Style/CSS/)
- [JavaScript] (https://www.javascript.com/) ES6

##### Technologies
- [Laravel](https://laravel.com/docs/5.4) v5.4
- Vue
- MySQL

##### Dependencies
- [LAMP is an archetypal model of web service stacks](https://en.wikipedia.org/wiki/LAMP_(software_bundle)
- [Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git) v2.7.4
- [Composer](https://getcomposer.org/download/) v1.3.1
- [Node.js](https://nodejs.org/es/) v4.3.1
- [NPM](https://docs.npmjs.com/cli/install) v3.5.2

##### Install
(Ubuntu Based)

###### 1. Clone repo
```
$ git clone https://github.com/alfredobarron/bb.git
```

###### 2. Config enviroment variables
```javascript
// Rename file .env-example -> .env
$ sudo mv .env-example .env

// Add variables into .env file
$ sudo nano .env
```

###### 3. Install Dependencies
```javascript
// Laravel
$ composer install

// Vuejs
$ npm install
```

###### 4.  Create DB
```javascript
mysql create database <name_db>
```

###### 5. Create tables
```javascript
php artisan migrate

// Seed tables with faker information **optional
$ php artisan db:seed
```

###### 6. Install [Authentication](https://laravel.com/docs/5.4/authentication) Laravel module
```javascript
php artisan auth
```
##### Run

```javascript
// in production
$ npm run production
// or
$ npm run dev
// or
$ npm run watch
```

##### Credits
- [@alfredobarron](https://github.com/alfredobarron)
- [@NSFrank](https://github.com/NSFrank)
