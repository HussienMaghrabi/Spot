<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use DB;
use Session;
use Stripe;
    
class StripeController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }
   
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        // return response()->json([
        //     'code'    => 200,
        //     'message' => 'success seen data',
        //     'data'    => $request->all()
        // ]);
        // dd($request->all());
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => intval($request->amount) * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "This payment is tested purpose phpcodingstuff.com"
        ]);
        // coins trans
        // user table coins ++
        DB::beginTransaction();
        try {
            $newCoins = $request->coins;
            $user = DB::table('users')->where('id',$request->user_id)->first();
            $userCoin = $user->coins + $newCoins;
            DB::table('users')->where('id',$request->user_id)->update(['coins'=>$userCoin]);
            DB::table('recharge_transactions')->insert(['user_id' => $request->user_id,'amount' => $newCoins]);
            DB::commit();
        }catch(\Exption $e){
            DB::rollBack();
            return $e;
        }
        Session::flash('success', 'Payment successful!');
           
        return back();
    }
    // check on user
    public function userCheck(Request $request)
    {
        // get user 
        $user = DB::table('users')->where('id',$request->user_id)->first();
        if(!empty($user)){
            return response()->json([
                'data'    => $user,
                'message' => 'success',
                'code'    => 200,
            ],200);
            }else{
                return response()->json([
                    'data'    => $user,
                    'message' => 'user not found',
                    'code'    => 404,
                ],404);    
        }
    }
}
