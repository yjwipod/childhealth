<?php /*a:6:{s:78:"C:\phpStudy\PHPTutorial\WWW\childHealth\application/index/view\user\index.html";i:1525598746;s:79:"C:\phpStudy\PHPTutorial\WWW\childHealth\application/index/view\layout\base.html";i:1522856436;s:80:"C:\phpStudy\PHPTutorial\WWW\childHealth\application/index/view\layout\toper.html";i:1525596458;s:81:"C:\phpStudy\PHPTutorial\WWW\childHealth\application/index/view\layout\header.html";i:1525597764;s:82:"C:\phpStudy\PHPTutorial\WWW\childHealth\application/index/view\user\rightmenu.html";i:1524241706;s:81:"C:\phpStudy\PHPTutorial\WWW\childHealth\application/index/view\layout\footer.html";i:1524074188;}*/ ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
<title><?php echo htmlentities($site_info['site_title']); ?></title>
<meta content="<?php echo htmlentities($site_info['site_keyword']); ?>" name="keywords"/>
<meta content="<?php echo htmlentities($site_info['site_description']); ?>" name="description"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp"/>
<link href="/assets/css/amazeui.css" rel="stylesheet"/>
<link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>
<!--<link href="/assets/css/base.css" rel="stylesheet">-->
<link href="/assets/css/style.css" rel="stylesheet"/>
<link rel="stylesheet" href="/assets/css/bootstrap.min.css"/>

    
<link href="/assets/css/user.css" rel="stylesheet">

</head>


<body>

<header class="navigation">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- header Nav Start -->
				<nav class="navbar">
					<div class="container-fluid">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							</button>
							<!--<a class="navbar-brand" href="<?php echo url('/'); ?>">
								<img src="assets/image/logo.png" alt="Logo">
							</a>-->
						</div>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav navbar-right">
								<li <?php if($action == 'index' && $controller != 'User'): ?> class="am-active" <?php endif; ?>
									><a  href="<?php echo url('/'); ?>">Home</a>
								</li>
								<li <?php if($action == 'introduction'): ?> class="am-active" <?php endif; ?>>
									<a href="<?php echo url('/introduction'); ?>" >FAQ</a>
								</li>
								<li <?php if($action == 'health'): ?> class="am-active" <?php endif; ?>>
									<a href="<?php echo htmlentities($site_info['health_url']); ?>" >Game</a>
								</li>
								<!--<li <?php if($action == 'reg'): ?> class="am-active" <?php endif; ?>>-->
								<li>	
									<a href="<?php echo htmlentities($site_info['reg_url']); ?>" >About Us</a>
								<!--</li>-->
								</li>


								<?php   if($user_id == 0){?>
								<li <?php if($action == 'reg'): ?> class="am-active" <?php endif; ?>>
									<a href="<?php echo htmlentities($site_info['reg_url']); ?>" >Sign up</a>
								</li>
								<li <?php if($action == 'login'): ?> class="am-active" <?php endif; ?>>
									<a href="<?php echo htmlentities($site_info['login_url']); ?>" >Login</a>
								</li>
								<?php }else{ ?>
								<li <?php if($action == 'index' && $controller == 'User'): ?> class="am-active" <?php endif; ?>>
								<a href="<?php echo url('/user/'.$user_id); ?>" target="new"  > Welcome <?php echo $user_info['user_name']; ?> </a></li>
								<li ><a href="<?php echo htmlentities($site_info['logout_url']); ?>"><i class="am-icon-sign-out am-icon-sm"></i> Log out</a> </li>
								<?php } ?>
							
							</ul>
							</div><!-- /.navbar-collapse -->
							</div><!-- /.container-fluid -->
						</nav>
					</div>
				</div>
			</div>
			</header><!-- header close -->



