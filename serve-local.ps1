$ErrorActionPreference = 'Stop'

$projectRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
$publicPath = Join-Path $projectRoot 'public'
$routerPath = Join-Path $publicPath 'router.php'

if (-not (Test-Path $routerPath)) {
    throw 'KISANWORLD development router was not found.'
}

Set-Location $publicPath
& 'C:\xampp\php\php.exe' -S 127.0.0.1:8000 $routerPath
