<?php require_once VIEW . 'layout.html.php' ?>
    <div class="row">
        <div class="col-lg-12">
            <form class="well" action="upload" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="file">Select a file to upload</label>
                    <input type="file" name="file">
                    <p class="help-block">Only jpg,jpeg,png and gif file with maximum size of 1 MB is allowed.</p>
                </div>
                <input type="submit" class="btn btn-lg btn-primary" value="Upload">
            </form>
        </div>
    </div>
<?php require_once VIEW . 'footer.html.php' ?>