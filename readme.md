# Plide

![Laravel](.brands/laravel.svg) +
![Reveal](.brands/reveal-white-text.svg) +
![Tailwind](.brands/tailwindcss.svg) 

Plide is composer that uses  [Laravel Blade](https://laravel.com/docs/10.x/blade#main-content), [Reveal.js](https://revealjs.com/) and [Tailwind CSS](https://tailwindcss.com/docs) to create beautiful presentations.

## Install

Clone the repository and run the following command to install the package.

PHP Dependencies
```bash
composer install
```

Node Dependencies
```bash
npm install
```

## Usage

#### Create
```bash
php plide new <presentation-name>
```
This creates a folder in the `presentations` directory with the name of the presentation.
The folder contains the following files:

#### Show 
```bash
php plide show <presentation-name>
```
This command starts a local server and opens the presentation in the browser.

> [!IMPORTANT]
> Run `npm run watch` to compile tailwind styles while you are working on the presentation.

#### Export
```bash
php plide export <presentation-name>
```

This command exports the presentation to a zip archive in the `exports` directory. 
this only contains **html** and compiled asset for presentation, ready to use
without need php.

>only need open `index.html` in your browser.   

## Presentation

When presentation is created, it contains `show.blade.php` 
that is the main view for the presentation.

```php
@extends('layouts.reveal')

@section('content')
    <x-slide>
       <h1 class="text-6xl">Plide</h1>
       <p class="text-2xl">
            Beating the hell out of PowerPoint
       </p>
    </x-slide>
@endsection
```

### Plide Components
- `<x-slide>` is a component that wraps the content of a slide.
- `<x-code>` is a component that wraps the content of a code block.

### Class
You can create a class to Manage the presentation, for example
`Master.php` in `presentations/master` directory.

```php
namespace Presentations\master;

use Illuminate\Contracts\View\View;
use Plide\Contract\Renderable;

class Master implements Renderable
{
   public function render() : View 
   {
     return view('custom_view', [//...]);
   }
}
```

And attach it to render method in `index.php`
```php
$plide->render(
    new Presentations\master\Master()
);
```





