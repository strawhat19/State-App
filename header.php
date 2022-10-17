<!DOCTYPE html>
<html lang="en">
  <head>
  <?php
        include('localStorage.php');
        include('head.php');
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
    const mainSection = dom(`.mainSection`);

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

        const deleteButtons = domA(`.deleteButton`);
        // If User Clicks Delete
        deleteButtons.forEach(button => button.addEventListener(`click`, event => {
          event.preventDefault();
          deleteDoc(doc(db, 'githubUsers', event.target.id)).then((data) => console.log(`User Deleted`));
        }));
      });
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

     // Github
     export const asyncFetch = async (url) => {
          const asyncResponse = await fetch(url);
          const asyncData = await asyncResponse.json();
          return asyncData;
      };

      const getGithubData = async (formValues) => {
        let username = formValues.username;
        console.log(username);

          const repoURL = `https://api.github.com/users/${username}/repos`;
          const githubURL = `https://api.github.com/users/${username}`;
          const repositories = JSON.parse(localStorage.getItem(`repositories`)) || [];
          const responseRepos = await fetch(repoURL);
          const response = await fetch(githubURL);
          
          if (!response.ok || !responseRepos.ok) {
              console.log(`Fetch Error`);
              console.clear();
          } else {
              const githubRepos = await responseRepos.json();
              const github = await response.json();
              const {name,html_url,bio,blog,avatar_url,login,public_repos,repos_url,starred_url,followers,following} = github;

              githubRepos.map(repo => {
                const {name,html_url,created_at,owner,topics,license,updated_at,deployments_url,language,homepage,description} = repo;
                const filteredRepo = new Object(name,html_url,created_at,owner,topics,license,updated_at,deployments_url,language,homepage,description);
                repositories.push(filteredRepo);
              });
 
              const user = new Object(name,html_url,bio,repositories,blog,avatar_url,login,public_repos,repos_url,starred_url,followers,following);
              
              getDocs(collection(db, `githubUsers`)).then((snapshot) => {
                let updatedUsers = snapshot.docs.map(entry => {
                  return {...entry.data(), id: entry.id}
                });
                snapshot.docs.length > 0 && (
                  localStorage.setItem(`users`, JSON.stringify(updatedUsers))
                  );

                  // Get Users
                  let collectionID = `githubUsers`;
                  let projectID = `github-projects-81e89`;
                  console.log(`Form Values`, formValues);
                  console.log(`Github User Created`, user);
                  console.log(`Current Users`, updatedUsers);
                  $(`#users`).val(JSON.stringify(updatedUsers));
                  console.log(`PHP Local Storage`, <?php echo json_encode((string)LocalStorage::getInstance()) ?>);
                  let firestoreUsers = fetch(`https://firestore.googleapis.com/v1/projects/${projectID}/databases/(default)/documents/${collectionID}/`).then(res => res.json()).then(dbUsers => console.log(`firestoreUsers`, dbUsers)).catch(error => console.log(`REST API Error Fetching Data`, error));
                  
          
                  // If User Exists
                  if (updatedUsers.map(usr => usr?.login).includes(user?.login)) {
                    console.log(`User Exists`);
                    updateDoc(doc(db, `githubUsers`, updatedUsers.filter(usr => usr.login == user.login)[0].id.toString()), {
                      ...user,
                      id: updatedUsers.filter(usr => usr.login == user.login)[0].id.toString(),
                    }).then(updatedUser => {
                      console.log(`User Updated`, updatedUser);
                    }).catch(error => console.log(error));
                  } else {
                    updatedUsers.push(user);
                    localStorage.setItem(`users`, updatedUsers);
                    console.log(`Updated Users`, updatedUsers);
                    addDoc(collection(db, `githubUsers`), {...JSON.parse(localStorage.getItem(`user`))}).then(updatedUser => {
                      console.log(`User Added`, updatedUser);
                    }).catch(error => console.log(error));
                  }
                });
              
          };
      }

      // Get Data from Database
      window.addEventListener(`DOMContentLoaded`, event => {
          let url = <?php echo json_encode($page) ?>;
          console.log(`PHP Website`, url);
          init();
          $(`.php`).on(`submit`, event => {
            let formValues = $(`.php`).serializeObject();
            getGithubData(formValues);
            event.preventDefault();
          });
      });
</script>