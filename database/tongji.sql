/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50611
Source Host           : localhost:3306
Source Database       : tongji

Target Server Type    : MYSQL
Target Server Version : 50611
File Encoding         : 65001

Date: 2016-12-27 23:24:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `history`
-- ----------------------------
DROP TABLE IF EXISTS `history`;
CREATE TABLE `history` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `admin_username` varchar(20) NOT NULL COMMENT '用户名称',
  `op` varchar(50) NOT NULL DEFAULT '0' COMMENT '操作类型',
  `request` varchar(8000) NOT NULL COMMENT '请求内容',
  `response` varchar(500) NOT NULL DEFAULT '' COMMENT '响应内容',
  `time` datetime NOT NULL COMMENT '时间',
  `time_limit` int(32) NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`),
  KEY `admin_username` (`admin_username`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='操作记录表';

-- ----------------------------
-- Records of history
-- ----------------------------

-- ----------------------------
-- Table structure for `query_template`
-- ----------------------------
DROP TABLE IF EXISTS `query_template`;
CREATE TABLE `query_template` (
  `template_name` varchar(40) NOT NULL DEFAULT '' COMMENT '模板名称',
  `fields` varchar(1000) DEFAULT NULL,
  `querys` varchar(5000) DEFAULT NULL,
  `memo` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`template_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of query_template
