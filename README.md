# Pelatihan Laravel - Multi-Service Docker Setup

This repository contains two Laravel applications configured to run with Docker Compose:

- **Portal Booking**: A booking portal application
- **Room Service (Layanan Ruangan)**: A room service management application

## Project Structure

```
pelatihan-laravel/
├── docker-compose.yml          # Main Docker Compose configuration
├── .env                        # Environment variables for databases
├── nginx/                      # Nginx configurations
│   └── room-service.conf      # Nginx config for room service
├── portal-booking/            # Portal booking Laravel application
│   ├── Dockerfile
│   └── docker-compose/
│       └── nginx/             # Portal booking nginx config
└── layanan-ruangan/           # Room service Laravel application
    └── Dockerfile
```

## Services

The setup includes 6 Docker services:

### Portal Booking Services
- **portal-booking-app**: PHP-FPM application container
- **portal-booking-nginx**: Nginx web server (Port: 8080)
- **portal-booking-db**: MySQL database (Port: 3306)

### Room Service Services
- **room-service-app**: PHP-FPM application container
- **room-service-nginx**: Nginx web server (Port: 8081)
- **room-service-db**: MySQL database (Port: 3307)

## Getting Started

1. **Clone and Navigate to the Project**
   ```bash
   cd pelatihan-laravel
   ```

2. **Build and Start All Services**
   ```bash
   docker-compose up -d --build
   ```

3. **Access the Applications**
   - Portal Booking: http://localhost:8080
   - Room Service: http://localhost:8081

4. **Stop All Services**
   ```bash
   docker-compose down
   ```

5. **View Service Logs**
   ```bash
   # All services
   docker-compose logs
   
   # Specific service
   docker-compose logs portal-booking-app
   docker-compose logs room-service-app
   ```

## Database Configuration

Database credentials are stored in the `.env` file:

- **Portal Booking DB**: `portal_booking` database on port 3306
- **Room Service DB**: `room_service` database on port 3307

## Development Commands

### Portal Booking
```bash
# Run Laravel commands
docker-compose exec portal-booking-app php artisan migrate
docker-compose exec portal-booking-app php artisan db:seed
docker-compose exec portal-booking-app composer install

# Access container shell
docker-compose exec portal-booking-app sh
```

### Room Service
```bash
# Run Laravel commands
docker-compose exec room-service-app php artisan migrate
docker-compose exec room-service-app php artisan db:seed
docker-compose exec room-service-app composer install

# Access container shell
docker-compose exec room-service-app sh
```

## Notes

- Each application has its own isolated network
- Database data is persisted using Docker volumes
- Both applications use PHP 8.2-FPM-Alpine base image
- Nginx configurations are optimized for Laravel applications
