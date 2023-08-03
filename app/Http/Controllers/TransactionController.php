<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $main = $request->session()->get('main');
        $request->session()->put('main', $main);

        return view('transactions');
    }

    public function create()
    {
        return view('transactions-create');
    }

    public function notes(Request $request){
        $transaction = $this->find($request->id);
        return response()->json(['notes' => parsedown($transaction->notes), 'name' => $transaction->name], 200);
    }

    public function store(Request $request)
    {
        $balanceDestiny = $request->user()->balance->where('exchange_id', $request->session()->get('main'))->first();
        $balanceDestinyID = $balanceDestiny->id;

        $data = $request->only(['name', 'quantity', 'status', 'notes', 'category_id', 'date']);
        
        $data['quantity'] = floatval($data['quantity']);
        $data['quantity'] *= 100;
        $data['quantity'] = intval($data['quantity']);
        $data['date'] = new DateTime($data['date']);

        $transaction = Transaction::create($data);

        DB::table('balance_transaction')->insert([
            'balance_id' => $balanceDestinyID,
            'transaction_id' => $transaction->id
        ]);

        $balanceUpdateValues = app()->make('App\Http\Controllers\BalanceController');
        $balanceUpdateValues->store($balanceDestiny);

        return redirect()->route('dashboard');
    }
    
    public function show($transactions, $queries)
    {
        if (count($queries) >= 1){
            if ($queries['type'] != '') {
                $type = $queries['type'];
                $transactions = $transactions->filter(function ($transaction) use ($type) {
                    return $transaction->category->type_id == intval($type);
                });
            }

            if ($queries['state'] != ''){
                $state = $queries['state'];
                $transactions = $transactions->filter(function ($transaction) use ($state) {
                    return var_export($transaction->status, true) == $state;
                });
            }

            if ($queries['base'] != '' || $queries['limit'] != ''){
                $baseLimit = [
                    $queries['base'] == null ? '0' : $queries['base']*100,
                    $queries['limit'] == null ? '100000000000000000000000' : $queries['limit']*100
                ];
                $transactions = $transactions->filter(function ($transaction) use ($baseLimit) {
                    return $transaction->quantity >= $baseLimit[0] && $transaction->quantity <= $baseLimit[1];
                });
            }
    
            if ($queries['since'] != '' || $queries['until'] != ''){
                $sinceUntil = [
                    $queries['since'] == null ? date_modify(new DateTime(), '-10 days') : new DateTime($queries['since']),
                    $queries['until'] == null ? new DateTime() : date_modify(new DateTime($queries['until']), '+1 day')
                ];
                $transactions = $transactions->filter(function ($transaction) use ($sinceUntil) {
                    return new DateTime($transaction->date) >= $sinceUntil[0] && new DateTime($transaction->date) <= $sinceUntil[1];
                });
            }
        }
        return $transactions;
    }

    protected function find(int $id){
        $balances = request()->user()->balance;
        $balanceID = $balances->where('exchange_id', request()->session()->get('main'))->first()->id; 
        $transaction = Transaction::whereHas('balance', function($query) use ($balanceID){
            $query->where('id', $balanceID);
        })->where('id', $id)->first();

        return $transaction;
    }

    public function edit(int $id)
    {
        $transaction = $this->find($id);

        if ($transaction){
            return view('transactions-create', compact('transaction'));
        } 

        return redirect(request()->session()->get('_previous')['url']);
    }

    public function update(Request $request)
    {
        $transaction = $this->find($request->transaction);
        if ($transaction){
            $data = $request->only(['name', 'quantity', 'status', 'notes', 'category_id', 'date']);

            $data['quantity'] = floatval($data['quantity']);
            $data['quantity'] *= 100;
            $data['quantity'] = intval($data['quantity']);
            $data['date'] = new DateTime($data['date']);

            $transaction->update($data);
            
            $balanceUpdateValues = app()->make('App\Http\Controllers\BalanceController');
            $balanceUpdateValues->store($transaction->balance->first());

            return redirect()->route('transactions.index');
        }

        return redirect(request()->session()->get('_previous')['url']);
    }

    public function destroy(int $id)
    {
        $transaction = $this->find($id);
        if ($transaction){
            $balance = $transaction->balance->first();
            $transaction->delete();

            $balanceUpdateValues = app()->make('App\Http\Controllers\BalanceController');
            $balanceUpdateValues->store($balance);
        } 

        return redirect()->route('transactions.index');
    }
}
