<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Artist;
use App\Models\Service;
use App\Models\Job;
use App\Models\JobLine;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Job::all();

        return view('web.jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer)
    {
        $artists = Artist::active()->get();
        $services = Service::active()->get();

        return view('web.jobs.create', compact([
            'artists',
            'services',
            'customer',
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer',
            'date' => 'required|date',
            'hour' => 'string|nullable|max:20',
            'service_id' => 'required|array|min:1',
            'service_id.*' => 'required|integer',
            'artist_id' => 'required|array|min:1',
            'artist_id.*' => 'required|integer',
            'details' => 'required|array|min:1',
            'details.*' => 'nullable|string|max:100',
            'amount' => 'required|array|min:1',
            'amount.*' => 'required|integer',
        ]);

        $job = new Job;
        $job->customer_id = $request->get('customer_id');
        $job->date = $request->get('date');
        $job->hour = $request->get('hour');
        $job->save();

        $service = $request->get('service_id');
        $artist = $request->get('artist_id');
        $details = $request->get('details');
        $amount = $request->get('amount');

        foreach($request->get('service_id') as $key => $sv)
        {
            $job_line = new JobLine;
            $job_line->job_id = $job->id;
            $job_line->service_id = $service[$key];
            $job_line->artist_id = $artist[$key];
            $job_line->details = $details[$key];
            $job_line->amount = $amount[$key];
            $job_line->save();
        }

        return redirect('/web/jobs/' . $job->getRouteKey())->with('success', __('La cita ha sido creada exitosamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        $job->load(['job_lines', 'payments']);

        return view('web.jobs.view', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        $customers = Customer::active()->get();

        $job->load(['job_lines', 'payments']);

        return view('web.jobs.edit', compact('job', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        $request->validate([
            'customer_id' => 'required|integer',
            'date' => 'required|date',
            'hour' => 'string|nullable|max:20',
        ]);

        $job->customer_id = $request->get('customer_id');
        $job->date = $request->get('date');
        $job->hour = $request->get('hour');
        $job->save();

        return redirect('/web/jobs/' . $job->getRouteKey())->with('success', __('La cita ha sido creada exitosamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        if($job->canBeDeleted() === true)
        {
            $job->delete();
            return redirect('/web/jobs')->with('success', __('La cita ha sido eliminada exitosamente'));
        }

        else
        {
            return back()->with('errors', __('Esta cita no puede ser eliminado, intente eliminar los pagos primero')); 
        }
    }
}
