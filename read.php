<?php require "templates/header.php"; ?>

<div class="center-align">

    <?php

    require "database/config.php";


    //Establish the connection
    $conn = mysqli_init();
    mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
    if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL)){
        die('Failed to connect to MySQL: '.mysqli_connect_error());
    }

    //Test if table exists
    $res = mysqli_query($conn, "SHOW TABLES LIKE 'Products'");

    if (mysqli_num_rows($res) <= 0) {
        echo "<h2>La lista de alumnos esta vacía</h2>";
    } else {
        //Query and print data
        $res = mysqli_query($conn, 'SELECT * FROM Products');

        if (mysqli_num_rows($res) <= 0) {
            echo "<h2>La lista de alumnos esta vacía</h2>";
        }
        else {
            echo "<table> <tr align=\"left\"> <th> Nombre del alumno</th> <th> Calificación </th> </tr>";
            while ($row = mysqli_fetch_assoc($res)) {
                echo "<tr align=\"left\"> <td> ".$row["ProductName"]." </td>";
                echo "<td> ".$row["Price"]." </td> </tr>";
            }
            echo "</table>";
        }
    }

    //Close the connection
    mysqli_close($conn);

    ?>

    <br> <br> <br>

    <table>
        <tr>
            <td> <a href="insert.php">Agregar un alumno</a> </td>
            <td> <a href="update.php">Actualizar un alumno</a> </td>
            <td> <a href="delete.php">Remover un alumno</a> </td>
            <td> <a href="index.php">Voler a la pagina de inicio</a> </td>
        </tr>
    </table>
    
</div>

<?php require "templates/footer.php"; ?>

