@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Crear Meta</div>

                <div class="card-body">
                <goal-component></goal-component>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-8 my-4">
            <div class="card">
                <div class="card-header">Asignar oficina a Meta</div>
                <div class="card-body">
                <officetogoal-component></officetogoal-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
