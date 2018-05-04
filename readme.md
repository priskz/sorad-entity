# SORAD Entity Package

## Purpose

A generic service implemented on top of the SORAD API + Paylorm that provides consistent conventions for facilitating the mapping of entities.

## Install via Composer

Add the following to your "require" schema:

```
"require": {
     "priskz/sorad-entity": "~0.1.0"
}
```

Run ```composer install```

Add ```'Entity\Laravel\ServiceProvider'``` to the ```'providers'``` in ```/app/laravel/config/app.php``` to enable the newly added service.

Add the following to the ```'aliases'``` aka facades in ```/app/laravel/config/app.php``` to register the newly added service facades:
```
'Entity'                 => 'Entity\Laravel\Facade',
'EntityAsset'            => 'Entity\Service\Asset\Laravel\Facade',
'EntityDetail'           => 'Entity\Service\Detail\Laravel\Facade',
'EntityIdentifier'       => 'Entity\Service\Identifier\Laravel\Facade',
```