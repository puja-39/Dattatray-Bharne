<?php
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Language_translation;
use App\Models\User;
use App\Models\Role;
use App\Models\Settings;
use App\Models\Category;


if(!function_exists('getBearerToken')){
    function getBearerToken(){
        $headers = null;
        if(isset($_SERVER['Authorization']) && $_SERVER['Authorization']!='') {
            $headers = trim($_SERVER["Authorization"]);
        }else if (isset($_SERVER['HTTP_AUTHORIZATION']) && $_SERVER['HTTP_AUTHORIZATION']!='') {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        }elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization']) && $requestHeaders['Authorization']!='') {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return str_replace('Bearer ','',$headers);
    }
}

if(!function_exists('get_parent_categories')){
    function get_parent_categories($id=0,$data=array()){
        $category = Category::where('id','=',$id)->first();
        if(isset($category) && !empty($category)){
            $data[] = $category['id'];
            return get_parent_categories($category['parent_id'],$data);
        }
        return array_reverse($data);
    }
}

if(!function_exists('rearrange_categories')){
    function rearrange_categories(){
        $category = Category::get();
        if(isset($category) && !empty($category)){ foreach ($category as $key => $value) {
            $path_array = get_parent_categories($value['parent_id']);
            $path = !empty($path_array) ? implode('-', $path_array) : 0;
            Category::where('id','=',$value['id'])->update(['path'=>$path]);
        } }
    }
}

if(!function_exists('get_category_path_name_string')){
    function get_category_path_name_string($path=0,$id=0){
        if($path!=0){
            $list = array();
            $paths = explode('-', $path);
            foreach ($paths as $key => $value) {
                $list[] = getColumnValue('category',['id'=>$value],'name');
            }
            if($id!=0){
                $list[] = getColumnValue('category',['id'=>$id],'name');
            }
            return implode(' » ', $list);
        }else{
            if($id!=0){
                return getColumnValue('category',['id'=>$id],'name');
            }else{
                return translate('No Parent');
            }
        }
    }
}



if (!function_exists('app_setting')) {
    function app_setting($key, $default = null){
        $settings = Cache::remember('app_settings', 86400, function () {
            return Settings::all();
        });

        $setting = $settings->where('key', $key)->first();

        return $setting == null ? $default : $setting->value;
    }
}
if(!function_exists('create_dt_length_menu')){
    function create_dt_length_menu($rpp = ''){
        $list = array(10,20,25,50,100,500);
        if($rpp!=''){ $list[] = $rpp; }
        $list = array_unique($list); sort($list);
        $list = implode(",",$list);
        return '['.$list.']';
    }
}
if(!function_exists('encode_string')){
    function encode_string($string){
        $string = Crypt::encryptString($string);
        return $string;
    }
}
if(!function_exists('decode_string')){
    function decode_string($string){
        $string = Crypt::decryptString($string);
        return $string;
    }
}
if (!function_exists('translate')) {
    function translate($key, $lang = null, $addslashes = false){
        if ($lang == null) {
            $lang = App::getLocale();
        }

        $lang_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($key)));
        $translations_en = Cache::rememberForever('translations-en', function () {
            return Language_translation::where('lang', 'en')->pluck('lang_value', 'lang_key')->toArray();
        });

        if (!isset($translations_en[$lang_key])) {
            $translation_def = new Language_translation;
            $translation_def->lang = 'en';
            $translation_def->lang_key = $lang_key;
            $translation_def->lang_value = str_replace(array("\r", "\n", "\r\n"), "", $key);
            $translation_def->save();
            Cache::forget('translations-en');
        }

        // return user session lang
        $translation_locale = Cache::rememberForever("translations-{$lang}", function () use ($lang) {
            return Language_translation::where('lang', $lang)->pluck('lang_value', 'lang_key')->toArray();
        });
        if (isset($translation_locale[$lang_key])) {
            return $addslashes ? addslashes(trim($translation_locale[$lang_key])) : trim($translation_locale[$lang_key]);
        }

        // return default lang if session lang not found
        $translations_default = Cache::rememberForever('translations-' . env('DEFAULT_LANGUAGE', 'en'), function () {
            return Language_translation::where('lang', env('DEFAULT_LANGUAGE', 'en'))->pluck('lang_value', 'lang_key')->toArray();
        });
        if (isset($translations_default[$lang_key])) {
            return $addslashes ? addslashes(trim($translations_default[$lang_key])) : trim($translations_default[$lang_key]);
        }

        // fallback to en lang
        if (!isset($translations_en[$lang_key])) {
            return trim($key);
        }
        return $addslashes ? addslashes(trim($translations_en[$lang_key])) : trim($translations_en[$lang_key]);
    }
}
if (!function_exists('app_timezone')) {
    function app_timezone()
    {
        return config('app.timezone');
    }
}

if (!function_exists('static_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function static_asset($path, $secure = null)
    {
        return app('url')->asset('public/' . $path, $secure);
    }
}

if (!function_exists('home_site_url')) {
    function home_site_url($url="") {
        return getBaseURL($url);
    }
}
if (!function_exists('isHttps')) {
    function isHttps()
    {
        return !empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS']);
    }
}

if (!function_exists('getBaseURL')) {
    function getBaseURL()
    {
        // $root = '//' . $_SERVER['HTTP_HOST'];
        $root = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]";
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        return $root;
    }
}


if (!function_exists('getFileBaseURL')) {
    function getFileBaseURL()
    {
        return getBaseURL() . 'public/';
    }
}


