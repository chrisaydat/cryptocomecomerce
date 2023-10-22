<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Deposit;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\Sell;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function allProduct(Request $request)
    {
        $search = $request->search;
        if($search){
            $pageTitle = "Search Result of $search";
            $products = Product::where('name','like',"%$search%")->latest()->paginate(getPaginate());

        }else{
            $pageTitle = 'All Products';
            $products = Product::latest()->with(['category','subcategory'])->paginate(getPaginate());
        }
        $emptyMessage = 'No data found';

        return view('admin.product.index',compact('pageTitle','emptyMessage','products'));
    }

    public function newProduct()
    {
        $pageTitle = 'Add New Product';
        $categories = Category::latest()->with('subcategories')->get();

        return view('admin.product.new',compact('pageTitle','categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'category_id'       => 'required|integer|gt:0',
            'sub_category_id'   => 'required|integer|gt:0',
            'name'              => 'required|max:255',
            'short_description' => 'required',
            'old_price'         => 'nullable|numeric|gt:0',
            'new_price'         => 'required|numeric|gt:0',
            'image'             => 'required|array|min:1',
            'image.*'           => ['required','image','max:2048', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'p_file' => ['nullable', new FileTypeValidate(['zip', 'txt', 'pdf'])],
        ]);


        $pImage = [];
        if ($request->hasFile('image')){
            foreach ($request->image as $item) {
                try{
                    $location = imagePath()['p_image']['path'];
                    $size = imagePath()['p_image']['size'];
                    $pImage[] = uploadImage($item, $location,$size);

                }catch(\Exception $exp) {
                    $notify[] = ['error', 'Could not upload the image'];
                    return back()->withNotify($notify);
                }
            }
        }

        $pFile = '';
        if ($request->hasFile('p_file')){
            try{
                $location = imagePath()['p_file']['path'];
                $pFile = str_replace(' ','_',strtolower($request->name)).'_'.uniqid().time().'.'.$request->p_file->getClientOriginalExtension();
                $request->p_file->move($location, $pFile);

            }catch(\Exception $exp) {
                $notify[] = ['error', 'Could not upload the file'];
                return back()->withNotify($notify);
            }
        }

        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->old_price = $request->old_price;
        $product->new_price = $request->new_price;
        $product->image = $pImage;
        $product->p_file = $pFile;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->save();

        $notify[] = ['success', 'Product has been successfully added'];
        return back()->withNotify($notify);
    }

    public function editProduct($id)
    {
        $pageTitle = 'Edit Product';
        $product = Product::findOrFail($id);
        $categories = Category::latest()->with('subcategories')->get();

        return view('admin.product.edit',compact('pageTitle', 'product','categories'));
    }

    public function updateProduct(Request $request ,$id)
    {
        $request->validate([
            'category_id' => 'required|integer|gt:0',
            'sub_category_id' => 'required|integer|gt:0',
            'name' => 'required|max:255',
            'short_description' => 'required',
            'old_price' => 'nullable|numeric|gt:0',
            'new_price' => 'required|numeric|gt:0',
            'image' => 'nullable|array|min:1',
            'image.*' => ['nullable','image','max:2048', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'p_file' => ['nullable', new FileTypeValidate(['zip', 'txt', 'pdf'])],
        ]);

        $product = Product::findOrFail($id);


        if($request->image){
            $pImage = [];

            foreach ($request->image as $item) {
                try{
                    $location = imagePath()['p_image']['path'];
                    $size = imagePath()['p_image']['size'];
                    $pImage[] = uploadImage($item, $location,$size);

                }catch(\Exception $exp) {
                    $notify[] = ['error', 'Could not upload the image'];
                    return back()->withNotify($notify);
                }
            }

        }else{
            $pImage = [];
        }

        $pFile = $product->p_file;
        if ($request->hasFile('p_file')){
            try{
                $location = imagePath()['p_file']['path'];
                removeFile($location . '/' . $pFile);
                $pFile = str_replace(' ','_',strtolower($request->name)).'_'.uniqid().time().'.'.$request->p_file->getClientOriginalExtension();
                $request->p_file->move($location, $pFile);

            }catch(\Exception $exp) {
                $notify[] = ['error', 'Could not upload the file'];
                return back()->withNotify($notify);
            }
        }

        $finalImageValues = array_merge($product->image,$pImage);

        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->old_price = $request->old_price;
        $product->new_price = $request->new_price;
        $product->image = $finalImageValues;
        $product->p_file = $pFile;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->save();

        $notify[] = ['success', 'Product has been successfully updated'];
        return back()->withNotify($notify);
    }

    public function removeImage($id,$name){

        $product = Product::findOrFail($id);
        $pImages = [];

        if (in_array($name,$product->image)) {

            foreach ($product->image as  $item) {
                if ($item == $name) {

                }else{

                    $pImages[] = $item;
                }
            }

            $product->image = $pImages;
            $product->save();

            $notify[] = ['success', 'Image removed successfully'];
            return back()->withNotify($notify);

        }else{
            $notify[] = ['error', 'Image not found'];
            return back()->withNotify($notify);
        }

    }

    public function enableProduct(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|gt:0',
        ]);

        $product = Product::findOrFail($request->id);

        $product->status = 1;
        $product->save();

        $notify[] = ['success', 'Product enabled successfully'];
        return back()->withNotify($notify);
    }

    public function disableProduct(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|gt:0',
        ]);

        $product = Product::findOrFail($request->id);

        $product->status = 0;
        $product->save();

        $notify[] = ['success', 'Product disabled successfully'];
        return back()->withNotify($notify);
    }

    public function featuredProduct(Request $request){
        $request->validate([
            'id' => 'required|integer|gt:0'
        ]);

        $product = Product::findOrFail($request->id);

        $product->featured = 1;
        $product->save();

        $notify[] = ['success', 'Product has been featured successfully'];
        return back()->withNotify($notify);
    }

    public function unFeaturedProduct(Request $request){
        $request->validate([
            'id' => 'required|integer|gt:0'
        ]);

        $product = Product::findOrFail($request->id);

        $product->featured = 0;
        $product->save();

        $notify[] = ['success', 'Product has been unfeatured successfully'];
        return back()->withNotify($notify);
    }

    public function processing(){
        $pageTitle = 'Processing Orders';
        $orders = Sell::where('status',0)->with('user')->latest()->groupBy('code')->paginate(getPaginate());
        $emptyMessage = 'No data found.';

        return view('admin.orders',compact('pageTitle', 'orders','emptyMessage'));
    }

    public function completed(){
        $pageTitle = 'Completed Orders';
        $orders = Sell::where('status',1)->with('user')->latest()->groupBy('code')->paginate(getPaginate());
        $emptyMessage = 'No data found.';

        return view('admin.orders',compact('pageTitle', 'orders','emptyMessage'));
    }

    public function rejected(){
        $pageTitle = 'Rejected Orders';
        $orders = Sell::where('status',3)->with('user')->latest()->groupBy('code')->paginate(getPaginate());
        $emptyMessage = 'No data found.';

        return view('admin.orders',compact('pageTitle', 'orders','emptyMessage'));
    }

    public function orderDetails($code){
        $pageTitle = 'Order Details';
        $orderDetails = Sell::where('code',$code)->with(['user','product'])->get();
        $shippingAddress = Deposit::where('code',$code)->pluck('shipping');
        $emptyMessage = 'No data found';
        return view('admin.order_details',compact('pageTitle', 'emptyMessage','orderDetails','shippingAddress'));
    }

    public function complete(Request $request){
        $request->validate([
            'code' => 'required'
        ]);


        $sells = Sell::where('code',$request->code)->get();

        foreach ($sells as $item) {
            $item->status = 1;
            $item->save();
        }

        notify($sells[0]->user, 'PRODUCT_DELIVERED', [
            'code' => $sells[0]->code
        ]);

        $notify[] = ['success', 'Order has been marked as completed successfully'];
        return back()->withNotify($notify);
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $emptyMessage = 'No search result was found.';
        $orders = Sell::where(function($query) use ($search){
            $query->orWhere('code',$search)->orWhereHas('product', function ($product) use ($search) {
                $product->where('name', 'like', "%$search%");
            });
        });

        if ($scope == 'processing') {
            $pageTitle = 'Processing Order Search';
            $orders = $orders->where('status',1);
        }elseif($scope == 'completed'){
            $pageTitle = 'Completed Order Search';
            $orders = $orders->where('status',1);
        }else{
            $pageTitle = 'Order Search';
        }

        $orders = $orders->latest()->paginate(getPaginate());
        $pageTitle .= '-' . $search;

        return view('admin.orders', compact('pageTitle', 'search', 'scope', 'emptyMessage', 'orders'));
    }

    public function dateSearch(Request $request,$scope = null){
        $search = $request->date;
        if (!$search) {
            return back();
        }
        $date = explode('-',$search);
        $start = @$date[0];
        $end = @$date[1];
        // date validation
        $pattern = "/\d{2}\/\d{2}\/\d{4}/";
        if ($start && !preg_match($pattern,$start)) {
            $notify[] = ['error','Invalid date format'];
            return redirect()->route('admin.order.processing')->withNotify($notify);
        }
        if ($end && !preg_match($pattern,$end)) {
            $notify[] = ['error','Invalid date format'];
            return redirect()->route('admin.order.processing')->withNotify($notify);
        }


        if ($start) {
            $orders = Sell::whereDate('created_at',Carbon::parse($start));
        }
        if($end){
            $orders = Sell::whereDate('created_at','>=',Carbon::parse($start))->whereDate('created_at','<=',Carbon::parse($end));
        }

        if ($scope == 'processing') {
            $pageTitle = 'Processing Order Search';
            $orders = $orders->where('status', 0);
        }elseif($scope == 'completed'){
            $pageTitle = 'Completed Order Search';
            $orders = $orders->where('status', 1);
        }elseif($scope == 'rejected'){
            $pageTitle = 'Rejected Order Search';
            $orders = $orders->where('status', 3);
        }
        $orders = $orders->groupBy('code')->latest()->with('user')->paginate(getPaginate());

        $pageTitle .= '-' . $search;
        $emptyMessage = 'No data found';
        $dateSearch = $search;
        return view('admin.orders', compact('pageTitle', 'emptyMessage', 'orders','dateSearch','scope'));
    }
}
