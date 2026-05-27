<div class="container bootstrap snippets bootdey">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading" style="padding-top:20px;">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-th"></span>
                        Change password
                    </h3>
                    <span class="glyphicon glyphicon-th"></span>
                    <a href="<?php echo SITE_URL ?>dashboard"><button type="submit" name="addAge" value="sfddsfs" class="btn btn-otline-primary"> Dashboard</button></a>

                </div>
                <div class="panel-body">
                    <form method="Post" class="form">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 separator social-login-box"> <br>
                                <img alt="" class="img-thumbnail" src="<?php echo $admin['profile']; ?>">
                            </div>
                            <div style="margin-top:80px;" class="col-xs-6 col-sm-6 col-md-6 login-box">
                                <div class="form-group">
                                    <div class="input-group-con">
                                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                                        <input class="form-control" type="password" name="oldpass" placeholder="Current Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group-con">
                                        <div class="input-group-addon"><span class="glyphicon glyphicon-log-in"></span></div>
                                        <input class="form-control" type="password" name="newPass" placeholder="New Password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group-con">
                                        <div class="input-group-addon"><span class="glyphicon glyphicon-log-in"></span></div>
                                        <div class="form-group">
                                            <input name="changePass" class="btn btn-sm btn-primary btn-block" value="Change Password" type="submit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>