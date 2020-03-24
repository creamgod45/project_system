@echo off
git config --global user.email "fuyin1054@gmail.com"
git config --global user.name "creamgod45"
git remote add origin https://github.com/creamgod45/project_system.git
git add assets
git add pull.bat
git add push.bat
git add project_system.sql
git add README.md
git add LICENSE
git commit -m "ver1.0-alpha"
git push -u origin master