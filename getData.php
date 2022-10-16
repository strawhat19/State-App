<?php 
    if (isset($_POST['submitForm'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = json_decode($_POST['user']);

        if (empty($user) || empty($email) || empty($password)) {
            exit();
        } else {
            print_r($email);
            print_r($password);

            foreach($user->projects as $index=>$project) { 
                ?>
                    <div class="project" title="<?php echo $project->name; ?>">
                        <span class="index"><?php echo $index+1; ?></span>
                        <?php echo $project->name; ?>
                    </div>
                <?php
            } 
        }
    }
?>