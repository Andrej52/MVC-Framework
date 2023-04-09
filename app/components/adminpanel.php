<!-- 
This is an scheme for an elemenary adminpanel
It is an includable  component 
NOTE: make your own HTML to suit onto your webpage
-->
<ul>
    <?php 
    if (!isset($_SESSION['username'])) 
        echo '  <a href="register">register</a>
                <a href="login">login</a>    ';
    else
        {
            echo '  <a href="../app/controllers/interactions.php?action=Logout">Logout</a>';
            echo "  <div>prihlaseny ako: {$_SESSION['username']}</div>";
            switch ($_SESSION['role']) {
                case 'member':
                    echo ' 
                    <a href="add_topics/add">add-topic</a>
                    <a href="add_topics/add2">add_gallery</a>
                    <a href="select">select</a>
                    ';
                    break;
                case 'user':
                    echo ' <a href="select">select</a>';
                    break;
                default:
                    break;
            }
        }
       
?>
    </ul>