<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;
use App\Models\Subscribe;
use Carbon\Carbon;

class Enquiry extends Controller
{
    public function contact(){
        return view('backend.enquiry.contact_list');
    }

    public function contact_list(Request $request){
        // dd($request->all());
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
                // dd($datalist);
            DB::commit();
        } catch(\Exception $exp) {
            DB::rollBack();
        }
        if ( isset($datalist) && ! empty($datalist)) {
            foreach ($datalist as $list) {
                //  dd($list);
                $details = '<a href="'.route('admin.enquiry.contact_details',['id'=>encode_string($list->id)]).'" class="btn ripple btn-secondary btn-sm mt-1 mb-1 text-sm text-white popup-page" data-placement="top" data-toggle="tooltip" title="'.translate('Details').'"> <i class="fa fa-eye"></i> </a>';
                $nestedData = array();
                // dd($list);
                $nestedData['id']           = $list->id;   
                $nestedData['name']         = $list->name;
                $nestedData['email']        = $list->email;
                $nestedData['phone_no']     = $list->phone_no;
                $nestedData['message']      = $list->message;
                $nestedData['created_at']   = Carbon::parse($list->created_at)->format('M d, Y h:i A');
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
    public function contact_details(Request $request, $id){
        $id = decode_string($id);
        $contact = array();
        try {
            DB::beginTransaction();
                $contact = Contact::where('id','=',$id)->first();
                // dd($contact);
            DB::commit();
        } catch(\Exception $exp) {
            DB::rollBack();
            //$exp->getMessage();
        }
        if ($request->ajax() && !empty($contact)) {
            return view('backend.enquiry.popup-details_contact',$contact);
        }else{
            abort(404);
        }
      }
    
 
    public function new_subscribe(Request $request)
    {
        // dd($request->all());
        $rules = [
        'newsletter_email' => 'required|email|unique:subscribe,newsletter_email',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ],200);
        }
        $subscribe = new Subscribe();
        $subscribe->newsletter_email = $request->input('newsletter_email');
        $subscribe->created_at = now();
        $subscribe->updated_at = null;
        $subscribe->save(); 

        return response()->json([
       'status' => true,
       'message' => 'Thank you! Your message has been sent',
         ]);
         
    }
      
     public function subscribe(){
        return view('backend.enquiry.subscribe_list');
     }

     public function subscribe_list(Request $request)
     {
        // dd($request->all());
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
                $totalData = Subscribe::count();
                $totalFiltered = Subscribe::where('newsletter_email','LIKE','%'.$like.'%')
                                ->count();
                $datalist = Subscribe::where('newsletter_email','LIKE','%'.$like.'%')
                                ->skip($start)
                                ->take($limit)
                                ->orderBy($order,$order_dir)
                                ->get();
                // dd($datalist);
            DB::commit();
        } catch(\Exception $exp) {
            DB::rollBack();
        }
        if ( isset($datalist) && ! empty($datalist)) {
            foreach ($datalist as $list) {
                //  dd($list);
                $details = '<a href="'.route('admin.enquiry.subscribe_details',['id'=>encode_string($list->id)]).'" class="btn ripple btn-secondary btn-sm mt-1 mb-1 text-sm text-white popup-page" data-placement="top" data-toggle="tooltip" title="'.translate('Details').'"> <i class="fa fa-eye"></i> </a>';
                $nestedData = array();
                // dd($list);
                $nestedData['id']           = $list->id;   
                $nestedData['email']    = $list->newsletter_email;
                $nestedData['created_at']   = Carbon::parse($list->created_at)->format('M d, Y h:i A');
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

        public function subscribe_details(Request $request, $id)
      {
        // dd($request->all());
        $id = decode_string($id);
        $contact = array();
        try {
            DB::beginTransaction();
                $subscribe = Subscribe::where('id','=',$id)->first();
                // dd($subscribe);
            DB::commit();
        } catch(\Exception $exp) {
            DB::rollBack();
            $exp->getMessage();
        }
        if ($request->ajax() && !empty($subscribe)) {
            return view('backend.enquiry.popup-details_subscribe' ,  ['subscribe' => $subscribe]);
        }else{
            abort(404);
        }
      }    
      
     public function joinWithUs(){
        return view('backend.enquiry.joinWithus_list');
     }

        public function new_joinWithUs(Request $request)
    {
        // dd($request->all());
        $rules = [
              'phone_no' =>['required', 'regex:/^[6-9][0-9]{9}$/'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ],200);
        }
        $subscribe = new Subscribe();
        $subscribe->newsletter_email = $request->input('newsletter_email');
        $subscribe->created_at = now();
        $subscribe->updated_at = null;
        $subscribe->save(); 

        return response()->json([
       'status' => true,
       'message' => 'Thank you! Your message has been sent',
         ]);         
     }
      public function joinWithus_list(Request $request)
     {
        // dd($request->all());
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
                $totalData = Subscribe::count();
                $totalFiltered = Subscribe::where('newsletter_email','LIKE','%'.$like.'%')
                                ->count();
                $datalist = Subscribe::where('newsletter_email','LIKE','%'.$like.'%')
                                ->skip($start)
                                ->take($limit)
                                ->orderBy($order,$order_dir)
                                ->get();
                // dd($datalist);
            DB::commit();
        } catch(\Exception $exp) {
            DB::rollBack();
        }
        if ( isset($datalist) && ! empty($datalist)) {
            foreach ($datalist as $list) {
                //  dd($list);
                $details = '<a href="'.route('admin.enquiry.joinWithUs_details',['id'=>encode_string($list->id)]).'" class="btn ripple btn-secondary btn-sm mt-1 mb-1 text-sm text-white popup-page" data-placement="top" data-toggle="tooltip" title="'.translate('Details').'"> <i class="fa fa-eye"></i> </a>';
                $nestedData = array();
                // dd($list);
                $nestedData['id']           = $list->id;   
                $nestedData['email']    = $list->newsletter_email;
                $nestedData['created_at']   = Carbon::parse($list->created_at)->format('M d, Y h:i A');
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

     public function joinWithUs_details(Request $request, $id)
      {
        // dd($request->all());
        $id = decode_string($id);
        $contact = array();
        try {
            DB::beginTransaction();
                $subscribe = Subscribe::where('id','=',$id)->first();
                // dd($subscribe);
            DB::commit();
        } catch(\Exception $exp) {
            DB::rollBack();
            $exp->getMessage();
        }
        if ($request->ajax() && !empty($subscribe)) {
            return view('backend.enquiry.popup-details_joinWithUs' ,  ['subscribe' => $subscribe]);
        }else{
            abort(404);
        }
      }    

}
