@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="ceo-header mt-3">
            <h5>
                Số lượng tất cả các phòng ban : {{ count($departments) }}
            </h5>
        </div>
        <div class="row mt-4">
            @foreach ($departments as $department)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header text-center">{{ $department->name }}</div>
                        <div class="card-body department-body">
                            
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
