# Music Voting App

A modern web application built with Laravel and Vue.js that allows users to vote on their favorite music tracks. Users can upvote or downvote songs, and tracks are ranked based on their total votes.

## Features

### User Authentication
- User registration and login
- Secure authentication using Laravel Sanctum
- Role-based access (admin/user)

### Album Management
- View list of albums with pagination
- Search albums by song name or artist
- Admin can add, edit, and delete albums
- Upload and manage album cover images

### Voting System
- Interactive voting interface with custom SVG icons
- Upvote (yellow fill) and downvote (black fill) functionality
- Real-time vote count updates
- Vote count display with tooltip showing detailed statistics
- One vote per user per album
- Sort albums by vote count

## Tech Stack

### Backend
- Laravel 10.x
- MySQL
- Laravel Sanctum for authentication
- File storage for album covers

### Frontend
- Vue.js 3
- TypeScript
- Pinia for state management
- SCSS for styling
- Axios for API calls

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js and npm
- MySQL

### Backend Setup
1. Clone the repository:
```bash
git clone <repository-url>
cd <project-folder>
```

2. Install PHP dependencies:
```bash
cd backend
composer install
```

3. Set up environment variables:
```bash
cp .env.example .env
# Edit .env with your database credentials
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Run migrations and seeders:
```bash
php artisan migrate
php artisan db:seed
```

6. Create storage link for album covers:
```bash
php artisan storage:link
```

### Frontend Setup
1. Install dependencies:
```bash
cd frontend
npm install
```

2. Configure environment:
```bash
cp .env.example .env
# Edit .env with your API URL
```

3. Start development server:
```bash
npm run dev
```

## API Endpoints

### Authentication
- `POST /api/register` - Register new user
- `POST /api/login` - User login
- `POST /api/logout` - User logout
- `GET /api/user` - Get authenticated user

### Albums
- `GET /api/albums` - List albums (with pagination and search)
- `POST /api/albums` - Create new album
- `GET /api/albums/{id}` - Get single album
- `PUT /api/albums/{id}` - Update album
- `DELETE /api/albums/{id}` - Delete album
- `POST /api/albums/{id}/vote` - Vote on album

## Usage

### User Features
1. Register/Login to access the application
2. Browse through the list of albums
3. Search for specific songs or artists
4. Vote on albums (upvote or downvote)
5. View voting statistics via tooltips

### Admin Features
1. All user features
2. Add new albums
3. Edit existing albums
4. Delete albums
5. Manage album cover images

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgments
- Vue.js team for the amazing framework
- Laravel team for the robust backend framework
- All contributors who participate in this project 