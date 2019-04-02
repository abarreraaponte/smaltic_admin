<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm rounded mt-4">
            <div class="card-header borde-0"><a class="h5">Trabajos de esta clienta</a></div>
            <div class="card-body border-0">
                <div class="table-responsive table-hover">
                    <table id="main_table" class="table table-sm table-bordered table-striped">
                        <thead class="thead-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customer->jobs as $job)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($job->date)->format('d/m/Y') }}</td>
                                <td>
                                    <a class="btn btn-sm btn-primary" href="{{ '/web/jobs/' . $job->getRouteKey() }}"><i class="fas fa-eye"></i></a>
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