if (!function_exists('isUnique')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function isUnique($email)
    {
        $user = \App\Models\User::where('email', $email)->first();

        if ($user == null) {
            return true; // $user = null means we did not get any match with the email provided by the user inside the database
        } else {
            return false;
        }
    }
}

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null, $lang = false)
    {
        $settings = Cache::remember('business_settings', 86400, function () {
            return BusinessSetting::all();
        });

        if ($lang == false) {
            $setting = $settings->where('type', $key)->first();
        } else {
            $setting = $settings->where('type', $key)->where('lang', $lang)->first();
            $setting = !$setting ? $settings->where('type', $key)->first() : $setting;
        }
        return $setting == null ? $default : $setting->value;
    }
}


if (!function_exists('timezones')) {
    function timezones()
    {
        return [
            '(GMT-12:00) International Date Line West' => 'Pacific/Kwajalein',
            '(GMT-11:00) Midway Island' => 'Pacific/Midway',
            '(GMT-11:00) Samoa' => 'Pacific/Apia',
            '(GMT-10:00) Hawaii' => 'Pacific/Honolulu',
            '(GMT-09:00) Alaska' => 'America/Anchorage',
            '(GMT-08:00) Pacific Time (US & Canada)' => 'America/Los_Angeles',
            '(GMT-08:00) Tijuana' => 'America/Tijuana',
            '(GMT-07:00) Arizona' => 'America/Phoenix',
            '(GMT-07:00) Mountain Time (US & Canada)' => 'America/Denver',
            '(GMT-07:00) Chihuahua' => 'America/Chihuahua',
            '(GMT-07:00) La Paz' => 'America/Chihuahua',
            '(GMT-07:00) Mazatlan' => 'America/Mazatlan',
            '(GMT-06:00) Central Time (US & Canada)' => 'America/Chicago',
            '(GMT-06:00) Central America' => 'America/Managua',
            '(GMT-06:00) Guadalajara' => 'America/Mexico_City',
            '(GMT-06:00) Mexico City' => 'America/Mexico_City',
            '(GMT-06:00) Monterrey' => 'America/Monterrey',
            '(GMT-06:00) Saskatchewan' => 'America/Regina',
            '(GMT-05:00) Eastern Time (US & Canada)' => 'America/New_York',
            '(GMT-05:00) Indiana (East)' => 'America/Indiana/Indianapolis',
            '(GMT-05:00) Bogota' => 'America/Bogota',
            '(GMT-05:00) Lima' => 'America/Lima',
            '(GMT-05:00) Quito' => 'America/Bogota',
            '(GMT-04:00) Atlantic Time (Canada)' => 'America/Halifax',
            '(GMT-04:00) Caracas' => 'America/Caracas',
            '(GMT-04:00) La Paz' => 'America/La_Paz',
            '(GMT-04:00) Santiago' => 'America/Santiago',
            '(GMT-03:30) Newfoundland' => 'America/St_Johns',
            '(GMT-03:00) Brasilia' => 'America/Sao_Paulo',
            '(GMT-03:00) Buenos Aires' => 'America/Argentina/Buenos_Aires',
            '(GMT-03:00) Georgetown' => 'America/Argentina/Buenos_Aires',
            '(GMT-03:00) Greenland' => 'America/Godthab',
            '(GMT-02:00) Mid-Atlantic' => 'America/Noronha',
            '(GMT-01:00) Azores' => 'Atlantic/Azores',
            '(GMT-01:00) Cape Verde Is.' => 'Atlantic/Cape_Verde',
            '(GMT) Casablanca' => 'Africa/Casablanca',
            '(GMT) Dublin' => 'Europe/London',
            '(GMT) Edinburgh' => 'Europe/London',
            '(GMT) Lisbon' => 'Europe/Lisbon',
            '(GMT) London' => 'Europe/London',
            '(GMT) UTC' => 'UTC',
            '(GMT) Monrovia' => 'Africa/Monrovia',
            '(GMT+01:00) Amsterdam' => 'Europe/Amsterdam',
            '(GMT+01:00) Belgrade' => 'Europe/Belgrade',
            '(GMT+01:00) Berlin' => 'Europe/Berlin',
            '(GMT+01:00) Bern' => 'Europe/Berlin',
            '(GMT+01:00) Bratislava' => 'Europe/Bratislava',
            '(GMT+01:00) Brussels' => 'Europe/Brussels',
            '(GMT+01:00) Budapest' => 'Europe/Budapest',
            '(GMT+01:00) Copenhagen' => 'Europe/Copenhagen',
            '(GMT+01:00) Ljubljana' => 'Europe/Ljubljana',
            '(GMT+01:00) Madrid' => 'Europe/Madrid',
            '(GMT+01:00) Paris' => 'Europe/Paris',
            '(GMT+01:00) Prague' => 'Europe/Prague',
            '(GMT+01:00) Rome' => 'Europe/Rome',
            '(GMT+01:00) Sarajevo' => 'Europe/Sarajevo',
            '(GMT+01:00) Skopje' => 'Europe/Skopje',
            '(GMT+01:00) Stockholm' => 'Europe/Stockholm',
            '(GMT+01:00) Vienna' => 'Europe/Vienna',
            '(GMT+01:00) Warsaw' => 'Europe/Warsaw',
            '(GMT+01:00) West Central Africa' => 'Africa/Lagos',
            '(GMT+01:00) Zagreb' => 'Europe/Zagreb',
            '(GMT+02:00) Athens' => 'Europe/Athens',
            '(GMT+02:00) Bucharest' => 'Europe/Bucharest',
            '(GMT+02:00) Cairo' => 'Africa/Cairo',
            '(GMT+02:00) Harare' => 'Africa/Harare',
            '(GMT+02:00) Helsinki' => 'Europe/Helsinki',
            '(GMT+02:00) Istanbul' => 'Europe/Istanbul',
            '(GMT+02:00) Jerusalem' => 'Asia/Jerusalem',
            '(GMT+02:00) Kyev' => 'Europe/Kiev',
            '(GMT+02:00) Minsk' => 'Europe/Minsk',
            '(GMT+02:00) Pretoria' => 'Africa/Johannesburg',
            '(GMT+02:00) Riga' => 'Europe/Riga',
            '(GMT+02:00) Sofia' => 'Europe/Sofia',
            '(GMT+02:00) Tallinn' => 'Europe/Tallinn',
            '(GMT+02:00) Vilnius' => 'Europe/Vilnius',
            '(GMT+03:00) Baghdad' => 'Asia/Baghdad',
            '(GMT+03:00) Kuwait' => 'Asia/Kuwait',
            '(GMT+03:00) Moscow' => 'Europe/Moscow',
            '(GMT+03:00) Nairobi' => 'Africa/Nairobi',
            '(GMT+03:00) Riyadh' => 'Asia/Riyadh',
            '(GMT+03:00) St. Petersburg' => 'Europe/Moscow',
            '(GMT+03:00) Volgograd' => 'Europe/Volgograd',
            '(GMT+03:30) Tehran' => 'Asia/Tehran',
            '(GMT+04:00) Abu Dhabi' => 'Asia/Muscat',
            '(GMT+04:00) Baku' => 'Asia/Baku',
            '(GMT+04:00) Muscat' => 'Asia/Muscat',
            '(GMT+04:00) Tbilisi' => 'Asia/Tbilisi',
            '(GMT+04:00) Yerevan' => 'Asia/Yerevan',
            '(GMT+04:30) Kabul' => 'Asia/Kabul',
            '(GMT+05:00) Ekaterinburg' => 'Asia/Yekaterinburg',
            '(GMT+05:00) Islamabad' => 'Asia/Karachi',
            '(GMT+05:00) Karachi' => 'Asia/Karachi',
            '(GMT+05:00) Tashkent' => 'Asia/Tashkent',
            '(GMT+05:30) Chennai' => 'Asia/Kolkata',
            '(GMT+05:30) Kolkata' => 'Asia/Kolkata',
            '(GMT+05:30) Mumbai' => 'Asia/Kolkata',
            '(GMT+05:30) New Delhi' => 'Asia/Kolkata',
            '(GMT+05:45) Kathmandu' => 'Asia/Kathmandu',
            '(GMT+06:00) Almaty' => 'Asia/Almaty',
            '(GMT+06:00) Astana' => 'Asia/Dhaka',
            '(GMT+06:00) Dhaka' => 'Asia/Dhaka',
            '(GMT+06:00) Novosibirsk' => 'Asia/Novosibirsk',
            '(GMT+06:00) Sri Jayawardenepura' => 'Asia/Colombo',
            '(GMT+06:30) Rangoon' => 'Asia/Rangoon',
            '(GMT+07:00) Bangkok' => 'Asia/Bangkok',
            '(GMT+07:00) Hanoi' => 'Asia/Bangkok',
            '(GMT+07:00) Jakarta' => 'Asia/Jakarta',
            '(GMT+07:00) Krasnoyarsk' => 'Asia/Krasnoyarsk',
            '(GMT+08:00) Beijing' => 'Asia/Hong_Kong',
            '(GMT+08:00) Chongqing' => 'Asia/Chongqing',
            '(GMT+08:00) Hong Kong' => 'Asia/Hong_Kong',
            '(GMT+08:00) Irkutsk' => 'Asia/Irkutsk',
            '(GMT+08:00) Kuala Lumpur' => 'Asia/Kuala_Lumpur',
            '(GMT+08:00) Perth' => 'Australia/Perth',
            '(GMT+08:00) Singapore' => 'Asia/Singapore',
            '(GMT+08:00) Taipei' => 'Asia/Taipei',
            '(GMT+08:00) Ulaan Bataar' => 'Asia/Irkutsk',
            '(GMT+08:00) Urumqi' => 'Asia/Urumqi',
            '(GMT+09:00) Osaka' => 'Asia/Tokyo',
            '(GMT+09:00) Sapporo' => 'Asia/Tokyo',
            '(GMT+09:00) Seoul' => 'Asia/Seoul',
            '(GMT+09:00) Tokyo' => 'Asia/Tokyo',
            '(GMT+09:00) Yakutsk' => 'Asia/Yakutsk',
            '(GMT+09:30) Adelaide' => 'Australia/Adelaide',
            '(GMT+09:30) Darwin' => 'Australia/Darwin',
            '(GMT+10:00) Brisbane' => 'Australia/Brisbane',
            '(GMT+10:00) Canberra' => 'Australia/Sydney',
            '(GMT+10:00) Guam' => 'Pacific/Guam',
            '(GMT+10:00) Hobart' => 'Australia/Hobart',
            '(GMT+10:00) Melbourne' => 'Australia/Melbourne',
            '(GMT+10:00) Port Moresby' => 'Pacific/Port_Moresby',
            '(GMT+10:00) Sydney' => 'Australia/Sydney',
            '(GMT+10:00) Vladivostok' => 'Asia/Vladivostok',
            '(GMT+11:00) Magadan' => 'Asia/Magadan',
            '(GMT+11:00) New Caledonia' => 'Asia/Magadan',
            '(GMT+11:00) Solomon Is.' => 'Asia/Magadan',
            '(GMT+12:00) Auckland' => 'Pacific/Auckland',
            '(GMT+12:00) Fiji' => 'Pacific/Fiji',
            '(GMT+12:00) Kamchatka' => 'Asia/Kamchatka',
            '(GMT+12:00) Marshall Is.' => 'Pacific/Fiji',
            '(GMT+12:00) Wellington' => 'Pacific/Auckland',
            '(GMT+13:00) Nuku\'alofa' => 'Pacific/Tongatapu'
        ];
    }
}

