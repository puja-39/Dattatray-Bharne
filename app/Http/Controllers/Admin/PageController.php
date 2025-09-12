<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Tax;
use App\Models\Item;
use App\Models\Page;

class PageController extends Controller
{
    
    public function index(){
        return view('backend.page.list');
    }

    public function add(){
        $page_data = array();
        $page_data['page_title']    = 'Add New Page';
        $page_data['page_action']   = route('admin.page.add_page');
        return view('backend.page.add-edit',$page_data);
    }

    public function new_page(Request $request)
    {
        // dd($request->all());

        $updated = array();
        $updated['type'] = 'admin';
        $updated['id'] = session('id');
        $status = false;
        $type = 'error';
        $title = translate('Page');
        $msg = translate('Invalid Request');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'is_active' => 'required',
            'description' => 'required',
        ]);
        $attrNames = [
            'name' => translate('Name'),
            'is_active' => translate('Status'),
            'description' => translate('Description'),
        ];
        $validator->setAttributeNames($attrNames);
        if ($validator->fails()) {
            return response()->json([
                'status' => $status,
                'type' => $type,
                'title'  => $title,
                'message'  => $validator->errors()->all()
            ]);
        }

        try {
            DB::beginTransaction();
            $up_data = array();
            $up_data['name'] = $request['name'];
            $up_data['slug'] = generateSlug('pages', $request['name']);
            $up_data['is_active'] = $request['is_active'];
            $up_data['description'] = $request['description'];
            $up_data['created_by'] = json_encode($updated);
            $up_data['updated_by'] = json_encode($updated);
            $page = Page::create($up_data);
            if (empty($page)) { 
                DB::rollBack();
                return response()->json([
                    'status' => $status,
                    'type' => $type,
                    'title'  => $title,
                    'message'  => translate('Something Went Wrong')
                ]);
            } else {
                DB::commit();
                return response()->json([
                    'status' => true,
                    'type' => 'success',
                    'title'  => $title,
                    'url' => route('admin.page'),
                    'message'  => translate('Details Added Successfully')
                ]);
            }
        } catch (\Exception $exp) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'type' => 'error',
                'title'  => $title,
                'message' => $exp->getMessage()
            ]);
        }
    }


    public function ajax_list(Request $request)
    {
        // dd($request->all());
        $totalData = $totalFiltered = 0;
        $datalist = [];
        $columns = $request['columns'];
        $data = array();
        $like = '';
        $order = '';
        $order_dir = '';
        $limit = $request['length'];
        $start = $request['start'];
        $search = $request['search'];
        if (isset($search['value']) && $search['value'] != '') {
            $like = $search['value'];
        }
        $order_array = $request['order'];
        if (isset($order_array[0]['column']) && $order_array[0]['column'] != 0) {
            $col_id = $order_array[0]['column'];
            $order = $columns[$col_id]['data'];
            $order_dir = $order_array[0]['dir'];
        }
        try {
            DB::beginTransaction();
            $totalData = Page::count();
            $totalFiltered = Page::where('name', 'LIKE', '%' . $like . '%')
                ->count();
            $datalist = Page::where('name', 'LIKE', '%' . $like . '%')
                ->skip($start)
                ->take($limit)
                ->orderBy($order, $order_dir)
                ->get();
            DB::commit();
        } catch (\Exception $exp) {
            DB::rollBack();
        }
        if (isset($datalist) && ! empty($datalist)) {
            foreach ($datalist as $list) {
                $edit = '';
                if (valid_session('page', 'edit', false)) {
                    $edit = '<a href="' . route('admin.page.edit', ['id' => encode_string($list->id)]) . '" class="btn ripple btn-primary btn-sm mt-1 mb-1 text-sm text-white" data-placement="top" data-toggle="tooltip" title="' . translate('Edit') . '"> <i class="fa fa-edit"></i> </a>';
                }
                $details = '<a href="' . route('admin.page.quick_details', ['id' => encode_string($list->id)]) . '" class="btn ripple btn-secondary btn-sm mt-1 mb-1 text-sm popup-page" data-placement="top" data-toggle="tooltip" title="' . translate('Details') . '"> <i class="fa fa-eye"></i> </a>';
                $status = $list->is_active == '1' ? '<span class="badge bg-success cursor-pointer change-status" data-action="change_status" data-id="' . encode_string($list->id) . '" data-url="' . route('admin.page.change-status') . '">' . translate('Active') . '</span>' : '<span class="badge bg-danger cursor-pointer change-status" data-action="change_status" data-id="' . encode_string($list->id) . '" data-url="' . route('admin.page.change-status') . '">' . translate('Inactive') . '</span>';
               

                $nestedData = array();
                $nestedData['id']           = $list->id;
                $nestedData['name']           = $list->name;
                $nestedData['created_at']   = Carbon::parse($list->created_at)->format('M d, Y h:i A');
                $nestedData['status']       = $status;
                $nestedData['actions']      = '<div class="btn-group" role="group"">' . $edit . $details . '</div>';
                $data[]                     = $nestedData;
            }
        }
        return response()->json([
            "draw"            => $request['draw'],
            "recordsTotal"    => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data,
        ]);
    }

    public function quick_details(Request $request, $id)
    {
        $id = decode_string($id);
        $page = array();
        try {
            DB::beginTransaction();
            $page = Page::where('id', '=', $id)
                ->first();
            DB::commit();
        } catch (\Exception $exp) {
            DB::rollBack();
            //$exp->getMessage();
        }
        if ($request->ajax() && !empty($page)) {
            return view('backend.page.quick_details', compact('page'));
        } else {
            abort(404);
        }
    }

    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            $status = false;
            $type = 'error';
            $title = translate('Update Page');
            $msg = translate('Invalid Request');
            if (!valid_session('page', 'edit', false)) {
                return response()->json([
                    'status' => $status,
                    'type' => $type,
                    'title'  => $title,
                    'message'  => $msg
                ]);
            }
            $id = session('id');
            $updated = array();
            $updated['type'] = 'admin';
            $updated['id'] = $id;
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'action' => 'required'
            ]);
            $attrNames = [
                'id' => translate('id')
            ];
            $validator->setAttributeNames($attrNames);
            if ($validator->fails()) {
                return response()->json([
                    'status' => $status,
                    'type' => $type,
                    'title'  => $title,
                    'message'  => $validator->errors()->all()
                ]);
            }
            try {
                DB::beginTransaction();
                if ($request['id'] != '') {
                    $id = decode_string($request['id']);
                    $role = Page::where('id', '=', $id)->first();
                    $up_data = array();
                    $up_data['is_active'] = '1';
                    if ($role->is_active == '1') {
                        $up_data['is_active'] = '0';
                    }
                    $up_data['updated_by'] = json_encode($updated);
                    $role_id = Page::where('id', '=', $id)->update($up_data);
                    if (empty($role_id)) {
                        DB::rollBack();
                        return response()->json([
                            'status' => $status,
                            'type' => $type,
                            'title'  => $title,
                            'message'  => translate('Something Went Wrong')
                        ]);
                    } else {
                        DB::commit();
                        return response()->json([
                            'status' => true,
                            'type' => 'success',
                            'title'  => $title,
                            'reload' => true,
                            'message'  => translate('Status Update Successfully')
                        ]);
                    }
                }
            } catch (\Exception $exp) {
                DB::rollBack();
                return response([
                    'status' => false,
                    'type' => 'error',
                    'title'  => $title,
                    'message' => $msg
                    // 'message' => $exp->getMessage()
                ]);
            }
        } else {
            abort(404);
        }
    }

    public function edit(Request $request, $id)
    {
        $id = decode_string($id);
        $page_data = array();
        $page_data['page_title'] = 'Update Page';
        $page_data['id'] = '';
        $page_data['page_action'] = route('admin.page.edit_page');
        if ($id != '') {
            $page_data['id'] = encode_string($id);
            $page_data['page'] = Page::where('id', '=', $id)
                ->first();
        }
        return view('backend.page.add-edit', $page_data);
    }

    public function edit_page(Request $request)
    {
        // dd($request->all());

        $updated = array();
        $updated['type'] = 'admin';
        $updated['id'] = session('id');
        $status = false;
        $type = 'error';
        $title = translate('Page');
        $msg = translate('Invalid Request');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'is_active' => 'required',
            'description' => 'required',
        ]);
        $attrNames = [
            'name' => translate('Name'),
            'is_active' => translate('Is Active'),
            'description' => translate('Description'),
        ];
        $validator->setAttributeNames($attrNames);
        if ($validator->fails()) {
            return response()->json([
                'status' => $status,
                'type' => $type,
                'title'  => $title,
                'message'  => $validator->errors()->all()
            ]);
        }
        try {
            DB::beginTransaction();
            if ($request['id'] != '') {
                $id = decode_string($request['id']);
                $page = Page::where('id', '=', $id)->first();
                $up_data = array();
                $up_data['name'] = $request['name'];
                $up_data['is_active'] = $request['is_active'];
                if ($page && $page->name !== $request['name']) {
                    $up_data['slug'] = generateSlug('pages', $request['name']);
                } else {
                    $up_data['slug'] = $page->slug;
                }
                $up_data['description'] = $request['description'];
                $up_data['updated_by'] = json_encode($updated);

                $Page = Page::where('id', '=', $id)
                    ->update($up_data);
                if (empty($Page)) {
                    DB::rollBack();
                    return response()->json([
                        'status' => $status,
                        'type' => $type,
                        'title'  => $title,
                        'message'  => translate('Something Went Wrong')
                    ]);
                } else {
                    DB::commit();
                    return response()->json([
                        'status' => true,
                        'type' => 'success',
                        'title'  => $title,
                        'url' => route('admin.page'),
                        'message'  => translate('Details Updated Successfully')
                    ]);
                }
            }
        } catch (\Exception $exp) {
            DB::rollBack();
            return response([
                'status' => false,
                'type' => 'error',
                'title'  => $title,
                'message' => $msg
            ]);
        }
    }


    public function frontend_legal_pages($slug)
    {
        // dd($slug);
        $page = Page::where('slug', '=', $slug)
            ->where('is_active', '=', '1')
            ->first();
        if (empty($page)) {
            abort(404);
        }
        return view('frontend.legal-pages', compact('page'));
    }

}
