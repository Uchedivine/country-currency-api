# Country Currency & Exchange API

A RESTful API built with Laravel 12 that fetches country data from external APIs, stores it in a database, and provides CRUD operations with filtering capabilities.

## Features

- Fetch and cache country data from RestCountries API
- Fetch real-time exchange rates
- Calculate estimated GDP for each country
- Filter countries by region and currency
- Sort countries by estimated GDP
- Generate summary image report
- Full CRUD operations

## Technologies Used

- Laravel 12
- MySQL
- PHP GD Library
- RestCountries API
- Open Exchange Rates API

## Installation

1. Clone the repository
```bash
git clone <your-repo-url>
cd country-currency-api
```

2. Install dependencies
```bash
composer install
```

3. Configure environment
```bash
cp .env.example .env
```

Edit `.env` and set your database credentials:
```
DB_DATABASE=country_currency_api
DB_USERNAME=root
DB_PASSWORD=your_password
```

4. Generate application key
```bash
php artisan key:generate
```

5. Run migrations
```bash
php artisan migrate
```

6. (Optional) Seed sample data
```bash
php artisan db:seed --class=CountrySeeder
```

7. Start the server
```bash
php artisan serve
```

## API Endpoints

### Refresh Countries
```
POST /api/countries/refresh
```
Fetches all countries and exchange rates, then caches them in the database.

### Get All Countries
```
GET /api/countries
GET /api/countries?region=Africa
GET /api/countries?currency=NGN
GET /api/countries?sort=gdp_desc
```

### Get Single Country
```
GET /api/countries/{name}
```
Example: `/api/countries/Nigeria`

### Delete Country
```
DELETE /api/countries/{name}
```

### Get Status
```
GET /api/status
```
Returns total countries and last refresh timestamp.

### Get Summary Image
```
GET /api/countries/image
```
Returns a PNG image with statistics and top 5 countries by GDP.

## Response Examples

### Success Response
```json
{
  "id": 1,
  "name": "Nigeria",
  "capital": "Abuja",
  "region": "Africa",
  "population": 206139589,
  "currency_code": "NGN",
  "exchange_rate": 1600.23,
  "estimated_gdp": 329823448125.20,
  "flag_url": "https://flagcdn.com/ng.svg",
  "last_refreshed_at": "2025-10-27T14:09:34.000000Z"
}
```

### Error Response
```json
{
  "error": "Country not found"
}
```

## Testing

Test the API using Thunder Client, Postman, or any HTTP client.

1. First, refresh the data:
```bash
POST http://127.0.0.1:8001/api/countries/refresh
```

2. Then test other endpoints as needed.

## Requirements

- PHP 8.2+
- MySQL 8.0+
- Composer
- PHP GD Extension enabled

## Author

Uche Divine - Uchedivine65@gmail.com

## License

This project is open-sourced software.