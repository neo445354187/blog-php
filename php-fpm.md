# php-fpm

## 概念

### 1.什么是CGI？

最最最最先的网页，网站都只能是静态。随着发展的需要，处理动态的网站成为必要，此刻CGI(通用网关接口)登场，
CGI是用于处理webserver和浏览器进行交互的协议。可将html页面上的数据传递到php解释器，然后php解释器处理完成后将数据解析成html返回给浏览器。

### 2.什么是FAST-CGI？

CGI的改良版，CGI只能一个请求fork出一个worker，然后kill掉，再有请求再循环，这样很浪费资源，
FAST-CGI每次处理完请求后，不会kill掉这个进程，而是保留这个进程，使这个进程可以一次处理多个请求。
这样每次就不用重新fork一个进程了，大大提高了效率。

### 3.什么是PHP-FPM？

PHP-FPM即php-Fastcgi Process Manager，是 FastCGI 在php中的应用，专用于php进程管理。php-fpm进程管理流程图如下


### 4.php-fpm进程启动模式说明

pm = dynamic/static/ondemand  设置php-fpm进程启动模式

- dynamic 动态进程，常用模式，首先在fpm启动时按照`pm.start_servers`初始化一定数量的worker，
  运行期间如果master发现空闲worker数低于`pm.min_spare_servers`配置数(表示请求比较多，
  worker处理不过来了)则会fork worker进程，但总的worker数不能超过`pm.max_children`，
  如果master发现空闲worker数超过了`pm.max_spare_servers`(表示闲着的worker太多了)则会杀掉一些worker，避免占用过多资源，
  master通过这4个值来控制worker数

- static 这种方式比较简单，在启动时master按照`pm.max_children`配置fork出相应数量的worker进程，即worker进程数是固定不变的

- ondemand这种方式一般很少用，在启动时不分配worker进程，等到有请求了后再通知master进程fork worker进程，
  总的worker数不超过`pm.max_children`，处理完成后worker进程不会立即退出，当空闲时间超过`pm.process_idle_timeout`后再退出

## 配置
### 第一部分：FPM 配置
```
-p　: 命令行中动态修改--prefix 　

 ;include=etc/fpm.d/*.conf　　#用于包含一个或多个文件，如果glob(3)存在(glob()函数返回匹配指定模式的文件名或目录)
```

### 第二部分：全局配置
 由标志[global]开始：

