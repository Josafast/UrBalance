<?php
 
namespace App\Http\Controllers;


use App\Models\Balance;
use App\Models\Type;
use DateTime;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function selectMainBalance($balances, $main){
        $mains = "";
        $option = "";
        if ($main == 'yes'){
            $mains = array_column(json_decode($balances), 'main');
            $option = array_search('true', $mains);
        } else {
            $mains = array_column(json_decode($balances), 'exchange_id');
            $option = array_search($main, $mains);
        }

        return $balances[$option];
    }

    public function index($balance, $main)
    {
        $balance = $this->selectMainBalance($balance, $main);

        $sign = $balance->exchange->sign;

        $notDone = Balance::find($balance->id)->transactions->where('status','<>','false');
        $toDo = array(floatval(0),floatval(0));
        foreach($notDone as $nd):
            if ($nd->category->type->id == 2):
            $toDo[0] = $toDo[0] + floatval($nd->quantity);
            else:
            $toDo[1] = $toDo[1] + floatval($nd->quantity);
            endif;
        endforeach;

        $balance = array(
            'total'=>$balance->balance.$sign,
            'saving'=>$balance->saving.$sign,
            'deuda'=>number_format($toDo[0],2).$sign,
            'cobro'=>number_format($toDo[1],2).$sign
        );

        return $balance;
    }

    public function create()
    {
        
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

    public function show($balances, $main, int $type = null, array $sinceUntil = null)
    {
        /*
        $allCategories = Type::find($type)->categories;

        $newCategories = $allCategories->reduce(function ($result, $category) {
            $result[$category->name] = [$category->transactions, $category->color];
            return $result;
        }, []);

        $newerCategories = [];
        
        foreach ($newCategories as $category => $data) {
            $newerCategories[$category] = [
                'transactions' => [],
                'color' => $data[1]
            ];
        
            foreach ($data[0] as $transaction) {
                if ($transaction->status){
                    if ($transaction->balance[0]->main) {
                        $newerCategories[$category]['transactions'][] = $transaction->quantity;
                    }
            
                    if ($transaction->balance[0]->exchange_id == session('main')) {
                        $newerCategories[$category]['transactions'][] = $transaction->quantity;
                    }
                }
            }
        }

        return $newerCategories;
        */

        $balance = $this->selectMainBalance($balances, $main);

        $transactions = $balance->transactions;

        if ($type) {
            $transactions = $transactions->filter(function ($transaction) use ($type) {
                return $transaction->category->type_id == $type;
            });
        }

        if ($sinceUntil){
            $transactions = $transactions->filter(function ($transaction) use ($sinceUntil) {
                return new DateTime($transaction->created_at) >= $sinceUntil[0] && new DateTime($transaction->created_at) <= $sinceUntil[1];
            });
        }

        $transactions = $transactions->filter(function ($transaction){
            return $transaction->status == 'true';
        });

        return $transactions;
    }

    public function edit(string $id)
    {
        
    }

    public function update(Request $request, string $id)
    {
        
    }

    public function destroy(string $id)
    {
        
    }
}
