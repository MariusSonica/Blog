<?php

// Include the functions so you can create a URL
include_once 'functions.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'
    && $_POST['submit'] == 'Save Entry'
    && !empty($_POST['page'])
    && !empty($_POST['title'])
    && !empty($_POST['entry'])
) {
    // Create a URL to save in the database
    $url = makeUrl($_POST['title']);

    // Include database credentials and connect to the database
    include_once 'db.inc.php';
    $db = new PDO(DB_INFO, DB_USER, DB_PASS);

    // Edit an existing entry
    if(!empty($_POST['id']))
    {
        $sql = "UPDATE entries
                SET title=?, entry=?, url=?
                WHERE id=?
                LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute(
            array(
                $_POST['title'],
                $_POST['entry'],
                $url,
                $_POST['id']
            )
        );
        $stmt->closeCursor();
    }
    // Create a new entry
    else
    {
/*    // Save the entry into the database
    $sql = "INSERT INTO entries (page, title, entry)
VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    $title = $_POST[title];
    $entry = $_POST[entry];

    $stmt->execute(array($_POST['page'], $_POST['title'], $_POST['entry']));
    $stmt->closeCursor();
*/
    // Save the entry into the database

    $sql = "INSERT INTO entries (page, title, entry, url)
VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->execute(
        array($_POST['page'], $_POST['title'], $_POST['entry'], $url)
    );
    $stmt->closeCursor();
    }
    // Sanitize the page information for use in the success URL
    $page = htmlentities(strip_tags($_POST['page']));

    // Get the ID of the entry we just saved
    $id_obj = $db->query("SELECT LAST_INSERT_ID()");
    $id = $id_obj->fetch();
    $id_obj->closeCursor();
    // Send the user to the new entry
    header('Location: ../'.$page.'/'.$url);
    exit;
    // Continue processing information . . .
} // If both conditions aren't met, sends the user back to the main page
else {
    header('Location: ../admin.php');
    exit;
}

