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

                    <section class="content">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card bg-info text-white p-3 h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h4>All Received Orders</h4>
                    <p>{{ $allOrdersCount }}</p>
                    <a href="{{ route('orders.index') }}" class="btn btn-light mt-auto">View</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card bg-warning text-white p-3 h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h4>Reception Orders</h4>
                    <p>{{ $receptionOrdersCount }}</p>
                    <a href="{{ route('receptionorders') }}" class="btn btn-light mt-auto">View</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card bg-primary text-white p-3 h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h4>Kitchen Orders</h4>
                    <p>{{ $kitchenOrdersCount }}</p>
                    <a href="{{ route('kitchenorders') }}" class="btn btn-light mt-auto">View</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card bg-success text-white p-3 h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h4>Completed Orders</h4>
                    <p>{{ $completedOrdersCount }}</p>
                    <a href="{{ route('completedorders') }}" class="btn btn-light mt-auto">View</a>
                </div>
            </div>
        </div>
    </div>
</section>


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
                                          <a class="btn btn-danger" style="float: inline-end;"
                                              href="{{ route('neworders') }}">Create Order</a>
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
                                              <th class="text-center">is_Reception/is_Kitchen</th>

                                              <th class="text-center">Status</th>
                                              <th class="text-center">Action</th>

                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach ($orders as $key => $res)
                                              <tr>
                                                  <td class="text-center">{{ $loop->iteration }}</td>
                                                  <td class="text-center">#RCO000{{ $res->id }}</td>
                                                  <td class="text-center">{{ $res->customer['name'] ?? 'N/A' }}</td>

                                                  <td class="text-center">{{ $res->customer['phone']?? 'N/A' }}</td>
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
                                                            $menu = Modules\Restaurent\Models\Menu::find($item->menu_id);
                                                            $variation = Modules\Restaurent\Models\MenuVariation::find($item->variation_id);
                                                        @endphp
                                                       {{-- @dd($variation); --}}
                                                        <tr>

                                                            <td>{{ $variation->name ?? 'N/A' }}-{{ $menu->name ?? 'N/A' }}</td>
                                                            <td>{{ $item->qty ?? 0 }}</td>
                                                            <td>{{ $variation->price ?? 0 }}</td>

                                                        </tr>
                                                    @endforeach
                                                      </table>
                                                  </td>

                                                  <!-- <td class="text-center">{{ $res->order_type }}</td> -->
                                                  <td class="text-center">{{ $res->order_type }}</td>
                                                  <td class="text-center">{{ $res->order_source }}</td>
                                                  <td class="text-center">{{ $res->status }}</td>
                                                  <td>

                                                      {{-- @include('restaurent::restaurent.edit') --}}
                                                      <a href="{{ route('restaurent.show', $res->id) }}"
                                                          class="btn btn-success btn-sm">
                                                          <i class="fa fa-eye"></i>
                                                      </a>


                                                      <form id="destroy{{ $res->id }}"
                                                          action="{{ route('restaurent.destroy', $res->id) }}"
                                                          method="POST" class="d-inline">
                                                          @csrf
                                                          @method('delete')
                                                          <button type="button" class="btn btn-danger btn-sm"
                                                              onclick="if (confirm('Are you sure? It will delete the data permanently!')) { document.getElementById('destroy{{ $res->id }}').submit(); }">
                                                              <i class="fa fa-trash"></i>
                                                          </button>
                                                      </form>


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
                                              <th class="text-center">is_Reception/is_Kitchen</th>
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
