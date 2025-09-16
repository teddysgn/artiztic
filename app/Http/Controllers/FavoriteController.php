<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\FavoriteModel as MainModel;
 
class FavoriteController extends Controller
{
    private $pathViewController = 'admin.pages.favorite.';
    private $controllerName     = 'favorite';
    private $model;
    private $params             = [];

    public function __construct()
    {
        $this->params['pagination']['totalItemsPerPage'] = 10;
        $this->model = new MainModel();
        view()->share('controllerName', $this->controllerName);
    }

    public function show(Request $request)
    {   
        $this->params['search']['field']  = $request->input('search_field', 'name');
        $this->params['search']['value']  = $request->input('search_value', '');
        $items          = $this->model->listItems($this->params, ['task' => 'list-items']);

        return view($this->pathViewController.'index', [
            'params'        => $this->params,
            'items'         => $items,
            'header'        => 'Favorites - List',
        ]);
    }
}