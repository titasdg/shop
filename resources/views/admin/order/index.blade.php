@extends('layouts.app')

@section('content')

                     

    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Užsakymai</div>
                    <div class="card-body">
                        <a href="https://www.omniva.lt/privatus/pastomatu_adresai">Paštomatų paieška</a>
                        {!! Form::open(['method' => 'GET', 'url' => '/admin/order', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Ieškoti..." value="{{ request('search') }}">
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Vardas</th><th>Pavarde</th><th>El.Paštas</th><th>Užsakymo numeris</th><th>Veiksmai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($order as $item)
                                @if($item->status==0)
                                <tr class="redLine" id="line{{$item->order_id}}">
                                    @elseif($item->status==1)
                                    <tr class="orangeLine" id="line{{$item->order_id}}">
                                    @else
                                    <tr class="greenLine" id="line{{$item->order_id}}">
                                @endif
                                        <td><div class="ball"></div></td>
                                        <td>{{ $item->name }}</td><td>{{ $item->last_name }}</td><td>{{ $item->email }}</td><td>{{ $item->order_id }}</td>
                                        <td>
                                            <a href="{{ url('/admin/order/' . $item->order_id) }}" title="View Order"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Peržiūrėti</button></a>
                                        <select onchange="myFunction(this)" id="{{$item->order_id}}">

                                        <option value="0" {{$selected=((integer)$item->status==0) ? "selected":""}}>Naujas</option>
                                        <option value="1" {{$selected=((integer)$item->status==1) ? "selected":""}} >Apmokėtas</option>
                                        <option value="2" {{$selected=((integer)$item->status==2) ? "selected":""}} >Atliktas</option>

                                        </select>
                                        
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/admin/order', $item->order_id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Ištrinti', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'title' => 'Delete Order',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $order->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
