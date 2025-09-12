<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Gallery;
class GalleryController extends Controller
{
    public function index(){
        return view('backend.gallery.list');
    }

    public function add(Request $request)
    {
        if ($request->ajax()) {
            $page_data = array();
            $page_data['page_title'] = 'Add New Gallery';
            $page_data['page_action'] = route('admin.gallery.add_gallery');                              
            return view('backend.gallery.add-edit', $page_data);
        } else {
            abort(404);
        }
    }

    public function new_gallery(Request $request)
    {
        // dd($request->all());
        $updated = array();
        $updated['type'] = 'admin';
        $updated['id'] = session('id');
        $status = false;
        $type = 'error';
        $title = translate('Gallery');
        $msg = translate('Invalid Request');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'is_active' => 'required',
            'short_description' => 'required',
            'image' => 'required',
            'images' => 'required'
        ]);
        $attrNames = [
            'name' => translate('Name'),
            'is_active' => translate('Status'),
            'short_description' => translate('Short Description'),
            'image' => translate('Image'),
            'images' => translate('Multiple Images'),
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
            $up_data['slug'] = generateSlug('gallery',$request['name']);
            $up_data['short_description'] = $request['short_description'];
            $up_data['image'] = $request['image']?? '';
            if (empty($up_data['image'])) {
                $up_data['image'] = 'default.png';
            }
            $up_data['images']= $request['images'];
            $up_data['is_active'] = $request['is_active'];
            $up_data['created_by'] = json_encode($updated);
            $up_data['updated_by'] = json_encode($updated);
            $gallery = Gallery::insert($up_data);
            if (empty($gallery)) {
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
                    'message'  => translate('Details Added Successfully')
                ]);
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
            $totalData = Gallery::count();
            $totalFiltered = Gallery::where('name', 'LIKE', '%' . $like . '%')
                ->count();
            $datalist = Gallery::where('name', 'LIKE', '%' . $like . '%')
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
                if (valid_session('gallery', 'edit', false)) {
                    $edit = '<a href="' . route('admin.gallery.edit', ['id' => encode_string($list->id)]) . '" class="btn ripple btn-primary btn-sm mt-1 mb-1 text-sm text-white popup-page" data-placement="top" data-toggle="tooltip" title="' . translate('Edit') . '"> <i class="fa fa-edit"></i> </a>';
                }
                $details = '<a href="' . route('admin.gallery.quick_details', ['id' => encode_string($list->id)]) . '" class="btn ripple btn-secondary btn-sm mt-1 mb-1 text-sm popup-page" data-placement="top" data-toggle="tooltip" title="' . translate('Details') . '"> <i class="fa fa-eye"></i> </a>';
                $status = $list->is_active == '1' ? '<span class="badge bg-success cursor-pointer change-status" data-action="change_status" data-id="' . encode_string($list->id) . '" data-url="' . route('admin.gallery.change-status') . '">' . translate('Active') . '</span>' : '<span class="badge bg-danger cursor-pointer change-status" data-action="change_status" data-id="' . encode_string($list->id) . '" data-url="' . route('admin.gallery.change-status') . '">' . translate('Inactive') . '</span>';
                  $image = uploads_url($list->image,uploads_url('default.png'));
                //    dd($image);
                $nestedData = array();
                $nestedData['id']           = $list->id;
               $nestedData['image']        = '<a data-fancybox="image" data-src="'.$image.'" data-caption="'.$list->name.'"><img alt="'.$list->name.'" class="radius cursor-pointer image-delay" src="'.uploads_url('loader.gif').'" data-src="'.$image.'" style="width:48px;height:48px;"></a>'; 
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
        $gallery = array();
        try {
            DB::beginTransaction();
            $gallery = Gallery::where('id', '=', $id)->first();
            // dd($gallery);
            DB::commit();
        } catch (\Exception $exp) {
            DB::rollBack();
            //$exp->getMessage();
        }
        if ($request->ajax() && !empty($gallery)) {
            return view('backend.gallery.quick_details', compact('gallery'));
        } else {
            abort(404);
        }
    }

    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            $status = false;
            $type = 'error';
            $title = translate('Update Gallery');
            $msg = translate('Invalid Request');
            if (!valid_session('gallery', 'edit', false)) {
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
                    $role = Gallery::where('id', '=', $id)->first();
                    $up_data = array();
                    $up_data['is_active'] = '1';
                    if ($role->is_active == '1') {
                        $up_data['is_active'] = '0';
                    }
                    $up_data['updated_by'] = json_encode($updated);
                    $role_id = Gallery::where('id', '=', $id)->update($up_data);
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
        if ($request->ajax()) {
            $id = decode_string($id);
            $page_data = array();
            $page_data['page_title'] = 'Update Gallery';
            $page_data['id'] = '';
            $page_data['page_action'] = route('admin.gallery.edit_gallery');
            if ($id != '') {
                $page_data['id'] = encode_string($id);
                $page_data['gallery'] = Gallery::where('id', '=', $id)
                    ->first();
            }
            return view('backend.gallery.add-edit', $page_data);
        } else {
            abort(404);
        }
    }

    public function edit_gallery(Request $request)
    {
        $updated = array();
        $updated['type'] = 'admin';
        $updated['id'] = session('id');
        $status = false;
        $type = 'error';
        $title = translate(' Gallery');
        $msg = translate('Invalid Request');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'is_active' => 'required',
            
        ]);
        $attrNames = [
            'name' => translate('name'),
            'is_active' => translate('Status'),
            'short_description'=> translate('Short_description'),
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
                $up_data = array();
                $up_data['name'] = $request['name'];
                $up_data['slug'] = generateSlug('gallery',$request['name']);
                $up_data['short_description'] = $request['short_description'];
                $up_data['image'] = $request['image']?? '';
            if (empty($up_data['image'])) {
                $up_data['image'] = 'default.png';
            }
                $up_data['images']= $request['images']; 
                $up_data['is_active'] = $request['is_active'];
                $up_data['created_by'] = json_encode($updated);
                $up_data['updated_by'] = json_encode($updated);

                $gallery = Gallery::where('id', '=', $id)
                    ->update($up_data);
                if (empty($gallery)) {
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
}
