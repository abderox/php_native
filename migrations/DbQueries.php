<?php

class DbQueries
{
    public function createUser() {
        return "CREATE TABLE user(
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                user_name VARCHAR(30) NOT NULL UNIQUE,
                email VARCHAR(30) NOT NULL UNIQUE,
                password VARCHAR(70) NOT NULL 
            )";
    }

    public function createPage() {
    return "CREATE TABLE page(
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                page_name VARCHAR(30) NOT NULL UNIQUE,
                FOREIGN KEY (user_id) REFERENCES user(id)
            )";
    }

    public function createArticle() {
        return "CREATE TABLE article(
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                title VARCHAR(30) NOT NULL UNIQUE,
                image VARCHAR(30) NOT NULL UNIQUE,
                content VARCHAR(1000) NOT NULL UNIQUE,
                title VARCHAR(30) NOT NULL UNIQUE,
                FOREIGN KEY (page_id) REFERENCES page(id)
            )";
    }
}