-- ----------------------------
INSERT INTO `query_template` VALUES ('兑换码使用', '$1=兑换码', 'db=hldb2#query=select id,time,p1,p2,p3,memo from user_log where p3=\'$1\' and id =62 order by time desc;#desc=id,ID|time,时间|p1,玩家RID|p2,账号|p3,兑换码|memo,备注#title=user_log兑换码查询##db=hldb2#query=select id,time,p1,p2,p3,memo from bonus_log where p3=\'$1\' and id =62 order by time desc;#desc=id,ID|time,时间|p1,玩家RID|p2,账号|p3,兑换码|memo,备注#title=bonus_log兑换码查询', '这个没有办法判断出准确的使用区组#得一个个区组选择查过去');
INSERT INTO `query_template` VALUES ('冈布奥丢失情况', '$1=RID#$2=副本id', 'db=hldb2#query=select * from dungeon_log where id = 23 and p1 =\'$1\' and p2 = \'$2\' order by time DESC;#desc=id,ID|time,时间|p1,玩家RID|p2,迷宫id|p3,最高层|memo,备注#title=副本进出记录##db=hldb2#query=select * from pet_log where id = 25 and p1 =\'$1\' order by time DESC;#desc=id,ID|time,时间|p1,玩家RID|p2,宠物id|p3,当前数量|memo,备注#title=获得冈布奥记录', '冈布奥丢失模板#男巫pet_id 50 副本id 1#佐罗pet_id 51 副本id 2#铁血战士pet_id 52 副本id 3#黑暗龙pet_id 56 副本id 4#斯巴达pet_id 75 副本id 5#太阳花pet_id 74 副本id 6#王子pet_id 53 副本id 7#神灯pet_id 54 副本id 8#巫妖王pet_id 77 副本id 9#巫妖王pet_id 78 副本id 10#匹诺曹pet_id 84 副本id 1004#######');
INSERT INTO `query_template` VALUES ('复活查询', '$1=RID', 'db=hldb2#query=select * from attrib_log where id = 28 and p1=\"$1\" and memo like \'%revive%\'#desc=id,ID|time,时间|p1,玩家RID|p2,消耗数量|p3,当前量|memo,备注#title=attrib_log复活记录##db=hldb2#query=select * from gem_log where id = 28 and p1=\"$1\" and memo like \'%revive%\'#desc=id,ID|time,时间|p1,玩家RID|p2,消耗数量|p3,当前量|memo,备注#title=gem_log复活记录', '复活查询');
INSERT INTO `query_template` VALUES ('昵称查询', '$1=昵称', 'db=bsdb#query=select nickname,account from nickname_list where nickname like \'%$1%\';#desc=nickname,昵称|account,账号#title=昵称查询', '昵称查询，支持模糊查询#ps: 区组随便选个就可以了，全区组查询');
INSERT INTO `query_template` VALUES ('玩家登陆情况', '$1=RID#$2=查询时间', 'db=hldb1#query=select * from login_log where id in(6,7,8,119) and p1=\'$1\' and time > \'$2\' order by time DESC;#desc=id,ID|time,时间|p1,玩家RID|p2,|p3,|memo,备注#title=玩家登陆日志', '玩家登陆情况#1. 日志信息6 掉线 7离开游戏日志 8登录日志 119掉线#2  以这个查询时间(2016-10-13 07:22:41)之后#3. 这是条凑数的说明');
INSERT INTO `query_template` VALUES ('角色情况查询', '$1=账号', 'db=hddb#query=select rid,account,nickname,level,runtime_holder from user where account = \'$1\';#desc=rid,ID|account,账号|nickname,昵称|level,等级|runtime_holder,是否在线#title=rid查询角色信息##db=hadb#query=select account,sum(price) from charge where account = \'$1\';#desc=account,账号|sum(price),充值额#title=账号充值总额', '角色查询');
INSERT INTO `query_template` VALUES ('账号区组查询', '$1=账号', 'db=gdb#query=select account,dist_id from account_dist where account = \'$1\';#desc=account,账号|dist_id,区组ID#title=账号对应区组##db=gdb#query=select id,weight,server from server;#desc=id,ID|server,区组名|weight,区组权重#title=区组对照表', '输入账号#区组对照表，也一并给出#ps: 区组随便选个就可以了，全区组查询');
INSERT INTO `query_template` VALUES ('金钱获得消耗', '$1=RID#$2=金钱限制', 'db=hldb2#query=select * from money_log where  p2 >=$2 and id in (29,30) and p1=\"$1\" order by time desc;#desc=id,ID|time,时间|p1,玩家RID|p2,数量|p3,当前量|memo,备注#title=money_log金钱记录##db=hldb2#query=select * from attrib_log where  p2 >= $2 and id in (29,30) and p1=\"$1\" order by time desc;#desc=id,ID|time,时间|p1,玩家RID|p2,数量|p3,当前量|memo,备注#title=attrib_log金钱记录', '金钱获得消耗#金钱限制指的是少于这个数值的金钱日志不显示#money_log金钱记录，是新版的日志记录#attrib_log金钱记录，是旧版的日志记录');
INSERT INTO `query_template` VALUES ('限时礼包查询', '$1=RID', 'db=hldb2#query=select id,time,p1,p2,p3,memo from bonus_log where p1=\'$1\' and id in (48,49) order by time desc;#desc=id,ID|time,时间|p1,玩家RID|p2,商品id|p3,礼包id|memo,礼包奖励#title=限时礼包记录##db=hldb2#query=select id,time,p1,p2,p3,memo from user_log where p1=\'$1\' and id = 110 order by time desc;#desc=id,ID|time,时间|p1,玩家RID|p2,商品id|p3,礼包id|memo,礼包奖励#title=构造限时礼包记录', '48 完成限时礼包#49 领取限时礼包#110 构造限时礼包记录##\"5001\" => \"炼金坊の招牌\",#\"10001\" => \"小袋钻石\",#\"10002\" => \"大箱钻石\",#\"10005\" => \"超大箱钻石\",#\"10006\" => \"诸神の宝藏\",#\"10008\" => \"赤字の账单\",#\"10007\" => \"大袋钻石\",#\"5008\"  => \"亚空间魔蜥\"');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(20) NOT NULL COMMENT '用户名称',
  `salt` varchar(20) NOT NULL DEFAULT '123' COMMENT '密码加的盐',
  `password` varchar(100) NOT NULL COMMENT '用户密码',
  `priv` varchar(500) NOT NULL DEFAULT '' COMMENT '用户权限',
  `login_time` datetime NOT NULL COMMENT '登录时间',
  `login_ip` varchar(20) NOT NULL COMMENT '登陆IP',
  `realname` varchar(20) NOT NULL COMMENT '用户名称',
  `flag` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户角色对应表';

