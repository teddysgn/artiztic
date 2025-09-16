<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\DetailModel as MainModel;
use App\Models\CategoryModel as CategoryModel;
use App\Models\ProductModel as ProductModel;
use App\Models\SizeModel as SizeModel;
use App\Models\ColorModel as ColorModel;
use App\Models\OccasionModel as OccasionModel;
use App\Models\CollectionModel as CollectionModel;
use App\Http\Requests\DetailRequest as MainRequest;
 
class DetailController extends Controller
{
    private $pathViewController = 'admin.pages.detail.';
    private $controllerName     = 'detail';
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
        $this->params['search']['field']        = $request->input('search_field', 'name');
        $this->params['search']['value']        = $request->input('search_value', '');

        $items              = $this->model->listItems($this->params, ['task' => 'list-items']);

        return view($this->pathViewController.'index', [
            'params'            => $this->params,
            'items'             => $items,
            'header'            => 'Similar Products by Color - List',
        ]);
    }

    public function form(Request $request)
    {
        $item = '';
        $header = 'Similar Products by Color - Add';
        if($request->id != null){
            $this->params['id'] = $request->id;
            $item = $this->model->getItem($this->params, ['task' => 'get-item']);
            $header = 'Similar Products by Color - Details';
        }

        $productModel       = new ProductModel();
        $style              = $productModel->listItems(null, ['task' => 'list-items-in-selectbox']);

        $colorModel         = new ColorModel();
        $color              = $colorModel->listItems(null, ['task' => 'list-items-in-selectbox']);

        return view($this->pathViewController.'form', [
            'item'          => $item,
            'colorSlb'      => $color,
            'styleSlb'      => $style,
            'header'        => $header,
        ]);
    }

    public function save(MainRequest $request)
    {
        if($request->method() == 'POST'){
            $this->params = $request->all();

            $task = 'add-item';
            $notify = 'Added Successfully';

            if($this->params['id'] !== null){
                $task = 'edit-item';
                $notify = 'Updated Successfully';
            }
            
           
        
            $id = $this->model->saveItem($this->params, ['task' => $task]);

            if(isset($this->params['save_close']))
                return redirect()->route($this->controllerName)->with('artiz_notify', $notify);
            if(isset($this->params['save_new']))
                return redirect()->route($this->controllerName .'/form')->with('artiz_notify', $notify);
            if(isset($this->params['save']))
                return redirect()->route($this->controllerName .'/form', ['id' => $id])->with('artiz_notify', $notify);
           
        }
    }

    public function delete(Request $request)
    {
        $this->params['id']               =   $request->id;
        $this->model->deleteItem($this->params, ['task' => 'delete-item']);
        return redirect()->route($this->controllerName)->with('artiz_notify', 'Deleted Successfully!!!');
    }

    public function ajax(Request $request)
    {
        $params['color'] = $request->color;
        $params['style'] = $request->style;
        $item = $this->model->getItem($params, ['task' => 'get-item-exist-color-in-style']);
       
        return $item;
    }

    public function ajaxForm(Request $request)
    {
        $this->params['name'] = $request->name;
        $this->params['style'] = $request->style;

        if($this->params['name'] != null)
            $items = $this->model->getItem($this->params, ['task' => 'get-name-ajax']);
        if($this->params['style'] != null)
            $items = $this->model->getItem($this->params, ['task' => 'get-style-ajax']);
       
        return $items;
    }

   
}