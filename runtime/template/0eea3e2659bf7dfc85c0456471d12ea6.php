<?php /*a:5:{s:77:"C:\phpStudy\PHPTutorial\WWW\childHealth\application/index/view\index\reg.html";i:1525572096;s:79:"C:\phpStudy\PHPTutorial\WWW\childHealth\application/index/view\layout\base.html";i:1522856436;s:80:"C:\phpStudy\PHPTutorial\WWW\childHealth\application/index/view\layout\toper.html";i:1525596458;s:81:"C:\phpStudy\PHPTutorial\WWW\childHealth\application/index/view\layout\header.html";i:1525597764;s:81:"C:\phpStudy\PHPTutorial\WWW\childHealth\application/index/view\layout\footer.html";i:1524074188;}*/ ?>
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

    
<style>
    .form-box {
        width: 300px;
        margin: 0 auto;
        padding: 30px 0;
        padding-bottom: 120px;
    }

    .form-box .item {
        margin-top: 20px;
    }

    .form-box .item input {
        height: 40px;
        width: 100%;
        border: 1px solid #ccc;
        text-indent: 10px;
    }

    .mt-btn {
        display: inline-block;
        background: #ff5402;
        color: #fff;
        padding: 10px 20px;
    }

    .mt-btn:hover {
        color: #fff;
    }

    .mt-btn-block {
        display: block;
        text-align: center;
    }

    .img-code {
        vertical-align: middle;
        height: 41px;
    }

    #imgcode {
        width: 160px;
        top: 1px;
        right: -5px;
        position: relative;
    }
</style>

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
    <form action="chkLogin.html" id="reg_form" name="reg_form" method="POST">
        <div class="register">
            <div class="form-box">
                <h1 class="logo"> Register</h1>
                <!-- <div class="item">
                    <input id="email" type="text" placeholder="邮箱">
                </div> -->
                <div class="item">
                    <input id="account" name="account" type="text" placeholder="account">
                </div>
                <div class="item">
                    <input id="email" name="email" type="text" placeholder="email">
                </div>

                <div class="am-form-group" style="margin-top: 10px">

                    <label class="am-radio-inline">
                        <input type="radio" class="sex" name="sex" value="0" style="width:20px" checked="checked">Boy
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio"  class="sex" name="sex" value="1" style="width:20px">Girl
                    </label>
                </div>

                <div class="item">
                    <img id="avatar" src="/assets/image/timg.jpg" width="50px"/>
                </div>

                <div class="item">
                    <input id="password" name="password" type="password" placeholder="password">
                </div>
                <div class="item">
                    <input id="repassword" name="repassword" type="password" placeholder="comfirm_passwd">
                </div>

                <div class="item">
                    <img class="img-code captcha" src="<?php echo url('/index/index/verify'); ?>" alt="verify code" id="re_butid"
                         onclick="re_verify()"/>
                    <input id="imgcode" name="imgcode" type="text" placeholder="enter verify code">
                </div>
                <div class="item">
                    <a id="registerBtn" class="mt-btn mt-btn-block">Register</a>
                </div>
                <div class="item">
                    Had Account？ <a href="<?php echo url('/login'); ?>">GO Login</a>
                </div>
            </div>
        </div>
    </form>
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
    function re_verify() {
        $('.captcha').attr('src', "<?php echo url('/index/index/verify'); ?>&r=" + Math.random());
    }

    $(document).ready(function () {

        $("#registerBtn").click(function () {
            userRegister.saveInfo();
        });

    });
</script>
<script>
    $(function() {
        $('#doc-form-file').on('change', function() {
            var fileNames = '';
            $.each(this.files, function() {
                fileNames += '<span class="am-badge">' + this.name + '</span> ';
            });
            $('#file-list').html(fileNames);
        });
        $('.sex').click(function(){
            if( $("input[name='sex']:checked").val() == 0 ){
                $("#avatar").attr('src','/assets/image/timg.jpg');
            }else{
                $("#avatar").attr('src','/assets/image/ftimg.jpg');
            }
        });
    });
</script>

</html>