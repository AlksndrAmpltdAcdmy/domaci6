<?php // gradovi_izmjena.php

    include 'db.php';
    include 'functions.php';
    include 'header.php';

    if (isset($_POST['id']))
    {
        $id = get_post($conn, 'id');
        $query = "SELECT * FROM gradovi WHERE id=$id";
        $result = $conn->query($query);
        if (!$result) echo "db greska";
    }

    $staro_ime=$result->fetch_array(MYSQLI_NUM)[1];

    echo <<<_END
    <form action="gradovi.php" method="post">
    <input type='hidden' name='id' value='$id'>
    Naziv grada: <input type="text" name="novo_ime" value="$staro_ime" required>
    <input type="submit" value="Izmjeni grad"></form><hr>
    _END;

    $result->close();
    $conn->close();

?>
