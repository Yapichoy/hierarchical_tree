@extends('template.app')
@section('content')
        @foreach($first_layers as $first_layer)
        <div class="row mt-1">
            <div class="employee">
                @include('template.employee',['_layer'=>$first_layer])
               @if(isset($second_layers[$first_layer['id']]))
                    @foreach($second_layers[$first_layer['id']] as $second_layer)
                        <div class="employee cli" id = {{$second_layer['id']}}>
                           @include('template.employee',['_layer'=>$second_layer])
                            {{--<div id="load">
                                @if(isset($third_layers[$second_layer['id']]))
                                    @foreach($third_layers[$second_layer['id']] as $third_layer)
                                        <div class="employee">
                                            @include('template.employee',['_layer'=>$third_layer])
                                            @if(isset($forth_layers[$third_layer['id']]))
                                                @foreach($forth_layers[$third_layer['id']] as $forth_layer)
                                                    <div class="employee">
                                                        @include('template.employee',['_layer'=>$forth_layer])
                                                        @if(isset($fifth_layers[$forth_layer['id']]))
                                                            @foreach($fifth_layers[$forth_layer['id']] as $fifth_layer)
                                                                <div class="employee">
                                                                    @include('template.employee',['_layer'=>$fifth_layer])
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>--}}
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
        <hr>
            @endforeach
    {{$first_layers->links()}}
@endsection
