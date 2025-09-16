<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\SkuModel as MainModel;
use App\Models\SizeModel as SizeModel;
use App\Models\ColorModel as ColorModel;
use App\Models\ProductModel as ProductModel;
use App\Http\Requests\SkuRequest as MainRequest;
 
class SkuController extends Controller
{
    private $pathViewController = 'admin.pages.sku.';
    private $controllerName     = 'sku';
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
            'header'        => 'SKUs - List',
        ]);
    }

    public function form(Request $request)
    {
        $item = '';
        $header = 'SKU - Add';
        $colorModel     = new ColorModel();
        $sizeModel      = new SizeModel();
        $productModel   = new ProductModel();
        $color          = $colorModel->listItems(null, ['task' => 'list-items-in-selectbox']);
        $size           = $sizeModel->listItems(null, ['task' => 'list-items-in-selectbox']);
        $style          = $productModel->listItems(null, ['task' => 'list-items-in-selectbox']);

        if($request->id != null){
            $this->params['id'] = $request->id;
            $item = $this->model->getItem($this->params, ['task' => 'get-item']);
            $header = 'SKU - Details';
        }
       
        
        return view($this->pathViewController.'form', [
            'item'          => $item,
            'sizeSlb'       => $size,
            'colorSlb'      => $color,
            'styleSlb'      => $style,
            'header'        => $header,
        ]);
    }

    public function check(Request $request)
    {
        $this->params               =   $request->all();
        $productModel   = new ProductModel();
        $check          = $productModel->getItem($this->params, ['task' => 'sku-check-item']);
        return response()->json([
            'items'             => $check
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
        
            $this->model->saveItem($this->params, ['task' => $task]);
            return redirect()->route($this->controllerName)->with('artiz_notify', $notify);
        }
    }

    public function delete(Request $request)
    {
        $this->params['id']               =   $request->id;
        $this->model->deleteItem($this->params, ['task' => 'delete-item']);
        return redirect()->route($this->controllerName)->with('artiz_notify', 'Deleted Successfully!!!');
    }
}