<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Vehicle;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class QueryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $months = $this->months();

        $vehicles = Vehicle::query()->latest()->get();

        $dates = [];

        if ($request->filled(['year', 'month', 'vehicle_id'])) {
            $dates = $this->fetchReservationDates($request);
        }

        $description = $this->description($request);

        return view('query', compact('months', 'vehicles', 'dates', 'description'));
    }

    /**
     * Get a months list.
     *
     * @return array
     */
    public function months()
    {
        return [
            1 => __('January'),
            2 => __('February'),
            3 => __('March'),
            4 => __('April'),
            5 => __('May'),
            6 => __('June'),
            7 => __('July'),
            8 => __('August'),
            9 => __('September'),
            10 => __('October'),
            11 => __('November'),
            12 => __('December')
        ];
    }

    /**
     * Fetch reservation dates list based on request.
     *
     * @param \Illuminate\Http\Request  $request
     * @return array
     */
    public function fetchReservationDates($request)
    {
        [$year, $month, $vehicleId] = [
            $request->query('year'),
            $request->query('month'),
            $request->query('vehicle_id'),
        ];

        $period = Carbon::create($year, $month);

        $start = $period->startOfMonth()->toDateString();
        $end = $period->endOfMonth()->toDateString();

        $reservations = Reservation::query()
            ->with(['vehicle', 'user'])
            ->where('date', '>=', $start)
            ->where('date', '<=', $end)
            ->where('vehicle_id', $vehicleId)
            ->get();

        return $this->buildPeriodReservations($reservations, $start, $end);
    }

    /**
     * Build period reservations dates list.
     *
     * @param \Illuminate\Database\Eloquent\Collection $reservations
     * @param string $start
     * @param string $end
     * @return array
     */
    public function buildPeriodReservations(Collection $reservations, $start, $end)
    {
        $range = CarbonPeriod::create($start, $end);

        $dates = [];

        foreach ($range as $date) {

            $reservation = $reservations->filter(function ($reservation) use ($date) {
                return $reservation->date == $date->format('Y-m-d');
            })->first();

            array_push($dates, [
                'date' => $date->format('Y-m-d'),
                'date_formated' => $date->format('d/m/Y'),
                'reservation' => $reservation,
            ]);
        }

        return $dates;
    }

    /**
     * Get a description for vehicle query.
     *
     * @param \Illuminate\Http\Request  $request
     * @return string
     */
    public function description(Request $request)
    {
        $vehicle = Vehicle::find($request->query('vehicle_id'));

        if (!$vehicle) {
            return __("Query");
        }

        return __("Query for: :vehicle - :month/:year", [
            'vehicle' => $vehicle->description,
            'month' => $request->query('month'),
            'year' => $request->query('year'),
        ]);
    }
}
