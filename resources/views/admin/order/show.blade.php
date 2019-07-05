@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Uzsakymas {{ $order->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/order') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/order/' . $order->id . '/edit') }}" title="Edit Order"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['admin/order', $order->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Delete Order',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>
                        <div class="card-header">Pirkejo informacija</div>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $order->id }}</td>
                                    </tr>
                                    <tr><th> Name </th><td> {{ $customer->name }} </td></tr><tr><th> Last Name </th><td> {{ $customer->last_name }} </td></tr><tr><th> Email </th><td> {{ $customer->email }} </td></tr>
                                    <tr>
                                        <th>Tel.Nr</th><td>{{ $customer->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Imone</th><td>{{ $customer->company }}</td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                            <div class="card-header">Uzsakymo informacija</div>
                            <table class="table table-borderless">
                                <tbody>
                                     <tr>
                                        <th>Kaina</th><td>{{ $order->price }}</td>
                                    </tr>
                                    <tr>
                                        <th>Adresas</th><td>{{ $order->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Papildomas adresas</th><td>{{ $order->addressExtra }}</td>
                                    </tr>
                                    <tr>
                                        <th>Miestas</th><td>{{ $order->city }}</td>
                                    </tr>
                                    <tr>
                                        <th>Salis</th><td>{{ $order->country }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pasto kodas</th><td>{{ $order->post_code }}</td>
                                    </tr>
                                    <tr>
                                        <th>Apmokejimo budas</th><td>{{ $order->payment_method }}</td>
                                    </tr>
                                    <tr>
                                        <th>Atsiemimo budas</th><td>{{ $order->shipping }}</td>
                                    </tr>
                                    <tr>
                                    @if($order->status==2)
                                        <th>Statusas</th><td>Atliktas</td>
                                    @elseif($order->status==1)
                                    <th>Statusas</th><td>Apmokėtas</td>
                                    @elseif($order->status==0)
                                    <th>Statusas</th><td>Naujas</td>
                                    @endif

                                    </tr>
                                   
                                  
                                    
                                </tbody>
                            </table>
                            <div class="card-header">Produktai</div>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>Pavadinimas</th>
                                        <th>Kiekis</th>
                                    </tr>
                                   @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->title }}</td>
                                  <td>{{ $product->quantity }}</td>

                                    </tr>
                                  @endforeach
                                 
                                    
                                </tbody>
                            </table>





                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
