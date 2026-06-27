<?php $__env->startSection('title', 'Pilih Barbershop & Salon'); ?>
<?php $__env->startSection('hide_public_chrome', '1'); ?>

<?php $__env->startSection('head'); ?>
    <!-- LeafletJS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <!-- Google Fonts Inter for clean and premium UI -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome for Premium UI Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        /* Custom Dropdown Styling */
        .auth-widget {
            position: relative;
            z-index: 1000;
        }
        .custom-dropdown {
            position: relative;
            display: inline-block;
        }
        .custom-dropdown-btn {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 9px 15px;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            user-select: none;
            box-sizing: border-box;
            outline: none;
        }
        .custom-dropdown-btn:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }
        .custom-dropdown-btn.login-btn {
            background: #1e1e24;
            color: #ffffff;
            border: none;
            padding: 10px 18px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
            font-weight: 700;
        }
        .custom-dropdown-btn.login-btn:hover {
            background: #2d2d35;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.14);
        }
        .auth-icon {
            font-size: 1.15rem;
            color: #64748b;
        }
        .custom-dropdown-btn.login-btn .chevron-icon {
            color: rgba(255, 255, 255, 0.8);
        }
        .chevron-icon {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-left: 4px;
            transition: transform 0.2s ease;
        }
        .custom-dropdown-btn.active .chevron-icon {
            transform: rotate(180deg);
        }
        .custom-dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            min-width: 210px;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.1), 0 8px 10px -6px rgba(15, 23, 42, 0.1);
            padding: 8px;
            animation: slideIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 1001;
            box-sizing: border-box;
        }
        .custom-dropdown-menu.show {
            display: block;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .dropdown-header {
            padding: 8px 12px;
            text-align: left;
        }
        .user-name {
            font-weight: 700;
            color: #0f172a;
            font-size: 0.85rem;
        }
        .user-email {
            color: #64748b;
            font-size: 0.75rem;
            margin-top: 2px;
            word-break: break-all;
        }
        .dropdown-divider {
            height: 1px;
            background: #f1f5f9;
            margin: 8px 0;
        }
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 12px;
            border-radius: 10px;
            color: #334155;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            border: none;
            background: none;
            text-align: left;
            cursor: pointer;
            transition: all 0.15s ease;
            box-sizing: border-box;
        }
        .dropdown-item:hover {
            background: #f1f5f9;
            color: #0f172a;
        }
        .dropdown-item.text-danger {
            color: #ef4444;
        }
        .dropdown-item.text-danger:hover {
            background: #fef2f2;
            color: #dc2626;
        }
        .icon-pelanggan {
            color: #10b981;
        }
        .icon-admin {
            color: #ef4444;
        }

        /* Base reset & overrides to guarantee full screen layout */
        body {
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
            font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
            background-color: #0f172a !important;
        }
        .page-wrapper {
            max-width: none !important;
            width: 100vw !important;
            height: 100vh !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            display: flex !important;
            flex-direction: column !important;
            background: #0f172a !important;
        }
        .main-content {
            flex: 1 !important;
            height: 100% !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            overflow: hidden !important;
        }

        /* Split layout container */
        .dashboard-container {
            display: grid;
            grid-template-columns: 65% 35%;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            position: relative;
        }

        /* Map styling */
        .map-panel {
            position: relative;
            height: 100%;
            width: 100%;
            background: #1e293b;
        }
        #map {
            height: 100%;
            width: 100%;
            z-index: 1;
        }

        /* Floating back button */
        .floating-back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 1000;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            padding: 10px 18px;
            border-radius: 30px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            font-size: 0.85rem;
            text-decoration: none;
        }
        .floating-back-btn:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            transform: translateY(-2px);
            color: #e8a53a;
        }

        /* Sidebar / Location panel */
        .sidebar-panel {
            background: #ffffff;
            border-left: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
            z-index: 10;
            box-shadow: -10px 0 30px -5px rgba(15, 23, 42, 0.05);
        }

        /* Bottom sheet handle (only visible on mobile) */
        .bottom-sheet-drag-handle {
            display: none;
        }

        /* Sidebar header components */
        .sidebar-header {
            padding: 24px;
            border-bottom: 1px solid #f1f5f9;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            gap: 16px;
            flex-shrink: 0;
        }
        .sidebar-title-container h1 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 4px 0;
            letter-spacing: -0.02em;
        }
        .sidebar-title-container p {
            font-size: 0.85rem;
            color: #64748b;
            margin: 0;
        }

        /* Search input bar */
        .search-wrapper {
            position: relative;
        }
        .search-input {
            width: 100%;
            padding: 12px 16px 12px 42px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s ease;
            color: #0f172a;
            background: #f8fafc;
            font-family: inherit;
        }
        .search-input:focus {
            border-color: #e8a53a;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(232, 165, 58, 0.1);
        }
        .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
            width: 16px;
            height: 16px;
        }

        /* Filter tags container */
        .filters-row {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 4px;
            scrollbar-width: none;
        }
        .filters-row::-webkit-scrollbar {
            display: none;
        }
        .filter-tag {
            padding: 8px 14px;
            border-radius: 20px;
            border: 1.5px solid #e2e8f0;
            background: #ffffff;
            font-size: 0.8rem;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s ease;
        }
        .filter-tag:hover {
            border-color: #cbd5e1;
            color: #334155;
            background: #f8fafc;
        }
        .filter-tag.active {
            background: #1e293b;
            border-color: #1e293b;
            color: #ffffff;
        }

        /* Sorting controls */
        .sort-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            color: #64748b;
            padding-top: 4px;
        }
        .sort-select-wrapper {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .sort-select {
            border: none;
            background: transparent;
            font-weight: 700;
            color: #0f172a;
            cursor: pointer;
            outline: none;
            font-size: 0.8rem;
            padding: 2px 4px;
            font-family: inherit;
        }
        .sort-select:focus {
            color: #e8a53a;
        }

        /* Scrollable locations list */
        .locations-list {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            background: #f8fafc;
        }
        .locations-list::-webkit-scrollbar {
            width: 6px;
        }
        .locations-list::-webkit-scrollbar-track {
            background: transparent;
        }
        .locations-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        /* Card Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #64748b;
        }
        .empty-state svg {
            color: #94a3b8;
            margin-bottom: 12px;
            width: 48px;
            height: 48px;
        }
        .empty-state p {
            margin: 0;
            font-size: 0.9rem;
        }

        /* Location Card styling */
        .location-card {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.01), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
            position: relative;
            flex-shrink: 0; /* Prevents cards from compressing in the flex list container */
        }
        .location-card:hover {
            border-color: #cbd5e1;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.04), 0 4px 6px -2px rgba(15, 23, 42, 0.04);
        }
        .location-card.selected {
            border-color: #e8a53a;
            box-shadow: 0 0 0 3px rgba(232, 165, 58, 0.15);
            background: #fffdfa;
        }

        /* Image section of card */
        .card-image-wrapper {
            position: relative;
            height: 140px;
            width: 100%;
            background: #e2e8f0;
            overflow: hidden;
        }
        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .location-card:hover .card-image {
            transform: scale(1.03);
        }
        .card-badge-category {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(15, 23, 42, 0.75);
            color: #ffffff;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            backdrop-filter: blur(4px);
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }
        .card-badge-status {
            position: absolute;
            top: 12px;
            right: 12px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            backdrop-filter: blur(4px);
        }
        .status-buka {
            background: rgba(34, 197, 94, 0.9);
            color: #ffffff;
        }
        .status-tutup {
            background: rgba(239, 68, 68, 0.9);
            color: #ffffff;
        }

        /* Card Content details */
        .card-content {
            padding: 18px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .card-header-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 8px;
        }
        .card-name {
            font-size: 1.15rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.25;
            margin: 0;
            letter-spacing: -0.015em;
        }
        .card-rating {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.8rem;
            font-weight: 700;
            color: #e2a028;
            background: #fffbeb;
            padding: 2px 6px;
            border-radius: 6px;
            border: 1px solid #fde68a;
        }

        .card-info-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 0.75rem;
            color: #64748b;
        }
        .card-info-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .card-info-item svg {
            width: 14px;
            height: 14px;
            color: #94a3b8;
        }
        .card-address {
            font-size: 0.8rem;
            color: #475569;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin: 0;
        }

        /* Queue pill / Congestion levels */
        .queue-badge {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 700;
            margin-top: 4px;
        }
        .queue-sepi {
            background: #f0fdf4;
            color: #166534;
            border: 1.5px solid #bbf7d0;
        }
        .queue-sedang {
            background: #fffbeb;
            color: #92400e;
            border: 1.5px solid #fde68a;
        }
        .queue-ramai {
            background: #fef2f2;
            color: #991b1b;
            border: 1.5px solid #fecaca;
        }
        .queue-badge-title {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .queue-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: currentColor;
            display: inline-block;
        }
        .queue-sepi .queue-dot {
            animation: pulse-green 1.5s infinite;
        }
        @keyframes pulse-green {
            0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
            70% { box-shadow: 0 0 0 6px rgba(34, 197, 94, 0); }
            100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }
        .queue-time {
            font-size: 0.75rem;
            font-weight: 500;
            opacity: 0.85;
        }

        .card-actions {
            margin-top: 12px;
            padding: 0 !important;
            border-top: none !important;
            background: transparent !important;
            display: block !important;
        }
        .btn-primary-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 12px;
            background: #1e293b;
            color: #ffffff;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.85rem;
            border: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.08);
            gap: 6px;
        }
        .btn-primary-action:hover {
            background: #0f172a;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.12);
        }
        .btn-primary-action svg {
            transition: transform 0.2s ease;
        }
        .btn-primary-action:hover svg {
            transform: translateX(4px);
        }

        /* Distance pill styles */
        .card-distance-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f1f5f9;
            color: #475569;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 2px;
            align-self: flex-start;
        }
        .card-distance-pill svg {
            width: 14px;
            height: 14px;
            color: #64748b;
        }

        /* Custom Leaflet icons/popup styling */
        .leaflet-popup-content-wrapper {
            border-radius: 14px;
            padding: 4px;
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.1), 0 4px 6px -2px rgba(15, 23, 42, 0.05);
            border: 1px solid #f1f5f9;
        }
        .leaflet-popup-content {
            margin: 10px 12px;
            font-family: 'Inter', system-ui, sans-serif;
        }
        .popup-card h3 {
            font-size: 0.95rem;
            font-weight: 800;
            margin: 0 0 4px 0;
            color: #0f172a;
        }
        .popup-card p {
            font-size: 0.75rem;
            color: #64748b;
            margin: 0 0 10px 0;
            line-height: 1.3;
        }
        .popup-card .popup-btn {
            display: inline-flex;
            justify-content: center;
            width: 100%;
            padding: 6px 10px;
            background: #1e293b;
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 6px;
            text-decoration: none;
            text-align: center;
        }

        /* Marker Styles */
        .custom-map-marker {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #ffffff;
            border: 2px solid #e8a53a;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s;
        }
        .custom-map-marker.selected {
            transform: scale(1.15) !important;
            border-color: #0f172a;
            z-index: 99999 !important;
        }
        .marker-inner {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
        }
        .marker-barber {
            background: #d97706; /* Amber for Barbershop */
        }
        .marker-salon {
            background: #db2777; /* Pink/Rose for Salon */
        }

        /* User Location Pulsing Marker */
        .user-location-marker {
            width: 14px;
            height: 14px;
            background: #3b82f6;
            border: 2.5px solid #ffffff;
            border-radius: 50%;
            box-shadow: 0 0 0 6px rgba(59, 130, 246, 0.35);
            animation: pulse-blue 1.5s infinite;
        }
        @keyframes pulse-blue {
            0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.6); }
            70% { box-shadow: 0 0 0 8px rgba(59, 130, 246, 0); }
            100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
        }

        /* Responsive Breakpoints & Fluid Tweaks */
        @media (max-width: 1024px) {
            .dashboard-container {
                grid-template-columns: 60% 40%;
            }
        }
        
        @media (max-width: 768px) {
            /* Mobile View: Full screen map, locations list becomes a collapsible bottom sheet */
            .dashboard-container {
                grid-template-columns: 1fr;
                height: 100vh;
            }
            
            .map-panel {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                height: -webkit-fill-available;
            }

            .sidebar-panel {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 75vh;
                border-left: none;
                border-top-left-radius: 24px;
                border-top-right-radius: 24px;
                transform: translateY(calc(75vh - 95px)); /* default collapsed showing header */
                transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
                z-index: 1000;
                border-top: 1.5px solid #f1f5f9;
            }

            .sidebar-panel.expanded {
                transform: translateY(0);
            }
            .sidebar-panel.semi-expanded {
                transform: translateY(35vh);
            }

            .bottom-sheet-drag-handle {
                display: block;
                width: 48px;
                height: 5px;
                background: #e2e8f0;
                border-radius: 10px;
                margin: 10px auto 4px auto;
                cursor: pointer;
                flex-shrink: 0;
            }

            .sidebar-header {
                padding: 12px 24px 20px 24px;
            }

            .floating-back-btn {
                top: 16px;
                left: 16px;
                padding: 8px 14px;
                font-size: 0.8rem;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $barberData = [];
    foreach($barbershops as $b) {
        // 1. Get queue count for today (status 'menunggu' or 'sedang dilayani')
        $queueCount = \App\Models\Antrean::where('barbershop_id', $b->id)
            ->whereIn('status', ['menunggu', 'sedang dilayani'])
            ->whereDate('created_at', \Carbon\Carbon::today())
            ->count();
            
        // 2. Estimate waiting time
        $activeQueues = \App\Models\Antrean::where('barbershop_id', $b->id)
            ->whereIn('status', ['menunggu', 'sedang dilayani'])
            ->whereDate('created_at', \Carbon\Carbon::today())
            ->get();
            
        $estimatedTime = 0;
        foreach($activeQueues as $q) {
            if ($q->status === 'sedang dilayani') {
                $elapsed = now()->diffInMinutes($q->updated_at);
                $estimatedTime += max(0, ($q->total_estimasi_waktu ?? 20) - $elapsed);
            } else {
                $estimatedTime += ($q->total_estimasi_waktu ?? 20);
            }
        }
        
        // 3. Category grouping
        $category = str_contains(strtolower($b->nama), 'salon') ? 'Salon' : 'Barbershop';
        
        // 4. Staff count
        $staffCount = \App\Models\User::where('barbershop_id', $b->id)->count();
        
        // 5. Open status
        $jamBuka = \Illuminate\Support\Facades\DB::table('settings')->where('barbershop_id', $b->id)->where('key', 'queue_jam_buka')->value('value') ?? '09:00';
        $jamTutup = \Illuminate\Support\Facades\DB::table('settings')->where('barbershop_id', $b->id)->where('key', 'queue_jam_tutup')->value('value') ?? '21:00';
        $nowTime = now()->format('H:i');
        $isOpen = ($nowTime >= $jamBuka && $nowTime <= $jamTutup);
        
        // 6. Ratings
        $rating = $b->id == 1 ? 4.9 : ($b->id == 2 ? 4.7 : 4.5);
        
        // 7. Thumbnail
        $photo = $b->id == 1 
            ? 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?auto=format&fit=crop&w=400&q=80' 
            : ($b->id == 2 
                ? 'https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=400&q=80' 
                : 'https://images.unsplash.com/photo-1621605815971-fbc98d665033?auto=format&fit=crop&w=400&q=80');

        $barberData[] = [
            'id' => $b->id,
            'nama' => $b->nama,
            'slug' => $b->slug,
            'alamat' => $b->alamat ?? 'Alamat tidak tersedia',
            'latitude' => (float)$b->latitude,
            'longitude' => (float)$b->longitude,
            'category' => $category,
            'queue_count' => $queueCount,
            'estimated_time' => $estimatedTime,
            'staff_count' => $staffCount,
            'is_open' => $isOpen,
            'jam_buka' => $jamBuka,
            'jam_tutup' => $jamTutup,
            'rating' => $rating,
            'photo' => $photo,
        ];
    }
?>

<div class="dashboard-container">
    <!-- Left Column: Map -->
    <div class="map-panel">
        <a href="<?php echo e(url('/')); ?>" class="floating-back-btn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span>Kembali ke Beranda</span>
        </a>
        <div id="map"></div>
    </div>

    <!-- Right Column: Sidebar (Collapsible bottom sheet on mobile) -->
    <div class="sidebar-panel" id="sidebarPanel">
        <!-- Touch drag handle for mobile bottom sheet -->
        <div class="bottom-sheet-drag-handle" id="sheetHandle"></div>
        
        <div class="sidebar-header">
            <div class="header-top-row" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                <div class="sidebar-title-container" style="flex: 1; padding-right: 12px; text-align: left;">
                    <h1 style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0; letter-spacing: -0.02em;">Temukan Layanan</h1>
                    <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Pilih barbershop terbaik di sekitar Anda</p>
                </div>
                
                <!-- Auth Widget -->
                <div class="auth-widget">
                    <?php if(auth()->check()): ?>
                        <div class="custom-dropdown" id="customAuthDropdown">
                            <button type="button" class="custom-dropdown-btn" onclick="toggleDropdown('authMenu')" aria-haspopup="menu" aria-expanded="false" aria-label="Menu Pengguna">
                                <i class="fas fa-user-circle auth-icon" aria-hidden="true"></i>
                                <span class="username-text" style="max-width: 90px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo e(explode(' ', auth()->user()->name)[0]); ?></span>
                                <i class="fas fa-chevron-down chevron-icon" aria-hidden="true"></i>
                            </button>
                            <div class="custom-dropdown-menu" id="authMenu" role="menu">
                                <div class="dropdown-header">
                                    <div class="user-name"><?php echo e(auth()->user()->name); ?></div>
                                    <div class="user-email"><?php echo e(auth()->user()->email); ?></div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <?php if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin')): ?>
                                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="dropdown-item">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>
                                <?php endif; ?>
                                <a href="<?php echo e(route('profile.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-user-circle"></i> Profil & Booking
                                </a>
                                <form action="<?php echo e(route('logout')); ?>" method="POST" style="margin: 0;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login.user')); ?>" class="custom-dropdown-btn login-btn" style="text-decoration: none;">
                            <i class="fas fa-sign-in-alt"></i> Masuk
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Search box -->
            <div class="search-wrapper">
                <svg class="search-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" id="searchInput" placeholder="Cari nama lokasi..." class="search-input" aria-label="Cari nama lokasi barbershop">
            </div>

            <!-- Filter Categories Row -->
            <div class="filters-row">
                <span class="filter-tag active" data-filter="all">Semua</span>
                <span class="filter-tag" data-filter="barbershop">Barbershop</span>
                <span class="filter-tag" data-filter="salon">Salon</span>
                <span class="filter-tag" data-filter="open">Buka Sekarang</span>
                <span class="filter-tag" data-filter="sepi">Antrean Sepi</span>
            </div>

            <!-- Sorting & Result Info -->
            <div class="sort-row">
                <span id="resultCount">Menampilkan 0 lokasi</span>
                <div class="sort-select-wrapper">
                    <span>Urutkan:</span>
                    <select id="sortSelect" class="sort-select">
                        <option value="jarak">Jarak Terdekat</option>
                        <option value="antrean">Antrean Tersingkat</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Scrollable cards list -->
        <div class="locations-list" id="locationsList">
            <!-- Cards will be populated dynamically via JavaScript -->
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <!-- LeafletJS Script -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        // Custom Dropdown JS
        window.toggleDropdown = function(menuId) {
            const menu = document.getElementById(menuId);
            const btn = menu.previousElementSibling;
            
            // Close all other custom dropdowns
            document.querySelectorAll('.custom-dropdown-menu').forEach(m => {
                if (m.id !== menuId) {
                    m.classList.remove('show');
                    m.previousElementSibling.classList.remove('active');
                }
            });
            
            // Toggle current
            menu.classList.toggle('show');
            btn.classList.toggle('active');
        };
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.custom-dropdown')) {
                document.querySelectorAll('.custom-dropdown-menu').forEach(m => {
                    m.classList.remove('show');
                    m.previousElementSibling.classList.remove('active');
                });
            }
        });
        // Set data barbershops dari backend
        const originalBarbershops = <?php echo json_encode($barberData, 15, 512) ?>;
        let barbershops = [...originalBarbershops];

        // Koordinat default (Balige Center) jika koordinat user tidak tersedia
        const fallbackCoordinates = { lat: 2.3845, lng: 99.1480 };
        let userLocation = null;

        // Inisialisasi Leaflet Map
        var map = L.map('map', {
            zoomControl: false // matikan default zoom agar posisi custom lebih pas
        }).setView([fallbackCoordinates.lat, fallbackCoordinates.lng], 14);

        // Tambahkan tombol zoom di pojok kanan atas agar estetik
        L.control.zoom({ position: 'topright' }).addTo(map);

        // Map Tile Layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Objek untuk menyimpan markers
        let markers = {};
        let userLocationMarker = null;

        // Filter status
        let activeFilter = 'all';
        let searchQuery = '';
        let sortBy = 'jarak';

        // Hitung jarak Haversine (km)
        function getDistance(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = 
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
                Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }

        // Tentukan tingkat kepadatan antrean
        function getQueueStatus(count) {
            if (count <= 1) {
                return { class: 'queue-sepi', text: count === 0 ? 'Tidak ada antrean' : '1 antrean', label: 'Sepi' };
            } else if (count <= 4) {
                return { class: 'queue-sedang', text: `${count} pelanggan menunggu`, label: 'Sedang' };
            } else {
                return { class: 'queue-ramai', text: `${count} pelanggan menunggu`, label: 'Ramai' };
            }
        }

        // Fungsi inisialisasi & refresh Markers di peta
        function updateMapMarkers() {
            // Hapus markers yang ada
            Object.values(markers).forEach(m => map.removeLayer(m));
            markers = {};

            // Tambahkan markers yang sesuai filter saja
            barbershops.forEach(b => {
                if (b.latitude && b.longitude) {
                    const iconColorClass = b.category.toLowerCase() === 'salon' ? 'marker-salon' : 'marker-barber';
                    const iconSvg = b.category.toLowerCase() === 'salon'
                        ? `<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>` // Simbol Salon/Plus
                        : `<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>`; // Simbol Barber/Informasi

                    const customIcon = L.divIcon({
                        className: `custom-map-marker-container`,
                        html: `<div class="custom-map-marker" id="marker-${b.id}"><div class="marker-inner ${iconColorClass}">${iconSvg}</div></div>`,
                        iconSize: [36, 36],
                        iconAnchor: [18, 18]
                    });

                    const marker = L.marker([b.latitude, b.longitude], { icon: customIcon }).addTo(map);

                    const popupContent = `
                        <div class="popup-card">
                            <h3>${b.nama}</h3>
                            <p>${b.alamat.substring(0, 50)}...</p>
                            <a href="/${b.slug}" class="popup-btn">Kunjungi</a>
                        </div>
                    `;
                    marker.bindPopup(popupContent);
                    
                    // Event marker diklik
                    marker.on('click', () => {
                        selectLocationCard(b.id);
                        map.setView([b.latitude, b.longitude], 15);
                        
                        // Pada mobile, expand bottom sheet saat marker diklik agar infonya terlihat
                        if (window.innerWidth <= 768) {
                            const panel = document.getElementById('sidebarPanel');
                            panel.classList.remove('semi-expanded');
                            panel.classList.add('expanded');
                        }
                    });

                    markers[b.id] = marker;
                }
            });
        }

        // Highlight & Scroll list ke Card yang terpilih
        function selectLocationCard(id) {
            // Hapus kelas selected dari seluruh card & marker
            document.querySelectorAll('.location-card').forEach(c => c.classList.remove('selected'));
            document.querySelectorAll('.custom-map-marker').forEach(m => m.classList.remove('selected'));

            const selectedCard = document.getElementById(`card-${id}`);
            if (selectedCard) {
                selectedCard.classList.add('selected');
                selectedCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            const selectedMarker = document.getElementById(`marker-${id}`);
            if (selectedMarker) {
                selectedMarker.classList.add('selected');
            }
        }

        // Pindahkan peta ke koordinat tertentu
        function focusLocationOnMap(lat, lng, id) {
            map.setView([lat, lng], 16, {
                animate: true,
                duration: 0.8
            });

            if (markers[id]) {
                setTimeout(() => {
                    markers[id].openPopup();
                }, 300);
            }
            selectLocationCard(id);

            // Pada mobile, collapse bottom sheet ke semi-expanded agar peta terlihat jelas saat di-focus
            if (window.innerWidth <= 768) {
                const panel = document.getElementById('sidebarPanel');
                panel.classList.remove('expanded');
                panel.classList.add('semi-expanded');
            }
        }

        // Render List Cards
        function renderLocationsList() {
            const listContainer = document.getElementById('locationsList');
            const resultCountEl = document.getElementById('resultCount');
            listContainer.innerHTML = '';

            resultCountEl.textContent = `Menampilkan ${barbershops.length} lokasi`;

            if (barbershops.length === 0) {
                listContainer.innerHTML = `
                    <div class="empty-state">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        <p>Tidak ada lokasi yang cocok dengan pencarian atau filter Anda.</p>
                    </div>
                `;
                return;
            }

            barbershops.forEach(b => {
                const qStatus = getQueueStatus(b.queue_count);
                const distanceText = b.distance !== undefined ? `${b.distance.toFixed(1)} km dari lokasi Anda` : 'Menghitung jarak...';
                const statusBadgeClass = b.is_open ? 'status-buka' : 'status-tutup';
                const statusText = b.is_open ? 'BUKA' : 'TUTUP';

                 const cardHtml = `
                    <div class="location-card" id="card-${b.id}" onclick="focusLocationOnMap(${b.latitude}, ${b.longitude}, ${b.id})">
                        <div class="card-image-wrapper">
                            <img src="${b.photo}" alt="${b.nama}" class="card-image">
                            <span class="card-badge-category">${b.category}</span>
                            <span class="card-badge-status ${statusBadgeClass}">${statusText}</span>
                        </div>
                        <div class="card-content">
                            <div class="card-header-info">
                                <h2 class="card-name">${b.nama}</h2>
                            </div>
                            
                            <p class="card-address">${b.alamat}</p>
                            
                            <div class="card-distance-pill">
                                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                <span>${distanceText}</span>
                            </div>

                            <div class="queue-badge ${qStatus.class}">
                                <div class="queue-badge-title">
                                    <span class="queue-dot"></span>
                                    <span>${qStatus.text}</span>
                                </div>
                                <span class="queue-time">Est: ${b.estimated_time} menit</span>
                            </div>

                            <div class="card-actions">
                                <a href="/${b.slug}" class="btn-primary-action" onclick="event.stopPropagation();">
                                    <span>Cek Lokasi</span>
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                `;
                listContainer.insertAdjacentHTML('beforeend', cardHtml);
            });
        }

        // Handler untuk hitung ulang jarak dan refresh tampilan
        function recalculateDistances(lat, lng) {
            barbershops.forEach(b => {
                b.distance = getDistance(lat, lng, b.latitude, b.longitude);
            });
            sortAndFilter();
        }

        // Sorting & Filtering Master Function
        function sortAndFilter() {
            // 1. Filter
            barbershops = originalBarbershops.filter(b => {
                // Search match
                const matchesSearch = b.nama.toLowerCase().includes(searchQuery.toLowerCase()) || 
                                      b.alamat.toLowerCase().includes(searchQuery.toLowerCase());
                
                if (!matchesSearch) return false;

                // Category & density filters
                if (activeFilter === 'all') return true;
                if (activeFilter === 'barbershop') return b.category.toLowerCase() === 'barbershop';
                if (activeFilter === 'salon') return b.category.toLowerCase() === 'salon';
                if (activeFilter === 'open') return b.is_open === true;
                if (activeFilter === 'sepi') return b.queue_count <= 1;

                return true;
            });

            // 2. Sort
            if (sortBy === 'jarak') {
                barbershops.sort((a, b) => (a.distance || 0) - (b.distance || 0));
            } else if (sortBy === 'antrean') {
                barbershops.sort((a, b) => a.queue_count - b.queue_count);
            } else if (sortBy === 'rating') {
                barbershops.sort((a, b) => b.rating - a.rating);
            }

            // 3. Render
            renderLocationsList();
            updateMapMarkers();
        }

        // Inisialisasi Lokasi Pengguna
        function initGeolocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    position => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        userLocation = { lat, lng };

                        // Buat marker lokasi pengguna
                        const userIcon = L.divIcon({
                            className: 'user-location-marker-container',
                            html: '<div class="user-location-marker"></div>',
                            iconSize: [20, 20],
                            iconAnchor: [10, 10]
                        });
                        
                        if (userLocationMarker) {
                            map.removeLayer(userLocationMarker);
                        }
                        userLocationMarker = L.marker([lat, lng], { icon: userIcon }).addTo(map);

                        // Hitung jarak dari posisi user yang baru
                        recalculateDistances(lat, lng);
                        
                        // Posisikan peta agar memuat user dan lokasi barbershop terdekat
                        const bounds = L.latLngBounds([
                            [lat, lng],
                            ...originalBarbershops.map(b => [b.latitude, b.longitude])
                        ]);
                        map.fitBounds(bounds, { padding: [50, 50] });
                    },
                    error => {
                        console.warn("Geolocation failed or denied. Using Balige Town Center as default.", error);
                        userLocation = fallbackCoordinates;
                        recalculateDistances(fallbackCoordinates.lat, fallbackCoordinates.lng);
                    },
                    { enableHighAccuracy: true, timeout: 5000 }
                );
            } else {
                userLocation = fallbackCoordinates;
                recalculateDistances(fallbackCoordinates.lat, fallbackCoordinates.lng);
            }
        }

        // EVENT LISTENERS

        // Search Input
        document.getElementById('searchInput').addEventListener('input', e => {
            searchQuery = e.target.value;
            sortAndFilter();
        });

        // Category Filter tags
        document.querySelectorAll('.filter-tag').forEach(tag => {
            tag.addEventListener('click', () => {
                document.querySelectorAll('.filter-tag').forEach(t => t.classList.remove('active'));
                tag.classList.add('active');
                activeFilter = tag.getAttribute('data-filter');
                sortAndFilter();
            });
        });

        // Sorting select
        document.getElementById('sortSelect').addEventListener('change', e => {
            sortBy = e.target.value;
            sortAndFilter();
        });

        // Responsive Bottom Sheet Drag & Snap Controls untuk Mobile
        const sidebarPanel = document.getElementById('sidebarPanel');
        const sheetHandle = document.getElementById('sheetHandle');
        
        // Klik handle bottom sheet untuk snap tinggi (collapsed -> semi-expanded -> expanded)
        sheetHandle.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                if (sidebarPanel.classList.contains('expanded')) {
                    sidebarPanel.classList.remove('expanded');
                    sidebarPanel.classList.add('semi-expanded');
                } else if (sidebarPanel.classList.contains('semi-expanded')) {
                    sidebarPanel.classList.remove('semi-expanded');
                } else {
                    sidebarPanel.classList.add('semi-expanded');
                }
            }
        });

        // Tambah event touch gesture ringan
        let startY = 0;
        let currentTransform = 0;
        
        sheetHandle.addEventListener('touchstart', e => {
            startY = e.touches[0].clientY;
            sidebarPanel.style.transition = 'none'; // nonaktifkan transition agar drag terasa instan
        });

        sheetHandle.addEventListener('touchmove', e => {
            const currentY = e.touches[0].clientY;
            const diffY = currentY - startY;
            
            // Batasi drag ke bawah saja atau atas saja secara dinamis
            if (window.innerWidth <= 768) {
                if (diffY < -20) {
                    sidebarPanel.classList.add('expanded');
                    sidebarPanel.classList.remove('semi-expanded');
                } else if (diffY > 20) {
                    if (sidebarPanel.classList.contains('expanded')) {
                        sidebarPanel.classList.remove('expanded');
                        sidebarPanel.classList.add('semi-expanded');
                    } else {
                        sidebarPanel.classList.remove('semi-expanded');
                    }
                }
            }
        });

        sheetHandle.addEventListener('touchend', () => {
            sidebarPanel.style.transition = ''; // kembalikan smooth transition
        });

        // Initial launch sequence
        initGeolocation();
        sortAndFilter();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH K:\Deploy-Argahomes\resources\views/pelanggan/map.blade.php ENDPATH**/ ?>