if (!function_exists('getTableAutoIncrement')) {
    function getTableAutoIncrement($table){
        $statement  = DB::select("SHOW TABLE STATUS LIKE '".$table."'");
        return $statement[0]->Auto_increment;
    }
}


if (!function_exists('getColumnValue')) {
    function getColumnValue($tbl,$where,$column){
        return DB::table($tbl)->where($where)->value($column);
    }
}

if(!function_exists('get_crud_user_details')){
    function get_crud_user_details($data,$column){
        $data = json_decode($data);
        $type = isset($data->type) ? $data->type : '';
        $id = isset($data->id) ? $data->id : '';
        if($type!='' && $id!=''){
            $tbl = '';
            switch (strtolower($type)) {
                case 'admin':$tbl = 'admin';break;
                default:$tbl = '';break;
            }
            if($tbl!=''){
                return DB::table($tbl)->where('id',$id)->value($column);
            }
        }
        return translate('unknown');
    }
}

if(!function_exists('get_user_details')){
    function get_user_details($tbl,$where){
    return DB::table($tbl)->where($where)->first();
}}

if(!function_exists('generate_combinations')){
    function generate_combinations($arrays, $i=0){
        if (!isset($arrays[$i])) { return array(); }
        
        if ($i == count($arrays) - 1) {
            $result = array();
            foreach ($arrays[$i] as $v) { $result[][] = $v; }
            return $result;
        }
        
        $tmp = generate_combinations($arrays, $i + 1);
        $result = array();
        
        foreach ($arrays[$i] as $v) { foreach ($tmp as $t) {
            $result[] = is_array($t) ? array_merge(array($v), $t) : array($v, $t);
        } }
        
        return $result;
    }
}

