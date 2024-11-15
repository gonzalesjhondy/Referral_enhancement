<div class="transaction_incomplete">
    <small>Notes</small>
    <textarea name="transaction_incomplete" class="form-control" id="" cols="30" rows="5"></textarea><br>
</div>
<!--
<style>
    input[type=radio] {
        width: 20%;
        height: 2em;
    }
</style>
<table class="table table-hover table-bordered">
    <tr>
        <td >
            <small>Dropped Calls</small>
            <input type="radio" value="drop_call" name="transaction_incomplete" <?php if(Session::get("client")->transaction_incomplete == 'drop_call') echo 'checked'; ?>>
        </td>
        <td >
            <small>Hung up</small>
            <input type="radio" value="hung_up" name="transaction_incomplete" <?php if(Session::get("client")->transaction_incomplete == 'hung_up') echo 'checked'; ?>>
        </td>
        <td >
            <small>Prank Calls</small>
            <input type="radio" value="prank_call" name="transaction_incomplete" <?php if(Session::get("client")->transaction_incomplete == 'prank_call') echo 'checked'; ?>>
        </td>
    </tr>
</table>
-->