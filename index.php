<?php include('header.php')?>
<div id="wrapper">
    <main class="mainSection">
        <form class="php" method="post" action="<?php echo $localPage ?>">
            <span class="formInner">
                <input type="hidden" name="user" id="user">
                <input type="text" name="username" id="username" placeholder="Github Username">
                <button name="submitForm" type="submit" class="submitButton">Submit</button>
            </span>
        </form>
    </main>
</div>
  <?php include('footer.php')?>
</body>
</html>