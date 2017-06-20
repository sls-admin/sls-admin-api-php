## 此项目是sls-admin项目的接口PHP版本，由于部分伙伴使用sls-admin时，不熟悉后台接口模式，所以在这里开源接口。

> 此接口基于thinkPHP5开发，如对代码有疑问请问thinkPHP官方文档。

### 数据库配置

数据库配置文件/application/database.php，把数据库信息改成你自己的。

创建数据库sls_admin,导入/databases/sls_admin.sql文件。

导入成功之后，用户表有一个默认账号：sailengsi/123456


### 七牛配置
配置文件在/application/config.php，改成你自己的accesskey和secretkey

七牛简单封装好的类在：/application/open/controller/Qiniu.php，在此类的构造函数中，bucket是代表七牛云空间名称，这里设置的是默认的，你改成自己的。

但是一般都是需要调用时自定义，在本套接口中，调用七牛类的地方在/application/sls_admin/controller/Open.php,在此类的构造函数中，可以发现，我在实例化Qiniu类时，传入了当前需要的bucket，而实例化下面有一个配置项root_path，此值是为了区分在多个项目都上传到同一个七牛空间时，不容易在七牛上区分哪些文件属于哪个项目，所以通过此值来做个区分，方便管理。



