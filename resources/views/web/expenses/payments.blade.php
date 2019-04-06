<div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mt-4">
                <div class="card-header"><a class="h5">Pagos de Este Gasto</a></div>
                <div class="card-body">
                    <div class="table-responsive table-hover">
                        <table id="main_table" class="table table-sm table-bordered table-striped">
                            <thead class="thead-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Cuenta</th>
                                <th>Medio de Pago</th>
                                <th>Referencia</th>
                                <th>Monto Total</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($expense_payments as $expense_payment)
                                <tr>
                                    <td>{{ $expense_payment->date }}</td>
                                    <td>{{ $expense_payment->account->name }}</td>
                                    <td>{{ $expense_payment->payment_method->name }}</td>
                                    <td>{{ $expense_payment->reference }}</td>
                                    <td>{{ -1 * $expense_payment->amount }}</td>
                                    <td><button type="button" data-toggle="modal" data-target="{{ '#editpayment' . $expense_payment->getRouteKey() }}"  class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> {{ __('Editar Pago') }}</button>
                                        <a class="btn btn-sm btn-danger" href="#" onclick='{{ 'deletepayment' . $expense_payment->id . '()' }}'><i class="fas fa-trash-alt"></i></a>
                                        <form id="{{ 'delete-payment' . $expense_payment->getRouteKey() }}" method="post" action="{{ '/web/expenses/' . $expense->getRouteKey() . '/payment/' . $expense_payment->getRouteKey() . '/delete' }}">
                                            <input name="_method" type="hidden" value="DELETE">
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
    </div>

<!--Create Payment Modal-->
<div class="modal fade" id="addpayment" role="dialog" tabindex="-1" aria-labelledby="addpayment" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <a class="h5 modal-title" id="contactmodallabel">Nuevo Pago</a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ '/web/expenses/' . $expense->getRouteKey() . '/payment/create' }}">
                    @csrf
                    <label class="mt-3"><a class="text-danger">*</a> Fecha de Pago</label>
                    <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}" required>

                    <label class="mt-3"><a class="text-danger">*</a> Medio de Pago</label>
                    <select class="form-control" id="payment_method_id" name="payment_method_id" required>
                            <option value="">{{ __('Seleccionar') }}</option>
                        @foreach($payment_methods as $payment_method)
                            <option value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>
                        @endforeach
                    </select>

                    <label class="mt-3"><a class="text-danger">*</a> Cuenta</label>
                    <select class="form-control" id="account_id" name="account_id" required>
                            <option value="">{{ __('Seleccionar') }}</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>

                    <label class="mt-3">Referencia <small class="text-muted">(Opcional)</small></label>
                    <input type="text" class="form-control" name="reference" value="">

                    <label class="mt-3"><a class="text-danger">*</a> Monto del Pago</label>
                    <input type="number" class="form-control" name="amount" value="{{ $expense->getPendingAmount() }}" min="0" max="{{ $expense->getPendingAmount() }}" step="100" required>

                    <button type="submit" class="btn btn-success btn-block mt-3"><i class="fas fa-plus-circle"></i> Guardar Pago</button>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach($expense_payments as $expense_payment)

<!-- Edit Payment Modal -->
<div class="modal fade" id="{{ 'editpayment' . $expense_payment->getRouteKey() }}" role="dialog" tabindex="-1" aria-labelledby="editpayment" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <a class="h5 modal-title" id="contactmodallabel">Editar Pago</a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ '/web/expenses/' . $expense->getRouteKey() . '/payment/' . $expense_payment->getRouteKey() . '/edit' }}">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf

                    <label class="mt-3"><a class="text-danger">*</a> Fecha de Pago</label>
                    <input type="date" class="form-control" name="date" value="{{ $expense_payment->date }}" required>

                    <label class="mt-3"><a class="text-danger">*</a> Medio de Pago</label>
                    <select class="form-control" id="artist_id" name="payment_method_id" required>
                            <option value="">{{ __('Seleccionar') }}</option>
                        @foreach($payment_methods as $payment_method)
                            <option value="{{ $payment_method->id }}" @if($payment_method->id === $expense_payment->payment_method_id) selected @endif>{{ $payment_method->name }}</option>
                        @endforeach
                    </select>

                    <label class="mt-3"><a class="text-danger">*</a> Cuenta</label>
                    <select class="form-control" id="account_id" name="account_id" required>
                            <option value="">{{ __('Seleccionar') }}</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" @if($account->id === $expense_payment->account_id) selected @endif>{{ $account->name }}</option>
                        @endforeach
                    </select>

                    <label class="mt-3">Referencia <small class="text-muted">(Opcional)</small></label>
                    <input type="text" class="form-control" name="reference" value="{{ $expense_payment->reference }}">

                    <label class="mt-3"><a class="text-danger">*</a> Monto del Pago</label>
                    <input type="number" class="form-control" name="amount" value="{{ $expense_payment->amount }}" min="0" step="100" max="{{ $expense_payment->amount + $expense->getPendingAmount() }}" required>

                    <button type="submit" class="btn btn-success btn-block mt-3"><i class="fas fa-plus-circle"></i> Guardar Pago</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endforeach