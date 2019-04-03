<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Job;
use App\Models\Payment;
use App\Models\Artist;
use App\Models\Discount;
use App\Models\Source;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::active()->orderBy('created_at', 'desc')->get();

        return view('web.customers.index', compact('customers'));
    }


    public function inactives()
    {
        $customers = Customer::inactive()->orderBy('created_at', 'desc')->get();

        return view('web.customers.inactives', compact('customers'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $artists = Artist::active()->get();
        $sources = Source::active()->get();
        $customers = Customer::active()->get();
        $reference_source = $sources->where('is_customer_reference', 1)->pluck('id')->first();
        return view('web.customers.create', compact('artists', 'sources', 'customers', 'reference_source'));
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
            'source_id' => 'integer|nullable',
            'artist_id' => 'integer|nullable',
            'referrer_id' => 'integer|nullable',
            'name' => 'string|required|max:100',
            'instagram' => 'string|nullable|max:100',
            'phone' => 'string|required|max:100',
        ]);

        $customer = new Customer;
        $customer->source_id = $request->get('source_id');
        $customer->artist_id = $request->get('artist_id');
        $customer->name = $request->get('name');
        $customer->instagram = $request->get('instagram');
        $customer->phone = str_replace(['+', '.', '-'], ['', '', ''], $request->get('phone'));
        $customer->save();

        if($request->get('referrer_id') != null)
        {
            $referrer_id = $request->get('referrer_id');
            $referrer = Customer::where('id', $referrer_id)->first();

            $discount = new Discount;
            $discount->customer_id = $referrer->id;
            $discount->amount = config('app.referral_amount');
            $discount->description = 'Premio por haber referido a:' . ' ' . $customer->name;
            $discount->save();

        }

        return redirect('/web/customers/' . $customer->getRouteKey() . '/job/create')->with('success', __('El cliente ha sido creado exitosamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        $customer->load(['jobs']);
        $points = $customer->rewards->pluck('value')->sum();
        $available_discount_amount = $customer->getAvailableDiscountAmount();
        return view('web.customers.view', compact('customer', 'points', 'available_discount_amount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $artists = Artist::active()->get();
        $sources = Source::active()->get();

        return view('web.customers.edit', compact('customer', 'artists', 'sources'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
         $request->validate([
            'source_id' => 'integer|nullable',
            'artist_id' => 'integer|nullable',
            'name' => 'string|required|max:100',
            'instagram' => 'string|nullable|max:100',
            'phone' => 'string|required|max:100',
        ]);

        $customer->source_id = $request->get('source_id');
        $customer->artist_id = $request->get('artist_id');
        $customer->name = $request->get('name');
        $customer->instagram = $request->get('instagram');
        $customer->phone = str_replace(['+', '.', '-'], ['', '', ''], $request->get('phone'));
        $customer->save();

        return redirect('/web/customers/' . $customer->getRouteKey())->with('success', __('El cliente ha sido actualizado exitosamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        if($customer->canBeDeleted() === true)
        {
            $customer->delete();
            return redirect('/web/customers')->with('success', __('El cliente ha sido eliminado exitosamente'));
        }

        else
        {
            return back()->with('errors', ' Este cliente no puede ser eliminado, intente desactivarlo');
        }
    }


    public function inactivate(Customer $customer)
    {
        $customer->inactivate();

        return redirect('/web/customers')->with('success', __('El cliente ha sido desactivado exitosamente'));
    }


    public function reactivate(Customer $customer)
    {
        $customer->reactivate();
        {
            return redirect('/web/customers/' . $customer->getRouteKey())->with('success', __('El Cliente ha sido reactivado exitosamente'));
        }
    }
}
