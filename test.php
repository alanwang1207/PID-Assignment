if (isset($_POST["btnOK"])&&$_POST["txtQuantity"] != "0") {
    $itemid = $_POST["btn444"];
    echo $itemid;

    $quantity = $_POST["txtQuantity"];
    $sql = <<<multi
  INSERT INTO shoplists (itemID, quantity,userId) VALUES
  ('$itemid', '$quantity','$id')
multi;

    $result = mysqli_query($link, $sql);
    header("location:echo.php");
    exit();

} else {

  $sql = <<<multi
  select * from itemlists 
  multi;
  $result = mysqli_query($link, $sql);

  echo $_SESSION['id'];
}

?>





    <tr>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>


        <form id="form1" name="form1" method="post">
          <td><?= $row["itemname"] ?></td>
          <?php if ($_SESSION["login_session"] != false) { ?>
            <td><?= $row["itemprice"] ?></td>
          <?php } else { ?>

            <td> <input type="text" name="txtprice" id="txtprice" value="<?= $row["itemprice"] ?>" /></td>
          <?php  } ?>

          <td><?= $row["species"] ?></td>
          <?php if ($_SESSION["login_session"] != false) { ?>

            <td> <input type="text" name="txtQuantity" id="txtQuantity" value="0" /></td>
          <?php } ?>

          <td>
            <?php if ($_SESSION["login_session"] == false) { ?>
              <a href="login.php" class="btn btn-danger btn-sm">新增</a>
            <?php } else { ?>

              <input type="submit" name="btnOK" id="btnOK" value="新增" class="btn btn-success btn-sm" />

              <input type="hidden" name="btn444" id="btn444" value="<?php echo $row["itemID"] ?>" />
            <?php } ?>
          </td>
        </form>
    </tr>

  <?php  } ?>


  </table>



  <table width="600" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#F2F2F2">
    <td align="left" bgcolor="#CCCCCC">
      <font color="#CCCCCC">11</font>
    </td>
  </table>
</body>

</html>