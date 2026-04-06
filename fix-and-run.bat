@echo off
setlocal
cd /d "%~dp0"

echo [1/4] Cleaning Laravel Cache...
php artisan config:clear
php artisan cache:clear

echo [2/5] Resetting Database (migrate:fresh --seed)...
echo WARNING: This will delete existing data in Ecom-Market-DB.
php artisan migrate:fresh --seed
php artisan storage:link

echo [3/4] Building Frontend Assets...
if not exist node_modules (
    echo node_modules not found, installing dependencies...
    call npm install
)
call npm run build

echo [4/4] Starting Server...
start http://127.0.0.1:8000
php artisan serve --port=8000

pause
