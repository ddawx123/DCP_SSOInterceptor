# DCP_SSOInterceptor For WordPress Introduction
DCP_SSOInterceptor WordPress登录接管/自动登录/原生登录拦截器

# 必要说明
SSOClient之前一直不想开源，因为代码实在忒乱了。然后对拦截器这块的开发又不怎么重视，就一直没去改动。。。好多都没加注释-_-||

所以如果下载源码后阅读时头昏脑胀，请联系我。。

# 文件列表
提供完整的插件和主题，主题使用Akina的修改版，并植入了Sweetalert实现通行证登录浮动层效果。实现开箱即用！

注意请修改部分JS文件中的SSO服务端域名为您自己的主域名，默认为passport.dingstudio.cn 。

需要修改的文件列表：
- wp-content/themes/Saebr/inc/js/dingstudio.app.js [该文件为SSO前端动作行为控制]

# 关于自动同步登录与退出
关于自动同步登录与退出，请参照zblogphp的zbp_ssoutils.js文件的实现过程，并将过程注入全局前端页面的初始化过程即可！此处不再重复撰述。
