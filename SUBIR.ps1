# Script de PowerShell para generar paquetes de despliegue separados

$baseDir = Get-Location

Write-Host "Generando paquetes de actualización..." -ForegroundColor Cyan

# 1. Paquete para la zona PRIVADA (app)
$appZip = Join-Path $baseDir "subir_a_PRIVADO_app.zip"
if (Test-Path $appZip) { Remove-Item $appZip }
Compress-Archive -Path "app" -DestinationPath $appZip -Force
Write-Host "  -> Creado: subir_a_PRIVADO_app.zip" -ForegroundColor Green

# 2. Paquete para la zona PÚBLICA (assets)
$assetsZip = Join-Path $baseDir "subir_a_PUBLIC_assets.zip"
if (Test-Path $assetsZip) { Remove-Item $assetsZip }
Compress-Archive -Path "public\assets" -DestinationPath $assetsZip -Force
Write-Host "  -> Creado: subir_a_PUBLIC_assets.zip" -ForegroundColor Green

Write-Host "¡Paquetes listos para subir a tu Hosting!" -ForegroundColor Yellow
