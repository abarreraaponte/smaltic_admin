<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Artist;
use App\Models\Service;
use App\Models\Job;
use App\Models\JobLine;
use App\Models\PaymentMethod;
use App\Models\Account;
use App\Models\Reward;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Job::orderBy('id', 'desc')->get();
        $customers = Customer::active()->get();

        return view('web.jobs.index', compact('jobs', 'customers'));
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
            'service_id' => 'required|integer',
            'artist_id' => 'required|integer',
            'details' => 'nullable|string|max:255',
            'amount' => 'required|integer',
            'has_reward' => 'nullable|integer',
        ]);

        if($request->get('service_id_2') != null)
        {
            $request->validate([
                'service_id_2' => 'required|integer',
                'artist_id_2' => 'required|integer',
                'amount_2' => 'required|integer',
            ]);
        }

        $job = new Job;
        $job->customer_id = $request->get('customer_id');
        $job->date = $request->get('date');
        $job->details = $request->get('details');
        $job->save();

        $jl = new JobLine;
        $jl->job_id = $job->id;
        $jl->service_id = $request->get('service_id');
        $jl->artist_id = $request->get('artist_id');
        $jl->amount = $request->get('amount');
        $jl->save();

        if($request->get('service_id_2') != null)
        {
            $jl2 = new JobLine;
            $jl2->job_id = $job->id;
            $jl2->service_id = $request->get('service_id_2');
            $jl2->artist_id = $request->get('artist_id_2');
            $jl2->amount = $request->get('amount_2');
            $jl2->save();
        }

        if($request->get('has_reward') === '1')
        {
            $reward = new Reward;
            $reward->job_id = $job->id;
            $reward->customer_id = $job->customer_id;
            $reward->value = $job->getAmount() * (config('app.reward_rate') / 100);
            $reward->save();
        }

        return redirect('/web/jobs/' . $job->getRouteKey())->with('success', __('El trabajo ha sido registrado exitosamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        $job->load(['payments']);
        $accounts = Account::active()->where('is_reward', '<>', '1')->get();
        $payments = $job->payments;
        $points = $job->customer->rewards->pluck('value')->sum();
        $payment_methods = PaymentMethod::where('is_reward', 0)->get();
        $rpm = PaymentMethod::where('is_reward', '1')->first();
        $first_line = $job->job_lines->first();
        if($job->job_lines->count() > 1)
        {
            $last_line = $job->job_lines->last();
        }

        else
        {
            $last_line = null;
        }
        

        return view('web.jobs.view', compact('job', 'accounts', 'first_line', 'last_line', 'payments', 'points', 'payment_methods', 'rpm'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        $job->load(['payments']);
        $artists = Artist::active()->get();
        $services = Service::active()->get();
        $first_line = $job->job_lines->first();
        if($job->job_lines->count() > 1)
        {
            $last_line = $job->job_lines->last();
        }

        else
        {
            $last_line = null;
        }

        return view('web.jobs.edit', compact('job', 'artists', 'services', 'first_line', 'last_line'));
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
            'date' => 'required|date',
            'service_id' => 'required|integer',
            'artist_id' => 'required|integer',
            'details' => 'nullable|string|max:255',
            'amount' => 'required|integer',
        ]);

        if($request->get('service_id_2') != null)
        {
            $request->validate([
                'service_id_2' => 'required|integer',
                'artist_id_2' => 'required|integer',
                'amount_2' => 'required|integer',
                'delete_last_line' => 'nullable|integer',
            ]);
        }

        $job->date = $request->get('date');
        $job->details = $request->get('details');
        $job->save();

        $jl = $job->job_lines->first();
        $jl->service_id = $request->get('service_id');
        $jl->artist_id = $request->get('artist_id');
        $jl->amount = $request->get('amount');
        $jl->save();

        if($request->get('service_id_2') != null)
        {
            if($job->job_lines->count() === 1)
            {
                $jl2 = new JobLine;
                $jl2->job_id = $job->id;
                $jl2->service_id = $request->get('service_id_2');
                $jl2->artist_id = $request->get('artist_id_2');
                $jl2->amount = $request->get('amount_2');
                $jl2->save();
            }

            elseif($job->job_lines->count() > 1) 
            {
                if($request->get('delete_last_line') === '1')
                {
                    $jl2 = $job->job_lines->last();
                    $jl2->delete();
                }

                else {
                    $jl2 = $job->job_lines->last();
                    $jl2->service_id = $request->get('service_id_2');
                    $jl2->artist_id = $request->get('artist_id_2');
                    $jl2->amount = $request->get('amount_2');
                    $jl2->save();
                }
            }
        }

        if($job->reward != null)
        {
            $reward = $job->reward;
            $reward->value = $job->getAmount() * (config('app.reward_rate') / 100);
            $reward->save(); 
        }

        return redirect('/web/jobs/' . $job->getRouteKey())->with('success', __('El trabajo ha sido actualizado exitosamente'));
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
            if($job->reward != null)
            {
                $job->reward->delete();
            }

            foreach($job->job_lines as $job_line)
            {
                $job_line->delete();
            }

            $job->delete();
            return redirect('/web/jobs')->with('success', __('La cita ha sido eliminada exitosamente'));
        }

        else
        {
            return back()->with('errors', __('Esta cita no puede ser eliminado, intente eliminar los pagos primero')); 
        }
    }
}
