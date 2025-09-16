<?php
 
namespace App\Models;
use App\Models\ProductModel as MainModel;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
 
class AdminModel extends Model 
{
    protected $table        = '';
    protected $folderUpload = '';
    const CREATED_AT        = 'created';
    const UPDATED_AT        = 'modified';
    protected $fieldSearchAccepted = [
        'id',
        'name'
    ];

    protected $crudNoAccepted = [
        'id',
        'task',
        '_token',
        'hidden_picture',
        'hidden_picture1',
        'hidden_picture2',
        'hidden_picture3',
        'hidden_picture4',
        'hidden_picture5',
        'hidden_picture6',
        'hidden_picture_profile',
        'save',
        'save_new',
        'save_close',
        'save_sku',
    ];

    public function deletePictureAndChangeNameDirectory($picture, $pictureHidden, $nameDirectory = null){
        $pictureTmp = $picture;
        $picture = Str::random(10) . '.' .  $pictureTmp->clientExtension();
        if($nameDirectory != null){
            Storage::disk('artiz_storage')->delete($this->folderUpload . '/' . $nameDirectory . '/' . $pictureHidden);
            $pictureTmp->storeAs($this->folderUpload . '/' . $nameDirectory, $picture, 'artiz_storage');
        } else {
            Storage::disk('artiz_storage')->delete($this->folderUpload . '/' . $pictureHidden);
            $pictureTmp->storeAs($this->folderUpload, $picture, 'artiz_storage');
        }
           
        
        
        return $picture;
    }
}