# Counter
docker-compose exec app bash

docker-compose up -d --force-recreate --build
docker-compose up --force-recreate --build


sf4 Vue2 Counter App
========================

Requirements
---
 * Docker
 * Docker Compose
    

Run project
---
```
git clone https://github.com/DawidKre/counter.git
cd counter/
```
Start docker containers:
```
docker-compose up -d
```
Add new entries to hosts file:
```
127.0.0.1 phpadmin.counter.local
127.0.0.1 counter.local
```
Install composer dependencies
```
docker-compose exec backend composer install
```
Install npm dependencies
```
docker-compose exec backend yarn install
docker-compose exec backend yarn encore dev
```
Create app database schema (tables and relations)
```
docker-compose exec backend bin/console doctrine:schema:create 
```
Import data from fixtures
```
docker-compose exec backend bin/console doctrine:fixtures:load
```
---
And that is all
You should be able to test application at:
http://counter.local
---
Links:
---
Application with vue:

- http://counter.local

Backend api documentation with possibility of testing it:

- http://counter.local/api

phpMyAdmin:

- http://phpadmin.counter.local

Credentials:
---
DB:
- Username: `db_user`
- Password: `db_password`
- DB name: `db_name`

Applications:
- Username: `admin`
- Password: `counter`


Api:
---
Database structure and tables was done by symfony entities.

Api was done by Api Platform https://api-platform.com/.
Additionally, documentation in  has been created automatically.

Front:
---
Frontend applications is SPA done in Vue.js 2 and Vue framework called Vuetify https://vuetifyjs.com
Data is provided from api. There is server side pagination.

TODO:
---
Main thing todo is write some tests unfortunately I did not make it in time although I really wanted to.

Backend
- Improve performance of counters script
- Test performance
- Write some tests
- Overall refactor mainly in filters components
- Mobile friendly

Frontend 
- Write some tests
- Overall refactor
- Add options to add custom templates
- Add options to edit counters
- Custom texts in counters
- Changing fonts in text in templates counters
- Mobile friendly
