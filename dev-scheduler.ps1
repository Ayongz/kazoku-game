# Laravel Schedule Runner for Development
# Run this in PowerShell for testing

Write-Host "Starting Laravel Scheduler..." -ForegroundColor Green
Write-Host "Press Ctrl+C to stop" -ForegroundColor Yellow

while ($true) {
    $timestamp = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
    Write-Host "[$timestamp] Running schedule..." -ForegroundColor Cyan
    
    Set-Location "c:\xampp\htdocs\kazoku-game"
    php artisan schedule:run
    
    Start-Sleep -Seconds 60
}