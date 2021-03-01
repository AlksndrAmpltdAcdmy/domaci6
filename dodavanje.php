<?php // dodavanje.php

    include 'db.php';
    include 'functions.php';
    include 'header.php';


    $query = "SELECT * FROM gradovi";
    $result = $conn->query($query);
    if (!$result) die ("db greska");
    
    $gradovi="<select name='pretraga_grad'>";
    while ($row = $result->fetch_array(MYSQLI_NUM))
    {
        $gradovi=$gradovi."<option value='$row[0]'>$row[1]</option>";
    }
    $gradovi=$gradovi." </select>";


    $query = "SELECT * FROM tip_nekretnine";
    $result = $conn->query($query);
    if (!$result) die ("db greska");

    $tip_nekretnine="<select name='tip_nekretnine'>";
    while ($row = $result->fetch_array(MYSQLI_NUM))
    {
        $tip_nekretnine=$tip_nekretnine."<option value='$row[0]'>$row[1]</option>";
    }
    $tip_nekretnine=$tip_nekretnine." </select>";


    echo <<<_END
    <form action='index.php' method='post' enctype="multipart/form-data"><hr>
    Grad: $gradovi <br><br>
    Tip nekretnine: $tip_nekretnine <br><br>
    Tip oglasa:
    <select name="tip_oglasa">
        <option value="1">prodaja</option>
        <option value="2">iznajmljivanje</option>
        <option value="3">kompenzacija</option>
    </select><br><br>   
    Povrsina: <input type="number" name="povrsina" required> <br><br>
    Cijena: <input type="number" name="cijena" required> <br><br>
    Godina: <input type="number" min="1901" max="2155" name="godina" required> <br><br>
    Opis: <textarea name="opis" rows="3" cols="30" required></textarea><br><br>
    Prodato: <input id="prodata" type="checkbox" name="prodata" value="TRUE" onclick="dodajDatum()">
    <div id="datum"></div><br><br>
    Slike: <div id="slike"><input type="file" name="slike[]" required></div><br>
    <button type="button" onClick="dodajSliku()">Dodaj jos slika...</button><hr><br>
    <input type="submit" value="Dodaj nekretninu"> </form>
    _END;


?>

<script>
    function dodajDatum()
    {
        var datum = document.createElement("input");
        datum.setAttribute("type", "date")
        datum.setAttribute("name", "datum");
        datum.setAttribute("id", "datum_prodaje");
        datum.setAttribute("value","2021-01-01");
        document.getElementById("datum").appendChild(datum);
        document.getElementById("prodata").setAttribute("onClick","makniDatum()");
    }

    function makniDatum()
    {
        document.getElementById("prodata").setAttribute("onClick","dodajDatum()");
        document.getElementById("datum_prodaje").remove();
    }

    function dodajSliku()
    {
        var slika = document.createElement("input");
        slika.setAttribute("type", "file");
        slika.setAttribute("name", "slike[]");
        document.getElementById("slike").appendChild(slika);
    }

</script>
