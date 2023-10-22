<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categories()
    {
        $pageTitle = 'All Categories';
        $categories = Category::latest()->paginate(getPaginate());
        $emptyMessage = 'No data found';
        return view('admin.category.category',compact('pageTitle','categories','emptyMessage'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category       = new Category();
        $category->name = $request->name;
        $category->save();

        $notify[] = ['success', 'Category has been added'];
        return back()->withNotify($notify);
    }

    public function updateCategory(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        $notify[] = ['success', 'Category has been Updated.'];
        return back()->withNotify($notify);
    }

    public function searchCategory(Request $request)
    {
        $search         = $request->search;
        $pageTitle      = 'Category Search';
        $emptyMessage   = 'No data found';
        $categories = Category::where('name', 'like',"%$search%")->paginate(getPaginate());

        return view('admin.category.category', compact('pageTitle', 'categories', 'emptyMessage', 'search'));
    }

    public function subcategories($id)
    {
        $category = Category::findOrFail($id);
        $pageTitle = $category->name.' - Subcategories';
        $subcategories = $category->subCategories()->paginate(getPaginate());
        $emptyMessage = 'No data found';
        return view('admin.category.subcategory',compact('pageTitle','subcategories', 'category','emptyMessage'));
    }

    public function storeSubcategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $subcategory = new SubCategory();
        $subcategory->category_id = $category->id;
        $subcategory->name = $request->name;
        $subcategory->save();

        $notify[] = ['success', 'Subcategory has been added.'];
        return back()->withNotify($notify);
    }

    public function updateSubcategory(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string|max:191',
        ]);

        $subcategory = SubCategory::findOrFail($id);
        $subcategory->name = $request->name;
        $subcategory->save();

        $notify[] = ['success', 'Subcategory has been updated.'];
        return back()->withNotify($notify);
    }

    public function searchSubcategory(Request $request, $id)
    {

        $category       = Category::findOrFail($id);
        $search         = $request->search;
        $pageTitle      = 'Subcategory Search';
        $emptyMessage   = 'No data found';
        $subcategories  = SubCategory::where('category_id', $id)->where('name', 'like',"%$search%")->paginate(getPaginate());

        return view('admin.category.subcategory', compact('pageTitle', 'subcategories', 'category', 'emptyMessage'));
    }
}
