<?php require_once VIEW . 'layout.html.php' ?>
    <h3 class="alert text-center">Check your favorite galleries here.</h3>
    <div class="row">
        <table class="table table-hover table-striped table-condensed table-responsive">
            <thead>
            <tr class="alert alert-success text-center">
                <th>Gallery Number</th>
                <th colspan="2">Gallery Photos</th>
                <th>Gallery Title</th>
                <th>Gallery Description</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $num = 1;
            if (!empty($galleries)):
            foreach ($galleries as $gallery):
                if (empty($gallery->id)){continue;}
                ?>
                <tr>
                    <td><?= $num ?></td>
                    <td colspan="2">
                        <?php
                        echo 'ppppppp';
                        var_dump($galleryPhotos);
                        if (!empty($galleryPhotos) && !empty($galleryPhotos[$gallery->id])):
                            echo '====';

                            foreach ($galleryPhotos[$gallery->id] as $photo):var_dump($photo);
                                if (empty($photo->photoName)){
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
                                <!-- Display photo modal start-->
                                <div class="modal fade" id="showPhoto" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img src="<?= ROOT_URL . '/' . $photo->path . $photo->photoName ?>"
                                                     class="img-rounded" alt="<?= $gallery->galleryDescription ?>" width="800"
                                                     height="800">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </td>
                    <td><?= !empty($gallery->galleryTitle) ? $gallery->galleryTitle : ''?></td>
                    <td><?= !empty($gallery->galleryDescription) ? $gallery->galleryDescription : '' ?></td>
                </tr>

                <?php $num++; ?>
            <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>

<?php require_once VIEW . 'footer.html.php' ?>