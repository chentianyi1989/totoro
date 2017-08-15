<?php
namespace App\Http\Controllers\Install;

use App\Http\Controllers\Controller;
use App\Models\Test2;
use App\Models\Test1;
use Illuminate\Support\Facades\DB;
class InstallController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
        
        
        
        Test1::create([
            'name' => "test1",
        ]);
        Test2::create([
            'name' => "test1",
        ]);
        
        
        DB::transaction(function()
        {
            Test1::create([
                'name' => "test2",
            ]);
            throwException("asd");
            Test2::create([
                'name' => "test2",
            ]);
        });
        
        
        return "hello word";
    }
    
    //php artisan make:migration test1
    //php artisan make:migration test1 --table=test1
    //php artisan make:migration test1 --create=test1
    //php artisan migrate
    
}
