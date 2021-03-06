<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $category = DB::table('categories')->orderBy('id', 'desc')->paginate(5);
        return view('backend.category.index', compact('category'));
    }

    public function AddCategory()
    {
        return view('backend.category.create');
    }

    public function StoreCategory(Request $request)
    {
        $validatedData = $request->validate([
            'category_en' => 'required|unique:categories|max:255',
            'category_ar' => 'required|unique:categories|max:255'
        ]);

        $data = [];
        $data['category_en'] = $request->category_en;
        $data['category_ar'] = $request->category_ar;
        DB::table('categories')->insert($data);
        $notification = array(
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('categories')->with($notification);
    }

    public function EditCategory($id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        return view('backend.category.edit', compact('category'));
    }

    public function UpdateCategory(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category_en' => 'required|unique:categories|max:255',
            'category_ar' => 'required|unique:categories|max:255'
        ]);

        $data = [];
        $data['category_en'] = $request->category_en;
        $data['category_ar'] = $request->category_ar;
        DB::table('categories')->where('id', $id)->update($data);
        $notification = array(
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('categories')->with($notification);
    }

    public function DeleteCategory($id)
    {
        DB::table('categories')->where('id', $id)->delete();
        $notification = array(
            'message' => 'Category Dleleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('categories')->with($notification);
    }
}
