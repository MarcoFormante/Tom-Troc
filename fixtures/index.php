<?php 
require_once('./config/config.php');
require_once('./config/autoload.php');

require_once('./fixtures/UserFixture.php');


while(true){
    $commandName = readline("Name of Fixture ('help' for more info): ");

    switch (trim($commandName)) {
        case 'help':
            echo "\n addRandomUsers: add random users;\n";
            echo " addRandomUsers: add random users;\n \n";
            break;

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
        
        default:
            echo "Cette commande n'existe pas \n ";
            break;
        }
}

