<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;
use App\Models\ExpenseLine;

class ExpensesExport implements FromView
{
    use Exportable;

    public function __construct(Request $request)
    {
        $request->validate([
            'date_from' => 'date|nullable',
            'date_until' => 'date|nullable',
            'categories' => 'nullable|array|min:1',
            'categories.*' => 'integer',
            'payment_statuses' => 'nullable|array|min:1',
            'payment_statuses.*' => 'string',
        ]);

        $this->data = $request;
    }

    public function view(): View
    {
        $categories = $this->data->categories;
        $date_from = $this->data->date_from;
        $date_until = $this->data->date_until;
        $payment_statuses = $this->data->payment_statuses;

        $expense_lines = ExpenseLine::with('expense', 'expense_category')
            ->when($date_from, function ($query, $date_from) {
                return $query->whereHas('expense', function ($query) use ($date_from) {
                    $query->whereDate('date', '>=', $date_from);
                });
            })
            ->when($date_until, function ($query, $date_until) {
                return $query->whereHas('expense', function ($query) use ($date_until) {
                    $query->whereDate('date', '<=', $date_until);
                });
            })
            ->when($payment_statuses, function ($query, $payment_statuses) {
                return $query->whereHas('expense', function ($query) use ($payment_statuses) {
                    $query->whereIn('payment_status', $payment_statuses);
                });
            })
            ->when($categories, function ($query, $categories) {
                return $query->whereIn('expense_category_id', $categories);
            })
            ->orderBy('id', 'asc')->get();

        $amount_sum = $expense_lines->pluck('amount')->sum();

        return view('web.reports.expenses-table', compact('expense_lines','date_from', 'date_until', 'amount_sum'));
    }
}