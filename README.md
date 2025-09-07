# 🌍 Tourist Guide - Travel Booking Platform

A comprehensive Laravel-based Tourist Guide and Travel Booking Platform that revolutionizes the way travelers discover, book, and manage their travel experiences. This full-featured application provides seamless integration between tourists, service providers, and administrators.

## 📋 Table of Contents
- [Features](#-features)
- [Technology Stack](#-technology-stack)
- [Installation](#-installation)
- [API Documentation](#-api-documentation)
- [Project Structure](#-project-structure)
- [Usage](#-usage)
- [Contributing](#-contributing)
- [License](#-license)

## ✨ Features

### 🎯 Core Functionality
- **Tourist Management**: Complete user registration, authentication, and profile management
- **Event Discovery**: Browse and search through various tourist events and activities
- **Hotel Booking System**: Comprehensive hotel search, booking, and management
- **Real-time Availability**: Live updates on event slots and hotel room availability
- **Booking Management**: End-to-end booking process with confirmation and payment integration

### 🔐 Authentication & Security
- Multi-role authentication (Tourists, Admin, Service Providers)
- JWT token-based API authentication
- Secure password handling with Laravel's built-in encryption
- Role-based access control (RBAC)

### 📱 API & Integration
- RESTful API endpoints for mobile app integration
- Comprehensive API documentation
- JSON response formatting
- Error handling and validation

### 🎨 Admin Dashboard
- User management and analytics
- Event and hotel content management
- Booking oversight and reporting
- System configuration and settings

### 🌐 User Experience
- Responsive web interface
- Intuitive booking flow
- Search and filtering capabilities
- Multi-language support ready

## 🛠 Technology Stack

### Backend
- **Framework**: Laravel 12 (PHP)
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Sanctum/JWT
- **API**: RESTful architecture
- **Validation**: Laravel Form Requests

### Frontend
- **Blade Templates**: Server-side rendering
- **CSS Framework**: Bootstrap/Tailwind CSS
- **JavaScript**: Vanilla JS/Alpine.js
- **Icons**: Font Awesome/Heroicons

### Development Tools
- **Package Manager**: Composer (PHP), NPM (JS)
- **Build Tools**: Laravel Mix/Vite
- **Version Control**: Git
- **Testing**: PHPUnit, Laravel Dusk

## 🚀 Installation

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/PostgreSQL database
- Web server (Apache/Nginx)

### Step-by-step Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/AnasOmarObaid/tourist-guide.git
   cd tourist-guide
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Setup**
   - Configure your database credentials in `.env`
   - Run migrations and seeders:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build Assets**
   ```bash
   npm run build
   # or for development
   npm run dev
   ```

7. **Start the Development Server**
   ```bash
   php artisan serve
   ```

## 📚 API Documentation

### Authentication Endpoints
```
POST /api/register        - User registration
POST /api/login          - User login
POST /api/logout         - User logout
POST /api/refresh        - Refresh token
```

### Tourist Endpoints
```
GET  /api/events         - List all events
GET  /api/events/{id}    - Get event details
POST /api/events/book    - Book an event

GET  /api/hotels         - List all hotels
GET  /api/hotels/{id}    - Get hotel details
POST /api/hotels/book    - Book a hotel room
```

### Booking Management
```
GET  /api/bookings       - User's bookings
GET  /api/bookings/{id}  - Booking details
PUT  /api/bookings/{id}  - Update booking
DEL  /api/bookings/{id}  - Cancel booking
```

## 📁 Project Structure

```
tourist-guide/
├── app/
│   ├── Http/Controllers/
│   │   ├── API/         # API Controllers
│   │   └── Web/         # Web Controllers
│   ├── Models/          # Eloquent Models
│   ├── Services/        # Business Logic
│   └── Repositories/    # Data Access Layer
├── database/
│   ├── migrations/      # Database Migrations
│   └── seeders/         # Database Seeders
├── resources/
│   ├── views/           # Blade Templates
│   ├── js/             # JavaScript Files
│   └── css/            # Stylesheets
├── routes/
│   ├── api.php         # API Routes
│   └── web.php         # Web Routes
└── public/             # Public Assets
```

## 🆕 What's New (2025-09)

- Dashboard enhancements
  - KPI widgets: Revenue Today, Revenue This Month, Avg Order Value
  - Charts: Monthly revenue (Tickets vs Bookings), Orders (last 7 days), Booking status distribution
  - Top Cities lists by paid tickets and paid bookings
  - Polished tables for Latest 10 Bookings and Latest 10 Tickets (avatars, thumbnails, totals)
- Events
  - Modern filter UI: search, tags multi-select, city select, status, price range (1–9999), date ranges
  - One unified filter scope using query->when() with clamped price range and safe date handling
- Hotels
  - Modern filter UI: search, multi-selects (cities, services, statuses), price range sliders, date range (created_at)
  - One unified filter scope using query->when() (cities[], services[], statuses[], price_min/max, date_from/to)
- Tickets
  - Modern filter UI on index (client-side) similar to cities: search (event, user, barcode) and status filters
- Bookings
  - New card layout with modern filter UI on index (client-side)
  - Each booking displayed individually (not grouped)
- Profile
  - ProfileService for shared profile logic (web + mobile)
  - ProfileController with edit/update and password update
  - Modern profile edit page with avatar preview and password confirmation check

## 🔎 How to Use Filters

Web (Dashboard)

- Events (GET params)
  - q, tags[], city_id, status (1=Active, 0=Cancelled), price_min, price_max, start_at_from, start_at_to, end_at_from, end_at_to
  - Example:
    /dashboard/event?q=concert&tags[]=2&tags[]=5&city_id=3&status=1&price_min=200&price_max=400&start_at_from=2025-09-01&end_at_to=2025-09-30

- Hotels (GET params)
  - q, city_ids[], service_ids[], statuses[] (1=Active, 0=Cancelled), price_min, price_max, date_from, date_to
  - Example:
    /dashboard/hotel?q=beach&city_ids[]=1&city_ids[]=3&service_ids[]=2&statuses[]=1&price_min=100&price_max=500&date_from=2025-09-01&date_to=2025-09-30

- Tickets (GET params)
  - q (barcode, event title, user name), statuses[] (valid|used|canceled)
  - Example:
    /dashboard/ticket?q=TKT-ABCD&statuses[]=valid

- Bookings (GET params)
  - q (order number, hotel name, user name), statuses[] (confirmed|pending|canceled)
  - Example:
    /dashboard/booking?q=ORD-1234&statuses[]=confirmed

Notes
- Price range is clamped to 1–9999.
- Dates should be in YYYY-MM-DD.
- Filters are additive and support multi-select where noted.

API / Mobile Integration
- All filters are implemented as a single local scope on the model using query->when().
- You can pass a Request or an array of filters.

Examples (PHP)
```php
// Events
$events = \App\Models\Event::with(['tags','city'])
  ->filter([
    'q' => 'concert',
    'city_id' => 3,
    'tags' => [2,5],
    'status' => '1',
    'price_min' => 200,
    'price_max' => 400,
    'start_at_from' => '2025-09-01',
    'end_at_to' => '2025-09-30',
  ])->paginate(20);

// Hotels
$hotels = \App\Models\Hotel::with(['services','city'])
  ->filter([
    'q' => 'beach',
    'city_ids' => [1,3],
    'service_ids' => [2],
    'statuses' => ['1'],
    'price_min' => 100,
    'price_max' => 500,
    'date_from' => '2025-09-01',
    'date_to' => '2025-09-30',
  ])->paginate(20);

// Tickets
$tickets = \App\Models\Ticket::with(['event.city','user'])
  ->filter([
    'q' => 'TKT-ABCD',
    'statuses' => ['valid'],
  ])->paginate(20);

// Bookings
$bookings = \App\Models\Booking::with(['hotel.city','user'])
  ->filter([
    'q' => 'ORD-',
    'statuses' => ['confirmed'],
  ])->paginate(20);
```

## 📸 Screenshots

Add your screenshots to docs/screenshots and link them here:

- Dashboard Overview
  - docs/screenshots/dashboard-overview.png
- Event Filters
  - docs/screenshots/event-filters.png
- Hotel Filters
  - docs/screenshots/hotel-filters.png
- Profile Edit
  - docs/screenshots/profile-edit.png
- Bookings & Tickets
  - docs/screenshots/bookings-tickets.png

## 🎯 Usage

### For Tourists
1. Register/Login to the platform
2. Browse available events and hotels
3. Use search and filter options to find desired experiences
4. Make bookings with secure payment processing
5. Manage bookings through user dashboard

### For Administrators
1. Access admin dashboard
2. Manage users, events, and hotels
3. Monitor booking activities
4. Generate reports and analytics
5. Configure system settings

### For Developers
1. Use the API endpoints for mobile app integration
2. Extend functionality through Laravel's modular structure
3. Customize frontend components
4. Implement additional payment gateways

## 🤝 Contributing

We welcome contributions to improve the Tourist Guide platform!

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Development Guidelines
- Follow PSR-12 coding standards
- Write comprehensive tests
- Update documentation for new features
- Use meaningful commit messages

## 📄 License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## 👨‍💻 Author

**Anas Omar Obaid**
- GitHub: [@AnasOmarObaid](https://github.com/AnasOmarObaid)

## 🙏 Acknowledgments

- Laravel Framework for the robust foundation
- The open-source community for inspiration and tools
- All contributors who help improve this project

---

⭐ **Star this repository if you find it helpful!**
