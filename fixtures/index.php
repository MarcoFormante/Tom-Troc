<?php 
require_once('./config/config.php');
require_once('./config/autoload.php');

require_once('./fixtures/AbstractFixture.php');
require_once('./fixtures/UserFixture.php');
require_once('./fixtures/BookFixture.php');


while(true){
    $commandName = readline("Name of Fixture ('help' for more info): ");

    switch (trim($commandName)) {
        case 'help':
            echo "\n addRandomUsers: add random users;\n";
            echo " addRandomUsers: add random users;\n \n";
            break;

            /** USERS */
        case 'addRandomUsers':
            $userFixture = new UserFixture();
            $userFixture->addRandomUsers();
            break;
        
        case 'addOneRandomUser':
            $userFixture = new UserFixture();
            $userFixture->addUser();
            break;
        
        case 'deleteAllUsers':
            $userFixture = new UserFixture();
            $userFixture->deleteAllUsers();
            break;

            /** BOOKS */
        case 'addRandomBooks':
            $bookFixture = new BookFixture();
            $bookFixture->addRandomBooks();
            break;


        case 'addOneRandomBook':
            $bookFixture = new BookFixture();
            $bookFixture->addBook();
            break;


        case 'deleteAllBooks':
            $bookFixture = new BookFixture();
            $bookFixture->deleteAllBooks();
            break;

        
        
        default:
            echo "Cette commande n'existe pas, tapez 'help' pour plus d'informations \n ";
            break;
        }
}