if(!function_exists('get_currency_with_amt')){
    function get_currency_with_amt($amount='',$pre='',$post=''){
        $code='₹';
        $position='l';
        $space = $amount!='' ? ' ' : '';
        if($position=='r'){
            return $pre.$amount.$space.$code.$post;
        }else{
            return $pre.$code.$space.$amount.$post;
        }
    }
}

if (! function_exists ("add_parser_varialbes")) {
    function text_parser_varialbes($template) {
        return $template;
        /*$search = base_url("writable/uploads/");
        $replace = '{APP_BASE_URL}';
        echo preg_replace($search,$replace,$template);
        /*$parser = \Config\Services::parser();
        $parser->setDelimiters('','');

        $parser_data = array();
        $parser_data['APP_BASE_URL']   = base_url('writable/uploads/');
        $parser_data[base_url('writable/uploads/')]   = 'APP_BASE_URL';
        echo $parser->setData($parser_data)->renderString($template);exit;
        return $parser->setData($parser_data)->renderString($template);*/
    }
}

if(!function_exists('app_html_editor')){
    function app_html_editor($name,$id,$placeholder='',$default_text='',$required=true,$height='350'){
        $req = $required==true ? 'required' : '';
        $html ='<textarea class="form-control html_editor" name="'.$name.'" id="'.$id.'" placeholder="'.$placeholder.'" data-height="'.$height.'" data-parsley-errors-container="#error_html_editor_'.$id.'" '.$req.'>'.text_parser_varialbes($default_text).'</textarea>'
            .'<span id="error_html_editor_'.$id.'"></span>';
        return $html;
    }
}

if (! function_exists ("null_handling")) {
    function null_handling($data) {
        if (is_array($data) || is_object($data)) {
            $return = array();
            foreach ($data as $key => $value) { $return[$key] = $value!='' ? $value : ''; }
            if(is_object($data)){ $return = (object) $return; }
        }else{
            $return = $data!='' ? $data : '';
        }
        return $return;
    }
}

// ============== ROHAN FILE MANAGER START ==============

if(!function_exists('rohanGeneratePreviewContent')){
    function rohanGeneratePreviewContent($filePath, $type, $width, $height) {
        if ($filePath == '') {
            return rohanGetDefaultPreview($type, $width, $height);
        }
        
        $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $fullPath = asset('public/filemanager/' . $filePath);
        
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'ico'];
        $audioExtensions = ['mp3', 'wav', 'ogg', 'aac', 'flac', 'm4a', 'wma'];
        if (in_array($fileExtension, $imageExtensions)) {
            return '<img src="'.$fullPath.'" class="img-thumbnail" style="height: '.$height.';width: '.$width.';" alt="Selected Image">';
        }
        if (in_array($fileExtension, $audioExtensions) || strtolower($type) === 'audio') {
            return '<audio controls style="width:' . $width . ';height:' . $height . '"><source src="' . $fullPath . '" type="audio/mpeg">Your browser does not support the audio element.</audio>';
        }
        $fileName = basename($filePath);
        $iconClass = rohanGetFileIcon($fileExtension);
        $iconColor = rohanGetFileIconColor($fileExtension);
        return '<div class="file-preview-container d-flex flex-column align-items-center justify-content-center border rounded" 
                     style="height: '.$height.'; width: '.$width.'; background: #f8f9fa;">
                    <i class="'.$iconClass.'" style="font-size: 48px; color: '.$iconColor.'; margin-bottom: 10px;"></i>
                    <small class="text-muted text-center px-2" style="word-break: break-all; font-size: 11px;">'.$fileName.'</small>
                </div>';
    }
}

