<?php
    $contacts = file('contacts.txt');

    echo("<h1>Contacts</h1>");
    foreach ($contacts as $contact) {
        list($name, $email) = split(":", $contact);
        echo("<h2>Name</h2>\n<p>$name</p>\n");
        echo("<h2>Email</h2>\n<p>$email</p>");
    }
?>