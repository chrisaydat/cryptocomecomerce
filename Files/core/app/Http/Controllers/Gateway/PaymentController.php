<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\Sell;
use App\Models\Transaction;
use App\Models\User;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        return $this->activeTemplate = activeTemplate();
    }

    public function deposit()
    {
        $orders = Order::where('order_number',auth()->user()->id)->get();

        if (count($orders) > 0) {
            $totalPrice = $orders->sum('total_price');
        }else{
            $notify[] = ['error', 'You have no items in cart'];
            return redirect()->route('home')->withNotify($notify);
        }

        $pageTitle = 'Payment Methods';

        $gatewayCurrency = GatewayCurrency::where('min_amount', '<' ,$totalPrice)->where('max_amount', '>' ,$totalPrice)->whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();

        return view($this->activeTemplate . 'user.payment.deposit', compact('gatewayCurrency', 'pageTitle', 'totalPrice'));
    }

    public function depositInsert(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'method_code' => 'required',
            'currency' => 'required',
            'name' => 'sometimes|required',
            'mobile' => 'sometimes|required',
            'email' => 'sometimes|required|email',
            'address' => 'sometimes|required'
        ]);


        $user = auth()->user();

        $orders = Order::where('order_number',$user->id)->get();

        if (count($orders) > 0) {

            $totalPrice = $orders->sum('total_price');

            $gate = GatewayCurrency::whereHas('method', function ($gate) {
                $gate->where('status', 1);
            })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();
            if (!$gate) {
                $notify[] = ['error', 'Invalid gateway'];
                return back()->withNotify($notify);
            }

            if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
                $notify[] = ['error', 'Please follow deposit limit'];
                return back()->withNotify($notify);
            }

            $charge = $gate->fixed_charge + ($request->amount * $gate->percent_charge / 100);
            $payable = $request->amount + $charge;
            $final_amo = $payable * $gate->rate;

            $data = new Deposit();
            $data->user_id = $user->id;
            $data->method_code = $gate->method_code;
            $data->method_currency = strtoupper($gate->currency);
            $data->amount = $request->amount;
            $data->charge = $charge;
            $data->rate = $gate->rate;
            $data->final_amo = $final_amo;
            $data->btc_amo = 0;
            $data->btc_wallet = "";
            $data->trx = getTrx();
            $data->try = 0;
            $data->status = 0;
            $data->shipping =  [
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->mobile,
                'address' => $request->address
            ];
            $data->save();
            session()->put('Track', $data->trx);
            return redirect()->route('user.deposit.preview');
        }else{
            $notify[] = ['error', 'You have no items in cart'];
            return redirect()->route('home')->withNotify($notify);
        }
    }


    public function depositPreview()
    {

        $track = session()->get('Track');
        $data = Deposit::where('trx', $track)->where('status',0)->orderBy('id', 'DESC')->firstOrFail();
        $pageTitle = 'Payment Preview';
        return view($this->activeTemplate . 'user.payment.preview', compact('data', 'pageTitle'));
    }


    public function depositConfirm()
    {
        $track = session()->get('Track');
        $deposit = Deposit::where('trx', $track)->where('status',0)->orderBy('id', 'DESC')->with('gateway')->firstOrFail();

        if ($deposit->method_code >= 1000) {
            $this->userDataUpdate($deposit);
            $notify[] = ['success', 'Your deposit request is queued for approval.'];
            return back()->withNotify($notify);
        }


        $dirName = $deposit->gateway->alias;
        $new = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);


        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if(@$data->session){
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $pageTitle = 'Payment Confirm';
        return view($this->activeTemplate . $data->view, compact('data', 'pageTitle', 'deposit'));
    }


    public static function userDataUpdate($trx)
    {
        $orders = Order::where('order_number',auth()->user()->id)->get();

        if (count($orders) > 0) {

            $general = GeneralSetting::first();
            $data = Deposit::where('trx', $trx)->first();

            if ($data->status == 0) {

                $user = User::find($data->user_id);
                $code = getTrx(8);

                foreach ($orders as $item) {
                    $sell = new Sell();
                    $sell->code = $code;
                    $sell->user_id = $user->id;
                    $sell->product_id = $item->product_id;
                    $sell->qty = $item->qty;
                    $sell->product_price = $item->product_price;
                    $sell->total_price = $item->total_price;
                    $sell->status = 1;
                    $sell->payment_status = 1;
                    $sell->save();

                    $sell->product->total_sell += 1;
                    $sell->product->save();
                }

                $data->status = 1;
                $data->code = $code;
                $data->save();

                $transaction = new Transaction();
                $transaction->user_id = $data->user_id;
                $transaction->amount = $data->amount;
                $transaction->charge = $data->charge;
                $transaction->trx_type = '+';
                $transaction->details = 'Payment Via ' . $data->gatewayCurrency()->name;
                $transaction->trx = $data->trx;
                $transaction->save();

                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $user->id;
                $adminNotification->title = 'Payment successful via '.$data->gatewayCurrency()->name;
                $adminNotification->click_url = urlPath('admin.deposit.successful');
                $adminNotification->save();

                notify($user, 'PAYMENT_COMPLETE', [
                    'method_name' => $data->gatewayCurrency()->name,
                    'method_currency' => $data->method_currency,
                    'method_amount' => showAmount($data->final_amo),
                    'amount' => showAmount($data->amount),
                    'charge' => showAmount($data->charge),
                    'currency' => $general->cur_text,
                    'rate' => showAmount($data->rate),
                    'trx' => $data->trx
                ]);

                foreach ($orders as $item) {
                    $item->delete();
                }

                $notify[] = ['success', 'Your Payment is successful'];
                return redirect()->route('user.purchase.log')->withNotify($notify);
            }
        }else{
            $notify[] = ['error', 'You have no items in cart'];
            return redirect()->route('home')->withNotify($notify);
        }
    }

    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return redirect()->route(gatewayRedirectUrl());
        }
        if ($data->method_code > 999) {

            $pageTitle = 'Payment Confirm';
            $method = $data->gatewayCurrency();
            return view($this->activeTemplate . 'user.manual_payment.manual_confirm', compact('data', 'pageTitle', 'method'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $orders = Order::where('order_number',auth()->user()->id)->get();

        if (count($orders) > 0) {

            $track = session()->get('Track');
            $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
            if (!$data) {
                return redirect()->route(gatewayRedirectUrl());
            }

            $params = json_decode($data->gatewayCurrency()->gateway_parameter);

            $rules = [];
            $inputField = [];
            $verifyImages = [];

            if ($params != null) {
                foreach ($params as $key => $custom) {
                    $rules[$key] = [$custom->validation];
                    if ($custom->type == 'file') {
                        array_push($rules[$key], 'image');
                        array_push($rules[$key], new FileTypeValidate(['jpg','jpeg','png']));
                        array_push($rules[$key], 'max:2048');

                        array_push($verifyImages, $key);
                    }
                    if ($custom->type == 'text') {
                        array_push($rules[$key], 'max:191');
                    }
                    if ($custom->type == 'textarea') {
                        array_push($rules[$key], 'max:300');
                    }
                    $inputField[] = $key;
                }
            }
            $this->validate($request, $rules);


            $directory = date("Y")."/".date("m")."/".date("d");
            $path = imagePath()['verify']['deposit']['path'].'/'.$directory;
            $collection = collect($request);
            $reqField = [];
            if ($params != null) {
                foreach ($collection as $k => $v) {
                    foreach ($params as $inKey => $inVal) {
                        if ($k != $inKey) {
                            continue;
                        } else {
                            if ($inVal->type == 'file') {
                                if ($request->hasFile($inKey)) {
                                    try {
                                        $reqField[$inKey] = [
                                            'field_name' => $directory.'/'.uploadImage($request[$inKey], $path),
                                            'type' => $inVal->type,
                                        ];
                                    } catch (\Exception $exp) {
                                        $notify[] = ['error', 'Could not upload your ' . $inKey];
                                        return back()->withNotify($notify)->withInput();
                                    }
                                }
                            } else {
                                $reqField[$inKey] = $v;
                                $reqField[$inKey] = [
                                    'field_name' => $v,
                                    'type' => $inVal->type,
                                ];
                            }
                        }
                    }
                }
                $data->detail = $reqField;
            } else {
                $data->detail = null;
            }

            $adminNotification = new AdminNotification();
            $adminNotification->user_id = $data->user->id;
            $adminNotification->title = 'Deposit request from '.$data->user->username;
            $adminNotification->click_url = urlPath('admin.deposit.details',$data->id);
            $adminNotification->save();

            $general = GeneralSetting::first();
            notify($data->user, 'PAYMENT_REQUEST', [
                'method_name' => $data->gatewayCurrency()->name,
                'method_currency' => $data->method_currency,
                'method_amount' => showAmount($data->final_amo),
                'amount' => showAmount($data->amount),
                'charge' => showAmount($data->charge),
                'currency' => $general->cur_text,
                'rate' => showAmount($data->rate),
                'trx' => $data->trx
            ]);

            $user = User::find($data->user_id);
            $code = getTrx(8);

            foreach ($orders as $item) {

                $sell = new Sell();
                $sell->code = $code;
                $sell->user_id = $user->id;
                $sell->product_id = $item->product_id;
                $sell->qty = $item->qty;
                $sell->product_price = $item->product_price;
                $sell->total_price = $item->total_price;
                $sell->status = 2;
                $sell->payment_status = 0;
                $sell->save();
            }

            foreach ($orders as $item) {
                $item->delete();
            }

            $data->status = 2; // pending
            $data->code = $code;
            $data->save();

            $notify[] = ['success', 'Your payment request has been taken.'];
            return redirect()->route('user.purchase.log')->withNotify($notify);

        }else{
            $notify[] = ['error', 'You have no items in cart'];
            return redirect()->route('home')->withNotify($notify);
        }
    }
}
