<?php

namespace App\Http\Controllers;
use App\Models\AdminNotification;
use App\Models\Advertise;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\Product;
use App\Models\Rating;
use App\Models\SubCategory;
use App\Models\Subscriber;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SiteController extends Controller
{

    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index(){
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','home')->count();
        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'HOME';
            $page->slug = 'home';
            $page->save();
        }
        $pageTitle = 'Home';
        $bannerElements = Frontend::where('data_keys','banner.element')->latest()->get();

        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','home')->first();
        return view($this->activeTemplate . 'home', compact('pageTitle','sections','bannerElements'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle','sections'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact',compact('pageTitle'));
    }


    public function contactSubmit(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function products()
    {
        $pageTitle = 'Products';

        $products = Product::where('status',1)->with('category', 'subcategory')->paginate(getPaginate());


        $min = floor($products->min('new_price'));
        $max = ceil($products->max('new_price'));

        return view($this->activeTemplate.'search',compact('pageTitle','products', 'min', 'max'));
    }

    public function productSearch(Request $request)
    {
        $pageTitle = 'Search Results';
        $search = $request->search_p;


        $products = Product::where('status',1)->where(function($q) use ($search) {
            $q->where('name', 'LIKE' ,"%$search%")->orWhereHas('category', function ($category) use ($search) {
                $category->where('name', 'LIKE', "%$search%");
            })->orWhereHas('subcategory', function($subcategory) use ($search){
                $subcategory->where('name', 'LIKE', "%$search%");
            });
        });

        if(@$request->search_c > 0){
            $products = $products->where('category_id',$request->search_c);
        }

        $products = $products->with('subcategory')->latest()->paginate(getPaginate());

        $min = floor($products->min('new_price'));
        $max = ceil($products->max('new_price'));


        return view($this->activeTemplate . 'search', compact('products','pageTitle','min','max'));
    }

    public function categorySearch($id)
    {
        $category = Category::findOrFail($id);
        $pageTitle = 'Search Result For '.$category->name;

        $products = $category->products()->where('status',1)->with('subcategory')->latest()->paginate(getPaginate());

        $min = floor($products->min('new_price'));
        $max = ceil($products->max('new_price'));

        return view($this->activeTemplate.'search',compact('pageTitle','products','min','max'));
    }

    public function subcategorySearch($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $pageTitle = 'Search Result For '.$subcategory->name;

        $products = $subcategory->products()->where('status',1)->with('subcategory')->latest()->paginate(getPaginate());

        $min = floor($products->min('new_price'));
        $max = ceil($products->max('new_price'));

        return view($this->activeTemplate.'search',compact('pageTitle','products','min','max'));
    }

    public function productFilter(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'min'       => 'required|numeric',
            'max'       => 'required|numeric',
            'sortby'    => 'nullable|integer|min:0|max:4',
        ]);

        if($validate->fails()){
            return response()->json(['error' => $validate->errors()]);
        }

        $min = $request->min;
        $max = $request->max;
        $sortBy = $request->sortby;

        $products = Product::where('status',1)->where('new_price', '>=', $min)->where('new_price', '<=' ,$max);

        if ($request->search_p) {
            $search = $request->search_p;

            $products->where(function($q) use ($search) {
                $q->where('name', 'LIKE' ,"%$search%")->orWhereHas('category', function ($category) use ($search) {
                    $category->where('name', 'LIKE', "%$search%");
                })->orWhereHas('subcategory', function($subcategory) use ($search){
                    $subcategory->where('name', 'LIKE', "%$search%");
                });
            });
        }

        if ($request->search_c) {
            $products = $products->where('category_id',$request->search_c);
        }

        if($sortBy == 0){
            $products = $products->orderBy('id');
        }elseif($sortBy == 1){
            $products = $products->latest();
        }elseif($sortBy == 2){
            $products = $products->orderBy('new_price');
        }elseif($sortBy == 3){
            $products = $products->orderBy('new_price','desc');
        }elseif($sortBy == 4){
            $products = $products->orderBy('avg_rating','desc');
        }else{
            $products = $products;
        }
        $products = $products->with('subcategory')->limit(10)->get();

        $view = view($this->activeTemplate.'filtered_search',compact('products'))->render();
        return response()->json([
            'html' => $view,
         ]);
    }

    public function loadmoreProducts(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'count' => 'required|integer|gt:0',
            'min' => 'required|numeric',
            'max' => 'required|numeric',
            'sortby' => 'nullable|min:0|max:4'
        ]);

        if($validate->fails()){
            return response()->json(['error' => $validate->errors()]);
        }

        $min = $request->min;
        $max = $request->max;
        $sortBy = $request->sortby;

        $products = Product::where('status',1)->where('new_price', '>=', $min)->where('new_price', '<=' ,$max);

        if($sortBy == 0){
            $products = $products->orderBy('id');
        }elseif($sortBy == 1){
            $products = $products->latest();
        }elseif($sortBy == 2){
            $products = $products->orderBy('new_price');
        }elseif($sortBy == 3){
            $products = $products->orderBy('new_price','desc');
        }elseif($sortBy == 4){
            $products = $products->orderBy('avg_rating','desc');
        }else{
            $products = $products;
        }

        $products = $products->with('subcategory')->skip($request->count)->limit(9)->get();

        $view = view($this->activeTemplate.'pagination_search',compact('products'))->render();
        return response()->json([
            'html' => $view,
            'productCount' => count($products),
         ]);
    }

    public function productDetails($id,$slug)
    {
        $pageTitle = 'Products Details';
        $product = Product::where('status',1)->with('category.products.subcategory')->findOrFail($id);
        $ratings = Rating::where('product_id',$product->id)->with('user')->limit(6)->get();
        $offerElements = getContent('home_page_offer.element',false);
        return view($this->activeTemplate.'product_details',compact('pageTitle','product','offerElements','ratings'));
    }

    public function loadmoreRating(Request $request)
    {
        $request->validate([
            'count' => 'required|integer|gt:0',
            'id' => 'required|integer|gt:0',
        ]);
        $product = Product::where('status',1)->findOrFail($request->id);
        $ratings = $product->ratings()->with('user')->latest()->skip($request->count)->limit(5)->get();
        $view = view($this->activeTemplate.'ratings',compact('ratings'))->render();

        return response()->json([
            'success' => true,
            'ratings' => $ratings,
            'html' => $view,
        ]);
    }

    public function blogs()
    {
        $pageTitle = 'Blogs';
        $blogElements = Frontend::where('data_keys', 'blog.element')->latest()->paginate(getPaginate());
        return view($this->activeTemplate.'blog',compact('pageTitle','blogElements'));
    }

    public function blogDetails($id,$slug){
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $pageTitle = $blog->data_values->title;
        $blogElements = Frontend::where('data_keys', 'blog.element')->limit(6)->latest()->get();
        return view($this->activeTemplate.'blog_details',compact('blog','pageTitle','blogElements'));
    }

    public function subscriberStore(Request $request) {


        $validate = Validator::make($request->all(),[
            'email' => 'required|email|unique:subscribers',
        ]);

        if($validate->fails()){
            return response()->json(['error' => $validate->errors()]);
        }

        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        return response()->json(['success' => 'Subscribed Successfully!']);
    }

    public function policy($id)
    {
        $pageTitle = 'Company Policy';
        $policy = Frontend::findOrFail($id);

        return view($this->activeTemplate.'policy',compact('pageTitle','policy'));
    }

    public function cookieAccept(){
        session()->put('cookie_accepted',true);
        return response()->json(['success' => 'Cockie accepted successfully']);
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }
}
