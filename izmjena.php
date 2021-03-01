<?php // izmjena.php

    include 'db.php';
    include 'functions.php';
    include 'header.php';

    var_dump($_POST);
    if (isset($_POST['idslike']))
    {
        $id = get_post($conn, 'idslike');
        $query = "SELECT url FROM slike WHERE slike.id=$id";
        $result = $conn->query($query);
        if (!$result) echo "db error";
        while (unlink("./slike/".$result->fetch_array(MYSQLI_NUM)[0]));
        $query = "DELETE FROM slike WHERE slike.id=$id";
        $result = $conn->query($query);
        if (!$result) echo "brisanje slike neuspjesno";
    }

    if (isset($_POST['id']))
    {
        $id = get_post($conn, 'id');

        $query = "SELECT nekretnine.id, nekretnine.povrsina, nekretnine.cijena, nekretnine.godina, nekretnine.opis, 
        nekretnine.prodata, nekretnine.datum_prodaje, gradovi.ime, tip_nekretnine.tip, tip_oglasa.tip
        FROM nekretnine left JOIN gradovi ON nekretnine.gradovi_id=gradovi.id 
        LEFT JOIN tip_nekretnine ON nekretnine.tip_nekretnine_id=tip_nekretnine.id 
        LEFT JOIN tip_oglasa ON nekretnine.tip_oglasa_id=tip_oglasa.id WHERE nekretnine.id='$id'";
        $result = $conn->query($query);
        if (!$result) echo "db greska";
        $izmjena = $result->fetch_array(MYSQLI_NUM);

        $query = "SELECT * FROM gradovi";
        $result = $conn->query($query);
        if (!$result) die ("db greska");

        $gradovi="<select name='grad'>";
        while ($row = $result->fetch_array(MYSQLI_NUM))
        {   
            if ($izmjena[7]==$row[1])
            $gradovi=$gradovi."<option selected='selected' value='$row[0]'>$row[1]</option>";
            else
            $gradovi=$gradovi."<option value='$row[0]'>$row[1]</option>";
        }
        $gradovi=$gradovi." </select>";


        $query = "SELECT * FROM tip_nekretnine";
        $result = $conn->query($query);
        if (!$result) die ("db greska");

        $tip_nekretnine="<select name='tip_nekretnine'>";
        while ($row = $result->fetch_array(MYSQLI_NUM))
        {
            if($izmjena[8]==$row[1])
            $tip_nekretnine=$tip_nekretnine."<option selected='selected' value='$row[0]'>$row[1]</option>";
            else
            $tip_nekretnine=$tip_nekretnine."<option value='$row[0]'>$row[1]</option>";
        }
        $tip_nekretnine=$tip_nekretnine." </select>";

        $query = "SELECT * FROM tip_oglasa";
        $result = $conn->query($query);
        if (!$result) die ("db greska");

        $tip_oglasa="<select name='tip_oglasa'>";
        while ($row = $result->fetch_array(MYSQLI_NUM))
        {
            if($izmjena[9]==$row[1])
            $tip_oglasa=$tip_oglasa."<option selected='selected' value='$row[0]'>$row[1]</option>";
            else
            $tip_oglasa=$tip_oglasa."<option value='$row[0]'>$row[1]</option>";
        }
        $tip_oglasa=$tip_oglasa." </select>";

        if($izmjena[5]=="0") $prodata="";
        else $prodata="checked";

        echo <<<_END
        <form action='index.php' method='post' enctype="multipart/form-data"><hr>
        <input type='hidden' name='izmjena' value='TRUE'>
        <input type='hidden' name='id' value='$id'>
        Grad: $gradovi <br><br>
        Tip nekretnine: $tip_nekretnine <br><br>
        Tip oglasa: $tip_oglasa <br><br>  
        Povrsina: <input type="number" name="povrsina" value="$izmjena[1]" required> <br><br>
        Cijena: <input type="number" name="cijena" value="$izmjena[2]" required> <br><br>
        Godina: <input type="number" min="1901" max="2155" name="godina" value="$izmjena[3]" required> <br><br>
        Opis: <textarea name="opis" rows="3" cols="30" required>$izmjena[4]</textarea><br><br>
        Prodato: <input id="prodata" type="checkbox" name="prodata" value="TRUE" $prodata>
        <input type='date' name='datum' value='$izmjena[6]'><br><br>
        Dodaj slike: <div id="slike"><input type="file" name="slike[]"></div><br>
        <button type="button" onClick="dodajSliku()">Dodaj jos slika...</button><hr><br>
        <input type="submit" value="Sacuvaj"> </form>
        _END;

        $query = "SELECT url , id FROM slike WHERE nekretnina_id='$izmjena[0]'";
        $url = $conn->query($query);
        if (!$url) die ("db greska");
        while($slika=$url->fetch_array(MYSQLI_NUM))
        {
            echo <<<_END
                <br><img src="./slike/$slika[0]" width="300" height="300"><br>
                <form action='izmjena.php' method='post'>
                <input type='hidden' name='idslike' value='$slika[1]'>
                <input type='hidden' name='id' value='$id'>
                <input type='submit' value='IZBRISI SLIKU'></form>
            _END;
        }
    }

?>

<script>

    function dodajSliku()
    {
        var slika = document.createElement("input");
        slika.setAttribute("type", "file");
        slika.setAttribute("name", "slike[]");
        document.getElementById("slike").appendChild(slika);
    }

</script>
