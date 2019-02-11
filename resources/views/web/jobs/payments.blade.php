<div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mt-4">
                <div class="card-header"><a class="h5">Pagos de Esta Sesión</a></div>
                <div class="card-body">
                    <div class="table-responsive table-hover">
                        <table id="main_table" class="table table-sm table-bordered table-striped">
                            <thead class="thead-light">
                            <tr>
                                <th>Fecha</th>
                                <th>¿Es Abono?</th>
                                <th>Medio de Pago</th>
                                <th>Monto Total</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->date }}</td>
                                    <td>
                                        @if($payment->downpayment === 1)
                                        Si
                                        @else
                                        No
                                        @endif
                                    </td>
                                    <td>{{ $payment->payment_method->name }}</td>
                                    <td>{{ $payment->amount }}</td>
                                    @if($payment->payment_method_id != $rpm->id)
                                        <td><button type="button" data-toggle="modal" data-target="{{ '#editpayment' . $payment->uuid }}"  class="btn btn-sm btn-info bg-gradient-info"><i class="fas fa-edit"></i> {{ __('Editar Pago') }}</button>
                                            <a class="btn btn-sm btn-danger" href="#" onclick='{{ 'deletepayment' . $payment->id . '()' }}'><i class="fas fa-trash-alt"></i></a>
                                            <form id="{{ 'delete-record' . $payment->getRouteKey() }}" method="post" action="{{ '/transactions/' . $job->getRouteKey() . '/payment/' . $payment->getRouteKey() . '/delete' }}">
                                                <input name="_method" type="hidden" value="DELETE">
                                                @csrf
                                            </form>
                                        </td>
                                    @elseif($payment->payment_method_id === $rpm->id)
                                        <td><button type="button" data-toggle="modal" data-target="{{ '#editreward' . $payment->uuid }}"  class="btn btn-sm btn-info bg-gradient-warning"><i class="fas fa-award"></i> {{ __('Editar Uso de Puntos') }}</button>
                                            <a class="btn btn-sm btn-danger" href="#" onclick='{{ 'deletepayment' . $payment->id . '()' }}'><i class="fas fa-trash-alt"></i></a>
                                            <form id="{{ 'delete-record' . $payment->getRouteKey() }}" method="post" action="{{ '/transactions/' . $job->getRouteKey() . '/payment/' . $payment->getRouteKey() . '/delete' }}">
                                                <input name="_method" type="hidden" value="DELETE">
                                                @csrf
                                            </form>
                                        </td>
                                    @endif
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
            <div class="modal-header bg-dark text-white">
                <a class="h5 modal-title" id="contactmodallabel">Nuevo Pago</a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ '/transactions/' . $job->getRouteKey() . '/payment' }}">
                    @csrf
                    <label class="mt-3"><a class="text-danger">*</a>¿Es Abono?</label>
                    <input type="hidden" name="downpayment" value="0">
                    <input type="checkbox" name="downpayment" value="1">

                    <br>

                    <label class="mt-3"><a class="text-danger">*</a> Fecha de Pago</label>
                    <input type="date" class="form-control" name="date" required>

                    <label class="mt-3"><a class="text-danger">*</a> Medio de Pago</label>
                    <select class="form-control" id="artist_id" name="payment_method_id" required>
                            <option value="">{{ __('Seleccionar') }}</option>
                        @foreach($payment_methods as $payment_method)
                            <option value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>
                        @endforeach
                    </select>

                    <label class="mt-3"><a class="text-danger">*</a> Monto del Pago</label>
                    <input type="number" class="form-control" name="amount" value="{{ $job->getPendingAmount() }}" min="0" max="{{ $job->getPendingAmount() }}" step="100" required>

                    <button type="submit" class="btn btn-success btn-block mt-3"><i class="fas fa-plus-circle"></i> Guardar Pago</button>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach($payments as $payment)