```
;pid = run/php-fpm.pid　　　　　   设置pid文件的位置，默认目录路径 /usr/local/php/var
;error_log = log/php-fpm.log　　  记录错误日志的文件，默认目录路径 /usr/local/php/var
;syslog.facility = daemon　　　　  用于指定什么类型的程序日志消息。
;syslog.ident = php-fpm　　　　    用于FPM多实例甄别
;log_level = notice　　　　　　　   记录日志的等级，默认notice，可取值alert, error, warning, notice, debug
;emergency_restart_threshold = 0  如果子进程在这个时间段内带有IGSEGV或SIGBUS退出，则重启fpm，默认0表示关闭这个功能
;emergency_restart_interval = 0　 设置时间间隔来决定服务的初始化时间（默认单位：s秒），可选s秒，m分，h时，d天
;process_control_timeout = 0　　  子进程等待master进程对信号的回应（默认单位：s秒），可选s秒，m分，h时，d天
;process.max = 128　　　　　　　　  控制最大进程数，使用时需谨慎
;process.priority = -19　　　　　  处理nice(2)的进程优先级别-19(最高)到20(最低)
;rlimit_files = 1024　　　　　　　　设置主进程文件描述符rlimit的数量
;rlimit_core = 0　　　　　　　　　　 设置主进程rlimit最大核数
;events.mechanism = epoll　　　　　使用处理event事件的机制
　　; - select     (any POSIX os)
　　; - poll       (any POSIX os)
　　; - epoll      (linux >= 2.5.44)
　　; - kqueue     (FreeBSD >= 4.1, OpenBSD >= 2.9, NetBSD >= 2.0)
　　; - /dev/poll  (Solaris >= 7)
　　; - port       (Solaris >= 10)
;daemonize = yes　　　　　　　　　　 将fpm转至后台运行，如果设置为"no"，那么fpm会运行在前台
;systemd_interval = 10
复制代码
第三部分：进程池的定义
         通过监听不同的端口和不用管理选择可以定义多个不同的子进程池，进程池被用于记录和统计，对于fpm能够处理进程池数目的多少并没有限制

          其中$pool变量可以在任何指令中使用，他将会替代相应的进程池名字。例如：这里的[www]

   [root@test ～]# ps -ef | grep php-fpm
    root      3028     1  0 20:33 ?        00:00:00 php-fpm: master process (/usr/local/php/etc/php-fpm.conf)
    nobody    3029  3028  0 20:33 ?        00:00:00 php-fpm: pool www          
    nobody    3030  3028  0 20:33 ?        00:00:00 php-fpm: pool www
复制代码
[www]
; It only applies on the following directives:
; - 'access.log'
; - 'slowlog'
; - 'listen' (unixsocket)
; - 'chroot'
; - 'chdir'
; - 'php_values'
; - 'php_admin_values'

;prefix = /path/to/pools/$pool    如果没有制定，将使用全局prefix替代
user = nobody　　　　　　　　　　　　 进程的发起用户和用户组，用户user是必须设置，group不是
group = nobody
listen = 127.0.0.1:9000　　　　　　 监听ip和端口
;listen.backlog = 65535　　　　　　 设置listen(2)函数backlog
;listen.owner = nobody
;listen.group = nobody
;listen.mode = 0660
;listen.acl_users =
;listen.acl_groups =
;listen.allowed_clients = 127.0.0.1 允许FastCGI客户端连接的IPv4地址，多个地址用','分隔，为空则允许任何地址发来链接请求
; process.priority = -19
pm = dynamic　　　　　　　　　　　　　  选择进程池管理器如何控制子进程的数量
　　  static：　　                   对于子进程的开启数路给定一个锁定的值(pm.max_children)
　　  dynamic:　                    子进程的数目为动态的，它的数目基于下面的指令的值(以下为dynamic适用参数)
　　　　pm.max_children：            同一时刻能够存活的最大子进程的数量
　　　　pm.start_servers：           在启动时启动的子进程数量
　　　　pm.min_spare_servers：       处于空闲"idle"状态的最小子进程，如果空闲进程数量小于这个值，那么相应的子进程会被创建
　　　　pm.max_spare_servers：       最大空闲子进程数量，空闲子进程数量超过这个值，那么相应的子进程会被杀掉。
　　ondemand：                       在启动时不会创建，只有当发起请求链接时才会创建(pm.max_children, pm.process_idle_timeout)

pm.max_children = 5
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 3
;pm.process_idle_timeout = 10s;　　空闲进程超时时间
;pm.max_requests = 500　　　　　　　 在派生新的子进程前，每一个子进程应该处理的请求数目，在第三方库中解决内存溢出很有用，设置为0则不会限制
;pm.status_path = /status　　　     配置一个URI，以便查看fpm状态页

状态页描述：
　　accepted conn:                 该进程池接受的请求数量
　　pool:                          进程池的名字
　　process manager:               进程管理，就是配置中pm指令，可以选择值static，dynamic，ondemand
　　idle processes:                空闲进程数量
　　active processes:              当前活跃的进程数量
　　total processes:               总的进程数量=idle+active
　　max children reached:          达到最大子进程的次数，达到进程的限制，当pm试图开启更多的子进程的时候(仅当pm工作在dynamic时)
;ping.path = /ping　　　　          该ping URI将会去调用fpm监控页面，如果这个没有设置，那么不会有URI被做为ping页
;ping.response = pong　　          用于定制平请求的响应，响应的格式text/plain(对200响应代码)
;access.log = log/$pool.access.log
;access.format = "%R - %u %t \"%m %r%Q%q\" %s %f %{mili}d %{kilo}M %C%%"
　　; The following syntax is allowed
　　;  %%: the '%' character
　　;  %C: %CPU used by the request
　　;      it can accept the following format:
　　;      - %{user}C for user CPU only
　　;      - %{system}C for system CPU only
　　;      - %{total}C  for user + system CPU (default)
　　;  %d: time taken to serve the request
　　;      it can accept the following format:
　　;      - %{seconds}d (default)
　　;      - %{miliseconds}d
　　;      - %{mili}d
　　;      - %{microseconds}d
　　;      - %{micro}d
　　;  %e: an environment variable (same as $_ENV or $_SERVER)
　　;      it must be associated with embraces to specify the name of the env
　　;      variable. Some exemples:
　　;      - server specifics like: %{REQUEST_METHOD}e or %{SERVER_PROTOCOL}e
　　;      - HTTP headers like: %{HTTP_HOST}e or %{HTTP_USER_AGENT}e
　　;  %f: script filename
　　;  %l: content-length of the request (for POST request only)
　　;  %m: request method
　　;  %M: peak of memory allocated by PHP
　　;      it can accept the following format:
　　;      - %{bytes}M (default)
　　;      - %{kilobytes}M
　　;      - %{kilo}M
　　;      - %{megabytes}M
　　;      - %{mega}M
　　;  %n: pool name
　　;  %o: output header
　　;      it must be associated with embraces to specify the name of the header:
　　;      - %{Content-Type}o
　　;      - %{X-Powered-By}o
　　;      - %{Transfert-Encoding}o
　　;      - ....
　　;  %p: PID of the child that serviced the request
　　;  %P: PID of the parent of the child that serviced the request
　　;  %q: the query string
　　;  %Q: the '?' character if query string exists
　　;  %r: the request URI (without the query string, see %q and %Q)
　　;  %R: remote IP address
　　;  %s: status (response code)
　　;  %t: server time the request was received
　　;      it can accept a strftime(3) format:
　　;      %d/%b/%Y:%H:%M:%S %z (default)
　　;  %T: time the log has been written (the request has finished)
　　;      it can accept a strftime(3) format:
　　;      %d/%b/%Y:%H:%M:%S %z (default)
　　;  %u: remote user
;slowlog = log/$pool.log.slow　　 用于记录慢请求
;request_slowlog_timeout = 0　　  慢日志请求超时时间，对一个php程序进行跟踪。
;request_terminate_timeout = 0　　终止请求超时时间，在worker进程被杀掉之后，提供单个请求的超时间隔。由于某种原因不停止脚本执行时，应该使用该选项，0表示关闭不启用
　　(在php.ini中，max_execution_time 一般设置为30，表示每一个脚本的最大执行时间)
;rlimit_files = 1024　　　　　　　　设置打开文件描述符的限制
;rlimit_core = 0　　　　　　　　　　 设置内核对资源的使用限制，用于内核转储
;chroot =　　　　　　　　　　　　　　　设置chroot路径，程序一启动就将其chroot放置到指定的目录下，该指令值必须是一个绝对路径
;chdir = /var/www　　　　　　　　　　在程序启动时将会改变到指定的位置(这个是相对路径，相对当前路径或chroot后的“/”目录)　　　　
;catch_workers_output = yes　　　　将worker的标准输出和错误输出重定向到主要的错误日志记录中，如果没有设置，根据FastCGI的指定，将会被重定向到/dev/null上
;clear_env = no　　　　　　　　　　  清理环境
;security.limit_extensions = .php .php3 .php4 .php5　　限制FPM执行解析的扩展名
;env[HOSTNAME] = $HOSTNAME
;env[PATH] = /usr/local/bin:/usr/bin:/bin
;env[TMP] = /tmp
;env[TMPDIR] = /tmp
;env[TEMP] = /tmp

; Additional php.ini defines, specific to this pool of workers. These settings
; overwrite the values previously defined in the php.ini. The directives are the
; same as the PHP SAPI:
;   php_value/php_flag             - you can set classic ini defines which can
;                                    be overwritten from PHP call 'ini_set'.
;   php_admin_value/php_admin_flag - these directives won't be overwritten by
;                                     PHP call 'ini_set'
; For php_*flag, valid values are on, off, 1, 0, true, false, yes or no.

; Defining 'extension' will load the corresponding shared extension from
; extension_dir. Defining 'disable_functions' or 'disable_classes' will not
; overwrite previously defined php.ini values, but will append the new value
; instead.

;php_admin_value[sendmail_path] = /usr/sbin/sendmail -t -i -f www@my.domain.com
;php_flag[display_errors] = off
;php_admin_value[error_log] = /var/log/fpm-php.www.log
;php_admin_flag[log_errors] = on
;php_admin_value[memory_limit] = 32M
```


## 参考
- 参考：<https://blog.csdn.net/skykingf/article/details/51957298>
- 参考：<https://www.cnblogs.com/mzhaox/p/11215153.html>
- 参考：<https://www.jianshu.com/p/d49a094ce2ca>
- 参考：<http://hanc.cc/index.php/archives/179/?replyTo=209>