if(!function_exists('rohanGetDefaultPreview')){
    function rohanGetDefaultPreview($type, $width, $height) {
        $iconClass = 'fa fa-file';
        $iconColor = '#6c757d';
        $text = 'Select File';
        
        switch (strtolower($type)) {
            case 'image':
            case 'images':
                $iconClass = 'fa fa-image';
                $iconColor = '#28a745';
                $text = 'Select Image';
                break;
            case 'document':
            case 'documents':
                $iconClass = 'fa fa-file-text';
                $iconColor = '#007bff';
                $text = 'Select Document';
                break;
            case 'video':
            case 'videos':
                $iconClass = 'fa fa-video';
                $iconColor = '#dc3545';
                $text = 'Select Video';
                break;
            case 'audio':
            case 'audios':
                $iconClass = 'fa fa-music';
                $iconColor = '#6f42c1';
                $text = 'Select Audio';
                break;
        }
        return '<div class="file-preview-container d-flex flex-column align-items-center justify-content-center border border-dashed rounded" 
                     style="height: '.$height.'; width: '.$width.'; background: #f8f9fa;">
                    <i class="'.$iconClass.'" style="font-size: 48px; color: '.$iconColor.'; margin-bottom: 10px;"></i>
                    <small class="text-muted">'.$text.'</small>
                </div>';
    }
}

if(!function_exists('rohanGetFileIcon')){
    function rohanGetFileIcon($extension) {
        $iconMap = [
            'pdf' => 'fa fa-file-pdf-o',
            'doc' => 'fa fa-file-text',
            'docx' => 'fa fa-file-text',
            'xls' => 'fa fa-file-excel-o',
            'xlsx' => 'fa fa-file-excel-o',
            'ppt' => 'fa fa-file-powerpoint-o',
            'pptx' => 'fa fa-file-powerpoint-o',
            
            'mp4' => 'fa fa-play-circle-o',
            'avi' => 'fa fa-play-circle-o',
            'mov' => 'fa fa-play-circle-o',
            'wmv' => 'fa fa-play-circle-o',
            'flv' => 'fa fa-play-circle-o',
            'webm' => 'fa fa-play-circle-o',
            'mkv' => 'fa fa-play-circle-o',
            '3gp' => 'fa fa-play-circle-o',
            
            'jpg' => 'fa fa-image',
            'jpeg' => 'fa fa-image',
            'png' => 'fa fa-image',
            'gif' => 'fa fa-image',
            'webp' => 'fa fa-image',
            'svg' => 'fa fa-image',
            'bmp' => 'fa fa-image',
            'ico' => 'fa fa-image',
        ];
        
        return isset($iconMap[$extension]) ? $iconMap[$extension] : 'fa fa-file';
    }
}

if(!function_exists('rohanGetFileIconColor')){
    function rohanGetFileIconColor($extension) {
        $colorMap = [
            'pdf' => '#dc3545',
            'doc' => '#2b579a',
            'docx' => '#2b579a',
            'xls' => '#1d6f42',
            'xlsx' => '#1d6f42',
            'ppt' => '#d04423',
            'pptx' => '#d04423',
            
            'mp4' => '#6f42c1',
            'avi' => '#6f42c1',
            'mov' => '#6f42c1',
            'wmv' => '#6f42c1',
            'flv' => '#6f42c1',
            'webm' => '#6f42c1',
            'mkv' => '#6f42c1',
            '3gp' => '#6f42c1',
            
            'jpg' => '#28a745',
            'jpeg' => '#28a745',
            'png' => '#28a745',
            'gif' => '#28a745',
            'webp' => '#28a745',
            'svg' => '#28a745',
            'bmp' => '#28a745',
            'ico' => '#28a745',
        ];
        
        return isset($colorMap[$extension]) ? $colorMap[$extension] : '#6c757d';
    }
}

if(!function_exists('rohan_file_manager_input')){
    function rohan_file_manager_input($name, $id, $type = 'image', $default = '', $required = false, $width = '250px', $height = '250px', $mode = 'single') {
        $req = $required ? 'required' : '';
        
        if ($mode === 'multiple' || $mode === true) {
            return rohan_multiple_file_manager_input($name, $id, $type, $default, $required, $width, $height);
        }
        
        $previewContent = rohanGeneratePreviewContent($default, $type, $width, $height);
        
        $html = '<div class="rohan-file-manager-input">
            <div id="'.$id.'Preview" onclick="rohanOpenFileManager(\''.$id.'\', \''.$type.'\')" title="Click to browse files" style="cursor: pointer;">
                '.$previewContent.'
            </div>
            
            <input type="hidden" name="'.$name.'" id="'.$id.'" value="'.$default.'" '.$req.'>
        </div>';
        
        return $html;
    }
}

if(!function_exists('rohan_multiple_file_manager_input')){
    function rohan_multiple_file_manager_input($name, $id, $type = 'image', $default = '', $required = false, $width = '250px', $height = '250px') {
        $req = $required ? 'required' : '';
        $defaultFiles = $default ? explode(',', $default) : [];
        
        $html = '<div class="rohan-multiple-file-manager-input">
            <div class="d-flex justify-content-start align-items-center mb-3">
                <button type="button" class="btn btn-primary btn-sm me-2" onclick="rohanOpenMultipleFileManager(\''.$id.'\', \''.$type.'\')" title="Click to browse files">
                    <i class="fa fa-plus me-1"></i> Select Multiple
                </button>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="rohanClearAllFiles(\''.$id.'\')" title="Clear all files">
                    <i class="fa fa-trash me-1"></i> Clear All
                </button>
            </div>
            <div id="'.$id.'Preview" class="multiple-files-preview border rounded p-3" style="min-height: 150px; background: #f8f9fa;">
                <div class="row g-3" id="'.$id.'PreviewContainer">';
        
        if (!empty($defaultFiles)) {
            foreach ($defaultFiles as $file) {
                $file = trim($file);
                if ($file) {
                    $fileName = basename($file);
                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'ico']);
                    
                    $html .= '<div class="col-lg-2 col-md-3 col-sm-4 col-6 file-preview-item" data-file="'.$file.'">
                        <div class="card h-100 shadow-sm">
                            <div class="position-relative">';
                    
                    if ($isImage) {
                        $html .= '<img src="'.asset('public/filemanager/' . $file).'" class="card-img-top" style="height: 100px; object-fit: cover;" alt="'.$fileName.'">';
                    } else {
                        $iconClass = rohanGetFileIcon($extension);
                        $iconColor = rohanGetFileIconColor($extension);
                        $html .= '<div class="card-img-top d-flex align-items-center justify-content-center" style="height: 100px; background: #e9ecef;">
                            <i class="'.$iconClass.'" style="font-size: 32px; color: '.$iconColor.';"></i>
                        </div>';
                    }
                    
                    $html .= '<button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" onclick="rohanRemoveFile(\''.$id.'\', \''.$file.'\')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            <div class="card-body p-2">
                                <small class="text-muted d-block text-truncate" title="'.$fileName.'" style="font-size: 10px;">'.$fileName.'</small>
                            </div>
                        </div>
                    </div>';
                }
            }
        } else {
            $html .= '<div class="col-12 text-center text-muted no-files-message py-5">
                <i class="fas fa-images fa-4x mb-3 opacity-50"></i>
                <h6>No files selected</h6>
                <p class="mb-0">Click "Select Multiple" to choose files</p>
            </div>';
        }
        
        $html .= '</div>
            </div>
            <input type="hidden" name="'.$name.'" id="'.$id.'" value="'.$default.'" '.$req.'>
        </div>';
        
        return $html;
    }
}

