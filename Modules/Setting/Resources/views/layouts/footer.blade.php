<footer class="main-footer">
    <strong>Copyright &copy; 2024 <a href="https://bginfotechs.com/">BG Infotechs</a>.</strong>
    All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>

<!-- Required Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('backend/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('backend/plugins/sparklines/sparkline.js') }}"></script>
<script src="{{ asset('backend/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('backend/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ asset('backend/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<script src="{{ asset('backend/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('backend/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('backend/dist/js/adminlte.js') }}"></script>
<script src="{{ asset('backend/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('backend/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('backend/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('backend/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('backend/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<script src="{{ asset('backend/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('backend/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('backend/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script src="{{ asset('backend/plugins/dropzone/min/dropzone.min.js') }}"></script>

<!-- Custom Scripts -->
<script>
    $(document).ready(function() {
        $('.summernote').summernote();
    });
    $(function() {
        // Initialize Select2 Elements
        $('.select2').select2();
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        // Initialize Input Masks
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        });
        $('#datemask2').inputmask('mm/dd/yyyy', {
            'placeholder': 'mm/dd/yyyy'
        });
        $('[data-mask]').inputmask();

        // Date Pickers
        $('#reservationdate').datetimepicker({
            format: 'L'
        });
        $('#reservationdatetime').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });
        $('#reservation').daterangepicker();
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        });

        // Time Picker
        $('#timepicker').datetimepicker({
            format: 'LT'
        });

        // Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox();


        // Color Picker
        $('.my-colorpicker1').colorpicker();
        $('.my-colorpicker2').colorpicker().on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        });

        // Bootstrap Switch
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });
    });

    // Initialize DataTables
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

    // Initialize BS-Stepper
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'));
    });

    // DropzoneJS Demo Code
    Dropzone.autoDiscover = false;
    var previewNode = document.querySelector("#template");
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

    var myDropzone = new Dropzone(document.body, {
        url: "/target-url",
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: false,
        previewsContainer: "#previews",
        clickable: ".fileinput-button"
    });

    myDropzone.on("addedfile", function(file) {
        file.previewElement.querySelector(".start").onclick = function() {
            myDropzone.enqueueFile(file);
        };
    });

    myDropzone.on("totaluploadprogress", function(progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
    });

    myDropzone.on("sending", function(file) {
        document.querySelector("#total-progress").style.opacity = "1";
        file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
    });

    myDropzone.on("queuecomplete", function() {
        document.querySelector("#total-progress").style.opacity = "0";
    });

    document.querySelector("#actions .start").onclick = function() {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
    };

    document.querySelector("#actions .cancel").onclick = function() {
        myDropzone.removeAllFiles(true);
    };
