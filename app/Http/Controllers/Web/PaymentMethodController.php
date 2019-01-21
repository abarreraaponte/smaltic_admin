<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_methods = PaymentMethod::active()->orderBy('created_at', 'desc')->get();

        return view('web.payment-methods.index', compact('payment_methods'));
    }


    public function inactives()
    {
        $payment_methods = PaymentMethod::inactive()->orderBy('created_at', 'desc')->get();

        return view('web.payment-methods.inactives', compact('payment_methods'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.payment-methods.create');
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
            'name' => 'string|required|max:100',
            'for_income' => 'required|integer',
            'for_expense' => 'required|integer',
        ]);

        $payment_method = new PaymentMethod;
        $payment_method->name = $request->get('name');
        $payment_method->for_income = $request->get('for_income');
        $payment_method->for_expense = $request->get('for_expense');
        $payment_method->save();

        return redirect('/web/payment-methods/' . $payment_method->getRouteKey())->with('success', __('El medio de Pago ha sido creado exitosamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethod $payment_method)
    {
        return view('web.payment-methods.view', compact('payment_method'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $payment_method)
    {
        return view('web.payment-methods.edit', compact('payment_method'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentMethod $payment_method)
    {
        $request->validate([
            'name' => 'string|required|max:100',
            'for_income' => 'required|integer',
            'for_expense' => 'required|integer',
        ]);

        $payment_method->name = $request->get('name');
        $payment_method->for_income = $request->get('for_income');
        $payment_method->for_expense = $request->get('for_expense');
        $payment_method->save();

        return redirect('/web/payment-methods/' . $payment_method->getRouteKey())->with('success', __('El medio de Pago ha sido actualizado exitosamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $payment_method)
    {
        if($payment_method->canBeDeleted() === true)
        {
            $payment_method->delete();
            return redirect('/web/payment-methods')->with('success', __('El medio de pago ha sido eliminado exitosamente'));
        }

        else 
        {
            return back()->with('errors', __('Este medio de pago no puede ser eliminado, intente desactivarlo'));
        }
    }

    public function inactivate(PaymentMethod $payment_method)
    {
        $payment_method->inactivate();

        return redirect('/web/payment-methods')->with('success', __('El medio de pago ha sido desactivado exitosamente'));
    }


    public function reactivate(PaymentMethod $payment_method)
    {
        $payment_method->reactivate();

        return redirect('/web/payment-methods/' . $payment_method->getRouteKey())->with('success', __('El medio de pago ha sido reactivado  exitosamente'));
    }
}
