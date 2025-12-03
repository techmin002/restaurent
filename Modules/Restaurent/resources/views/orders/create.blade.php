  @extends('setting::layouts.master')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @section('title', 'New Order Request')
  @section('content')
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>New Order Request</h1>
                      </div>
                      <div class="col-sm-6">
                          <ol class="breadcrumb float-sm-right">
                              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                              <li class="breadcrumb-item active">Reception Orders</li>
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
                                  <span>Order Detail's</span>
                              </div>
                              <form id="orderForm" action="{{ route('orders.store') }}" method="post">
                                  @csrf
                                  <div class="card-body">

                                      <div class="row">

                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label for="customerName">Customer</label> <a
                                                      class="btn btn-xs btn-primary ml-2 float-right" data-toggle="modal"
                                                      data-target="#addCustomerModal">+ Customer</a>
                                                  <select class="form-control" id="customerName" name="customer_id">
                                                      <option value="">-- Select Customer --</option>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label for="orderType">Order Type</label>
                                                  <select class="form-control" id="orderType" name="orderType">
                                                      <option value="">-- Select Order Type --</option>
                                                      <option value="dinein">Dine In</option>
                                                      <option value="takeaway">Take Away</option>
                                                      <option value="office">Office Order</option>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-4">
                                              <div id="dynamicField"></div>
                                          </div>
                                      </div>
                                      <hr class="text-danger">
                                      <div id="itemsContainer">
                                          <h5>Order Items</h5>
                                          <div class="itemRow row mb-2">
                                              <div class="col-md-4">
                                                  <select class="form-control item-search" name="menu_id[]">
                                                      <option value="">-- Select Item --</option>
                                                  </select>
                                              </div>
                                              <div class="col-md-3">
                                                  <select class="form-control item-variation" name="variation_id[]">
                                                      <option value="">Select Variation</option>
                                                  </select>
                                              </div>
                                              <div class="col-md-2">
                                                  <input type="number" name="qty[]" class="form-control item-qty"
                                                      placeholder="Qty" min="1" value="1">
                                              </div>
                                              <div class="col-md-2">
                                                  <button type="button"
                                                      class="btn btn-danger btn-sm btn-remove">Remove</button>
                                              </div>
                                          </div>
                                      </div>
                                      <hr class="text-danger">
                                      <button type="button" id="addItemBtn" class="btn btn-success btn-sm mb-3">Add More
                                          Item</button>
                                      <div class="row">
                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label for="discountType">Discount Type</label>
                                                  <select class="form-control" id="discountType" name="discountType">
                                                      <option value="percent">Percentage (%)</option>
                                                      <option value="flat">Flat (Rs.)</option>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label for="discountValue">Discount Amount</label>
                                                  <input type="number" class="form-control" id="discountValue"
                                                      name="discountValue" min="0" value="0" max="100">

                                              </div>
                                          </div>
                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label for="deliveryCharge">Delivery Charge (Optional)</label>
                                                  <input type="number" class="form-control" id="deliveryCharge"
                                                      name="deliveryCharge" min="0" value="0">
                                              </div>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label for="remarks">Remarks / Message</label>
                                          <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                                      </div>

                                      <div class="row bg-danger" style="border-radius: 10px">
                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label>Total Amount:</label>
                                                  <p id="totalAmount">0</p>
                                              </div>
                                          </div>
                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label>Discount Applied:</label>
                                                  <p id="discountApplied">0</p>
                                              </div>
                                          </div>
                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label>Grand Total:</label>
                                                  <p id="grandTotal">0</p>
                                              </div>
                                          </div>
                                      </div>
                                      <input type="hidden" name="sub_total" id="subTotalInput">
                                      <input type="hidden" name="discount_amount" id="discountAmountInput">
                                      <input type="hidden" name="grand_total" id="grandTotalInput">
                                  </div>
                                  <div class="card-footer text-center">
                                      <button type="submit" class="btn btn-success w-100">Place Order</button>

                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
          </section>
      </div>
      <!-- Add Customer Modal -->
      <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog"
          aria-labelledby="addCustomerModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <form id="addCustomerForm">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title">Add New Customer</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span>&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          @csrf

                          <div class="form-group">
                              <label for="newCustomerName">Name</label>
                              <input type="text" class="form-control" id="newCustomerName" name="name" required>
                          </div>
                          <div class="form-group">
                              <label for="newCustomerPhone">Phone</label>
                              <input type="text" class="form-control" id="newCustomerPhone" name="phone">
                          </div>
                          <div class="form-group">
                              <label for="newCustomerEmail">Email</label>
                              <input type="email" class="form-control" id="newCustomerEmail" name="email">
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Save Customer</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                      </div>
                  </div>
              </form>
          </div>
      </div>

      <script>
          function updateTotal() {
              let total = 0;

              $(".itemRow").each(function() {
                  const qty = parseFloat($(this).find(".item-qty").val()) || 0;

                  let price = parseFloat($(this).find(".item-variation option:selected").data("price"));

                  if (isNaN(price)) {
                      price = parseFloat($(this).find(".item-variation").data("price")) || 0;
                  }

                  total += qty * price;
              });

              const discountType = $("#discountType").val();
              let discountValue = parseFloat($("#discountValue").val()) || 0;
              const deliveryCharge = parseFloat($("#deliveryCharge").val()) || 0;

              let discountAmount = 0;

              if (discountType === "percent") {
                  if (discountValue > 100) discountValue = 100;
                  discountAmount = total * (discountValue / 100);
              } else if (discountType === "flat") {
                  discountAmount = discountValue > total ? total : discountValue;
              }

              const grandTotal = (total - discountAmount) + deliveryCharge;

              // Display totals
              $("#totalAmount").text(total.toFixed(2));
              $("#discountApplied").text(discountAmount.toFixed(2));
              $("#grandTotal").text(grandTotal.toFixed(2));

              // Store in hidden fields
              $("#subTotalInput").val(total.toFixed(2));
              $("#discountAmountInput").val(discountAmount.toFixed(2));
              $("#grandTotalInput").val(grandTotal.toFixed(2));
          }

          function fetchAllProducts(selectElement) {
              $.ajax({
                  url: '/api/products/search',
                  method: 'GET',
                  data: {
                      query: ''
                  },
                  success: function(data) {
                      selectElement.empty().append('<option value="">-- Select Item --</option>');
                      data.forEach(product => {
                          selectElement.append(
                              `<option data-id="${product.id}" data-base-price="${product.price}" value="${product.id}">${product.name}</option>`
                          );
                      });
                  }
              });
          }


          function fetchVariationsByProductId(id, selectElement) {
              $.ajax({
                  url: '/api/products/' + id, // assuming route like /api/products/{id}
                  method: 'GET',
                  success: function(product) {
                      const options = product.variations || [];
                      const variationContainer = selectElement.closest('.col-md-3');

                      if (options.length > 0) {
                          const selectHTML = `
                    <select class="form-control item-variation" name="variation_id[]">
                        <option value="">Select Variation</option>
                        ${options.map(opt =>
                            `<option data-price="${opt.price}" value="${opt.id}">${opt.name} - Rs. ${opt.price}</option>`
                        ).join('')}
                    </select>
                `;
                          variationContainer.html(selectHTML);
                      } else {
                          const basePrice = product.price || 0;
                          const staticHTML = `
                    <input type="text" class="form-control item-variation" data-price="${basePrice}" value="Price - Rs. ${basePrice}" disabled>
                `;
                          variationContainer.html(staticHTML);
                      }

                      updateTotal();
                  }
              });
          }


          function fetchOptionsForOrderType(type) {
              const dynamicField = $('#dynamicField');
              dynamicField.empty();

              if (type === 'dinein') {
                  $.ajax({
                      url: '/api/tables',
                      method: 'GET',
                      success: function(data) {
                          const options = data.map(table =>
                                  `<option value="${table.id}">${table.table_number}</option>`)
                              .join('');
                          dynamicField.append(`
                        <div class="form-group">
                            <label for="table">Select Table</label>
                            <select class="form-control" id="table" name="table_id">
                                ${options}
                            </select>
                        </div>
                    `);
                      }
                  });
              } else if (type === 'office') {
                  $.ajax({
                      url: '/api/offices',
                      method: 'GET',
                      success: function(data) {
                          const options = data.map(office =>
                              `<option value="${office.id}">${office.name}</option>`).join('');
                          dynamicField.append(`
                        <div class="form-group">
                            <label for="office">Select Office</label>
                            <select class="form-control" id="office" name="office_id">
                                ${options}
                            </select>
                        </div>
                    `);
                      }
                  });
              }
          }

          $('#orderType').on('change', function() {
              const selected = $(this).val();
              fetchOptionsForOrderType(selected);
          });

          $('#customerName').on('focus', function() {
              $.ajax({
                  url: '/api/customers',
                  method: 'GET',
                  success: function(data) {
                      const select = $('#customerName');
                      select.empty().append('<option value="">-- Select Customer --</option>');
                      data.forEach(c => {
                          select.append(`<option value="${c.id}">${c.name}</option>`);
                      });
                  }
              });
          });

          $(document).on('change', '.item-search', function() {
              const menuId = $(this).val();
              const variationSelect = $(this).closest('.itemRow').find('.item-variation');
              fetchVariationsByProductId(menuId, variationSelect);
              updateTotal();
          });


          $(document).on('change', '.item-variation, .item-qty', updateTotal);

          $(document).on('click', '#addItemBtn', function() {
              const itemRow = `<div class="itemRow row mb-2">
            <div class="col-md-4">
                <select class="form-control item-search" name="menu_id[]">
                    <option value="">-- Select Item --</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-control item-variation" name="variation_id[]"">
                    <option value="">Select Variation</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control item-qty" name="qty[]"" placeholder="Qty" min="1" value="1">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm btn-remove">Remove</button>
            </div>
        </div>`;
              $('#itemsContainer').append(itemRow);
              fetchAllProducts($('#itemsContainer .itemRow:last .item-search'));
          });

          $(document).on('click', '.btn-remove', function() {
              $(this).closest('.itemRow').remove();
              updateTotal();
          });

          //   $('#orderForm').on('submit', function(e) {
          //       e.preventDefault();
          //       alert('Order submitted successfully!');
          //   });

          // Initial product population
          $(document).ready(function() {
              fetchAllProducts($('.item-search'));
          });
          $('#discountType, #discountValue, #deliveryCharge').on('input change', function() {
              updateTotal();
          });
      </script>
      <script>
          $('#addCustomerForm').on('submit', function(e) {
              e.preventDefault();

              const formData = {
                  name: $('#newCustomerName').val(),
                  phone: $('#newCustomerPhone').val(),
                  email: $('#newCustomerEmail').val(),
              };
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

              $.ajax({
                  url: '/api/customers/store', // <-- Update this to your route
                  type: 'POST',
                  data: formData,
                  success: function(response) {
                      // Add new customer to the dropdown
                      $('#customerName').append(
                          `<option value="${response.id}" selected>${response.name}</option>`);

                      // Hide modal & reset form
                      $('#addCustomerModal').modal('hide');
                      $('#addCustomerForm')[0].reset();
                  },
                  error: function(xhr) {
                      alert('Failed to add customer. Please try again.');
                  }
              });
          });
      </script>

  @endsection