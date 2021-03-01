<?php // gradovi.php

    include 'db.php';
    include 'functions.php';
    include 'header.php';

    if (isset($_POST['id']) && !isset($_POST['novo_ime']))
    {
        $id = get_post($conn, 'id');
        $query = "DELETE FROM gradovi WHERE id=$id";
        $result = $conn->query($query);
        if (!$result) echo "brisanje neuspjesno";
    }

    if (isset($_POST['id']) && isset($_POST['novo_ime']))
    {
        $id = get_post($conn, 'id');
        $novo_ime = get_post($conn, 'novo_ime');
        $query = "UPDATE gradovi SET ime='$novo_ime' WHERE id=$id";
        $result = $conn->query($query);
        if (!$result) echo "izmjena neuspjesna";
    }


    if (isset($_POST['novigrad']))
    {
        $novigrad = get_post($conn, 'novigrad');
        $query = "INSERT INTO gradovi(ime) VALUES('$novigrad')";
        $result = $conn->query($query);
        if (!$result) echo "dodavanje neuspjesno";
    }

    echo <<<_END
    <form action="gradovi.php" method="post">
    Ime grada: <input type="text" name="novigrad" required>
    <input type="submit" value="Dodaj grad"></form><hr>
    _END;

    $query = "SELECT * FROM gradovi";
    $result = $conn->query($query);
    if (!$result) die ("db greska");

    while ($row = $result->fetch_array(MYSQLI_NUM))
    {
        $r0=htmlspecialchars($row[0]);
        $r1=htmlspecialchars($row[1]);
        echo <<<_END
        <pre>
        ID grada: $r0
        Naziv grada: $r1
        </pre>
        <form action='gradovi.php' method='post'>
        <input type='hidden' name='id' value='$r0'>
        <input type='submit' value='IZBRISI GRAD'></form>
        <form action='gradovi_izmjena.php' method='post'>
        <input type='hidden' name='id' value='$r0'>
        <input type='submit' value='IZMJENI GRAD'></form><hr>
        _END;   
    }

    $result->close();
    $conn->close();

?>
