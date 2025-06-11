<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RainData;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RainDataController extends Controller
{


    public function store(Request $request)
    {
        $data = $request->validate([
            'device_id' => 'required',
            'volume' => 'required',
        ]);

        RainData::create([
            'device_id' => $data['device_id'],
            'amount' => $data['volume'],
            'recorded_at' => now(),
        ]);

        return response()->json(['message' => 'Data stored successfully']);
    }

    public function allData()
    {
        $data = RainData::all();

        $chartData = $data->groupBy('device_id')->map(function ($group) {
            return $group->sum('amount');
        });

        return view('rain.all', ['chartData' => $chartData]);
    }


    public function filteredData(Request $request)
    {
        $filter = $request->query('filter', 'daily');
        $now = now();
        $data = collect();

        if ($filter === 'daily') {
            // Start and end of this week (set to midnight for exact date matching)
            $start = (clone $now)->startOfWeek()->startOfDay();
            $end = (clone $now)->endOfWeek()->endOfDay();


            Log::info('Start of week: ' . $start);
            Log::info('End of week: ' . $end);

            // Get the days of the week
            $days = collect(Carbon::getDays())->map(fn($day) => ucfirst($day));
            Log::info('Days of the week: ' . $days);
            // Fetch records within this week
            $records = RainData::whereBetween('created_at', [$start, $end])->get();
            Log::info('Fetched records: ' . $records);
            // Group records by day of the week
            $grouped = $records->groupBy(fn($r) => Carbon::parse($r->created_at)->format('l'));

            // Format the data for the chart
            $data = $days->mapWithKeys(fn($day) => [
                $day => $grouped->has($day) ? $grouped[$day]->sum('amount') : 0
            ]);
        } elseif ($filter === 'monthly') {
            $start = (clone $now)->startOfMonth()->startOfDay();
            $end = (clone $now)->endOfMonth()->endOfDay();
            $daysInMonth = range(1, $now->daysInMonth);

            // Fetch records within the month
            $records = RainData::whereBetween('created_at', [$start, $end])->get();

            // Group records by day of the month
            $grouped = $records->groupBy(fn($r) => Carbon::parse($r->created_at)->format('d'));

            // Format the data for the chart
            $data = collect($daysInMonth)->mapWithKeys(function ($day) use ($grouped) {
                $key = str_pad($day, 2, '0', STR_PAD_LEFT); // Ensure '01', '02', etc.
                return [$key => $grouped->has($key) ? $grouped[$key]->sum('amount') : 0];
            });
        } elseif ($filter === 'yearly') {
            $start = (clone $now)->startOfYear()->startOfDay();
            $end = (clone $now)->endOfYear()->endOfDay();
            $months = collect(range(1, 12))->map(fn($m) => Carbon::create()->month($m)->format('F'));

            // Fetch records within the year
            $records = RainData::whereBetween('created_at', [$start, $end])->get();

            // Group records by month
            $grouped = $records->groupBy(fn($r) => Carbon::parse($r->created_at)->format('F'));

            // Format the data for the chart
            $data = $months->mapWithKeys(fn($month) => [
                $month => $grouped->has($month) ? $grouped[$month]->sum('amount') : 0
            ]);
        }

        // Calculate summary data
        $summary = [
            'total_rain' => $data->sum(),
            'rain_days' => $data->filter(fn($v) => $v > 0)->count(),
            'average_rain' => $data->sum(),
        ];

        // Pass data to the view
        return view('rain.filtered', [
            'data' => $data,
            'summary' => $summary,
            'filter' => $filter,
        ]);
    }



    public function chartData()
    {
        $data = RainData::all()
            ->groupBy('device_id')
            ->map(function ($group) {
                return $group->sum('amount');
            });

        return response()->json($data);
    }
}
