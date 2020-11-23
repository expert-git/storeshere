<h3>
    <?php echo $user[0]['inmates_name']." : ".$user[0]['inmates_booking_no']; ?>
</h3>
<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Email/Phone</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach($user as $ur) { ?>
    <tr>
        <td><?php echo $ur['username']; ?></td>
        <td><?php echo $ur['email']; ?></td>
    </tr>
    <?php
        }
    ?>
    </tbody>
</table>
<style>
    table {
      border-collapse: collapse;
    }
    
    table, th, td {
      border: 1px solid black;
      text-align: center;
    }
</style>