if(!function_exists('rohan_file_manager_scripts')){
    function rohan_file_manager_scripts() {
        $fileManagerUrl = route('admin.filemanager');
        
        return '<script>
            function rohanOpenFileManager(inputId, fileType = "image") {
                const fileManagerUrl = "'.$fileManagerUrl.'";
                const popup = window.open(
                    fileManagerUrl + "?select_mode=true&file_type=" + fileType + "&input_id=" + inputId,
                    "filemanager",
                    "width=1200,height=800,scrollbars=yes,resizable=yes"
                );

                function handleMessage(event) {
                    if (event.data.type === "fileSelected" && event.data.inputId === inputId) {
                        const filePath = event.data.filePath;
                        document.getElementById(inputId).value = filePath;
                        
                        rohanUpdateFilePreview(inputId, filePath, fileType);
                        
                        window.removeEventListener("message", handleMessage);
                    }
                }
                
                window.addEventListener("message", handleMessage);

                function handleCustomEvent(event) {
                    if (event.detail.inputId === inputId) {
                        const filePath = event.detail.filePath;
                        document.getElementById(inputId).value = filePath;
                        
                        rohanUpdateFilePreview(inputId, filePath, fileType);
                        
                        window.removeEventListener("fileSelected", handleCustomEvent);
                    }
                }
                
                window.addEventListener("fileSelected", handleCustomEvent);
            }
            
            function rohanOpenMultipleFileManager(inputId, fileType = "image") {
                const fileManagerUrl = "'.$fileManagerUrl.'";
                const popup = window.open(
                    fileManagerUrl + "?select_mode=true&file_type=" + fileType + "&input_id=" + inputId + "&multiple=true",
                    "filemanager",
                    "width=1200,height=800,scrollbars=yes,resizable=yes"
                );

                function handleMessage(event) {
                    if (event.data.type === "multipleFilesSelected" && event.data.inputId === inputId) {
                        const filePaths = event.data.filePaths;
                        const currentValue = document.getElementById(inputId).value;
                        const currentFiles = currentValue ? currentValue.split(",").map(f => f.trim()).filter(f => f) : [];
                        
                        const allFiles = [...new Set([...currentFiles, ...filePaths])];
                        document.getElementById(inputId).value = allFiles.join(",");
                        
                        rohanUpdateMultipleFilePreview(inputId, allFiles, fileType);
                        
                        window.removeEventListener("message", handleMessage);
                    }
                }
                
                window.addEventListener("message", handleMessage);
            }

            function rohanIsImageFile(filePath) {
                const imageExtensions = ["jpg", "jpeg", "png", "gif", "webp", "svg", "bmp", "ico"];
                const extension = filePath.split(".").pop().toLowerCase();
                return imageExtensions.includes(extension);
            }

            function rohanGetFileExtension(filePath) {
                return filePath.split(".").pop().toLowerCase();
            }

            function rohanGetFileIcon(extension) {
                const iconMap = {
                    "pdf": "fa fa-file-pdf-o",
                    "doc": "fa fa-file-text",
                    "docx": "fa fa-file-text",
                    "xls": "fa fa-file-excel-o",
                    "xlsx": "fa fa-file-excel-o",
                    "ppt": "fa fa-file-powerpoint-o",
                    "pptx": "fa fa-file-powerpoint-o",
                    
                    "mp4": "fa fa-play-circle-o",
                    "avi": "fa fa-play-circle-o",
                    "mov": "fa fa-play-circle-o",
                    "wmv": "fa fa-play-circle-o",
                    "flv": "fa fa-play-circle-o",
                    "webm": "fa fa-play-circle-o",
                    "mkv": "fa fa-play-circle-o",
                    "3gp": "fa fa-play-circle-o",
                    
                    "jpg": "fa fa-image",
                    "jpeg": "fa fa-image",
                    "png": "fa fa-image",
                    "gif": "fa fa-image",
                    "webp": "fa fa-image",
                    "svg": "fa fa-image",
                    "bmp": "fa fa-image",
                    "ico": "fa fa-image"
                };
                
                return iconMap[extension] || "fa fa-file";
            }

            function rohanGetFileIconColor(extension) {
                const colorMap = {
                    "pdf": "#dc3545",
                    "doc": "#2b579a",
                    "docx": "#2b579a",
                    "xls": "#1d6f42",
                    "xlsx": "#1d6f42",
                    "ppt": "#d04423",
                    "pptx": "#d04423",
                    
                    "mp4": "#6f42c1",
                    "avi": "#6f42c1",
                    "mov": "#6f42c1",
                    "wmv": "#6f42c1",
                    "flv": "#6f42c1",
                    "webm": "#6f42c1",
                    "mkv": "#6f42c1",
                    "3gp": "#6f42c1",
                    
                    "jpg": "#28a745",
                    "jpeg": "#28a745",
                    "png": "#28a745",
                    "gif": "#28a745",
                    "webp": "#28a745",
                    "svg": "#28a745",
                    "bmp": "#28a745",
                    "ico": "#28a745"
                };
                
                return colorMap[extension] || "#6c757d";
            }

            function rohanUpdateFilePreview(inputId, filePath, fileType) {
                const previewId = inputId + "Preview";
                const previewContainer = document.getElementById(previewId);
                if (!previewContainer) return;
                
                const extension = rohanGetFileExtension(filePath);
                const fileName = filePath.split("/").pop();
                
                if (rohanIsImageFile(filePath)) {
                    previewContainer.innerHTML = `
                        <img src="'.asset('public/filemanager/').'/${filePath}" 
                             class="img-thumbnail" style="height: 250px;width: 250px;" alt="Selected Image">
                    `;
                } else {
                    const iconClass = rohanGetFileIcon(extension);
                    const iconColor = rohanGetFileIconColor(extension);
                    
                    previewContainer.innerHTML = `
                        <div class="file-preview-container d-flex flex-column align-items-center justify-content-center border rounded" 
                             style="height: 250px; width: 250px; background: #f8f9fa;">
                            <i class="${iconClass}" style="font-size: 48px; color: ${iconColor}; margin-bottom: 10px;"></i>
                            <small class="text-muted text-center px-2" style="word-break: break-all; font-size: 11px;">${fileName}</small>
                        </div>
                    `;
                }
                
                previewContainer.onclick = function() {
                    rohanOpenFileManager(inputId, fileType);
                };
                previewContainer.style.cursor = "pointer";
                previewContainer.title = "Click to browse files";
            }
            
            function rohanUpdateMultipleFilePreview(inputId, filePaths, fileType) {
                const previewContainer = document.getElementById(inputId + "PreviewContainer");
                if (!previewContainer) return;
                
                if (!filePaths || filePaths.length === 0) {
                    previewContainer.innerHTML = `
                        <div class="col-12 text-center text-muted no-files-message py-5">
                            <i class="fas fa-images fa-4x mb-3 opacity-50"></i>
                            <h6>No files selected</h6>
                            <p class="mb-0">Click "Select Multiple" to choose files</p>
                        </div>
                    `;
                    return;
                }
                
                let html = "";
                filePaths.forEach(function(filePath) {
                    if (!filePath.trim()) return;
                    
                    const fileName = filePath.split("/").pop();
                    const extension = rohanGetFileExtension(filePath);
                    const isImage = rohanIsImageFile(filePath);
                    
                    html += `
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6 file-preview-item" data-file="${filePath}">
                            <div class="card h-100 shadow-sm">
                                <div class="position-relative">
                    `;
                    
                    if (isImage) {
                        html += `<img src="'.asset('public/filemanager/').'/${filePath}" class="card-img-top" style="height: 100px; object-fit: cover;" alt="${fileName}">`;
                    } else {
                        const iconClass = rohanGetFileIcon(extension);
                        const iconColor = rohanGetFileIconColor(extension);
                        html += `
                            <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 100px; background: #e9ecef;">
                                <i class="${iconClass}" style="font-size: 32px; color: ${iconColor};"></i>
                            </div>
                        `;
                    }
                    
                    html += `
                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" onclick="rohanRemoveFile(\'${inputId}\', \'${filePath}\')">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                                <div class="card-body p-2">
                                    <small class="text-muted d-block text-truncate" title="${fileName}" style="font-size: 10px;">${fileName}</small>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                previewContainer.innerHTML = html;
            }
            
            function rohanRemoveFile(inputId, filePath) {
                const input = document.getElementById(inputId);
                const currentValue = input.value;
                const files = currentValue ? currentValue.split(",").map(f => f.trim()).filter(f => f) : [];
                const updatedFiles = files.filter(f => f !== filePath);
                
                input.value = updatedFiles.join(",");
                rohanUpdateMultipleFilePreview(inputId, updatedFiles, "image");
            }
            
            function rohanClearAllFiles(inputId) {
                document.getElementById(inputId).value = "";
                rohanUpdateMultipleFilePreview(inputId, [], "image");
            }
        </script>';
    }
}

// ============== ROHAN FILE MANAGER END ==============

if (!function_exists('uploads_url')){
    function uploads_url($uri = ''){
        $uri = $uri!='' ? $uri : 'default.png';
        return getBaseURL().'public/filemanager/'.$uri;
    }
}

if(!function_exists('secure_file_manager')){
    function secure_file_manager($name, $id, $type = 'image', $default = '', $required = true) {
        $req = $required ? 'required' : '';
        $acceptTypes = '';
        
        switch($type) {
            case 'image':
                $acceptTypes = '.jpg,.jpeg,.png,.gif,.webp,.svg';
                break;
            case 'document':
                $acceptTypes = '.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt';
                break;
            case 'video':
                $acceptTypes = '.mp4,.avi,.mov,.wmv,.flv,.webm';
                break;
            case 'audio':
                $acceptTypes = '.mp3,.wav,.ogg,.aac';
                break;
            default:
                $acceptTypes = '.jpg,.jpeg,.png,.gif,.webp,.svg,.pdf,.doc,.docx,.xls,.xlsx,.mp4,.avi,.mov,.mp3,.wav';
        }
        
        if($type === 'image' && $default) {
            $preview = '<div class="file-preview mb-2">
                <img src="'.uploads_url($default).'" class="img-thumbnail" id="preview_'.$id.'" style="max-width: 150px;" alt="Preview">
            </div>';
        } else {
            $preview = '';
        }
        
        $html = '<div class="secure-file-manager">
            '.$preview.'
            <input type="file" class="form-control" name="'.$name.'" id="'.$id.'" accept="'.$acceptTypes.'" data-parsley-errors-container="#error_'.$id.'" '.$req.'>
            <input type="hidden" name="'.$name.'_current" value="'.$default.'">
            <small class="form-text text-muted">Max file size: 10MB. Allowed types: '.str_replace('.', '', $acceptTypes).'</small>
            <span id="error_'.$id.'"></span>
        </div>';
        
        return $html;
    }
}

if (!function_exists('customer_setting')) {
    function customer_setting($key,$default='') {
        $value = config('deepinfo.'.$key);
        if ($value !== NULL) {
            return $value;
        }else {
            return $default;
        }
    }
}

if (!function_exists('app_file_exists')) {
    function app_file_exists($file='',$default='') {
        if($file!='' && strpos($file, '.') && file_exists(str_replace(getBaseURL(), '', $file))){
            return $file;
        }
        if($default!=''){
            return $default;
        }
        return false;
    }
}

if (! function_exists ("display_datetime_format")) {
    function display_datetime_format($datetime,$format='datetime') {
        $datetime = strtotime($datetime);
        if($format=='date'){
            return date('d-m-Y', $datetime);
        }else if($format=='time'){
            return date('h:i:s A', $datetime);
        }else{
            return date('d-m-Y h:i:s A', $datetime);
        }
    }
}

if (!function_exists('check_bad_words')) {
    function check_bad_words($string, $words=array()) {
        if(app_setting('badword_status')=='on'){
            if(empty($words)){ 
                $words = app_setting('badwords'); 
                $words = $words!='' ? explode(",",$words) : array(); 
            }
            if(isset($words) && !empty($words)){ foreach ($words as $word) {
                if (str_contains($word, $string)) return true;
            } }
            return false;
        }
        return false;
    }
}
if (!function_exists('static_asset_home')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function static_asset_home($path, $secure = null)
    {
        $version = customer_setting('app_version');
       return app('url')->asset('public/assets/home/' . $path . '?v=' . $version, $secure);

    }
}
if(!function_exists('valid_session')){
    function valid_session($module = '', $action = '', $redirect = true) {
        $permissions = array();
        if($redirect){
            $admin_id = customer_setting('admin_id');
            $role_id = customer_setting('role_id');
        }else{
            $id = session('id');
            $web_auth_key = session('web_auth_key');
            $user = User::where('id','=',$id)
                    ->where('web_auth_key','=',$web_auth_key)
                    ->first();
            
            if(!empty($user)){
                $role = Role::where('id','=',$user->role_id)
                        ->where('is_active','=','1')
                        ->first();

                if(!empty($role)){
                    if($user->role_id!=1){
                        $permissions = json_decode($role->permissions,true);
                    }
                    $admin_id = $role->id;
                    $role_id = $user->id;
                }
            }
        }
        if ($admin_id != '') {
            if ($role_id != 1 && $redirect) {
                $permissions = customer_setting('permissions');
            }
            if ($module == 'dashboard' || $module == 'profile') { 
                return true; 
            }
            if (empty($permissions) || isset($permissions[$module][$action]) || isset($permissions[$module][strtoupper($action)]) || isset($permissions[strtolower($module)][$action])) { 
                return true;
            } else {
                if ($redirect) {
                    redirect()->route('admin.dashboard');exit;
                } else {
                    return false;
                }
            }
        } else {
            if ($redirect) {
                redirect()->route('admin.login');exit;
            } else {
                return false;
            }
        }
    }
}

if (!function_exists('downloadfile')) {
    /**
     * Download an asset file.
     *
     * @param string $path
     * @param string|null $name
     */
    function downloadfile($path, $name = null)
    {
        $filePath = public_path($path);
        $fileName = $name ?: basename($filePath);
        return response()->download($filePath, $fileName);
    }
}

/* Unique Slug */

if(!function_exists('generateSlug')){
    function generateSlug($tbl,$title)
    {
        $slug = Str::slug($title, '-');
        // Ensure the slug is unique
        $count = 1;
        while (DB::table($tbl)->whereSlug($slug)->exists()) {
            $slug = Str::slug($title, '-') . '-' . $count++;
        }
        return $slug;
    }

}

if(!function_exists("file_type_icon")){
    function file_type_icon($type){
        if(@preg_match('/image/i', $type)){
            $icon  = "<i class='fa fa-file-image-o'></i>";
        }
        else if(@preg_match('/sheet/i', $type)){
            $icon = "<i class='fa fa-file-excel-o'></i>";
        }
        else if(@preg_match('/pdf/i', $type)){
            $icon =  "<i class='fa fa-file-pdf-o'></i>";
        }
        else if(@preg_match('/word/i', $type)){
            $icon = "<i class='fa fa-file-word-o'></i>";
        }
         else if(@preg_match('/text/i', $type)){
            $icon =  "<i class='fa fa-file-text-o'></i>";
        }
        else{
            $icon =  "<i class='fa fa-file-o'></i>";
        }
    return $icon;    
    }
}

/* Get DB Data */
if (!function_exists('get_amount_with_tax')) {
    function get_amount_with_tax($amount, $tax, $tax_type){
        $amount = floatval($amount);
        $tax = floatval($tax);
        $tax_amt = ($amount*$tax)/100;
        if($tax_type!='i'){
            $amount = $amount+$tax_amt;
        }
        return round($amount);
    }
}

if (!function_exists('get_cp_amount')) {
    function get_cp_amount($amount, $tax){
        $amount = floatval($amount);
        $tax = floatval($tax);
        $tax_amt = ($amount*$tax)/100;
        return round($tax_amt);
    }
}

