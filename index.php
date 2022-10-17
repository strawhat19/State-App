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
      if (isset($_POST['form'])) {
        $username = $_POST['username'];
        $users = json_decode($_POST['users']);
        if (is_array($users)) {
          LocalStorage::getInstance()->commit($users);
        }

        print_r($users);
      }
      $users = json_decode((string)LocalStorage::getInstance());
      if (is_array($users)) {
        foreach($users as $userIndex=>$user) {
          ?>
          <section class="userSection <?php echo $user->login ?>" id="<?php echo $user->id ?>">
            <div class="<?php echo $user->login ?> user hero" id="<?php echo $user->id ?>">
              <div class="row userRow">
                <div class="userCont large-12 columns">
                  <?php if ($user->name): ?>
                    <h1 class="title">(<?php echo $userIndex+1 ?>) <?php echo $user->name; ?>'s Apps</h1>
                  <?php else: ?>
                    <h1 class="title">(<?php echo $userIndex+1 ?>) <?php echo $user->login; ?>'s Apps</h1>
                  <?php endif ?>
                  <div class="user">
                    <div class="userInner">
                        <?php if ($user->name): ?><div class="userName"><?php echo $user->name; ?></div><?php endif ?>
                        <span class="linkContainer <?php echo $user->login; ?>"><a class="githubLink userGit" href="<?php echo $user->url; ?>"><img src="<?php echo $user->avatar; ?>" class="userAvatar" /> <?php echo $user->login; ?></a></span>
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
              <section id="<?php echo $user->login; ?>apps" class="apps appsInit appsSection">
                <?php foreach($user->projects as $index=>$app) {
                    ?>
                        <div class="app" title="<?php echo $app->login; ?>">
                            <span class="index"><?php echo $index+1; ?></span>
                            <div class="appInner">
                            <a class="githubLink" href="<?php echo $app->url; ?>"><i class="fab fa-github"></i> <?php echo $app->name; ?></a>
                            <a class="localLink" href="./apps/<?php echo $app->name; ?>/"><i class="fas fa-map-marker-alt"></i> <?php echo $app->name; ?></a>
                            <?php if ($app->homepage): ?><a class="liveLink" href="<?php echo $app->homepage; ?>"><i class="fas fa-globe-americas"></i> <?php echo $app->name; ?></a><?php endif ?>
                            </div>
                        </div>
                    <?php
                }?>
              </section>
            </div>
          </section>
          <?php
        }
      }
    ?>
  </div>
  <?php include('footer.php')?>
</body>
</html>