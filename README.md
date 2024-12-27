The aim of this system itself is to manage ongoing projects, making everything more organized and legible, so that all ongoing projects can be managed more easily and easily, solving the problem of getting lost among so many other files and photos that can easily spread if not stored correctly.

---
## Instalation
To install the system you need to fulfill a few prerequisites, for example, to have the following packages installed:
- git
- composer
- php
- mysql or mariadb

Once the packages have been installed, we can move on to the system, which can be easily installed by running the command below:
```bash
git clone https://github.com/juliodeoliveira/MVC-project
```

Once the download is complete, go to the folder named `MVC-project` and install all the dependencies using the command below:
```bash
cd MVC-project && composer install
```

Once all the dependencies have been installed you will need to configure your `.env` file, you can do this by simply editing and renaming the `.env.example` file in the root of the project. If your database is also correct, you just need to start the project with the command below:
```bash
php -S localhost:5500 -t public
```
