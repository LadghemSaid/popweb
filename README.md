# popweb
site de l'agence
1) git pull
2) composer install
3) npm install
3bis) modifier le .env => ligne 28 : 'DATABASE_URL=mysql://user:password@localhost:port(ex : 3306 Windows, 8888 Mac)/popweb'
3bisbis) php bin/console d:d:c
4) php bin/console d:s:u --force
5) php bin/console h:f:l
6) php bin/console c:c
7) npm run watch
8) php bin/console s:run
