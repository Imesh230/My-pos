# Auto Push to GitHub Script
param(
    [string]$Message = "Auto-update: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')"
)

Write-Host "Starting auto-push process..." -ForegroundColor Green

# Check if there are any changes
$status = git status --porcelain
if (-not $status) {
    Write-Host "No changes to commit." -ForegroundColor Yellow
    exit
}

Write-Host "Adding all changes..." -ForegroundColor Blue
git add .

Write-Host "Committing with message: $Message" -ForegroundColor Blue
git commit -m $Message

Write-Host "Pushing to GitHub..." -ForegroundColor Blue
$pushResult = git push origin main 2>&1

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ Successfully pushed to GitHub!" -ForegroundColor Green
} else {
    Write-Host "❌ Push failed: $pushResult" -ForegroundColor Red
}

Write-Host "Auto-push completed!" -ForegroundColor Green
