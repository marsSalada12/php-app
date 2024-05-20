<?php require "templates/header.php"; ?>

<div class="center-align">

    <?php

    if (isset($_POST['submit'])) {

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
            echo "<h2>El catalago de productos esta vacio</h2>";
        } else { 

            //Delete data
            $ProductName = $_POST['ProductName'];

            if ($stmt = mysqli_prepare($conn, "DELETE FROM Products WHERE ProductName = ?")) {
                mysqli_stmt_bind_param($stmt, 's', $ProductName);
                mysqli_stmt_execute($stmt);
                if (mysqli_stmt_affected_rows($stmt) == 0) {
                    echo "<h2>El producto \"$ProductName\" no fue encontrado en el catalago.</h2>";
                }
                else {
                    echo "<h2>El producto \"$ProductName\" ha sido removido del catalago.</h2>";
                }

                mysqli_stmt_close($stmt);
                
            }
        } 

        //Close the connection
        mysqli_close($conn);

    } else {

    ?>

    <h2>Remover un producto</h2>
    <br>

    <form method="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <table>
            <tr>
                <td class="no-border"> <label for="ProductName">Nombre del producto</label> </td>
                <td class="no-border"> <input type="text" name="ProductName" id="ProductName"> </td>
            </tr>
        </table>
        <br><br>
        <input type="submit" name="submit" value="Enviar">
    </form>

    <?php
        }
    ?>

    <br> <br> <br>
    <table>
        <tr>
            <td> <a href="delete.php">Remover otro producto</a> </td>
            <td> <a href="read.php">Ver catalago</a> </td>
            <td> <a href="index.php">Volver a la pagina de inicio</a> </td>
        </tr>
    </table>


</div>

<?php require "templates/footer.php"; ?>

