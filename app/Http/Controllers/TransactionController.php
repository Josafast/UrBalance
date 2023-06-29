<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $main = $request->session()->get('main');
        $request->session()->put('main', $main);

        return view('transactions');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($transactions, $queries)
    {
        if (count($queries) >= 1){
            if ($queries['type'] != '') {
                $type = $queries['type'];
                $transactions = $transactions->filter(function ($transaction) use ($type) {
                    return $transaction->category->type_id == $type;
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
                    $queries['base'] == null ? '0' : $queries['base'],
                    $queries['limit'] == null ? '100000000000000000000000' : $queries['limit']
                ];
                $transactions = $transactions->filter(function ($transaction) use ($baseLimit) {
                    return $transaction->quantity >= $baseLimit[0] && $transaction->quantity <= $baseLimit[1];
                });
            }
    
            if ($queries['since'] != '' || $queries['until'] != ''){
                $sinceUntil = [
                    $queries['since'] == null ? date_modify(new DateTime(), '-10 days') : new DateTime($queries['since']),
                    $queries['until'] == null ? new DateTime() : new DateTime($queries['until'])
                ];
                $transactions = $transactions->filter(function ($transaction) use ($sinceUntil) {
                    return new DateTime($transaction->created_at) >= $sinceUntil[0] && new DateTime($transaction->created_at) <= $sinceUntil[1];
                });
            }
        }
        return $transactions;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
