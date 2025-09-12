<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;
use Artisan;
use App\Models\User;

class Dashboard extends Controller
{
public function index() {
    $page_data = array();
    $page_data['enquiry_count'] = Contact::all()->count();  
    $page_data['blog_count'] = Blog::all()->count(); 
    $page_data['our_indapur_count'] = Blog::all()->count(); 
    $user = User::where('id', session('id'))->first();
    $role_id = $user->role_id;    
    return view('backend.dashboard.dashboard', $page_data,compact('role_id'));
   }
    function clear_cache(Request $request){
        Artisan::call('optimize:clear');
        return back();
   }
     public function contact_list(Request $request){
        $totalData = $totalFiltered = 0; $datalist = [];
        $columns = $request['columns'];
        $data = array();
        $like = '';
        $order = '';
        $order_dir = '';
        $limit = $request['length'];
        $start = $request['start'];
        $search = $request['search'];
        if(isset($search['value']) && $search['value']!=''){
            $like = $search['value'];
        }
        $order_array= $request['order'];
        if(isset($order_array[0]['column']) && $order_array[0]['column']!=0){
            $col_id = $order_array[0]['column'];
            $order = $columns[$col_id]['data'];
            $order_dir = $order_array[0]['dir'];
        }
        try {
            DB::beginTransaction();
                $totalData = Contact::count();
                $totalFiltered = Contact::where('name','LIKE','%'.$like.'%')
                                ->count();
                $datalist = Contact::where('name','LIKE','%'.$like.'%')
                                ->skip($start)
                                ->take($limit)
                                ->orderBy($order,$order_dir)
                                ->get();
            DB::commit();
        } catch(\Exception $exp) {
            DB::rollBack();
        }
        if ( isset($datalist) && ! empty($datalist)) {
            foreach ($datalist as $list) {
                $details = '<a href="'.route('admin.enquiry.contact_details',['id'=>encode_string($list->id)]).'" class="btn ripple btn-secondary btn-sm mt-1 mb-1 text-sm text-white popup-page" data-placement="top" data-toggle="tooltip" title="'.translate('Details').'"> <i class="fa fa-eye"></i> </a>';
                $nestedData = array();
                $nestedData['id']           = $list->id;   
                $nestedData['name']         = $list->name;
                $nestedData['email_id']  = $list->email_id;
                 $nestedData['phone_no']  = $list->phone_no;
                 $nestedData['message']  = $list->message;
                $nestedData['created_at']   = $list->created_at;
                $nestedData['actions']      = '<div class="btn-group" role="group"">'.$details.'</div>';
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
   
}
