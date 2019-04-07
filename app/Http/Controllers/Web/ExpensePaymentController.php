<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Expense;

class ExpensePaymentController extends Controller
{
    public function add(Request $request, Expense $expense)
    {
        request()->validate([
            'date' => 'date|required',
            'payment_method_id' => 'integer|required',
            'account_id' => 'integer|nullable',
            'amount' => 'integer|required',
            'reference' => 'nullable|string|max:100',
        ]);

        $expense_payment = new Payment;
        $expense_payment->date = $request->get('date');
        $expense_payment->expense_id = $expense->id;
        $expense_payment->account_id = $request->get('account_id');
        $expense_payment->payment_method_id = $request->get('payment_method_id');
        $expense_payment->reference = $request->get('reference');
        $expense_payment->amount = -1 * $request->get('amount');
        $expense_payment->save();

        $expense->updatePaymentStatus();

        return redirect('/web/expenses/' . $expense->getRouteKey())->with('success', 'El pago ha sido registrado exitosamente');

    }

    public function edit(Request $request, Expense $expense, Payment $expense_payment)
    {
        request()->validate([
            'date' => 'date|required',
            'payment_method_id' => 'integer|required',
            'account_id' => 'integer|nullable',
            'amount' => 'integer|required',
            'reference' => 'nullable|string|max:100',
        ]);

        $expense_payment->date = $request->get('date');
        $expense_payment->account_id = $request->get('account_id');
        $expense_payment->payment_method_id = $request->get('payment_method_id');
        $expense_payment->reference = $request->get('reference');
        $expense_payment->amount = -1 * $request->get('amount');
        $expense_payment->save();

        $expense->updatePaymentStatus();

        return redirect('/web/expenses/' . $expense->getRouteKey())->with('success', 'El pago ha sido editado exitosamente');

    }

    public function delete(Request $request, Expense $expense, Payment $expense_payment)
    {
        $expense_payment->delete();

        $expense->updatePaymentStatus();

        return redirect('/web/expenses/' . $expense->getRouteKey())->with('success', 'El pago ha sido eliminado exitosamente');
    }
}
