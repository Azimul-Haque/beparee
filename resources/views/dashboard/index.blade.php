@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
<div class="row"> {{-- class: justify-content-center --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Dashboard</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                You are logged in!
            </div>
        </div>
    </div>
</div>
@endsection
