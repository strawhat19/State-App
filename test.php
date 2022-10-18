<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing</title>
</head>
<body>
<script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" defer></script>
<script type="module" id="getData" defer>
    let firestoreUsers = fetch("https://firestore.googleapis.com/v1/projects/github-projects-81e89/databases/(default)/documents/githubUsers/").then(res => res.json()).then(dbUsers => {
        console.log("firestoreUsers", dbUsers);
        dbUsers.documents.forEach(user => {
            let row = document.createElement("row");
            row.name = user?.fields?.login?.stringValue;
            row.innerHTML = user?.fields?.login?.stringValue;
            document.body.append(row);
        });
    }).catch(error => console.log("REST API Error Fetching Data", error));
</script>
</body>
</html>