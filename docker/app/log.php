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
            if(isset($_POST['submit'])){

                $user= $_POST['username'];
                $mdp= $_POST['password'];
                $content= $_POST['content'];
                $titre= $_POST['titre'];

                $host = 'database';
                $db   = 'php_dp';
                $root = 'root';
                $pass = 'password';
                $charset = 'utf8mb4';
                $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
                $pdo = new PDO($dsn, $root, $pass);
            
                $sql = "SELECT * FROM blog_user where user = :user ";
                $resultat = $pdo->prepare($sql);
                $resultat->bindParam("user", $user);
                $resultat->execute();

                $id = "SELECT id FROM blog_user where user = :user ";
                $resultat_id = $pdo->prepare($id);
                $resultat_id->bindParam("user", $user);
                $resultat_id->execute();
                $id_user_temp = $resultat_id -> fetch(PDO::FETCH_ASSOC);
                $id_user = $id_user_temp['id'];

                $blog = "SELECT id,content,name_user,titre FROM blog_comment ORDER BY id DESC";
                $resultat_blog = $pdo->prepare($blog);
                $resultat_blog->execute();
                $data_blog = $resultat_blog -> fetchAll(PDO::FETCH_OBJ);

                if($resultat->rowCount() > 0)
                {
                    $data = $resultat -> fetchAll();
                    if (password_verify($mdp, $data[0]["password"])){
                        echo $user." Vous etes connecte";
                        $_SESSION['username'] = $user;

                        if($titre == 0 or $content == 0 ){
                            
                        }else{
                            $post = "INSERT INTO blog_comment (id_user,content,name_user,titre) VALUES (:id_user,:content,:user,:titre)";
                            $post_blog = $pdo->prepare($post);
                            $post_blog->execute(
                                [
                                    ":id_user"=>$id_user,
                                    ":content"=>$content,
                                    ":user"=>$user,
                                    ":titre"=>$titre,
                                ]
                            );
                            $_POST['content'] = 0;
                            $_POST['titre'] = 0;
                        }
                        
                        echo'
                            <form method="POST" action="log.php">
                                <div class="field">
                                    <label>titre :</label>
                                    <input  type="text" name="titre" placeholder="content" required>
                                </div>

                                <div class="field">
                                    <label>content :</label>
                                    <textarea name="content" style="overflow:scroll;resize:both" required></textarea>
                                </div>

                                <input  type="hidden" name="username" value="'.$user.'" required>
                                <input  type="hidden" name="password" value="'.$mdp.'" required>

                                <div class="ui right aligned segment">
                                    <input type="submit" name="submit" ></input>
                                </div>
                            </form>
                        ';

                        foreach($data_blog as $all_blogs):
                            echo'
                                <div id="'.$all_blogs->id.'" >
                                <h2>'.$all_blogs->name_user.'</h2>
                                <h3>'.$all_blogs->titre.'</h3>
                                <p onclick ="edit_msg('.$all_blogs->id.')">'.$all_blogs->content.'</p> 
                                </div>
                            ';
                        endforeach;

                    }
                    else{
                        echo $user." code faux ou pseudo deja utilise";
                    }
                }
                else{
                    $mdp = password_hash($mdp, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO blog_user (user,password) VALUES (:user,:mdp)";
                    $req = $pdo->prepare($sql);
                    $req->execute(
                        [
                            ":user"=>$user,
                            ":mdp"=>$mdp,
                        ]
                    );
                    echo $user." Votre enregistrement a etait effectue.";
                }
            }
        ?>
        </body>
        <script> 
            function edit_msg(id) {
                $msg = prompt("Edit your message", $("#msg-"+id).attr("cont"))
                $.post("/edit?id="+id+"&msg="+$msg);
            }   
        </script>

    </html>
        