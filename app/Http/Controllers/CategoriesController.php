<?php

namespace App\Http\Controllers;


use App\Http\Requests\Admin\AddCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;

use App\Repositories\EventsRepository;
use App\Repositories\SpeakerRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\UniRepository;
use App\Repositories\UsersRepository;
use App\Uni;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\DB;



class CategoriesController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $categoryRepo = null;
    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function getCategories(){
        $categories = $this->categoryRepo->getAllCategories();
        return view('categories.categories',['title' => 'categories','categories' => $categories]);
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
        dd($id);
    }
    public function deleteCategories(Request $request){
        $this->validate(request(),[
            'delete_ids' => 'required',],['delete_ids.required' => 'Select Record to Delete']);
        $this->categoryRepo->deleteRecords($request->input('delete_ids'));
        return redirect()->back()->with('success','Categorys deleted');
    }
    public function sortCategories(Request $request){
        $categories = DB::table('categories')->orderBy('sort_id','ASC')->get();
        $item_id = $request->input('itemId');
        $item_index = $request->input('itemIndex');
        foreach($categories as $category){
            return DB::table('categories')->where('id',$item_id)->update(['sort_id' => $item_index]);
        }
    }






}
