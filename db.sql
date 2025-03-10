create table users (
    id int primary key auto_increment,
    firstName varchar(50) not null,
    lastName varchar(50) not null,
    email varchar(100) unique not null,
    password varchar(255) not null,
    cgpa decimal(5,2) default 0.00
);

-- semester table
create table semester (
    id int primary key auto_increment,
    sem_id int not null,
    gpa decimal(4,2),
    tot_cre int,
    user_id int,
    foreign key (user_id) references users(id) on delete cascade
);

-- course table
create table course (
    sem int not null,
    course_name varchar(100) not null,
    result varchar(2) not null,
    credits int not null,
    user_id int,
    foreign key (user_id) references users(id) on delete cascade
);
