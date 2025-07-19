<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RainData;
use Carbon\Carbon;

class RainDataReader extends Component
{
    public $rainData = [];
    public $startDate;
    public $endDate;

    protected $rules = [
        'startDate' => 'nullable|date',
        'endDate' => 'nullable|date|after_or_equal:startDate',
    ];

    public function mount()
    {
        // On initial load, fetch the latest data
        $this->loadData();
    }

    // A single method to load data based on current filters
    public function loadData()
    {
        $query = RainData::query();

        if ($this->startDate) {
            $query->where('recorded_at', '>=', Carbon::parse($this->startDate)->startOfDay());
        }

        if ($this->endDate) {
            $query->where('recorded_at', '<=', Carbon::parse($this->endDate)->endOfDay());
        }

        // If no dates are set, default to latest 5
        if (!$this->startDate && !$this->endDate) {
            $this->rainData = $query->latest('recorded_at')->take(5)->get();
        } else {
            $this->rainData = $query->orderBy('recorded_at', 'desc')->get();
        }
    }

    public function applyFilter()
    {
        $this->validate();
        $this->loadData(); 
    }

    public function resetFilter()
    {
        $this->startDate = null;
        $this->endDate = null;
        $this->loadData(); 
    }

    public function render()
    {
        $this->loadData(); 
        return view('livewire.rain-data-reader');
    }
}