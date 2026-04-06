@echo off
cd /d "c:\xampp\htdocs\matjari-project"
start cmd /k "php artisan serve --host=127.0.0.1 --port=8000"
echo.
echo Server starting... Please wait...
timeout /t 3 /nobreak > nul
start http://127.0.0.1:8000
echo.
echo Browser opened. Please login with:
echo Email: superadmin@example.com
echo Password: password
echo.
pause