<?php 
    $user = json_decode($_POST["user"]);
    $projects = json_decode($_POST["projects"]);

    if (isset($projects) && isset($user)) {
        foreach($projects as $index=>$project) { 
            ?>
                <div class="project" title="<?php echo $project->name; ?>">
                    <span class="index"><?php echo $index+1; ?></span>
                    <?php echo $project->name; ?>
                </div>
            <?php
        } 
    } else {
        $userData = json_decode(file_get_contents('https://firestore.googleapis.com/v1/projects/github-projects-81e89/databases/(default)/documents/githubUsers/6BKC7I078V5XhC4ylRuR'), true);
        print_r($userData);
        echo $userData;
    }

    if (isset($userData)) {
        // print_r($userData);
        foreach($userData as $data) { 
            ?>
                <div class="project" title="hello">
                    <span class="index"></span>
                    <?php echo $data; ?>
                </div>
            <?php
        } 
    }

?>

