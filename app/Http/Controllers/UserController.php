<?php
 
namespace App\Http\Controllers;
 
use Cache;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\UserModel as MainModel;
use App\Http\Requests\UserRequest as MainRequest;
 
class UserController extends Controller
{
    private $pathViewController = 'admin.pages.user.';
    private $controllerName     = 'user';
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
        $this->params['filter']['status'] = $request->input('filter_status', 'all');
        $this->params['search']['field']  = $request->input('search_field', 'name');
        $this->params['search']['value']  = $request->input('search_value', '');
        $items          = $this->model->listItems($this->params, ['task' => 'list-items']);
        $countByStatus  = $this->model->countItems($this->params, ['task' => 'count-status']);

        return view($this->pathViewController.'index', [
            'params'            => $this->params,
            'items'             => $items,
            'countByStatus'     => $countByStatus,
            'header'            => 'Users - List',
        ]);
    }

    public function form(Request $request)
    {
        $item = '';
        $header = 'User - Add';
        if($request->id != null){
            $this->params['id'] = $request->id;
            $item = $this->model->getItem($this->params, ['task' => 'get-item']);
            $header = 'User - Details';
        }
        return view($this->pathViewController.'form', [
            'item'      => $item,
            'header'    => $header,
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

    public function changePassword(MainRequest $request)
    {
        if($request->method() == 'POST'){
            $this->params = $request->all();
        
            $this->model->saveItem($this->params, ['task' => 'change-password']);
            return redirect()->route($this->controllerName)->with('artiz_notify', 'Updated Password succesfully');
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

    public function level(Request $request)
    {
        $this->params['currentLevel']    = $request->level;
        $this->params['id']               =   $request->id;
        $this->model->saveItem($this->params, ['task' => 'change-level']);
        return redirect()->route($this->controllerName)->with('artiz_notify', 'Changed Level Successfully!!!');
    }
}