-- ----------------------------
-- Table structure for `charge_warn`
-- ----------------------------
DROP TABLE IF EXISTS `charge_warn`;
CREATE TABLE `charge_warn` (
  `account` VARCHAR(64) NOT NULL COMMENT '账号',
  `first_warn_times` int(10) DEFAULT 0 COMMENT '初级警告次数',
  `second_warn_times` int(10) DEFAULT 0 COMMENT '二次警告次数',
  `block_times` int(10) DEFAULT 0 COMMENT '账号封停次数',
  `last_warn_time` datetime NOT NULL COMMENT '最近一次警告时间',

  PRIMARY KEY (`account`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='玩家充值警告表';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', '123', '638b7e7442b886620ce75a2479968cb2', 'priv_gm_info,priv_gm_kick,priv_gm_block,priv_gm_activity,priv_gm_mail,priv_gm_order,priv_gm_bbs,priv_gm_card,priv_gm_gift,priv_gm_query,priv_gm_query_op,priv_user,push_setting', '2016-12-27 23:16:07', '10.2.49.223', '管理员', '1');
INSERT INTO `user` VALUES ('2', 'test1', '192202', 'c41e2362b91d61857785eb184685e9f6', 'priv_gm_info,priv_gm_activity,priv_gm_mail,priv_gm_order,priv_user', '2016-11-08 15:02:48', '10.2.49.223', 'test', '1');
INSERT INTO `user` VALUES ('3', 'test2', '157788', '4d2bc5a7e9748b60edf4feb75a3de49b', 'priv_gm_info,priv_gm_kick,priv_gm_block,priv_user', '2016-11-08 15:07:22', '10.2.49.223', 'test', '1');

-- ----------------------------
-- Table structure for `chat_keywords`
-- ----------------------------
DROP TABLE IF EXISTS `chat_keywords`;
CREATE TABLE `chat_keywords` (
  `keyword` varchar(40) NOT NULL DEFAULT '' COMMENT '关键字',
  PRIMARY KEY (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `batch_mail_accouts`
-- ----------------------------
DROP TABLE IF EXISTS `batch_mail_accouts`;
CREATE TABLE `batch_mail_accouts` (
  `account` VARCHAR(64) NOT NULL COMMENT '目标玩家账号',
  `times` int(11) NOT NULL COMMENT '重试次数',
  `mail_rid` VARCHAR(64) NOT NULL COMMENT '该封邮件的RID',
  PRIMARY KEY (`account`),
  KEY `mail_rid` (`mail_rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `batch_mail_info`
-- ----------------------------
DROP TABLE IF EXISTS `batch_mail_info`;
CREATE TABLE `batch_mail_info` (
  `id` int(11) NOT NULL COMMENT 'id',
  `account_num` VARCHAR(64) NOT NULL COMMENT '目标玩家总数',
  `body` VARCHAR(5000) NOT NULL COMMENT '邮件内容',
  `property` VARCHAR(5000) NOT NULL COMMENT '邮件奖励',
  `op` VARCHAR(64) NOT NULL COMMENT '发起批量操作的管理员账号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `log_field_desc`
-- ----------------------------
DROP TABLE IF EXISTS `log_field_desc`;
CREATE TABLE `log_field_desc` (
  `path` varchar(100) NOT NULL DEFAULT '' COMMENT '路径',
  `desc` varchar(300) NOT NULL DEFAULT '' COMMENT '解释',
  PRIMARY KEY (`path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `cheat_handle_history`
-- ----------------------------
DROP TABLE IF EXISTS `cheat_handle_history`;
CREATE TABLE `cheat_handle_history` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `admin_username` VARCHAR(20) NOT NULL COMMENT '管理员名称',
  `account` VARCHAR(64) NOT NULL COMMENT '玩家账号',
  `aaa_id` int(10) DEFAULT 0 COMMENT '玩家所在区组',
  `rid` VARCHAR(16) NOT NULL COMMENT '玩家RID',
  `nickname` VARCHAR(64) NOT NULL COMMENT '玩家角色名',
  `total_charge_amount` int(10) DEFAULT 0 COMMENT '玩家充值金额',
  `group_rid` VARCHAR(16) NOT NULL COMMENT '联盟RID',
  `target_time` VARCHAR(64) NOT NULL COMMENT '目标日期',
  `time` datetime NOT NULL COMMENT '处理时间',
  `type` VARCHAR(64) NOT NULL COMMENT '处理方式',
  `reason` VARCHAR(500) NOT NULL COMMENT '处理原因',
  PRIMARY KEY (`id`),
  KEY `target_time` (`target_time`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='玩家外挂使用处理情况表';

-- ----------------------------
-- Table structure for `local_mail_template`
-- ----------------------------
DROP TABLE IF EXISTS `local_mail_template`;
CREATE TABLE `local_mail_template` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL COMMENT '模板名称',
  `content` VARCHAR(50000) NOT NULL COMMENT '邮件内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='本地邮件模板';