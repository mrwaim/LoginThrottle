<section class="panel">
    <header class="panel-heading">
        @if(count($attempts) > 0)
            <div class="panel-actions">
                <a href="{!! route('failed-logins.purge') !!}"
                   class="panel-action">
                    <i class="fa fa-trash-o mr-xs"></i>
                    Purge
                </a>
            </div>
        @endif
        <h2 class="panel-title">
            All Failed Login Attempts
        </h2>
    </header>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="{{isset($table_class) ? $table_class : 'table table-bordered table-striped table-condensed mb-none'}}">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>DateTime</th>
                    <th>IP Address</th>
                    <th>IC Number</th>
                </tr>
                </thead>
                <tbody>
                @forelse($attempts as $attempt)
                    <tr>
                        <td>{{$attempt->id}}</td>
                        <td>{{$attempt->created_at->toDayDateTimeString()}}</td>
                        <td>{{$attempt->client_ip}}</td>
                        <td>{{$attempt->ic_number}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            No records found
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

