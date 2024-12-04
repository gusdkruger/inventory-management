<div id="toast" class="toast hide" style="width: 220px; position: fixed; top: 70px; left: 10px;" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <img class="me-1" src="./img/check-lg.svg" width="25px">
        <strong class="me-auto">Item updated</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>
<form class="mx-auto my-5" style="width: 90%; max-width: 400px;" hx-post="/editItem" hx-vals='{"id": "<?= $item["id"] ?>"}'>
    <h2 class="fs-4 mb-3">Edit item</h2>
    <div class="form-floating mb-2">
        <input class="form-control" id="input-name" placeholder="" value="<?= $item["name"] ?>" name="name" type="text">
        <label for="input-name">Name</label>
        <small class="form-text text-danger ms-2" id="name-feedback"></small>
    </div>
    <div class="form-floating mb-2">
        <input class="form-control" id="input-quantity" placeholder="" value="<?= $item["quantity"] ?>" name="quantity" type="number">
        <label for="input-quantity">Quantity</label>
        <small class="form-text text-danger ms-2" id="quantity-feedback"></small>
    </div>
    <div class="form-floating mb-2">
        <input class="form-control" id="input-location" placeholder="" value="<?= $item["location"] ?>" name="location" type="text">
        <label for="input-location">Location</label>
        <small class="form-text text-danger ms-2" id="location-feedback"></small>
    </div>
    <div class="form-floating mb-2">
        <input class="form-control" id="input-description" placeholder="" value="<?= $item["description"] ?>" name="description" type="text">
        <label for="input-description">Description</label>
        <small class="form-text text-danger ms-2" id="description-feedback"></small>
    </div>
    <button class="btn btn-primary mb-2 py-2 w-100" type="submit">Save item</button>
    <a class="d-block mx-auto p-2 link-underline link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" style="width: fit-content; cursor: pointer;" hx-post="/templateTable" hx-target="main">Go back</a>
</form>