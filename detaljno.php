<?php // detaljno.php

     include 'db.php';
     include 'functions.php';
     include 'header.php';

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

        $row = $result->fetch_array(MYSQLI_NUM);

        if(!$row[5]) $prodata="Ne";
        else $prodata="Da ($row[6])";

        echo <<<_END
        <table><hr><tr>
        <td width="300">
            Grad: $row[7] <br>
            Tip nekretnine: $row[8] <br>
            Tip oglasa: $row[9] <br>
            Povrsina: $row[1] <br>
            Cijena: $row[2] <br>
            Godina: $row[3] <br>
            Prodata: $prodata <br>
        </td>
        <td width="300">
            $row[4]
        </td>
        </tr></table>
        _END;

        $query = "SELECT url FROM slike WHERE nekretnina_id='$row[0]'";
        $url = $conn->query($query);
        if (!$url) die ("db greska");
        while($slika=$url->fetch_array(MYSQLI_NUM))
        {
            echo <<<_END
                <br><img src="./slike/$slika[0]" width="300" height="300"><br>
            _END;
        }
    }
    
    $result->close();
    $conn->close();

?>
