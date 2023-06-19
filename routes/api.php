<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\FormController;
use App\Http\Controllers\API\MailController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PackageFeatureController;
use App\Http\Controllers\API\ProjectProcessController;
use App\Http\Controllers\API\ServicePackageController;
use App\Http\Controllers\API\ServiceProductController;
use App\Http\Middleware\LogRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/admin/login', [AdminController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/admin/logout', [AdminController::class, 'logout']);

    Route::apiResource('project_processes', ProjectProcessController::class)
         ->except(['index']);
    Route::post('/project_processes/{id}', [ProjectProcessController::class, 'update']);

    Route::apiResource('service_products', ServiceProductController::class)
         ->except(['index','show']);
    Route::post('service_products/{id}', [ServiceProductController::class, 'update']);

    Route::apiResource('service_packages', ServicePackageController::class);
    Route::apiResource('package_features', PackageFeatureController::class)
    ->except(['index', 'show']);
    Route::apiResource('/orders', OrderController::class)
    ->except(['store']);

    Route::apiResource('/customers', CustomerController::class);

});


Route::middleware([LogRequest::class])->group(function () {

Route::get('project_processes', [ProjectProcessController::class, 'index']);
Route::get('service_products', [ServiceProductController::class, 'index']);
Route::get('service_products/{id}', [ServiceProductController::class, 'show']);

Route::post('/orders', [OrderController::class , 'store']);
Route::post('/form', FormController::class);
});

Route::get('/cities', [CityController::class, 'getCities']);
Route::get('/cities/{city_id}/districts', [CityController::class, 'getDistrictsByCity']);

Route::get('/send-mails', [MailController::class, 'sendMailToCustomers']);
Route::post('/send-to-mail', [MailController::class, 'sendEmail']);

Route::get('/logs', [LogController::class, 'index']);


/*
 {
  "service_product_id": 3,
  "name": "Bronze",
  "subheading": "Küçük Ölçekli Firmalar için",
  "price": 1999.99,
  "package_features": [
    {
      "icon": "schedule",
      "text": "2 Gün içerinde Teslim  "
    },
    {
      "icon": "description",
      "text": "Tek Sayfa Uygulama"
    },
    {
      "icon": "folder",
      "text": "Kaynak Dosyası"
    }
  ]
}


{
  "service_product_id": 3,
  "name": "Temel Paket",
  "subheading": "Küçük Ölçekli Ve Orta Ölçekli Firmalar için",
  "price": 3599.99,
  "package_features": [
    {
      "icon": "schedule",
      "text": "4 Gün içerinde Teslim  "
    },
    {
      "icon": "description",
      "text": "5 Sayfa Kadar Tasarım"
    },
    {
      "icon": "folder",
      "text": "Kaynak Dosyası"
    },
    {
      "icon": "update",
      "text": "Kısmen Güncellenebilir İçerikler"
    }
  ]
}

{
  "service_product_id": 4,
  "name": "Gelişmiş Paket",
  "subheading": "Büyük Ölçekli Ve Orta Ölçekli E-ticaret Uygulamaları İçin",
  "price": 19999.99,
  "package_features": [
    {
      "icon": "schedule",
      "text": "7 Gün içerinde Teslim  "
    },
    {
      "icon": "description",
      "text": "Sınırsız İçerik Oluşturma"
    },
    {
      "icon": "folder",
      "text": "Kaynak Dosyası"
    },
    {
      "icon": "update",
      "text": "Tam Kontrol Güncellenebilir İçerikler"
    },
    {
      "icon": "person",
      "text" : "Admin & Kullanıcı Girişleri"
    },
    {
      "icon" : "notifications",
      "text" : "Gerçek zamanlı bildirimler"
    }
  ]
}
{
  "service_product_id": 4,
  "name": "Temel Paket",
  "subheading": "Küçün Ve Orta Ölçekli E-ticaret Uygulamaları İçin",
  "price": 9999,99,
  "package_features": [
    {
      "icon": "schedule",
      "text": "7 Gün içerinde Teslim  "
    },
    {
      "icon": "description",
      "text": "Sınırsız İçerik Oluşturma"
    },
    {
      "icon": "folder",
      "text": "Kaynak Dosyası"
    },
    {
      "icon": "update",
      "text": "Tam Kontrol Güncellenebilir İçerikler"
    },
    {
      "icon": "person",
      "text" : "Admin & Kullanıcı Girişleri"
    }
  ]
}
 */