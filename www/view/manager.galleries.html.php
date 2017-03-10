<?php require_once VIEW . 'layout.html.php' ?>
    <h3 class="alert text-center">Check your favorite galleries here.</h3>
    <div class="row">
        <table class="table table-hover table-striped table-condensed table-responsive">
            <thead>
            <tr class="alert alert-success text-center">
                <th>Gallery Title</th>
                <th>Gallery Photos</th>
                <th>Gallery Description</th>
                <th>Action</th>
                <!-- Trigger the create gallery modal with a button -->
                <th colspan="3">
                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal"
                            data-target="#creategalleryModal">Add gallery
                    </button>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($galleries)):
                foreach ($galleries as $gallery):
                    if (empty($gallery->id)) {
                        continue;
                    }
                    ?>
                    <tr>
                        <td><?= !empty($gallery->galleryTitle) ? $gallery->galleryTitle : '' ?></td>
                        <td>
                            <?php
                            if (!empty($galleryPhotos) && !empty($galleryPhotos[$gallery->id])):
                                foreach ($galleryPhotos[$gallery->id] as $photo):
                                    if (empty($photo->photoName)) {
                                        continue;
                                    }
                                    ?>
                                    <a href="#">
                                        <img data-toggle="modal" data-target="#showPhoto"
                                             src="<?= ROOT_URL . '/' . $photo->path . $photo->photoName ?>"
                                             class="img-rounded" alt="<?= $gallery->galleryDescription ?>"
                                             width="150"
                                             height="150">
                                    </a>
                                    <a href="/Galleries/deletePhoto/<?= $photo->id ?>" title="delete photo"><span
                                                title="delete photo" class="glyphicon glyphicon-remove-sign"></span></a>
                                    <!-- Display photo modal start-->
                                    <div class="modal fade" id="showPhoto" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                            </div>
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <img src="<?= ROOT_URL . '/' . $photo->path . $photo->photoName ?>"
                                                         class="img-rounded" alt="<?= $gallery->galleryDescription ?>"
                                                         width="800"
                                                         height="800">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>

                        <td><?= !empty($gallery->galleryDescription) ? $gallery->galleryDescription : '' ?></td>
                        <td>
                            <button type="button" class="btn btn-primary edit-gallery" data-id="<?= $gallery->id ?>"
                                    data-toggle="modal" data-target="#editgalleryModal" style="margin-bottom:5px;"> Edit Gallery
                            </button><br>
                            <button type="button" class="btn btn-primary upload-photo" data-id="<?= $gallery->id ?>"
                                    data-toggle="modal" data-target="#uploadPhotoModal" style="margin-bottom:5px;"> Upload Photo
                            </button><br>
                            <a class="btn btn-danger" href="/Galleries/deleteGallery/<?= $gallery->id ?>">Remove
                                Gallery</a>
                        </td>
                        <td></td>
                    </tr>
                    <!-- Edit the current gallery modal start-->
                    <div class="modal fade" id="editgalleryModal" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title well">Edit a gallery</h4>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="editGallery/<?= $gallery->id ?>">
                                        <input type="hidden" name="id" value="<?= $gallery->id ?>">
                                        <input type="hidden" name="userId" value="<?= $gallery->userId ?>">

                                        <div class="form-group">
                                            gallery Title:*<input name="galleryTitle" class="form-control"
                                                                  value="<?= $gallery->galleryTitle ?>" required>
                                        </div>
                                        <div class="form-group">
                                            gallery Description:*<textarea name="galleryDescription"
                                                                           class="form-control" required><?= $gallery->galleryDescription ?></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload photo modal start-->
                    <div class="modal fade" id="uploadPhotoModal" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title well">Upload a photo</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <form class="well" action="uploadPhoto" method="post"
                                                  enctype="multipart/form-data">
                                                <input type="hidden" name="id"
                                                       value="<?= (empty($photos)) ? 1 : ($photos[sizeof($photo) - 1]->id + 1); ?>">
                                                <input type="hidden" name="galleryId" value="<?= $gallery->id ?>">
                                                <input type="hidden" name="userId" value="<?= $gallery->userId ?>">
                                                <div class="form-group">
                                                    <label for="file">Select a file to upload</label>
                                                    <input type="file" name="file" required>
                                                    <p class="help-block">Only jpg,jpeg,png and gif file with maximum
                                                        size
                                                        of 1 MB
                                                        is allowed.</p>
                                                </div>
                                                <input type="submit" class="btn btn-lg btn-primary" value="Upload">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Edit the current gallery modal end-->
                <?php endforeach ?>
            <?php endif ?>
            </tbody>
        </table>
    </div>
    <!-- Create a new gallery modal start-->
    <div class="modal fade" id="creategalleryModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title well">New gallery</h4>
                </div>
                <div class="modal-body">
                    <!--<form method="POST" action="addGallery">-->
                    <form class="well" action="addGallery" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id"
                               value="<?= (empty($galleries)) ? 1 : ($galleries[sizeof($galleries) - 1]->id + 1); ?>">
                        <div class="form-group">
                            Gallery Title:*<input name="galleryTitle" class="form-control" required>
                        </div>
                        <div class="form-group">
                            Gallery Description:*<textarea name="galleryDescription" class="form-control" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add gallery</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php require_once VIEW . 'footer.html.php' ?>