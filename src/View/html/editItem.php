<form class="ajax-form itemForm" hx-post="/editItem" hx-vals='{"id": "<?= $item["id"] ?>"}' hx-target="#error-container" hx-ext="response-targets" hx-target-error="#error-container">
    <label for="input-name">Name</label>
    <input id="input-name" name="name" type="text" value="<?= $item["name"] ?>" minlength="1" maxlength="255" required>
    <label for="input-quantity">Quantity</label>
    <input id="input-quantity" name="quantity" type="number" value="<?= $item["quantity"] ?>" required>
    <label for="input-location">Location</label>
    <input id="input-location" name="location" type="text" value="<?= $item["location"] ?>" maxlength="255">
    <label for="input-description">Description</label>
    <input id="input-description" name="description" type="text" value="<?= $item["description"] ?>" maxlength="255">
    <button type="submit">Save</button>
    <div id="error-container"></div>
    <a class="ajax-nav" href="/">Go back</a>
</form>
