# Laravel Project - Docker Setup

A Laravel 12 application with Docker containerization for easy development and deployment.

## 🚀 Quick Start

### Prerequisites

- [Docker](https://docs.docker.com/get-docker/) (version 20.10+)
- [Docker Compose](https://docs.docker.com/compose/install/) (version 2.0+)

### Getting Started

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd userlution-task
   ```

2. **Start the application**
   ```bash
   docker-compose up -d
   ```

3. **Access the application**
   - **Laravel App**: http://localhost:8000
   - **phpMyAdmin**: http://localhost:8080
   - **MySQL**: localhost:3306

That's it! The application should be running with all dependencies.

## 🏗️ Architecture

The project uses a multi-container Docker setup with clean separation of concerns:

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Nginx         │    │   Laravel App   │    │   MySQL 8.0     │
│   (Web Server)  │◄───┤   (PHP-FPM)     │◄───┤   (Database)    │
│   Port: 8000    │    │   Port: 9000    │    │   Port: 3306    │
└─────────────────┘    └─────────────────┘    └─────────────────┘
                                ▲
                                │
                       ┌─────────────────┐
                       │   phpMyAdmin    │
                       │   (DB Admin)    │
                       │   Port: 8080    │
                       └─────────────────┘
```

### Services

- **nginx**: Web server handling HTTP requests and static files
- **app**: Laravel application running on PHP 8.2 FPM
- **mysql**: MySQL 8.0 database with persistent storage
- **phpmyadmin**: Web-based MySQL administration tool

## 🔧 Development Workflow

### Managing Containers

```bash
# Start all services
docker-compose up -d

# View logs
docker-compose logs -f

# Stop all services
docker-compose down

# Rebuild containers (after code changes)
docker-compose up -d --build
```

### Laravel Commands

```bash
# Access the Laravel container
docker-compose exec app sh

# Run Artisan commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan tinker

# Install Composer packages
docker-compose exec app composer install

# Clear caches
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
```

### Database Management

**Using phpMyAdmin** (Recommended)
- URL: http://localhost:8080
- Server: `mysql`
- Username: `laravel`
- Password: `secret`

**Using Command Line**
```bash
# Access MySQL directly
docker-compose exec mysql mysql -u laravel -p laravel

# Run migrations
docker-compose exec app php artisan migrate

# Seed database
docker-compose exec app php artisan db:seed

# Reset database
docker-compose exec app php artisan migrate:fresh --seed
```

### Asset Building

```bash
# Install NPM dependencies (if needed)
docker-compose exec app npm install

# Build assets for development
docker-compose exec app npm run dev

# Build assets for production
docker-compose exec app npm run build

# Watch for changes (development)
docker-compose exec app npm run dev -- --watch
```

## 📁 Project Structure

```
.
├── Dockerfile              # Laravel app container definition
├── docker-compose.yml      # Multi-container orchestration
├── nginx.conf              # Nginx configuration
├── .dockerignore           # Files to exclude from Docker context
├── app/                    # Laravel application code
├── public/                 # Public web assets
├── resources/              # Views, CSS, JS source files
├── database/               # Migrations, seeders, factories
└── ...
```

## 🛠️ Configuration

### Environment Variables

The application uses the following environment configuration:

```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=database
```

### Custom Configuration

To modify the setup:

1. **Change ports**: Edit `docker-compose.yml` ports section
2. **Database credentials**: Update `docker-compose.yml` environment variables
3. **Nginx settings**: Modify `nginx.conf`
4. **PHP settings**: Edit `Dockerfile` or add custom PHP configuration

## 🐛 Troubleshooting

### Common Issues

**Container won't start**
```bash
# Check container status
docker-compose ps

# View detailed logs
docker-compose logs app
docker-compose logs nginx
docker-compose logs mysql
```

**Database connection issues**
```bash
# Ensure MySQL is ready
docker-compose exec mysql mysql -u laravel -p

# Check Laravel database config
docker-compose exec app php artisan config:show database
```

**Permission issues**
```bash
# Fix storage permissions
docker-compose exec app chmod -R 755 storage bootstrap/cache
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

**Clear everything and restart**
```bash
# Stop and remove containers, networks, volumes
docker-compose down -v

# Rebuild from scratch
docker-compose up -d --build
```

### Performance Tips

- Use `.dockerignore` to exclude unnecessary files
- Mount only necessary directories in development
- Use Docker BuildKit for faster builds
- Consider using `--parallel` flag for faster startup

## 🚀 Production Deployment

For production deployment:

1. Update environment variables in `docker-compose.yml`
2. Set `APP_ENV=production` and `APP_DEBUG=false`
3. Use proper SSL certificates
4. Configure proper database credentials
5. Set up proper logging and monitoring

```bash
# Production build
docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d
```

## 📚 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Docker Documentation](https://docs.docker.com/)
- [Docker Compose Documentation](https://docs.docker.com/compose/)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test with Docker
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
