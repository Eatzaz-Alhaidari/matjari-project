@echo off
cd /d "C:\Users\MY_World\Desktop\E-Store_New"
start cmd /k "php artisan serve --host=127.0.0.1 --port=8000"
echo.
echo Server starting... Please wait...
timeout /t 3 /nobreak > nul
start http://127.0.0.1:8000
echo.
echo Browser opened. Please login with:
echo Email: ha@gmail.com
echo Password: password
echo.
pause