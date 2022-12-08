## MySQL Database

```sql
CREATE DATABASE loginsys;
USE loginsys;
```

```sql
CREATE TABLE users(
    id int AUTO_INCREMENT PRIMARY KEY,
    username varchar(15) NOT NULL,
    first_name varchar(55) NOT NULL,
    last_name varchar(55) NOT NULL,
    dob date NOT NULL,
    gender char NOT NULL,
    email varchar(125) NOT NULL,
    password varchar(255) NOT NULL
);
```
