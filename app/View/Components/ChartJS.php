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
    public $sinceUntil;
    public function __construct(string $type, array $sinceUntil)
    {
        $sinceUntil = [
            $sinceUntil[0] == null ? date_modify(new DateTime(), '-10 days') : new DateTime($sinceUntil[0]),
            $sinceUntil[1] == null ? new DateTime() : new DateTime($sinceUntil[1])
        ];
        $this->sinceUntil = $sinceUntil; 
        $this->type = $type;
        $searchINT = $type == 'entrance' ? 1 : ($type == 'spent' ? 2 : 3);

        $searchedBalance = app()->make('App\Http\Controllers\BalanceController');
        $searchedBalance = $searchedBalance->show(request()->user()->balance, session('main') ,$searchINT, $sinceUntil);

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

        foreach($searchedBalance as $transaction){
            for($i=0; $i<count($labels['name']); $i++){
                if ($labels['name'][$i] == $transaction->category->name){
                    $labels['data']['transactions'][$i] = floatval($labels['data']['transactions'][$i]) + floatval($transaction->quantity);
                }
            }
        }

        $this->labels = response()->json($labels);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.chartjs');
    }
}
