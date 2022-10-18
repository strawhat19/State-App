$xml = new DOMDocument();
$xml->loadXml('
<record>
    <row>innerRow</row>
    <row>innerRow</row>
    <row>innerRow</row>
</record>
');

$xpath = new DomXpath($xml);
?>
<script>
    document.addEventListener(`DOMContentLoaded`, event => {

        function getElementByXpath(path) {
            return document.evaluate(path, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
        }

        // console.log( getElementByXpath("//html[1]/body[1]/div[1]") );

        let users = [{name: `name 1`, id: 1}, {name: `name 2`, id: 2}];
        users.forEach(user => {
            let row = document.createElement(`row`);
            row.classList.add(`row`);
            console.log(row);
            document.body.append(row);
        });
    });
   
</script>

<?php

// traverse all results
foreach ($xpath->query('//row') as $rowNode) {

    ?>
    <div style="padding: 3em;"><?php echo $rowNode->nodeValue; ?></div>
    <?php
}

// Or access the first result directly
$rowNode = $xpath->query('//row')->item(0);
if ($rowNode instanceof DomElement) {
    ?>
    <div style="padding: 3em;"><?php echo $rowNode->nodeValue; ?></div>
    <?php
}


foreach($firestoreUsers as $userIndex=>$user) {
    ?> 
        <div class="user"><?php echo $user->fields->login->stringValue; ?></div>
    <?php
}