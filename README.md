# laravel-shop

如果你觉得还可以的话，请Star , Fork给作者鼓励一下

## 说明
- 使用 Laravel 快速构建用户登录、注册功能；
- 使用 MailHog 调试邮件发送功能；
- 事件与监听器的使用；
- 使用授权策略来控制权限；
- 使用 overtrue/laravel-lang 来汉化错误信息；
- 使用 laravel-admin 快速构建对模型的增删改查功能；
- 使用 laravel-admin 配置后台用户角色、权限；
- 商品 SKU 的维度；
- 自定义 Laravel 验证器；
- 高并发下减商品库存的正确姿势；
- 使用预加载与延迟预加载解决数据库 N + 1 问题；


## 功能模块：
- 注册登录
- 邮箱激活
- 邮箱找回密码
- 商品管理
- 权限管理
- 购物车管理
- 订单管理
- 支付功能（支付宝）

## 后续添加的功能模块：
- 第三方授权登陆
- 评价商品
- 优惠券功能

## 导出mysql

```
mysqldump -t laravel-shop admin_menu admin_permissions admin_role_menu admin_role_permissions admin_role_users admin_roles admin_user_permissions admin_users > database/admin.sql
```

## 截图

![0](https://user-images.githubusercontent.com/324764/41385028-c1329666-6fab-11e8-8052-eb8d863cb766.png)


![1](https://user-images.githubusercontent.com/324764/41385029-c1a58dba-6fab-11e8-9c15-5cdf85f848b6.gif)


![2](https://user-images.githubusercontent.com/324764/41385030-c2034504-6fab-11e8-8b7a-04797afa6b28.png)


![3](https://user-images.githubusercontent.com/324764/41385031-c267b3ae-6fab-11e8-815c-5a027ca34318.png)


![5](https://user-images.githubusercontent.com/324764/41385032-c2c82de2-6fab-11e8-9aa6-0d88cc486dfe.png)


![6](https://user-images.githubusercontent.com/324764/41385033-c32a3140-6fab-11e8-8deb-fb23fe3ae8a6.png)


![7](https://user-images.githubusercontent.com/324764/41385034-c39c59c8-6fab-11e8-899a-5f042fa0bd1d.png)


## 环境需求

* Composer
* PHP >= 7.1.3
* OpenSSL PHP 扩展
* PDO PHP 扩展
* Mysql 5.7+

## 安装步骤

* git clone或者下载解压到本地
* composer install
* npm install
* 修改.env文件，关于邮件发送请参考官网文档配置（修改.env以及email.php）
* 启动mysql，创建数据库，执行 php artisan migrate:refresh
