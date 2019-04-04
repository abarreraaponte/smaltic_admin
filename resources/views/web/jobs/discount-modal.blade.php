<!--Create Payment Modal-->
<div class="modal fade" id="applydiscount" role="dialog" tabindex="-1" aria-labelledby="applydiscount" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <a class="h5 modal-title" id="contactmodallabel">Aplicar Descuentos</a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ '/web/jobs/' . $job->getRouteKey() . '/discounts/apply' }}">
                    @csrf
                    <a class="h5 my-2">Descuentos Disponibles</a>

                    @foreach($available_discounts as $discount)
                    <div class="custom-control custom-checkbox my-2">
                        <input type="checkbox" class="custom-control-input" id="{{ 'discount' . $discount->id }}" value="{{ $discount->id }}" name="applieddiscount[]">
                        <label class="custom-control-label" for="{{ 'discount' . $discount->id }}">{{ $discount->description . ' -> Monto: ' . $discount->amount }}</label>
                    </div>
                    @endforeach

                    <button type="submit" class="btn btn-secondary btn-block mt-3"><i class="fas fa-plus-circle"></i> Aplicar</button>
                </form>
            </div>
        </div>
    </div>
</div>
