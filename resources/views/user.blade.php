@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ $user->name }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                    <table class="table" id="table">
                      <thead>
                        <th>QUESTION</th>
                        <th>ANSWER</th>
                        <th>STATUS</th>
                        <th>DATE</th>
                      </thead>
                    </table>
                  </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    <script>
        $(function() {
            $('table').DataTable({
                proccesing: true,
                serverSide: true,
                ajax: "{{ route('data.user.history', $user->id) }}",
                columns: [
                    {
                        data: 'question',
                        name: 'question'
                    },
                    {
                        data: 'answer',
                        name: 'answer'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            if(row.status) {
                                return 'true';
                            }
                            return 'false';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }
                ]
            })
        });
    </script>
@endsection
