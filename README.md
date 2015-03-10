# log2redis
  为什么要写这个东西：

最开始主要是为了方便自己，由于开发人员没有访问生产环境的log文件，需要向我们来去相应的log，然后再反馈给开发人员，一来一去，非常麻烦。而且也十分浪费管理时间。

实现原理：

log2redis就是部署在各个服务器里的agent来实时抓取日志存入redis服务端，然后web服务端通过条件来搜索日志，目前web服务端支持历史日志查看和实时日志查看2种模式。实时日志查看模式可以把最新的日志实时的反馈给开发人员，使开发人员可以第一时间查看日志的更新，主要用于检测修复bug之后有没有在出现类似错误日志;历史日志查看模式，可让开发人员在输入的时间点内查看对应的日志，主要用于对历史错误信息的查看，方便修复bug。

一些主要文件结构简介：

log2redis 里面有2个文件夹，一个是server,一个是agent;server用于部署服务端,agent用于部署到各个服务器，来抓取日志。

在server端没什么东西，部署一个web服务端就ok了，然后在php里面把redis服务地址改下就行了。

在agent端只要有4个文件

[newqfc@qfc-pre-133v log2redis]$ ll
总计 16
-rwxr-xr-x 1 root root 871 03-06 08:42 app.pl
-rw-r--r-- 1 root root 210 03-06 08:42 config.ini
-rwxr-xr-x 1 root root 975 03-06 08:42 count_snap.pl
-rwxr-xr-x 1 root root 708 03-06 08:42 get_log.pl
congig.ini 文件是配置文件，用来配置redis服务器和要抓取工程的文件
app.pl 是个主程序文件
count_snap.pl: 时间计数快照程序,用来做时间点的快照
get_log.pl :抓取日志程序
