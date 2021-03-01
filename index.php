<?php // index.php

     include 'db.php';
     include 'functions.php';
     include 'header.php';

    //brisanje
    if (!isset($_POST['izmjena']) && isset($_POST['id']))
    {
        $id = get_post($conn, 'id');
        $query = "SELECT url FROM slike WHERE nekretnina_id=$id";
        $result = $conn->query($query);
        if (!$result) echo "db error";
        while (unlink("./slike/".$result->fetch_array(MYSQLI_NUM)[0]));
        $query = "DELETE FROM nekretnine WHERE id=$id";
        $result = $conn->query($query);
        if (!$result) echo "brisanje neuspjesno";
    }

    //dodavanje
    if (!isset($_POST['izmjena']) && isset($_POST['grad']) && isset($_POST['tip_nekretnine']) && isset($_POST['tip_oglasa']) && isset($_POST['povrsina'])
    && isset($_POST['cijena']) && isset($_POST['godina']) && isset($_POST['opis']))
    {
        $grad = get_post($conn, 'grad');
        $tip_nekretnine = get_post($conn, 'tip_nekretnine');
        $tip_oglasa = get_post($conn, 'tip_oglasa');
        $povrsina = get_post($conn, 'povrsina');
        $cijena = get_post($conn, 'cijena');
        $godina = get_post($conn, 'godina');
        $opis = get_post($conn, 'opis');
        if (isset($_POST['prodata']))
        {
            $prodata='1';
            $datum = "'".get_post($conn, 'datum')."'";
        }
        else
        {
            $prodata='0';
            $datum = 'NULL';
        }
        $query = "INSERT INTO nekretnine(gradovi_id, tip_nekretnine_id, tip_oglasa_id, povrsina, cijena, godina, opis, prodata, datum_prodaje)
        VALUES ('$grad','$tip_nekretnine','$tip_oglasa','$povrsina','$cijena','$godina','$opis','$prodata',$datum)";
        $result = $conn->query($query);
        if (!$result) echo "dodavanje neuspjesno";

        $query = "SELECT MAX(id) FROM nekretnine";
        $result = $conn->query($query);
        if (!$result) echo "db greska";
        $id=$result->fetch_array(MYSQLI_NUM)[0];
        foreach ($_FILES['slike']['tmp_name'] as $i => $tmp_name)
        {
            $original_name = $_FILES['slike']['name'][$i];
            $temp_arr = explode(".", $original_name );
            $ext = $temp_arr[ count($temp_arr)-1];
            $new_file_name = uniqid().".".$ext;
            copy($tmp_name, "./slike/".$new_file_name);

            $query = "INSERT INTO slike (nekretnina_id, url) VALUES ('$id','$new_file_name')";
            $result = $conn->query($query);
            if (!$result) echo "db greska2";
        }
    }

    //izmjena
    if (isset($_POST['izmjena']) && isset($_POST['id']) && isset($_POST['grad']) && isset($_POST['tip_nekretnine']) && isset($_POST['tip_oglasa']) && isset($_POST['povrsina'])
    && isset($_POST['cijena']) && isset($_POST['godina']) && isset($_POST['opis']))
    {
        $id = get_post($conn, 'id');
        $grad = get_post($conn, 'grad');
        $tip_nekretnine = get_post($conn, 'tip_nekretnine');
        $tip_oglasa = get_post($conn, 'tip_oglasa');
        $povrsina = get_post($conn, 'povrsina');
        $cijena = get_post($conn, 'cijena');
        $godina = get_post($conn, 'godina');
        $opis = get_post($conn, 'opis');
        if (isset($_POST['prodata']))
        {
            $prodata='1';
            $datum = "'".get_post($conn, 'datum')."'";
        }
        else
        {
            $prodata='0';
            $datum = 'NULL';
        }
        $query = "UPDATE nekretnine SET gradovi_id='$grad', tip_nekretnine_id='$tip_nekretnine', tip_oglasa_id='$tip_oglasa',
                  povrsina='$povrsina', cijena='$cijena', godina='$godina', opis='$opis', prodata='$prodata', datum_prodaje=$datum
                  WHERE id='$id'";
        $result = $conn->query($query);
        if (!$result) echo "izmjena neuspjesna";

        foreach ($_FILES['slike']['tmp_name'] as $i => $tmp_name)
        {
            $original_name = $_FILES['slike']['name'][$i];
            $temp_arr = explode(".", $original_name );
            $ext = $temp_arr[ count($temp_arr)-1];
            $new_file_name = uniqid().".".$ext;
            copy($tmp_name, "./slike/".$new_file_name);

            $query = "INSERT INTO slike (nekretnina_id, url) VALUES ('$id','$new_file_name')";
            $result = $conn->query($query);
            if (!$result) echo "db greska2";
        }
    }

    // pretraga
    $query = "SELECT * FROM gradovi";
    $result = $conn->query($query);
    if (!$result) die ("db greska");
    $gradovi="<select name='pretraga_grad'> <option disabled selected value> -- trazi po gradovima -- </option>";
    while ($row = $result->fetch_array(MYSQLI_NUM))
        $gradovi=$gradovi."<option value='$row[1]'>$row[1]</option>";
    $gradovi=$gradovi." </select>";

    $query = "SELECT * FROM tip_nekretnine";
    $result = $conn->query($query);
    if (!$result) die ("db greska");
    $tip_nekretnine="<select name='pretraga_tip_nekretnine'> <option disabled selected value> -- tip nekretnine -- </option>";
    while ($row = $result->fetch_array(MYSQLI_NUM))
        $tip_nekretnine=$tip_nekretnine."<option value='$row[1]'>$row[1]</option>";
    $tip_nekretnine=$tip_nekretnine." </select>";

    echo <<<_END
    <form action='index.php' method='get'><hr>
    PRETRAGA: 
    Grad: $gradovi 
    Tip nekretnine: $tip_nekretnine 
    Tip oglasa:
    <select name="pretraga_tip_oglasa">
        <option disabled selected value> -- tip oglasa -- </option>"
        <option value="prodaja">prodaja</option>
        <option value="iznajmljivanje">iznajmljivanje</option>
        <option value="kompenzacija">kompenzacija</option>
    </select> 
    Povrsina min: <input type="number" name="povrsina_min" >
    Povrsina max: <input type="number" name="povrsina_max" >
    Cijena min: <input type="number" name="cijena_min" >
    Cijena max: <input type="number" name="cijena_max" >
    <input type="submit" value="TRAZI"> </form>
    _END;

    $where_arr = [];
    $where_arr[] = " 1=1 ";
    if( isset($_GET['pretraga_grad']) && $_GET['pretraga_grad'] != "" )
    {
        $pretraga_grad=$_GET['pretraga_grad'];
        $where_arr[] = " gradovi.ime LIKE '$pretraga_grad'";
    }
    if( isset($_GET['pretraga_tip_nekretnine']) && $_GET['pretraga_tip_nekretnine'] != "" )
    {
        $pretraga_tip_nekretnine=$_GET['pretraga_tip_nekretnine'];
        $where_arr[] = " tip_nekretnine.tip LIKE '$pretraga_tip_nekretnine'";
    }
    if( isset($_GET['pretraga_tip_oglasa']) && $_GET['pretraga_tip_oglasa'] != "" )
    {
        $pretraga_tip_oglasa=$_GET['pretraga_tip_oglasa'];
        $where_arr[] = "tip_oglasa.tip LIKE '$pretraga_tip_oglasa'";
    }
    if( isset($_GET['povrsina_min']) && $_GET['povrsina_min'] != "" )
    {
        $povrsina_min=$_GET['povrsina_min'];
        $where_arr[] = " nekretnine.povrsina >= $povrsina_min";
    }
    if( isset($_GET['povrsina_max']) && $_GET['povrsina_max'] != "" )
    {
        $povrsina_max=$_GET['povrsina_max'];
        $where_arr[] = " nekretnine.povrsina <= $povrsina_max";
    }
    if( isset($_GET['cijena_min']) && $_GET['cijena_min'] != "" )
    {
        $cijena_min=$_GET['cijena_min'];
        $where_arr[] = " nekretnine.cijena >= $cijena_min";
    }
    if( isset($_GET['cijena_max']) && $_GET['cijena_max'] != "" )
    {
        $cijena_max=$_GET['cijena_max'];
        $where_arr[] = " nekretnine.cijena <= $cijena_max";
    }
    
    
    $where_str = implode(" AND ", $where_arr );

    $query = "SELECT nekretnine.id, nekretnine.povrsina, nekretnine.cijena, nekretnine.godina, nekretnine.opis, 
    nekretnine.prodata, nekretnine.datum_prodaje, gradovi.ime, tip_nekretnine.tip, tip_oglasa.tip
    FROM nekretnine left JOIN gradovi ON nekretnine.gradovi_id=gradovi.id 
    LEFT JOIN tip_nekretnine ON nekretnine.tip_nekretnine_id=tip_nekretnine.id 
    LEFT JOIN tip_oglasa ON nekretnine.tip_oglasa_id=tip_oglasa.id WHERE $where_str";
    $result = $conn->query($query);
    if (!$result) die ("db greska");

    while ($row = $result->fetch_array(MYSQLI_NUM))
    {   
        $query = "SELECT url FROM slike WHERE nekretnina_id='$row[0]' LIMIT 1";
        $url = $conn->query($query);
        if (!$url) die ("db greska");
        $url=$url->fetch_array(MYSQLI_NUM)[0];

        if(!$row[5]) $prodata="Ne";
        else $prodata="Da ($row[6])";

        echo <<<_END
        <table><hr><tr>
        <td width="300">
            <img src="./slike/$url" width="250" height="250">
        </td>
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
        <td width="300">
            <form action='detaljno.php' method='post'>
            <input type='hidden' name='id' value='$row[0]'>
            <input type="submit" value="Detaljno"> </form><br><br>

            <form action='izmjena.php' method='post'>
            <input type='hidden' name='id' value='$row[0]'>
            <input type="submit" value="Izmjeni nekretninu"> </form><br><br>

            <form action='index.php' method='post'>
            <input type='hidden' name='id' value='$row[0]'>
            <input type="submit" value="Obrisi nekretninu"> </form><br><br>
        </td>
        </tr></table>
        _END;   
    }

    echo <<<_END
    <form action="./dodavanje.php"><hr>
        <input type="submit" value="DODAJ NEKRETNINU" />
    </form>
    _END;
    
    $result->close();
    $conn->close();

?>
