@extends('template.app')
@section('title', 'Главная страница')
@section('content')
        @foreach($first_layers as $first_layer)
        <div class="row mt-1">
            <div class="employee">
                @include('template.employee',['_layer'=>$first_layer])
               @if(isset($second_layers[$first_layer['id']]))
                    @foreach($second_layers[$first_layer['id']] as $second_layer)
                        <div class="employee cli" id = {{$second_layer['id']}}>
                           @include('template.employee',['_layer'=>$second_layer])

                        </div>
                    @endforeach
                @endif
            </div>

        </div>
        <hr>
            @endforeach
    {{$first_layers->links()}}
@endsection
