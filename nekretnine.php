<?php // nekretnine.php

    include 'db.php';
    include 'functions.php';
    include 'header.php';

    if (isset($_POST['id']) && !isset($_POST['izmjenjen_tip']))
    {
        $id = get_post($conn, 'id');
        $query = "DELETE FROM tip_nekretnine WHERE id=$id";
        $result = $conn->query($query);
        if (!$result) echo "brisanje neuspjesno";
    }

    if (isset($_POST['id']) && isset($_POST['izmjenjen_tip']))
    {
        $id = get_post($conn, 'id');
        $izmjenjen_tip = get_post($conn, 'izmjenjen_tip');
        $query = "UPDATE tip_nekretnine SET tip='$izmjenjen_tip' WHERE id=$id";
        $result = $conn->query($query);
        if (!$result) echo "izmjena neuspjesna";
    }


    if (isset($_POST['novitip']))
    {
        $novitip = get_post($conn, 'novitip');
        $query = "INSERT INTO tip_nekretnine(tip) VALUES('$novitip')";
        $result = $conn->query($query);
        if (!$result) echo "dodavanje neuspjesno";
    }

    echo <<<_END
    <form action="nekretnine.php" method="post">
    Tip nekretnine: <input type="text" name="novitip" required>
    <input type="submit" value="Dodaj tip nekretnine"></form><hr>
    _END;

    $query = "SELECT * FROM tip_nekretnine";
    $result = $conn->query($query);
    if (!$result) die ("db greska");

    while ($row = $result->fetch_array(MYSQLI_NUM))
    {
        $r0=htmlspecialchars($row[0]);
        $r1=htmlspecialchars($row[1]);
        echo <<<_END
        <pre>
        ID tipa nekretnine: $r0
        Naziv tipa nekretnine: $r1
        </pre>
        <form action='nekretnine.php' method='post'>
        <input type='hidden' name='id' value='$r0'>
        <input type='submit' value='IZBRISI TIP NEKRETNINE'></form>
        <form action='nekretnine_izmjena.php' method='post'>
        <input type='hidden' name='id' value='$r0'>
        <input type='submit' value='IZMJENI TIP NEKRETNINE'></form><hr>
        _END;   
    }

    $result->close();
    $conn->close();

?>
