<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transfer;
use App\Models\Account;
use App\Models\Payment;
use App\Models\ExpensePayment;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transfers = Transfer::orderBy('date', 'desc')->get();
        return view('web.transfers.index', compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = Account::active()->where('is_reward', 0)->get();
        return view('web.transfers.create', compact('accounts'));
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
            'origin_account_id' => 'required|required',
            'end_account_id' => 'required|required',
            'date' => 'date|required',
            'description' => 'nullable|string|max:255',
            'reference' => 'nullable|string|max:255',
            'amount' => 'required|integer',
        ]);

        $transfer = new Transfer;
        $transfer->origin_account_id = $request->get('origin_account_id');
        $transfer->end_account_id = $request->get('end_account_id');
        $transfer->date = $request->get('date');
        $transfer->description = $request->get('description');
        $transfer->reference = $request->get('reference');
        $transfer->amount = $request->get('amount');
        $transfer->save();

        $ep = new Payment;
        $ep->account_id = $transfer->origin_account_id;
        $ep->transfer_id = $transfer->id;
        $ep->date = $transfer->date;
        $ep->amount = -1 * $transfer->amount;
        $ep->reference = $transfer->reference;
        $ep->save();

        $payment = new Payment;
        $payment->account_id = $transfer->end_account_id;
        $payment->transfer_id = $transfer->id;
        $payment->date = $transfer->date;
        $payment->amount = $transfer->amount;
        $payment->reference = $transfer->reference;
        $payment->save();

        return redirect('/web/transfers')->with('success', 'La transferencia ha sido creada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transfer $transfer)
    {
        foreach ($transfer->payments as $payment)
        {
            $payment->delete();
        }

        $transfer->delete();

        return redirect('/web/transfers')->with('success', 'La transferencia ha sido eliminada exitosamente');
    }
}
