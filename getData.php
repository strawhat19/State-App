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