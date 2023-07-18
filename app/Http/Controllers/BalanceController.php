<?php
 
namespace App\Http\Controllers;


use App\Models\Balance;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function index($main)
    {
        
        $balance = $main == 'yes'
        ? Balance::where('main', true)->where('user_id', request()->user()->id)->first()
        : Balance::where('exchange_id',$main)->where('user_id',request()->user()->id)->first();

        request()->session()->put('main', $balance->exchange_id);

        $sign = $balance->exchange->sign;

        $notDone = Balance::find($balance->id)->transactions->where('status','<>','false');
        $toDo = array(floatval(0),floatval(0));
        foreach($notDone as $nd):
            if ($nd->category->type->id == 2):
                $toDo[0] = $toDo[0] + floatval($nd->quantity);
            endif;

            if ($nd->category->type->id == 1){
                $toDo[1] = $toDo[1] + floatval($nd->quantity);
            }
        endforeach;

        $balance = array(
            'total'=>$balance->balance.$sign,
            'saving'=>$balance->saving.$sign,
            'deuda'=>number_format($toDo[0],2).$sign,
            'cobro'=>number_format($toDo[1],2).$sign
        );

        return $balance;
    }

    public function create(Request $request)
    {
        $queries = [
            'userID' => $request->has('userID') ? $request->userID : $request->user()->id,
            'initial' => floatval($request->initial),
            'exchangeID' => intval($request->exchange_id),
            'main' => $request->has('userID') ? true : false 
        ];

        \App\Models\Balance::create([
            'user_id' => $queries['userID'],
            'balance' => $queries['initial'],
            'initial' => $queries['initial'],
            'exchange_id' => $queries['exchangeID'],
            'main' => $queries['main']
        ]);

        if (!$request->is('register.view')){
            $request->session()->put('main',$request->exchange_id);
            return response()->json(['link' => $request->session()->get('_previous')['url']], 200);
        }
    }

    public function store($balance)
    {
        $calc = [floatval($balance->initial), floatval($balance->saving)];
        $transactions = $balance->transactions;

        foreach ($transactions as $transaction):
            if ($transaction->status):
                switch($transaction->category->type->id):
                    case 1:
                        $calc[0] += floatval($transaction->quantity);
                        break;
                    case 3:
                        $calc[1] += floatval($transaction->quantity);
                        break;
                    default:
                        $calc[0] -= floatval($transaction->quantity);
                        break;
                endswitch;
            endif;
        endforeach;

        $balance->balance = $calc[0];
        $balance->saving = $calc[1];
        $balance->save();
    }

    public function update(Request $request)
    {
        if ($request->boolean('change_main')){
            $balances = $request->user()->balance;
            $balances->map(function($balance) use ($request){
                if ($balance->exchange_id ==  $request->session()->get('main')){
                    $balance->main = false;
                    $balance->save();
                }

                if ($balance->exchange_id == $request->main){
                    $balance->main = true;
                    $balance->save();
                }
            });
        }

        $request->session()->put('main', $request->main);

        return response()->json(['link' => $request->session()->get('_previous')['url']], 200);       
    }

    public function destroy(Request $request)
    {
        $currentBalance = $request->user()->balance->where('exchange_id',$request->main)->first();
        $mainOption = $request->session()->get('main');

        if ($mainOption != $request->main OR !$currentBalance->main){
            if ($mainOption == $request->main){
                $realMainBalance = $request->user()->balance->where('main', true)->first();
                $request->session()->put('main', $realMainBalance->exchange_id);
            }

            if ($currentBalance->main){
                $newMainBalance = $request->user()->balance->where('exchange_id',$mainOption)->first();
                $newMainBalance->main = true;
                $newMainBalance->save();
            }

            $currentBalance->delete();
        }

        return response()->json(['link' => $request->session()->get('_previous')['url']], 200);
    }
}
