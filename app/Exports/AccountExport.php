<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Payment;

class AccountExport implements FromView
{
    use Exportable;

    public function __construct(Request $request)
    {
        $request->validate([
            'date_from' => 'date|nullable',
            'date_until' => 'date|nullable',
            'account_id' => 'required|integer'
        ]);

        $this->data = $request;
    }

    public function view(): View
    {
        $date_from = $this->data->date_from;
        $date_until = $this->data->date_until;
        $account = Account::where('id', $this->data->account_id)->first();

        $payments = Payment::with('job', 'customer', 'transfer', 'expense')
            ->when($date_from, function ($query, $date_from) {
                return $query->whereDate('date', '>=', $date_from);
            })
            ->when($date_until, function ($query, $date_until) {
                return $query->whereDate('date', '<=', $date_until);
            })
            ->where('account_id', $account->id)->orderBy('date', 'desc')->get();

        $amount_sum = $payments->pluck('amount')->sum();

        return view('web.reports.accounts-table', compact('payments', 'date_from', 'date_until', 'amount_sum', 'account'));
    }
}