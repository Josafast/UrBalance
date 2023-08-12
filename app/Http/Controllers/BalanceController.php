<?php
 
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function index($balance)
    {
        $sign = $balance->exchange->sign;

        $notDone = $balance->transactions->reduce(function ($previous, $transaction) {
            if (!boolval($transaction->status)){
                if ($transaction->category->type_id == 2) {
                    $previous[0] += floatval($transaction->quantity / 100);
                } elseif ($transaction->cateogry->type_id == 1) {
                    $previous[1] += floatval($transaction->quantity / 100);
                }
            }
            return $previous;
        }, [0, 0]);

        $balanceValues = array(
            'total'=>number_format($balance->balance/100, 2).$sign,
            'savings'=>number_format($balance->saving/100, 2).$sign,
            'debts'=>number_format($notDone[0],2).$sign,
            'charges'=>number_format($notDone[1],2).$sign
        );

        return $balanceValues;
    }

    public function create(Request $request)
    {
        $queries = [
            'userID' => auth()->check() ? $request->user()->id : $request->input('userID'),
            'initial' => floatval($request->initial)*100,
            'exchangeID' => intval($request->exchange_id),
            'main' => !auth()->check() 
        ];

        \App\Models\Balance::create([
            'user_id' => $queries['userID'],
            'balance' => $queries['initial'],
            'initial' => $queries['initial'],
            'exchange_id' => $queries['exchangeID'],
            'main' => $queries['main']
        ]);

        if (auth()->check()){
            session()->put('main',$request->exchange_id);
            return response()->json(['link' => request()->session()->get('_previous')['url'], 'messages' => ['message' => [__('balance.messages.created')]], 'status' => 'done'], 200);
        }
    }

    public function store_all($balance){
        $this->calculateAndUpdateBalance($balance->transactions, $balance);
    }

    public function store($transaction){
        $this->calculateAndUpdateBalance($transaction, $transaction->balance->first());
    }

    public function calculateAndUpdateBalance($transactions, $balance){
        if (is_countable($transactions)) {
            $calc = [intval($balance->initial), 0];
            foreach($transactions as $transaction){
                $this->transaction_store($transaction, $calc);
            }
        } else {
            $calc = [intval($balance->balance), intval($balance->saving)];
            $this->transaction_store($transactions, $calc);
        }

        $balance->balance = $calc[0];
        $balance->saving = $calc[1];
        $balance->save();
    }

    protected function transaction_store($transaction, &$calc){
        if ($transaction->status){
            switch($transaction->category->type->id){
                case 1:
                    $calc[0] += intval($transaction->quantity);
                    break;
                case 3:
                    $calc[1] += intval($transaction->quantity);
                    break;
                default:
                    if ($transaction->category_id == 12){
                        $calc[1] -= intval($transaction->quantity);
                        break;
                    } else {
                        $calc[0] -= intval($transaction->quantity);
                        break;
                    }
            }
        }
    }

    public function update(Request $request)
    {
        if ($request->boolean('change_main')){
            $balances = $request->user()->balance;
            $balances->where('exchange_id','=',$request->session()->get('main'))
		             ->first()->update(['main' => false]);
		 
            $balances->where('exchange_id','=',$request->main)
		             ->first()->update(['main' => true]);
        }

        session()->put('main', $request->main);

        return response()->json(['link' => request()->session()->get('_previous')['url'], 'messages' => ['message' => [$request->boolean('change_main') ? __('balance.messages.main_modified') : __('balance.messages.current_changed')]], 'status' => 'edited'], 200);   
    }

    public function destroy(Request $request)
    {
        $balances = $request->user()->balance;
        $realMainbalance = $balances->where('main', true)->first();
        $mainOption = session()->get('main');
        $currentBalance = '';

        $balances->when($realMainbalance->exchange_id == $request->main, function ($query) use ($request, $mainOption, &$realMainbalance, &$currentBalance){
            $currentBalance = $realMainbalance;
            
            $realMainbalance = $request->main == $mainOption ? 
                $query->where('main', false)->first() :
                $query->where('exchange_id', $mainOption)->first();

            $realMainbalance->main = true;
            $realMainbalance->save();
            $request->session()->put('main', $realMainbalance->exchange_id);
        }, function ($query) use (&$currentBalance, $request){
            $currentBalance = $query->where('exchange_id', $request->main)->first();
        });

        $currentBalance->delete();

        return response()->json(['link' => session()->get('_previous')['url'], 'messages' => ['message' => [__('balance.messages.deleted')]], 'status' => 'deleted'], 200);
    }
}
