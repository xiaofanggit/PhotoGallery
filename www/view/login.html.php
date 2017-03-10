<?php require_once VIEW . 'layout.html.php' ?>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h3 class="alert alert-success text-center">Welcome to the photo galleries site!<br>Please use
                xiaofang@gmail.com/12345 to try.
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/Users/Login">

                        <div class="form-group<?= !empty($errors['email']) ? ' has-error' : '' ?>">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email"
                                       value="<?= (!empty($user['email']) ? $user['email'] : ''); ?>" required
                                       autofocus>

                                <?php if (!empty($errors['email'])): ?>
                                    <span class="help-block">
                                        <strong><?= $errors['email']; ?></strong>
                                    </span>
                                <?php endif ?>
                            </div>
                        </div>

                        <div class="form-group<?= !empty($errors['password']) ? ' has-error' : '' ?>">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password"
                                       value="<?= (!empty($user['password']) ? $user['password'] : ''); ?>" required
                                       autofocus>

                                <?php if (!empty($errors['password'])): ?>
                                    <span class="help-block">
                                        <strong><?= $errors['password']; ?></strong>
                                    </span>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php require_once VIEW . 'footer.html.php' ?>