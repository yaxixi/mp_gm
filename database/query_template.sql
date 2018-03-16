/*
Navicat MySQL Data Transfer

Source Server         : 雷霆_pp_cc从库
Source Server Version : 50632
Source Host           : 139.224.64.55:3306
Source Database       : gumballs_gbalisb111_webgm

Target Server Type    : MYSQL
Target Server Version : 50632
File Encoding         : 65001

Date: 2016-12-28 18:42:12
*/

SET FOREIGN_KEY_CHECKS=0;

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