</script>
<script>
    (function() {
        // --- Setup CSRF for Laravel ---
        const csrfToken = $('meta[name="csrf-token"]').attr('content') || '';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        let lastOrderId = 0;
        const POLL_MS = 5000;
        let pollHandle = null;

        // Start polling
        function startPolling() {
            if (pollHandle) clearInterval(pollHandle);
            pollHandle = setInterval(checkNewOrders, POLL_MS);
            checkNewOrders(); // call once immediately
        }

        // Check endpoint and add rows
        function checkNewOrders() {
            $.ajax({
                url: "/check-latest-order",
                method: "GET",
                data: {
                    last_order_id: lastOrderId
                },
                dataType: "json",
                success: function(res) {
                    try {
                        let orders = [];
                        if (res.newOrders && Array.isArray(res.newOrders)) {
                            orders = res.newOrders;
                        } else if (res.newOrder) {
                            orders = [res.newOrder];
                        }
                        if (orders.length === 0) return;

                        let hasNewOrder = false;

                        orders.forEach(order => {
                            if (order.id && Number(order.id) > Number(lastOrderId)) {
                                lastOrderId = Number(order.id);
                                appendOrderRow(order);
                                hasNewOrder = true; // mark as new
                            }
                        });

                        // Play notification sound only if there is at least one new order
                        if (hasNewOrder) {
                            const audio = document.getElementById('newOrderSound');
                            if (audio) {
                                audio.pause();
                                audio.currentTime = 0;
                                audio.play().catch(e => console.error('Audio play error:', e));
                            }

                            // Show modal
                            const modalEl = document.getElementById('newOrderModal');
                            if (typeof $ !== 'undefined' && typeof $(modalEl).modal === 'function') {
                                $(modalEl).modal('show');
                            } else if (typeof bootstrap !== 'undefined') {
                                const bsModal = new bootstrap.Modal(modalEl);
                                bsModal.show();
                            }
                        }

                    } catch (e) {
                        console.error('Error processing checkNewOrders:', e);
                    }
                },
                error: function(xhr, status, err) {
                    console.error('checkNewOrders AJAX error:', status, err, xhr.responseText);
                }
            });
        }


        // Build and append a table row for one order
        function appendOrderRow(order) {
            if (!order || !order.id) return;
            if ($('#orderRow' + order.id).length) return;

            const total = (typeof order.total !== 'undefined') ? Number(order.total) :
                (order.order_items ? computeTotalFromItems(order.order_items) : 0);

            const showButtons = (order.status === 'pending'); // show only for pending

            const totalAmount = Number(order.grand_total || 0).toFixed(2);

            // Get kitchen route URL (you'll need to adjust this based on your route)
            const kitchenStartRoute = `/kitchen/start/${order.id}`; // Default route
            // Or if you have a named route in your blade:
            // const kitchenStartRoute = "{{ route('kitchen.start.cooking', ':id') }}".replace(':id', order.id);

            const actionButtons = showButtons ? `
        <button class="btn btn-sm btn-success btn-accept" data-id="${order.id}" title="Accept order ${order.id}">
            Accept
        </button>
        <button class="btn btn-sm btn-danger btn-reject ms-2" data-id="${order.id}" title="Reject order ${order.id}">
            Reject
        </button>
    ` : `
        <button class="btn btn-sm btn-warning btn-preparing" 
                data-id="${order.id}" 
                data-url="${kitchenStartRoute}"
                title="Start preparing order ${order.id}">
            <i class="fas fa-fire mr-1"></i> Preparing
        </button>
    `;

            // Build items list with variations
            let itemsHtml = 'N/A';
            if (order.items && order.items.length > 0) {
                itemsHtml = order.items.map(item => {
                    let itemText = `${escapeHtml(item.menu_name || 'N/A')} (Qty: ${item.qty || 0})`;
                    if (item.variation_name) {
                        itemText += ` - ${escapeHtml(item.variation_name)}`;
                    }
                    return itemText;
                }).join('<br>');
            }

            const rowHtml = `
            <tr id="orderRow${order.id}">
                <td>#${escapeHtml(order.id.toString())}</td>
                <td>${escapeHtml(order.order_type.toString())}</td>
                <td>Rs. ${Number(order.grand_total).toFixed(2)}</td>
                <td>${itemsHtml}</td>
                <td>${order.order_type === 'dinein' ? escapeHtml(order.table_id || 'N/A') : '-'}</td>
                <td>${order.order_type === 'dinein' ? escapeHtml(order.customer_name || 'N/A') : '-'}</td>
                <td>${order.order_type === 'dinein' ? escapeHtml(order.customer_contact || 'N/A') : '-'}</td>
                <td>${order.order_type === 'office' ? escapeHtml(order.office_name || 'N/A') : '-'}</td>
                <td>${order.order_type === 'office' ? escapeHtml(order.office_contact || 'N/A') : '-'}</td>
                <td>${order.order_type === 'office' ? escapeHtml(order.office_address || 'N/A') : '-'}</td>
                <td>
                    ${actionButtons}
                </td>
            </tr>
        `;

            $('#newOrdersBody').append(rowHtml);

            // Highlight new row briefly
            const $row = $('#orderRow' + order.id);
            $row.css('background-color', '#e9f7ef');
            setTimeout(() => {
                $row.css('transition', 'background-color 800ms').css('background-color', '');
            }, 800);
        }

        function computeTotalFromItems(items) {
            if (!items || !Array.isArray(items)) return 0;
            return items.reduce((sum, it) => {
                const price = Number(it.price) || 0;
                const qty = Number(it.quantity) || 0;
                return sum + (price * qty);
            }, 0);
        }

        // --- Accept and Reject via POST form submission ---
        $(document).on('click', '.btn-accept', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            if (!id) return;
            const csrf = $('meta[name="csrf-token"]').attr('content');
            const form = $('<form>', {
                method: 'POST',
                action: `/accept-order/${id}`
            }).append(`<input type="hidden" name="_token" value="${csrf}">`);
            $('body').append(form);
            form.submit();
        });

        $(document).on('click', '.btn-reject', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            if (!id) return;
            if (!confirm('Reject order #' + id + '?')) return;
            const csrf = $('meta[name="csrf-token"]').attr('content');
            const form = $('<form>', {
                method: 'POST',
                action: `/reject-order/${id}`
            }).append(`<input type="hidden" name="_token" value="${csrf}">`);
            $('body').append(form);
            form.submit();
        });

        // --- Preparing Button Handler ---
        $(document).on('click', '.btn-preparing', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const url = $(this).data('url');

            if (!id || !url) return;

            // Change button state
            const $btn = $(this);
            const originalHtml = $btn.html();
            $btn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Starting...');
            $btn.prop('disabled', true).removeClass('btn-warning').addClass('btn-secondary');

            // Send AJAX request
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: csrfToken
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Update button to show cooking in progress
                        $btn.html('<i class="fas fa-fire mr-1"></i> Cooking');
                        $btn.removeClass('btn-secondary').addClass('btn-danger');
                        $btn.prop('disabled', true);

                        // Show success notification
                        showToast('Order started cooking!', 'success');

                        // Optionally remove the row after a delay
                        setTimeout(() => {
                            $('#orderRow' + id).fadeOut(500, function() {
                                $(this).remove();
                                checkIfNoRowsHideModal();
                            });
                        }, 2000);
                    } else {
                        // Reset button on error
                        $btn.html(originalHtml);
                        $btn.prop('disabled', false).removeClass('btn-secondary').addClass(
                            'btn-warning');
                        showToast(response.message || 'Failed to start cooking', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    // Reset button on error
                    $btn.html(originalHtml);
                    $btn.prop('disabled', false).removeClass('btn-secondary').addClass(
                        'btn-warning');
                    showToast('Started preparing', );
                    // 💥 Reload the page
                    setTimeout(() => {
                        location.reload();
                    }, 5000); // small delay so toast shows briefly
                }
            });
        });

        // Toast notification function
        function showToast(message, type = 'success') {
            const toastId = 'toast-' + Date.now();
            const toastHtml = `
                <div id="${toastId}" class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0 position-fixed" 
                     style="top: 20px; right: 20px; z-index: 9999;" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;

            $('body').append(toastHtml);
            const toastEl = document.getElementById(toastId);

            if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
                const toast = new bootstrap.Toast(toastEl, {
                    delay: 3000
                });
                toast.show();

                // Remove after hide
                toastEl.addEventListener('hidden.bs.toast', function() {
                    $(this).remove();
                });
            } else {
                // Fallback if Bootstrap not available
                $(toastEl).fadeIn().delay(3000).fadeOut(500, function() {
                    $(this).remove();
                });
            }
        }

        function checkIfNoRowsHideModal() {
            if ($('#newOrdersBody tr').length === 0) {
                const modalEl = document.getElementById('newOrderModal');
                if (typeof $ !== 'undefined' && typeof $(modalEl).modal === 'function') {
                    $(modalEl).modal('hide');
                } else if (typeof bootstrap !== 'undefined') {
                    const bsModal = bootstrap.Modal.getInstance(modalEl);
                    if (bsModal) bsModal.hide();
                }
            }
        }

        function escapeHtml(unsafe) {
            return String(unsafe)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        $(document).ready(function() {
            startPolling();
        });

    })();
</script>
