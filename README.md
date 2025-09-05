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
