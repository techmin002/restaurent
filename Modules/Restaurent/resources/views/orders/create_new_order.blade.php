@extends('setting::layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title', 'New Order Request')
@section('content')
     <style>
        /* New Order Specific Styles */
        .new-order-wrapper {
            background-color: #f5f7fb;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        /* Menu Items Styling */
        .new-order-menu-item .card {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            height: 100%;
            background: white;
            position: relative;
            cursor: pointer;
        }

        .new-order-menu-item .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .new-order-menu-item .card-img-container {
            position: relative;
            overflow: hidden;
            height: 160px;
        }

        .new-order-menu-item img {
            object-fit: cover;
            width: 100%;
            height: 100%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .new-order-menu-item .card:hover img {
            transform: scale(1.08);
        }

        .new-order-category-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            color: #2d3748;
            z-index: 2;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .new-order-price-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #e53e3e, #c53030);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            z-index: 2;
            box-shadow: 0 4px 10px rgba(229, 62, 62, 0.3);
        }

        .new-order-card-body {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            height: calc(100% - 160px);
        }

        .new-order-card-title {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
            font-size: 1rem;
            line-height: 1.4;
        }

        .new-order-card-text {
            color: #718096;
            font-size: 0.85rem;
            line-height: 1.5;
            flex-grow: 1;
            margin-bottom: 0.75rem;
        }

        .new-order-card-footer {
            background: transparent;
            border-top: 1px solid #edf2f7;
            padding: 0.75rem 1rem;
        }

        .new-order-qty-control {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .new-order-qty-btn {
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
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.8rem;
        }

        .new-order-qty-btn:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
        }

        .new-order-qty-input {
            width: 42px;
            text-align: center;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 4px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .new-order-add-to-cart-btn {
            background: linear-gradient(135deg, #2d3748, #4a5568);
            border: none;
            border-radius: 8px;
            padding: 6px 12px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: white;
        }

        .new-order-add-to-cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(45, 55, 72, 0.3);
            color: white;
        }

        /* Category Navigation */
        .new-order-category-nav-container {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            margin-bottom: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .new-order-category-scroll {
            display: flex;
            overflow-x: auto;
            padding-bottom: 5px;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 transparent;
            gap: 8px;
        }

        .new-order-category-scroll::-webkit-scrollbar {
            height: 6px;
        }

        .new-order-category-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .new-order-category-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }

        .new-order-category-nav {
            display: flex;
            gap: 8px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .new-order-category-nav .nav-link {
            padding: 12px 20px;
            border-radius: 10px;
            color: #4a5568;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            white-space: nowrap;
            font-size: 0.9rem;
            border: 2px solid #e2e8f0;
            background: #f7fafc;
            text-decoration: none;
            display: block;
        }

        .new-order-category-nav .nav-link.active {
            background: linear-gradient(135deg, #2d3748, #4a5568);
            color: white;
            border-color: #2d3748;
            box-shadow: 0 4px 12px rgba(45, 55, 72, 0.2);
        }

        .new-order-category-nav .nav-link:not(.active):hover {
            background: #edf2f7;
            border-color: #cbd5e0;
            transform: translateY(-2px);
        }

        /* Search Bar */
        .new-order-search-container {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .new-order-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            z-index: 3;
        }

        .new-order-search-input {
            padding-left: 40px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            height: 46px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .new-order-search-input:focus {
            border-color: #2d3748;
            box-shadow: 0 0 0 3px rgba(45, 55, 72, 0.1);
        }

        /* Cart Sidebar */
        .new-order-cart-sidebar {
            position: sticky;
            top: 90px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: none;
        }

        .new-order-cart-header {
            background: linear-gradient(135deg, #2d3748, #4a5568);
            color: white;
            padding: 1.25rem;
        }

        .new-order-cart-item {
            border-bottom: 1px solid #edf2f7;
            padding: 12px 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .new-order-cart-item:hover {
            background: #f7fafc;
        }

        .new-order-cart-item:last-child {
            border-bottom: none;
        }

        .new-order-cart-item-name {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 4px;
            font-size: 0.9rem;
        }

        .new-order-cart-item-details {
            color: #718096;
            font-size: 0.8rem;
        }

        .new-order-cart-controls {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .new-order-cart-qty-btn {
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
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .new-order-cart-qty-btn:hover {
            background: #edf2f7;
        }

        .new-order-remove-btn {
            color: #e53e3e;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.8rem;
        }

        .new-order-remove-btn:hover {
            background: #fed7d7;
        }

        .new-order-empty-cart {
            color: #a0aec0;
            text-align: center;
            padding: 2rem 1rem;
        }

        .new-order-empty-cart-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .new-order-cart-footer {
            background: #f7fafc;
            padding: 1.25rem;
            border-top: 1px solid #edf2f7;
        }

        .new-order-total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
        }

        .new-order-checkout-btn {
            background: linear-gradient(135deg, #38a169, #2f855a);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 1rem;
            color: white;
        }

        .new-order-checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(56, 161, 105, 0.3);
            color: white;
        }

        /* Order Details Section */
        .new-order-details-card {
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: none;
            margin-bottom: 1.5rem;
        }

        .new-order-details-header {
            background: #f7fafc;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #edf2f7;
            font-weight: 600;
            color: #2d3748;
        }

        .new-order-details-body {
            padding: 1.25rem;
        }

        .new-order-form-group {
            margin-bottom: 1rem;
        }

        .new-order-form-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .new-order-radio-group {
            display: flex;
            gap: 1rem;
        }

        .new-order-radio-option {
            flex: 1;
        }

        .new-order-radio-option input {
            display: none;
        }

        .new-order-radio-option label {
            display: block;
            padding: 10px;
            text-align: center;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .new-order-radio-option input:checked+label {
            background: #2d3748;
            color: white;
            border-color: #2d3748;
        }

        .new-order-radio-option label:hover {
            border-color: #2d3748;
        }

        .new-order-discount-controls {
            display: flex;
            gap: 10px;
        }

        .new-order-discount-type {
            flex: 0 0 100px;
        }

        .new-order-discount-value {
            flex: 1;
        }

        .new-order-section-title {
            color: #2d3748;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            padding-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .new-order-section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: #2d3748;
            border-radius: 3px;
        }

        /* Order Type Specific Fields */
        .new-order-type-field {
            display: none;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .new-order-type-field.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        /* Customer Details Section */
        .new-order-customer-details {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #e9ecef;
        }

        /* Modal Styles */
        .new-order-modal-overlay {
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
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .new-order-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .new-order-item-modal {
            background: white;
            border-radius: 16px;
            width: 90%;
            max-width: 900px;
            max-height: 90vh;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transform: translateY(20px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        .new-order-modal-overlay.active .new-order-item-modal {
            transform: translateY(0);
        }

        .new-order-modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #edf2f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .new-order-modal-title {
            font-weight: 700;
            color: #2d3748;
            margin: 0;
            font-size: 1.5rem;
        }

        .new-order-close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #a0aec0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .new-order-close-modal:hover {
            background: #f7fafc;
            color: #4a5568;
        }

        .new-order-modal-body {
            padding: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            flex-grow: 1;
        }

        .new-order-modal-content {
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: auto;
        }

        .new-order-modal-image-section {
            position: relative;
            height: 300px;
            overflow: hidden;
        }

        .new-order-modal-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .new-order-modal-details {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .new-order-modal-item-name {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .new-order-modal-item-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #e53e3e;
            margin-bottom: 1rem;
        }

        .new-order-modal-item-description {
            color: #718096;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }

        .new-order-variants-section {
            margin-bottom: 1.5rem;
        }

        .new-order-variants-title {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.75rem;
            font-size: 1rem;
        }

        .new-order-variants-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .new-order-variant-option {
            flex: 1;
            min-width: 120px;
        }

        .new-order-variant-option input {
            display: none;
        }

        .new-order-variant-option label {
            display: block;
            padding: 10px 15px;
            text-align: center;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            font-size: 0.9rem;
            background: white;
        }

        .new-order-variant-option input:checked+label {
            background: #2d3748;
            color: white;
            border-color: #2d3748;
        }

        .new-order-variant-option label:hover {
            border-color: #2d3748;
        }

        .new-order-modal-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 1.5rem;
            border-top: 1px solid #edf2f7;
        }

        .new-order-modal-qty-control {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .new-order-modal-qty-btn {
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
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1rem;
        }

        .new-order-modal-qty-btn:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
        }

        .new-order-modal-qty-input {
            width: 60px;
            text-align: center;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px;
            font-weight: 600;
            font-size: 1rem;
        }

        .new-order-modal-add-btn {
            background: linear-gradient(135deg, #2d3748, #4a5568);
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1rem;
            color: white;
        }

        .new-order-modal-add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(45, 55, 72, 0.3);
            color: white;
        }

        /* Recent Orders Styling */
        .new-order-recent-orders {
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

        .new-order-recent-orders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e1e5ff;
        }

        .new-order-recent-orders-count {
            background: #2d3748;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .new-order-recent-orders .order-item {
            padding: 12px;
            border-radius: 10px;
            background: white;
            margin-bottom: 10px;
            border-left: 4px solid #2d3748;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .new-order-recent-orders .order-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .new-order-recent-orders .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .new-order-recent-orders .order-status {
            font-size: 0.7rem;
            padding: 4px 8px;
            border-radius: 20px;
            font-weight: 600;
        }

        .new-order-recent-orders .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .new-order-recent-orders .status-preparing {
            background: #cce7ff;
            color: #004085;
        }

        .new-order-recent-orders .status-ready {
            background: #d1ecf1;
            color: #0c5460;
        }

        .new-order-recent-orders .status-completed {
            background: #d1f7e4;
            color: #0f5132;
        }

        /* Recent Orders Total Display */
        .new-order-recent-orders-total {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-radius: 10px;
            padding: 12px 16px;
            margin: 12px 0;
            border: 1px solid #90caf9;
            box-shadow: 0 2px 6px rgba(33, 150, 243, 0.15);
            display: none;
        }

        .new-order-recent-orders-total-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .new-order-recent-orders-total-label {
            font-weight: 600;
            color: #1565c0;
            font-size: 0.9rem;
        }

        .new-order-recent-orders-total-value {
            font-weight: 700;
            color: #0d47a1;
            font-size: 1rem;
        }

        .new-order-recent-orders-total-note {
            font-size: 0.75rem;
            color: #1976d2;
            font-style: italic;
        }

        /* Combined Total Display */
        .new-order-combined-total {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            border-radius: 10px;
            padding: 12px 16px;
            margin: 12px 0;
            border: 1px solid #81c784;
            box-shadow: 0 2px 6px rgba(76, 175, 80, 0.15);
            display: none;
        }

        .new-order-combined-total-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .new-order-combined-total-label {
            font-weight: 600;
            color: #2e7d32;
            font-size: 0.9rem;
        }

        .new-order-combined-total-value {
            font-weight: 700;
            color: #1b5e20;
            font-size: 1.1rem;
        }

        .new-order-combined-total-note {
            font-size: 0.75rem;
            color: #388e3c;
            font-style: italic;
        }

        /* Update Mode Button */
        .new-order-update-btn {
            background: linear-gradient(135deg, #dd6b20, #b45309) !important;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 1rem;
            color: white;
        }

        .new-order-update-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(221, 107, 32, 0.3);
            color: white;
        }

        /* Table Status Indicators */
        .new-order-table-status {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .new-order-table-status-available {
            background-color: #38a169;
        }

        .new-order-table-status-occupied {
            background-color: #e53e3e;
        }

        .new-order-table-status-reserved {
            background-color: #dd6b20;
        }

        @media (min-width: 768px) {
            .new-order-modal-content {
                flex-direction: row;
            }

            .new-order-modal-image-section {
                flex: 0 0 45%;
                height: auto;
            }

            .new-order-modal-details {
                flex: 0 0 55%;
                overflow-y: auto;
            }
        }

        @media (max-width: 768px) {
            .new-order-menu-item {
                margin-bottom: 1.5rem;
            }

            .new-order-category-nav .nav-link {
                margin-bottom: 8px;
            }

            .new-order-radio-group {
                flex-direction: column;
                gap: 0.5rem;
            }

            .new-order-modal-actions {
                flex-direction: column;
                gap: 1rem;
            }

            .new-order-modal-qty-control {
                width: 100%;
                justify-content: center;
            }

            .new-order-modal-add-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="content-wrapper new-order-wrapper">
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
                        <div class="new-order-search-container">
                            <i class="fas fa-search new-order-search-icon" style="left:16px;"></i>
                            <input id="new-order-search-input" class="form-control new-order-search-input" type="search"
                                placeholder="Search menu items..." aria-label="Search" style="padding-left:48px;">
                        </div>

                        <!-- Categories Navigation -->
                        <div class="new-order-category-nav-container">
                            <h5 class="new-order-section-title">Categories</h5>
                            <div class="new-order-category-scroll">
                                <ul class="new-order-category-nav">
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
                        <div class="row" id="new-order-menu-items">
                            @foreach ($menus as $item)
                                <div class="col-xl-3 col-lg-4 col-md-6 mb-4 new-order-menu-item"
                                    data-category="{{ $item->category_id }}" data-name="{{ strtolower($item->name) }}">
                                    <div class="card h-100">
                                        <div class="new-order-card-img-container">
                                            <img src="{{ asset('upload/images/menu/' . $item['image']) }}"
                                                alt="{{ $item->name }}" class="new-order-item-image" data-id="{{ $item->id }}">
                                            <span class="new-order-category-badge">{{ $item->category_name }}</span>
                                            <span class="new-order-price-badge">Rs {{ number_format($item->price, 2) }}</span>
                                        </div>
                                        <div class="new-order-card-body" style="height:auto; padding-bottom:0.4rem;">
                                            <h5 class="new-order-card-title" style="margin-bottom:0.25rem;">{{ $item->name }}</h5>
                                            <p class="new-order-card-text" style="margin-bottom:0.15rem;">
                                                {{ Str::limit($item->description, 80) }}</p>
                                        </div>
                                        <div class="new-order-card-footer" style="padding-top:0.35rem;">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="new-order-qty-control d-flex align-items-center mb-2">
                                                    <button class="new-order-qty-btn minus" data-id="{{ $item->id }}">-</button>
                                                    <input type="number" min="1" value="1" class="new-order-qty-input"
                                                        id="new-order-qty-{{ $item->id }}"
                                                        style="width:64px;padding:6px 8px;text-align:center;">
                                                    <button class="new-order-qty-btn plus" data-id="{{ $item->id }}">+</button>
                                                </div>

                                                <div class="w-100 d-flex justify-content-center">
                                                    <button type="button" class="btn btn-primary new-order-add-to-cart-btn"
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
                        <div class="card new-order-details-card">
                            <div class="new-order-details-header">
                                Order Details
                            </div>
                            <div class="new-order-details-body">
                                <!-- Order Type -->
                                <div class="new-order-form-group">
                                    <label class="new-order-form-label">Order Type</label>
                                    <div class="new-order-radio-group">
                                        <div class="new-order-radio-option">
                                            <input type="radio" id="dineIn" name="orderType" value="dine_in" checked>
                                            <label for="dineIn">Dine In</label>
                                        </div>
                                        <div class="new-order-radio-option">
                                            <input type="radio" id="takeAway" name="orderType" value="take_away">
                                            <label for="takeAway">Take Away</label>
                                        </div>
                                        <div class="new-order-radio-option">
                                            <input type="radio" id="office" name="orderType" value="office">
                                            <label for="office">Office</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dine In Table Number Field -->
                                <div class="new-order-form-group new-order-type-field show" id="dineInField">
                                    <label for="tableNumber" class="new-order-form-label">Select Table</label>
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
                                <div class="new-order-form-group new-order-type-field" id="officeField">
                                    <label for="officeSelect" class="new-order-form-label">Select Office</label>
                                    <select class="form-control" id="officeSelect" name="office_id">
                                        <option value="">-- Select Office --</option>
                                        <!-- Offices will be populated dynamically -->
                                    </select>
                                </div>

                                <!-- Customer Details Section - Hidden for Office orders -->
                                <div class="new-order-customer-details" id="customerDetails">
                                    <h6><i class="fas fa-user me-2"></i>Customer Details</h6>

                                    <!-- Customer Contact Number -->
                                    <div class="new-order-form-group">
                                        <label for="customerPhone" class="new-order-form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="customerPhone" name="customer_phone"
                                            placeholder="Enter phone number">
                                    </div>

                                    <!-- Customer Name -->
                                    <div class="new-order-form-group">
                                        <label for="customerName" class="new-order-form-label">Customer Name</label>
                                        <input type="text" class="form-control" id="customerName" name="customer_name"
                                            placeholder="Enter customer name">
                                    </div>
                                </div>

                                <!-- Discount Section -->
                                <div class="new-order-form-group">
                                    <label class="new-order-form-label">Discount</label>
                                    <div class="new-order-discount-controls">
                                        <select class="form-select new-order-discount-type" id="discountType" name="discount_type">
                                            <option value="flat">Flat (Rs)</option>
                                            <option value="percent">Percentage (%)</option>
                                        </select>
                                        <input type="number" class="form-control new-order-discount-value" id="discountValue"
                                            name="discount_value" placeholder="0.00" min="0" step="0.01">
                                    </div>
                                </div>

                                <!-- VAT Section -->
                                <div class="new-order-form-group">
                                    <label for="vat" class="new-order-form-label">VAT (%)</label>
                                    <input type="number" class="form-control" id="vat" name="vat" value="13"
                                        min="0" max="100" step="0.01">
                                </div>
                            </div>
                        </div>

                        <!-- Cart Sidebar -->
                        <div id="new-order-cart-sidebar" class="card new-order-cart-sidebar">
                            <div class="new-order-cart-header">
                                <h5 class="card-title mb-1">Current Order</h5>
                                <small id="new-order-cart-count">0 items</small>
                            </div>
                            <div class="card-body p-0">
                                <div id="new-order-cart-items-list" style="max-height: 300px; overflow-y: auto;">
                                    <div class="new-order-empty-cart">
                                        <div class="new-order-empty-cart-icon">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>
                                        <p>Your cart is empty</p>
                                        <small class="text-muted">Add items to create an order</small>
                                    </div>
                                </div>
                            </div>

                            <div class="new-order-cart-footer">
                                <div class="new-order-total-row">
                                    <span>Subtotal</span>
                                    <span id="new-order-cart-subtotal">Rs 0.00</span>
                                </div>
                                <div class="new-order-total-row">
                                    <span>Discount</span>
                                    <span id="new-order-cart-discount">Rs 0.00</span>
                                </div>
                                <div class="new-order-total-row">
                                    <span>VAT (<span id="new-order-vat-percent">13</span>%)</span>
                                    <span id="new-order-cart-vat">Rs 0.00</span>
                                </div>
                                <div class="new-order-total-row mb-2" style="border-top: 1px solid #e2e8f0; padding-top: 8px;">
                                    <strong>Total</strong>
                                    <strong id="new-order-cart-total">Rs 0.00</strong>
                                </div>

                                <!-- Recent Orders Total Display -->
                                <div class="new-order-recent-orders-total" id="new-order-recent-orders-total">
                                    <div class="new-order-recent-orders-total-header">
                                        <span class="new-order-recent-orders-total-label">Recent Orders Total</span>
                                        <span class="new-order-recent-orders-total-value" id="new-order-recent-orders-total-value">Rs
                                            0.00</span>
                                    </div>
                                    <div class="new-order-recent-orders-total-note">Total from previous orders</div>
                                </div>

                                <!-- Combined Total Display -->
                                <div class="new-order-combined-total" id="new-order-combined-total">
                                    <div class="new-order-combined-total-header">
                                        <span class="new-order-combined-total-label">Combined Total</span>
                                        <span class="new-order-combined-total-value" id="new-order-combined-total-value">Rs 0.00</span>
                                    </div>
                                    <div class="new-order-combined-total-note">Current order + Recent orders</div>
                                </div>

                                <form id="new-order-checkout-form" action="{{ route('orders.menus.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="order_items" id="new-order-order-items-input">
                                    <input type="hidden" name="order_type" id="new-order-order-type-input" value="dine_in">
                                    <input type="hidden" name="customer_name" id="new-order-customer-name-input">
                                    <input type="hidden" name="customer_phone" id="new-order-customer-phone-input">
                                    <input type="hidden" name="office_id" id="new-order-office-id-input">
                                    <input type="hidden" name="table_number" id="new-order-table-number-input">
                                    <input type="hidden" name="discount_type" id="new-order-discount-type-input" value="flat">
                                    <input type="hidden" name="discount_value" id="new-order-discount-value-input" value="0">
                                    <input type="hidden" name="vat" id="new-order-vat-input" value="13">
                                    <input type="hidden" name="recent_orders_total" id="new-order-recent-orders-total-input" value="0">
                                    <button type="submit" class="btn new-order-checkout-btn">Place Order</button>
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
    <div class="new-order-modal-overlay" id="new-order-item-modal">
        <div class="new-order-item-modal">
            <div class="new-order-modal-header">
                <h3 class="new-order-modal-title">Item Details</h3>
                <button class="new-order-close-modal" id="new-order-close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="new-order-modal-body">
                <div class="new-order-modal-content">
                    <div class="new-order-modal-image-section">
                        <img src="" alt="Item Image" class="new-order-modal-image" id="new-order-modal-image">
                    </div>
                    <div class="new-order-modal-details">
                        <h2 class="new-order-modal-item-name" id="new-order-modal-item-name"></h2>
                        <div class="new-order-modal-item-price" id="new-order-modal-item-price"></div>
                        <p class="new-order-modal-item-description" id="new-order-modal-item-description"></p>

                        <!-- Variants Section -->
                        <div class="new-order-variants-section" id="new-order-variants-section" style="display: none;">
                            <h4 class="new-order-variants-title">Choose Variant</h4>
                            <div class="new-order-variants-container" id="new-order-variants-container">
                                <!-- Variants will be dynamically added here -->
                            </div>
                        </div>

                        <div class="new-order-modal-actions">
                            <div class="new-order-modal-qty-control">
                                <button class="new-order-modal-qty-btn" id="new-order-modal-minus">-</button>
                                <input type="number" min="1" value="1" class="new-order-modal-qty-input" id="new-order-modal-qty">
                                <button class="new-order-modal-qty-btn" id="new-order-modal-plus">+</button>
                            </div>
                            <button class="new-order-modal-add-btn" id="new-order-modal-add-to-cart">
                                <i class="fas fa-cart-plus"></i> Add Item!
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // New Order JavaScript Module
        const NewOrderApp = (function() {
            // DOM Elements
            const elements = {
                menuContainer: document.getElementById('new-order-menu-items'),
                cartItemsList: document.getElementById('new-order-cart-items-list'),
                cartCount: document.getElementById('new-order-cart-count'),
                cartSubtotal: document.getElementById('new-order-cart-subtotal'),
                cartDiscount: document.getElementById('new-order-cart-discount'),
                cartVat: document.getElementById('new-order-cart-vat'),
                cartTotal: document.getElementById('new-order-cart-total'),
                vatPercent: document.getElementById('new-order-vat-percent'),
                orderItemsInput: document.getElementById('new-order-order-items-input'),
                orderTypeInput: document.getElementById('new-order-order-type-input'),
                customerNameInput: document.getElementById('new-order-customer-name-input'),
                customerPhoneInput: document.getElementById('new-order-customer-phone-input'),
                officeIdInput: document.getElementById('new-order-office-id-input'),
                tableNumberInput: document.getElementById('new-order-table-number-input'),
                discountTypeInput: document.getElementById('new-order-discount-type-input'),
                discountValueInput: document.getElementById('new-order-discount-value-input'),
                vatInput: document.getElementById('new-order-vat-input'),
                recentOrdersTotalInput: document.getElementById('new-order-recent-orders-total-input'),
                customerNameField: document.getElementById('customerName'),
                customerPhoneField: document.getElementById('customerPhone'),
                customerDetailsSection: document.getElementById('customerDetails'),
                dineInField: document.getElementById('dineInField'),
                officeField: document.getElementById('officeField'),
                tableNumberSelect: document.getElementById('tableNumber'),
                officeSelect: document.getElementById('officeSelect'),
                recentOrdersTotalValue: document.getElementById('new-order-recent-orders-total-value'),
                combinedTotalValue: document.getElementById('new-order-combined-total-value'),
                modalOverlay: document.getElementById('new-order-item-modal'),
                closeModalBtn: document.getElementById('new-order-close-modal'),
                modalImage: document.getElementById('new-order-modal-image'),
                modalItemName: document.getElementById('new-order-modal-item-name'),
                modalItemPrice: document.getElementById('new-order-modal-item-price'),
                modalItemDescription: document.getElementById('new-order-modal-item-description'),
                variantsSection: document.getElementById('new-order-variants-section'),
                variantsContainer: document.getElementById('new-order-variants-container'),
                modalMinusBtn: document.getElementById('new-order-modal-minus'),
                modalPlusBtn: document.getElementById('new-order-modal-plus'),
                modalQtyInput: document.getElementById('new-order-modal-qty'),
                modalAddToCartBtn: document.getElementById('new-order-modal-add-to-cart')
            };

            // State
            const state = {
                cart: [],
                currentModalItem: null,
                existingOrderId: null,
                isUpdateMode: false,
                recentOrdersTotal: 0,
                recentOrdersContainer: null
            };

            // Variants data from backend
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

            // Initialize
            function init() {
                setupEventListeners();
                populateOffices();
                initializeOrderType();
                renderCart();
                setNewOrderMode();
            }

            // Setup Event Listeners
            function setupEventListeners() {
                // Order type change
                document.querySelectorAll('input[name="orderType"]').forEach(radio => {
                    radio.addEventListener('change', handleOrderTypeChange);
                });

                // Office selection
                elements.officeSelect.addEventListener('change', () => {
                    elements.officeIdInput.value = elements.officeSelect.value;
                });

                // Table number selection
                elements.tableNumberSelect.addEventListener('change', () => {
                    elements.tableNumberInput.value = elements.tableNumberSelect.value;
                });

                // Phone input with debounce
                const debouncedCheckCustomer = debounce(checkCustomerByPhone, 800);
                elements.customerPhoneField.addEventListener('input', function() {
                    const phone = this.value.trim();
                    elements.customerPhoneInput.value = phone;

                    if (phone.length >= 10) {
                        debouncedCheckCustomer(phone);
                    } else {
                        hideRecentOrders();
                        setNewOrderMode();
                        showPhoneFeedback('Enter phone number to check customer', 'info');
                    }
                });

                // Customer name input
                elements.customerNameField.addEventListener('input', function() {
                    elements.customerNameInput.value = this.value;
                });

                // Quantity controls for card items
                document.querySelectorAll('.new-order-qty-btn').forEach(btn => {
                    btn.addEventListener('click', handleCardQtyClick);
                });

                // Add to cart from card
                document.querySelectorAll('.new-order-add-to-cart-btn').forEach(btn => {
                    btn.addEventListener('click', handleAddToCartFromCard);
                });

                // Open modal when clicking on item
                document.querySelectorAll('.new-order-item-image, .new-order-menu-item .card').forEach(element => {
                    element.addEventListener('click', handleOpenModalClick);
                });

                // Modal controls
                elements.closeModalBtn.addEventListener('click', closeModal);
                elements.modalOverlay.addEventListener('click', (e) => {
                    if (e.target === elements.modalOverlay) closeModal();
                });
                elements.modalMinusBtn.addEventListener('click', handleModalMinus);
                elements.modalPlusBtn.addEventListener('click', handleModalPlus);
                elements.modalAddToCartBtn.addEventListener('click', handleModalAddToCart);

                // Cart item controls
                elements.cartItemsList.addEventListener('click', handleCartItemClick);

                // Category filter
                document.querySelectorAll('.new-order-category-nav .nav-link').forEach(link => {
                    link.addEventListener('click', handleCategoryFilter);
                });

                // Search functionality
                document.getElementById('new-order-search-input').addEventListener('input', handleSearch);

                // Discount controls
                document.getElementById('discountType').addEventListener('change', () => {
                    elements.discountTypeInput.value = document.getElementById('discountType').value;
                    renderCart();
                });

                document.getElementById('discountValue').addEventListener('input', () => {
                    elements.discountValueInput.value = document.getElementById('discountValue').value;
                    renderCart();
                });

                // VAT control
                document.getElementById('vat').addEventListener('input', () => {
                    const vatValue = parseFloat(document.getElementById('vat').value) || 0;
                    elements.vatInput.value = vatValue;
                    elements.vatPercent.textContent = vatValue;
                    renderCart();
                });

                // Form submission
                document.getElementById('new-order-checkout-form').addEventListener('submit', handleFormSubmit);
            }

            // Populate offices dropdown
            function populateOffices() {
                elements.officeSelect.innerHTML = '<option value="">-- Select Office --</option>';
                
                if (officesData && officesData.length > 0) {
                    officesData.forEach(office => {
                        const option = document.createElement('option');
                        option.value = office.id;
                        option.textContent = office.name;
                        elements.officeSelect.appendChild(option);
                    });
                }
            }

            // Handle order type change
            function handleOrderTypeChange(e) {
                const selectedType = e.target.value;
                elements.orderTypeInput.value = selectedType;

                // Hide all order type specific fields
                elements.dineInField.classList.remove('show');
                elements.officeField.classList.remove('show');

                // Show/hide customer details section
                if (selectedType === 'office') {
                    elements.customerDetailsSection.style.display = 'none';
                    elements.officeField.classList.add('show');
                    elements.tableNumberSelect.required = false;
                    elements.tableNumberInput.value = '';
                } else {
                    elements.customerDetailsSection.style.display = 'block';
                    elements.officeIdInput.value = '';

                    if (selectedType === 'dine_in') {
                        elements.dineInField.classList.add('show');
                        elements.tableNumberSelect.required = true;
                    } else {
                        elements.tableNumberSelect.required = false;
                        elements.tableNumberInput.value = '';
                    }
                }
            }

            // Initialize order type
            function initializeOrderType() {
                const selectedType = document.querySelector('input[name="orderType"]:checked').value;
                elements.orderTypeInput.value = selectedType;
                
                if (selectedType === 'dine_in') {
                    elements.dineInField.classList.add('show');
                }
            }

            // Check customer by phone number
            async function checkCustomerByPhone(phone) {
                if (!phone || phone.length < 10) {
                    hideRecentOrders();
                    setNewOrderMode();
                    return;
                }

                showPhoneFeedback('Checking customer...', 'info');

                try {
                    const response = await fetch('{{ route('check.customer.by.phone') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ phone })
                    });

                    const data = await response.json();

                    if (data.exists && data.customer) {
                        elements.customerNameField.value = data.customer.name || '';
                        elements.customerNameInput.value = data.customer.name || '';
                        showPhoneFeedback('Customer found! Name auto-filled.', 'success');
                        fetchRecentOrders(data.customer.id);
                    } else {
                        elements.customerNameField.value = '';
                        elements.customerNameInput.value = '';
                        showPhoneFeedback('New customer. Please enter name.', 'info');
                        hideRecentOrders();
                        setNewOrderMode();
                    }
                } catch (error) {
                    console.error('Error checking customer:', error);
                    showPhoneFeedback('Error checking customer. Please try again.', 'error');
                    hideRecentOrders();
                    setNewOrderMode();
                }
            }

            // Fetch recent orders for customer
            async function fetchRecentOrders(customerId) {
                if (!customerId) {
                    hideRecentOrders();
                    setNewOrderMode();
                    return;
                }

                try {
                    const response = await fetch(`/api/customers/${customerId}/recent-orders`);
                    const data = await response.json();
                    displayRecentOrders(data);

                    // Check for incomplete orders
                    if (data && data.length > 0) {
                        const incompleteOrder = data.find(order =>
                            order.status === 'pending' || order.status === 'confirmed' || order.status === 'accepted'
                        );

                        if (incompleteOrder) {
                            setUpdateMode(incompleteOrder.id);
                        } else {
                            setNewOrderMode();
                        }
                    } else {
                        setNewOrderMode();
                    }
                } catch (error) {
                    console.error('Error fetching recent orders:', error);
                    hideRecentOrders();
                    setNewOrderMode();
                }
            }

            // Display recent orders
            function displayRecentOrders(orders) {
                createRecentOrdersContainer();

                if (!orders || orders.length === 0) {
                    state.recentOrdersContainer.innerHTML = '<div class="text-center text-muted p-3">No recent orders found</div>';
                    state.recentOrdersContainer.style.display = 'block';
                    state.recentOrdersTotal = 0;
                    updateRecentOrdersTotalDisplay();
                    return;
                }

                let html = `
            <div class="new-order-recent-orders-header">
                <h6><i class="fas fa-history me-2"></i>Recent Orders</h6>
                <span class="new-order-recent-orders-count">${orders.length} orders</span>
            </div>
        `;

                state.recentOrdersTotal = 0;

                orders.forEach(order => {
                    const statusClass = getStatusClass(order.status);
                    const orderTime = new Date(order.order_time).toLocaleString();
                    const orderTotal = order.grand_total || order.calculated_total || 0;
                    state.recentOrdersTotal += orderTotal;

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

                state.recentOrdersContainer.innerHTML = html;
                state.recentOrdersContainer.style.display = 'block';
                updateRecentOrdersTotalDisplay();
            }

            // Create recent orders container
            function createRecentOrdersContainer() {
                if (!state.recentOrdersContainer) {
                    state.recentOrdersContainer = document.createElement('div');
                    state.recentOrdersContainer.className = 'new-order-recent-orders';
                    
                    const customerNameGroup = elements.customerNameField.closest('.new-order-form-group');
                    customerNameGroup.parentNode.insertBefore(state.recentOrdersContainer, customerNameGroup.nextSibling);
                }
            }

            // Hide recent orders
            function hideRecentOrders() {
                if (state.recentOrdersContainer) {
                    state.recentOrdersContainer.style.display = 'none';
                    state.recentOrdersContainer.innerHTML = '';
                }
                state.recentOrdersTotal = 0;
                updateRecentOrdersTotalDisplay();
            }

            // Update recent orders total display
            function updateRecentOrdersTotalDisplay() {
                const recentOrdersTotalDisplay = document.getElementById('new-order-recent-orders-total');
                const combinedTotalDisplay = document.getElementById('new-order-combined-total');

                if (state.recentOrdersTotal > 0) {
                    elements.recentOrdersTotalValue.textContent = `Rs ${state.recentOrdersTotal.toFixed(2)}`;
                    recentOrdersTotalDisplay.style.display = 'block';
                    elements.recentOrdersTotalInput.value = state.recentOrdersTotal;
                    updateCombinedTotal();
                } else {
                    recentOrdersTotalDisplay.style.display = 'none';
                    combinedTotalDisplay.style.display = 'none';
                    elements.recentOrdersTotalInput.value = 0;
                }
            }

            // Update combined total display
            function updateCombinedTotal() {
                const combinedTotalDisplay = document.getElementById('new-order-combined-total');
                const currentOrderTotal = parseFloat(elements.cartTotal.textContent.replace('Rs ', '')) || 0;
                const combinedTotal = currentOrderTotal + state.recentOrdersTotal;

                elements.combinedTotalValue.textContent = `Rs ${combinedTotal.toFixed(2)}`;
                combinedTotalDisplay.style.display = 'block';
            }

            // Set form to UPDATE mode
            function setUpdateMode(orderId) {
                state.isUpdateMode = true;
                state.existingOrderId = orderId;

                const checkoutForm = document.getElementById('new-order-checkout-form');

                // Store original action
                if (!checkoutForm.dataset.originalAction) {
                    checkoutForm.dataset.originalAction = checkoutForm.action;
                }

                // Set update action
                checkoutForm.action = '{{ route('orders.menus.update') }}';

                // Add order_id input
                let orderIdInput = document.getElementById('new-order-order-id-input');
                if (!orderIdInput) {
                    orderIdInput = document.createElement('input');
                    orderIdInput.type = 'hidden';
                    orderIdInput.name = 'order_id';
                    orderIdInput.id = 'new-order-order-id-input';
                    checkoutForm.appendChild(orderIdInput);
                }
                orderIdInput.value = orderId;

                // Update UI
                const checkoutBtn = checkoutForm.querySelector('button[type="submit"]');
                checkoutBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i> Update Order';
                checkoutBtn.classList.remove('new-order-checkout-btn');
                checkoutBtn.classList.add('new-order-update-btn');

                showNotification('UPDATE MODE: Adding items to existing order #' + orderId, 'warning');
            }

            // Set form to NEW ORDER mode
            function setNewOrderMode() {
                state.isUpdateMode = false;
                state.existingOrderId = null;

                const checkoutForm = document.getElementById('new-order-checkout-form');

                // Restore original action
                if (checkoutForm.dataset.originalAction) {
                    checkoutForm.action = checkoutForm.dataset.originalAction;
                }

                // Remove order_id input
                const orderIdInput = document.getElementById('new-order-order-id-input');
                if (orderIdInput) orderIdInput.remove();

                // Update UI
                const checkoutBtn = checkoutForm.querySelector('button[type="submit"]');
                checkoutBtn.innerHTML = 'Place Order';
                checkoutBtn.classList.remove('new-order-update-btn');
                checkoutBtn.classList.add('new-order-checkout-btn');
            }

            // Handle card quantity click
            function handleCardQtyClick(e) {
                const btn = e.target.closest('.new-order-qty-btn');
                if (!btn) return;

                const id = btn.dataset.id;
                const input = document.getElementById(`new-order-qty-${id}`);
                let value = parseInt(input.value);

                if (btn.classList.contains('plus')) {
                    value++;
                } else if (btn.classList.contains('minus') && value > 1) {
                    value--;
                }

                input.value = value;
            }

            // Handle add to cart from card
            function handleAddToCartFromCard(e) {
                const btn = e.target.closest('.new-order-add-to-cart-btn');
                if (!btn) return;

                const id = btn.dataset.id;
                const name = btn.dataset.name;
                const price = parseFloat(btn.dataset.price);
                const qtyInput = document.getElementById(`new-order-qty-${id}`);
                const qty = Math.max(1, parseInt(qtyInput.value || 1, 10));

                // Check if item has variants
                const variants = variantsData[id];
                if (variants && variants.length > 0) {
                    const card = btn.closest('.new-order-menu-item');
                    const description = card.querySelector('.new-order-card-text').textContent;
                    const imageSrc = card.querySelector('.new-order-item-image').src;
                    openModal(id, name, price, description, imageSrc);
                } else {
                    addToCart(id, name, price, qty);
                    qtyInput.value = 1;
                    showNotification(`${name} added to cart!`);
                }
            }

            // Handle open modal click
            function handleOpenModalClick(e) {
                if (e.target.closest('.new-order-qty-control') || e.target.closest('.new-order-add-to-cart-btn')) {
                    return;
                }

                const card = e.target.closest('.new-order-menu-item');
                const btn = card.querySelector('.new-order-add-to-cart-btn');
                const id = btn.dataset.id;
                const name = card.querySelector('.new-order-card-title').textContent;
                const price = parseFloat(btn.dataset.price);
                const description = card.querySelector('.new-order-card-text').textContent;
                const imageSrc = card.querySelector('.new-order-item-image').src;

                openModal(id, name, price, description, imageSrc);
            }

            // Open modal
            function openModal(id, name, price, description, imageSrc) {
                state.currentModalItem = {
                    id,
                    name,
                    basePrice: price,
                    price,
                    description,
                    imageSrc
                };

                elements.modalImage.src = imageSrc;
                elements.modalItemName.textContent = name;
                elements.modalItemPrice.textContent = `Rs ${price.toFixed(2)}`;
                elements.modalItemDescription.textContent = description;
                elements.modalQtyInput.value = 1;

                const variants = variantsData[id];
                if (variants && variants.length > 0) {
                    elements.variantsSection.style.display = 'block';
                    renderVariants(variants);

                    if (variants.length > 0) {
                        const firstVariantPrice = variants[0].price;
                        state.currentModalItem.price = firstVariantPrice;
                        elements.modalItemPrice.textContent = `Rs ${firstVariantPrice.toFixed(2)}`;
                    }
                } else {
                    elements.variantsSection.style.display = 'none';
                }

                elements.modalOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            // Render variants in modal
            function renderVariants(variants) {
                elements.variantsContainer.innerHTML = '';

                variants.forEach((variant, index) => {
                    const variantOption = document.createElement('div');
                    variantOption.className = 'new-order-variant-option';
                    const inputId = `new-order-variant-${variant.id}`;

                    variantOption.innerHTML = `
                <input type="radio" id="${inputId}" name="new-order-variant" value="${variant.id}" data-price="${variant.price}" ${index === 0 ? 'checked' : ''}>
                <label for="${inputId}">${variant.name} (Rs ${variant.price.toFixed(2)})</label>
            `;

                    elements.variantsContainer.appendChild(variantOption);
                });

                document.querySelectorAll('input[name="new-order-variant"]').forEach(radio => {
                    radio.addEventListener('change', updateModalPrice);
                });

                updateModalPrice();
            }

            // Update modal price
            function updateModalPrice() {
                const selectedVariant = document.querySelector('input[name="new-order-variant"]:checked');
                if (selectedVariant) {
                    const variantPrice = parseFloat(selectedVariant.dataset.price);
                    state.currentModalItem.price = variantPrice;
                    elements.modalItemPrice.textContent = `Rs ${variantPrice.toFixed(2)}`;
                }
            }

            // Close modal
            function closeModal() {
                elements.modalOverlay.classList.remove('active');
                document.body.style.overflow = 'auto';
                state.currentModalItem = null;
            }

            // Handle modal minus
            function handleModalMinus() {
                let value = parseInt(elements.modalQtyInput.value);
                if (value > 1) {
                    value--;
                    elements.modalQtyInput.value = value;
                }
            }

            // Handle modal plus
            function handleModalPlus() {
                let value = parseInt(elements.modalQtyInput.value);
                value++;
                elements.modalQtyInput.value = value;
            }

            // Handle modal add to cart
            function handleModalAddToCart() {
                if (!state.currentModalItem) return;

                const qty = parseInt(elements.modalQtyInput.value);
                let price = state.currentModalItem.price;
                let name = state.currentModalItem.name;
                let variantId = null;

                const selectedVariant = document.querySelector('input[name="new-order-variant"]:checked');
                if (selectedVariant) {
                    const variantPrice = parseFloat(selectedVariant.dataset.price);
                    price = variantPrice;
                    name += ` (${selectedVariant.nextElementSibling.textContent.split(' (Rs')[0]})`;
                    variantId = selectedVariant.value;
                }

                addToCart(state.currentModalItem.id, name, price, qty, variantId);
                showNotification(`${name} added to cart!`);
                closeModal();
            }

            // Add to cart
            function addToCart(id, name, price, qty, variantId = null) {
                const cartItemId = variantId ? `${id}-${variantId}` : id.toString();
                const existing = state.cart.find(c => c.cartItemId === cartItemId);

                if (existing) {
                    existing.qty += qty;
                } else {
                    state.cart.push({
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

            // Calculate order totals
            function calculateOrder() {
                if (state.cart.length === 0) {
                    return {
                        subtotal: 0,
                        discount: 0,
                        vatAmount: 0,
                        total: 0
                    };
                }

                const subtotal = state.cart.reduce((sum, item) => sum + (item.qty * parseFloat(item.price)), 0);
                const discountType = document.getElementById('discountType').value;
                const discountValue = parseFloat(document.getElementById('discountValue').value) || 0;
                let discount = 0;

                if (discountType === 'flat') {
                    discount = Math.min(discountValue, subtotal);
                } else {
                    discount = subtotal * (discountValue / 100);
                }

                const vatRate = parseFloat(document.getElementById('vat').value) || 0;
                const vatAmount = (subtotal - discount) * (vatRate / 100);
                const total = subtotal - discount + vatAmount;

                return { subtotal, discount, vatAmount, total };
            }

            // Render cart
            function renderCart() {
                if (state.cart.length === 0) {
                    elements.cartItemsList.innerHTML = `
                <div class="new-order-empty-cart">
                    <div class="new-order-empty-cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <p>Your cart is empty</p>
                    <small class="text-muted">Add items to create an order</small>
                </div>`;
                    elements.cartCount.textContent = '0 items';
                    elements.cartSubtotal.textContent = 'Rs 0.00';
                    elements.cartDiscount.textContent = 'Rs 0.00';
                    elements.cartVat.textContent = 'Rs 0.00';
                    elements.cartTotal.textContent = 'Rs 0.00';
                    elements.orderItemsInput.value = '';

                    document.getElementById('new-order-combined-total').style.display = 'none';
                    return;
                }

                const totalItems = state.cart.reduce((sum, item) => sum + item.qty, 0);
                elements.cartCount.textContent = totalItems + (totalItems === 1 ? ' item' : ' items');

                const { subtotal, discount, vatAmount, total } = calculateOrder();

                elements.cartItemsList.innerHTML = '';

                state.cart.forEach((item, idx) => {
                    const itemTotal = item.qty * parseFloat(item.price);

                    const div = document.createElement('div');
                    div.className = 'new-order-cart-item';
                    div.innerHTML = `
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <div class="new-order-cart-item-name">${item.name}</div>
                        <div class="new-order-cart-item-details">Rs ${parseFloat(item.price).toFixed(2)} × ${item.qty} = Rs ${itemTotal.toFixed(2)}</div>
                    </div>
                    <div class="new-order-cart-controls">
                        <button class="new-order-cart-qty-btn minus" data-idx="${idx}">-</button>
                        <span class="mx-1" style="font-size: 0.8rem;">${item.qty}</span>
                        <button class="new-order-cart-qty-btn plus" data-idx="${idx}">+</button>
                        <button class="new-order-remove-btn ms-2" data-idx="${idx}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
                    elements.cartItemsList.appendChild(div);
                });

                elements.cartSubtotal.textContent = 'Rs ' + subtotal.toFixed(2);
                elements.cartDiscount.textContent = 'Rs ' + discount.toFixed(2);
                elements.cartVat.textContent = 'Rs ' + vatAmount.toFixed(2);
                elements.cartTotal.textContent = 'Rs ' + total.toFixed(2);

                elements.orderItemsInput.value = JSON.stringify(state.cart.map(i => ({
                    menu_id: i.id,
                    name: i.name,
                    price: i.price,
                    qty: i.qty,
                    variation_id: i.variantId,
                    item_total: (i.price * i.qty)
                })));

                if (state.recentOrdersTotal > 0) {
                    updateCombinedTotal();
                }
            }

            // Handle cart item click
            function handleCartItemClick(e) {
                const btn = e.target.closest('button');
                if (!btn) return;

                const idx = btn.dataset.idx;
                if (typeof idx === 'undefined') return;

                if (btn.closest('.new-order-remove-btn')) {
                    state.cart.splice(idx, 1);
                    renderCart();
                    showNotification('Item removed from cart');
                } else if (btn.closest('.minus')) {
                    if (state.cart[idx].qty > 1) {
                        state.cart[idx].qty--;
                        renderCart();
                    }
                } else if (btn.closest('.plus')) {
                    state.cart[idx].qty++;
                    renderCart();
                }
            }

            // Handle category filter
            function handleCategoryFilter(e) {
                e.preventDefault();
                const link = e.target.closest('.nav-link');
                if (!link) return;

                document.querySelectorAll('.new-order-category-nav .nav-link').forEach(l => l.classList.remove('active'));
                link.classList.add('active');

                const categoryId = link.dataset.category;
                document.querySelectorAll('.new-order-menu-item').forEach(card => {
                    card.style.display = (categoryId === 'all' || card.dataset.category === categoryId) ? 'block' : 'none';
                });
            }

            // Handle search
            function handleSearch(e) {
                const query = e.target.value.trim().toLowerCase();
                document.querySelectorAll('.new-order-menu-item').forEach(card => {
                    const name = card.dataset.name || '';
                    card.style.display = name.includes(query) ? 'block' : 'none';
                });
            }

            // Handle form submission
            async function handleFormSubmit(e) {
                e.preventDefault();
                const form = e.target;

                // Validate cart
                if (state.cart.length === 0) {
                    showNotification('Please add at least one item to the cart', 'error');
                    return false;
                }

                // Validate based on order type
                const orderType = elements.orderTypeInput.value;

                if (orderType === 'office') {
                    if (!elements.officeIdInput.value) {
                        showNotification('Please select an office for office orders', 'error');
                        return false;
                    }
                    elements.customerNameInput.value = '';
                    elements.customerPhoneInput.value = '';
                    elements.tableNumberInput.value = '';
                } else {
                    if (!elements.customerNameField.value.trim() || !elements.customerPhoneField.value.trim()) {
                        showNotification('Please enter customer name and phone number', 'error');
                        return false;
                    }

                    if (orderType === 'dine_in' && !elements.tableNumberInput.value) {
                        showNotification('Please select a table for dine-in orders', 'error');
                        return false;
                    }
                    elements.officeIdInput.value = '';
                }

                try {
                    const formData = new FormData(form);
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        const successMessage = state.isUpdateMode ? 'Order updated successfully!' : 'Order placed successfully!';
                        showNotification(successMessage, 'success');

                        setTimeout(() => {
                            window.location.href = '{{ route('orders.index') }}';
                        }, 1500);
                    } else {
                        showNotification(data.message || 'An error occurred', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('An error occurred while processing your order', 'error');
                }
            }

            // Helper function: debounce
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

            // Helper function: get status class
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

            // Helper function: show phone feedback
            function showPhoneFeedback(message, type) {
                const existingFeedback = document.getElementById('new-order-phone-feedback');
                if (existingFeedback) existingFeedback.remove();

                const feedback = document.createElement('div');
                feedback.id = 'new-order-phone-feedback';
                feedback.style.cssText = 'font-size: 0.85rem; margin-top: 0.5rem; padding: 0.5rem; border-radius: 6px;';

                const colors = {
                    info: { bg: '#e3f2fd', text: '#1565c0', icon: 'fa-info-circle' },
                    success: { bg: '#e8f5e8', text: '#2e7d32', icon: 'fa-check-circle' },
                    error: { bg: '#ffebee', text: '#c62828', icon: 'fa-exclamation-triangle' },
                    warning: { bg: '#fff3cd', text: '#856404', icon: 'fa-exclamation-triangle' }
                };

                const color = colors[type] || colors.info;
                feedback.style.backgroundColor = color.bg;
                feedback.style.color = color.text;
                feedback.innerHTML = `<i class="fas ${color.icon} me-2"></i>${message}`;

                elements.customerPhoneField.parentNode.appendChild(feedback);

                setTimeout(() => {
                    if (feedback.parentNode) feedback.remove();
                }, 5000);
            }

            // Helper function: show notification
            function showNotification(message, type = 'success') {
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

                setTimeout(() => {
                    if (notification.parentNode) notification.remove();
                }, 3000);
            }

            // Public API
            return {
                init: init
            };
        })();

        // Initialize the application when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            NewOrderApp.init();
        });
    </script>

@endsection