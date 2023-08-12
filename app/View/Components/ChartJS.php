<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Type;
use Closure;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ChartJS extends Component
{
    public $type;
    public $labels;
    public function __construct($transactions, $category, array $sinceUntil)
    {
        $this->type = __('transactions.types.'.($category[0]->type_id == 1 ? 'entrance' : ($category[0]->type_id == 2 ? 'spend' : 'saving')));

        $labels = array(
            'name' => array(),
            'data' => array(
                'transactions' => array(),
                'color' => array()
            )
        );

        foreach($category as $categoryElement){
            $labels['name'][] = $categoryElement->name;
            $labels['data']['transactions'][] = 0;
            $labels['data']['color'][] = $categoryElement->color;
        }

        foreach($transactions as $transaction){
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
