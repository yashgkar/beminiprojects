<?php
session_start();
if ($_SESSION['sid'] == "") {
    header('Location:index.php');
}
$id = $_SESSION['sid'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SickoMail</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <h4>SickoMail</h4>
        <nav>
            <ul class="nav__links">
                <li><a href="yhome.php?chk=logout"><button>LOGOUT</button></a></li>
            </ul>
        </nav>
    </header>

    <?php
    include_once('connection.php');

    $id = $_SESSION['sid'];
    $sql = "SELECT * FROM usermail where sen_id='$id'";
    $dd = mysqli_query($con, $sql);
    list($mid, $rid, $sid, $s, $m, $a, $d) = mysqli_fetch_array($dd)
    ?>

    <div class="inbox">
        <ul>
            <li><a href="ycompose.php">COMPOSE</a></li>
            <li><a href="yhome.php">INBOX</li>
            <li><a href="ysent.php">SENT</a></li>
            <li><a href="ychngpswd.php">CHANGE PASSWORD</a></li>
            <li><a href="yprofed.php">PROFILE</a></li>
        </ul>
        <div class="inboxtable">
            <?php
            include_once('connection.php');

            @$id = $_SESSION['sid'];


            $sql = "SELECT * FROM usermail where sen_id='$id'";
            $dd = mysqli_query($con, $sql);

            echo "<br><br><br>";
            echo "<table>";
            echo "<tr>";
            echo "<td width='5%'>Check </td>
            <td>To </td>
            <td>Subject </td>
            <td>Message</td>
            <td>Date</td>";
            echo "</tr>";
            echo "<tr>";
            while (list($mid, $rid, $sid, $s, $m, $a, $d) = mysqli_fetch_array($dd)) {

                echo "<form action='delete_msg.php' method='post'>";
                echo "<td><input type='checkbox' name='ch[]' value='$mid'/></td>";
                echo "<td>" . $rid . "</td>";
                #echo "<td><a href='ysent.php?coninb=$mid'>" . $s . "</a></td>";
                echo "<td>" . $s . "</td>";
                echo "<td>" . $m . "</td>";
                echo "<td>" . $d . "</td>";
                echo "</tr>";
            }
            echo "</table>";

            echo "<button type='submit' value='Delete' name='delete'>Delete</button>";
            @$cheklist = $_REQUEST['ch'];
            if (isset($_GET['delete'])) {
                foreach ($cheklist as $v) {

                    $d = "DELETE from usermail where mail_id='$v'";
                    mysqli_query($con, $d);
                }
                echo "Mail Deleted";
            }
            ?>
        </div>
        <?php
        $id = $_SESSION['sid'];
        @$coninb = $_GET['coninb'];

        if ($coninb) {
            $sql = "SELECT * FROM usermail where sen_id='$id' and mail_id='$coninb'";
            $dd = mysqli_query($con, $sql);
            $row = mysqli_fetch_object($dd);
            echo "<br>";
            echo "<tr>";
            echo "<td>Subject :</td>";
            echo "<td>" . $row->sub . "</td>";
            echo "</tr><br><br>";
            echo "<tr>";
            echo "<td>Message :</td>";
            echo "<td>" . $row->msg . "</td>";
            echo "</tr><br><br>";
            echo "<tr><a href='ysent.php?chk=sent'><button>Go Back</button></a></tr>";
        }

        ?>










    </div>
    <?php
    @$id = $_SESSION['sid'];
    @$chk = $_REQUEST['chk'];
    @$coninb = $_REQUEST['coninb'];
    @$m = $_REQUEST[$mid];
    if ($chk == "vprofile") {
        include_once("editProfile.php");
    }
    if ($chk == "compose") {
        include_once('ycompose.php');
    }
    if ($chk == "sent") {
        include_once('ysent.php');
    }
    if ($chk == "trash") {
        include_once('trash.php');
    }
    if ($chk == "setting") {
        include_once('setting.php');
    }
    if ($chk == "chngPass") {
        include_once('ychngpswd.php');
    }
    if ($chk == "chngthm") {
        include_once('chngthm.php');
    }
    //if ($coninb == $m) {
    //   include_once('ymessage.php');
    //}
    if ($chk == "draft") {
        include_once('draft.php');
    }
    if ($chk == "updnews") {
        include_once('latestupd.php');
    }

    ?>
</body>

</html>