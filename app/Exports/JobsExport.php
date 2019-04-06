<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\JobLine;

class JobsExport implements FromView
{
    use Exportable;

    public function __construct(Request $request)
    {
        $request->validate([
            'date_from' => 'date|nullable',
            'date_until' => 'date|nullable',
            'artists' => 'nullable|array|min:1',
            'artists.*' => 'integer',
            'services' => 'nullable|array|min:1',
            'services.*' => 'integer',
            'payment_statuses' => 'nullable|array|min:1',
            'payment_statuses.*' => 'string',
        ]);

        $this->data = $request;
    }

    public function view(): View
    {
        $artists = $this->data->artists;
        $services = $this->data->services;
        $date_from = $this->data->date_from;
        $date_until = $this->data->date_until;
        $payment_statuses = $this->data->payment_statuses;

        $job_lines = JobLine::with('job', 'artist', 'service')
            ->when($date_from, function ($query, $date_from) {
                return $query->whereHas('job', function ($query) use ($date_from) {
                    $query->whereDate('date', '>=', $date_from);
                });
            })
            ->when($date_until, function ($query, $date_until) {
                return $query->whereHas('job', function ($query) use ($date_until) {
                    $query->whereDate('date', '<=', $date_until);
                });
            })
            ->when($payment_statuses, function ($query, $payment_statuses) {
                return $query->whereHas('job', function ($query) use ($payment_statuses) {
                    $query->whereIn('payment_status', $payment_statuses);
                });
            })
            ->when($artists, function ($query, $artists) {
                return $query->whereIn('artist_id', $artists);
            })
            ->when($services, function ($query, $services) {
                return $query->whereIn('service_id', $services);
            })
            ->orderBy('id', 'asc')->get();

        $customers = Customer::all();
        $amount_sum = $job_lines->pluck('amount')->sum();

        return view('web.reports.jobs-table', compact('job_lines', 'customers', 'date_from', 'date_until', 'amount_sum'));
    }
}