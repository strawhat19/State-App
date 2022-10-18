
<?php 

$firestoreUsers = file_get_contents('https://firestore.googleapis.com/v1/projects/github-projects-81e89/databases/(default)/documents/githubUsers/');

$users = json_decode($firestoreUsers)->documents;

foreach($users as $userIndex=>$user) {
    ?> 
        <div class="user"><?php echo $user->fields->login->stringValue; ?></div>
    <?php
}

?>

