<!DOCTYPE html>
<html lang="en">
  <head>
  <?php include('head.php');
        include('localStorage.php');
?>
    <meta charset="UTF-8">
    <!-- Refresh Page Every 10 Seconds -->
    <!-- <meta http-equiv="refresh" content="10" URL="<?php // echo $page; ?>"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://piratechs.com/wp-content/uploads/2019/05/Icon.svg" type="image/x-icon">
     <!-- Font Awesome Version 5 -->
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous"/>
     <link rel="stylesheet" href="./styles/all.css">
     <link rel="stylesheet" href="./styles/bitnami.css">
     <link rel="stylesheet" href="./styles/global.css">
    <title><?php echo $title; ?></title>
</head>
<body>
<div class="contain-to-grid">
  <nav class="top-bar" data-topbar>
      <ul class="title-area">
      <li class="name">
          <h1><a href="<?php echo $page; ?>"><i class="fas fa-globe-americas"></i> <?php echo $title; ?></a></h1>
      </li>
      <li class="toggle-topbar menu-icon">
          <a href="#">
          <span>Menu</span>
          </a>
      </li>
      </ul>

      <section class="top-bar-section">
      <!-- Right Nav Section -->
      <ul class="right">
          <li class="active"><a href="/applications">Applications</a></li>
      </ul>
      </section>
  </nav>
</div>
<script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" defer></script>
<script type="module" defer>
    // Firestore Imports
    // https://firebase.google.com/docs/web/setup#available-libraries
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.12.1/firebase-app.js";
    import { getFirestore, collection, getDocs, onSnapshot, addDoc, deleteDoc, doc, query, where, orderBy, serverTimestamp, getDoc, updateDoc } from 'https://www.gstatic.com/firebasejs/9.12.1/firebase-firestore.js';

    // Functions 
    export const dom = (selector) => document.querySelector(selector);
    export const domA = (selector) => document.querySelectorAll(selector);
    export const log = (item, item1) => item1 ? console.log(item, item1) : console.log(item);

    // Variables
    const appsCont = $(`.apps`);
    const wrapper = dom(`#wrapper`);
    const userCont = domA(`.userRow`);
    const appsInner = dom(`.appsInner`);

    const body = $(`body`);
    body.attr(`style`,`display: none`);
    body.fadeIn(1500);

    // Your web app's Firebase configuration
    const firebaseConfig = {
        apiKey: "AIzaSyDdYG9FKpI_AKXzzAgiy_zVgq7-JqgjFN0",
        authDomain: "github-projects-81e89.firebaseapp.com",
        projectId: "github-projects-81e89",
        storageBucket: "github-projects-81e89.appspot.com",
        messagingSenderId: "560866180522",
        appId: "1:560866180522:web:082c51c8da761168a73fd3"
    };

    // Initialize
    export const create = (xmlString) => {
      let div = document.createElement('div');
      div.innerHTML = xmlString.trim();
      return div.firstChild;
    }

    // Firestore
    initializeApp(firebaseConfig);
    const db = getFirestore();

    const init = () => {
      getDocs(collection(db, `githubUsers`)).then((snapshot) => {
        let updatedUsers = snapshot.docs.map(entry => {
          return {...entry.data(), id: entry.id}
        });
        snapshot.docs.length > 0 && (
          localStorage.setItem(`users`, JSON.stringify(updatedUsers))
        );
        console.log(`Registered Users`, updatedUsers);
        console.log(`PHP Local Storage`, <?php echo json_encode((string)LocalStorage::getInstance()) ?>);

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
                        <div class="userBio">${user.bio}</div>
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

        const deleteButtons = domA(`.deleteButton`);
        // If User Clicks Delete
        deleteButtons.forEach(button => button.addEventListener(`click`, event => {
          event.preventDefault();
          deleteDoc(doc(db, 'githubUsers', event.target.id)).then((data) => console.log(`User Deleted`));
        }));
      });
    }

     // Github
     export const asyncFetch = async (url) => {
          const asyncResponse = await fetch(url);
          const asyncData = await asyncResponse.json();
          return asyncData;
      };

      const getGithubData = async (username) => {
        console.log(username);
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

          const repoURL = `https://api.github.com/users/${username}/repos`;
          const githubURL = `https://api.github.com/users/${username}`;
          const repositories = JSON.parse(localStorage.getItem(`repositories`)) || [];
          const responseRepos = await fetch(repoURL);
          const response = await fetch(githubURL);
          
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

              const user = new User(name,html_url,bio,repositories,blog,avatar_url,login,public_repos,repos_url,starred_url,followers,following);

              localStorage.setItem(`user`, JSON.stringify(user));
              
              let users = JSON.parse(localStorage.getItem(`users`)) || [];
              console.log(`Users`, users);
              console.log(`Github User Created`, user);
              
              if (users.map(usr => usr?.login).includes(user?.login)) {
                console.log(`User Exists`);
                updateDoc(doc(db, `githubUsers`, users.filter(usr => usr.login == user.login)[0].id.toString()), {
                  ...user,
                  id: users.filter(usr => usr.login == user.login)[0].id.toString(),
                }).then(data => console.log(`User Updated`));
                $(`#user`).val(JSON.stringify(user));
              } else {
                users.push(user);
                localStorage.setItem(`users`, users);
                console.log(`Updated Users`, users);
                addDoc(collection(db, `githubUsers`), {...JSON.parse(localStorage.getItem(`user`))}).then(data => console.log(`User Added`));
                $(`#user`).val(JSON.stringify(user));
              }
              
              init();
              
          };
      }

      $.fn.serializeObject = function(){
          var o = {};
          var a = this.serializeArray();
          $.each(a, function() {
              if (o[this.name] !== undefined) {
                  if (!o[this.name].push) {
                      o[this.name] = [o[this.name]];
                  }
                  o[this.name].push(this.value || '');
              } else {
                  o[this.name] = this.value || '';
              }
          });
          return o;
      };
      
      $(function() {
          $('form').submit(function() {
              $('#result').text(JSON.stringify($('form').serializeObject()));
              return false;
          });
      });

      // Get Data from Database
      window.addEventListener(`DOMContentLoaded`, event => {
          let users = JSON.parse(localStorage.getItem(`users`)) || [];
          let url = <?php echo json_encode($page) ?>;
          console.log(`PHP Website`, url);
          init();

          $(`.php`).on(`submit`, event => {
            event.preventDefault();
            let formValues = $(`.php`).serializeObject();
            console.log({...formValues, user: users[0], users});
            
          });
      });
</script>