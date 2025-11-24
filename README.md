# GUVI Project - Fullstack (Fixed)

This archive contains a fully working local version of the GUVI task: MySQL (users), Redis sessions (Memurai/Redis), MongoDB (profiles), PHP backend and a Bootstrap + jQuery frontend.

## Structure

```
guvi_project_fixed/
  backend/
    db.php
    redis.php
    mongo.php
    auth.php
    register.php
    login.php
    logout.php
    profile_save.php
    profile_get.php
  public/
    index.html
    css/style.css
    js/app.js
  init_db.sql
  composer.json
  README.md
```

## Setup

1. Ensure services running:
   - MySQL (service)
   - Memurai/Redis
   - MongoDB (or use Atlas and update MONGO_URI in environment)

2. Install PHP dependencies (composer):
```bash
cd backend
composer require predis/predis
composer require mongodb/mongodb
```

3. Create database:
```bash
& "C:\tools\mysql\current\bin\mysql.exe" -u root -p < init_db.sql
```

4. Start PHP dev server from project root:
```bash
cd public
php -S localhost:8000
# open http://localhost:8000
```

5. Register -> Login -> Save Profile -> Load Profile flow works out of the box.

## Notes

- Backend expects Redis on 127.0.0.1:6379 and MongoDB on mongodb://127.0.0.1:27017 by default.
- If using MongoDB Atlas, set MONGO_URI environment variable or update `backend/mongo.php`.
- DO NOT commit `vendor/` directory to git; run composer locally to install packages.
