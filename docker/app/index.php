<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <?php
            if(isset($_SESSION['user']))
            {
                echo"vous etes connecte en tant que".$_SESSION['user'];
            }
            else
            {
            ?>
                <div class="ui container">

                    <form method="POST" action="log.php">
                        <div class="field">
                            <label>Username</label>
                            <input  type="text" name="username" placeholder="Username" required>
                        </div>
                        <div class="field">
                            <label>Password"</label>
                            <input type="password" name="password" placeholder="Password"" required>
                        </div>
                        
                        <input  type="hidden" name="content" value="0" >
                        <input  type="hidden" name="titre" value="0" >

                        <div class="ui right aligned segment">
                            <input type="submit" name="submit" ></input>
                        </div>
                    </form>
                            
                </div>
            <?php
            }
            ?>
    </body>
</html>