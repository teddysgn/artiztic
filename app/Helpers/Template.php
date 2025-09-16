<?php
    namespace App\Helpers;

    class Template {
        public static function showItemStatus($controllerName, $id, $status) {
            $tempalteStatus = [
                'active'    => ['name' => 'Active', 'class' => 'btn-success'],
                'inactive'  => ['name' => 'Inactive', 'class' => 'btn-danger']
            ];

            $currentStatus = $tempalteStatus[$status];
            $link = route($controllerName.'/status', ['status' => $status, 'id' => $id]);

            $xhtml = '<button data-url="'.$link.'" class="btn btn-sm status-ajax '.$currentStatus['class'].'">'.$currentStatus['name'].'</button>';
            return $xhtml;
        }

        public static function showButtonFilter($controllerName, $countByStatus, $currentFilterStatus, $paramsSearch, $params) {
            $xhtml = '';
            $count = 0;

            $tempalteStatus = [
                'all'       => ['name' => 'All'],
                'active'    => ['name' => 'Active'],
                'inactive'  => ['name' => 'Inactive']
            ];

            if(count($countByStatus) > 0){
                array_unshift($countByStatus, [
                    'count' => array_sum(array_column($countByStatus, 'count')),
                    'status' => 'all'
                ]);

                foreach($countByStatus as $value){
                    $link = route($controllerName) .'?filter_status='.$value['status'];

                    $split = $count != 0 ? 'style="margin-left: 5px"' : '';
                    $class = $value['status'] == $currentFilterStatus ? 'btn-primary' : 'btn-warning';

                    if($paramsSearch['value'] != ''){
                        $link .= '&search_field=' . $paramsSearch['field'] . '&search_value=' . $paramsSearch['value'];
                    }

                    if(isset($params['filter']['occasion'])){
                        if($params['filter']['occasion'] != ''){
                            $link .= '&filter_occasion=' . $params['filter']['occasion'];
                        }
                    }
                    
                    if(isset($params['filter']['category'])){
                        if($params['filter']['category'] != ''){
                            $link .= '&filter_category=' . $params['filter']['category'];
                        }
                    }

                    if(isset($params['filter']['collection'])){
                        if($params['filter']['collection'] != ''){
                            $link .= '&filter_collection=' . $params['filter']['collection'];
                        }
                    }
                    if(isset($params['filter']['type'])){
                        if($params['filter']['type'] != ''){
                            $link .= '&filter_type=' . $params['filter']['type'];
                        }
                    }

                    $currentStatus = $tempalteStatus[$value['status']];
                    $xhtml .= '<a href="'.$link.'" '.$split.' class="btn btn-sm '.$class.'">'.$currentStatus['name'].' ('.$value['count'].')</a>';
                    $count++;
                }
            }
        
            return $xhtml;
        }

        public static function showStatusCart($controllerName, $countByStatus, $currentFilterStatus, $paramsSearch, $params) {
            $xhtml = '';
            $count = 0;

            $tempalteStatus = [
                'all'        => ['name' => 'All'],
                'pending'    => ['name' => 'Pending'],
                'approved'   => ['name' => 'Approved'],
                'packaging'  => ['name' => 'Packaging'],
                'shipping'   => ['name' => 'Shipping'],
                'delivered'  => ['name' => 'Delivered'],
            ];

            if(count($countByStatus) > 0){
                array_unshift($countByStatus, [
                    'count' => array_sum(array_column($countByStatus, 'count')),
                    'status' => 'all'
                ]);

                foreach($countByStatus as $value){
                    $link = route($controllerName) .'?filter_status='.$value['status'];

                    $split = $count != 0 ? 'style="margin-left: 5px"' : '';
                    $class = $value['status'] == $currentFilterStatus ? 'btn-primary' : 'btn-warning';

                    if($paramsSearch['value'] != ''){
                        $link .= '&search_field=' . $paramsSearch['field'] . '&search_value=' . $paramsSearch['value'];
                    }

                    if($params['filter']['method'] != ''){
                        $link .= '&filter_method=' . $params['filter']['method'];
                    }

                    if($params['filter']['cancel'] != ''){
                        $link .= '&filter_cancel=' . $params['filter']['cancel'];
                    }

                    if($params['filter']['order_by'] != ''){
                        $link .= '&order_by=' . $params['filter']['order_by'];
                    }

                    if($params['filter']['sort_by'] != ''){
                        $link .= '&sort_by=' . $params['filter']['sort_by'];
                    }

                    $currentStatus = $tempalteStatus[$value['status']];
                    $xhtml .= '<a href="'.$link.'" '.$split.' class="btn btn-sm '.$class.'">'.$currentStatus['name'].' ('.$value['count'].')</a>';
                    $count++;
                }
            }
        
            return $xhtml;
        }

        public static function showMethodCart($controllerName, $countByMethod, $currentFilterMethod, $paramsSearch, $params) {
            $xhtml = '';
            $count = 0;

            $tempalteMethod = [
                'all'                   => ['name' => 'All'],
                'cash on delivery'      => ['name' => 'Cash on Delivery'],
                'mobile banking'        => ['name' => 'Mobile Banking'],
            ];

            if(count($countByMethod) > 0){
                array_unshift($countByMethod, [
                    'count' => array_sum(array_column($countByMethod, 'count')),
                    'payment_method' => 'all'
                ]);

                foreach($countByMethod as $value){
                    $link = route($controllerName) .'?filter_method='.$value['payment_method'];

                    $split = $count != 0 ? 'style="margin-left: 5px"' : '';
                    $class = $value['payment_method'] == $currentFilterMethod ? 'btn-primary' : 'btn-warning';

                    if($paramsSearch['value'] != ''){
                        $link .= '&search_field=' . $paramsSearch['field'] . '&search_value=' . $paramsSearch['value'];
                    }

                    if($params['filter']['status'] != ''){
                        $link .= '&filter_status=' . $params['filter']['status'];
                    }

                    if($params['filter']['cancel'] != ''){
                        $link .= '&filter_cancel=' . $params['filter']['cancel'];
                    }

                    if($params['filter']['order_by'] != ''){
                        $link .= '&order_by=' . $params['filter']['order_by'];
                    }

                    if($params['filter']['sort_by'] != ''){
                        $link .= '&sort_by=' . $params['filter']['sort_by'];
                    }                   
                    

                    $currentMethod = $tempalteMethod[$value['payment_method']];
                    
                    $xhtml .= '<a href="'.$link.'" '.$split.' class="btn btn-sm '.$class.'">'.$currentMethod['name'].' ('.$value['count'].')</a>';
                    $count++;
                }
            }
        
            return $xhtml;
        }

        public static function showCancelCart($controllerName, $countByCancel, $currentFilterCancel, $paramsSearch, $params) {
            $xhtml = '';
            $count = 0;

            $tempalteCancel = [
                'all'          => ['name' => 'All'],
                'default'      => ['name' => 'Not Yet'],
                'pending'      => ['name' => 'Pending'],
                'approved'     => ['name' => 'Approved'],
                'deny'         => ['name' => 'Deny'],
            ];

            if(count($countByCancel) > 0){
                array_unshift($countByCancel, [
                    'count' => array_sum(array_column($countByCancel, 'count')),
                    'cancel' => 'all'
                ]);

                foreach($countByCancel as $value){
                    $link = route($controllerName) .'?filter_cancel='.$value['cancel'];

                    $split = $count != 0 ? 'style="margin-left: 5px"' : '';
                    $class = $value['cancel'] == $currentFilterCancel ? 'btn-primary' : 'btn-warning';

                    if($paramsSearch['value'] != ''){
                        $link .= '&search_field=' . $paramsSearch['field'] . '&search_value=' . $paramsSearch['value'];
                    }

                    if($params['filter']['status'] != ''){
                        $link .= '&filter_status=' . $params['filter']['status'];
                    }

                    if($params['filter']['method'] != ''){
                        $link .= '&filter_method=' . $params['filter']['method'];
                    }

                    if($params['filter']['order_by'] != ''){
                        $link .= '&order_by=' . $params['filter']['order_by'];
                    }

                    if($params['filter']['sort_by'] != ''){
                        $link .= '&sort_by=' . $params['filter']['sort_by'];
                    }                   
                    

                    $currentCancel = $tempalteCancel[$value['cancel']];
                    
                    $xhtml .= '<a href="'.$link.'" '.$split.' class="btn btn-sm '.$class.'">'.$currentCancel['name'].' ('.$value['count'].')</a>';
                    $count++;
                }
            }
        
            return $xhtml;
        }

        public static function showItemThumb($controllerName, $src, $name, $width = null) {
            $xhtml = '<img width="'.$width.'" src="'.asset("public/images//$controllerName//$name//$src").'" alt="'.$name.'">';
            return $xhtml;
        }

        public static function showItemSelect($controllerName, $id, $displayValue, $fieldName, $paramsSelectbox, $width = null) {
            $link = route($controllerName. '/' . $fieldName, [$fieldName => 'value_new', 'id' => $id]);
            $xhtml = '<div class="form-group"><select data-url="'.$link.'" name="select_change_attr" style="width: '.$width.'px" class="form-control">';
            
            foreach($paramsSelectbox as $key => $value){
                $xhtmlSelected = '';
                if($key == $displayValue){
                    $xhtmlSelected = 'selected';
                }
                    
                $xhtml .= '<option value="'.$key.'" '.$xhtmlSelected.'>'.$value.'</option>';
            }

            $xhtml .= '</select></div>';
            
            return $xhtml;
        }

        public static function showItemSelectStatusCart($controllerName, $id, $displayValue, $cancelValue, $fieldName, $width = null) {
            $link = route($controllerName. '/' . $fieldName, [$fieldName => 'value_new', 'id' => $id]);
            $disabled = '';
            if($cancelValue != 'default' || $displayValue == 'delivered')
                $disabled = 'disabled';
            $xhtml = '<div class="form-group"><select data-url="'.$link.'" '.$disabled.' name="select_change_attr" style="width: '.$width.'px" class="form-control">';

            switch($displayValue){
                case 'pending':
                    $paramsSelectbox    = [
                        'pending'   => 'Pending',
                        'approved'  => 'Approved',
                        'packaging' => 'Packaging',
                        'shipping'  => 'Shipping',
                        'delivered' => 'Delivered',
                    ];
                    break;
                case 'approved':
                    $paramsSelectbox    = [
                        'approved'  => 'Approved',
                        'packaging' => 'Packaging',
                        'shipping'  => 'Shipping',
                        'delivered' => 'Delivered',
                    ];
                    break;
                case 'packaging':
                    $paramsSelectbox    = [
                        'packaging' => 'Packaging',
                        'shipping'  => 'Shipping',
                        'delivered' => 'Delivered',
                    ];
                    break;
                case 'shipping':
                    $paramsSelectbox    = [
                        'shipping'  => 'Shipping',
                        'delivered' => 'Delivered',
                    ];
                    break;
                case 'delivered':
                    $paramsSelectbox    = [
                        'delivered' => 'Delivered',
                    ];
                    break;
            }
            foreach($paramsSelectbox as $key => $value){
                $xhtmlSelected = '';
                if($key == $displayValue){
                    $xhtmlSelected = 'selected';
                }
                    
                $xhtml .= '<option value="'.$key.'" '.$xhtmlSelected.'>'.$value.'</option>';
            }

            $xhtml .= '</select></div>';
            
            return $xhtml;
        }

        public static function showItemSelectCancelCart($controllerName, $id, $displayValue, $cancelBy, $statusValue, $fieldName, $width = null) {
            $link = route($controllerName. '/' . $fieldName, [$fieldName => 'value_new', 'id' => $id]);
            $disabled = $statusValue != 'delivered' ? '' : 'disabled';
            if($displayValue != 'pending' || $statusValue == 'delivered')
                $disabled = 'disabled';
            $xhtml = '<div class="form-group"><select data-url="'.$link.'" '.$disabled.' name="select_change_attr" style="width: '.$width.'px" class="form-control">';

            switch($displayValue){
                case 'default':
                    $paramsSelectbox    = [
                        'default'   => 'Not Yet',
                    ];
                    break;
                case 'pending':
                    if($cancelBy == 'Artiz' ){
                        $paramsSelectbox    = [
                            'pending'   => 'Pending',
                            'approved'  => 'Approved',
                        ];
                    } else {
                        $paramsSelectbox    = [
                            'pending'   => 'Pending',
                            'approved'  => 'Approved',
                            'deny'      => 'Deny',
                        ];
                    }
                    
                    break;
                case 'approved':
                    $paramsSelectbox    = [
                        'approved'  => 'Approved',
                    ];
                    break;
                case 'deny':
                    $paramsSelectbox    = [
                        'deny'      => 'Deny',
                    ];
                    break;
            }
            foreach($paramsSelectbox as $key => $value){
                $xhtmlSelected = '';
                if($key == $displayValue){
                    $xhtmlSelected = 'selected';
                }
                    
                $xhtml .= '<option value="'.$key.'" '.$xhtmlSelected.'>'.$value.'</option>';
            }

            $xhtml .= '</select></div>';
            
            return $xhtml;
        }

        public static function showItemSelectExchangeCart($controllerName, $id, $displayValue, $fieldName, $width = null) {
            $link = route($controllerName. '/' . $fieldName, [$fieldName => 'value_new', 'id' => $id]);
            $disabled = '';
            if($displayValue != 'pending')
                $disabled = 'disabled';
            $xhtml = '<div class="form-group"><select data-url="'.$link.'" '.$disabled.' name="select_change_attr" style="width: '.$width.'px" class="form-control">';

            switch($displayValue){
                case '':
                    $paramsSelectbox    = [
                        ''   => 'Not Yet',
                    ];
                    break;
                case 'pending':
                    $paramsSelectbox    = [
                        'pending'   => 'Pending',
                        'approved'  => 'Approved',
                    ];
                    break;
                case 'approved':
                    $paramsSelectbox    = [
                        'approved'  => 'Approved',
                    ];
                    break;
            }
            foreach($paramsSelectbox as $key => $value){
                $xhtmlSelected = '';
                if($key == $displayValue){
                    $xhtmlSelected = 'selected';
                }
                    
                $xhtml .= '<option value="'.$key.'" '.$xhtmlSelected.'>'.$value.'</option>';
            }

            $xhtml .= '</select></div>';
            
            return $xhtml;
        }

        public static function showItemButton($controllerName, $id) {
            $tempalteButton = [
                'edit'    => ['class' => 'btn-info', 'title' => 'Edit', 'icon' => 'icon-pencil', 'link' => route($controllerName . '/form', ['id' => $id])],
                'delete'  => ['class' => 'btn-danger btn-delete', 'title' => 'Trash', 'icon' => 'icon-trash-simple', 'link' => route($controllerName . '/delete', ['id' => $id])]
            ];

            $buttonInArea = [
                'default'       => ['edit', 'delete'],
                'product'       => ['edit', 'delete'],
                'category'      => ['edit', 'delete'],
                'user'          => ['edit', 'delete'],
                'occasion'      => ['edit', 'delete'],
                'color'         => ['edit', 'delete'],
                'size'          => ['edit', 'delete'],
                'collection'    => ['edit', 'delete'],
                'outfit'        => ['edit', 'delete'],
                'coupon'        => ['edit', 'delete'],
                'member'        => ['edit', 'delete'],
                'news'          => ['edit', 'delete'],
                'sku'           => ['delete'],
                'cart'          => ['edit'],
            ];

            $listButtons = $buttonInArea[$controllerName];
            $xhtml = '';
            $count = 0;

            $controller = (array_key_exists($controllerName, $buttonInArea)) ? $controllerName : 'default';
            foreach($listButtons as $button){
                $split = $count != 0 ? '<hr>' : '';
                $currentButton = $tempalteButton[$button];
                $xhtml .= $split . '<a href="'.$currentButton['link'].'" class="btn btn-sm '.$currentButton['class'].'">
                            <i class="tim-icons '.$currentButton['icon'].'"></i>
                        </a>';
                $count++;
            }
            
            return $xhtml;
        }

        public static function showAreaSearch($controllerName, $paramsSearch) {
            $xhtml = '';
            $xhtmlField = '';
            
            $templateField = [
                'all'           => ['name' => 'Search by All'],
                'name'          => ['name' => 'Search by NAME'],
                'id'            => ['name' => 'Search by ID'],
                'username'      => ['name' => 'Search by USERNAME'],
                'fullname'      => ['name' => 'Search by FULLNAME'],
                'email'         => ['name' => 'Search by EMAIL'],
                'level'         => ['name' => 'Search by LEVEL'],
                'style'         => ['name' => 'Search by STYLE'],
                'size'          => ['name' => 'Search by SIZE'],
                'color'         => ['name' => 'Search by COLOR'],
                'hex'           => ['name' => 'Search by HEX'],
                'barcode'       => ['name' => 'Search by BARCODE'],
                'code'          => ['name' => 'Search by CODE'],
                'u.fullname'    => ['name' => 'Search by USER'],
                'p.name'        => ['name' => 'Search by PRODUCT'],
                'r.review'      => ['name' => 'Search by CONTENT'],
                'title'         => ['name' => 'Search by TITLE'],
                'source'        => ['name' => 'Search by SOURCE'],
            ];

            $fieldInController = [
                'default'       => ['all', 'id'],
                'product'       => ['all', 'id', 'name'],
                'category'      => ['all', 'id', 'name'],
                'occasion'      => ['all', 'id', 'name'],
                'color'         => ['all', 'id', 'name', 'hex'],
                'size'          => ['all', 'id', 'name'],
                'collection'    => ['all', 'id', 'name'],
                'member'        => ['all', 'id', 'name'],
                'coupon'        => ['all', 'id', 'code'],
                'favorite'      => ['all', 'u.fullname', 'p.name'],
                'cart'          => ['all', 'id', 'u.fullname'],
                'rating'        => ['all', 'id', 'r.review', 'p.name'],
                'sku'           => ['all', 'barcode', 'color', 'size', 'style'],
                'user'          => ['all', 'id', 'fullname', 'username', 'email'],
                'news'          => ['all', 'id', 'title', 'source'],
            ];

            $controllerName = array_key_exists($controllerName, $fieldInController) ? $controllerName : 'default';

            $searchField = in_array($paramsSearch['field'], $fieldInController[$controllerName]) ? $paramsSearch['field'] : 'all';

            foreach($fieldInController[$controllerName] as $field){ // $field = all id
                $xhtmlField .= '<li class="nav-link">
                                    <a style="color: #800020" href="#" class="nav-item dropdown-item p-0 select_field" data-field="'.$field.'">'.$templateField[$field]['name'].'</a>
                                </li>';
            } 

            $xhtml = '<form>
                        <div class="row">
                            <div class="col-sm-12 col-md-8">
                                <div class="form-group" style="margin: 4px 1px">
                                    <input type="text" class="form-control search" style="position: relative" id="search_input" name="search_value" value="'.$paramsSearch['value'].'" placeholder="Type here..." style="color: #800020; font-size: 17px">
                                    <input type="hidden" name="search_field" value="'.$searchField.'">
                                </div>
                                <div class="search-ajax-result form-group">
                                    
                                   
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <button id="btn-search" style="padding: 10px 18px" href="http://localhost/admin/product?filter_status=all" class="btn btn-sm btn-warning">Search</a>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <li class="dropdown nav-item" style="list-style-type: none; margin: 4px 1px">
                                    <button type="submit" class="dropdown-toggle btn btn-sm btn-warning btn-active-field" data-toggle="dropdown" style="padding: 5px 15p">
                                        '.$templateField[$searchField]['name'].'
                                    </button>
                                    <ul class="dropdown-menu">
                                        '.$xhtmlField.'
                                    </ul>
                                </li>
                            </div>
                        </div>
                    </form>';
            return $xhtml;
        }

        public static function showSelectFilter($controllerName, $params, $paramsSelectbox, $buttonName) { // $buttonName = occasion
            $selectName = 'Select ' . ucfirst($buttonName);
            $xhtmlField = '';
            foreach($paramsSelectbox as $key => $value){ // $field = all id
                $link = route($controllerName);
               

                if($buttonName == 'occasion'){
                    $link .= '?filter_occasion='.$key;
                    if($params['search']['value'] != ''){
                        $link .= '&search_field=' . $params['search']['field'] . '&search_value=' . $params['search']['value'];
                    }
                    if($params['filter']['category'] != ''){
                        $link .= '&filter_category=' . $params['filter']['category'];
                    }
                
                    if($params['filter']['collection'] != ''){
                        $link .= '&filter_collection=' . $params['filter']['collection'];
                    }
    
                    if($params['filter']['type'] != ''){
                        $link .= '&filter_type=' . $params['filter']['type'];
                    }

                    if($params['filter']['status'] != ''){
                        $link .= '&filter_status=' . $params['filter']['status'];
                    }

                    if(isset($params['filter']['occasion']) && $params['filter']['occasion'] == $key){
                        $selectName = $value;
                    }
                }

                if($buttonName == 'category'){
                    $link .= '?filter_category='.$key;
                    if($params['search']['value'] != ''){
                        $link .= '&search_field=' . $params['search']['field'] . '&search_value=' . $params['search']['value'];
                    }
                    if($params['filter']['occasion'] != ''){
                        $link .= '&filter_occasion=' . $params['filter']['occasion'];
                    }
                
                    if($params['filter']['collection'] != ''){
                        $link .= '&filter_collection=' . $params['filter']['collection'];
                    }
    
                    if($params['filter']['type'] != ''){
                        $link .= '&filter_type=' . $params['filter']['type'];
                    }
                    if($params['filter']['status'] != ''){
                        $link .= '&filter_status=' . $params['filter']['status'];
                    }

                    if(isset($params['filter']['category']) && $params['filter']['category'] == $key){
                        $selectName = $value;
                    }
                }

                if($buttonName == 'collection'){
                    $link .= '?filter_collection='.$key;
                    if($params['search']['value'] != ''){
                        $link .= '&search_field=' . $params['search']['field'] . '&search_value=' . $params['search']['value'];
                    }
                    if($params['filter']['occasion'] != ''){
                        $link .= '&filter_occasion=' . $params['filter']['occasion'];
                    }
                
                    if($params['filter']['category'] != ''){
                        $link .= '&filter_category=' . $params['filter']['category'];
                    }
    
                    if($params['filter']['type'] != ''){
                        $link .= '&filter_type=' . $params['filter']['type'];
                    }
                    if($params['filter']['status'] != ''){
                        $link .= '&filter_status=' . $params['filter']['status'];
                    }

                    if(isset($params['filter']['collection']) && $params['filter']['collection'] == $key){
                        $selectName = $value;
                    }
                }

                if($buttonName == 'type'){
                    $link .= '?filter_type='.$key;
                    if($params['search']['value'] != ''){
                        $link .= '&search_field=' . $params['search']['field'] . '&search_value=' . $params['search']['value'];
                    }
                    if($params['filter']['occasion'] != ''){
                        $link .= '&filter_occasion=' . $params['filter']['occasion'];
                    }
                
                    if($params['filter']['category'] != ''){
                        $link .= '&filter_category=' . $params['filter']['category'];
                    }
    
                    if($params['filter']['collection'] != ''){
                        $link .= '&filter_collection=' . $params['filter']['collection'];
                    }

                    if($params['filter']['status'] != ''){
                        $link .= '&filter_status=' . $params['filter']['status'];
                    }

                    if(isset($params['filter']['type']) && $params['filter']['type'] == $key){
                        $selectName = $value;
                    }
                }
                

                $xhtmlField .= '<li class="nav-link">
                                    <a style="color: #800020" href="'.$link.'&filter_ajax=true" class="nav-item dropdown-item p-0 filter-ajax" data-field="'.$key.'">'.$value.'</a>
                                </li>';
            } 

            $xhtml = '<form>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <li class="dropdown nav-item" style="list-style-type: none; margin: 4px 1px">
                                    <button type="submit" class="dropdown-toggle btn btn-sm btn-warning" data-toggle="dropdown" style="padding: 5px 15p; width: 100%">
                                        '.$selectName.'
                                    </button>
                                    <ul class="dropdown-menu">
                                        '.$xhtmlField.'
                                    </ul>
                                </li>
                            </div>
                        </div>
                    </form>';
            return $xhtml;
        }

        public static function showOrderCart($controllerName, $params, $buttonName) {
            $selectName = 'Select ' . ucfirst($buttonName);
            $xhtmlField = '';

            $paramsSelectbox = [
                'all'           => 'All',
                'today'         => 'Today',
                'last_week'     => 'Last 07 Days',
                'last_month'    => 'Last 30 Days',
            ];
            foreach($paramsSelectbox as $key => $value){
                $link = route($controllerName) . '?order_by=' . $key;

                if($params['search']['value'] != ''){
                    $link .= '&search_field=' . $params['search']['field'] . '&search_value=' . $params['search']['value'];
                }

                if($params['filter']['status'] != ''){
                    $link .= '&filter_status=' . $params['filter']['status'];
                }

                if($params['filter']['method'] != ''){
                    $link .= '&filter_method=' . $params['filter']['method'];
                }

                if($params['filter']['sort_by'] != ''){
                    $link .= '&sort_by=' . $params['filter']['sort_by'];
                }

                if($params['filter']['order_by'] != '' && $params['filter']['order_by'] == $key){
                    $selectName = $value;
                }
                

                $xhtmlField .= '<li class="nav-link">
                                    <a style="color: #800020" href="'.$link.'&filter_ajax=true" class="nav-item dropdown-item p-0 filter-ajax" data-field="'.$key.'">'.$value.'</a>
                                </li>';
            } 

            $xhtml = '<div class="col-6 col-md-3">
                            <li class="dropdown nav-item" style="list-style-type: none; margin: 4px 1px">
                                <button type="submit" class="dropdown-toggle btn btn-sm btn-warning" data-toggle="dropdown" style="padding: 5px 15p; width: 100%">
                                    '.$selectName.'
                                </button>
                                <ul class="dropdown-menu">
                                    '.$xhtmlField.'
                                </ul>
                            </li>
                        </div>';
            return $xhtml;
        }

        public static function showSortCart($controllerName, $params, $buttonName) {
            $selectName = 'Select ' . ucfirst($buttonName);
            $xhtmlField = '';

            $paramsSelectbox = [
                'all'           => 'Default',
                'newest'        => 'Newest',
                'latest'        => 'Latest',
            ];
            foreach($paramsSelectbox as $key => $value){
                $link = route($controllerName) . '?sort_by=' . $key;

                if($params['search']['value'] != ''){
                    $link .= '&search_field=' . $params['search']['field'] . '&search_value=' . $params['search']['value'];
                }

                if($params['filter']['status'] != ''){
                    $link .= '&filter_status=' . $params['filter']['status'];
                }

                if($params['filter']['method'] != ''){
                    $link .= '&filter_method=' . $params['filter']['method'];
                }

                if($params['filter']['order_by'] != ''){
                    $link .= '&order_by=' . $params['filter']['order_by'];
                }

                if($params['filter']['sort_by'] != '' && $params['filter']['sort_by'] == $key){
                    $selectName = $value;
                }
                

                $xhtmlField .= '<li class="nav-link">
                                    <a style="color: #800020" href="'.$link.'&filter_ajax=true" class="nav-item dropdown-item p-0 filter-ajax" data-field="'.$key.'">'.$value.'</a>
                                </li>';
            } 

            $xhtml = '
                            <div class="col-6 col-md-3">
                                <li class="dropdown nav-item" style="list-style-type: none; margin: 4px 1px">
                                    <button type="submit" class="dropdown-toggle btn btn-sm btn-warning" data-toggle="dropdown" style="padding: 5px 15p; width: 100%">
                                        '.$selectName.'
                                    </button>
                                    <ul class="dropdown-menu">
                                        '.$xhtmlField.'
                                    </ul>
                                </li>
                            </div>';
            return $xhtml;
        }
    }
?>