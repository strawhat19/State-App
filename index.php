<?php include('header.php')?>
<div id="wrapper">
    <main class="mainSection">
        <form class="php" method="post" action="<?php echo $localPage ?>">
            <span class="formInner">
                <input type="hidden" name="users" id="users">
                <input type="text" name="username" id="username" placeholder="Github Username">
                <button name="submitForm" type="submit" class="submitButton">Submit</button>
            </span>
    </main>

    <?php 
        if (isset($_POST['submitForm'])) {
            $users = json_decode($_POST['users']);
            $username = $_POST['username'];

            foreach($users as $userIndex=>$user) {
             ?>
                <div id="<?php echo $user->id ?>" class="user hero">
              <div class="row userRow">
                <div class="userCont large-12 columns">
                  <h1 class="title">(<?php echo $userIndex+1 ?>) <?php echo $user->name; ?>'s Apps</h1>
                  <div class="user">
                    <div class="userInner">
                        <div class="userName"><?php echo $user->name; ?></div>
                        <span class="linkContainer ${user.login}"><a class="githubLink userGit" href="<?php echo $user->url; ?>"><img src="<?php echo $user->avatar; ?>" class="userAvatar" /> <?php echo $user->login; ?></a></span>
                        <?php if ($user->bio): ?><div class="userBio"><?php echo $user->bio; ?></div><?php endif ?>
                    </div>
                  </div>
                </div>
              </div>
              <main id="<?php echo $user->login; ?>Section" class="section">
                <span id="<?php echo $user->login; ?>Button" class="formInner">
                    <button id="<?php echo $user->id; ?>" name="Delete" class="deleteButton submitButton">Delete</button>
                </span>
              </main>
            </div>
            <div id="lowerContainer" class="row">
              <section id="<?php echo $user->login; ?>apps" class="apps appsInit">
                <?php foreach($user->projects as $index=>$app) {
                    ?>
                        <div class="app" title="<?php echo $app->login; ?>">
                            <span class="index"><?php echo $index+1; ?></span>
                            <div class="appInner">
                            <a class="githubLink" href="<?php echo $app->url; ?>"><i class="fab fa-github"></i> <?php echo $app->name; ?> Github</a>
                            <a class="localLink" href="./apps/<?php echo $app->name; ?>/"><i class="fas fa-map-marker-alt"></i> <?php echo $app->name; ?> Local</a>
                            <a class="liveLink" href="${app?.homepage}" ${!app?.homepage && `style="display: none;"`}><i class="fas fa-globe-americas"></i> <?php echo $app->name; ?> Live</a>
                            </div>
                        </div>
                    <?php
                }?>
              </section>
            </div>
             <?php
            }
        }
    ?>
</div>
  <?php include('footer.php')?>
</body>
</html>