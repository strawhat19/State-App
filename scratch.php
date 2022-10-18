// // traverse all results
// foreach ($xpath->query('//row[@name="title"]') as $rowNode) {
//     echo $rowNode->nodeValue; // will be 'this item'
// }

// // Or access the first result directly
// $rowNode = $xpath->query('//row[@name="title"][1]')->item(0);
// if ($rowNode instanceof DomElement) {
//     echo $rowNode->nodeValue;
// }

<div id="lowerContainer" class="row">
      <section class="apps appsInit">
        <?php 


if (isset($_POST['submitForm'])) {
  $users = json_decode($_POST['users']);
  $username = $_POST['username'];

  if (is_array($users)) {
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
}


foreach($users->projects as $index=>$app) { ?>
    <div class="app" title="<?php echo $app; ?>">
        <span class="index"><?php echo $index+1; ?></span>
        <div class="appInner">
        <a class="liveLink" href="https://strawhat19.github.io/<?php echo $app; ?>/"><i class="fas fa-globe-americas"></i> <?php echo $app; ?> Live</a>
        <a class="localLink" href="./apps/<?php echo $app; ?>/" ${!apps.includes(app.name) && `style="display: none;"`}><i class="fas fa-map-marker-alt"></i> <?php echo $app; ?> Local</a>
        <a class="githubLink" href="https://github.com/strawhat19/<?php echo $app; ?>"><i class="fab fa-github"></i> <?php echo $app; ?> Github</a>
        </div>
    </div><?php
}
    
        if (isset($_POST['submitForm'])) {
                $user = json_decode($_POST['user']);
                $username = $_POST['username'];

                if (empty($user) || empty($username)) {
                    exit();
                } else {
                    print_r('Github Username:'.$username.'<br />');

                    foreach($user->projects as $index=>$app) { ?>
                        <div class="app" title="<?php echo $app; ?>">
                            <span class="index"><?php echo $index+1; ?></span>
                            <div class="appInner">
                            <a class="liveLink" href="https://strawhat19.github.io/<?php echo $app; ?>/"><i class="fas fa-globe-americas"></i> <?php echo $app; ?> Live</a>
                            <a class="localLink" href="./apps/<?php echo $app; ?>/" ${!apps.includes(app.name) && `style="display: none;"`}><i class="fas fa-map-marker-alt"></i> <?php echo $app; ?> Local</a>
                            <a class="githubLink" href="https://github.com/strawhat19/<?php echo $app; ?>"><i class="fab fa-github"></i> <?php echo $app; ?> Github</a>
                            </div>
                        </div><?php
                    }
                }
            }      
        ?>
      </section>
      <script type="module">
        let jsUsers = () => {
                  // Initialize Apps
        updatedUsers.forEach((user, userIndex) => {
          // Create Users
          wrapper.append(create(`
            <div id="${user?.login}" class="user hero">
              <div class="row userRow">
                <div class="userCont large-12 columns">
                  <h1 class="title">(${userIndex+1}) ${user.name}'s Apps</h1>
                  <div class="user">
                    <div class="userInner">
                        <div class="userName">${user.name}</div>
                        <span class="linkContainer ${user.login}"><a class="githubLink userGit" href="${user.url}"><img src="${user.avatar}" class="userAvatar" /> ${user.login}</a></span>
                        <div class="userBio ${user?.bio ? `valid` : `hidden`}">${user?.bio}</div>
                    </div>
                  </div>
                </div>
              </div>
              <main id="${user?.login}Section" class="section">
                <span id="${user?.login}Button" class="formInner">
                    <button id="${user?.id ?? user?.login}" name="Delete" class="deleteButton submitButton">Delete</button>
                </span>
              </main>
            </div>
          `));

          wrapper.append(create(`
          <div id="lowerContainer" class="row">
              <section id="${user?.login}apps" class="apps appsInit">
              </section>
            </div>
          `));

          let appsSection = $(`#${user?.login}apps`);
          user.projects.forEach((app, index) => {
            appsSection.append(create(`
              <div class="app" title="${app.name}">
                <span class="index">${index + 1}</span>
                <div class="appInner">
                  <a class="githubLink" href="${app.url}"><i class="fab fa-github"></i> ${app.name} Github</a>
                  <a class="localLink" href="./apps/${app.name}/"><i class="fas fa-map-marker-alt"></i> ${app.name} Local</a>
                  <a class="liveLink" href="${app?.homepage}" ${!app?.homepage && `style="display: none;"`}><i class="fas fa-globe-americas"></i> ${app.name} Live</a>
                </div>
              </div>
            `));
          });
        });
        }
      </script>
    </div>