<?php

namespace App\Http\Controllers;

use App\Lib\GoogleAuthenticator;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Sell;
use App\Models\SupportTicket;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function home()
    {
        $pageTitle = 'Dashboard';
        $user = auth()->user();
        $completedOrders = Sell::where('user_id',$user->id)->where('status',1)->count();
        $processingOrders = Sell::where('user_id',$user->id)->where('status',0)->count();
        $supportTickets = SupportTicket::where('user_id',$user->id)->count();

        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle','completedOrders','processingOrders','supportTickets'));
    }

    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user = Auth::user();
        return view($this->activeTemplate. 'user.profile_setting', compact('pageTitle','user'));
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => 'sometimes|required|max:80',
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|max:40',
            'city' => 'sometimes|required|max:50',
            'image' => ['image',new FileTypeValidate(['jpg','jpeg','png'])]
        ],[
            'firstname.required'=>'First name field is required',
            'lastname.required'=>'Last name field is required'
        ]);

        $user = Auth::user();

        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
        ];


        if ($request->hasFile('image')) {
            $location = imagePath()['profile']['user']['path'];
            $size = imagePath()['profile']['user']['size'];
            $filename = uploadImage($request->image, $location, $size, $user->image);
            $in['image'] = $filename;
        }
        $user->fill($in)->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {

        $password_validation = Password::min(6);
        $general = GeneralSetting::first();
        if ($general->secure_password) {
            $password_validation = $password_validation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required','confirmed',$password_validation]
        ]);


        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', 'Password changes successfully.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'The password doesn\'t match!'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    /*
     * Deposit History
     */
    public function depositHistory()
    {
        $pageTitle = 'Deposit History';
        $emptyMessage = 'No history found.';
        $logs = auth()->user()->deposits()->with(['gateway'])->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.deposit_history', compact('pageTitle', 'emptyMessage', 'logs'));
    }

    public function show2faForm()
    {
        $general = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->sitename, $secret);
        $pageTitle = 'Two Factor';
        return view($this->activeTemplate.'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user,$request->code,$request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_ENABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Google authenticator enabled successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }


    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user,$request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Two factor authenticator disable successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function purchaseLog()
    {
        $pageTitle = 'Product Purchase Log';
        $products = Sell::where('user_id',auth()->user()->id)->groupBy( 'code')->paginate(getPaginate());

        return view($this->activeTemplate.'user.purchase', compact('pageTitle','products'));
    }

    public function orderDetails($code)
    {
        $orders = Sell::where('code',$code)->with(['product','user'])->paginate(getPaginate());
        $pageTitle = 'Order Code - ['.$code.' ]';

        return view($this->activeTemplate.'user.order_details', compact('pageTitle','orders'));
    }

    public function productDownload($id)
    {
        $product = Product::findOrFail(Crypt::decrypt($id));

        $file = $product->p_file;
        $full_path = 'assets/product/' . $file;
        $title = str_replace(' ','_',strtolower($product->name));
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $mimetype = mime_content_type($full_path);
        header('Content-Disposition: attachment; filename="' . $title . '.' . $ext . '";');
        header("Content-Type: " . $mimetype);
        return readfile($full_path);
    }

    public function rating(Request $request){
        $request->validate([
            'rating' => 'required|integer|gt:0|max:5',
            'product_id' => 'required|integer|gt:0',
            'review' => 'required',
        ]);

        $product = Sell::where('product_id',$request->product_id)->where('user_id',auth()->user()->id)->first();
        $user = auth()->user();

        if ($product == null) {
            $notify[] = ['error', 'Something went wrong'];
            return back()->withNotify($notify);
        }

        $rating = new Rating();
        $rating->product_id = $request->product_id;
        $rating->user_id = $user->id;
        $rating->rating = $request->rating;
        $rating->review = $request->review;
        $rating->save();

        $totalRatingProduct = $product->product->total_rating + $request->rating;
        $totalResponseProduct = $product->product->total_response + 1;
        $avgRatingProduct = round($totalRatingProduct / $totalResponseProduct);

        $product->product->total_rating = $totalRatingProduct;
        $product->product->total_response = $totalResponseProduct;
        $product->product->avg_rating = $avgRatingProduct;
        $product->product->save();

        $notify[] = ['success', 'Thanks for your review'];
        return back()->withNotify($notify);
    }
}
