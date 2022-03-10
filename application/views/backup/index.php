		 <?php cek_user()?>
		 <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><?php echo $title?></h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-5 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <h4>Menu ini berguna untuk mem back-up data keseluruhan dari aplikasi Point Of Sales yang berformat <b>.sql</b></h4><br>
                    <a href="<?php echo base_url('backup/backup')?>" class="btn btn-primary btn-block"><i class="fa fa-download"></i> Backup Data</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>