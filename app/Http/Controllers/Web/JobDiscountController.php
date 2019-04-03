<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Discount;

class JobDiscountController extends Controller
{
    public function apply(Request $request, Job $job)
    {
        $request->validate([
            'applieddiscount' => 'nullable|array|min:1',
            'applieddiscount.*' => 'integer|max:10',
        ]);

        $applied_discounts = array_merge($request->get('applieddiscount'));
        $discounts = Discount::unapplied()->whereIn('id', $applied_discounts)->get();

        foreach($discounts as $discount)
        {
            $discount->job_id = $job->id;
            $discount->save();
        }

        return redirect('/web/jobs/' . $job->getRouteKey())->with('success', 'El descuento ha sido aplicado exitosamente');

    }
}
