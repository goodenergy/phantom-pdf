Phantom PDF
===========

A Package for generating PDF files using PhantomJS. The package is framework agnostic, but provides integration with Laravel 4/5.

Notice: This package only works on 64-bit Linux operating systems.

##Installation
Run `composer require danielboendergaard/phantom-pdf`

####Laravel 4 Installation (optional)

Add the service provider in the `providers` array in `app/config/app.php`
````
'providers' => [
  ...
  'PhantomPdf\Laravel\PhantomPdfServiceProvider'
]
````

####Laravel 5 Installation (optional)

Add `Laravel5ServiceProvider` in the `providers` array in `app/config/app.php`
````
'providers' => [
  ...
  'PhantomPdf\Laravel\Laravel5ServiceProvider'
]
````

Add `DeleteTemporaryFiles` in the list of middleware in `App\Http\Kernel.php`
````
protected $middleware = [
  ...
  'PhantomPdf\Laravel\DeleteTemporaryFiles'
]
````

#### Laravel 4/5 Facade usage (optional)

Add the facade to the `aliases` array in `app/config/app.php` (optional)
````
'aliases' => [
  ...
  'PDF' => 'PhantomPdf\Laravel\PDFFacade'
]
````

##Usage with Laravel
````php
class SampleController extends Controller {

  public function index()
  {
    $view = View::make('index');
    
    return PDF::createFromView($view, 'filename.pdf');
  }
}
````

##Usage outside Laravel

````php

$generator = new PdfGenerator;

$generator->setStoragePath('storage/path');

// Returns a Symfony\Component\HttpFoundation\BinaryFileResponse
return $generator->createFromView($html, 'filename.pdf');

````