@if($payment->payment_method_id != $rpm->id)
<!-- Edit Payment Modal -->
<div class="modal fade" id="{{ 'editpayment' . $payment->uuid }}" role="dialog" tabindex="-1" aria-labelledby="editpayment" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <a class="h5 modal-title" id="contactmodallabel">Editar Pago</a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ '/transactions/' . $job->getRouteKey() . '/payment/' . $payment->getRouteKey() . '/edit' }}">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <label class="mt-3"><a class="text-danger">*</a>¿Es Abono?</label>
                    <input type="hidden" name="downpayment" value="0">
                    <input type="checkbox" @if($payment->downpayment === 1) checked @endif name="downpayment" value="1">

                    <br>

                    <label class="mt-3"><a class="text-danger">*</a> Fecha de Pago</label>
                    <input type="date" class="form-control" name="date" value="{{ $payment->date }}" required>

                    <label class="mt-3"><a class="text-danger">*</a> Medio de Pago</label>
                    <select class="form-control" id="artist_id" name="payment_method_id" required>
                            <option value="">{{ __('Seleccionar') }}</option>
                        @foreach($payment_methods as $payment_method)
                            <option value="{{ $payment_method->id }}" @if($payment_method->id === $payment->payment_method_id) selected @endif>{{ $payment_method->name }}</option>
                        @endforeach
                    </select>

                    <label class="mt-3"><a class="text-danger">*</a> Monto del Pago</label>
                    <input type="number" class="form-control" name="amount" value="{{ $payment->amount }}" min="0" step="100" max="{{ $payment->amount + $job->getPendingAmount() }}" required>

                    <button type="submit" class="btn btn-success btn-block mt-3"><i class="fas fa-plus-circle"></i> Guardar Pago</button>
                </form>
            </div>
        </div>
    </div>
</div>

@elseif($payment->payment_method_id === $rpm->id)
<!-- Edit Payment With Reward Modal -->
<div class="modal fade" id="{{ 'editreward' . $payment->uuid }}" role="dialog" tabindex="-1" aria-labelledby="editpayment" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-warning text-white">
                <a class="h5 modal-title" id="userewardlabel"><i class="fas fa-award"></i> Modificar Pago con Puntos</a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ '/transactions/' . $job->getRouteKey() . '/payment/' . $payment->getRouteKey() . '/edit' }}">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <input type="hidden" name="is_reward" value="1">
                    <input type="hidden" name="downpayment" value="0">
                    <input type="hidden" name="payment_method_id" value="{{ $rpm->id }}">

                    <label class="mt-3"><a class="text-danger">*</a> Fecha de Pago</label>
                    <input type="date" class="form-control" name="date" value="{{ $payment->date }}" required>

                    @if($job->getPendingAmount() < $points)
                        <label class="mt-3"><a class="text-danger">*</a> Puntos a Utilizar (Pesos)</label>
                        <input type="number" class="form-control" name="amount" value="{{ $payment->amount }}" min="0" max="{{ $payment->amount + $job->getPendingAmount() }}" step="100" required>
                    @elseif($job->getPendingAmount() > $points)
                        <label class="mt-3"><a class="text-danger">*</a> Puntos a Utilizar (Pesos)</label>
                        <input type="number" class="form-control" name="amount" value="{{ $payment->amount }}" min="0" max="{{ $payment->amount + $points }}" step="100" required>
                    @endif

                    <button type="submit" class="btn btn-warning btn-block mt-3"><i class="fas fa-plus-circle"></i> Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endif

@endforeach

@if($points >= config('app.reward_baseline'))
<!--Use Reward Modal-->
<div class="modal fade" id="usereward" role="dialog" tabindex="-1" aria-labelledby="usereward" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-warning text-white">
                <a class="h5 modal-title" id="userewardlabel"><i class="fas fa-award"></i> Usar Puntos</a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ '/transactions/' . $job->getRouteKey() . '/payment' }}">
                    @csrf
                    <input type="hidden" name="is_reward" value="1">
                    <input type="hidden" name="downpayment" value="0">
                    <input type="hidden" name="payment_method_id" value="{{ $rpm->id }}">

                    <label class="mt-3"><a class="text-danger">*</a> Fecha de Pago</label>
                    <input type="date" class="form-control" name="date" required>

                    @if($job->getPendingAmount() < $points)
                        <label class="mt-3"><a class="text-danger">*</a> Puntos a Utilizar (Pesos)</label>
                        <input type="number" class="form-control" name="amount" value="{{ $job->getPendingAmount() }}" min="0" max="{{ $job->getPendingAmount() }}" required>
                    @elseif($job->getPendingAmount() > $points)
                        <label class="mt-3"><a class="text-danger">*</a> Puntos a Utilizar (Pesos)</label>
                        <input type="number" class="form-control" name="amount" value="{{ $points }}" min="0" max="{{ $points }}" step="100" required>
                    @endif

                    <button type="submit" class="btn btn-warning btn-block mt-3"><i class="fas fa-plus-circle"></i> Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif