  @extends('setting::layouts.master')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @section('title', 'Orders')
  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Order's</h1>
                      </div>
                      <div class="col-sm-6">
                          <ol class="breadcrumb float-sm-right">
                              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                              <li class="breadcrumb-item active">New Order Request</li>
                          </ol>
                      </div>
                  </div>
              </div><!-- /.container-fluid -->
          </section>
          <!-- Main content -->
          <section class="content">
              <div class="container-fluid">
                  <div class="row">
                      <div class="col-12">
                          <div class="card">
                              <div class="card-header bg-green">
                                <div class="row">
                                    <div class="col-6">
                                          <span>Order Detail's</span>
                                    </div>
                                    <div class="col-6">
                                          <a class="btn btn-danger" style="float: inline-end;" href="{{ route('neworders') }}">Create Order</a>
                                    </div>
                                </div>
                              </div>
                               <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Order ID</th>
                                            <th class="text-center">Customer</th>
                                            <th class="text-center">Phone</th>
                                            <th class="text-center">Items</th>
                                            <th class="text-center">Table/ Office/ Takeway</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $key => $res)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">#RCO000{{ $res->id }}</td>
                                                <td class="text-center">{{  $res->customer ? $res->customer['name'] : 'N/A' }}</td>

                                                <td class="text-center">{{ $res->customer ? $res->customer['phone'] : 'N/A' }}</td>
                                                <td class="text-center">
                                                    <b>Iteams:</b>
                                                    <table>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Qty</th>
                                                            <th>Price</th>
                                                        </tr>
                                                        @foreach ($res->items as $item)
                                                        @php
                                                            $variation = Modules\Restaurent\Models\MenuVariation::select('name','price')->where('id',$item->variation_id)->first();
                                                            
                                                            $menu = Modules\Restaurent\Models\Menu::select('name','price')->where('id',$item->menu_id)->first();

                                                        @endphp
                                                       {{-- @dd($variation); --}}
                                                        <tr>
                                                            <td>{{ $menu->name?? $item->name }}</td>
                                                            <td>{{ $item->qty }}</td>
                                                            <td>{{ $variation->price?? $item->price }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </table>
                                                </td>
                                                <td class="text-center">{{ $res->order_type }}</td>
                                                <td class="text-center">{{ $res->status }}</td>
                                                <td>

                                                    {{-- @include('restaurent::restaurent.edit') --}}
                                                    <a href="{{ route('restaurent.show', $res->id) }}"
                                                        class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                                                    <button id="delete" class="btn btn-danger btn-sm"
                                                        onclick="event.preventDefault();if (confirm('Are you sure? It will delete the data permanently!')) {document.getElementById('destroy{{ $res->id }}').submit()}">
                                                        <i class="fa fa-trash"></i>
                                                        <form id="destroy{{ $res->id }}" class="d-none"
                                                            action="{{ route('restaurent.destroy', $res->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')
                                                        </form>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Restaurent</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Phone</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Location</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                          </div>
                      </div>
                  </div>
              </div>
          </section>
      </div>
  @endsection
