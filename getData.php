<?php 
    if (isset($_POST['submitForm'])) {
        $users = json_decode($_POST['users']);
        $username = $_POST['username'];

        print_r($_POST);

        if (empty($users) || empty($username)) {
            exit();
        } else {
            print_r($users);
            print_r($username);

            foreach($users as $index=>$user) { 
                ?>
                    <div class="user" title="<?php echo $user->name; ?>">
                        <span class="index"><?php echo $index+1; ?></span>
                        <?php echo $user->name; ?>
                    </div>
                <?php
            } 
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Hello
</body>
</html>