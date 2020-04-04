<?php

namespace App\Http\Controllers;


use App\Category;
use App\Http\Requests\Admin\AddCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;

use App\Link;
use App\Major;
use App\MajorCategory;
use App\Repositories\EventsRepository;
use App\Repositories\SpeakerRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\UniRepository;
use App\Repositories\UsersRepository;
use App\SubCategory;
use App\Uni;
use App\UniMajor;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use http\Client;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;



class SubCategoriesController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $categoryRepo = null;
    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function getSubCategories(Request $request){

        $sub_categories = SubCategory::with('uni','major','category');
        if($request->has('unis') and $request->unis) {
            $sub_categories->where('uni_id',$request->unis);
        }
        if($request->has('majors') and $request->majors) {
            $sub_categories->where('major_id',$request->majors);
        }
        if($request->has('categories') and $request->categories) {
            $sub_categories->where('category_id',$request->categories);
        }

        $page_size = $request->get('page_size');
        $page_size = isset($page_size) ? $page_size : 10;
        if($request->has('sort')) {
            $sub_categories = $sub_categories->orderBy('title',$request->sort)->paginate($page_size);
        }
        else {
            $sub_categories = $sub_categories->orderBy('created_at','DESC')->paginate($page_size);
        }
        $unis = Uni::all();
        $majors = Major::all();
        $categories = Category::all();


        return view('major_categories.sub_categories',['title' => 'sub_categories',
            'data' => $sub_categories,
            'unis' => $unis,
            'majors' => $majors,
            'categories' => $categories,
        ]);
    }

    public function updateSubCategoryView($sub_id) {
        $sub_category = SubCategory::find($sub_id);
        $unis = Uni::all();
        $majors = Major::all();
        $categories = Category::all();

        $sub_category->description = isset($sub_category->description) ? $this->removeSpecialChars($sub_category->description) : $sub_category->description;
        $sub_category->summary = isset($sub_category->summary) ? $this->removeSpecialChars($sub_category->summary) : $sub_category->summary;

        if($sub_category) {
            return view('major_categories.edit_sub_category',['title' => 'sub_categories',
                'sub_category' => $sub_category,
                'unis' => $unis,
                'majors' => $majors,
                'categories' => $categories,
            ]);
        }
        else {
            return redirect('/sub/categories')->with('error','Category not exist');
        }
    }

    public function removeSpecialChars($data_str) {
        $str = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
        }, htmlspecialchars_decode($data_str));
        return str_replace('\n',' ',$str);

    }
    public function updateSubCategory(Request $request) {
        $this->validate($request,[
                'title' => 'required',
                'category_id' => 'required',
                'uni_id' => 'required'
            ]
        );
        $requestData = $request->all();
        if(!$request->has('major_id')) {
            $requestData['major_id'] = [0];
        }
        unset($requestData['signIn']);
        unset($requestData['_token']);

        $insertData = $requestData;

        foreach($requestData['uni_id'] as $uni_id) {
            foreach ($requestData['major_id'] as $major_id) {
                foreach ($requestData['category_id'] as $category_id) {
                    $insertData['uni_id'] = $uni_id;
                    $insertData['category_id'] = $category_id;
                    $insertData['major_id'] = $major_id;
                    $insertData['time'] = '';
                    SubCategory::updateOrCreate([
                        'link' => $requestData['link'],
                        'title' => $requestData['title'],
                        'category_id' => $category_id,
                        'major_id' => $major_id,
                        'uni_id' => $uni_id,
                    ],$insertData);
                    //SubCategory::create($insertData);
                }
            }
        }

//
//        $insertData = $requestData = $request->all();
//        if(!$request->has('major_id')) {
//            $requestData['major_id'] = [0];
//        }
//        unset($requestData['signIn']);
//        unset($requestData['_token']);
//        SubCategory::where('id',$requestData['id'])->update($requestData);
        return redirect('sub/categories')->with('success','Sub Category Updated');

    }

    public function deleteSubCategory($id) {
        SubCategory::where('id',$id)->delete();
        $sub_categories = SubCategory::where('scrap_link','InfoSession_Valencia')->first();
        if(!$sub_categories) {
            DB::table('info_session')->delete();
        }
        return redirect()->back()->with('success','Sub Category deleted');
    }

    public function bulkDeleteSubCategory() {
        SubCategory::whereIn('id',request()->delete_ids)->delete();
        $sub_categories = SubCategory::where('scrap_link','InfoSession_Valencia')->first();
        if(!$sub_categories) {
            DB::table('info_session')->delete();
        }
        return redirect()->back()->with('success','Sub Categories deleted');
    }

    public function addCustomCategoryView() {
        $majors = Major::all();
        $unis = Uni::all();
        $categories = Category::all();
        return view('major_categories.add_custom_category',['title' => 'sub_categories',
            'majors' => $majors,
            'unis' => $unis,
            'categories' => $categories
        ]);
    }

    public function getMajorCategories(Request $request) {
        $cat_ids = MajorCategory::where('major_id',$request->major_id)->pluck('category_id')->toArray();
        $categories = Category::whereIn('id',$cat_ids)->get();
        return ['status' => true,'categories' => $categories->toArray()];
    }

    public function addCustomCategory(Request $request) {
        $this->validate($request,[
                'title' => 'required',
                'category_id' => 'required',
                'uni_id' => 'required',
            ]
        );
//        $v = Validator::make([], []);
//        if($request->major_id == 0) {
//            $v->errors()->add('some_field', 'some_translated_error_key');
//            dd($v);
//        }

        $insertData = $requestData = $request->all();
        if(!$request->has('major_id')) {
            $requestData['major_id'] = [0];
        }
        unset($requestData['signIn']);
        unset($requestData['_token']);
        foreach($requestData['uni_id'] as $uni_id) {
            foreach ($requestData['major_id'] as $major_id) {
                foreach ($requestData['category_id'] as $category_id) {
                    $insertData['uni_id'] = $uni_id;
                    $insertData['category_id'] = $category_id;
                    $insertData['major_id'] = $major_id;
                    $insertData['time'] = '';
                    SubCategory::create($insertData);
                }
            }
        }

        return redirect()->back()->with('success','Sub Category Added');
    }


    public function addSubCategoryVew($major_id = 0) {
        /*
                $majors = Major::all();
                if($major_id == 0) {
                    $cat_ids = MajorCategory::where('major_id',$majors[0]->id)->pluck('category_id')->toArray();
                } else {
                    $cat_ids = MajorCategory::where('major_id',$major_id)->pluck('category_id')->toArray();
                }
                $categories = Category::whereIn('id',$cat_ids)->get();*/

        $unis = Uni::all();
        $majors = Major::all();
        $categories = Category::all();
        $info_session = DB::table('info_session')->orderBy('id','desc')->first();
        return view('major_categories.add_sub_category',['title' => 'sub_categories',
            'unis' => $unis,
            'majors' => $majors,
            'categories' => $categories,
            'links' => Link::all(),
            'info_session' => isset($info_session) ? $info_session->week : 0
        ]);
    }



    public function addSubCategory(Request $request) {
        try
        {

            /* $process = new Process('import:data');
             $process->start();
             dd($process->getStatus());
             dd('hereerere');*/
            //SubCategory::truncate();
            set_time_limit(0);
            $link = "";
            $requestData = $request->all();
            if(!$request->major_id) {
                $requestData['major_id'] = [0];
            }
            $url = url('/');
            $url = trim($url,'public/');
            $endpoint = "$url/scrapper/generate.php";
            $client = new \GuzzleHttp\Client();
            $size = 5;
            $link = Link::find($request->link);
            if($link) {
                //call scrapper for selected link
                if($link->link == 'https://blog.bizzabo.com/education-events') {
                    $endpoint = "$url/scrapper/bizzabo.php";
                }
                else if($link->link == 'https://valenciacollege.edu/academics/programs/') {
                    $endpoint = "$url/scrapper/valenciacollege.php";
                }
                else if($request->selected_link == 'InfoSession_Valencia') {
                    try {
                       $endpoint = "$url/scrapper/newEvent.php";
                       $week = $request->week;
                        $now = Carbon::now();
                        $year = $now->year;
                        $dateRange = $this->getStartAndEndDate($week,$year);
                        $startDate = $dateRange['week_start'];
                        $url = "https://events.valenciacollege.edu/calendar/week/$startDate";

                        $info_id = DB::table('info_session')->insertGetId([
                            'link_id' => $link->id,
                            'week' => $request->week,
                            'start_date' => $dateRange['week_start'],
                            'end_date' => $dateRange['week_end']
                        ]);
                        $requestData['link'] = $request->selected_link;
                        $res = $this->getEventsData($requestData,$endpoint,$client,$url,"");
                        /*if($res['status']) {
                            DB::table('info_session')->delete();
                        }*/
                        return ['status' => true,'message' => 'Data is added'];

                        $endpoint = "$url/scrapper/newEvent.php";
                        $now = Carbon::now();
                        $now = $now->month;
                        while($now <= 12) {
                            $date = "month/2020/$now/15";
                            $url = $link->link."/$date";
                            $this->getEventsData($requestData,$endpoint,$client,$url,$date);
                            $now++;
                        }
                        return ['status' => true,'message' => 'Data is added'];
                    }
                    catch (\Exception $e) {
                        DB::table('info_session')->where('id',$info_id)->delete();
                        Log::info('events_error',['message' => $e->getMessage(),'line' => $e->getLine(),'code' => $e->getCode()]);
                        return ['status' => false,'message' => 'Data is added'];
                    }

                }
                else if($request->selected_link == 'Jobs') {
                    $job_title = $request->job_title;
                    $job_location = $request->job_location;
                    $job_title = urlencode($job_title);
                    $job_location = urlencode($job_location);
                    $endpoint = "$url/scrapper/indeed.php";
                    $radius = $request->radius;
                    $start = 0;
                    $index = 0;
                    $total_records = 0;

                    //get total record count
                    $url  = "https://www.indeed.com/jobs?q=$job_title&l=$job_location&radius=$radius";
                    $result = $this->getJobsData($requestData,$endpoint,$client,$url,true);
                    $result = explode(' ',$result);
                    if(count($result) > 0) {
                        $total_records = str_replace(',','', $result[3]);
                        $total_records = round($total_records / 10);
                    }
                    else {
                        return ['status' => true,'message' => 'Data not found'];
                    }
                    while($start < $total_records) {
                        $page_no = $start * 10;
                        $url  = "https://www.indeed.com/jobs?q=$job_title&l=$job_location&radius=$radius&start=$page_no";
                        Log::info('subcategory error',['data_input' => $url]);
                        $this->getJobsData($requestData,$endpoint,$client,$url,false);
                        $start++;
                    }
                    return ['status' => true,'message' => 'Data is added'];
                }

                else if($request->selected_link == 'Internships') {
                    $job_title = $request->job_title;
                    $job_location = $request->job_location;
                    $job_title = urlencode($job_title);
                    $job_location = urlencode($job_location);
                    $endpoint = "$url/scrapper/indeed.php";
                    $radius = $request->radius;
                    $start = 0;
                    $index = 0;
                    $total_records = 0;

                    //get total record count

                    $url = "https://www.indeed.com/jobs?q=$job_title&l=$job_location&jt=internship&radius=$radius";
                    $result = $this->getJobsData($requestData,$endpoint,$client,$url,true);
                    $result = explode(' ',$result);
                    if(count($result) > 0) {
                        $total_records = $result[3];
                        $total_records = round($total_records / 10);
                    }
                    else {
                        return ['status' => true,'message' => 'Data not found'];
                    }
                    while($start < $total_records) {
                        $page_no = $start * 10;
                        $url = "https://www.indeed.com/jobs?q=$job_title&l=$job_location&radius=$radius&jt=internship&start=$page_no";
                        Log::info('subcategory error',['data_input' => $url]);
                        $this->getJobsData($requestData,$endpoint,$client,$url,false);
                        $start++;
                    }
                    return ['status' => true,'message' => 'Data is added'];


                }

                else if($link->link == 'https://valenciacollege.campuslabs.com/engage/api/discovery/search/organizations?orderBy[0]=UpperName%20asc&top=1000&filter=&query=&skip=0') {
                    $endpoint = "$url/scrapper/generate.php";
                }
                else if($link->link == 'https://valenciacollege.edu/finaid/scholarship-bulletin-board.php') {
                    $endpoint = "$url/scrapper/scholarship.php";
                }
                else {
                    return ['status' => false,'message' => 'Invalid URL'];
                }
                $url = $link->link;

            }
            $skip = 0;
            foreach($requestData['uni_id'] as $uni_id) {
                foreach ($requestData['major_id'] as $major_id) {
                    foreach ($requestData['category_id'] as $category_id) {
                        $response = $client->request('GET', $endpoint, ['query' => [
                            'size' => $size,
                            'url' => $url,
                            'skip' => $skip
                        ]]);
                        $response = json_decode($response->getBody()->getContents());
                        if(isset($response)) {
                            //while(count($response ) > 0) {
                            $sub_arr = [];
                            $temp = [];
                            foreach ($response as $sub_category) {
                                $temp = [
                                    'link' => $sub_category->Link ?? "",
                                    'title' => property_exists($sub_category,'Title') ? $sub_category->Title : $sub_category->Name,
                                    'description' => $sub_category->Description ?? "",
                                    'summary' => $sub_category->Summary ?? "",
                                    'email' => $sub_category->Email ?? "",
                                    'address' => property_exists($sub_category,'ContactAddress') ? $sub_category->ContactAddress : $sub_category->Location,
                                    'time' => property_exists($sub_category,'Time') ? $sub_category->Time : $sub_category->Date,
                                    'category_id' => $category_id,
                                    'major_id' => $major_id,
                                    'uni_id' => $uni_id,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s')
                                ];
                                // SubCategory::where([
                                //     'uni_id' => $uni_id,'major_id' => $major_id,'category_id' => $category_id
                                // ])->delete();
                                //$sub_arr[] = $temp;

                                try {
                                    SubCategory::updateOrCreate([
                                        'link' => $sub_category->Link ?? "",
                                        'title' => property_exists($sub_category,'Title') ? $sub_category->Title : $sub_category->Name,
                                        'email' => $sub_category->Email ?? "",
                                        'category_id' => $category_id,
                                        'major_id' => $major_id,
                                        'uni_id' => $uni_id,
                                    ],$temp);
                                }
                                catch(\Exception $e) {
                                    Log::info('subcategory error',['error_mesage' => $e->getMessage(),'data_input' => $temp]);
                                    continue;
                                }

                            }
                        /*    try{
                                //SubCategory::insert($sub_arr);

                            }
                            catch (\Exception $e){
                                Log::info('subcategory error',['data_input' => $sub_arr]);
                            }*/
                            /*

                                                          $skip = $skip + 5;
                                                            $response = $client->request('GET', $endpoint, ['query' => [
                                                                'size' => $size,
                                                                'url' => $url,
                                                                'skip' => $skip
                                                            ]]);
                                                            $response = json_decode($response->getBody()->getContents());*/
                            //}
                        }
                        /*else{
                            $skip = 0;
                        }*/
                        else {
                            return ['status' => false,'message' => 'Failed to fetch data'];
                        }
                    }
                }
            }
            return ['status' => true,'message' => 'Data is added'];

        }
        catch (\Exception $e) {
            Log::info('subcategory error',['message' => $e->getMessage(),'line' => $e->getLine()]);
            return ['status' => false,'message' => 'Data is added'];
        }
    }

    public function getStartAndEndDate($week, $year) {
        $dto = new \DateTime();
        $dto->setISODate($year, $week);
        $ret['week_start'] = $dto->format('yy/m/d');
        $dto->modify('+6 days');
        $ret['week_end'] = $dto->format('yy/m/d');
        return $ret;
    }


    public function getJobsData($requestData,$endpoint,$client,$url,$size) {
        if($size) {
            $response = $client->request('GET', $endpoint, ['query' => [
                'url' => $url,
                'size' => $size
            ]]);
            $response = $response->getBody()->getContents();
            return trim($response);
        }

        foreach($requestData['uni_id'] as $uni_id) {
            foreach ($requestData['major_id'] as $major_id) {
                foreach ($requestData['category_id'] as $category_id) {
                    $response = $client->request('GET', $endpoint, ['query' => [
                        'url' => $url,
                        'size' => $size
                    ]]);
                    $response = json_decode($response->getBody()->getContents());
                    if(isset($response)) {
                        //while(count($response ) > 0) {
                        foreach ($response as $sub_category) {
                            $temp = [
                                'link' => $sub_category->Link ?? "",
                                'title' => property_exists($sub_category,'Title') ? $sub_category->Title : $sub_category->Name,
                                'description' => $sub_category->Description ?? "",
                                'summary' => $sub_category->Summary ?? "",
                                'email' => $sub_category->Email ?? "",
                                'address' => property_exists($sub_category,'ContactAddress') ? $sub_category->ContactAddress : $sub_category->Location,
                                'time' => property_exists($sub_category,'Time') ? $sub_category->Time : $sub_category->Date,
                                'category_id' => $category_id,
                                'major_id' => $major_id,
                                'uni_id' => $uni_id,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ];

                            try {
                                SubCategory::updateOrCreate([
                                    'link' => $sub_category->Link,
                                    'title' => $sub_category->Title,
                                    'category_id' => $category_id,
                                    'major_id' => $major_id,
                                    'uni_id' => $uni_id,
                                ],$temp);
                            }
                            catch(\Exception $e) {
                                Log::info('subcategory error',['error' => $e->getMessage(),'data_input' => $temp]);
                                continue;
                            }

                        }
                    }
                    else {
                        return ['status' => false,'message' => 'Failed to fetch data'];
                    }
                }
            }
        }
        return ['status' => true];
    }

    public function getEventsData($requestData,$endpoint,$client,$url,$date) {
        foreach($requestData['uni_id'] as $uni_id) {
            foreach ($requestData['major_id'] as $major_id) {
                foreach ($requestData['category_id'] as $category_id) {

//                    $client->setDefaultOption('headers', array('User-Agent' => 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0'));

                    try {
                        $response = $client->request('GET', $endpoint, ['query' => [
                            'url' => $url,
                        ]]);
                    } catch (ClientException $e) {
                        Log::info('events_curl_error',['events_curl_error' => $e->getMessage(),'line' => $e->getLine(),'code' =>$e->getResponse()]);
                    }
                    $response = json_decode($response->getBody()->getContents());
                    if(isset($response)) {
                        //while(count($response ) > 0) {
                        foreach ($response as $sub_category) {
                            $temp = [
                                'link' => $sub_category->Link ?? "",
                                'title' => property_exists($sub_category,'Title') ? $sub_category->Title : $sub_category->Name,
                                'description' => $sub_category->Description ?? "",
                                'summary' => $sub_category->Summary ?? "",
                                'email' => $sub_category->Email ?? "",
                                'address' => property_exists($sub_category,'ContactAddress') ? $sub_category->ContactAddress : $sub_category->Location,
                                'time' => property_exists($sub_category,'Time') ? $sub_category->Time : $sub_category->Date,
                                'category_id' => $category_id,
                                'major_id' => $major_id,
                                'uni_id' => $uni_id,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ];

                            try {
                                SubCategory::updateOrCreate([
                                    'link' => $sub_category->Link ?? "",
                                    'title' => property_exists($sub_category,'Title') ? $sub_category->Title : $sub_category->Name,
                                    'email' => $sub_category->Email ?? "",
                                    'category_id' => $category_id,
                                    'major_id' => $major_id,
                                    'uni_id' => $uni_id,
                                    'scrap_link' => $requestData['link']
                                ],$temp);
                            }
                            catch(\Exception $e) {
                                Log::info('getEventsData()_error',['error' => $e->getTrace(),'data_input' => $temp]);
                                continue;
                            }

                        }
                        return ['status' => true];
                    }
                    else {
                        return ['status' => false,'message' => 'Failed to fetch data'];
                    }
                }
            }
        }
    }

    public function showCategoryView(){
        return view('categories.add_category',['title' => 'categories']);
    }

    public function addCategory(AddCategoryRequest $request){

        $category_id = $this->categoryRepo->store($request->storableAttrs())->id;
        $file = $request->file('image');
        if(isset($file)){
            $public_path = '/category/images/' . $category_id;
            $destinationPath = public_path($public_path);
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $image = $public_path . '/' . $filename;
            $this->categoryRepo->updateWhere(['id' => $category_id],['image' => $image]);
        }

        return redirect()->back()->with('success','Category Added Successfully');
    }

    public function editCategoryForm($id){
        $category = $this->categoryRepo->findById($id);
        return view('categories.edit_category',['title' => 'categories','category' => $category]);
    }

    public function updateCategory(UpdateCategoryRequest $request,$id){
        $category_id = $id;
        $this->categoryRepo->updateWhere(['id' => $category_id],$request->updateAttrs());
        $file = $request->file('image');
        if(isset($file)){
            $public_path = '/category/images/' . $category_id;
            $destinationPath = public_path($public_path);
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $image = $public_path . '/' . $filename;
            $this->categoryRepo->updateWhere(['id' => $category_id],['image' => $image]);
        }

        return redirect()->back()->with('success','Category Updated Successfully');
    }
    public function deleteCategory($id){
        $this->categoryRepo->deleteById($id);
        return redirect()->back()->with('success','Category Deleted');
    }
    public function categoryDetail($id){
        return view('categories.category_detail',['title' => 'categories','category' => $this->categoryRepo->findById($id)]);
    }
    public function subCategories($id) {
        set_time_limit(0);
        $url = url('/');
        $url = trim($url,'public/');
        $endpoint = "$url/scrapper/generate.php";
        $client = new \GuzzleHttp\Client();
        $size = 10;
        $url = "https://valenciacollege.campuslabs.com/engage/api/discovery/search/organizations";
        $response = $client->request('GET', $endpoint, ['query' => [
            'size' => $size,
            'url' => $url,
        ]]);

        dd(json_decode($response->getBody()->getContents()));


    }
    public function deleteCategories(Request $request){
        $this->validate(request(),[
            'delete_ids' => 'required',],['delete_ids.required' => 'Select Record to Delete']);
        $this->categoryRepo->deleteRecords($request->input('delete_ids'));
        return redirect()->back()->with('success','Categories deleted');
    }
    public function sortCategories(Request $request){
        $categories = DB::table('categories')->orderBy('sort_id','ASC')->get();
        $item_id = $request->input('itemId');
        $item_index = $request->input('itemIndex');
        foreach($categories as $category){
            return DB::table('categories')->where('id',$item_id)->update(['sort_id' => $item_index]);
        }
    }

    public function getSub() {

    }






}
