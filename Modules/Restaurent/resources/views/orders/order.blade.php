<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $profile = \Modules\Setting\Entities\CompanyProfile::first();
    @endphp
    <title>@yield('title') || {{ $profile->company_name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        :root {
            --primary: #0d6efd;
            --primary-dark: #0b5ed7;
            --primary-light: #3d8bfd;
            --secondary: #6c757d;
            --success: #198754;
            --info: #0dcaf0;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #212529;
            --card-bg: #ffffff;
            --body-bg: #f4f6f9;
            --sidebar-bg: #ffffff;
            --text-primary: #2d3748;
            --text-secondary: #4a5568;
            --text-muted: #718096;
            --border-color: #e2e8f0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --border-radius: 12px;
            --border-radius-sm: 8px;
            --gradient-primary: linear-gradient(135deg, var(--primary), var(--primary-dark));
            --gradient-success: linear-gradient(135deg, var(--success), #157347);
            --gradient-danger: linear-gradient(135deg, var(--danger), #c82333);
        }

        * {
            box-sizing: border-box;
        }

        .status-accepted {
            background: rgba(255, 152, 0, 0.2);
            color: #ef6c00;
        }

        html,
        body {
            height: 100%;
            font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--body-bg);
            color: var(--text-primary);
            margin: 0;
            padding: 0;
            font-size: 14px;
            line-height: 1.5;
        }

        body {
            padding-bottom: 80px;
            /* Space for mobile bottom bar */
        }

        /* App Shell */
        .app-shell {
            padding: 16px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Top Navigation */
        .topnav {
            background: var(--gradient-primary);
            color: #fff;
            padding: 12px 16px;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
            box-shadow: var(--shadow);
        }

        .topnav .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
        }

        .topnav .logo {
            width: 40px;
            height: 40px;
            border-radius: var(--border-radius-sm);
            background: rgba(255, 255, 255, 0.9);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: var(--shadow);
        }

        .topnav .brand-text {
            flex: 1;
        }

        .topnav .brand-text div:first-child {
            font-weight: 700;
            font-size: 1rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .topnav .brand-text .small-muted {
            font-size: 0.75rem;
            opacity: 0.9;
        }

        .topnav .actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .topnav .actions .btn {
            padding: 6px 8px;
            font-size: 0.8rem;
        }

        /* Main Layout */
        .main {
            padding: 0;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .topbar>div:first-child {
            flex: 1;
            min-width: 200px;
        }

        .topbar h3 {
            font-size: 1.5rem;
            margin-bottom: 4px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .topbar .small-muted {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            background: var(--card-bg);
            margin-bottom: 16px;
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: var(--shadow-hover);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 16px;
        }

        .card-header-prim {
            background: var(--gradient-primary);
            color: #fff;
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
            padding: 12px 16px;
        }

        .card-body {
            padding: 16px;
        }

        .card-footer {
            background: transparent;
            border-top: 1px solid var(--border-color);
            padding: 12px 16px;
        }

        .small-muted {
            color: var(--text-muted);
            font-size: .85rem;
        }

        /* Order Container */
        .order-container {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* Menu Section */
        .menu-section {
            order: 2;
        }

        .sidebar-section {
            order: 1;
        }

        /* Search Bar - IMPROVED */
        .search-container {
            position: relative;
            margin-bottom: 1rem;
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            z-index: 3;
            pointer-events: none;
            /* Add this */
        }

        .search-input {
            padding-left: 48px !important;
            /* Increased from 48px to 50px */
            padding-right: 16px;
            border-radius: var(--border-radius-sm);
            border: 1px solid var(--border-color);
            height: 42px;
            font-size: 0.9rem;
            transition: var(--transition);
            width: 100%;
            box-sizing: border-box;
        }

        .search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
            padding-left: 50px !important;
            /* Maintain consistent padding on focus */
        }

        .search-input::placeholder {
            color: var(--text-muted);
            opacity: 0.8;
        }

        /* Categories Navigation */
        .category-nav-container {
            background: white;
            border-radius: var(--border-radius);
            padding: 1rem;
            box-shadow: var(--shadow);
            margin-bottom: 1rem;
            border: 1px solid var(--border-color);
        }

        .category-scroll {
            display: flex;
            overflow-x: auto;
            padding-bottom: 4px;
            scrollbar-width: none;
            -ms-overflow-style: none;
            gap: 6px;
        }

        .category-scroll::-webkit-scrollbar {
            display: none;
        }

        .category-nav {
            display: flex;
            gap: 6px;
            margin: 0;
            padding: 0;
            list-style: none;
            flex-wrap: nowrap;
        }

        .category-nav .nav-link {
            padding: 8px 12px;
            border-radius: var(--border-radius-sm);
            color: var(--text-secondary);
            font-weight: 600;
            transition: var(--transition);
            cursor: pointer;
            white-space: nowrap;
            font-size: 0.8rem;
            border: 1px solid var(--border-color);
            background: var(--light);
            text-decoration: none;
            display: block;
        }

        .category-nav .nav-link.active {
            background: var(--gradient-primary);
            color: white;
            border-color: var(--primary);
        }

        /* Menu Items Grid */
        .menu-items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 12px;
        }

        .menu-item .card {
            border: 0;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: var(--transition);
            overflow: hidden;
            background: white;
            height: 100%;
            cursor: pointer;
        }

        .menu-item .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .menu-item .card-img-container {
            position: relative;
            overflow: hidden;
            height: 120px;
        }

        .menu-item img {
            object-fit: cover;
            width: 100%;
            height: 100%;
            transition: var(--transition);
        }

        .menu-item .card:hover img {
            transform: scale(1.05);
        }

        .category-badge {
            position: absolute;
            top: 6px;
            left: 6px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.65rem;
            font-weight: 600;
            color: var(--text-primary);
            z-index: 1;
        }

        .price-badge {
            position: absolute;
            top: 6px;
            right: 6px;
            font-weight: 700;
            color: #fff;
            background: var(--gradient-danger);
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            z-index: 1;
        }

        .card-body {
            padding: 0.75rem;
        }

        .card-title {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
            font-size: 0.85rem;
            line-height: 1.3;
        }

        .card-text {
            color: var(--text-muted);
            font-size: 0.75rem;
            line-height: 1.4;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-footer {
            background: transparent;
            border-top: 1px solid var(--border-color);
            padding: 0.5rem 0.75rem;
        }

        .qty-control {
            display: flex;
            align-items: center;
            gap: 6px;
            justify-content: center;
            margin-bottom: 8px;
        }

        .qty-btn {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color);
            background: white;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.7rem;
        }

        .qty-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .qty-input {
            width: 36px;
            text-align: center;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            padding: 2px 4px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .add-to-cart-btn {
            background: var(--gradient-primary);
            border: none;
            border-radius: var(--border-radius-sm);
            padding: 6px 10px;
            font-weight: 600;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            font-size: 0.75rem;
            color: white;
            width: 100%;
        }

        .add-to-cart-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Customer Card */
        .customer-card {
            border-radius: var(--border-radius);
            overflow: hidden;
        }

        .customer-card .card-header {
            background: var(--gradient-primary);
            color: white;
            border: none;
        }

        .customer-card .card-body {
            padding: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
        }

        .form-control {
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            padding: 8px 12px;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .phone-input-group .form-control {
            font-size: 0.9rem;
        }

        /* Recent Orders */
        .recent-orders {
            max-height: 200px;
            overflow: auto;
            padding: 10px;
            background: var(--light);
            border-radius: var(--border-radius-sm);
            margin: 10px 0;
            display: none;
        }

        .recent-orders .order-item {
            padding: 8px;
            border-radius: var(--border-radius-sm);
            background: white;
            margin-bottom: 6px;
            border-left: 3px solid var(--primary);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .order-status {
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 600;
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.2);
            color: #856404;
        }

        .status-preparing {
            background: rgba(13, 110, 253, 0.2);
            color: var(--primary);
        }

        .status-ready {
            background: rgba(25, 135, 84, 0.2);
            color: var(--success);
        }

        .status-completed {
            background: rgba(108, 117, 125, 0.2);
            color: var(--secondary);
        }

        .order-time {
            font-size: 0.7rem;
        }

        .order-items {
            font-size: 0.75rem;
            margin-bottom: 4px;
        }

        .order-total {
            font-size: 0.75rem;
        }

        .order-location,
        .order-type {
            font-size: 0.7rem;
        }

        .order-type-badge {
            font-size: 0.65rem;
        }

        /* Cart Sidebar */
        .cart-sidebar {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            border: none;
            position: sticky;
            top: 16px;
        }

        .cart-header {
            background: var(--gradient-primary);
            color: white;
            padding: 1rem;
        }

        .cart-item {
            border-bottom: 1px solid var(--border-color);
            padding: 10px 12px;
            transition: var(--transition);
        }

        .cart-item:hover {
            background: rgba(0, 0, 0, 0.02);
        }

        .cart-item-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 2px;
            font-size: 0.85rem;
        }

        .cart-item-details {
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        .cart-controls {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 4px;
        }

        .cart-qty-btn {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color);
            background: white;
            font-size: 0.65rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .cart-qty-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .remove-btn {
            color: var(--danger);
            background: none;
            border: none;
            cursor: pointer;
            padding: 2px;
            border-radius: 4px;
            font-size: 0.7rem;
            transition: var(--transition);
        }

        .remove-btn:hover {
            background: rgba(220, 53, 69, 0.1);
        }

        .empty-cart {
            color: var(--text-muted);
            text-align: center;
            padding: 2rem 1rem;
        }

        .empty-cart-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            opacity: 0.5;
        }

        .cart-footer {
            background: var(--light);
            padding: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 0;
            font-size: 0.85rem;
        }

        .checkout-btn {
            background: var(--gradient-success);
            border: none;
            border-radius: var(--border-radius-sm);
            padding: 10px;
            font-weight: 600;
            width: 100%;
            transition: var(--transition);
            margin-top: 0.75rem;
            color: white;
            font-size: 0.9rem;
        }

        .checkout-btn:hover {
            background: #157347;
            transform: translateY(-2px);
        }

        /* Order Summary */
        .order-summary {
            background: linear-gradient(180deg, #fff, #f8fafc);
            padding: 1rem;
            border-radius: var(--border-radius-sm);
            margin-top: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        /* Mobile Bottom Navigation */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid var(--border-color);
            padding: 12px 16px;
            display: none;
            z-index: 1000;
            box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .mobile-nav-items {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .mobile-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.75rem;
            gap: 4px;
            transition: var(--transition);
        }

        .mobile-nav-item.active {
            color: var(--primary);
        }

        .mobile-nav-item i {
            font-size: 1.25rem;
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
            padding: 16px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .item-modal {
            background: white;
            border-radius: var(--border-radius);
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow: hidden;
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }

        .modal-overlay.active .item-modal {
            transform: translateY(0);
        }

        .modal-header {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            padding: 1rem;
            max-height: 60vh;
            overflow-y: auto;
        }

        .modal-footer {
            padding: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .modal-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: var(--border-radius-sm);
            margin-bottom: 1rem;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .modal-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .modal-description {
            color: var(--text-muted);
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .variants-section {
            margin-bottom: 1rem;
        }

        .variants-title {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .variants-container {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .variant-option {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .variant-option input[type="radio"] {
            margin: 0;
        }

        .variant-option label {
            font-size: 0.9rem;
            color: var(--text-secondary);
            cursor: pointer;
        }

        .modal-qty-control {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .modal-qty-label {
            font-weight: 600;
            color: var(--text-primary);
        }

        .modal-qty-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-qty-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color);
            background: white;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
        }

        .modal-qty-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .modal-qty-input {
            width: 50px;
            text-align: center;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            padding: 5px;
            font-weight: 600;
        }

        .modal-add-to-cart-btn {
            background: var(--gradient-primary);
            border: none;
            border-radius: var(--border-radius-sm);
            padding: 10px 16px;
            font-weight: 600;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            color: white;
            width: 100%;
        }

        .modal-add-to-cart-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 250px;
            border-radius: var(--border-radius-sm);
            box-shadow: var(--shadow-lg);
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
        }

        .notification.show {
            opacity: 1;
            transform: translateX(0);
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .app-shell {
                padding: 12px;
            }

            .mobile-bottom-nav {
                display: block;
            }

            .topnav .brand-text div:first-child {
                font-size: 0.8rem;
            }

            .topnav .brand-text .small-muted {
                font-size: 0.7rem;
            }

            .menu-items-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 10px;
            }

            .cart-sidebar {
                position: relative;
                top: 0;
            }

            .order-summary {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }

            .order-summary>div {
                flex: 1;
            }
        }

        @media (min-width: 769px) {
            .order-container {
                flex-direction: row;
            }

            .menu-section {
                order: 1;
                flex: 1;
            }

            .sidebar-section {
                order: 2;
                width: 400px;
                flex-shrink: 0;
            }

            .menu-items-grid {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
                gap: 16px;
            }
        }

        @media (min-width: 1024px) {
            .menu-items-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }

        /* Utility Classes */
        .btn-wide {
            min-width: 120px;
        }

        .text-info-Soft {
            color: #0b76d1;
        }

        .badge-soft {
            background: rgba(11, 125, 209, 0.12);
            color: var(--primary);
            padding: .25rem .5rem;
            border-radius: .7rem;
            font-weight: 600;
            font-size: 0.75rem;
        }

        footer {
            padding: 1rem;
            text-align: center;
            color: var(--text-muted);
            font-size: .8rem;
            margin-top: 2rem;
        }

        /* Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Animation for mobile interactions */
        @keyframes slideUp {
            from {
                transform: translateY(100%);
            }

            to {
                transform: translateY(0);
            }
        }

        .mobile-bottom-nav {
            animation: slideUp 0.3s ease-out;
        }

        /* Select2 customization */
        .select2-container--default .select2-selection--single {
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            height: 38px;
            padding: 5px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px;
            padding-left: 0;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--primary);
        }

        /* Order Mode Indicator */
        .order-mode-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .mode-new {
            background: rgba(25, 135, 84, 0.1);
            color: var(--success);
        }

        .mode-update {
            background: rgba(255, 193, 7, 0.1);
            color: #856404;
        }

        /* Order Stats */
        .order-stats {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
        }

        .stat-card {
            flex: 1;
            background: white;
            border-radius: var(--border-radius);
            padding: 12px;
            box-shadow: var(--shadow);
            text-align: center;
        }

        .stat-value {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Customer Quick Actions */
        .customer-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .customer-actions .btn {
            flex: 1;
            font-size: 0.8rem;
            padding: 6px 8px;
        }
    </style>
</head>

<body>
    <div class="app-shell">
        <!-- Top Navigation -->
        <div class="topnav">
            <div class="brand">
                <div class="logo">R</div>
                <div class="brand-text">
                    <div>BG RestroCare</div>
                    <div class="small-muted">Orders Panel</div>
                </div>
            </div>
            <div class="actions">
                <div class="small-muted d-none d-md-block text-end me-2">
                    <div>Hello, Admin</div>
                    <div class="small-muted">Today: {{ \Carbon\Carbon::now()->format('d M, Y') }}</div>
                </div>

                <button class="btn btn-light btn-sm" id="compactNavToggle"><i class="fa-solid fa-bars"></i></button>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <main class="main">
            <div class="topbar">
                <div>
                    <h3 class="mb-0">Make an Order</h3>
                    <div class="small-muted d-flex align-items-center gap-2">
                        <span id="orderModeText">Create new takeaway / delivery orders quickly</span>
                        <span id="orderModeIndicator" class="order-mode-indicator mode-new d-none">
                            <i class="fas fa-plus-circle"></i>
                            <span>NEW ORDER</span>
                        </span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="small-muted text-end me-2 d-md-none">
                        <div>Hello, Admin</div>
                        <div class="small-muted">Today: {{ \Carbon\Carbon::now()->format('d M, Y') }}</div>
                    </div>

                    <a href="{{ url('/notify/' . $restaurent_table->table_number) }}" class="btn btn-primary">
                        <i class="fa-solid fa-bell"></i>
                    </a>


                    <button class="btn btn-primary btn-sm btn-wide" onclick="window.location.reload()">
                        <i class="fa-solid fa-plus me-1"></i>New
                    </button>
                </div>
            </div>

            <!-- Order Stats -->
            <div class="order-stats">
                <div class="stat-card">
                    <div class="stat-value" id="cart-items-count">0</div>
                    <div class="stat-label">Items</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="cart-subtotal-value">Rs 0.00</div>
                    <div class="stat-label">Subtotal</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="cart-total-value">Rs 0.00</div>
                    <div class="stat-label">Total</div>
                </div>
            </div>

            <!-- DYNAMIC FORM -->
            <form id="orderForm" action="{{ route('tables.orders.submit') }}" method="post">
                @csrf
                <input type="hidden" name="office_id" value="{{ $table->id ?? '' }}">
                <input type="hidden" name="restaurent_id" value="{{ auth()->user()->restaurent_id ?? '' }}">
                <input type="hidden" name="created_by" value="{{ auth()->id() ?? 1 }}">
                <input type="hidden" name="order_from" value="web">
                <input type="hidden" name="order_time" value="{{ now() }}">
                <input type="hidden" name="table_id" value="{{ $restaurent_table->table_number ?? '' }}">
                <input type="hidden" id="order_id" name="order_id" value="">
                <input type="hidden" id="orderType" name="orderType" value="dinein">
                <input type="hidden" name="table_id" value="{{ $restaurent_table->id ?? '' }}">

                <div class="order-container">
                    <!-- Menu Section -->
                    <div class="menu-section">
                        <!-- Search Bar - IMPROVED with better spacing -->
                        <div class="search-container">
                            <i class="fas fa-search search-icon"></i>
                            <input id="search-input" class="form-control search-input" type="search"
                                placeholder="Search office menu items..." aria-label="Search">
                        </div>

                        <!-- Categories Navigation -->
                        <div class="category-nav-container">
                            <h6 class="mb-2">Categories</h6>
                            <div class="category-scroll">
                                <ul class="category-nav">
                                    <li>
                                        <a class="nav-link active" data-category="all">All Items</a>
                                    </li>
                                    @foreach ($categories as $category)
                                        <li>
                                            <a class="nav-link" data-category="{{ $category->id }}">
                                                {{ $category->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Menu Items Grid -->
                        <div class="menu-items-grid" id="menu-items">
                            @foreach ($menus as $item)
                                @php
                                    $hasVariants = $item->variations && count($item->variations) > 0;
                                @endphp
                                <div class="menu-item" data-category="{{ $item->category_id }}"
                                    data-name="{{ strtolower($item->name) }}"
                                    data-has-variants="{{ $hasVariants ? 'true' : 'false' }}">
                                    <div class="card h-100">
                                        <div class="card-img-container">
                                            <img src="{{ asset('upload/images/menu/' . $item['image']) }}"
                                                alt="{{ $item->name }}" class="item-image"
                                                data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                data-price="{{ $item->price }}"
                                                data-description="{{ $item->description }}"
                                                data-image="{{ asset('upload/images/menu/' . $item['image']) }}"
                                                data-has-variants="{{ $hasVariants ? 'true' : 'false' }}">
                                            <span class="category-badge">{{ $item->category_name }}</span>
                                            <span class="price-badge">Rs {{ number_format($item->price, 2) }}</span>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $item->name }}</h6>
                                            <p class="card-text">{{ Str::limit($item->description, 60) }}</p>
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="qty-control">
                                                    <button class="qty-btn minus"
                                                        data-id="{{ $item->id }}">-</button>
                                                    <input type="number" min="1" value="1"
                                                        class="qty-input" id="qty-{{ $item->id }}">
                                                    <button class="qty-btn plus"
                                                        data-id="{{ $item->id }}">+</button>
                                                </div>
                                                <button type="button" class="add-to-cart-btn"
                                                    data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                    data-price="{{ $item->price }}"
                                                    data-description="{{ $item->description }}"
                                                    data-image="{{ asset('upload/images/menu/' . $item['image']) }}"
                                                    data-has-variants="{{ $hasVariants ? 'true' : 'false' }}">
                                                    <i class="fas fa-cart-plus me-1"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sidebar Section -->
                    <div class="sidebar-section">
                        <!-- Customer Card -->
                        <div class="card customer-card">
                            <div class="card-header">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="mb-0">Customer Details</h6>
                                        <small class="small-muted">Auto-fill by phone</small>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        id="addCustomerBtn">
                                        <i class="fas fa-plus me-1"></i> New
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <input type="hidden" id="customer_id" name="customer_id" value="">

                                <div class="mb-3">
                                    <label class="form-label fw-600">Customer Phone *</label>
                                    <div class="input-group phone-input-group">
                                        <span class="input-group-text bg-white">
                                            <i class="fa-solid fa-phone text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control" id="customer_phone"
                                            name="customer_phone" placeholder="e.g. 03001234567" required>
                                        <button type="button" id="clearPhone"
                                            class="btn btn-outline-secondary d-none">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <div id="phone-feedback" class="mt-1 small-muted"></div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-600">Customer Name *</label>
                                    <input type="text" class="form-control" id="customer_name"
                                        name="customer_name" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-600">Email</label>
                                    <input type="email" class="form-control" id="customer_email"
                                        name="customer_email" placeholder="optional">
                                </div>

                                <!-- Customer Quick Actions -->
                                <div class="customer-actions">
                                    <button type="button" id="resetCustomer" class="btn btn-light btn-sm">
                                        <i class="fas fa-redo me-1"></i> Reset
                                    </button>
                                </div>

                                <!-- Recent Orders Container -->
                                <div id="recentOrdersContainer" class="recent-orders"></div>
                            </div>
                        </div>

                        <!-- Cart Sidebar -->
                        <div class="card cart-sidebar">
                            <div class="cart-header">
                                <h6 class="mb-0">Current Order</h6>
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
                                <div class="total-row"
                                    style="border-top: 1px solid var(--border-color); padding-top: 8px;">
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

                                <div class="order-summary d-flex align-items-center justify-content-between mt-3">
                                    <div>
                                        <div class="small-muted">Current Order</div>
                                        <h5 id="totalAmount" class="mb-0">0.00</h5>
                                    </div>
                                    <div>
                                        <button type="submit" id="submitBtn" class="btn btn-primary btn-wide">
                                            <i class="fa-solid fa-check me-1"></i>
                                            <span id="submitBtnText">Place Order</span>
                                        </button>
                                    </div>
                                </div>

                                <input type="hidden" name="sub_total" id="subTotalInput">
                                <input type="hidden" name="discount_amount" id="discountAmountInput"
                                    value="0">
                                <input type="hidden" name="grand_total" id="grandTotalInput">
                                <input type="hidden" name="order_items" id="orderItemsInput">
                                <input type="hidden" name="recent_orders_total" id="recentOrdersTotalInput"
                                    value="0">
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <footer class="mt-4">
                © {{ date('Y') }} Restaurant Admin • Crafted for operations
            </footer>
        </main>
    </div>

    <!-- Mobile Bottom Navigation -->
    <div class="mobile-bottom-nav">
        <div class="mobile-nav-items">
            <a href="#" class="mobile-nav-item active">
                <i class="fas fa-utensils"></i>
                <span>Menu</span>
            </a>
            <a href="#" class="mobile-nav-item">
                <i class="fas fa-shopping-cart"></i>
                <span>Cart</span>
                <span class="badge bg-danger" id="mobile-cart-count">0</span>
            </a>
            <a href="#" class="mobile-nav-item">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>
            <a href="#" class="mobile-nav-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </div>
    </div>

    <!-- Item Modal for Variants -->
    <div class="modal-overlay" id="item-modal">
        <div class="item-modal">
            <div class="modal-header">
                <h5 class="modal-title">Customize Item</h5>
                <button type="button" id="close-modal" class="btn-close"></button>
            </div>
            <div class="modal-body">
                <img id="modal-image" src="" alt="Item Image" class="modal-image">
                <h4 id="modal-item-name" class="modal-title"></h4>
                <div id="modal-item-price" class="modal-price"></div>
                <p id="modal-item-description" class="modal-description"></p>

                <div id="variants-section" class="variants-section" style="display: none;">
                    <h6 class="variants-title">Select Variant</h6>
                    <div id="variants-container" class="variants-container"></div>
                </div>

                <div class="modal-qty-control">
                    <div class="modal-qty-label">Quantity</div>
                    <div class="modal-qty-buttons">
                        <button class="modal-qty-btn" id="modal-minus">-</button>
                        <input type="number" min="1" value="1" class="modal-qty-input" id="modal-qty">
                        <button class="modal-qty-btn" id="modal-plus">+</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-add-to-cart-btn" id="modal-add-to-cart">
                    <i class="fas fa-cart-plus me-1"></i> Add to Cart
                </button>
            </div>
        </div>
    </div>

    <!-- Add Customer Modal -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCustomerForm">
                        <div class="mb-3">
                            <label class="form-label">Name *</label>
                            <input type="text" class="form-control" id="newCustomerName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone *</label>
                            <input type="text" class="form-control" id="newCustomerPhone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="newCustomerEmail">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveNewCustomer">Save Customer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS: jQuery, Bootstrap, Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Enhanced Restaurant Order Management System
        let userRestaurantId = "{{ auth()->user()->restaurent_id ?? '' }}";
        let recentOrdersTotal = 0;
        let existingOrderId = null;
        let isUpdateMode = false;
        const cart = [];

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

        // Current item being viewed in modal
        let currentModalItem = null;

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

        // Function to check if customer exists by phone number
        function checkCustomerByPhone(phone) {
            if (!phone || phone.length < 10) {
                return;
            }

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('phone', phone);

            fetch('{{ route('check.customer.by.phone') }}', {
                    method: 'POST',
                    body: formData
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
                        $('#customer_name').val(data.customer.name || '');
                        $('#customer_email').val(data.customer.email || '');

                        if (data.customer.id) {
                            $('#customer_id').val(data.customer.id);
                            console.log('Customer ID set to:', data.customer.id);
                            fetchRecentOrders(data.customer.id);
                        } else {
                            console.warn('Customer ID not found in response');
                            $('#customer_id').val('');
                            hideRecentOrders();
                            setNewOrderMode();
                        }

                        $('#phone-feedback').html(
                            '<span class="text-success"><i class="fas fa-check-circle"></i> Customer found! Name auto-filled.</span>'
                        );
                        $('#clearPhone').removeClass('d-none');
                        setTimeout(() => $('#phone-feedback').html(''), 3000);
                    } else {
                        $('#customer_id').val('');
                        $('#customer_name').val('');
                        $('#customer_email').val('');
                        $('#phone-feedback').html(
                            '<span class="text-info"><i class="fas fa-info-circle"></i> New customer. Please enter details.</span>'
                        );
                        $('#clearPhone').removeClass('d-none');
                        hideRecentOrders();
                        setNewOrderMode();
                        setTimeout(() => $('#phone-feedback').html(''), 3000);
                    }
                })
                .catch(error => {
                    console.error('Error checking customer:', error);
                    $('#phone-feedback').html(
                        '<span class="text-danger"><i class="fas fa-exclamation-triangle"></i> Error checking customer.</span>'
                    );
                    setTimeout(() => $('#phone-feedback').html(''), 3000);
                    hideRecentOrders();
                    setNewOrderMode();
                });
        }

        // Function to fetch recent orders for a customer
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
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
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

                    if (data && data.length > 0) {
                        const incompleteOrder = data.find(order =>
                            order.status === 'pending' || order.status === 'confirmed' || order.status ===
                            'preparing' || order.status === 'accepted'
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

        // Function to display recent orders with totals
        function displayRecentOrders(orders) {
            const container = $('#recentOrdersContainer');

            if (!orders || orders.length === 0) {
                container.html('<div class="text-center text-muted p-3">No incomplete orders found</div>').show();
                recentOrdersTotal = 0;
                updateRecentOrdersTotalDisplay();
                updateOverallTotal();
                return;
            }

            let html = '<h6 class="mb-3"><i class="fas fa-history me-2"></i>Recent Incomplete Orders</h6>';
            recentOrdersTotal = 0;

            orders.forEach(order => {
                const statusClass = getStatusClass(order.status);
                const orderTime = new Date(order.order_time).toLocaleString();
                const orderTotal = order.grand_total || order.calculated_total || 0;
                recentOrdersTotal += orderTotal;

                html += `
                        <div class="order-item">
                            <div class="order-header">
                                <span>Order #${order.id}</span>
                                <span class="order-status ${statusClass}">${order.status}</span>
                            </div>
                            <div class="order-time small text-muted mb-2">
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
                            <div class="order-total small text-muted mt-2">
                                <strong>Order Total: Rs. ${orderTotal.toFixed(2)}</strong>
                            </div>
                            ${order.table_number ? `
                                                                                                                                <div class="order-location small text-muted mt-1">
                                                                                                                                    <i class="fas fa-table me-1"></i>Table: ${order.table_number}
                                                                                                                                </div>
                                                                                                                            ` : ''}
                            ${order.order_type ? `
                                                                                                                                <div class="order-type small text-muted mt-1">
                                                                                                                                    <span class="badge order-type-badge bg-secondary">${order.order_type}</span>
                                                                                                                                </div>
                                                                                                                            ` : ''}
                        </div>
                    `;
            });

            container.html(html).show();
            updateRecentOrdersTotalDisplay();
            updateOverallTotal();
        }

        // Function to hide recent orders container
        function hideRecentOrders() {
            $('#recentOrdersContainer').hide().html('');
            recentOrdersTotal = 0;
            updateRecentOrdersTotalDisplay();
            updateOverallTotal();
        }

        // Update recent orders total display
        function updateRecentOrdersTotalDisplay() {
            const recentOrdersTotalValue = $('#recent-orders-total-value');
            const recentOrdersTotalDisplay = $('#recent-orders-total');

            if (recentOrdersTotal > 0) {
                recentOrdersTotalValue.text(`Rs ${recentOrdersTotal.toFixed(2)}`);
                recentOrdersTotalDisplay.show();
                $('#recentOrdersTotalInput').val(recentOrdersTotal);
            } else {
                recentOrdersTotalDisplay.hide();
                $('#recentOrdersTotalInput').val(0);
            }
        }

        // Update overall total (current order + recent orders)
        function updateOverallTotal() {
            const currentOrderTotal = parseFloat($('#totalAmount').text()) || 0;
            const overallTotal = currentOrderTotal + recentOrdersTotal;

            $('#grandTotal').text(overallTotal.toFixed(2));
            $('#grandTotalInput').val(overallTotal.toFixed(2));

            const combinedTotalValue = $('#combined-total-value');
            const combinedTotalDisplay = $('#combined-total');

            if (recentOrdersTotal > 0) {
                combinedTotalValue.text(`Rs ${overallTotal.toFixed(2)}`);
                combinedTotalDisplay.show();
            } else {
                combinedTotalDisplay.hide();
            }
        }

        // Set form to UPDATE mode
        function setUpdateMode(orderId) {
            isUpdateMode = true;
            existingOrderId = orderId;

            $('#orderForm').attr('action', '{{ route('tables.orders.update') }}');
            $('#order_id').val(orderId);

            $('#orderModeText').html('Adding items to existing order');
            $('#orderModeIndicator').removeClass('d-none mode-new').addClass('mode-update').html(
                '<i class="fas fa-edit"></i><span>UPDATE MODE</span>'
            );
            $('#submitBtnText').text('Update Order');
            $('#submitBtn').removeClass('btn-primary').addClass('btn-warning');

            console.log('Switched to UPDATE mode for order:', orderId);
        }

        // Set form to NEW ORDER mode
        function setNewOrderMode() {
            isUpdateMode = false;
            existingOrderId = null;

            $('#orderForm').attr('action', '{{ route('tables.orders.submit') }}');
            $('#order_id').val('');

            $('#orderModeText').text('Create new takeaway / delivery orders quickly');
            $('#orderModeIndicator').removeClass('d-none mode-update').addClass('mode-new').html(
                '<i class="fas fa-plus-circle"></i><span>NEW ORDER</span>'
            );
            $('#submitBtnText').text('Place Order');
            $('#submitBtn').removeClass('btn-warning').addClass('btn-primary');

            console.log('Switched to NEW ORDER mode');
        }

        // Helper function to get status class
        function getStatusClass(status) {
            const statusMap = {
                'pending': 'status-pending',
                'accepted': 'status-accepted',
                'confirmed': 'status-preparing',
                'preparing': 'status-preparing',
                'ready': 'status-ready',
                'completed': 'status-completed'
            };
            return statusMap[status] || 'status-pending';
        }

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
        const debouncedCheckCustomer = debounce(checkCustomerByPhone, 500);

        // Open modal function
        function openModal(id, name, price, description, imageSrc) {
            currentModalItem = {
                id,
                name,
                basePrice: price,
                price,
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
                currentModalItem.price = variantPrice;
                modalItemPrice.textContent = `Rs ${variantPrice.toFixed(2)}`;
            }
        }

        // Close modal
        function closeModal() {
            modalOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
            currentModalItem = null;
        }

        // Cart functionality
        function addToCart(id, name, price, qty = 1, variantId = null, variantName = null) {
            const cartItemId = variantId ? `${id}-${variantId}` : id.toString();
            const existingItem = cart.find(item => item.cartItemId === cartItemId);

            if (existingItem) {
                existingItem.qty += qty;
            } else {
                cart.push({
                    id,
                    name: variantName ? `${name} (${variantName})` : name,
                    price,
                    qty,
                    variantId,
                    cartItemId
                });
            }

            renderCart();
            updateTotal();
            updateOrderStats();
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            renderCart();
            updateTotal();
            updateOrderStats();
        }

        function updateCartItemQty(index, change) {
            const item = cart[index];
            item.qty += change;

            if (item.qty < 1) {
                removeFromCart(index);
            } else {
                renderCart();
                updateTotal();
                updateOrderStats();
            }
        }

        function renderCart() {
            const cartItemsList = $('#cart-items-list');
            const cartCount = $('#cart-count');
            const cartSubtotal = $('#cart-subtotal');
            const cartTotalElement = $('#cart-total');

            if (cart.length === 0) {
                cartItemsList.html(`
                        <div class="empty-cart">
                            <div class="empty-cart-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <p>Your cart is empty</p>
                            <small class="text-muted">Add items to create an order</small>
                        </div>
                    `);
                cartCount.text('0 items');
                cartSubtotal.text('Rs 0.00');
                cartTotalElement.text('Rs 0.00');
                $('#orderItemsInput').val('');
                return;
            }

            let html = '';
            let subtotal = 0;

            cart.forEach((item, index) => {
                const itemTotal = item.price * item.qty;
                subtotal += itemTotal;

                html += `
                        <div class="cart-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="cart-item-name">${item.name}</div>
                                    <div class="cart-item-details">Rs ${item.price.toFixed(2)} × ${item.qty} = Rs ${itemTotal.toFixed(2)}</div>
                                </div>
                                <div class="cart-controls">
                                    <button class="cart-qty-btn minus" data-index="${index}">-</button>
                                    <span class="mx-1" style="font-size: 0.8rem;">${item.qty}</span>
                                    <button class="cart-qty-btn plus" data-index="${index}">+</button>
                                    <button class="remove-btn ms-2" data-index="${index}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
            });

            const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
            cartCount.text(totalItems + (totalItems === 1 ? ' item' : ' items'));
            cartSubtotal.text('Rs ' + subtotal.toFixed(2));
            cartTotalElement.text('Rs ' + subtotal.toFixed(2));
            cartItemsList.html(html);

            // Update order items input for form submission
            $('#orderItemsInput').val(JSON.stringify(cart.map(item => ({
                menu_id: item.id,
                name: item.name,
                price: item.price,
                qty: item.qty,
                variation_id: item.variantId || '',
                item_total: (item.price * item.qty)
            }))));
        }

        function updateTotal() {
            let total = 0;

            cart.forEach(item => {
                total += item.price * item.qty;
            });

            $("#totalAmount").text(total.toFixed(2));
            $("#cart-total").text('Rs ' + total.toFixed(2));
            $("#subTotalInput").val(total.toFixed(2));

            updateOverallTotal();
        }

        function updateOrderStats() {
            const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);

            $('#cart-items-count').text(totalItems);
            $('#cart-subtotal-value').text('Rs ' + subtotal.toFixed(2));
            $('#cart-total-value').text('Rs ' + subtotal.toFixed(2));

            // Update mobile cart count
            $('#mobile-cart-count').text(totalItems);
        }

        // Category filter
        function setupCategoryFilter() {
            $('.category-nav .nav-link').on('click', function(e) {
                e.preventDefault();
                $('.category-nav .nav-link').removeClass('active');
                $(this).addClass('active');

                const categoryId = $(this).data('category');
                $('.menu-item').each(function() {
                    if (categoryId === 'all' || $(this).data('category') == categoryId) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        }

        // Search functionality
        function setupSearch() {
            $('#search-input').on('input', function() {
                const query = $(this).val().trim().toLowerCase();
                $('.menu-item').each(function() {
                    const name = $(this).data('name') || '';
                    if (name.includes(query)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        }

        // Handle image click event
        // Update the handleImageClick function (around line 1689) to:
        function handleImageClick(e) {
            e.stopPropagation(); // ADD THIS LINE - prevents event from bubbling up

            // Don't trigger if clicking on quantity controls or add button
            if ($(e.target).closest('.qty-control').length || $(e.target).closest('.add-to-cart-btn').length) {
                return;
            }

            const card = $(e.target).closest('.menu-item');
            const img = card.find('.item-image');
            const id = img.data('id');
            const name = img.data('name');
            const price = parseFloat(img.data('price'));
            const description = card.find('.card-text').text();
            const imageSrc = img.attr('src');
            const hasVariants = img.data('has-variants') === true;

            // Check if item has variants
            if (hasVariants) {
                // Item has variants, open modal for variant selection
                openModal(id, name, price, description, imageSrc);
            } else {
                // Item has no variants, add ONE quantity directly to cart (ignore input value)
                const qty = 1; // Always add 1 when clicking image

                addToCart(id, name, price, qty);
                showNotification(`${name} added to cart!`);

                // Reset quantity input to 1
                $(`#qty-${id}`).val(1);
            }
        }

        // Quantity controls for menu items
        function setupQuantityControls() {
            $(document).on('click', '.qty-btn', function(e) {
                e.stopPropagation(); // Prevent triggering image click

                const id = $(this).data('id');
                const input = $(`#qty-${id}`);
                let value = parseInt(input.val());

                if ($(this).hasClass('plus')) {
                    value++;
                } else if ($(this).hasClass('minus') && value > 1) {
                    value--;
                }

                input.val(value);
            });

            // Add to cart from menu items
            $(document).on('click', '.add-to-cart-btn', function(e) {
                e.stopPropagation(); // Prevent triggering image click

                const id = $(this).data('id');
                const name = $(this).data('name');
                const price = parseFloat($(this).data('price'));
                const description = $(this).data('description');
                const image = $(this).data('image');
                const hasVariants = $(this).data('has-variants') === true;
                const qtyInput = $(`#qty-${id}`);
                const qty = Math.max(1, parseInt(qtyInput.val() || 1, 10));

                // Check if item has variants
                if (hasVariants) {
                    openModal(id, name, price, description, image);
                } else {
                    addToCart(id, name, price, qty);
                    qtyInput.val(1);
                    showNotification(`${name} added to cart!`);
                }
            });

            // Cart controls
            $(document).on('click', '.cart-qty-btn, .remove-btn', function() {
                const index = $(this).data('index');

                if ($(this).hasClass('remove-btn')) {
                    removeFromCart(index);
                    showNotification('Item removed from cart');
                } else if ($(this).hasClass('minus')) {
                    updateCartItemQty(index, -1);
                } else if ($(this).hasClass('plus')) {
                    updateCartItemQty(index, 1);
                }
            });

            // Handle clicks on the card image
            $(document).on('click', '.item-image, .card-img-container', function(e) {
                handleImageClick(e);
            });

            // Handle clicks on the card body (excluding quantity controls)
            $(document).on('click', '.card-body', function(e) {
                // Only trigger if not clicking on text links or other interactive elements
                if (!$(e.target).is('a, button, input, .qty-control, .add-to-cart-btn')) {
                    handleImageClick(e);
                }
            });
        }

        // Modal event listeners
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
            let variantName = null;

            // Check if a variant is selected
            const selectedVariant = document.querySelector('input[name="variant"]:checked');
            if (selectedVariant) {
                const variantPrice = parseFloat(selectedVariant.dataset.price);
                price = variantPrice;
                variantName = selectedVariant.nextElementSibling.textContent.split(' (Rs')[0].trim();
                variantId = selectedVariant.value;
            }

            addToCart(currentModalItem.id, name, price, qty, variantId, variantName);
            showNotification(`${name} ${variantName ? '(' + variantName + ')' : ''} added to cart!`);
            closeModal();
        });

        // Notification function
        function showNotification(message, type = 'success') {
            // Remove any existing notifications
            $('.notification').remove();

            const icon = type === 'warning' ? 'fa-exclamation-triangle' :
                type === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle';

            const notification = $(`
                    <div class="notification alert alert-${type}">
                        <div class="d-flex align-items-center">
                            <i class="fas ${icon} me-2"></i>
                            <span>${message}</span>
                        </div>
                    </div>
                `);

            $('body').append(notification);

            // Show notification with animation
            setTimeout(() => {
                notification.addClass('show');
            }, 10);

            // Remove notification after delay
            setTimeout(() => {
                notification.removeClass('show');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // Event Listeners
        $('#customer_phone').on('input', function() {
            const phone = $(this).val().trim();
            if (phone.length >= 10) {
                debouncedCheckCustomer(phone);
            } else {
                $('#phone-feedback').html('');
                $('#clearPhone').addClass('d-none');
                $('#customer_id').val('');
                hideRecentOrders();
                setNewOrderMode();
            }
        });

        // Clear phone quickly
        $('#clearPhone').on('click', function() {
            $('#customer_phone').val('').trigger('input').focus();
            $('#customer_id').val('');
            $(this).addClass('d-none');
            hideRecentOrders();
            setNewOrderMode();
        });

        // Reset customer form
        $('#resetCustomer').on('click', function() {
            $('#customer_phone').val('');
            $('#customer_name').val('');
            $('#customer_email').val('');
            $('#customer_id').val('');
            $('#phone-feedback').html('');
            $('#clearPhone').addClass('d-none');
            hideRecentOrders();
            setNewOrderMode();
        });

        // Save customer details
        $('#saveCustomer').on('click', function() {
            const phone = $('#customer_phone').val().trim();
            const name = $('#customer_name').val().trim();
            const email = $('#customer_email').val().trim();

            if (!phone || !name) {
                showNotification('Please fill in customer phone and name.', 'warning');
                return;
            }

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('phone', phone);
            formData.append('name', name);
            formData.append('email', email);

            fetch('{{ route('customers.store') }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Customer details saved successfully!');
                        if (data.customer && data.customer.id) {
                            $('#customer_id').val(data.customer.id);
                        }
                    } else {
                        showNotification('Failed to save customer details.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error saving customer:', error);
                    showNotification('Error saving customer details.', 'error');
                });
        });

        // Add customer modal
        $('#addCustomerBtn').on('click', function() {
            $('#addCustomerModal').modal('show');
        });

        $('#saveNewCustomer').on('click', function() {
            const name = $('#newCustomerName').val().trim();
            const phone = $('#newCustomerPhone').val().trim();
            const email = $('#newCustomerEmail').val().trim();

            if (!name || !phone) {
                showNotification('Please fill in customer name and phone.', 'warning');
                return;
            }

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('name', name);
            formData.append('phone', phone);
            formData.append('email', email);

            fetch('{{ route('customers.store') }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('New customer added successfully!');
                        $('#customer_phone').val(phone);
                        $('#customer_name').val(name);
                        $('#customer_email').val(email);
                        if (data.customer && data.customer.id) {
                            $('#customer_id').val(data.customer.id);
                        }
                        $('#addCustomerModal').modal('hide');
                        $('#addCustomerForm')[0].reset();
                    } else {
                        showNotification('Failed to add customer.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error adding customer:', error);
                    showNotification('Error adding customer.', 'error');
                });
        });

        // Mobile navigation functionality
        $(document).on('click', '.mobile-nav-item', function(e) {
            e.preventDefault();
            $('.mobile-nav-item').removeClass('active');
            $(this).addClass('active');

            const target = $(this).find('span').text().toLowerCase();

            if (target === 'cart') {
                $('html, body').animate({
                    scrollTop: $('.cart-sidebar').offset().top - 20
                }, 500);
            } else if (target === 'menu') {
                $('html, body').animate({
                    scrollTop: $('.menu-section').offset().top - 20
                }, 500);
            }
        });

        $(document).ready(function() {
            updateTotal();
            updateOrderStats();
            hideRecentOrders();
            setNewOrderMode();
            setupCategoryFilter();
            setupSearch();
            setupQuantityControls();
            renderCart();

            // Initialize Select2 for any select elements if needed
            $('select').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        });

        // Form validation before submission
        $('#orderForm').on('submit', function(e) {
            console.log('Form submission started');
            console.log('Mode:', isUpdateMode ? 'UPDATE' : 'NEW ORDER');
            console.log('Order ID:', existingOrderId);

            if (!$('#customer_phone').val() || !$('#customer_name').val()) {
                e.preventDefault();
                showNotification('Please fill in customer phone and name.', 'warning');
                return false;
            }

            if (cart.length === 0) {
                e.preventDefault();
                showNotification('Please add at least one item to the cart.', 'warning');
                return false;
            }

            console.log('Form validation passed, submitting...');
        });
    </script>

</body>

</html>
