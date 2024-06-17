<nav class="navbar-default navbar-static-side la" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?= ($LOGON_USER_NAME) ?><b class="caret"></b></strong>
                         </span></a>
                    <ul class="dropdown-menu m-t-xs">
                        <li><a href="<?= ($BASE) ?>/profile" style="color: black;">Edit Profile</a></li>
                        <li><a class="logout" href="javascript:void(0)">ອອກຈາກລະບົບ</a></li>
                    </ul>
                </div>
                <div class="logo-element"></div>
            </li>

            <li><a href="<?= ($BASE) ?>/"><img src="<?= ($BASE) ?>/uploads/logo.png" style="width: 80%;margin: 10px;"></a></li>

            <li class="<?= ($nav=='home' ? 'active' : '') ?>">
                <a href="<?= ($BASE) ?>/"><i class="fa fa-home"></i> <span class="nav-label">Dashboard</span>  </a>
            </li>

            <li class="<?= ($nav=='user' ? 'active' : '') ?> || <?= ($nav=='product' ? 'active' : '') ?> || <?= ($nav=='category' ? 'active' : '') ?> || <?= ($nav=='supplier' ? 'active' : '') ?>">
                <a href="#"><i class="fa fa-cog"></i> <span class="nav-label la">ຈັດການຂໍ້ມູນພື້ນຖານ</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="<?= ($nav=='user' ? 'active' : '') ?>">
                        <a href="<?= ($BASE) ?>/user"><i class="fa fa-wrench"></i> <span class="nav-label">ຈັດການຂໍ້ມຸນຜູ້ໃຊ້ລະບົບ</span>  </a>
                    </li>
                    <li class="<?= ($nav=='product' ? 'active' : '') ?>">
                        <a href="<?= ($BASE) ?>/product"><i class="fa fa-wrench"></i> <span class="nav-label">ຈັດການຂໍັ້ມູນສີນຄ້າ</span>  </a>
                    </li>
                    <li class="<?= ($nav=='category' ? 'active' : '') ?>">
                        <a href="<?= ($BASE) ?>/category"><i class="fa fa-wrench"></i> <span class="nav-label">ຈັດການຂໍັ້ມູນປະເພດສີນຄ້າ</span>  </a>
                    </li>
                    <li class="<?= ($nav=='supplier' ? 'active' : '') ?>">
                        <a href="<?= ($BASE) ?>/supplier"><i class="fa fa-wrench"></i> <span class="nav-label">ຈັດການຂໍັ້ມູນຜູ້ສະໜອງ</span>  </a>
                    </li>
                </ul>
            </li>
            <?php if ($LOGON_USER_ROLE == 'admin'): ?>
                
                    <li class="<?= ($nav=='order' ? 'active' : '') ?>">
                        <a href="<?= ($BASE) ?>/order/edit"><i class="fa fa-anchor"></i> <span class="nav-label">ສັໍ່ງຊື້ສີນຄ້າ</span>  </a>
                    </li>
                 
            <?php endif; ?>
            <?php if ($LOGON_USER_ROLE == 'admin' ||  $LOGON_USER_ROLE == 'emp_meter'): ?>
                
                     <li class="<?= ($nav=='import' ? 'active' : '') ?>">
                        <a href="<?= ($BASE) ?>/import/edit"><i class="fa fa-truck"></i> <span class="nav-label">ນໍາເຂົັ້າສີນຄ້າ</span>  </a>
                    </li>
                
            <?php endif; ?>
            <?php if ($LOGON_USER_ROLE == 'admin'): ?>
                
                    <li class="<?= ($nav=='sale' ? 'active' : '') ?>">
                        <a href="<?= ($BASE) ?>/sale/edit"><i class="fa fa-print"></i> <span class="nav-label">ຂາຍສີນຄ້າ</span>  </a>
                    </li>
                 
            <?php endif; ?>

            <li class="<?= ($nav=='report-product' ? 'active' : '') ?> || <?= ($nav=='report-member' ? 'active' : '') ?>">
                <a href="#"><i class="fa fa-bullhorn"></i> <span class="nav-label la">ການລາຍງານ</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="<?= ($subnav=='report-product' ? 'active' : '') ?> la"><a href="<?= ($BASE) ?>/report/product">👤 ລາຍງານສິນຄ້າໃນສາງ</a></li>
                    <li class="<?= ($subnav=='report-member' ? 'active' : '') ?> la"><a href="/demo/report-member">👥 ລາຍງານໝົດອາຍ</a></li>
                    <li class="<?= ($subnav=='report-invoice' ? 'active' : '') ?> la"><a href="/demo/report-invoice">💱  ລາຍງານການສັໍ່ງຊື້</a></li>
                    <li class="<?= ($subnav=='report-member' ? 'active' : '') ?> la"><a href="#">📪 ລາຍງານການຂາຍ</a></li>
                </ul>
            </li> 
            
        
        </ul>
    </div>
</nav>