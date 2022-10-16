<?php 
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $url = "https://";
    } else {
        $url = "http://";
        $url.=$_SERVER['HTTP_HOST'];
        $url.=$_SERVER['REQUEST_URI'];
        $url;
    }

    $page = $url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Refresh Page Every 10 Seconds -->
    <!-- <meta http-equiv="refresh" content="10" URL="<?php echo $page; ?>"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://piratechs.com/wp-content/uploads/2019/05/Icon.svg" type="image/x-icon">
     <!-- Font Awesome Version 5 -->
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous"/>
     <link rel="stylesheet" href="./styles/global.css">
    <title>PHP Form Submissions</title>
</head>
<body>

<main class="section">
    <h1 class="php">PHP Form Submissions</h1>

    <div class="contentFetch">
        <form class="php" method="post" action="/apps/State-App/">
            <input type="hidden" name="user" id="user">
            <input type="email" name="email" id="email" placeholder="Email">
            <input type="password" name="password" id="password" placeholder="Password">
            <button name="submitForm" type="submit" class="hello">Submit</button>
        </form>
    </div>

  <div class="projects">
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
  </div>
</main>

    <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" defer></script>
    <script type="module" text="text/javascript">
        let url = <?php echo json_encode($page) ?>;
        console.log(`PHP Website`, url);

        // Github
        const getGithubData = async () => {

            // Custom User Object
            class User {
                constructor(name,url,bio,projects,blog,avatar,login,repoNum,repoLink,starred,followers,following) {
                    this.name = name;
                    this.url = url;
                    this.bio = bio;
                    this.projects = projects;
                    this.blog = blog;
                    this.avatar = avatar;
                    this.login = login;
                    this.repoNum = repoNum;
                    this.repoLink = repoLink;
                    this.starred = starred;
                    this.followers = followers;
                    this.following = following;
                }
            }

            // Custom Repo Object
            class Repository {
                constructor(name,url,date,owner,topics,license,updated,deployment,language,homepage,description) {
                    this.name = name;
                    this.url = url;
                    this.date = date;
                    this.owner = owner;
                    this.updated = updated;
                    this.deployment = deployment;
                    this.license = license;
                    this.topics = topics;
                    this.language = language;
                    this.homepage = homepage;
                    this.description = description;
                }
            }

            console.log(`Creating Github User...`);
            const username = `strawhat19`;
            const repoURL = `https://api.github.com/users/${username}/repos`;
            const githubURL = `https://api.github.com/users/${username}`;
            const responseRepos = await fetch(repoURL);
            const response = await fetch(githubURL);
            const repositories = JSON.parse(localStorage.getItem(`repositories`)) || [];
            
            if (!response.ok || !responseRepos.ok) {
                console.log(`Fetch Error`);
                console.clear();
                init();
            } else {
                const githubRepos = await responseRepos.json();
                const github = await response.json();
                const {name,html_url,bio,blog,avatar_url,login,public_repos,repos_url,starred_url,followers,following} = github;

                githubRepos.map(repo => {
                const {name,html_url,created_at,owner,topics,license,updated_at,deployments_url,language,homepage,description} = repo;
                const filteredRepo = new Repository(name,html_url,created_at,owner,topics,license,updated_at,deployments_url,language,homepage,description);
                repositories.push(filteredRepo);
                });

                const user = JSON.parse(localStorage.getItem(`user`)) || new User(name,html_url,bio,repositories,blog,avatar_url,login,public_repos,repos_url,starred_url,followers,following);

                localStorage.setItem(`repositories`, JSON.stringify(repositories));
                localStorage.setItem(`user`, JSON.stringify(user));

                console.log(`Github User Created`, user);

                // updateDoc(doc(db, `githubUsers`, `6BKC7I078V5XhC4ylRuR`), {
                //     ...user,
                //     id: `6BKC7I078V5XhC4ylRuR`,
                // }).then(data => console.log(data));

            };
        }

        window.addEventListener(`DOMContentLoaded`, event => {

            let user = JSON.parse(localStorage.getItem(`user`));
            let phpForm = $(`.php`);

            $(`#user`).val(JSON.stringify(user));
        
        });

    </script>
</body>
</html>