<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Room Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #fafafa;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .header h1 {
            font-size: 2.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            letter-spacing: -0.02em;
        }
        
        .header p {
            color: #6c757d;
            font-size: 1.1rem;
        }
        
        .main-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            padding: 40px;
            margin-bottom: 30px;
        }
        
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background: #F97A00;
            color: white;
            box-shadow: 0 2px 8px rgba(249, 122, 0, 0.2);
        }
        
        .btn-primary:hover {
            background: #e66a00;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(249, 122, 0, 0.3);
        }
        
        .btn-secondary {
            background: #f8f9fa;
            color: #6c757d;
            border: 1px solid #e9ecef;
        }
        
        .btn-secondary:hover {
            background: #e9ecef;
            color: #495057;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .btn-sm {
            padding: 8px 16px;
            font-size: 0.9rem;
        }
        
        .search-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 30px;
        }
        
        .search-input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            font-size: 1rem;
            background: #f8f9fa;
            transition: all 0.2s ease;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #F97A00;
            background: white;
            box-shadow: 0 0 0 3px rgba(249, 122, 0, 0.1);
        }
        
        .room-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .room-card {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 16px;
            padding: 24px;
            transition: all 0.2s ease;
            position: relative;
        }
        
        .room-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border-color: #F97A00;
        }
        
        .room-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }
        
        .room-name {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 4px;
        }
        
        .room-capacity {
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        .room-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-available {
            background: #d4edda;
            color: #155724;
        }
        
        .status-occupied {
            background: #f8d7da;
            color: #721c24;
        }
        
        .status-maintenance {
            background: #fff3cd;
            color: #856404;
        }
        
        .room-description {
            color: #6c757d;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        
        .room-actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }
        
        .icon-btn {
            padding: 8px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            background: #f8f9fa;
            color: #6c757d;
        }
        
        .icon-btn:hover {
            transform: scale(1.1);
        }
        
        .icon-btn.edit:hover {
            background: #F97A00;
            color: white;
        }
        
        .icon-btn.delete:hover {
            background: #dc3545;
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        
        .empty-state svg {
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .empty-state h3 {
            font-size: 1.3rem;
            margin-bottom: 8px;
            color: #495057;
        }
        
        .empty-state p {
            margin-bottom: 24px;
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
        }
        
        .modal-content {
            background: white;
            border-radius: 20px;
            padding: 40px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }
        
        .modal.show .modal-content {
            transform: scale(1);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6c757d;
            padding: 4px;
            border-radius: 4px;
        }
        
        .close-btn:hover {
            background: #f8f9fa;
            color: #495057;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #495057;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.2s ease;
            background: #f8f9fa;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #F97A00;
            background: white;
            box-shadow: 0 0 0 3px rgba(249, 122, 0, 0.1);
        }
        
        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            appearance: none;
        }
        
        .modal-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 30px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 600;
            color: #F97A00;
            margin-bottom: 8px;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 20px 16px;
            }
            
            .main-card {
                padding: 24px;
            }
            
            .action-bar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-bar {
                flex-direction: column;
            }
            
            .room-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Room Management</h1>
            <p>Manage your rooms efficiently with our modern interface</p>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number" id="totalRooms">{{ isset($rooms) ? count($rooms) : 0 }}</div>
                <div class="stat-label">Total Rooms</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="availableRooms">{{ isset($rooms) ? collect($rooms)->where('status', 'available')->count() : 0 }}</div>
                <div class="stat-label">Available</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="occupiedRooms">{{ isset($rooms) ? collect($rooms)->where('status', 'occupied')->count() : 0 }}</div>
                <div class="stat-label">Occupied</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="maintenanceRooms">{{ isset($rooms) ? collect($rooms)->where('status', 'maintenance')->count() : 0 }}</div>
                <div class="stat-label">Maintenance</div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-card">
            <!-- Action Bar -->
            <div class="action-bar">
                <h2 class="section-title">All Rooms</h2>
                <button class="btn btn-primary" onclick="openModal('add')">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14m-7-7h14"/>
                    </svg>
                    Add New Room
                </button>
            </div>

            <!-- Search Bar -->
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="Search rooms..." id="searchInput" onkeyup="searchRooms()">
                <select class="form-input form-select" id="statusFilter" onchange="filterRooms()">
                    <option value="">All Status</option>
                    <option value="available">Available</option>
                    <option value="occupied">Occupied</option>
                    <option value="maintenance">Maintenance</option>
                </select>
            </div>

            <!-- Rooms Grid -->
            <div class="room-grid" id="roomsGrid">
                {{-- Check if rooms exist and display them --}}
                @if(isset($rooms) && count($rooms) > 0)
                    @foreach($rooms as $room)
                        <div class="room-card" data-name="{{ strtolower($room->name) }}" data-status="{{ $room->status ?? 'available' }}">
                            <div class="room-header">
                                <div>
                                    <div class="room-name">{{ $room->name }}</div>
                                    <div class="room-capacity">Capacity: {{ $room->capacity ?? '10' }} people</div>
                                </div>
                                <span class="room-status status-{{ $room->status ?? 'available' }}">
                                    {{ ucfirst($room->status ?? 'available') }}
                                </span>
                            </div>
                            
                            <div class="room-description">
                                {{ $room->description ?? 'A comfortable meeting room perfect for team collaboration and presentations.' }}
                            </div>
                            
                            <div class="room-actions">
                                <button class="icon-btn edit" onclick="openModal('edit', {{ $room->id ?? 1 }})" title="Edit Room">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/>
                                    </svg>
                                </button>
                                <button class="icon-btn delete" onclick="deleteRoom({{ $room->id ?? 1 }})" title="Delete Room">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 6h18"/><path d="M8 6v12a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M5 6V4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Empty State -->
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <svg width="80" height="80" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9a2 2 0 0 1 2-2h.93a2 2 0 0 0 1.664-.89l.812-1.22A2 2 0 0 1 10.07 4h3.86a2 2 0 0 1 1.664.89l.812 1.22A2 2 0 0 0 18.07 7H19a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9z"/>
                            <path d="M15 13a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                        </svg>
                        <h3>No rooms found</h3>
                        <p>Start by adding your first room to the system</p>
                        <button class="btn btn-primary" onclick="openModal('add')">Add First Room</button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add/Edit Room Modal -->
    <div class="modal" id="roomModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalTitle">Add New Room</h3>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            
            <form id="roomForm" onsubmit="handleSubmit(event)">
                <input type="hidden" id="roomId" name="id">
                
                <div class="form-group">
                    <label class="form-label" for="roomName">Room Name *</label>
                    <input type="text" class="form-input" id="roomName" name="name" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="roomCapacity">Capacity *</label>
                    <input type="number" class="form-input" id="roomCapacity" name="capacity" min="1" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="roomStatus">Status</label>
                    <select class="form-input form-select" id="roomStatus" name="status">
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="roomDescription">Description</label>
                    <textarea class="form-input form-textarea" id="roomDescription" name="description" placeholder="Enter room description..."></textarea>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Add Room</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // CSRF Token for API requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Set up axios defaults
        if (window.axios) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
        }

        // Sample data for demonstration (replace with actual data from backend)
        let rooms = @json($rooms ?? []);
        let currentEditId = null;

        // Modal functions
        function openModal(mode, id = null) {
            const modal = document.getElementById('roomModal');
            const title = document.getElementById('modalTitle');
            const submitBtn = document.getElementById('submitBtn');
            const form = document.getElementById('roomForm');
            
            if (mode === 'add') {
                title.textContent = 'Add New Room';
                submitBtn.textContent = 'Add Room';
                form.reset();
                currentEditId = null;
            } else if (mode === 'edit') {
                title.textContent = 'Edit Room';
                submitBtn.textContent = 'Update Room';
                currentEditId = id;
                
                // Fetch room data from API
                fetchRoomData(id);
            }
            
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('roomModal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
            currentEditId = null;
        }

        // Fetch room data for editing
        async function fetchRoomData(id) {
            try {
                const response = await fetch(`/api/rooms/${id}`);
                const result = await response.json();
                
                if (result.success) {
                    const room = result.data;
                    document.getElementById('roomName').value = room.name || '';
                    document.getElementById('roomCapacity').value = room.capacity || '';
                    document.getElementById('roomStatus').value = room.status || 'available';
                    document.getElementById('roomDescription').value = room.description || '';
                }
            } catch (error) {
                console.error('Error fetching room data:', error);
                alert('Error loading room data');
            }
        }

        // Form submission
        async function handleSubmit(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            const data = {
                name: formData.get('name'),
                capacity: parseInt(formData.get('capacity')),
                status: formData.get('status'),
                description: formData.get('description')
            };
            
            try {
                let response;
                if (currentEditId) {
                    // Update existing room
                    response = await fetch(`/api/rooms/${currentEditId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });
                } else {
                    // Create new room
                    response = await fetch('/api/rooms', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });
                }
                
                const result = await response.json();
                
                if (result.success) {
                    alert(result.message);
                    closeModal();
                    location.reload(); // Refresh the page to show updated data
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error submitting form:', error);
                alert('Error submitting form');
            }
        }

        // Search functionality
        async function searchRooms() {
            const searchTerm = document.getElementById('searchInput').value;
            const statusFilter = document.getElementById('statusFilter').value;
            
            try {
                const params = new URLSearchParams();
                if (searchTerm) params.append('search', searchTerm);
                if (statusFilter) params.append('status', statusFilter);
                
                const response = await fetch(`/api/rooms/search?${params}`);
                const result = await response.json();
                
                if (result.success) {
                    updateRoomsGrid(result.rooms);
                }
            } catch (error) {
                console.error('Error searching rooms:', error);
            }
        }

        // Filter functionality
        function filterRooms() {
            searchRooms(); // Use the same search function
        }

        // Update rooms grid with new data
        function updateRoomsGrid(rooms) {
            const grid = document.getElementById('roomsGrid');
            
            if (rooms.length === 0) {
                grid.innerHTML = `
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <svg width="80" height="80" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9a2 2 0 0 1 2-2h.93a2 2 0 0 0 1.664-.89l.812-1.22A2 2 0 0 1 10.07 4h3.86a2 2 0 0 1 1.664.89l.812 1.22A2 2 0 0 0 18.07 7H19a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9z"/>
                            <path d="M15 13a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                        </svg>
                        <h3>No rooms found</h3>
                        <p>Try adjusting your search criteria</p>
                    </div>
                `;
                return;
            }
            
            grid.innerHTML = rooms.map(room => `
                <div class="room-card" data-name="${room.name.toLowerCase()}" data-status="${room.status}">
                    <div class="room-header">
                        <div>
                            <div class="room-name">${room.name}</div>
                            <div class="room-capacity">Capacity: ${room.capacity} people</div>
                        </div>
                        <span class="room-status status-${room.status}">
                            ${room.status.charAt(0).toUpperCase() + room.status.slice(1)}
                        </span>
                    </div>
                    
                    <div class="room-description">
                        ${room.description || 'A comfortable meeting room perfect for team collaboration and presentations.'}
                    </div>
                    
                    <div class="room-actions">
                        <button class="icon-btn edit" onclick="openModal('edit', ${room.id})" title="Edit Room">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/>
                            </svg>
                        </button>
                        <button class="icon-btn delete" onclick="deleteRoom(${room.id})" title="Delete Room">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 6h18"/><path d="M8 6v12a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M5 6V4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/>
                            </svg>
                        </button>
                    </div>
                </div>
            `).join('');
        }

        // Delete room
        async function deleteRoom(id) {
            if (confirm('Are you sure you want to delete this room? This action cannot be undone.')) {
                try {
                    const response = await fetch(`/api/rooms/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        alert(result.message);
                        location.reload(); // Refresh the page
                    } else {
                        alert('Error deleting room');
                    }
                } catch (error) {
                    console.error('Error deleting room:', error);
                    alert('Error deleting room');
                }
            }
        }

        // Load statistics on page load
        async function loadStatistics() {
            try {
                const response = await fetch('/api/rooms/statistics');
                const result = await response.json();
                
                if (result.success) {
                    const stats = result.stats;
                    document.getElementById('totalRooms').textContent = stats.total;
                    document.getElementById('availableRooms').textContent = stats.available;
                    document.getElementById('occupiedRooms').textContent = stats.occupied;
                    document.getElementById('maintenanceRooms').textContent = stats.maintenance;
                }
            } catch (error) {
                console.error('Error loading statistics:', error);
            }
        }

        // Close modal when clicking outside
        document.getElementById('roomModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Load statistics when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadStatistics();
        });
    </script>
</body>
</html>
