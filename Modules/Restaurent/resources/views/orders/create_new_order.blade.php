@extends('setting::layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title', 'New Order Request')
@section('content')
    <style>
        :root {
            --primary-color: #2d3748;
            --secondary-color: #4a5568;
            --accent-color: #e53e3e;
            --success-color: #38a169;
            --warning-color: #dd6b20;
            --info-color: #3182ce;
            --light-bg: #f7fafc;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --card-shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background-color: #f5f7fb;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .content-wrapper {
            background-color: #f5f7fb;
        }

        /* Menu Items Styling */
        .menu-item .card {
            border: 0;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            overflow: hidden;
            height: 100%;
            background: white;
            position: relative;
            cursor: pointer;
        }

        .menu-item .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-shadow-hover);
        }

        .menu-item .card-img-container {
            position: relative;
            overflow: hidden;
            height: 160px;
        }

        .menu-item img {
            object-fit: cover;
            width: 100%;
            height: 100%;
            transition: var(--transition);
        }

        .menu-item .card:hover img {
            transform: scale(1.08);
        }

        .category-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--primary-color);
            z-index: 2;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .price-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--accent-color), #c53030);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            z-index: 2;
            box-shadow: 0 4px 10px rgba(229, 62, 62, 0.3);
        }

        .card-body {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            height: calc(100% - 160px);
        }

        .card-title {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
            font-size: 1rem;
            line-height: 1.4;
        }

        .card-text {
            color: #718096;
            font-size: 0.85rem;
            line-height: 1.5;
            flex-grow: 1;
            margin-bottom: 0.75rem;
        }

        .card-footer {
            background: transparent;
            border-top: 1px solid #edf2f7;
            padding: 0.75rem 1rem;
        }

        .qty-control {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .qty-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e2e8f0;
            background: white;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.8rem;
        }

        .qty-btn:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
        }

        .qty-input {
            width: 42px;
            text-align: center;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 4px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .add-to-cart-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 8px;
            padding: 6px 12px;
            font-weight: 600;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: white;
        }

        .add-to-cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(45, 55, 72, 0.3);
            color: white;
        }

        /* Category Navigation - IMPROVED DESIGN */
        .category-nav-container {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .category-scroll {
            display: flex;
            overflow-x: auto;
            padding-bottom: 5px;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 transparent;
            gap: 8px;
        }

        .category-scroll::-webkit-scrollbar {
            height: 6px;
        }

        .category-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .category-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }

        .category-nav {
            display: flex;
            gap: 8px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .category-nav .nav-link {
            padding: 12px 20px;
            border-radius: 10px;
            color: #4a5568;
            font-weight: 600;
            transition: var(--transition);
            cursor: pointer;
            white-space: nowrap;
            font-size: 0.9rem;
            border: 2px solid #e2e8f0;
            background: #f7fafc;
            text-decoration: none;
            display: block;
        }

        .category-nav .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(45, 55, 72, 0.2);
        }

        .category-nav .nav-link:not(.active):hover {
            background: #edf2f7;
            border-color: #cbd5e0;
            transform: translateY(-2px);
        }

        /* Search Bar */
        .search-container {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            z-index: 3;
        }

        .search-input {
            padding-left: 40px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            height: 46px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(45, 55, 72, 0.1);
        }

        /* Cart Sidebar */
        #cart-sidebar {
            position: sticky;
            top: 90px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            border: none;
        }

        .cart-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.25rem;
        }

        .cart-item {
            border-bottom: 1px solid #edf2f7;
            padding: 12px 15px;
            transition: var(--transition);
        }

        .cart-item:hover {
            background: #f7fafc;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-name {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 4px;
            font-size: 0.9rem;
        }

        .cart-item-details {
            color: #718096;
            font-size: 0.8rem;
        }

        .cart-controls {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cart-qty-btn {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e2e8f0;
            background: white;
            font-size: 0.7rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .cart-qty-btn:hover {
            background: #edf2f7;
        }

        .remove-btn {
            color: #e53e3e;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: var(--transition);
            font-size: 0.8rem;
        }

        .remove-btn:hover {
            background: #fed7d7;
        }

        .empty-cart {
            color: #a0aec0;
            text-align: center;
            padding: 2rem 1rem;
        }

        .empty-cart-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .cart-footer {
            background: #f7fafc;
            padding: 1.25rem;
            border-top: 1px solid #edf2f7;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
        }

        .checkout-btn {
            background: linear-gradient(135deg, var(--success-color), #2f855a);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            transition: var(--transition);
            margin-top: 1rem;
            color: white;
        }

        .checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(56, 161, 105, 0.3);
            color: white;
        }

        /* Order Details Section */
        .order-details-card {
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            border: none;
            margin-bottom: 1.5rem;
        }

        .order-details-header {
            background: #f7fafc;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #edf2f7;
            font-weight: 600;
            color: #2d3748;
        }

        .order-details-body {
            padding: 1.25rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 8px 12px;
            font-size: 0.9rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(45, 55, 72, 0.1);
        }

        .radio-group {
            display: flex;
            gap: 1rem;
        }

        .radio-option {
            flex: 1;
        }

        .radio-option input {
            display: none;
        }

        .radio-option label {
            display: block;
            padding: 10px;
            text-align: center;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .radio-option input:checked+label {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .radio-option label:hover {
            border-color: var(--primary-color);
        }

        .discount-controls {
            display: flex;
            gap: 10px;
        }

        .discount-type {
            flex: 0 0 100px;
        }

        .discount-value {
            flex: 1;
        }

        .section-title {
            color: #2d3748;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            padding-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 3px;
        }

        /* Order Type Specific Fields */
        .order-type-field {
            display: none;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .order-type-field.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        /* Customer Details Section */
        .customer-details-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #e9ecef;
        }

        .customer-details-section h6 {
            color: #495057;
            margin-bottom: 0.75rem;
            font-weight: 600;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .item-modal {
            background: white;
            border-radius: 16px;
            width: 90%;
            max-width: 900px;
            max-height: 90vh;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transform: translateY(20px);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .modal-overlay.active .item-modal {
            transform: translateY(0);
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #edf2f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-weight: 700;
            color: #2d3748;
            margin: 0;
            font-size: 1.5rem;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #a0aec0;
            transition: var(--transition);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-modal:hover {
            background: #f7fafc;
            color: #4a5568;
        }

        .modal-body {
            padding: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            flex-grow: 1;
        }

        .modal-content {
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: auto;
        }

        .modal-image-section {
            position: relative;
            height: 300px;
            overflow: hidden;
        }

        .modal-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-details {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .item-name {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .item-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent-color);
            margin-bottom: 1rem;
        }

        .item-description {
            color: #718096;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }

        .variants-section {
            margin-bottom: 1.5rem;
        }

        .variants-title {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.75rem;
            font-size: 1rem;
        }

        .variants-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .variant-option {
            flex: 1;
            min-width: 120px;
        }

        .variant-option input {
            display: none;
        }

        .variant-option label {
            display: block;
            padding: 10px 15px;
            text-align: center;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
            font-size: 0.9rem;
            background: white;
        }

        .variant-option input:checked+label {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .variant-option label:hover {
            border-color: var(--primary-color);
        }

        .modal-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 1.5rem;
            border-top: 1px solid #edf2f7;
        }

        .modal-qty-control {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .modal-qty-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e2e8f0;
            background: white;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1rem;
        }

        .modal-qty-btn:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
        }

        .modal-qty-input {
            width: 60px;
            text-align: center;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px;
            font-weight: 600;
            font-size: 1rem;
        }

        .modal-add-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1rem;
            color: white;
        }

        .modal-add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(45, 55, 72, 0.3);
            color: white;
        }

        .modal-add-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Recent Orders Styling */
        .recent-orders {
            max-height: 200px;
            overflow-y: auto;
            padding: 16px;
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
            border-radius: 12px;
            margin: 16px 0;
            border: 1px solid #e1e5ff;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.08);
            display: none;
        }

        .recent-orders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e1e5ff;
        }

        .recent-orders-header h6 {
            margin: 0;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 0.9rem;
        }

        .recent-orders-count {
            background: var(--primary-color);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .recent-orders .order-item {
            padding: 12px;
            border-radius: 10px;
            background: white;
            margin-bottom: 10px;
            border-left: 4px solid var(--primary-color);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .recent-orders .order-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .recent-orders .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .recent-orders .order-id {
            font-size: 0.85rem;
            color: var(--primary-color);
        }

        .recent-orders .order-status {
            font-size: 0.7rem;
            padding: 4px 8px;
            border-radius: 20px;
            font-weight: 600;
        }

        .recent-orders .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .recent-orders .status-preparing {
            background: #cce7ff;
            color: #004085;
        }

        .recent-orders .status-ready {
            background: #d1ecf1;
            color: #0c5460;
        }

        .recent-orders .status-completed {
            background: #d1f7e4;
            color: #0f5132;
        }

        .recent-orders .order-time {
            font-size: 0.75rem;
            color: var(--muted);
            margin-bottom: 8px;
        }

        .recent-orders .order-items {
            font-size: 0.8rem;
            color: var(--muted);
            line-height: 1.4;
            margin-bottom: 8px;
        }

        .recent-orders .order-total {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--primary-color);
            text-align: right;
        }

        /* Recent Orders Total Display */
        .recent-orders-total {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-radius: 10px;
            padding: 12px 16px;
            margin: 12px 0;
            border: 1px solid #90caf9;
            box-shadow: 0 2px 6px rgba(33, 150, 243, 0.15);
            display: none;
        }

        .recent-orders-total-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .recent-orders-total-label {
            font-weight: 600;
            color: #1565c0;
            font-size: 0.9rem;
        }

        .recent-orders-total-value {
            font-weight: 700;
            color: #0d47a1;
            font-size: 1rem;
        }

        .recent-orders-total-note {
            font-size: 0.75rem;
            color: #1976d2;
            font-style: italic;
        }

        /* Combined Total Display */
        .combined-total {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            border-radius: 10px;
            padding: 12px 16px;
            margin: 12px 0;
            border: 1px solid #81c784;
            box-shadow: 0 2px 6px rgba(76, 175, 80, 0.15);
            display: none;
        }

        .combined-total-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .combined-total-label {
            font-weight: 600;
            color: #2e7d32;
            font-size: 0.9rem;
        }

        .combined-total-value {
            font-weight: 700;
            color: #1b5e20;
            font-size: 1.1rem;
        }

        .combined-total-note {
            font-size: 0.75rem;
            color: #388e3c;
            font-style: italic;
        }

        /* Update Mode Button */
        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color), #b45309) !important;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            transition: var(--transition);
            margin-top: 1rem;
            color: white;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(221, 107, 32, 0.3);
            color: white;
        }

        @media (min-width: 768px) {
            .modal-content {
                flex-direction: row;
            }

            .modal-image-section {
                flex: 0 0 45%;
                height: auto;
            }

            .modal-details {
                flex: 0 0 55%;
                overflow-y: auto;
            }
        }

        @media (max-width: 768px) {
            .menu-item {
                margin-bottom: 1.5rem;
            }

            .category-nav .nav-link {
                margin-bottom: 8px;
            }

            .radio-group {
                flex-direction: column;
                gap: 0.5rem;
            }

            .modal-actions {
                flex-direction: column;
                gap: 1rem;
            }

            .modal-qty-control {
                width: 100%;
                justify-content: center;
            }

            .modal-add-btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Enhanced Table Dropdown Styling */
        .table-dropdown-container {
            position: relative;
        }

        .table-dropdown-container .form-select {
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            padding: 12px 16px;
            font-size: 0.9rem;
            transition: var(--transition);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
        }

        .table-dropdown-container .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(45, 55, 72, 0.1);
        }

        /* Table Status Indicators */
        .table-status {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .table-status-available {
            background-color: var(--success-color);
        }

        .table-status-occupied {
            background-color: var(--accent-color);
        }

        .table-status-reserved {
            background-color: var(--warning-color);
        }

        /* Table Option Styling */
        .table-option {
            display: flex;
            align-items: center;
            padding: 8px 12px;
        }

        .table-info {
            display: flex;
            align-items: center;
            flex-grow: 1;
        }

        .table-capacity {
            font-size: 0.8rem;
            color: #718096;
            margin-left: auto;
        }
    </style>

    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1>New Order Request</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">New Order Request</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Left Column - Menu Items -->
                    <div class="col-lg-8">
                        <!-- Search Bar -->
                        <div class="search-container">
                            <i class="fas fa-search search-icon" style="left:16px;"></i>
                            <input id="search-input" class="form-control search-input" type="search"
                                placeholder="Search menu items..." aria-label="Search" style="padding-left:48px;">
                        </div>

                        <!-- Categories Navigation - IMPROVED DESIGN -->
                        <div class="category-nav-container">
                            <h5 class="section-title">Categories</h5>
                            <div class="category-scroll">
                                <ul class="category-nav">
                                    <li>
                                        <a class="nav-link active" data-category="all">All Items</a>
                                    </li>
                                    @foreach ($categories as $category)
                                        <li>
                                            <a class="nav-link"
                                                data-category="{{ $category->id }}">{{ $category->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Menu Items Grid -->
                        <div class="row" id="menu-items">
                            @foreach ($menus as $item)
                                <div class="col-xl-3 col-lg-4 col-md-6 mb-4 menu-item"
                                    data-category="{{ $item->category_id }}" data-name="{{ strtolower($item->name) }}">
                                    <div class="card h-100">
                                        <div class="card-img-container">
                                            <img src="{{ asset('upload/images/menu/' . $item['image']) }}"
                                                alt="{{ $item->name }}" class="item-image" data-id="{{ $item->id }}">
                                            <span class="category-badge">{{ $item->category_name }}</span>
                                            <span class="price-badge">Rs {{ number_format($item->price, 2) }}</span>
                                        </div>
                                        <div class="card-body" style="height:auto; padding-bottom:0.4rem;">
                                            <h5 class="card-title" style="margin-bottom:0.25rem;">{{ $item->name }}</h5>
                                            <p class="card-text" style="margin-bottom:0.15rem;">
                                                {{ Str::limit($item->description, 80) }}</p>
                                        </div>
                                        <div class="card-footer" style="padding-top:0.35rem;">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="qty-control d-flex align-items-center mb-2">
                                                    <button class="qty-btn minus" data-id="{{ $item->id }}">-</button>
                                                    <input type="number" min="1" value="1" class="qty-input"
                                                        id="qty-{{ $item->id }}"
                                                        style="width:64px;padding:6px 8px;text-align:center;">
                                                    <button class="qty-btn plus" data-id="{{ $item->id }}">+</button>
                                                </div>

                                                <div class="w-100 d-flex justify-content-center">
                                                    <button type="button" class="btn btn-primary add-to-cart-btn"
                                                        data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                        data-price="{{ $item->price }}" style="white-space:nowrap;">
                                                        <i class="fas fa-cart-plus me-1"></i> Add
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Right Column - Cart and Order Details -->
                    <div class="col-lg-4">
                        <!-- Order Details Card -->
                        <div class="card order-details-card">
                            <div class="order-details-header">
                                Order Details
                            </div>
                            <div class="order-details-body">
                                <!-- Order Type -->
                                <div class="form-group">
                                    <label class="form-label">Order Type</label>
                                    <div class="radio-group">
                                        <div class="radio-option">
                                            <input type="radio" id="dineIn" name="orderType" value="dineIn" checked>
                                            <label for="dineIn">Dine In</label>
                                        </div>
                                        <div class="radio-option">
                                            <input type="radio" id="takeAway" name="orderType" value="takeAway">
                                            <label for="takeAway">Take Away</label>
                                        </div>
                                        <div class="radio-option">
                                            <input type="radio" id="office" name="orderType" value="office">
                                            <label for="office">Office</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dine In Table Number Field -->
                                <div class="form-group order-type-field show" id="dineInField">
                                    <label for="tableNumber" class="form-label">Select Table</label>
                                    <select class="form-control" id="tableNumber" name="table_number">
                                        <option value="">-- Select Table --</option>
                                        @foreach ($tables as $table)
                                            @if ($table->booking_status === 'no')
                                                <option value="{{ $table->table_number }}">Table
                                                    {{ $table->table_number }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if (!$tables->where('booking_status', 'no')->count())
                                        <div class="alert alert-warning mt-2 mb-0">
                                            <small><i class="fas fa-exclamation-triangle me-1"></i>No available tables at
                                                the moment</small>
                                        </div>
                                    @endif
                                </div>

                                <!-- Office Selection Field -->
                                <div class="form-group order-type-field" id="officeField">
                                    <label for="officeSelect" class="form-label">Select Office</label>
                                    <select class="form-control" id="officeSelect" name="office_id">
                                        <option value="">-- Select Office --</option>
                                        <!-- Offices will be populated dynamically -->
                                    </select>
                                </div>

                                <!-- Customer Details Section - Hidden for Office orders -->
                                <div class="customer-details-section" id="customerDetails">
                                    <h6><i class="fas fa-user me-2"></i>Customer Details</h6>

                                    <!-- Customer Contact Number -->
                                    <div class="form-group">
                                        <label for="customerPhone" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="customerPhone"
                                            placeholder="Enter phone number">
                                    </div>

                                    <!-- Customer Name -->
                                    <div class="form-group">
                                        <label for="customerName" class="form-label">Customer Name</label>
                                        <input type="text" class="form-control" id="customerName"
                                            placeholder="Enter customer name">
                                    </div>
                                </div>

                                <!-- Discount Section -->
                                <div class="form-group">
                                    <label class="form-label">Discount</label>
                                    <div class="discount-controls">
                                        <select class="form-select discount-type" id="discountType">
                                            <option value="flat">Flat (Rs)</option>
                                            <option value="percent">Percentage (%)</option>
                                        </select>
                                        <input type="number" class="form-control discount-value" id="discountValue"
                                            placeholder="0.00" min="0" step="0.01">
                                    </div>
                                </div>

                                <!-- VAT Section -->
                                <div class="form-group">
                                    <label for="vat" class="form-label">VAT (%)</label>
                                    <input type="number" class="form-control" id="vat" value="13"
                                        min="0" max="100" step="0.01">
                                </div>
                            </div>
                        </div>

                        <!-- Cart Sidebar -->
                        <div id="cart-sidebar" class="card">
                            <div class="cart-header">
                                <h5 class="card-title mb-1">Current Order</h5>
                                <small id="cart-count">0 items</small>
                            </div>
                            <div class="card-body p-0">
                                <div id="cart-items-list" style="max-height: 300px; overflow-y: auto;">
                                    <div class="empty-cart">
                                        <div class="empty-cart-icon">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>
                                        <p>Your cart is empty</p>
                                        <small class="text-muted">Add items to create an order</small>
                                    </div>
                                </div>
                            </div>

                            <div class="cart-footer">
                                <div class="total-row">
                                    <span>Subtotal</span>
                                    <span id="cart-subtotal">Rs 0.00</span>
                                </div>
                                <div class="total-row">
                                    <span>Discount</span>
                                    <span id="cart-discount">Rs 0.00</span>
                                </div>
                                <div class="total-row">
                                    <span>VAT (<span id="vat-percent">13</span>%)</span>
                                    <span id="cart-vat">Rs 0.00</span>
                                </div>
                                <div class="total-row mb-2" style="border-top: 1px solid #e2e8f0; padding-top: 8px;">
                                    <strong>Total</strong>
                                    <strong id="cart-total">Rs 0.00</strong>
                                </div>

                                <!-- Recent Orders Total Display -->
                                <div class="recent-orders-total" id="recent-orders-total">
                                    <div class="recent-orders-total-header">
                                        <span class="recent-orders-total-label">Recent Orders Total</span>
                                        <span class="recent-orders-total-value" id="recent-orders-total-value">Rs
                                            0.00</span>
                                    </div>
                                    <div class="recent-orders-total-note">Total from previous orders</div>
                                </div>

                                <!-- Combined Total Display -->
                                <div class="combined-total" id="combined-total">
                                    <div class="combined-total-header">
                                        <span class="combined-total-label">Combined Total</span>
                                        <span class="combined-total-value" id="combined-total-value">Rs 0.00</span>
                                    </div>
                                    <div class="combined-total-note">Current order + Recent orders</div>
                                </div>

                                <form id="checkout-form" action="{{ route('orders.menus.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="order_items" id="order_items_input">
                                    <input type="hidden" name="order_type" id="order_type_input" value="dineIn">
                                    <input type="hidden" name="customer_name" id="customer_name_input">
                                    <input type="hidden" name="customer_phone" id="customer_phone_input">
                                    <input type="hidden" name="office_id" id="office_id_input">
                                    <input type="hidden" name="table_number" id="table_number_input">
                                    <!-- Store table ID for relations -->
                                    <input type="hidden" name="table_id" id="table_id_input">
                                    <input type="hidden" name="discount_type" id="discount_type_input" value="flat">
                                    <input type="hidden" name="discount_value" id="discount_value_input"
                                        value="0">
                                    <input type="hidden" name="vat" id="vat_input" value="13">
                                    <input type="hidden" name="recent_orders_total" id="recent_orders_total_input"
                                        value="0">
                                    <button type="submit" class="btn checkout-btn">Place Order</button>
                                </form>
                            </div>
                        </div>

                        <div class="mt-3 text-center text-muted small">
                            <i class="fas fa-lightbulb me-1"></i> Tip: Adjust quantity before adding to cart
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Item Modal -->
    <div class="modal-overlay" id="item-modal">
        <div class="item-modal">
            <div class="modal-header">
                <h3 class="modal-title">Item Details</h3>
                <button class="close-modal" id="close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-content">
                    <div class="modal-image-section">
                        <img src="" alt="Item Image" class="modal-image" id="modal-image">
                    </div>
                    <div class="modal-details">
                        <h2 class="item-name" id="modal-item-name"></h2>
                        <div class="item-price" id="modal-item-price"></div>
                        <p class="item-description" id="modal-item-description"></p>

                        <!-- Variants Section -->
                        <div class="variants-section" id="variants-section" style="display: none;">
                            <h4 class="variants-title">Choose Variant</h4>
                            <div class="variants-container" id="variants-container">
                                <!-- Variants will be dynamically added here -->
                            </div>
                        </div>

                        <div class="modal-actions">
                            <div class="modal-qty-control">
                                <button class="modal-qty-btn" id="modal-minus">-</button>
                                <input type="number" min="1" value="1" class="modal-qty-input"
                                    id="modal-qty">
                                <button class="modal-qty-btn" id="modal-plus">+</button>
                            </div>
                            <button class="modal-add-btn" id="modal-add-to-cart">
                                <i class="fas fa-cart-plus"></i> Add Item!
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const cart = [];
            const menuContainer = document.getElementById('menu-items');
            const cartItemsList = document.getElementById('cart-items-list');
            const cartCount = document.getElementById('cart-count');
            const cartSubtotal = document.getElementById('cart-subtotal');
            const cartDiscount = document.getElementById('cart-discount');
            const cartVat = document.getElementById('cart-vat');
            const cartTotal = document.getElementById('cart-total');
            const vatPercent = document.getElementById('vat-percent');
            const orderItemsInput = document.getElementById('order_items_input');

            // Order details inputs
            const orderTypeInput = document.getElementById('order_type_input');
            const customerNameInput = document.getElementById('customer_name_input');
            const customerPhoneInput = document.getElementById('customer_phone_input');
            const officeIdInput = document.getElementById('office_id_input');
            const tableNumberInput = document.getElementById('table_number_input');
            const discountTypeInput = document.getElementById('discount_type_input');
            const discountValueInput = document.getElementById('discount_value_input');
            const vatInput = document.getElementById('vat_input');
            const recentOrdersTotalInput = document.getElementById('recent_orders_total_input');

            // Customer form elements
            const customerNameField = document.getElementById('customerName');
            const customerPhoneField = document.getElementById('customerPhone');
            const customerDetailsSection = document.getElementById('customerDetails');

            // Order type specific fields
            const dineInField = document.getElementById('dineInField');
            const officeField = document.getElementById('officeField');
            const tableNumberSelect = document.getElementById('tableNumber');
            const officeSelect = document.getElementById('officeSelect');

            // Recent orders total display
            const recentOrdersTotalDisplay = document.getElementById('recent-orders-total');
            const recentOrdersTotalValue = document.getElementById('recent-orders-total-value');
            const combinedTotalDisplay = document.getElementById('combined-total');
            const combinedTotalValue = document.getElementById('combined-total-value');

            // Modal elements
            const modalOverlay = document.getElementById('item-modal');
            const closeModalBtn = document.getElementById('close-modal');
            const modalImage = document.getElementById('modal-image');
            const modalItemName = document.getElementById('modal-item-name');
            const modalItemPrice = document.getElementById('modal-item-price');
            const modalItemDescription = document.getElementById('modal-item-description');
            const variantsSection = document.getElementById('variants-section');
            const variantsContainer = document.getElementById('variants-container');
            const modalMinusBtn = document.getElementById('modal-minus');
            const modalPlusBtn = document.getElementById('modal-plus');
            const modalQtyInput = document.getElementById('modal-qty');
            const modalAddToCartBtn = document.getElementById('modal-add-to-cart');

            // Current item being viewed in modal
            let currentModalItem = null;

            // Update mode variables
            let existingOrderId = null;
            let isUpdateMode = false;
            let recentOrdersTotal = 0;

            // Variants data from backend - passed via data attributes
            const variantsData = {};
            @foreach ($menus as $item)
                @if ($item->variations && count($item->variations) > 0)
                    variantsData[{{ $item->id }}] = [
                        @foreach ($item->variations as $variant)
                            {
                                id: '{{ $variant->id }}',
                                name: '{{ $variant->name }}',
                                price: {{ $variant->price }}
                            },
                        @endforeach
                    ];
                @endif
            @endforeach

            // Offices data from backend
            const officesData = [
                @foreach ($offices as $office)
                    {
                        id: {{ $office->id }},
                        name: '{{ $office->name }}'
                    },
                @endforeach
            ];

            // Debug: Check offices data
            console.log('Offices data from backend:', officesData);
            console.log('Number of offices:', officesData.length);

            // Recent orders container (will be dynamically created)
            let recentOrdersContainer = null;

            // Populate offices dropdown
            function populateOffices() {
                console.log('Populating offices dropdown...');
                console.log('Offices data:', officesData);

                officeSelect.innerHTML = '<option value="">-- Select Office --</option>';

                if (officesData && officesData.length > 0) {
                    officesData.forEach(office => {
                        console.log('Adding office:', office);
                        const option = document.createElement('option');
                        option.value = office.id;
                        option.textContent = office.name;
                        officeSelect.appendChild(option);
                    });

                    console.log('Offices dropdown populated with', officesData.length, 'offices');
                } else {
                    console.warn('No offices data available');
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'No offices available';
                    option.disabled = true;
                    officeSelect.appendChild(option);
                }
            }

            // Handle order type change
            function handleOrderTypeChange(selectedType) {
                orderTypeInput.value = selectedType;

                // Hide all order type specific fields first
                dineInField.classList.remove('show');
                officeField.classList.remove('show');

                // Show/hide customer details section
                if (selectedType === 'office') {
                    customerDetailsSection.style.display = 'none';
                    officeField.classList.add('show');
                    officeSelect.required = true;
                    tableNumberSelect.required = false;
                } else {
                    customerDetailsSection.style.display = 'block';
                    officeSelect.required = false;

                    if (selectedType === 'dineIn') {
                        dineInField.classList.add('show');
                        tableNumberSelect.required = true;
                    } else {
                        tableNumberSelect.required = false;
                    }
                }
            }

            // Check customer by phone number
            function checkCustomerByPhone(phone) {
                if (!phone || phone.length < 10) {
                    hideRecentOrders();
                    setNewOrderMode();
                    return;
                }

                console.log('Checking customer with phone:', phone);

                // Show loading state
                showPhoneFeedback('Checking customer...', 'info');

                fetch('{{ route('check.customer.by.phone') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            phone: phone
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Customer check response:', data);

                        if (data.exists && data.customer) {
                            // Auto-fill customer name
                            customerNameField.value = data.customer.name || '';
                            customerNameInput.value = data.customer.name || '';

                            showPhoneFeedback('Customer found! Name auto-filled.', 'success');

                            // Fetch recent orders for this customer
                            fetchRecentOrders(data.customer.id);
                        } else {
                            // Clear customer name for new customer
                            customerNameField.value = '';
                            customerNameInput.value = '';
                            showPhoneFeedback('New customer. Please enter name.', 'info');
                            hideRecentOrders();
                            setNewOrderMode();
                        }
                    })
                    .catch(error => {
                        console.error('Error checking customer:', error);
                        showPhoneFeedback('Error checking customer. Please try again.', 'error');
                        hideRecentOrders();
                        setNewOrderMode();
                    });
            }

            // Fetch recent orders for customer
            function fetchRecentOrders(customerId) {
                if (!customerId) {
                    hideRecentOrders();
                    setNewOrderMode();
                    return;
                }

                console.log('Fetching recent orders for customer:', customerId);

                fetch(`/api/customers/${customerId}/recent-orders`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Recent orders received:', data);
                        displayRecentOrders(data);

                        // Check if there are incomplete orders and set update mode
                        if (data && data.length > 0) {
                            // For simplicity, we'll update the first incomplete order
                            const incompleteOrder = data.find(order =>
                                order.status === 'pending' || order.status === 'confirmed' || order.status ===
                                'accepted'
                            );

                            if (incompleteOrder) {
                                setUpdateMode(incompleteOrder.id);
                            } else {
                                setNewOrderMode();
                            }
                        } else {
                            setNewOrderMode();
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching recent orders:', error);
                        hideRecentOrders();
                        setNewOrderMode();
                    });
            }

            // Display recent orders
            function displayRecentOrders(orders) {
                createRecentOrdersContainer();

                if (!orders || orders.length === 0) {
                    recentOrdersContainer.innerHTML =
                        '<div class="text-center text-muted p-3">No recent orders found</div>';
                    recentOrdersContainer.style.display = 'block';
                    recentOrdersTotal = 0;
                    updateRecentOrdersTotalDisplay();
                    return;
                }

                let html = `
            <div class="recent-orders-header">
                <h6><i class="fas fa-history me-2"></i>Recent Orders</h6>
                <span class="recent-orders-count">${orders.length} orders</span>
            </div>
        `;

                recentOrdersTotal = 0;

                orders.forEach(order => {
                    const statusClass = getStatusClass(order.status);
                    const orderTime = new Date(order.order_time).toLocaleString();
                    const orderTotal = order.grand_total || order.calculated_total || 0;
                    recentOrdersTotal += orderTotal;

                    html += `
                <div class="order-item">
                    <div class="order-header">
                        <span class="order-id">Order #${order.id}</span>
                        <span class="order-status ${statusClass}">${order.status.toUpperCase()}</span>
                    </div>
                    <div class="order-time">
                        <i class="fas fa-clock me-1"></i>${orderTime}
                    </div>
                    <div class="order-items">
                        ${order.items && order.items.length > 0 
                            ? order.items.map(item => 
                                `${item.qty}x ${item.item_name} ${item.variation_name ? '(' + item.variation_name + ')' : ''}`
                              ).join(', ')
                            : 'No items'
                        }
                    </div>
                    <div class="order-total">
                        Total: Rs. ${orderTotal.toFixed(2)}
                    </div>
                </div>
            `;
                });

                recentOrdersContainer.innerHTML = html;
                recentOrdersContainer.style.display = 'block';
                updateRecentOrdersTotalDisplay();
            }

            // Update recent orders total display
            function updateRecentOrdersTotalDisplay() {
                if (recentOrdersTotal > 0) {
                    recentOrdersTotalValue.textContent = `Rs ${recentOrdersTotal.toFixed(2)}`;
                    recentOrdersTotalDisplay.style.display = 'block';
                    recentOrdersTotalInput.value = recentOrdersTotal;
                    updateCombinedTotal();
                } else {
                    recentOrdersTotalDisplay.style.display = 'none';
                    combinedTotalDisplay.style.display = 'none';
                    recentOrdersTotalInput.value = 0;
                }
            }

            // Update combined total display
            function updateCombinedTotal() {
                const currentOrderTotal = parseFloat(cartTotal.textContent.replace('Rs ', '')) || 0;
                const combinedTotal = currentOrderTotal + recentOrdersTotal;

                combinedTotalValue.textContent = `Rs ${combinedTotal.toFixed(2)}`;
                combinedTotalDisplay.style.display = 'block';
            }

            // Create recent orders container if it doesn't exist
            function createRecentOrdersContainer() {
                if (!recentOrdersContainer) {
                    recentOrdersContainer = document.createElement('div');
                    recentOrdersContainer.className = 'recent-orders';
                    recentOrdersContainer.style.cssText = `
                max-height: 200px;
                overflow-y: auto;
                padding: 16px;
                background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
                border-radius: 12px;
                margin: 16px 0;
                border: 1px solid #e1e5ff;
                box-shadow: 0 2px 8px rgba(13, 110, 253, 0.08);
                display: none;
            `;

                    // Insert after customer name field
                    const customerNameGroup = customerNameField.closest('.form-group');
                    customerNameGroup.parentNode.insertBefore(recentOrdersContainer, customerNameGroup.nextSibling);
                }
            }

            // Hide recent orders
            function hideRecentOrders() {
                if (recentOrdersContainer) {
                    recentOrdersContainer.style.display = 'none';
                    recentOrdersContainer.innerHTML = '';
                }
                recentOrdersTotal = 0;
                updateRecentOrdersTotalDisplay();
            }

            // Set form to UPDATE mode - FIXED VERSION
            function setUpdateMode(orderId) {
                isUpdateMode = true;
                existingOrderId = orderId;

                // Update form action and method
                const checkoutForm = document.getElementById('checkout-form');

                // Store the original action for new orders
                if (!checkoutForm.dataset.originalAction) {
                    checkoutForm.dataset.originalAction = checkoutForm.action;
                }

                // Set update action
                checkoutForm.action = '{{ route('orders.menus.update') }}';

                // Create hidden input for order_id if it doesn't exist
                let orderIdInput = document.getElementById('order_id_input');
                if (!orderIdInput) {
                    orderIdInput = document.createElement('input');
                    orderIdInput.type = 'hidden';
                    orderIdInput.name = 'order_id';
                    orderIdInput.id = 'order_id_input';
                    checkoutForm.appendChild(orderIdInput);
                }
                orderIdInput.value = orderId;

                // Update UI text
                const checkoutBtn = checkoutForm.querySelector('button[type="submit"]');
                checkoutBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i> Update Order';
                checkoutBtn.classList.remove('checkout-btn');
                checkoutBtn.classList.add('btn', 'btn-warning');

                // Show update mode notification
                showNotification('UPDATE MODE: Adding items to existing order #' + orderId, 'warning');

                console.log('Switched to UPDATE mode for order:', orderId);
                console.log('Form action set to:', checkoutForm.action);
            }

            // Set form to NEW ORDER mode - FIXED VERSION
            function setNewOrderMode() {
                isUpdateMode = false;
                existingOrderId = null;

                // Reset form action and method
                const checkoutForm = document.getElementById('checkout-form');

                // Restore original action for new orders
                if (checkoutForm.dataset.originalAction) {
                    checkoutForm.action = checkoutForm.dataset.originalAction;
                } else {
                    checkoutForm.action = '{{ route('orders.menus.store') }}';
                }

                // Remove order_id input if exists
                const orderIdInput = document.getElementById('order_id_input');
                if (orderIdInput) {
                    orderIdInput.remove();
                }

                // Update UI text
                const checkoutBtn = checkoutForm.querySelector('button[type="submit"]');
                checkoutBtn.innerHTML = 'Place Order';
                checkoutBtn.classList.remove('btn-warning');
                checkoutBtn.classList.add('checkout-btn');

                console.log('Switched to NEW ORDER mode');
                console.log('Form action set to:', checkoutForm.action);
            }

            // Helper function to get status class
            function getStatusClass(status) {
                const statusMap = {
                    'pending': 'status-pending',
                    'confirmed': 'status-preparing',
                    'preparing': 'status-preparing',
                    'ready': 'status-ready',
                    'completed': 'status-completed',
                    'delivered': 'status-completed'
                };
                return statusMap[status] || 'status-pending';
            }

            // Show phone feedback message
            function showPhoneFeedback(message, type) {
                // Remove existing feedback
                const existingFeedback = document.getElementById('phone-feedback');
                if (existingFeedback) {
                    existingFeedback.remove();
                }

                const feedback = document.createElement('div');
                feedback.id = 'phone-feedback';
                feedback.style.cssText = `
            font-size: 0.85rem;
            margin-top: 0.5rem;
            padding: 0.5rem;
            border-radius: 6px;
        `;

                const colors = {
                    info: {
                        bg: '#e3f2fd',
                        text: '#1565c0',
                        icon: 'fa-info-circle'
                    },
                    success: {
                        bg: '#e8f5e8',
                        text: '#2e7d32',
                        icon: 'fa-check-circle'
                    },
                    error: {
                        bg: '#ffebee',
                        text: '#c62828',
                        icon: 'fa-exclamation-triangle'
                    },
                    warning: {
                        bg: '#fff3cd',
                        text: '#856404',
                        icon: 'fa-exclamation-triangle'
                    }
                };

                const color = colors[type] || colors.info;
                feedback.style.backgroundColor = color.bg;
                feedback.style.color = color.text;

                feedback.innerHTML = `
            <i class="fas ${color.icon} me-2"></i>
            ${message}
        `;

                customerPhoneField.parentNode.appendChild(feedback);

                // Auto-remove after 5 seconds
                setTimeout(() => {
                    if (feedback.parentNode) {
                        feedback.remove();
                    }
                }, 5000);
            }

            // Debounce function for phone input
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Order type change handler
            document.querySelectorAll('input[name="orderType"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const selectedType = this.value;
                    handleOrderTypeChange(selectedType);
                });
            });

            // Office selection handler
            officeSelect.addEventListener('change', function() {
                officeIdInput.value = this.value;
            });

            // Table number selection handler
            tableNumberSelect.addEventListener('change', function() {
                tableNumberInput.value = this.value;
            });

            // Phone input handler with debounce
            const debouncedCheckCustomer = debounce(checkCustomerByPhone, 800);
            customerPhoneField.addEventListener('input', function() {
                const phone = this.value.trim();
                customerPhoneInput.value = phone;

                if (phone.length >= 10) {
                    debouncedCheckCustomer(phone);
                } else {
                    hideRecentOrders();
                    setNewOrderMode();
                    showPhoneFeedback('Enter phone number to check customer', 'info');
                }
            });

            // Customer name input handler
            customerNameField.addEventListener('input', function() {
                customerNameInput.value = this.value;
            });

            // Initialize order type and offices
            function initializeOrderType() {
                const selectedType = document.querySelector('input[name="orderType"]:checked').value;
                handleOrderTypeChange(selectedType);

                // Make sure dine-in field is visible
                if (selectedType === 'dineIn') {
                    dineInField.classList.add('show');
                }
            }

            // Initialize on page load
            initializeOrderType();
            populateOffices();

            // Quantity controls for card items
            document.querySelectorAll('.qty-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const input = document.getElementById(`qty-${id}`);
                    let value = parseInt(input.value);

                    if (this.classList.contains('plus')) {
                        value++;
                    } else if (this.classList.contains('minus') && value > 1) {
                        value--;
                    }

                    input.value = value;
                });
            });

            // Add to cart from card
            document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    const price = parseFloat(this.dataset.price);
                    const qtyInput = document.getElementById(`qty-${id}`);
                    const qty = Math.max(1, parseInt(qtyInput.value || 1, 10));

                    // Check if item has variants
                    const variants = variantsData[id];
                    if (variants && variants.length > 0) {
                        // If item has variants, open modal instead of adding directly
                        const card = this.closest('.menu-item');
                        const description = card.querySelector('.card-text').textContent;
                        const imageSrc = card.querySelector('.item-image').src;
                        openModal(id, name, price, description, imageSrc);
                    } else {
                        // If no variants, add directly to cart
                        addToCart(id, name, price, qty);

                        // Reset quantity input to 1
                        qtyInput.value = 1;

                        // Show notification
                        showNotification(`${name} added to cart!`);
                    }
                });
            });

            // Open modal when clicking on item image or card
            document.querySelectorAll('.item-image, .menu-item .card').forEach(element => {
                element.addEventListener('click', function(e) {
                    // Don't open modal if clicking on quantity controls or add button
                    if (e.target.closest('.qty-control') || e.target.closest('.add-to-cart-btn')) {
                        return;
                    }

                    const card = this.closest('.menu-item');
                    const id = this.dataset.id || card.querySelector('.add-to-cart-btn').dataset.id;
                    const name = card.querySelector('.card-title').textContent;
                    const price = parseFloat(card.querySelector('.add-to-cart-btn').dataset.price);
                    const description = card.querySelector('.card-text').textContent;
                    const imageSrc = card.querySelector('.item-image').src;

                    openModal(id, name, price, description, imageSrc);
                });
            });

            // Open modal function
            function openModal(id, name, price, description, imageSrc) {
                currentModalItem = {
                    id,
                    name,
                    basePrice: price, // Store base price separately
                    price, // This will be updated if variants exist
                    description,
                    imageSrc
                };

                // Set modal content
                modalImage.src = imageSrc;
                modalItemName.textContent = name;
                modalItemPrice.textContent = `Rs ${price.toFixed(2)}`;
                modalItemDescription.textContent = description;
                modalQtyInput.value = 1;

                // Check if item has variants
                const variants = variantsData[id];
                if (variants && variants.length > 0) {
                    variantsSection.style.display = 'block';
                    renderVariants(variants);

                    // Set initial price to first variant's price
                    if (variants.length > 0) {
                        const firstVariantPrice = variants[0].price;
                        currentModalItem.price = firstVariantPrice;
                        modalItemPrice.textContent = `Rs ${firstVariantPrice.toFixed(2)}`;
                    }
                } else {
                    variantsSection.style.display = 'none';
                }

                // Show modal
                modalOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            // Render variants in modal
            function renderVariants(variants) {
                variantsContainer.innerHTML = '';

                variants.forEach((variant, index) => {
                    const variantOption = document.createElement('div');
                    variantOption.className = 'variant-option';

                    const inputId = `variant-${variant.id}`;

                    variantOption.innerHTML = `
                <input type="radio" id="${inputId}" name="variant" value="${variant.id}" data-price="${variant.price}" ${index === 0 ? 'checked' : ''}>
                <label for="${inputId}">${variant.name} (Rs ${variant.price.toFixed(2)})</label>
            `;

                    variantsContainer.appendChild(variantOption);
                });

                // Add event listeners to variant options
                document.querySelectorAll('input[name="variant"]').forEach(radio => {
                    radio.addEventListener('change', function() {
                        updateModalPrice();
                    });
                });

                updateModalPrice();
            }

            // Update price in modal based on selected variant
            function updateModalPrice() {
                const selectedVariant = document.querySelector('input[name="variant"]:checked');
                if (selectedVariant) {
                    const variantPrice = parseFloat(selectedVariant.dataset.price);
                    // Use only the variant price, don't add to base price
                    currentModalItem.price = variantPrice;
                    modalItemPrice.textContent = `Rs ${variantPrice.toFixed(2)}`;
                }
            }

            // Close modal
            closeModalBtn.addEventListener('click', closeModal);
            modalOverlay.addEventListener('click', function(e) {
                if (e.target === modalOverlay) {
                    closeModal();
                }
            });

            // Modal quantity controls
            modalMinusBtn.addEventListener('click', function() {
                let value = parseInt(modalQtyInput.value);
                if (value > 1) {
                    value--;
                    modalQtyInput.value = value;
                }
            });

            modalPlusBtn.addEventListener('click', function() {
                let value = parseInt(modalQtyInput.value);
                value++;
                modalQtyInput.value = value;
            });

            // Add to cart from modal
            modalAddToCartBtn.addEventListener('click', function() {
                if (!currentModalItem) return;

                const qty = parseInt(modalQtyInput.value);
                let price = currentModalItem.price;
                let name = currentModalItem.name;
                let variantId = null;

                // Check if a variant is selected
                const selectedVariant = document.querySelector('input[name="variant"]:checked');
                if (selectedVariant) {
                    const variantPrice = parseFloat(selectedVariant.dataset.price);
                    price = variantPrice;
                    name += ` (${selectedVariant.nextElementSibling.textContent.split(' (Rs')[0]})`;
                    variantId = selectedVariant.value;
                }

                // Include variant ID in cart item if present
                addToCart(currentModalItem.id, name, price, qty, variantId);
                showNotification(`${name} added to cart!`);
                closeModal();
            });

            function closeModal() {
                modalOverlay.classList.remove('active');
                document.body.style.overflow = 'auto';
                currentModalItem = null;
            }

            // Add to cart function (updated to include variantId)
            function addToCart(id, name, price, qty, variantId = null) {
                const cartItemId = variantId ? `${id}-${variantId}` : id.toString();
                const existing = cart.find(c => c.cartItemId === cartItemId);

                if (existing) {
                    existing.qty += qty;
                } else {
                    cart.push({
                        id: id,
                        name: name,
                        price: price,
                        qty: qty,
                        variantId: variantId,
                        cartItemId: cartItemId
                    });
                }

                renderCart();
            }

            function calculateOrder() {
                if (cart.length === 0) {
                    return {
                        subtotal: 0,
                        discount: 0,
                        vatAmount: 0,
                        total: 0
                    };
                }

                // Calculate subtotal
                const subtotal = cart.reduce((sum, item) => sum + (item.qty * parseFloat(item.price)), 0);

                // Calculate discount
                const discountType = document.getElementById('discountType').value;
                const discountValue = parseFloat(document.getElementById('discountValue').value) || 0;
                let discount = 0;

                if (discountType === 'flat') {
                    discount = Math.min(discountValue, subtotal);
                } else {
                    discount = subtotal * (discountValue / 100);
                }

                // Calculate VAT
                const vatRate = parseFloat(document.getElementById('vat').value) || 0;
                const vatAmount = (subtotal - discount) * (vatRate / 100);

                // Calculate total
                const total = subtotal - discount + vatAmount;

                return {
                    subtotal,
                    discount,
                    vatAmount,
                    total
                };
            }

            function renderCart() {
                if (cart.length === 0) {
                    cartItemsList.innerHTML = `
                <div class="empty-cart">
                    <div class="empty-cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <p>Your cart is empty</p>
                    <small class="text-muted">Add items to create an order</small>
                </div>`;
                    cartCount.textContent = '0 items';
                    cartSubtotal.textContent = 'Rs 0.00';
                    cartDiscount.textContent = 'Rs 0.00';
                    cartVat.textContent = 'Rs 0.00';
                    cartTotal.textContent = 'Rs 0.00';
                    orderItemsInput.value = '';

                    // Hide combined total if cart is empty
                    combinedTotalDisplay.style.display = 'none';
                    return;
                }

                const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
                cartCount.textContent = totalItems + (totalItems === 1 ? ' item' : ' items');

                const {
                    subtotal,
                    discount,
                    vatAmount,
                    total
                } = calculateOrder();

                cartItemsList.innerHTML = '';

                cart.forEach((item, idx) => {
                    const itemTotal = item.qty * parseFloat(item.price);

                    const div = document.createElement('div');
                    div.className = 'cart-item';
                    div.innerHTML = `
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <div class="cart-item-name">${item.name}</div>
                        <div class="cart-item-details">Rs ${parseFloat(item.price).toFixed(2)} × ${item.qty} = Rs ${itemTotal.toFixed(2)}</div>
                    </div>
                    <div class="cart-controls">
                        <button class="cart-qty-btn minus" data-idx="${idx}">-</button>
                        <span class="mx-1" style="font-size: 0.8rem;">${item.qty}</span>
                        <button class="cart-qty-btn plus" data-idx="${idx}">+</button>
                        <button class="remove-btn ms-2" data-idx="${idx}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
                    cartItemsList.appendChild(div);
                });

                cartSubtotal.textContent = 'Rs ' + subtotal.toFixed(2);
                cartDiscount.textContent = 'Rs ' + discount.toFixed(2);
                cartVat.textContent = 'Rs ' + vatAmount.toFixed(2);
                cartTotal.textContent = 'Rs ' + total.toFixed(2);

                // Update order items input with ALL necessary information including PRICE
                orderItemsInput.value = JSON.stringify(cart.map(i => ({
                    menu_id: i.id,
                    name: i.name,
                    price: i.price,
                    qty: i.qty,
                    variation_id: i.variantId,
                    item_total: (i.price * i.qty)
                })));

                // Update combined total if recent orders exist
                if (recentOrdersTotal > 0) {
                    updateCombinedTotal();
                }
            }

            // Cart item controls
            cartItemsList.addEventListener('click', function(e) {
                const idx = e.target.closest('button')?.dataset.idx;
                if (typeof idx === 'undefined') return;

                if (e.target.closest('.remove-btn')) {
                    cart.splice(idx, 1);
                    renderCart();
                    showNotification('Item removed from cart');
                } else if (e.target.closest('.minus')) {
                    if (cart[idx].qty > 1) {
                        cart[idx].qty--;
                        renderCart();
                    }
                } else if (e.target.closest('.plus')) {
                    cart[idx].qty++;
                    renderCart();
                }
            });

            // Category filter
            document.querySelectorAll('.category-nav .nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelectorAll('.category-nav .nav-link').forEach(l => l.classList
                        .remove('active'));
                    this.classList.add('active');

                    const categoryId = this.dataset.category;
                    document.querySelectorAll('.menu-item').forEach(card => {
                        if (categoryId === 'all' || card.dataset.category === categoryId) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });

            // Search functionality
            document.getElementById('search-input').addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                document.querySelectorAll('.menu-item').forEach(card => {
                    const name = card.dataset.name || '';
                    if (name.includes(query)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });

            // Discount controls
            document.getElementById('discountType').addEventListener('change', function() {
                discountTypeInput.value = this.value;
                renderCart();
            });

            document.getElementById('discountValue').addEventListener('input', function() {
                discountValueInput.value = this.value;
                renderCart();
            });

            // VAT control
            document.getElementById('vat').addEventListener('input', function() {
                const vatValue = parseFloat(this.value) || 0;
                vatInput.value = vatValue;
                vatPercent.textContent = vatValue;
                renderCart();
            });

            // Notification function
            function showNotification(message, type = 'success') {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `alert alert-${type} position-fixed`;
                notification.style.cssText = 'top: 20px; right: 20px; z-index: 1050; min-width: 250px;';
                notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas ${type === 'warning' ? 'fa-exclamation-triangle' : 'fa-check-circle'} me-2"></i>
                <span>${message}</span>
            </div>
        `;

                document.body.appendChild(notification);

                // Remove after 3 seconds
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 3000);
            }

            // Form submission handler - FIXED VERSION
            document.getElementById('checkout-form').addEventListener('submit', function(e) {
                e.preventDefault();

                // Get current form action to determine if we're in update mode
                const isUpdate = this.action.includes('update');
                console.log('Form submission - Update mode:', isUpdate);
                console.log('Form action:', this.action);

                // Validate based on order type
                const orderType = orderTypeInput.value;

                if (orderType === 'office') {
                    // For office orders, only validate office selection
                    if (!officeIdInput.value) {
                        showNotification('Please select an office for office orders', 'error');
                        return false;
                    }
                } else {
                    // For dineIn and takeAway, validate customer details
                    if (!customerNameField.value || !customerPhoneField.value) {
                        showNotification('Please enter customer name and phone number', 'error');
                        return false;
                    }

                    // Additional validation for dineIn
                    if (orderType === 'dineIn' && !tableNumberInput.value) {
                        showNotification('Please enter table number for dine-in orders', 'error');
                        return false;
                    }
                }

                // Validate cart has items
                if (cart.length === 0) {
                    showNotification('Please add at least one item to the cart', 'error');
                    return false;
                }

                // Prepare form data
                const formData = new FormData(this);

                // For AJAX submission
                fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const successMessage = isUpdate ? 'Order updated successfully!' :
                                'Order placed successfully!';
                            showNotification(successMessage, 'success');

                            // Redirect to orders page
                            setTimeout(() => {
                                window.location.href = '{{ route('orders.index') }}';
                            }, 1500);
                        } else {
                            showNotification(data.message || 'An error occurred', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('An error occurred while processing your order', 'error');
                    });
            });

            // Initialize
            renderCart();
            setNewOrderMode(); // Start in new order mode
        })();
    </script>

@endsection
