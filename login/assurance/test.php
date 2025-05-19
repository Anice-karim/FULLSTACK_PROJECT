<td>
                <form action="code.php" method="POST" >
                <input type="hidden" name="accept_id" value="<?php echo $row['dossier_id']; ?>">
                <button  type="submit" name="accept_btn" class="btn btn-success"> Traiter</button>
                </form>
            </td>
            <td>
                 <form action="code.php" method="post">
                  <input type="hidden" name="refuse_id_as" value="<?php echo $row['dossier_id']; ?>">
                  <button type="submit" name="refuse_btn_as" class="btn btn-danger"> REFUSER</button>
                </form>
            </td>