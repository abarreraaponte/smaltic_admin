<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Payment;
use App\Models\PaymentMethod;

class JobPaymentController extends Controller
{
    public function add(Request $request, Job $job)
    {
        request()->validate([
            'is_downpayment' => 'required|integer',
            'date' => 'date|required',
            'payment_method_id' => 'integer|required',
            'account_id' => 'integer|required',
            'amount' => 'integer|required',
            'is_reward' => 'nullable|integer',
            'reference' => 'nullable|string|max:100',
        ]);

        $points = $job->customer->rewards->pluck('value')->sum();

        if($request->get('is_reward') === '1')
        {
            if($request->get('amount') > $job->getPendingAmount() or $request->get('amount') > $points)
            {
                return back()->with('error', 'El monto del pago/puntos es inválido');
            }
        }

        $payment = new Payment;
        $payment->is_downpayment = $request->get('is_downpayment');
        $payment->date = $request->get('date');
        $payment->job_id = $job->id;
        $payment->customer_id = $job->customer->id;
        if($request->get('is_reward') != null)
        {
            $payment->is_reward = $request->get('is_reward');
        }
        $payment->payment_method_id = $request->get('payment_method_id');
        $payment->account_id = $request->get('account_id');
        $payment->reference = $request->get('reference');
        $payment->amount = $request->get('amount');
        $payment->save();

        return redirect('/web/jobs/' . $job->getRouteKey())->with('success', 'El pago ha sido registrado exitosamente');

    }

    public function edit(Request $request, Job $job, Payment $payment)
    {
        request()->validate([
            'is_downpayment' => 'required|integer',
            'date' => 'date|required',
            'payment_method_id' => 'integer|required',
            'account_id' => 'integer|required',
            'amount' => 'integer|required',
            'is_reward' => 'nullable|integer',
            'reference' => 'nullable|string|max:100',
        ]);

        $payment->is_downpayment = $request->get('is_downpayment');
        $payment->date = $request->get('date');
        if($request->get('is_reward') != null)
        {
            $payment->is_reward = $request->get('is_reward');
        }
        $payment->payment_method_id = $request->get('payment_method_id');
        $payment->account_id = $request->get('account_id');
        $payment->reference = $request->get('reference');
        $payment->amount = $request->get('amount');
        $payment->save();

        return redirect('/web/jobs/' . $job->getRouteKey())->with('success', 'El pago ha sido editado exitosamente');

    }

    public function delete(Request $request, Job $job, Payment $payment)
    {
        $payment->delete();

        return redirect('/web/jobs/' . $job->getRouteKey())->with('success', 'El pago ha sido eliminado exitosamente');
    }
}
