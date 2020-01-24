<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\Admin\AddMajorRequest;
use App\Http\Requests\Admin\UpdateMajorRequest;

use App\Major;
use App\MajorCategory;
use App\Repositories\EventsRepository;
use App\Repositories\SpeakerRepository;
use App\Repositories\MajorRepository;
use App\Repositories\UniRepository;
use App\Repositories\UsersRepository;
use App\Uni;
use App\UniMajor;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;


class MajorsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $majorsRepo = null;
    public function __construct(MajorRepository $majorsRepo)
    {
        $this->majorsRepo = $majorsRepo;
    }

    public function getMajors(){
        $majors = $this->majorsRepo->getAllMojors();
        return view('majors.majors',['title' => 'majors','majors' => $majors]);
    }

    public function showMajorView(){
        $categories = Category::all();
        return view('majors.add_major',['title' => 'majors','categories' => $categories]);
    }

    public function addMajor(AddMajorRequest $request){

        $major_id = $this->majorsRepo->store($request->storableAttrs())->id;
        if($major_id) {
            $majors = [];
            foreach($request->categories as $category) {
                $temp = ['major_id' => $major_id,'category_id' => $category,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];
                $majors[] = $temp;
            }
            MajorCategory::insert($majors);
        }
        $file = $request->file('image');
        if(isset($file)){
            $public_path = '/major/images/' . $major_id;
            $destinationPath = public_path($public_path);
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $image = $public_path . '/' . $filename;
            $this->majorsRepo->updateWhere(['id' => $major_id],['image' => $image]);
        }
        $file = $request->file('signature_image');
        if(isset($file)){
            $public_path = '/major/signature_images/' . $major_id;
            $destinationPath = public_path($public_path);
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $image = $public_path . '/' . $filename;
            $this->majorsRepo->updateWhere(['id' => $major_id],['signature_image' => $image]);
        }

        return redirect()->back()->with('success','Major Added Successfully');
    }

    public function editMajorForm($id){
        $major = $this->majorsRepo->findById($id);
        $major_categories = MajorCategory::where('major_id',$major->id)->pluck('category_id')->toArray();
        $all_categories = Category::all();
        return view('majors.edit_major',['title' => 'majors','major' => $major,'all_categories' => $all_categories,'major_categories' => $major_categories]);
    }

    public function updateMajor(UpdateMajorRequest $request,$id){
        $major_id = $id;
        $this->majorsRepo->updateWhere(['id' => $major_id],$request->updateAttrs());

        MajorCategory::where('major_id',$major_id)->delete();
        $majors = [];
        foreach($request->categories as $category) {
            $temp = ['major_id' => $major_id,'category_id' => $category,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];
            $majors[] = $temp;
        }
        MajorCategory::insert($majors);

        $file = $request->file('image');
        if(isset($file)){
            $public_path = '/major/images/' . $major_id;
            $destinationPath = public_path($public_path);
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $image = $public_path . '/' . $filename;
            $this->majorsRepo->updateWhere(['id' => $major_id],['image' => $image]);
        }
        $file = $request->file('signature_image');
        if(isset($file)) {
            $public_path = '/major/signature_images/' . $major_id;
            $destinationPath = public_path($public_path);
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $image = $public_path . '/' . $filename;
            $this->majorsRepo->updateWhere(['id' => $major_id], ['signature_image' => $image]);
        }

        return redirect()->back()->with('success','Major Updated Successfully');
    }
    public function deleteMajor($id){
        $this->majorsRepo->deleteById($id);
        return redirect()->back()->with('success','Major Deleted');
    }
    public function majorDetail($id){
    return view('majors.major_detail',['title' => 'majors','major' => $this->majorsRepo->findById($id)]);
    }
    public function deleteMajors(Request $request){
        $this->validate(request(),[
            'delete_ids' => 'required',],['delete_ids.required' => 'Select Record to Delete']);
        $this->majorsRepo->deleteRecords($request->input('delete_ids'));
        return redirect()->back()->with('success','Majors deleted');
    }
    public function sortMajors(Request $request){
        $majors = DB::table('majors')->orderBy('sort_id','ASC')->get();
        $item_id = $request->input('itemId');
        $item_index = $request->input('itemIndex');
        foreach($majors as $major){
            return DB::table('majors')->where('id',$item_id)->update(['sort_id' => $item_index]);
        }
    }






}
