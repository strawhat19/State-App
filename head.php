<?php if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $url = "https://";
    } else {
        $url = "http://";
        $url.=$_SERVER['HTTP_HOST'];
        $url.=$_SERVER['REQUEST_URI'];
        $url;
    }
    $page = $url;
    $localPage = 'apps/State-App/';
    $title = 'PHP Form Submissions';
  

    if (isset($_POST['submitForm'])) {
      $user = json_decode($_POST['user']);
      $username = $_POST['username'];

      if (empty($user) || empty($username)) {
          exit();
      } else {

        
      LocalStorage::getInstance()->setValue('username', $username);
      LocalStorage::getInstance()->setValue('user', $user);
        LocalStorage::getInstance()->commit();
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