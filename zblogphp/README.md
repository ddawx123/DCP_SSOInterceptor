# DCP_SSOInterceptor For ZBlogPHP Introduction
DCP_SSOInterceptor ZBlogPHP登录接管/自动登录/原生登录拦截器

# 必要说明
SSOClient之前一直不想开源，因为代码实在忒乱了。然后对拦截器这块的开发又不怎么重视，就一直没去改动。。。好多都没加注释-_-||

所以如果下载源码后阅读时头昏脑胀，请联系我。。

# 文件列表
1. zbp_ssoutils.js ----- 登录状态同步组件（建议通过ZBP的C_HTML_JS_ADD和C_ADMIN_JS_ADD方法全局加载到ZBP的任意页面处）
2. dingstudio_sso.php ----- 核心库，实现SSO的首次认证检测和重定向逻辑
3. dingstudio_zbp_sso.php ----- 核心库，实现SSO认证成功后的回调以及同步登录物理操作过程
4. cmd.php ----- 这玩意儿ZBP自带的，不过我懒得写插件，直接在原先代码基础上加了一堆action
5. dingstudio_zbp_sso_regsiter.php ----- 新用户自动注册（此模块用于用户首次通过SSO登录ZBP时的账户数据自动导入注册逻辑过程）
6. dingstudio_sso_config.php ----- SSO配置文件，其实可以做数据库里。。不过当初由于历史遗留问题，采用了辣鸡的静态配置文件形式
