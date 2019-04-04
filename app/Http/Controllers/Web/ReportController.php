<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Artist;

class ReportController extends Controller
{
    public function index()
    {
        $artists = Artist::all();
        return view('web.reports.index', compact('artists'));
    }

    public function customers(Request $request)
    {
        $request->validate([
            'active' => 'integer|nullable',
            'artists' => 'nullable|array|min:1',
            'artists.*' => 'integer',
            'date_created' => 'date|nullable',
        ]);

        $artists = $request->get('artists');
        $active = $request->get('active');

        $customers = Customer::when($active, function ($query, $active){
                return $query->where('active', $active);
            })
            ->when($artists, function ($query, $artists) {
                return $query->whereIn('artist_id', $artists);
            })->get();

        return view('web.reports.customers', compact('customers'));

    }
}
