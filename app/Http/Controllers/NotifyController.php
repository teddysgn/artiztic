<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
 
class NotifyController extends Controller
{
    private $pathViewController = 'default.pages.notify.';
    private $controllerName     = 'notify';
    private $model;
    private $params             = [];

    public function __construct()
    {
        $this->params['pagination']['totalItemsPerPage'] = 10;
        view()->share('controllerName', $this->controllerName);
    }

    public function noPermission(Request $request)
    {   
        return view($this->pathViewController.'index', [
            'active'        => 'notify',
        ]);
    }
}