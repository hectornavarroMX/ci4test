@echo off
title Generador de Paquetes de Despliegue CI4
echo ======================================================
echo   Generando paquetes de despliegue para Hosting...
echo ======================================================
echo.

powershell -ExecutionPolicy Bypass -File "%~dp0SUBIR.ps1"

echo.
echo ======================================================
echo   Proceso finalizado con exito.
echo ======================================================
echo Presiona cualquier tecla para cerrar esta ventana...
pause > nul
