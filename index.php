<?php include('header.php')?>
  <div id="wrapper">
      <div class="formSection buttonSection">
          <form class="php" action="<?php echo $localPage ?>" method="post">
              <span class="formInner">
                  <input type="hidden" name="users" id="users">
                  <input type="text" name="username" id="username" placeholder="Github Username">
                  <button name="submitForm" type="submit" class="submitButton">Submit</button>
              </span>
          </form>
      </div>

      <form action="<?php echo $localPage ?>" method="post">
        <!-- <input type="text" name="username" id="username" placeholder="Github Username"> -->
        <input name="submitForm" type="submit" class="submitButton" value="Save" />
      </form>
      <?php 
      $firestoreUsers = file_get_contents('https://firestore.googleapis.com/v1/projects/github-projects-81e89/databases/(default)/documents/githubUsers/');

      $users = json_decode($firestoreUsers)->documents;
      if (is_array($users) && count($users) > 0) {
        foreach(array_reverse($users) as $userIndex=>$user) {
          ?>
          <section class="userSection" name="<?php echo $user->fields->login->stringValue ?>" id="<?php echo $user->fields->id->stringValue ?>">
            <div class="<?php echo $user->fields->login->stringValue ?> user hero" id="<?php echo $user->fields->id->stringValue ?>">
              <div class="row userRow">
                <div class="userCont large-12 columns">
                  <?php if (!empty($user->fields->name->stringValue)): ?>
                    <h1 class="title">(<?php echo $userIndex+1 ?>) <span id="<?php echo $user->fields->name->stringValue; ?>" class="title titleOf-<?php echo $user->fields->id->stringValue; ?>"><?php echo $user->fields->name->stringValue; ?>'s</span> Apps</h1>
                  <?php else: ?>
                    <h1 class="title">(<?php echo $userIndex+1 ?>) <span id="<?php echo $user->fields->login->stringValue; ?>" class="title titleOf-<?php echo $user->fields->id->stringValue; ?>"><?php echo $user->fields->login->stringValue; ?>'s</span> Apps</h1>
                  <?php endif ?>
                  <div class="user">
                    <div class="userInner">
                        <?php if (!empty($user->fields->name->stringValue)): ?><div class="userName"><?php echo $user->fields->name->stringValue; ?></div><?php endif ?>
                        <span class="linkContainer <?php echo $user->fields->login->stringValue; ?>"><a class="githubLink userGit" href="<?php echo $user->fields->url->stringValue; ?>"><img src="<?php echo $user->fields->avatar->stringValue; ?>" class="userAvatar" /> <?php echo $user->fields->login->stringValue; ?></a></span>
                        <?php if (!empty($user->fields->bio->stringValue)): ?><div class="userBio"><?php echo $user->fields->bio->stringValue; ?></div><?php endif ?>
                    </div>
                  </div>
                </div>
              </div>
              <div id="<?php echo $user->fields->login->stringValue; ?>Section" class="buttonSection">
                <span id="<?php echo $user->fields->login->stringValue; ?>Button" class="formInner">
                    <button id="<?php echo $user->fields->id->stringValue; ?>" name="Delete" class="deleteButton submitButton">Delete</button>
                </span>
              </div>
            </div>
            <div id="lowerContainer" class="row">
              <section id="<?php echo $user->fields->login->stringValue; ?>apps" class="apps appsInit appsSection">
                <?php foreach($user->fields->projects->arrayValue->values as $index=>$app) {
                    ?>
                        <div class="app" title="<?php echo $app->mapValue->fields->name->stringValue; ?>">
                            <span class="index"><?php echo $index+1; ?></span>
                            <div class="appInner">
                              <a class="githubLink" href="<?php echo $app->mapValue->fields->url->stringValue; ?>"><i class="fab fa-github"></i> <?php echo $app->mapValue->fields->name->stringValue; ?></a>
                              <a class="localLink" href="./apps/<?php echo $app->mapValue->fields->name->stringValue; ?>/"><i class="fas fa-map-marker-alt"></i> <?php echo $app->mapValue->fields->name->stringValue; ?></a>
                              <?php if (!empty($app->mapValue->fields->homepage->stringValue)): ?>
                                <a class="liveLink" href="<?php echo $app->mapValue->fields->homepage->stringValue; ?>">
                                  <i class="fas fa-globe-americas"></i> <?php echo $app->mapValue->fields->name->stringValue; ?>
                                </a>
                              <?php endif ?>
                            </div>
                        </div>
                    <?php
                }?>
              </section>
            </div>
          </section>
          <?php
        }
      } else {
        ?>
          <div class="noUsers">No Users Right Now</div>
        <?php
      }
    ?>
  </div>

  <?php 
    if (isset($_POST['submitForm'])) {
      LocalStorage::getInstance()->setValue('submitForm', $_POST['submitForm']);
      LocalStorage::getInstance()->commit();
    }
  ?>
  <?php include('footer.php')?>
</body>
</html>