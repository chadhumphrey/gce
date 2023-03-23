<?php

namespace App\Http\Livewire;
use Livewire\Component;

use App\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\RadarChartModel;
use Asantibanez\LivewireCharts\Models\TreeMapChartModel;

class Chart extends Component
{
  // public $columnChartModel;
  public $buster;
    public function render()
    {
      $columnChartModel =  LivewireCharts::columnChartModel()
      ->setTitle('Expenses by Type')
->addColumn('Food', 100, '#f6ad55')
->addColumn('Shopping', 200, '#fc8181')
->addColumn('Travel', 300, '#90cdf4');
             // ->setTitle('Expenses by Type');
       // ->addColumn('Food', 100, '#f6ad55')
       // ->addColumn('Shopping', 200, '#fc8181')
       // ->addColumn('Travel', 300, '#90cdf4');
        return view('livewire.chart',[            "columnChartModel" => $columnChartModel]);
        // return view('livewire.chart');
    }
}
