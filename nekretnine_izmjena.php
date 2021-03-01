<?php // nekretnine_izmjena.php

    include 'db.php';
    include 'functions.php';
    include 'header.php';

    if (isset($_POST['id']))
    {
        $id = get_post($conn, 'id');
        $query = "SELECT * FROM tip_nekretnine WHERE id=$id";
        $result = $conn->query($query);
        if (!$result) echo "db greska";
    }

    $stari_tip=$result->fetch_array(MYSQLI_NUM)[1];

    echo <<<_END
    <form action="nekretnine.php" method="post">
    <input type='hidden' name='id' value='$id'>
    Tip nekretnine: <input type="text" name="izmjenjen_tip" value="$stari_tip" required>
    <input type="submit" value="Promjeni tip nekretnine"></form><hr>
    _END;

    $result->close();
    $conn->close();

?>