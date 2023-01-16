# Yajra_DataTables

Yajra DataTables w docs


                                Basic Start

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" 
For the composer

composer create-project laravel/laravel DataTables
Created the base app

php artisan serve 
Start it
Made the local host database:
datatablesproj

Made connections in the .env file 

                                  Yajra
composer require laravel/ui --dev  
php artisan ui bootstrap --auth
 
composer require yajra/laravel-datatables:^9.0

///for datatables
npm i laravel-datatables-vite --save-dev 

resources/js/app.js
import 'laravel-datatables-vite';

resources/sass/app.scss
// DataTables
@import 'bootstrap-icons/font/bootstrap-icons.css';
@import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";
@import "datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css";
@import 'datatables.net-select-bs5/css/select.bootstrap5.css';

npm run dev

Make The DataTables file (its for looking for something in the database)
php artisan datatables:make Users

at the columns part you can edit the column names to look for


                        Controller & Route & View

Make a Controller for it

php artisan make:controller UsersController

app/Http/Controllers/UsersController.php
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('users.index');
    }

This is the base page for the datatable:

@extends('layouts.app')
 
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Users</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection
 
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush


Make a Route for it in web
Route::get('/users', [UsersController::class, 'index'])->name('users.index');

input this before the body end:
    @stack('scripts')


                               Migrate Seed

Edit the migrations files as ur liking:
\database\migrations\{name}
You can edit the factory file wich is the "seeder" 
\database\factory\{name}

to migrate and seed it simply 
php artisan migrate

Go into the tinker mode
php artisan tinker

Call the model 
User::factory(10)->create()

php artisan serve
if not works use 
npm run dev 

this example will be avaliable on /users route
