<?php

namespace App\Http\Controllers;

use App\Models\Category;
use DateTime;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected function find(int $id)
    {
        return Transaction::whereHas('balance', function ($query) {
            $query->where('exchange_id', session()->get('main'));
        })->where('id', $id)->first();
    }

    protected function data_formater(Request $request)
    {
        $data = $request->only(['name', 'quantity', 'status', 'notes', 'category_id', 'date']);

        $data['quantity'] = floatval($data['quantity']);
        $data['quantity'] *= 100;
        $data['quantity'] = intval($data['quantity']);
        $data['date'] = new DateTime($data['date']);

        return $data;
    }

    public function notes(Request $request)
    {
        $transaction = Transaction::find($request->id);
        return response()->json(['notes' => parsedown($transaction->notes), 'name' => $transaction->name], 200);
    }

    public function index(Request $request){
        return view('transactions');
    }

    public function create(Request $request){
        return view('transactions-create');
    }

    public function store(Request $request)
    {
        if (Category::find($request->category_id)->type->id == 2){
            $balance = $request->user()->balance->where('exchange_id', $request->session()->get('main'))->first();
            $validSpendFields = $request->category_id == '12' ?
            intval($balance->savgin) :
            intval($balance->balance);
            if (intval($request->quantity)*100 > $validSpendFields){
                return response()->json(['error' => [__('transactions.messages.not_more_than_having')]], 422);
            }
        }

        Transaction::create($this->data_formater($request));

        return response()->json(['link' => route('transactions.index'), 'messages' => ['message' => [__('transactions.messages.created')]], 'status' => 'done'], 200);
    }

    public function show($queries)
    {
        $transactions = request()->user()->balance
                                 ->where('exchange_id', session()->get('main'))
                                 ->first()->transactions->load('category.type');

        return $transactions->when(count($queries) >= 1, function ($collection) use ($queries){
            return $collection
                ->when($queries['type'] != '', 
                    function ($subcollection) use ($queries){
                        return $subcollection->where('category.type_id', $queries['type']);
                    })
                ->when($queries['state'] != '', 
                    function ($subcollection) use ($queries){
                        return $subcollection->where('status', boolval($queries['state']));
                    })
                ->when($queries['base'] != '' || $queries['limit'] != '', 
                    function($subcollection) use ($queries){
                        $baseLimit = [
                            $queries['base'] == null ? '0' : $queries['base']*100,
                            $queries['limit'] == null ? '100000000000000000000000' : $queries['limit']*100
                        ];
                        return $subcollection->whereBetween('quantity', $baseLimit);
                    })
                ->when($queries['since'] != '' || $queries['until'] != '', 
                    function($subcollection) use ($queries){
                        $sinceUntil = [
                            $queries['since'] == null ? date_format(date_modify(new DateTime(), '-10 days'), 'Y-m-d H:i:s') : date_format(new DateTime($queries['since']), 'Y-m-d H:i:s'),
                            $queries['until'] == null ? date_format(new DateTime(), 'Y-m-d H:i:s') : date_format(date_modify(new DateTime($queries['until']), '+1 days'), 'Y-m-d H:i:s')
                        ];
                        return $subcollection->where('date', ">=", $sinceUntil[0])->where('date', "<=", $sinceUntil[1]);
                });
        });
    }

    public function edit(int $id)
    {
        $transaction = $this->find($id);

        if ($transaction) {
            $transaction = $transaction->load('category');
            return view('transactions-create', compact('transaction'));
        }

        return redirect()->route('transactions.index');
    }

    public function update(Request $request)
    {
        $transaction = $this->find($request->id); 

        $transaction->update($this->data_formater($request));

        return response()->json(['link' => route('transactions.index'), 'messages' => ['message' => [__('transactions.messages.modified')]], 'status' => 'edited'], 200);
    }

    public function destroy(int $id)
    {
        $transaction = $this->find($id);
        if ($transaction) {
            $transaction->delete();
            return response()->json(['link' => route('transactions.index'), 'messages' => ['message' => [__('transactions.messages.deleted')]], 'status' => 'deleted'], 200);
        }

        return response()->json(['link' => route('transactions.index'), 'messages' => ['message' => [__('transactions.messages.not_found')]], 'status' => 'what?'], 200);
    }
}
