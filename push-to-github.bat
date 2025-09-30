@echo off
echo Adding all changes...
git add .

echo Committing changes...
git commit -m "Auto-update: %date% %time%"

echo Pushing to GitHub...
git push origin main

echo Done! Your changes have been pushed to GitHub.
pause
