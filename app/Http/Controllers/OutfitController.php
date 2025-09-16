<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\OutfitModel as MainModel;
use App\Models\ProductModel as ProductModel;
use App\Http\Requests\OutfitRequest as MainRequest;
 
class OutfitController extends Controller
{
    private $pathViewController = 'admin.pages.outfit.';
    private $controllerName     = 'outfit';
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
        $items                            = $this->model->listItems($this->params, ['task' => 'list-items']);
        $arrPicture = [];
        foreach($items as $key => $value){
            $arr = [
                    'item1' => $value['item1'],
                    'item2' => $value['item2'],
                    'item3' => $value['item3'],
                    'item4' => $value['item4'],
                    'item5' => $value['item5'],
                    'item6' => $value['item6'],
                    'id'    => $value['id'],
            ];
            array_unshift($arrPicture, $arr);
        }
        $productModel = new ProductModel();
        $picture = $productModel->listItems($arrPicture, ['task' => 'list-pictures']);

        return view($this->pathViewController.'index', [
            'params'        => $this->params,
            'items'         => $items,
            'picture'       => $picture,
            'header'        => 'Outfits - List',
        ]);
    }

    public function form(Request $request)
    {
        $item = '';
        $picture = '';
        $header = 'Outfit - Add';

        
        if($request->id != null){
            $this->params['id'] = $request->id;
            $item = $this->model->getItem($this->params, ['task' => 'get-item']);
            $header = 'Outfit- Details';

            $this->params['picture'] = [
                'item1' => $item['item1'],
                'item2' => $item['item2'],
                'item3' => $item['item3'],
                'item4' => $item['item4'],
                'item5' => $item['item5'],
                'item6' => $item['item6'],
            ];
            
            $productModel = new ProductModel();
            $picture = $productModel->getItem($this->params, ['task' => 'get-pictures']);
        }

        $productModel = new ProductModel();
        $nameDataList = $productModel->listItems(null, ['task' => 'list-name-products']);
        
        
        return view($this->pathViewController.'form', [
            'item'          => $item,
            'nameDataList'  => $nameDataList,
            'picture'       => $picture,
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

    public function status(Request $request)
    {
        $this->params['currentStatus']    = $request->status;
        $this->params['id']               =   $request->id;
        $this->model->saveItem($this->params, ['task' => 'change-status']);
        return redirect()->route($this->controllerName)->with('artiz_notify', 'Changed Status Successfully!!!');
    }

    public function ajax(Request $request)
    {
        $params = $request->key;
        $productModel = new ProductModel();
        $items = ProductModel::select('picture1', 'id', 'name')
                            ->where('name', '=', $params)
                            ->get();
        return $items;
    }
}