# Laravel Sanctum API Testing Examples

## 1. Register User Baru
```bash
curl -X POST http://localhost:8081/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com", 
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

**Response:**
```json
{
  "message": "User registered successfully",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2025-08-02T07:45:00.000000Z",
    "updated_at": "2025-08-02T07:45:00.000000Z"
  },
  "access_token": "1|wk8sLBKgTsBgQCIwyNX0QMZ3RVfrHYm69mqcmb30827c5b1",
  "token_type": "Bearer"
}
```

## 2. Login User
```bash
curl -X POST http://localhost:8081/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

**Response:**
```json
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "access_token": "2|Ab3dEf5gHi6jKl7mNo8pQr9sT0uVw1xY2zA3bC4dE5f",
  "token_type": "Bearer"
}
```

## 3. Akses User Profile (Protected Route)
```bash
curl -X GET http://localhost:8081/api/auth/user \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json"
```

**Response:**
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "email_verified_at": null,
    "created_at": "2025-08-02T07:45:00.000000Z",
    "updated_at": "2025-08-02T07:45:00.000000Z"
  }
}
```

## 4. Akses Room API (Protected)
```bash
curl -X GET http://localhost:8081/api/rooms \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json"
```

## 5. Create Room (Protected)
```bash
curl -X POST http://localhost:8081/api/rooms \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Meeting Room A",
    "capacity": 10,
    "location": "Floor 1",
    "description": "Small meeting room with projector"
  }'
```

## 6. Logout (Revoke Current Token)
```bash
curl -X POST http://localhost:8081/api/auth/logout \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json"
```

**Response:**
```json
{
  "message": "Logged out successfully"
}
```

## 7. Revoke All Tokens
```bash
curl -X POST http://localhost:8081/api/auth/revoke-all \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json"
```

**Response:**
```json
{
  "message": "All tokens revoked successfully"
}
```
