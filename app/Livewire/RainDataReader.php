<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\RainData; // Make sure your RainData model path is correct
use Carbon\Carbon; // Import Carbon for date manipulation

class RainDataReader extends Component
{
    // Public properties that will be available in the Blade view and bindable via wire:model
    public $rainData = []; // Stores the fetched rain data records
    public $startDate;     // Stores the selected start date for filtering
    public $endDate;       // Stores the selected end date for filtering

    /**
     * Define validation rules for the date inputs.
     * 'nullable' allows the fields to be empty.
     * 'after_or_equal:startDate' ensures the end date is not before the start date.
     */
    protected $rules = [
        'startDate' => 'nullable|date',
        'endDate' => 'nullable|date|after_or_equal:startDate',
    ];

    /**
     * The `mount` method is called once when the component is initialized.
     * It's used here to load the initial set of latest rain data.
     */
    public function mount()
    {
        $this->loadLatestRainData();
    }

    /**
     * Loads the latest 5 rain data records from the database.
     * This method is used for initial load and when resetting the filter.
     */
    public function loadLatestRainData()
    {
        // Fetch the latest 5 records ordered by 'created_at' in descending order
        $this->rainData = RainData::latest('created_at')->take(5)->get();
        // Clear any previously set date filters
        $this->startDate = null;
        $this->endDate = null;
    }

    /**
     * Applies the date range filter based on `startDate` and `endDate`.
     * This method is triggered by the "Apply Filter" button.
     */
    public function applyFilter()
    {
        // Validate the input dates against the defined rules
        $this->validate();

        // Start a new query on the RainData model
        $query = RainData::query();

        // If a start date is provided, add a 'where' clause to filter records
        // from the beginning of that day.
        if ($this->startDate) {
            $query->where('created_at', '>=', Carbon::parse($this->startDate)->startOfDay());
        }

        // If an end date is provided, add a 'where' clause to filter records
        // up to the end of that day.
        if ($this->endDate) {
            $query->where('created_at', '<=', Carbon::parse($this->endDate)->endOfDay());
        }

        // Execute the query and order the results by 'created_at' in descending order
        $this->rainData = $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Resets the date filter and reloads the latest 5 rain data records.
     * This method is triggered by the "Reset Filter" button.
     */
    public function resetFilter()
    {
        $this->loadLatestRainData();
    }

    /**
     * The `render` method returns the Blade view that Livewire will render.
     */
    public function render()
    {
        return view('livewire.rain-data-reader');
    }
}
