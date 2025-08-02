# Configuration Updates - Multi-Service Integration

This document outlines all the changes made to integrate the Portal Booking and Room Service applications using Docker Compose with API communication.

## 🔧 Changes Made

### 1. Nginx Configuration Updates

#### Portal Booking Nginx (`portal-booking/docker-compose/nginx/default.conf`)
- **Changed**: `fastcgi_pass app:9000` → `fastcgi_pass portal-booking-app:9000`
- **Purpose**: Use specific Docker service name for PHP-FPM communication

#### Room Service Nginx (`nginx/room-service.conf`)
- **Status**: Already correctly configured with `fastcgi_pass room-service-app:9000`

### 2. Database Configuration Updates

#### Portal Booking `.env`
```env
# Before
DB_HOST=mysql

# After  
DB_HOST=portal-booking-db
```

#### Room Service `.env`
```env
# Before
DB_HOST=127.0.0.1

# After
DB_HOST=room-service-db
```

### 3. API Integration Updates

#### RoomService Class (`portal-booking/app/Services/RoomService.php`)
- **Changed**: `$this->apiBaseUrl = 'http://127.0.0.1:8001/api'` 
- **To**: `$this->apiBaseUrl = 'http://room-service-nginx/api'`
- **Purpose**: Use Docker service name for inter-service communication

### 4. View Creation

#### Created `portal-booking/resources/views/bookings/create.blade.php`
- Responsive form with Tailwind CSS styling
- Dynamic room dropdown populated from API
- Form validation and error handling
- JavaScript for datetime validation
- Handles API unavailability gracefully

### 5. Docker Network Configuration

#### Updated `docker-compose.yml`
- Added `shared-network` for inter-service communication
- Both portal-booking-app and room-service-nginx services are now on shared network
- Enables portal-booking to communicate with room-service API

```yaml
# Services that need inter-service communication
portal-booking-app:
  networks:
    - portal-booking-network
    - shared-network

room-service-nginx:
  networks:
    - room-service-network  
    - shared-network
```

## 🚀 How It Works

### API Communication Flow
1. **Portal Booking** needs room data for booking form
2. **BookingController** calls `RoomService::getAllRooms()`
3. **RoomService** makes HTTP request to `http://room-service-nginx/api/rooms`
4. **Room Service Nginx** forwards request to **room-service-app**
5. **RoomController** returns room data as JSON
6. **Portal Booking** displays rooms in dropdown

### Network Architecture
```
┌─────────────────┐    ┌─────────────────┐
│ Portal Booking  │    │  Room Service   │
│    Network      │    │    Network      │
├─────────────────┤    ├─────────────────┤
│ booking-app     │    │ room-app        │
│ booking-nginx   │────│ room-nginx      │
│ booking-db      │    │ room-db         │
└─────────────────┘    └─────────────────┘
        │                       │
        └──── Shared Network ───┘
```

## 🔍 Key Features

### Booking Form (`create.blade.php`)
- **Dynamic Room Loading**: Rooms are fetched from room-service API
- **Error Handling**: Shows message if room service is unavailable  
- **Form Validation**: Client-side and server-side validation
- **Responsive Design**: Works on mobile and desktop
- **User Experience**: Real-time datetime validation

### API Integration Benefits
- **Microservice Architecture**: Services are loosely coupled
- **Single Source of Truth**: Room data comes from dedicated service
- **Scalability**: Services can be scaled independently
- **Reliability**: Graceful degradation if room service is down

## 🛠️ Development Commands

### Start All Services
```bash
cd "c:\Users\Kaochoz\Pelatihan-laravel"
docker-compose up -d --build
```

### Check Service Communication
```bash
# Test room service API directly
curl http://localhost:8081/api/rooms

# Check portal booking can access room service
docker-compose exec portal-booking-app curl http://room-service-nginx/api/rooms
```

### View Logs
```bash
# Portal booking logs
docker-compose logs portal-booking-app

# Room service logs  
docker-compose logs room-service-app
```

## 🌐 Access URLs

- **Portal Booking**: http://localhost:8080
- **Room Service**: http://localhost:8081
- **Portal Booking Create**: http://localhost:8080/bookings/create
- **Room Service API**: http://localhost:8081/api/rooms

## 🔒 Security Considerations

- Services communicate through internal Docker networks
- API endpoints are accessible within Docker network only
- Database credentials are isolated per service
- Environment variables stored in secure .env files

## 📝 Next Steps

1. **Authentication**: Consider adding API authentication between services
2. **Caching**: Implement caching for room data to reduce API calls
3. **Error Handling**: Add retry logic for failed API calls
4. **Monitoring**: Add health checks and monitoring
5. **Testing**: Create integration tests for API communication
