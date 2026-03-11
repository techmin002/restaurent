@can('access_counter_management')
    <!-- Counter Button -->
    <button id="counterBtn" class="custom-btn" data-state="open">
        <i class="fa-solid fa-toggle-on btn-icon"></i>
        <span class="btn-text">Open Counter</span>
    </button>

    <!-- Close Counter Modal -->
    <div id="closeCounterModal" class="close-counter-modal">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <div class="header-icon" id="printModalBtn" style="cursor:pointer;">
                    <i class="fas fa-print"></i>
                </div>
                <div class="header-text">
                    @php
                        $profile = \Modules\Setting\Entities\CompanyProfile::first();
                    @endphp
                    <h2>{{ $branch->name ?? $profile->company_name }} </h2>
                    <p>Daily Counter Summary</p>
                </div>
                <button class="close-btn btn btn-danger btn-sm btn-icon btn-close" id="modalCloseBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div id="modalData"></div>
            </div>
        </div>
    </div>
@endcan

<style>
    .custom-btn {
        background: linear-gradient(135deg, #3490dc 0%, #2779bd 100%);
        border: none;
        padding: 12px 24px;
        color: white;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(52, 144, 220, 0.3);
        position: relative;
        overflow: hidden;
    }

    .custom-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .custom-btn:hover::before {
        left: 100%;
    }

    .custom-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(52, 144, 220, 0.4);
    }

    .custom-btn:active {
        transform: translateY(-1px);
    }

    .custom-btn[data-state="close"] {
        background: linear-gradient(135deg, #e3342f 0%, #cc1f1a 100%);
        box-shadow: 0 4px 15px rgba(227, 52, 47, 0.3);
    }

    .custom-btn[data-state="close"]:hover {
        box-shadow: 0 8px 25px rgba(227, 52, 47, 0.4);
    }

    .btn-icon {
        font-size: 18px;
        transition: transform 0.3s ease;
    }

    .custom-btn:hover .btn-icon {
        transform: scale(1.1);
    }

    /* Modal Styles */
    .close-counter-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 100px;
        width: 100%;
        height: 100%;
        /* background: rgba(0, 0, 0, 0.7); */
        backdrop-filter: blur(5px);
        justify-content: center;
        align-items: center;
        z-index: 9999;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .close-counter-modal .modal-content {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 20px;
        width: 95%;
        max-width: 1000px;
        max-height: 90vh;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: slideUp 0.4s ease;
    }

    @keyframes slideUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        padding-right: 70px !important;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
    }

    .header-icon {
        background: rgba(255, 255, 255, 0.2);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        backdrop-filter: blur(10px);
    }

    .header-text h2 {
        margin-left: 0;
        font-size: 24px;
        font-weight: 700;
    }

    .header-text p {
        margin-left: 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .close-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 30px;
        max-height: calc(90vh - 150px);
        overflow-y: auto;
    }

    /* Cash Summary Styles */
    .cash-summary {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        border-left: 5px solid #28a745;
    }

    .cash-summary h3 {
        color: #2c3e50;
        margin-bottom: 20px;
        font-size: 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cash-summary h3 i {
        color: #28a745;
    }

    .cash-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 15px;
    }

    .cash-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        border-top: 4px solid #3490dc;
        transition: transform 0.3s ease;
    }

    .cash-card:hover {
        transform: translateY(-5px);
    }

    .cash-card.closing {
        border-top-color: #e3342f;
    }

    .cash-card .amount {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin: 10px 0 5px;
    }

    .cash-card .label {
        font-size: 14px;
        color: #6c757d;
        font-weight: 500;
    }

    /* Orders Table Styles */
    .orders-section {
        margin-top: 30px;
    }

    .orders-section h3 {
        color: #2c3e50;
        margin-bottom: 20px;
        font-size: 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .orders-section h3 i {
        color: #667eea;
    }

    .orders-table-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .orders-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .orders-table th {
        padding: 15px 12px;
        text-align: left;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .orders-table tbody tr {
        border-bottom: 1px solid #f1f3f4;
        transition: background-color 0.3s ease;
    }

    .orders-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .orders-table tbody tr:last-child {
        border-bottom: none;
    }

    .orders-table td {
        padding: 12px;
        color: #495057;
    }

    .orders-table .order-id {
        font-weight: 600;
        color: #3490dc;
    }

    .orders-table .customer-name {
        font-weight: 500;
        color: #2c3e50;
    }

    .orders-table .total-amount {
        font-weight: 700;
        color: #28a745;
        text-align: right;
    }

    .no-orders {
        text-align: center;
        padding: 50px 20px;
        color: #6c757d;
    }

    .no-orders i {
        font-size: 48px;
        margin-bottom: 15px;
        color: #dee2e6;
    }

    .no-orders h4 {
        margin: 10px 0;
        color: #6c757d;
        font-weight: 500;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .modal-header {
            padding: 20px;
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }

        .header-icon {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }

        .header-text h2 {
            font-size: 20px;
        }

        .modal-body {
            padding: 20px;
        }

        .cash-cards {
            grid-template-columns: 1fr;
        }

        .orders-table-container {
            overflow-x: auto;
        }

        .orders-table {
            min-width: 800px;
        }
    }

    /* Scrollbar Styling */
    .modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const counterBtn = document.getElementById("counterBtn");
        const btnIcon = counterBtn.querySelector(".btn-icon");
        const btnText = counterBtn.querySelector(".btn-text");

        const modal = document.getElementById("closeCounterModal");
        const modalData = document.getElementById("modalData");
        const modalCloseBtn = document.getElementById("modalCloseBtn");

        async function storeCounter(type) {
            try {
                const res = await fetch(type === "open" ?
                    "{{ route('openCounter') }}" :
                    "{{ route('closeCounter') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    });
                return await res.json();
            } catch (err) {
                console.error(err);
                return null;
            }
        }

        counterBtn.addEventListener("click", async function(e) {
            e.preventDefault();
            const state = counterBtn.dataset.state;

            if (!confirm(`Are you sure you want to ${state} the counter?`)) return;

            const data = await storeCounter(state);
            if (!data || !data.success) return;

            if (state === "open") {
                // Change button to Close
                btnIcon.className = "fa-solid fa-toggle-off btn-icon";
                btnText.textContent = "Close Counter";
                counterBtn.dataset.state = "close";
            } else {
                // Change button to Open
                btnIcon.className = "fa-solid fa-toggle-on btn-icon";
                btnText.textContent = "Open Counter";
                counterBtn.dataset.state = "open";

                // Show modal only when closing
                let orders = data.orders || [];

                let html = `
                    <div class="cash-summary">
                        <h3><i class="fas fa-chart-bar"></i>Cash Summary</h3>
                        <div class="cash-cards">
                            <div class="cash-card">
                                <div class="label">Opening Balance</div>
                                <div class="amount">Rs. ${parseFloat(data.cash_opening).toLocaleString()}</div>
                                <div class="description">Starting amount</div>
                            </div>
                            <div class="cash-card closing">
                                <div class="label">Closing Balance</div>
                                <div class="amount">Rs. ${parseFloat(data.cash_closing).toLocaleString()}</div>
                                <div class="description">End of day total</div>
                            </div>
                            <div class="cash-card">
                                <div class="label">Daily Revenue</div>
                                <div class="amount">Rs. ${(parseFloat(data.cash_closing) - parseFloat(data.cash_opening)).toLocaleString()}</div>
                                <div class="description">Net earnings</div>
                            </div>
                        </div>
                    </div>`;

                if (orders.length > 0) {
                    html += `
                    <div class="orders-section">
                        <h3><i class="fas fa-receipt"></i>Today's Orders (${orders.length})</h3>
                        <div class="orders-table-container">
                            <table class="orders-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Table</th>
                                        <th>Items</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                    orders.forEach(order => {
                        const itemCount = order.items.length;
                        const totalQty = order.items.reduce((sum, item) => sum + parseInt(
                            item.qty), 0);

                        html += `
                            <tr>
                                <td class="order-id">#${order.id}</td>
                                <td class="customer-name">${order.customer?.name ?? 'Office-order'}</td>
                                <td>${order.table ?? 'office'}</td>
                                <td>${itemCount} item${itemCount !== 1 ? 's' : ''}</td>
                                <td>${totalQty}</td>
                                <td class="total-amount">Rs. ${parseFloat(order.grand_total).toLocaleString()}</td>
                            </tr>`;
                    });

                    html += `</tbody></table></div></div>`;
                } else {
                    html += `
                    <div class="no-orders">
                        <i class="fas fa-clipboard-list"></i>
                        <h4>No Orders Today</h4>
                        <p>There were no orders processed for today.</p>
                    </div>`;
                }

                modalData.innerHTML = html;
                modal.style.display = "flex";
            }
        });

        modalCloseBtn.addEventListener("click", () => {
            modal.style.display = "none";
        });

        // Close modal when clicking outside
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.style.display = "none";
            }
        });
    });

    // Print Modal
    document.getElementById("printModalBtn").addEventListener("click", function() {
        let modalContent = document.querySelector("#closeCounterModal .modal-content").innerHTML;

        let printWindow = window.open("", "", "width=900,height=700");
        printWindow.document.write(`
        <html>
        <head>
            <title>Print Summary</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; }
                h2 { margin: 0; }
                table { width: 100%; border-collapse: collapse; }
                th, td { padding: 10px; border: 1px solid #ddd; }
            </style>
        </head>
        <body>
            ${modalContent}
        </body>
        </html>
    `);

        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    });
</script>
