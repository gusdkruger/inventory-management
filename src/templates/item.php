<tr>
    <th class="th1"><?= $item["userId"] ?></th>
    <th class="th2"><?= $item["name"] ?></th>
    <th class="th3"><?= $item["quantity"] ?></th>
    <th class="th4"><?= $item["location"] ?></th>
    <th class="th5"><?= $item["description"] ?></th>
    <th><button class="button1" hx-post="/templateEditItem" hx-vals='{"id": "<?= $item["id"] ?>"}' hx-target="main">Edit</button></th>
    <th><button class="button1" hx-post="/deleteItem" hx-vals='{"id": "<?= $item["id"] ?>"}'>Delete</button></th>
</tr>