<div class="detail">
    <div class="am-g am-g-fixed">
        <div class="am-u-lg-9 br_tp_g am-padding-horizontal-xs">

            <div class="am-container am-padding-horizonta-sm br_bt br_lf br_rg">

                <div class="am-container am-padding-horizontal-0">
                    <ol class="am-breadcrumb br_bt am-margin-bottom-0">
                        <li><a href="#" class="">Health Center</a></li>
                        <li><a href="#" class="">Member manage</a></li>
                    </ol>
                </div>

                <div class="am-container am-padding-horizontal-sm am-padding-vertical-sm">
                    <div class="am-u-lg-2 am-list-thumb am-padding-horizontal-0">
                        <a href="#" class="">
                            <?php if($user_info['sex'] == 0): ?>
                                <img src="/assets/image/timg.jpg" class="am-img-responsive am-hide-sm-only" alt="">
                            <?php else: ?>
                                <img src="/assets/image/ftimg.jpg" class="am-img-responsive am-hide-sm-only" alt="">
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class=" am-u-lg-10 am-list-main ">
                        <h2 class="font_black no_bold br_bt am-padding-bottom-xs am-margin-bottom-0">User Name：<?php echo $user_info['user_name']; ?>
                            <span class="am-text-sm am-margin-left-sm" style="float: right;"><a href="<?php echo url('/logout'); ?>" class="font_orange">Logout</a></span>
                        </h2>
                        <ul class="am-avg-lg-2 am-avg-sm-2 am-padding-top-xs">
                            <li class="font_green am-padding-vertical-sm">Email：<a><?php echo $user_info['email']; ?></a></li>
                            <li class="font_green am-padding-vertical-sm">Sex：<a><?php if($user_info['sex'] == 0): ?>Boy<?php else: ?>Girl <?php endif; ?></a></li>
                            <li class="font_green am-padding-vertical-xs">Point：<a><?php echo $user_info['point']; ?></a></li>
                            <li class="font_green am-padding-vertical-xs">Last Login：<a><?php echo date("Y-m-d H:i:s",$user_info['login_time']);?></a></li>
                            <li class="font_green am-padding-vertical-xs">Current Leve：<?php if($level['level'] != 0): ?><img src="/assets/image/<?php echo $level['level']; ?>.png"><?php else: ?> -- <?php endif; ?></li>
                            <li class="font_green am-padding-vertical-xs">You need <?php echo $level['needpoints']; ?> points to next level：<img src="/assets/image/<?php echo $level['level']+1; ?>.png"></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="am-container am-padding-horizonta-sm br_bt br_lf br_rg br_tp_g am-margin-top" style="display: none;">
                <div data-am-widget="titlebar" class="am-titlebar am-titlebar-multi am-margin-top-0 br_bt am-no-layout">
                    <h1 class="am-titlebar-title" style="color:#0e90d2">My Trip
                    </h1>
                </div>
                <div class="am-container am-margin-top-sm">
                    <table class="am-table am-table-bordered am-table-striped">
                        <thead>
                        <tr class="am-primary">
                            <th class="am-text-center">Trip Date</th>
                            <th class="am-text-center">Trip Time</th>
                            <th class="am-text-center">Weather</th>
                            <th class="am-text-center">Park Name</th>
                            <th class="am-text-center">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if(count($list) == 0): ?>
                            <tr><td class="am-text-center" colspan="4">none</td></tr>
                            <?php else: if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                    <tr>
                                        <td class="am-text-center"><?php echo $vo['date']; ?></td>
                                        <td class="am-text-center"><?php echo $vo['startTime']; ?>-<?php echo $vo['endTime']; ?></td>
                                        <td class="am-text-center"><?php echo $vo['weather']; ?></td>
                                        <td class="am-text-center"><a href="<?php echo url('index/index/go_trip',['ky'=>$vo['parkName']]); ?>" target="_blank" ><?php echo $vo['parkName']; ?></a></td>
                                        <td class="am-text-center">
                                            <?php switch($vo['status']): case "'0'": ?><span style="color: indianred">In Progress</span><?php break; case "2": ?><span style="color: green">Finished</span><?php break; case "3": ?><span style="color: saddlebrown">Cancelled</span><?php break; endswitch; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>


        <div class="am-u-lg-3 am-padding-right-0">
            <div class="am-container br_lf br_rg br_bt br_tp_g am-text-center am-padding-sm">

    <h2 class="font_green am-margin-bottom-xs">Manage Control</h2>
    <p class="am-margin-vertical-xs"><a href="<?php echo url('/user/'.$user_id); ?>">Home </a></p>
    <?php if($user_id == 1): ?>
    <p class="am-margin-vertical-xs"><a href="<?php echo url('/index/user/foods'); ?>">Food </a></p>
    <?php endif; ?>
    <p class="am-margin-vertical-xs"><a href="<?php echo url('/index/user/point_logs/user_id/'.$user_id); ?>">Point Log </a></p>
    <p class="am-margin-vertical-xs"><a href="<?php echo url('/logout'); ?>">Log out</a></p>
</div>
        </div>
    </div>
</div>


<footer class="footer">
    <p>
        Copyright © Your Website 2018
    </p>
</footer>


<script type="text/javascript" src="https://cdn.bootcss.com/amazeui/2.7.2/js/amazeui.ie8polyfill.js"></script>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/layer/layer.js"></script>
<script type="text/javascript" src="/assets/js/action.js"></script>
<script type="text/javascript" src="/assets/js/common.js"></script>
<script type="text/javascript" src="https://cdn.bootcss.com/amazeui/2.7.2/js/amazeui.min.js"></script>
<script>
    var demo = {
        notice: function(){
            // alert($(this).data('src'));
            layer.open({
                type: 1
                ,title: false //不显示标题栏
                ,closeBtn: false
                ,area: '1200px;'
                ,shade: 0.8
                ,id: 'LAY_layuipro' //设定一个id，防止重复弹出
                ,resize: false
                ,content: '<img src="'+$(this).data('src')+'" width="100%">'
                ,btn: [ 'Close']
                ,btnAlign: 'c'
                ,moveType: 1 //拖拽模式，0或者1
                ,success: function(layero){
                    var btn = layero.find('.layui-layer-btn');

                }
            });
        }

    };

    $('.layui-btn').on('click', function(){
        var othis = $(this), method = othis.attr('method');
        var demo1 = $('#demo1'), p = demo1.find('p').eq(othis.index());
        demo[method] ? demo[method].call(this, othis) : new Function('that', p.html())(this);
    });
</script>

</body>


<script type="text/javascript">

</script>

</html>