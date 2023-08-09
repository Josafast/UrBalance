<?php

namespace App\View\Components;

use App\Models\Category;
use Closure;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ChartJS extends Component
{
    public $type;
    public $labels;
    public function __construct(string $type, array $sinceUntil)
    {
        $searchINT = $type == 'entrance' ? 1 : ($type == 'spend' ? 2 : 3);
        $queries = [
            'type' => $searchINT,
            'state' => 'true',
            'base' => '',
            'limit' => '',
            'since' => $sinceUntil[0],
            'until' => $sinceUntil[1]
        ]; 
        $this->type = __('transactions.types.'.$type);

        $searchedTransactions = app()->make('App\Http\Controllers\TransactionController')->show($queries);

        $categories = Category::all();

        $categories = $categories->reduce(function ($result, $category) use ($searchINT){
            if ($category->type->id == $searchINT){
                $result[] = $category;
            }
            return $result;
        }, []);

        $labels = array(
            'name' => array(),
            'data' => array(
                'transactions' => array(),
                'color' => array()
            )
        );

        foreach($categories as $category){
            $labels['name'][] = $category->name;
            $labels['data']['transactions'][] = 0;
            $labels['data']['color'][] = $category->color;
        }

        foreach($searchedTransactions as $transaction){
            for($i=0; $i<count($labels['name']); $i++){
                if ($labels['name'][$i] == $transaction->category->name){
                    $labels['data']['transactions'][$i] = $labels['data']['transactions'][$i] + intval($transaction->quantity);
                }
            }
        }

        $this->labels = response()->json($labels);
    }

    public function render(): View|Closure|string
    {
        return view('components.chartjs');
    }
}
