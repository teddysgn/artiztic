<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ProductModel as MainModel;
use App\Models\CategoryModel as CategoryModel;
use App\Models\SizeModel as SizeModel;
use App\Models\ColorModel as ColorModel;
use App\Models\OccasionModel as OccasionModel;
use App\Models\CollectionModel as CollectionModel;
use App\Http\Requests\ProductRequest as MainRequest;
 
class ProductController extends Controller
{
    private $pathViewController = 'admin.pages.product.';
    private $controllerName     = 'product';
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
        $this->params['filter']['status']       = $request->input('filter_status', 'all');
        $this->params['filter']['category']     = $request->input('filter_category', '');
        $this->params['filter']['type']         = $request->input('filter_type', '');
        $this->params['filter']['occasion']     = $request->input('filter_occasion', '');
        $this->params['filter']['collection']   = $request->input('filter_collection', '');
        $this->params['search']['field']        = $request->input('search_field', 'name');
        $this->params['search']['value']        = $request->input('search_value', '');

        $items              = $this->model->listItems($this->params, ['task' => 'list-items']);
        $countByStatus      = $this->model->countItems($this->params, ['task' => 'count-status']);

        $occasionModel      = new OccasionModel();
        $occasion           = $occasionModel->listItems(null, ['task' => 'list-items-in-selectbox']);

        $collectionModel    = new CollectionModel();
        $collection         = $collectionModel->listItems(null, ['task' => 'list-items-in-selectbox']);

        $categoryModel      = new CategoryModel();
        $category           = $categoryModel->listItems(null, ['task' => 'list-items-in-selectbox']);

        return view($this->pathViewController.'index', [
            'params'            => $this->params,
            'items'             => $items,
            'countByStatus'     => $countByStatus,
            'occasionParams'    => $occasion,
            'collectionParams'  => $collection,
            'categoryParams'    => $category,
            'header'            => 'Products - List',
        ]);
    }

    public function form(Request $request)
    {
        $item = '';
        $header = 'Product - Add';
        if($request->id != null){
            $this->params['id'] = $request->id;
            $item = $this->model->getItem($this->params, ['task' => 'get-item']);
            $header = 'Product - Details';
        }
        

        $categoryModel      = new CategoryModel();
        $category           = $categoryModel->listItems(null, ['task' => 'list-items-in-selectbox']);

        $colorModel         = new ColorModel();
        $color              = $colorModel->listItems(null, ['task' => 'list-items-in-selectbox']);

        $sizeModel          = new SizeModel();
        $size               = $sizeModel->listItems(null, ['task' => 'list-items-in-selectbox']);

        $occasionModel      = new OccasionModel();
        $occasion           = $occasionModel->listItems(null, ['task' => 'list-items-in-selectbox']);

        $collectionModel    = new CollectionModel();
        $collection         = $collectionModel->listItems(null, ['task' => 'list-items-in-selectbox']);

        return view($this->pathViewController.'form', [
            'item'              => $item,
            'categorySlb'       => $category,
            'sizeSlb'           => $size,
            'colorSlb'          => $color,
            'occasionSlb'       => $occasion,
            'collectionSlb'     => $collection,
            'header'            => $header,
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
            
            $this->params['color'] = implode(",", array_flip($this->params['color']));
            $this->params['size']  = implode(",", array_flip($this->params['size']));
        
            $id = $this->model->saveItem($this->params, ['task' => $task]);

            if(isset($this->params['save_close']))
                return redirect()->route($this->controllerName)->with('artiz_notify', $notify);
            if(isset($this->params['save_new']))
                return redirect()->route($this->controllerName .'/form')->with('artiz_notify', $notify);
            if(isset($this->params['save']))
                return redirect()->route($this->controllerName .'/form', ['id' => $id])->with('artiz_notify', $notify);
            if(isset($this->params['save_sku']))
                return redirect()->route('sku/form')->with('artiz_notify', $notify);
        }
    }

    public function delete(Request $request)
    {
        $this->params['id']               =   $request->id;
        $this->model->deleteItem($this->params, ['task' => 'delete-item']);
        return redirect()->route($this->controllerName)->with('artiz_notify', 'Deleted Successfully!!!');
    }

    public function status(Request $request)
    {
        $this->params['currentStatus']    = $request->status;
        $this->params['id']               =   $request->id;
        $this->model->saveItem($this->params, ['task' => 'change-status']);
        $status = $request->status == 'active' ? 'inactive' : 'active';
        $link = route($this->controllerName.'/status', ['status' => $status, 'id' => $request->id]);
        return response()->json([
            'status' => $status,
            'link' => $link
        ]);
    }

    public function occasion(Request $request)
    {
        $this->params['currentOccasion']  = $request->occasion;
        $this->params['id']               =   $request->id;
        $this->model->saveItem($this->params, ['task' => 'change-occasion']);
        return response()->json([
            'message' => 'Occasion',
        ]);
    }

    public function collection(Request $request)
    {
        $this->params['currentCollection']  = $request->collection;
        $this->params['id']               =   $request->id;
        $this->model->saveItem($this->params, ['task' => 'change-collection']);
        return response()->json([
            'message' => 'Collection',
        ]);
    }

    public function category(Request $request)
    {
        $this->params['currentCategory']  = $request->category;
        $this->params['id']               =   $request->id;
        $this->model->saveItem($this->params, ['task' => 'change-category']);
        return response()->json([
            'message' => 'Category',
        ]);
    }

    public function type(Request $request)
    {
        $this->params['currentType']  = $request->type;
        $this->params['id']               =   $request->id;
        $this->model->saveItem($this->params, ['task' => 'change-type']);
        return response()->json([
            'message' => 'Type',
        ]);
    }

    public function ajax(Request $request)
    {
        $params = $request->key;
        $items = $this->model->listItems($params, ['task' => 'list-items-ajax']);
       
        return $items;
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