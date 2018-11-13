create table if not exists `registration` (
    `email` varchar(320) not null,
    `name` varchar(30) not null,
    `date` datetime not null
);