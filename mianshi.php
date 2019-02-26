<?php
/*
	PHP面试题
	MySQL优化方法:
		1)选择合适的字段
		2)使用JOIN来代替子查询
		3)使用联合(UNION)来代替手动创建的临时表
		4)使用事物
		5)使用外键
		6)使用索引
		7)优化查询语句
	MySQL分库分表:
		1)纵向分类
		2)横向分类
	sql语言四大类:
		1)DDL-CREATE,DROP,ALTER
		2)DML-INSERT,UPDATE,DELETE
		3)DQL-SELECT
		4)DCL-GRANT,REVOKE,COMMIT,ROLLBACK
	PHP连接mysql的几种方式的区别
		1)mysql:面向过程
		2)mysqli:面向对象
		3)pdo:可移植性高
	面向对象:
		三大特征:继承,多态,封装
		抽象类:abstract,至少一个方法是抽象的,不能被实例化,为子类定义公共接口
		接口:解决PHP单继承问题所有方法都是public访问权限的抽象放法不能声明变量.只能声明常量,实现一个类同时实现多个接口
	memcached,redis,mongodb的区别
		3个场景完全不同的东西,
			memcached:单一键值对内存缓存的,作对象缓存无可替代的分布式缓存
			Redis:是算法和数据结构的集合,快速的数据结构是它最大的特点,支持数据持久化
			mongodb:是bson结构介于rdb和nosql之间,更松散灵活的,但是不支持事务,只用于非重要的数据储存

	基本知识点
		HTTP协议状态码
			200:请求成功,请求数据随之返回
			301:永久性重定向
			302:暂时性重定向
			401:当前请求需要用户验证
			403:服务器拒绝执行请求,即没有权限
			404:页面不存在
			500:服务器错误
			503:服务器临时维护或过载,这个状态是临时性的
		request inclued inclued_once request_once 的区别处理错误的方式不同
		request产生致命错误,程序停止运行
		inclued产生警告错误,程序继续运行
		request_once/inclued_once处理错误方式一样区别在于当所包含的文件代码已存在时候,不在包含
	PHP魔术方法
		__construct()实例化类时自动调用
		__destruct()类实力化结束时自动调用
		__set()在给未定义的属性赋值的时候调用
		__get()调用未定义属性时调用
		__isset()使用isset()或empty时调用
		__unset()使用unset()时候调用
		__sleep()使用serialize序列化时调用
		__call()调用不存在的方法时候条用
		__clone()当使用clone复制一个	对象时候调用
		

 */



echo '<pre>';
print_r($arr+$arr1);