<?php

namespace App\Http\Controllers;


use App\Http\Requests\Admin\AddCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;

use App\Link;
use App\Repositories\EventsRepository;
use App\Repositories\SpeakerRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\UniRepository;
use App\Repositories\UsersRepository;
use App\Uni;
use App\User;
use http\Client;
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
    public function getLinks(){
        $links = Link::all();
        return view('links.links',['title' => 'links','links' => $links]);
    }

    public function showCategoryView(){
        return view('categories.add_category',['title' => 'categories']);
    }

    public function showLinkView(){
        return view('links.add_link',['title' => 'links']);
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

    public function addLink(Request $request){
        $this->validate($request, array(
            'link' => 'required',
        ));
        Link::create($request->all());
        return redirect()->back()->with('success','Link Added Successfully');
    }

    public function editCategoryForm($id){
        $category = $this->categoryRepo->findById($id);
        return view('categories.edit_category',['title' => 'categories','category' => $category]);
    }

    public function editLinkForm($id){
        $link = Link::find($id);
        return view('links.edit_link',['title' => 'links','link' => $link]);
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


    public function updateLink(Request $request,$id){
        $this->validate($request, array(
            'link' => 'required',
        ));
        Link::where('id',$id)->update(['link' => $request->link]);
        return redirect()->back()->with('success','Link Updated Successfully');
    }

    public function deleteCategory($id){
        $this->categoryRepo->deleteById($id);
        return redirect()->back()->with('success','Category Deleted');
    }

    public function deleteLink($id){
        Link::where('id',$id)->delete();
        return redirect()->back()->with('success','Link Deleted');
    }
    public function categoryDetail($id){
    return view('categories.category_detail',['title' => 'categories','category' => $this->categoryRepo->findById($id)]);
    }
    public function subCategories($id) {



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

    public function getSub() {

    }






}
