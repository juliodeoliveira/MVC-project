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

When everything is done you need to go to root folder from project and create the database:
```bash
cd database && php migrations.php && cd ../
```

Once the download is complete, go to the folder named `MVC-project` and install all the dependencies using the command below:
```bash
cd MVC-project && composer install
```

Once all the dependencies have been installed you will need to configure your `.env` file, you can do this by simply editing and renaming the `.env.example` file in the root of the project. If your database is also correct, you just need to start the project with the command below:
```bash
php -S localhost:5500 -t public
```

---
## Contributing
To contribute the project is very simple, it uses MVC architecture, basically it stands for Model, View and Controller. In this project I am using a Repository that cares about the queries and the database itself.

### Branches
To make it more organized I am using a branch for each "project state", the branches are: `feature, bugfixes and main`. If you want to add a new feature simply clone the project go to feature branch and create a new one with the name: feature/feature-name, and create a pull request, I will read the code and merge to the feature branch, when the release time comes I will merge the feature branch with the main, if a error appears, or someone else spotted an error, simply create a branch in bugfixes branch with the name bugfixes/bug-name, when error is solved the bugfixes/bug-name branch will be merged to bugfixes and bugfixes with main, basically the same thing with feature.

