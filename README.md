docker 搭建lnmp环境
===
学习docker 自行搭建的lnmp环境，包括mysql8,redis,swoole,laravel与lumen项目配置等。

### 安装容器
> 拉取库：
```
git clone https://github.com/rangerdong/dnmp.git
```
> 进入 `dnmp` 目录内，运行容器:
```
docker-compose up -d {nginx mysql php72 reids}
```
> 进入容器内部: (更新代码或者执行对应命令)
```
docker-compose exec php72 /bin/bash 
```
### 目录结构
```
│  .gitignore
│  docker-compose.yml 
│  README.md
├─codes                    # 存放php代码
│  │  .gitignore
│  │  
│  ├─html                  # 默认web站点 (http://www.lnmp-docker.local)
│  │      curl.php         # curl本机, fix curl(7) connect refuse 错误
│  │      index.php        # phpinfo()
│  │      mysql.php        # 测试数据库连接
│  │
│  ├─laravel               # 默认laravel站点 (http://www.laravel.local)
│  │
│  ├─lumen                 # 默认lumen站点 (http://www.lumen.local)
│      
├─conf                     # 配置文件夹
│  ├─nginx
│  │  │  nginx.conf
│  │  │  
│  │  └─conf.d
│  │          .gitignore
│  │          default.conf
│  │          laravel.conf
│  │          lumen.conf
│  │          
│  └─php
│      │  php.ini
│      │  
│      └─php-fpm.d
│              www.conf
│              
├─images                    # 镜build文件夹
│  ├─mysql
│  │      Dockerfile
│  │      my.cnf
│  │      
│  └─php
│          Dockerfile
│          
├─log                       # 日志文件夹
│  ├─mysql
│  │      .gitignore
│  │      
│  ├─nginx
│  │      .gitignore
│  │      
│  ├─php
│  │      .gitignore
│  │      
│  └─php-fpm
│          .gitignore
│          
└─mysql                     # mysql数据存储文件夹
    │  .gitignore
            
```

### 运行默认项目

> 在本机 `host` 内加入

```
127.0.01  www.lnmp-docker.local
127.0.0.1 www.laravel.local
127.0.0.1 www.lumen.local
```

运行即可

### 使用swoole加速laravel项目
> 本php72镜像已经安装好swoole拓展与swoole服务

#### 下载[laravels package](https://github.com/hhxsv5/laravel-s) 
> 进入php72容器中，并进入到laravel/lumen项目路径中，此处以默认项目为例

```
docker-compose exec php72 /bin/bash
# cd /var/www/laravel or lumen
```
> 安装composer包
```
composer require "hhxsv5/laravel-s:~1.0" -vvv
```
##### 添加Service Provider。

- `Laravel`: 修改文件`config/app.php`
```PHP
'providers' => [
    //...
    Hhxsv5\LaravelS\Illuminate\LaravelSServiceProvider::class,
],
```

- `Lumen`: 修改文件`bootstrap/app.php`
```PHP
$app->register(Hhxsv5\LaravelS\Illuminate\LaravelSServiceProvider::class);
```

##### 发布配置文件。
> *每次升级LaravelS后，建议重新发布一次配置文件*
```Bash
php artisan laravels publish
```

`使用Lumen时的特别说明`: 你不需要手动加载配置`laravels.php`，LaravelS底层已自动加载。
```PHP
// 不必手动加载，但加载了也不会有问题
$app->configure('laravels');
```

##### 修改配置`config/laravels.php`：监听的IP、端口等，请参考[配置项](https://github.com/hhxsv5/laravel-s/blob/master/Settings-CN.md)。
> ### 注意

> 需要将 配置文件中的 LARAVELS_LISTEN_IP 设置为 fpm(即此容器名称) 不然nginx会报连接错误

#### Run Server
```
php artisan laravels {start|stop|restart|reload|publish}
```


>### Attention
> mysql:latest 拉取的最新8.0版本 所以my.cnf会有所不同，因此此项目的cnf文件是8.0的配置


