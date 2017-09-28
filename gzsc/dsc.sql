/*
Navicat MySQL Data Transfer

Source Server         : link
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : dsc

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-08-11 11:02:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for address
-- ----------------------------
DROP TABLE IF EXISTS `address`;
CREATE TABLE `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `officer` varchar(50) DEFAULT NULL COMMENT '收货人',
  `address_phone` varchar(20) DEFAULT NULL,
  `default` int(4) DEFAULT '2' COMMENT '是否为默认地址  1默认  2不是默认',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of address
-- ----------------------------
INSERT INTO `address` VALUES ('42', '1', 'asdas', 'aaa', '110', '1');
INSERT INTO `address` VALUES ('43', '1', '季后赛的', '省电将好吧', '41545', '2');

-- ----------------------------
-- Table structure for adsserve
-- ----------------------------
DROP TABLE IF EXISTS `adsserve`;
CREATE TABLE `adsserve` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `cate_id` int(11) DEFAULT NULL,
  `adsserve_pic` varchar(255) DEFAULT NULL,
  `adsserve_http` varchar(255) DEFAULT NULL,
  `adsserve_address` varchar(255) DEFAULT NULL COMMENT '图片的位置 1header  2middle',
  `adsserve_descr` text,
  `adsserve_state` varchar(255) DEFAULT NULL COMMENT '图片的状态 1正常 2禁用',
  `end_time` datetime DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of adsserve
-- ----------------------------
INSERT INTO `adsserve` VALUES ('16', '6', '8', '2017-08-11/598d0c0a0aa50.jpg', '/gzsc/index.php/Home/Servedetail/secondhandcar?id=30', '2', 'aergfjhg', '1', '2017-08-18 09:45:16', '2017-08-11 09:45:16');
INSERT INTO `adsserve` VALUES ('12', '6', '5', '2017-08-10/598c669b32c80.jpg', '/gzsc/index.php/Home/Servedetail/weixiuserviceinfo?id=4', '2', '奇特', '1', '2017-08-17 21:58:51', '2017-08-10 21:58:51');
INSERT INTO `adsserve` VALUES ('10', '6', '8', '2017-08-10/598c663e84d00.jpg', '/gzsc/index.php/Home/Servedetail/secondhandcar?id=30', '1', '洞若观火', '1', '2017-08-04 21:57:18', '2017-08-10 21:57:18');
INSERT INTO `adsserve` VALUES ('13', '6', '3', '2017-08-10/598c66ba4a768.jpg', '/gzsc/index.php/Home/Servedetail/truckrendinfo?id=3', '2', '阿斯蒂芬', '2', '2017-08-17 21:59:22', '2017-08-10 21:59:22');
INSERT INTO `adsserve` VALUES ('14', '16', '3', '2017-08-10/598c66cda8750.jpg', '/gzsc/index.php/Home/Servedetail/truckrendinfo?id=4', '1', 'ASF ', '1', '2017-08-17 21:59:41', '2017-08-10 21:59:41');
INSERT INTO `adsserve` VALUES ('15', '6', '4', '2017-08-10/598c66fe0a410.jpg', '/gzsc/index.php/Home/Servedetail/inforserviceinfo?id=6', '2', '阿斯蒂芬', '1', '2017-08-17 22:00:30', '2017-08-10 22:00:30');

-- ----------------------------
-- Table structure for cate
-- ----------------------------
DROP TABLE IF EXISTS `cate`;
CREATE TABLE `cate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(255) DEFAULT NULL,
  `cate_pid` int(11) DEFAULT NULL,
  `cate_path` varchar(255) DEFAULT NULL,
  `cate_pic` varchar(255) DEFAULT NULL COMMENT '分类的图片',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cate
-- ----------------------------
INSERT INTO `cate` VALUES ('1', '服务', '0', '0', null);
INSERT INTO `cate` VALUES ('2', '房屋出租', '1', '0,1', '2017-08-08/59892bf700258.jpg');
INSERT INTO `cate` VALUES ('3', '货车出租', '1', '0,1', '2017-08-08/598977f595a88.jpg');
INSERT INTO `cate` VALUES ('4', '招聘信息', '1', '0,1', '2017-08-08/5989783f95a88.jpg');
INSERT INTO `cate` VALUES ('5', '维修服务', '1', '0,1', '2017-08-08/5989792ed6998.jpg');
INSERT INTO `cate` VALUES ('6', '家政服务', '1', '0,1', '2017-08-08/5989788183d60.jpg');
INSERT INTO `cate` VALUES ('7', '家具装修', '1', '0,1', '2017-08-08/59897a050b3b0.jpg');
INSERT INTO `cate` VALUES ('8', '二手车', '1', '0,1', '2017-08-08/59897a55d5610.jpg');
INSERT INTO `cate` VALUES ('9', '医疗', '1', '0,1', '2017-08-08/59897a9b084d0.jpg');
INSERT INTO `cate` VALUES ('10', '电商', '0', '0', '2017-08-08/59897f13f32a0.jpg');
INSERT INTO `cate` VALUES ('11', '家电', '10', '0,10', '2017-08-08/59897e0f591c8.jpg');
INSERT INTO `cate` VALUES ('12', '厨房电器', '11', '0,10,11', '2017-08-08/59897e2ba5488.jpg');
INSERT INTO `cate` VALUES ('13', '电视', '11', '0,10,11', '2017-08-08/59897e3f72420.jpg');
INSERT INTO `cate` VALUES ('14', '冰箱', '11', '0,10,11', '2017-08-08/59897e5cb9ca8.jpg');
INSERT INTO `cate` VALUES ('15', '空调', '11', '0,10,11', '2017-08-08/59897e7abbfd0.jpg');
INSERT INTO `cate` VALUES ('16', '手机数码', '11', '0,10,11', '2017-08-08/59897e9609858.jpg');
INSERT INTO `cate` VALUES ('17', '综合市场', '11', '0,10,11', '2017-08-08/59897eadb3718.jpg');
INSERT INTO `cate` VALUES ('18', '车', '10', '0,10', '2017-08-08/59897ec5d90a8.jpg');
INSERT INTO `cate` VALUES ('19', '4S店', '18', '0,10,18', '2017-08-08/59897ed743620.jpg');
INSERT INTO `cate` VALUES ('20', '汽车用品', '18', '0,10,18', null);
INSERT INTO `cate` VALUES ('21', '车品', '18', '0,10,18', '2017-08-08/598980c101388.jpg');
INSERT INTO `cate` VALUES ('22', '综合市场', '18', '0,10,18', '2017-08-08/598980d508ca0.jpg');
INSERT INTO `cate` VALUES ('23', '家居城', '10', '0,10', '2017-08-08/598980f18ed28.jpg');
INSERT INTO `cate` VALUES ('24', '建材卫浴', '23', '0,10,23', '2017-08-08/5989810842a68.png');
INSERT INTO `cate` VALUES ('25', '家具城', '23', '0,10,23', '2017-08-08/5989812157a58.jpg');
INSERT INTO `cate` VALUES ('26', '五金店', '23', '0,10,23', '2017-08-08/5989815aa9ec0.jpg');
INSERT INTO `cate` VALUES ('27', '综合市场', '23', '0,10,23', '2017-08-08/59898177d65b0.jpg');
INSERT INTO `cate` VALUES ('28', '超市', '10', '0,10', '2017-08-08/59898188347d8.jpg');
INSERT INTO `cate` VALUES ('29', '男装', '28', '0,10,28', '2017-08-08/598981ab0cb20.jpg');
INSERT INTO `cate` VALUES ('30', '女装', '28', '0,10,28', '2017-08-08/598981c2412f8.jpg');
INSERT INTO `cate` VALUES ('31', '鞋', '28', '0,10,28', '2017-08-08/5989844334bc0.jpg');
INSERT INTO `cate` VALUES ('32', '皮箱包', '28', '0,10,28', '2017-08-08/598984588aac0.jpg');
INSERT INTO `cate` VALUES ('33', '童装', '28', '0,10,28', '2017-08-08/5989847079950.jpg');
INSERT INTO `cate` VALUES ('34', '综合超市', '28', '0,10,28', '2017-08-08/5989849c1b580.jpg');
INSERT INTO `cate` VALUES ('35', '饮品', '10', '0,10', '2017-08-08/598984ad1b580.jpg');
INSERT INTO `cate` VALUES ('36', '奶粉', '35', '0,10,35', '2017-08-08/598984e27cc18.jpg');
INSERT INTO `cate` VALUES ('37', '饮料', '35', '0,10,35', '2017-08-08/598984f47ef40.jpg');
INSERT INTO `cate` VALUES ('38', '茶酒', '35', '0,10,35', '2017-08-08/5989850c9c018.jpg');
INSERT INTO `cate` VALUES ('39', '综合市场', '35', '0,10,35', '2017-08-08/59898526877f8.jpg');
INSERT INTO `cate` VALUES ('40', '纹饰', '10', '0,10', '2017-08-08/59898433e2ce8.jpg');
INSERT INTO `cate` VALUES ('41', '书店', '40', '0,10,40', '2017-08-09/598a723e0cf08.jpg');
INSERT INTO `cate` VALUES ('42', '电影', '40', '0,10,40', '2017-08-09/598a795226160.jpg');
INSERT INTO `cate` VALUES ('43', '首饰', '40', '0,10,40', '2017-08-09/598a7260612b0.jpg');
INSERT INTO `cate` VALUES ('44', '钟表', '40', '0,10,40', '2017-08-09/598a7969da818.jpg');
INSERT INTO `cate` VALUES ('45', '眼镜', '40', '0,10,40', '2017-08-09/598a72ebc1d90.jpg');
INSERT INTO `cate` VALUES ('46', '化妆品', '40', '0,10,40', '2017-08-09/598a730702328.jpg');
INSERT INTO `cate` VALUES ('47', '综合市场', '40', '0,10,40', '2017-08-09/598a73c2514c8.jpg');
INSERT INTO `cate` VALUES ('49', '玩具城', '10', '0,10', '2017-08-09/598a73f66d600.jpg');
INSERT INTO `cate` VALUES ('50', '动漫游戏机', '49', '0,10,49', '2017-08-09/598a73e0ddae0.jpg');
INSERT INTO `cate` VALUES ('51', '玩具', '49', '0,10,49', '2017-08-09/598a741748ff8.jpg');
INSERT INTO `cate` VALUES ('52', '综合市场', '49', '0,10,49', '2017-08-09/598a76801ec30.jpg');
INSERT INTO `cate` VALUES ('53', '农产品', '10', '0,10', '2017-08-09/598a75e7acda0.jpg');
INSERT INTO `cate` VALUES ('54', '水果', '53', '0,10,53', '2017-08-09/598a75feab630.jpg');
INSERT INTO `cate` VALUES ('55', '蔬菜', '53', '0,10,53', '2017-08-09/598a7614af898.jpg');
INSERT INTO `cate` VALUES ('73', '肉类', '53', '0,10,53', '2017-08-09/598a77b091050.jpg');
INSERT INTO `cate` VALUES ('57', '鱼类', '53', '0,10,53', '2017-08-09/598a7625d5610.jpg');
INSERT INTO `cate` VALUES ('58', '牲畜', '53', '0,10,53', '2017-08-09/598a7667d36d0.jpg');
INSERT INTO `cate` VALUES ('59', '综合市场', '53', '0,10,53', '2017-08-09/598a769428488.jpg');
INSERT INTO `cate` VALUES ('60', '酒店美食', '10', '0,10', '2017-08-09/598a7785eadd0.jpg');
INSERT INTO `cate` VALUES ('61', '酒店宾馆', '60', '0,10,60', '2017-08-09/598a77c2c5ff8.jpg');
INSERT INTO `cate` VALUES ('62', 'KTV酒吧', '60', '0,10,60', '2017-08-09/598a782320788.jpg');
INSERT INTO `cate` VALUES ('63', '美食', '60', '0,10,60', '2017-08-09/598a787b6d9e8.jpg');
INSERT INTO `cate` VALUES ('64', '综合', '60', '0,10,60', '2017-08-09/598a78f2a8f20.jpg');

-- ----------------------------
-- Table structure for collectgood
-- ----------------------------
DROP TABLE IF EXISTS `collectgood`;
CREATE TABLE `collectgood` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `good_attr_id` int(11) DEFAULT NULL COMMENT '商品id',
  `add_time` datetime DEFAULT NULL COMMENT '收藏时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of collectgood
-- ----------------------------
INSERT INTO `collectgood` VALUES ('7', '9', '39', '2017-07-17 11:09:47');
INSERT INTO `collectgood` VALUES ('8', '9', '40', '2017-07-17 11:10:28');
INSERT INTO `collectgood` VALUES ('9', '9', '42', '2017-07-17 11:10:33');

-- ----------------------------
-- Table structure for collectstore
-- ----------------------------
DROP TABLE IF EXISTS `collectstore`;
CREATE TABLE `collectstore` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of collectstore
-- ----------------------------

-- ----------------------------
-- Table structure for evaluate
-- ----------------------------
DROP TABLE IF EXISTS `evaluate`;
CREATE TABLE `evaluate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `good_attr_id` int(11) DEFAULT NULL,
  `good_id` int(11) DEFAULT NULL,
  `content` text,
  `evaluate_star` int(4) unsigned zerofill DEFAULT NULL COMMENT '评分 5五星',
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of evaluate
-- ----------------------------
INSERT INTO `evaluate` VALUES ('44', '6', '9', '39', '14', '你好', '0005', '2017-07-31 09:29:19');
INSERT INTO `evaluate` VALUES ('45', '6', '9', '39', '14', '你好', '0005', '2017-07-31 09:55:30');
INSERT INTO `evaluate` VALUES ('46', '6', '9', '39', '14', '你好', '0005', '2017-07-31 09:56:02');
INSERT INTO `evaluate` VALUES ('47', '6', '9', '39', '14', '你好', '0005', '2017-07-31 09:57:38');
INSERT INTO `evaluate` VALUES ('48', '6', '9', '39', '14', '你好', '0005', '2017-07-31 09:59:18');
INSERT INTO `evaluate` VALUES ('49', '6', '9', '39', '14', '你好', '0005', '2017-07-31 10:00:01');
INSERT INTO `evaluate` VALUES ('50', '6', '9', '39', '14', '你好', '0005', '2017-07-31 10:02:53');
INSERT INTO `evaluate` VALUES ('51', '6', '9', '39', '14', '你好', '0005', '2017-07-31 10:04:10');
INSERT INTO `evaluate` VALUES ('52', '6', '9', '39', '14', '你好', '0005', '2017-07-31 10:13:04');
INSERT INTO `evaluate` VALUES ('53', '6', '9', '39', '14', '你好', '0005', '2017-07-31 10:26:27');
INSERT INTO `evaluate` VALUES ('54', '6', '9', '39', '14', '你好', '0005', '2017-07-31 10:27:48');
INSERT INTO `evaluate` VALUES ('55', '6', '9', '39', '14', '你好', '0005', '2017-07-31 10:30:59');

-- ----------------------------
-- Table structure for evaluate_giveup
-- ----------------------------
DROP TABLE IF EXISTS `evaluate_giveup`;
CREATE TABLE `evaluate_giveup` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `evaluate_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of evaluate_giveup
-- ----------------------------
INSERT INTO `evaluate_giveup` VALUES ('1', '9', '24');
INSERT INTO `evaluate_giveup` VALUES ('2', '10', '24');

-- ----------------------------
-- Table structure for evaluate_pics
-- ----------------------------
DROP TABLE IF EXISTS `evaluate_pics`;
CREATE TABLE `evaluate_pics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `evaluate_id` int(11) DEFAULT NULL,
  `evaluate_pic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of evaluate_pics
-- ----------------------------
INSERT INTO `evaluate_pics` VALUES ('59', '44', 'http://192.168.31.125/gzsc/Public/upload/img/IMG_20170504_141819.jpg');
INSERT INTO `evaluate_pics` VALUES ('60', '44', 'http://192.168.31.125/gzsc/Public/upload/img/IMG_20170624_152936.jpg');
INSERT INTO `evaluate_pics` VALUES ('61', '44', 'http://192.168.31.125/gzsc/Public/upload/img/IMG_20170624_152936.jpg');
INSERT INTO `evaluate_pics` VALUES ('62', '44', 'http://192.168.31.125/gzsc/Public/upload/img/IMG_20170624_152936.jpg');
INSERT INTO `evaluate_pics` VALUES ('63', '54', 'http://192.168.31.125/gzsc/Public/upload/img/IMG_20170504_141819.jpg');
INSERT INTO `evaluate_pics` VALUES ('64', '54', 'http://192.168.31.125/gzsc/Public/upload/img/IMG_20170624_152936.jpg');
INSERT INTO `evaluate_pics` VALUES ('65', '54', 'http://192.168.31.125/gzsc/Public/upload/img/IMG_20170624_152936.jpg');
INSERT INTO `evaluate_pics` VALUES ('66', '54', 'http://192.168.31.125/gzsc/Public/upload/img/IMG_20170624_152936.jpg');
INSERT INTO `evaluate_pics` VALUES ('67', '55', 'http://192.168.31.125/gzsc/Public/upload/img/IMG_20170504_141819.jpg');
INSERT INTO `evaluate_pics` VALUES ('68', '55', 'http://192.168.31.125/gzsc/Public/upload/img/IMG_20170624_152936.jpg');
INSERT INTO `evaluate_pics` VALUES ('69', '55', 'http://192.168.31.125/gzsc/Public/upload/img/IMG_20170624_152936.jpg');
INSERT INTO `evaluate_pics` VALUES ('70', '55', 'http://192.168.31.125/gzsc/Public/upload/img/IMG_20170624_152936.jpg');

-- ----------------------------
-- Table structure for express_company
-- ----------------------------
DROP TABLE IF EXISTS `express_company`;
CREATE TABLE `express_company` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `name` text,
  `pic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=177 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of express_company
-- ----------------------------
INSERT INTO `express_company` VALUES ('2', 'aae', 'AAE', null);
INSERT INTO `express_company` VALUES ('3', 'anxindakuaixi', '安信达', null);
INSERT INTO `express_company` VALUES ('5', 'huitongkuaidi', '百世汇通', null);
INSERT INTO `express_company` VALUES ('6', 'baifudongfang', '百福东方', null);
INSERT INTO `express_company` VALUES ('7', 'bht', 'BHT', null);
INSERT INTO `express_company` VALUES ('8', 'youzhengguonei', '包裹/平邮/挂号信', null);
INSERT INTO `express_company` VALUES ('9', 'bangsongwuliu', '邦送物流', null);
INSERT INTO `express_company` VALUES ('11', 'cces', '希伊艾斯（CCES）', null);
INSERT INTO `express_company` VALUES ('12', 'coe', '中国东方（COE）', null);
INSERT INTO `express_company` VALUES ('13', 'chuanxiwuliu', '传喜物流', null);
INSERT INTO `express_company` VALUES ('14', 'canpost', '加拿大邮政Canada Post（英文结果）', null);
INSERT INTO `express_company` VALUES ('15', 'canpostfr', '加拿大邮政Canada Post(德文结果）', null);
INSERT INTO `express_company` VALUES ('17', 'datianwuliu', '大田物流', null);
INSERT INTO `express_company` VALUES ('18', 'debangwuliu', '德邦物流', null);
INSERT INTO `express_company` VALUES ('19', 'dpex', 'DPEX', null);
INSERT INTO `express_company` VALUES ('20', 'dhl', 'DHL-中国件-中文结果', null);
INSERT INTO `express_company` VALUES ('21', 'dhlen', 'DHL-国际件-英文结果', null);
INSERT INTO `express_company` VALUES ('22', 'dhlde', 'DHL-德国件-德文结果（德国国内派、收的件）', null);
INSERT INTO `express_company` VALUES ('23', 'dsukuaidi', 'D速快递', null);
INSERT INTO `express_company` VALUES ('24', 'disifang', '递四方', null);
INSERT INTO `express_company` VALUES ('26', 'ems', 'EMS(中文结果)', null);
INSERT INTO `express_company` VALUES ('28', 'ems', 'E邮宝', null);
INSERT INTO `express_company` VALUES ('30', 'emsen', 'EMS（英文结果）', null);
INSERT INTO `express_company` VALUES ('32', 'emsguoji', 'EMS-（中国-国际）', null);
INSERT INTO `express_company` VALUES ('34', 'emsinten', 'EMS-（中国-国际）', null);
INSERT INTO `express_company` VALUES ('37', 'fedex', 'Fedex-国际件-英文结果', null);
INSERT INTO `express_company` VALUES ('38', 'fedexcn', 'Fedex-国际件-中文结果', null);
INSERT INTO `express_company` VALUES ('39', 'fedexus', 'Fedex-美国件', null);
INSERT INTO `express_company` VALUES ('40', 'feikangda', '飞康达物流', null);
INSERT INTO `express_company` VALUES ('41', 'feikuaida', '飞快达', null);
INSERT INTO `express_company` VALUES ('42', 'rufengda', '凡客如风达', null);
INSERT INTO `express_company` VALUES ('43', 'fengxingtianxia', '风行天下', null);
INSERT INTO `express_company` VALUES ('44', 'feibaokuaidi', '飞豹快递', null);
INSERT INTO `express_company` VALUES ('46', 'ganzhongnengda', '港中能达', null);
INSERT INTO `express_company` VALUES ('47', 'guotongkuaidi', '国通快递', null);
INSERT INTO `express_company` VALUES ('48', 'guangdongyouzhengwuliu', '广东邮政', null);
INSERT INTO `express_company` VALUES ('49', 'youzhengguonei', '挂号信', null);
INSERT INTO `express_company` VALUES ('51', 'youzhengguonei', '国内邮件', null);
INSERT INTO `express_company` VALUES ('53', 'youzhengguoji', '国际邮件', null);
INSERT INTO `express_company` VALUES ('55', 'gls', 'GLS', null);
INSERT INTO `express_company` VALUES ('56', 'gongsuda', '共速达', null);
INSERT INTO `express_company` VALUES ('58', 'huitongkuaidi', '汇通快运', null);
INSERT INTO `express_company` VALUES ('59', 'huiqiangkuaidi', '汇强快递', null);
INSERT INTO `express_company` VALUES ('60', 'tiandihuayu', '华宇物流', null);
INSERT INTO `express_company` VALUES ('61', 'hengluwuliu', '恒路物流', null);
INSERT INTO `express_company` VALUES ('62', 'huaxialongwuliu', '华夏龙', null);
INSERT INTO `express_company` VALUES ('63', 'tiantian', '海航天天', null);
INSERT INTO `express_company` VALUES ('64', 'haiwaihuanqiu', '海外环球', null);
INSERT INTO `express_company` VALUES ('65', 'hebeijianhua', '河北建华', null);
INSERT INTO `express_company` VALUES ('66', 'haimengsudi', '海盟速递', null);
INSERT INTO `express_company` VALUES ('67', 'huaqikuaiyun', '华企快运', null);
INSERT INTO `express_company` VALUES ('68', 'haihongwangsong', '山东海红', null);
INSERT INTO `express_company` VALUES ('70', 'jiajiwuliu', '佳吉物流', null);
INSERT INTO `express_company` VALUES ('71', 'jiayiwuliu', '佳怡物流', null);
INSERT INTO `express_company` VALUES ('72', 'jiayunmeiwuliu', '加运美', null);
INSERT INTO `express_company` VALUES ('73', 'jinguangsudikuaijian', '京广速递', null);
INSERT INTO `express_company` VALUES ('74', 'jixianda', '急先达', null);
INSERT INTO `express_company` VALUES ('75', 'jinyuekuaidi', '晋越快递', null);
INSERT INTO `express_company` VALUES ('76', 'jietekuaidi', '捷特快递', null);
INSERT INTO `express_company` VALUES ('77', 'jindawuliu', '金大物流', null);
INSERT INTO `express_company` VALUES ('78', 'jialidatong', '嘉里大通', null);
INSERT INTO `express_company` VALUES ('80', 'kuaijiesudi', '快捷速递', null);
INSERT INTO `express_company` VALUES ('81', 'kangliwuliu', '康力物流', null);
INSERT INTO `express_company` VALUES ('82', 'kuayue', '跨越物流', null);
INSERT INTO `express_company` VALUES ('84', 'lianhaowuliu', '联昊通', null);
INSERT INTO `express_company` VALUES ('85', 'longbanwuliu', '龙邦物流', null);
INSERT INTO `express_company` VALUES ('86', 'lanbiaokuaidi', '蓝镖快递', null);
INSERT INTO `express_company` VALUES ('87', 'lejiedi', '乐捷递', null);
INSERT INTO `express_company` VALUES ('88', 'lianbangkuaidi', '联邦快递', null);
INSERT INTO `express_company` VALUES ('89', 'lianbangkuaidien', '联邦快递', null);
INSERT INTO `express_company` VALUES ('90', 'lijisong', '立即送', null);
INSERT INTO `express_company` VALUES ('91', 'longlangkuaidi', '隆浪快递', null);
INSERT INTO `express_company` VALUES ('93', 'menduimen', '门对门', null);
INSERT INTO `express_company` VALUES ('94', 'meiguokuaidi', '美国快递', null);
INSERT INTO `express_company` VALUES ('95', 'mingliangwuliu', '明亮物流', null);
INSERT INTO `express_company` VALUES ('97', 'ocs', 'OCS', null);
INSERT INTO `express_company` VALUES ('98', 'ontrac', 'onTrac', null);
INSERT INTO `express_company` VALUES ('100', 'quanchenkuaidi', '全晨快递', null);
INSERT INTO `express_company` VALUES ('101', 'quanjitong', '全际通', null);
INSERT INTO `express_company` VALUES ('102', 'quanritongkuaidi', '全日通', null);
INSERT INTO `express_company` VALUES ('103', 'quanyikuaidi', '全一快递', null);
INSERT INTO `express_company` VALUES ('104', 'quanfengkuaidi', '全峰快递', null);
INSERT INTO `express_company` VALUES ('105', 'sevendays', '七天连锁', null);
INSERT INTO `express_company` VALUES ('107', 'rufengda', '如风达快递', null);
INSERT INTO `express_company` VALUES ('109', 'shentong', '申通', null);
INSERT INTO `express_company` VALUES ('110', 'shunfeng', '顺丰', null);
INSERT INTO `express_company` VALUES ('111', 'shunfengen', '顺丰（英文结果）', null);
INSERT INTO `express_company` VALUES ('112', 'santaisudi', '三态速递', null);
INSERT INTO `express_company` VALUES ('113', 'shenghuiwuliu', '盛辉物流', null);
INSERT INTO `express_company` VALUES ('114', 'suer', '速尔物流', null);
INSERT INTO `express_company` VALUES ('115', 'shengfengwuliu', '盛丰物流', null);
INSERT INTO `express_company` VALUES ('116', 'shangda', '上大物流', null);
INSERT INTO `express_company` VALUES ('117', 'santaisudi', '三态速递', null);
INSERT INTO `express_company` VALUES ('118', 'haihongwangsong', '山东海红', null);
INSERT INTO `express_company` VALUES ('119', 'saiaodi', '赛澳递', null);
INSERT INTO `express_company` VALUES ('120', 'haihongwangsong', '山东海红', null);
INSERT INTO `express_company` VALUES ('121', 'sxhongmajia', '山西红马甲', null);
INSERT INTO `express_company` VALUES ('122', 'shenganwuliu', '圣安物流', null);
INSERT INTO `express_company` VALUES ('123', 'suijiawuliu', '穗佳物流', null);
INSERT INTO `express_company` VALUES ('125', 'tiandihuayu', '天地华宇', null);
INSERT INTO `express_company` VALUES ('126', 'tiantian', '天天快递', null);
INSERT INTO `express_company` VALUES ('127', 'tnt', 'TNT（中文结果）', null);
INSERT INTO `express_company` VALUES ('128', 'tnten', 'TNT（英文结果）', null);
INSERT INTO `express_company` VALUES ('129', 'tonghetianxia', '通和天下', null);
INSERT INTO `express_company` VALUES ('131', 'ups', 'UPS（中文结果）', null);
INSERT INTO `express_company` VALUES ('132', 'upsen', 'UPS（英文结果）', null);
INSERT INTO `express_company` VALUES ('133', 'youshuwuliu', '优速物流', null);
INSERT INTO `express_company` VALUES ('134', 'usps', 'USPS（中英文）', null);
INSERT INTO `express_company` VALUES ('136', 'wanjiawuliu', '万家物流', null);
INSERT INTO `express_company` VALUES ('137', 'wanxiangwuliu', '万象物流', null);
INSERT INTO `express_company` VALUES ('138', 'weitepai', '微特派', null);
INSERT INTO `express_company` VALUES ('140', 'xinbangwuliu', '新邦物流', null);
INSERT INTO `express_company` VALUES ('141', 'xinfengwuliu', '信丰物流', null);
INSERT INTO `express_company` VALUES ('142', 'xingchengjibian', '星晨急便', null);
INSERT INTO `express_company` VALUES ('143', 'xinhongyukuaidi', '鑫飞鸿', null);
INSERT INTO `express_company` VALUES ('144', 'cces', '希伊艾斯(CCES)', null);
INSERT INTO `express_company` VALUES ('145', 'xinbangwuliu', '新邦物流', null);
INSERT INTO `express_company` VALUES ('146', 'neweggozzo', '新蛋奥硕物流', null);
INSERT INTO `express_company` VALUES ('147', 'hkpost', '香港邮政', null);
INSERT INTO `express_company` VALUES ('149', 'yuantong', '圆通速递', null);
INSERT INTO `express_company` VALUES ('150', 'yunda', '韵达快运', null);
INSERT INTO `express_company` VALUES ('151', 'yuntongkuaidi', '运通快递', null);
INSERT INTO `express_company` VALUES ('152', 'youzhengguonei', '邮政小包（国内）', null);
INSERT INTO `express_company` VALUES ('153', 'youzhengguoji', '邮政小包（国际）', null);
INSERT INTO `express_company` VALUES ('154', 'yuanchengwuliu', '远成物流', null);
INSERT INTO `express_company` VALUES ('155', 'yafengsudi', '亚风速递', null);
INSERT INTO `express_company` VALUES ('156', 'yibangwuliu', '一邦速递', null);
INSERT INTO `express_company` VALUES ('157', 'youshuwuliu', '优速物流', null);
INSERT INTO `express_company` VALUES ('158', 'yuanweifeng', '源伟丰快递', null);
INSERT INTO `express_company` VALUES ('159', 'yuanzhijiecheng', '元智捷诚', null);
INSERT INTO `express_company` VALUES ('160', 'yuefengwuliu', '越丰物流', null);
INSERT INTO `express_company` VALUES ('161', 'yuananda', '源安达', null);
INSERT INTO `express_company` VALUES ('162', 'yuanfeihangwuliu', '原飞航', null);
INSERT INTO `express_company` VALUES ('163', 'zhongxinda', '忠信达快递', null);
INSERT INTO `express_company` VALUES ('164', 'zhimakaimen', '芝麻开门', null);
INSERT INTO `express_company` VALUES ('165', 'yinjiesudi', '银捷速递', null);
INSERT INTO `express_company` VALUES ('166', 'yitongfeihong', '一统飞鸿', null);
INSERT INTO `express_company` VALUES ('168', 'zhongtong', '中通速递', null);
INSERT INTO `express_company` VALUES ('169', 'zhaijisong', '宅急送', null);
INSERT INTO `express_company` VALUES ('170', 'zhongyouwuliu', '中邮物流', null);
INSERT INTO `express_company` VALUES ('171', 'zhongxinda', '忠信达', null);
INSERT INTO `express_company` VALUES ('172', 'zhongsukuaidi', '中速快件', null);
INSERT INTO `express_company` VALUES ('173', 'zhimakaimen', '芝麻开门', null);
INSERT INTO `express_company` VALUES ('174', 'zhengzhoujianhua', '郑州建华', null);
INSERT INTO `express_company` VALUES ('175', 'zhongtianwanyun', '中天万运', null);
INSERT INTO `express_company` VALUES ('176', 'auspost', '澳大利亚邮政', null);

-- ----------------------------
-- Table structure for file
-- ----------------------------
DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `good_id` int(11) DEFAULT NULL,
  `good_attr_id` int(11) DEFAULT NULL,
  `file_pic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of file
-- ----------------------------
INSERT INTO `file` VALUES ('84', '14', '39', '2017-07-27/597954cacf788.jpg');
INSERT INTO `file` VALUES ('85', '15', '40', '2017-07-12/5965956bb58b0.jpg');
INSERT INTO `file` VALUES ('86', '16', '41', '2017-07-12/5965968b964b0.jpg');
INSERT INTO `file` VALUES ('87', '14', '42', '2017-07-12/5965dc6dca328.jpg');
INSERT INTO `file` VALUES ('88', '14', '42', '2017-07-12/5965dc6dcc650.jpg');
INSERT INTO `file` VALUES ('89', '15', '43', '2017-07-12/5965e1726f608.jpg');
INSERT INTO `file` VALUES ('90', '15', '43', '2017-07-12/5965e17270990.jpg');
INSERT INTO `file` VALUES ('91', '17', '44', '2017-07-12/5965f40658ac0.jpg');
INSERT INTO `file` VALUES ('92', '17', '44', '2017-07-12/5965f40659e48.jpg');
INSERT INTO `file` VALUES ('93', '18', '45', '2017-07-12/59663b1b7a9b8.jpg');

-- ----------------------------
-- Table structure for good
-- ----------------------------
DROP TABLE IF EXISTS `good`;
CREATE TABLE `good` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `cate_id` int(11) DEFAULT NULL,
  `user_store_name` varchar(50) DEFAULT NULL,
  `good_name` varchar(50) DEFAULT NULL,
  `good_add_time` datetime DEFAULT NULL,
  `good_state` tinyint(4) DEFAULT '3' COMMENT '商品的状态   1下架 2新品上架    3正常',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of good
-- ----------------------------
INSERT INTO `good` VALUES ('14', '6', '15', 'shangdianyi', '格力空调1', '2017-07-12 11:04:58', '3');
INSERT INTO `good` VALUES ('15', '6', '15', 'shangdianyi', '美的空调1', '2017-07-12 11:18:50', '3');
INSERT INTO `good` VALUES ('16', '33', '15', 'shangdianshiyi', '格力空调十一11', '2017-07-12 11:23:41', '3');
INSERT INTO `good` VALUES ('17', '16', '15', 'shangdianer', '格力空调2', '2017-07-12 18:02:07', '3');
INSERT INTO `good` VALUES ('18', '6', '15', 'shangdianyi', '海尔一11', '2017-07-12 23:05:15', '1');

-- ----------------------------
-- Table structure for good_attr
-- ----------------------------
DROP TABLE IF EXISTS `good_attr`;
CREATE TABLE `good_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `good_id` int(11) DEFAULT NULL,
  `good_attr_color` varchar(50) DEFAULT NULL,
  `good_attr_size` varchar(50) DEFAULT NULL,
  `good_attr_num` int(11) DEFAULT NULL,
  `good_attr_des` varchar(255) DEFAULT NULL,
  `good_attr_price` decimal(10,2) DEFAULT NULL COMMENT '商品价格',
  `good_attr_price1` decimal(10,2) DEFAULT NULL COMMENT '商品原价',
  `good_attr_state` tinyint(4) DEFAULT '3' COMMENT ' 1下架   2新品上架   3正常',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of good_attr
-- ----------------------------
INSERT INTO `good_attr` VALUES ('41', '16', 'red', '12', '45', '省电十一11', '12.00', null, '3');
INSERT INTO `good_attr` VALUES ('42', '14', 'blue', '56', '534', '省电2', '125.00', '189.00', '2');
INSERT INTO `good_attr` VALUES ('40', '15', 'white', '1212', '12', '美1', '12.00', null, '3');
INSERT INTO `good_attr` VALUES ('39', '14', 'white', '12', '123', '省电1', '123.00', '156.00', '2');
INSERT INTO `good_attr` VALUES ('43', '15', 'white', '51', '8654', '美2', '125.00', null, '3');
INSERT INTO `good_attr` VALUES ('44', '17', 'white', '456', '45', '省电22', '45.00', null, '3');
INSERT INTO `good_attr` VALUES ('45', '18', 'blue', '456', '12', '海尔一1，大海', '456.00', null, '3');

-- ----------------------------
-- Table structure for home_decoration
-- ----------------------------
DROP TABLE IF EXISTS `home_decoration`;
CREATE TABLE `home_decoration` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `cate_id` int(11) DEFAULT NULL,
  `serve_cate` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pay_method` varchar(255) DEFAULT NULL,
  `des` text,
  `name` varchar(255) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `states` tinyint(4) DEFAULT '1' COMMENT '状态（1正常 2禁用）',
  `clicknum` int(11) DEFAULT '1' COMMENT '点击量',
  `valid_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of home_decoration
-- ----------------------------
INSERT INTO `home_decoration` VALUES ('10', '6', '7', '大众', '豫S1234A1', '01', '你好1', '亚龙21', '156388114569', '2017-08-02 15:21:29', '2', '2', '2017-08-07 00:00:00');
INSERT INTO `home_decoration` VALUES ('11', '16', '7', '大众', '豫S1234A', '0', '你好2', '亚龙3', '156388514569', '2017-08-02 15:21:34', '3', '1', '2017-08-14 14:13:09');
INSERT INTO `home_decoration` VALUES ('9', '16', '7', '大众', '豫S1234A1', '01', '你好3', '亚龙21', '156388114569', '2017-08-02 15:21:29', '2', '1', '2017-08-05 14:13:13');
INSERT INTO `home_decoration` VALUES ('8', '6', '7', '大众', '豫S1234A', '0', '你好4', '亚龙3', '156388514569', '2017-08-02 15:21:34', '2', '3', '2017-08-22 14:13:19');

-- ----------------------------
-- Table structure for home_decorationfile
-- ----------------------------
DROP TABLE IF EXISTS `home_decorationfile`;
CREATE TABLE `home_decorationfile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `home_decoration_id` int(11) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of home_decorationfile
-- ----------------------------
INSERT INTO `home_decorationfile` VALUES ('30', '10', '2017-08-02/598187c698580.jpg', '2017-08-02 00:00:00');
INSERT INTO `home_decorationfile` VALUES ('31', '10', '2017-08-02/598188d4c2560.jpg', '2017-08-02 00:00:00');
INSERT INTO `home_decorationfile` VALUES ('32', '10', '2017-08-02/598187e0d4e40.jpg', '2017-08-02 00:00:00');
INSERT INTO `home_decorationfile` VALUES ('27', '11', '2017-07-31/3f54a3aed1d7c2ed9a3b41da3c3d5735.jpg', '2017-08-02 15:21:34');
INSERT INTO `home_decorationfile` VALUES ('28', '11', '2017-07-31/4ed0bfd806ba867d22f05c218d6e08d9.jpg', '2017-08-02 15:21:34');

-- ----------------------------
-- Table structure for housekeeping
-- ----------------------------
DROP TABLE IF EXISTS `housekeeping`;
CREATE TABLE `housekeeping` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `cate_id` int(11) DEFAULT NULL,
  `serve_cate` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pay_method` varchar(255) DEFAULT NULL,
  `des` text,
  `name` varchar(50) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `states` tinyint(4) DEFAULT '1' COMMENT '状态（1正常 2禁用）',
  `clicknum` int(11) DEFAULT '1' COMMENT '点击量',
  `valid_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of housekeeping
-- ----------------------------
INSERT INTO `housekeeping` VALUES ('5', '16', '6', '大众', '豫S1234A', '0', '你好1', '亚龙3', '156388514569', '2017-08-02 16:12:49', '2', '2', '2017-08-08 14:27:23');
INSERT INTO `housekeeping` VALUES ('7', '6', '6', '大众', '豫S1234A1', '01', '你好2', '亚龙21', '1563885145691', '2017-08-02 16:12:46', '2', '2', '2017-08-15 00:00:00');
INSERT INTO `housekeeping` VALUES ('8', '6', '6', '大众', '豫S1234A', '0', '你好3', '亚龙3', '156388514569', '2017-08-02 16:12:49', '2', '3', '2017-08-15 14:27:33');
INSERT INTO `housekeeping` VALUES ('4', '9', '6', '大众', '豫S1234A', '0', '你好4', '亚龙3', '156388514569', '2017-08-02 16:12:49', '2', '1', '2017-08-08 14:33:22');

-- ----------------------------
-- Table structure for housekeepingfile
-- ----------------------------
DROP TABLE IF EXISTS `housekeepingfile`;
CREATE TABLE `housekeepingfile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `housekeeping_id` int(11) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of housekeepingfile
-- ----------------------------
INSERT INTO `housekeepingfile` VALUES ('14', '8', '2017-07-31/4ed0bfd806ba867d22f05c218d6e08d9.jpg', '2017-08-02 16:12:49');
INSERT INTO `housekeepingfile` VALUES ('16', '7', '2017-08-02/59818ef065ce8.jpg', '2017-08-02 00:00:00');
INSERT INTO `housekeepingfile` VALUES ('13', '8', '2017-07-31/3f54a3aed1d7c2ed9a3b41da3c3d5735.jpg', '2017-08-02 16:12:49');

-- ----------------------------
-- Table structure for house_for_rent
-- ----------------------------
DROP TABLE IF EXISTS `house_for_rent`;
CREATE TABLE `house_for_rent` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `cate_id` int(11) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `house_type` varchar(255) DEFAULT NULL,
  `cash` double(11,2) DEFAULT NULL COMMENT '押金',
  `pay_method` varchar(50) DEFAULT NULL COMMENT '付款方式',
  `des` text,
  `name` varchar(50) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `state` tinyint(4) DEFAULT NULL COMMENT '电话隐私保护（1 保护 2不保护）',
  `add_time` datetime DEFAULT NULL,
  `states` tinyint(4) DEFAULT '1' COMMENT '状态（1正常 2禁用）',
  `clicknum` int(11) DEFAULT '1' COMMENT '点击量',
  `valid_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of house_for_rent
-- ----------------------------
INSERT INTO `house_for_rent` VALUES ('7', '6', '2', '天津市天津市河东区', '三室一厅2', '13000.00', '0', '你好1', '亚龙21', '156388514561', '2', '2017-08-02 08:50:29', '2', '1', '0000-00-00 00:00:00');
INSERT INTO `house_for_rent` VALUES ('8', '9', '2', '河南', '三室一厅', '1000.00', '0', '你好', '亚龙1', '156388514569', '1', '2017-08-02 08:50:29', '2', '2', '2017-08-22 10:16:17');
INSERT INTO `house_for_rent` VALUES ('6', '16', '2', '河南', '两室一厅', '1000.00', '0', '你好', '亚龙3', '156388514569', '1', '2017-08-02 08:50:29', '2', '1', '2017-08-06 10:16:21');
INSERT INTO `house_for_rent` VALUES ('9', '6', '2', '河南', '两室一厅', '1000.00', '0', '你好', '亚龙', '156388514569', '1', '2017-08-02 11:56:23', '2', '1', '2017-08-21 10:16:26');
INSERT INTO `house_for_rent` VALUES ('10', '16', '2', '河南', '一室一厅', '1000.00', '0', '你好', '亚龙', '156388514569', '1', '2017-08-02 12:02:11', '2', '3', '2017-08-01 10:16:29');
INSERT INTO `house_for_rent` VALUES ('11', null, null, null, null, null, null, null, null, null, null, '2017-08-09 17:41:52', '1', '1', '2017-08-16 17:41:52');
INSERT INTO `house_for_rent` VALUES ('19', null, '2', '请选择', '123456', '123.00', '132', '13267', '1364', '13409362482', '1', '2017-08-09 23:29:27', '1', '1', '2017-08-16 23:29:27');
INSERT INTO `house_for_rent` VALUES ('13', null, null, null, null, null, null, null, null, null, null, '2017-08-09 17:42:02', '1', '1', '2017-08-16 17:42:02');
INSERT INTO `house_for_rent` VALUES ('14', null, null, null, null, null, null, null, null, null, null, '2017-08-09 17:42:32', '1', '1', '2017-08-16 17:42:32');
INSERT INTO `house_for_rent` VALUES ('15', null, null, null, null, null, null, null, null, null, null, '2017-08-09 17:42:33', '1', '1', '2017-08-16 17:42:33');
INSERT INTO `house_for_rent` VALUES ('16', null, null, null, null, null, null, null, null, null, null, '2017-08-09 17:42:35', '1', '1', '2017-08-16 17:42:35');
INSERT INTO `house_for_rent` VALUES ('17', null, '2', '广州', '123', '123.00', '很尴尬', '很尴尬', '455', '13409362482', '2', '2017-08-09 17:48:16', '1', '1', '2017-08-16 17:48:16');
INSERT INTO `house_for_rent` VALUES ('18', null, '2', '广州', '12', '1.00', '1', '1', '13409362482', '13409362482', '2', '2017-08-09 17:55:05', '1', '1', '2017-08-16 17:55:05');
INSERT INTO `house_for_rent` VALUES ('20', null, '8', null, null, null, null, 'DASDSADAS', 'SADAS', '13409362482', null, '2017-08-10 17:43:16', '1', '1', '2017-08-17 17:43:16');
INSERT INTO `house_for_rent` VALUES ('21', null, '8', null, null, null, null, 'DASDSADAS', 'SADAS', '13409362482', null, '2017-08-10 17:43:25', '1', '1', '2017-08-17 17:43:25');
INSERT INTO `house_for_rent` VALUES ('22', '1', '2', '江苏省常州市天宁区', 'asdas', '0.00', 'asdsa', 'asdsa', 'sadas', '13409362482', '1', '2017-08-11 08:19:38', '1', '1', '2017-08-18 08:19:38');

-- ----------------------------
-- Table structure for house_for_rentfile
-- ----------------------------
DROP TABLE IF EXISTS `house_for_rentfile`;
CREATE TABLE `house_for_rentfile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `house_for_rend_id` int(11) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of house_for_rentfile
-- ----------------------------
INSERT INTO `house_for_rentfile` VALUES ('25', '10', '2017-07-31/4ed0bfd806ba867d22f05c218d6e08d9.jpg', '2017-08-02 12:02:11');
INSERT INTO `house_for_rentfile` VALUES ('26', '18', '/storage/emulated/0/Pictures/Screenshots/S70808-18385456.jpg', '2017-08-09 17:55:05');
INSERT INTO `house_for_rentfile` VALUES ('27', '18', '/storage/emulated/0/Pictures/Screenshots/S70808-07510747.jpg', '2017-08-09 17:55:05');
INSERT INTO `house_for_rentfile` VALUES ('28', '18', '/storage/emulated/0/Pictures/Screenshots/S70807-23325655.jpg', '2017-08-09 17:55:05');
INSERT INTO `house_for_rentfile` VALUES ('29', '19', '/storage/emulated/0/Pictures/Screenshots/S70808-18385456.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('30', '19', '/storage/emulated/0/Pictures/Screenshots/S70808-07510747.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('31', '19', '/storage/emulated/0/Pictures/Screenshots/S70808-07515741.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('32', '19', '/storage/emulated/0/Pictures/Screenshots/S70807-23325655.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('33', '19', '/storage/emulated/0/Pictures/Screenshots/S70807-23290766.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('34', '19', '/storage/emulated/0/Pictures/Screenshots/S70807-20234991.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('35', '19', '/storage/emulated/0/Pictures/Screenshots/S70807-21351859.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('36', '19', '/storage/emulated/0/Pictures/Screenshots/S70807-20240246.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('24', '10', '2017-07-31/3f54a3aed1d7c2ed9a3b41da3c3d5735.jpg', '2017-08-02 12:02:11');
INSERT INTO `house_for_rentfile` VALUES ('21', '8', '2017-08-02/5981458d99840.jpg', '2017-08-02 00:00:00');
INSERT INTO `house_for_rentfile` VALUES ('22', '9', '2017-07-31/3f54a3aed1d7c2ed9a3b41da3c3d5735.jpg', '2017-08-02 11:56:23');
INSERT INTO `house_for_rentfile` VALUES ('23', '9', '2017-07-31/4ed0bfd806ba867d22f05c218d6e08d9.jpg', '2017-08-02 11:56:23');
INSERT INTO `house_for_rentfile` VALUES ('20', '8', '2017-08-02/598145a0b1710.jpg', '2017-08-02 00:00:00');
INSERT INTO `house_for_rentfile` VALUES ('37', '19', '/storage/emulated/0/Pictures/Screenshots/S70808-18385456.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('38', '19', '/storage/emulated/0/Pictures/Screenshots/S70808-07510747.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('39', '19', '/storage/emulated/0/Pictures/Screenshots/S70808-07515741.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('40', '19', '/storage/emulated/0/Pictures/Screenshots/S70807-23325655.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('41', '19', '/storage/emulated/0/Pictures/Screenshots/S70807-23290766.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('42', '19', '/storage/emulated/0/Pictures/Screenshots/S70807-20234991.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('43', '19', '/storage/emulated/0/Pictures/Screenshots/S70807-21351859.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('44', '19', '/storage/emulated/0/Pictures/Screenshots/S70807-20240246.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('45', '19', '/storage/emulated/0/Pictures/Screenshots/S70804-15243025.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('46', '19', '/storage/emulated/0/Pictures/Screenshots/S70804-18193318.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('47', '19', '/storage/emulated/0/Pictures/Screenshots/S70804-07494622.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('48', '19', '/storage/emulated/0/Pictures/Screenshots/S70803-20025157.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('49', '19', '/storage/emulated/0/Pictures/Screenshots/S70803-20341741.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('50', '19', '/storage/emulated/0/Pictures/Screenshots/S70804-07370168.jpg', '2017-08-09 23:29:27');
INSERT INTO `house_for_rentfile` VALUES ('51', '22', '2017-08-11/1502410777877956.jpg', '2017-08-11 08:19:38');

-- ----------------------------
-- Table structure for information
-- ----------------------------
DROP TABLE IF EXISTS `information`;
CREATE TABLE `information` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_des` text,
  `address` varchar(255) DEFAULT NULL,
  `seat` varchar(255) DEFAULT NULL,
  `job_req` text,
  `payment` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `states` int(4) DEFAULT '1' COMMENT '状态（1正常 2禁用）',
  `clicknum` int(11) DEFAULT '1' COMMENT '点击量',
  `valid_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of information
-- ----------------------------
INSERT INTO `information` VALUES ('1', '16', 'Alibab1', '待遇好1', '河南1', '程序员1', '技术好1', '40001', '小明21', '1563885145691', '2017-08-02 17:46:53', '2', '2', '2017-08-01 14:53:20');
INSERT INTO `information` VALUES ('2', '9', 'Alibab', '待遇好', '河南', '程序员2', '技术好', '4000', '小明3', '156388514569', '2017-08-02 17:46:55', '2', '1', '2017-08-16 14:53:23');
INSERT INTO `information` VALUES ('5', '6', 'Alibab1', '待遇好1', '河南1', '程序员13', '技术好1', '40001', '小明21', '1563885145691', '2017-08-02 17:46:53', '2', '2', '2017-08-15 14:53:27');
INSERT INTO `information` VALUES ('6', '6', 'Alibab', '待遇好', '河南', '程序员4', '技术好', '4000', '小明3', '156388514569', '2017-08-02 17:46:55', '2', '3', '2017-08-15 00:00:00');
INSERT INTO `information` VALUES ('7', null, null, null, null, null, null, null, '12312', '13409362482', '2017-08-10 17:39:53', '1', '1', '2017-08-17 17:39:53');
INSERT INTO `information` VALUES ('8', null, null, null, null, null, null, null, '12312', '13409362482', '2017-08-10 17:40:22', '1', '1', '2017-08-17 17:40:22');

-- ----------------------------
-- Table structure for informationfile
-- ----------------------------
DROP TABLE IF EXISTS `informationfile`;
CREATE TABLE `informationfile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `information_id` int(11) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of informationfile
-- ----------------------------
INSERT INTO `informationfile` VALUES ('20', '5', '2017-08-02/5981a68a635d8.jpg', '2017-08-02 00:00:00');
INSERT INTO `informationfile` VALUES ('17', '6', '2017-07-31/3f54a3aed1d7c2ed9a3b41da3c3d5735.jpg', '2017-08-02 17:46:55');
INSERT INTO `informationfile` VALUES ('18', '6', '2017-07-31/4ed0bfd806ba867d22f05c218d6e08d9.jpg', '2017-08-02 17:46:55');

-- ----------------------------
-- Table structure for medial_service
-- ----------------------------
DROP TABLE IF EXISTS `medial_service`;
CREATE TABLE `medial_service` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `cate_id` int(11) DEFAULT NULL,
  `serve_cate` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pay_method` varchar(255) DEFAULT NULL,
  `des` varchar(255) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `states` tinyint(4) DEFAULT '1' COMMENT '状态（1正常 2禁用）',
  `clicknum` int(11) DEFAULT '1' COMMENT '点击量',
  `valid_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of medial_service
-- ----------------------------
INSERT INTO `medial_service` VALUES ('4', '6', '9', null, '河南1', '02', '你好1', '亚龙11', '1563885145691', '2017-08-02 17:19:23', '2', '3', '2017-08-16 00:00:00');
INSERT INTO `medial_service` VALUES ('3', '6', '9', null, '河南', '0', '你好', '亚龙2', '156388514569', '2017-08-02 17:19:09', '2', '2', '2017-08-17 14:48:57');
INSERT INTO `medial_service` VALUES ('1', '16', '9', '', '河南', '0', '你好', '亚龙2', '156388514569', '2017-08-02 17:19:09', '2', '1', '2017-08-08 14:49:02');
INSERT INTO `medial_service` VALUES ('5', '6', '9', '', '河南', '0', '你好', '亚龙2', '156388514569', '2017-08-02 17:19:09', '2', '2', '2017-08-17 14:49:06');
INSERT INTO `medial_service` VALUES ('2', '9', '9', '', '河南', '0', '你好', '亚龙2', '156388514569', '2017-08-02 17:19:09', '2', '3', '2017-08-31 14:49:09');

-- ----------------------------
-- Table structure for medial_servicefile
-- ----------------------------
DROP TABLE IF EXISTS `medial_servicefile`;
CREATE TABLE `medial_servicefile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `medial_service_id` int(11) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of medial_servicefile
-- ----------------------------
INSERT INTO `medial_servicefile` VALUES ('5', '3', '2017-07-31/3f54a3aed1d7c2ed9a3b41da3c3d5735.jpg', '2017-08-02 17:19:09');
INSERT INTO `medial_servicefile` VALUES ('6', '3', '2017-07-31/4ed0bfd806ba867d22f05c218d6e08d9.jpg', '2017-08-02 17:19:09');
INSERT INTO `medial_servicefile` VALUES ('12', '4', '2017-08-02/59819e66e5010.jpg', '2017-08-02 00:00:00');

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_pic` varchar(255) DEFAULT NULL,
  `message_content` text,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of messages
-- ----------------------------

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `order_num` varchar(50) DEFAULT NULL,
  `order_grade` int(4) DEFAULT NULL COMMENT '订单的状态 1未支付 2已支付 3已发货 4已签收 5以评价',
  `order_total` decimal(10,2) DEFAULT NULL,
  `order_addtime` datetime DEFAULT NULL,
  `order_wuliucompany` varchar(255) DEFAULT NULL COMMENT '物流公司',
  `order_wuliunum` varchar(50) DEFAULT NULL COMMENT '物流单号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=405 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('114', '9', '1', '16', '15007117012874891', '2', '90.00', '0000-00-00 00:00:00', null, null);
INSERT INTO `order` VALUES ('118', '1', '42', '16', '15017434384936794', '1', '246.00', '0000-00-00 00:00:00', null, null);
INSERT INTO `order` VALUES ('119', '1', '42', '16', '15017434693820529', '1', '246.00', '0000-00-00 00:00:00', null, null);
INSERT INTO `order` VALUES ('120', '1', '42', '16', '15017434709267035', '1', '246.00', '0000-00-00 00:00:00', null, null);
INSERT INTO `order` VALUES ('121', '1', '42', '16', '15017434715132107', '1', '246.00', '0000-00-00 00:00:00', null, null);
INSERT INTO `order` VALUES ('122', '1', '42', '6', '15017434728255479', '1', '246.00', '0000-00-00 00:00:00', null, null);
INSERT INTO `order` VALUES ('123', '1', '42', '6', '15017434738439941', '3', '246.00', '0000-00-00 00:00:00', '圆通速递', '100747041553');
INSERT INTO `order` VALUES ('124', '1', '42', '6', '15017434741453179', '3', '246.00', '0000-00-00 00:00:00', '', '');
INSERT INTO `order` VALUES ('125', '1', '42', '6', '15017434758733452', '4', '246.00', '0000-00-00 00:00:00', '百世汇通', '1234561');
INSERT INTO `order` VALUES ('126', '1', '42', '6', '15017434775109591', '5', '246.00', '0000-00-00 00:00:00', '申通', '402523215812');
INSERT INTO `order` VALUES ('127', '1', '42', '6', '15017434781946071', '1', '246.00', '0000-00-00 00:00:00', null, '');
INSERT INTO `order` VALUES ('113', '9', '1', '16', '15007117012874891', '2', '90.00', '0000-00-00 00:00:00', '', '');

-- ----------------------------
-- Table structure for orderdetail
-- ----------------------------
DROP TABLE IF EXISTS `orderdetail`;
CREATE TABLE `orderdetail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `good_id` int(11) DEFAULT NULL,
  `good_attr_id` int(11) DEFAULT NULL,
  `good_num` int(11) DEFAULT NULL,
  `orderdetail_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=332 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orderdetail
-- ----------------------------
INSERT INTO `orderdetail` VALUES ('40', '113', '14', '39', '1', '2017-07-22 16:21:41');
INSERT INTO `orderdetail` VALUES ('38', '113', '14', '42', '1', '2017-07-22 16:21:41');
INSERT INTO `orderdetail` VALUES ('39', '114', '17', '44', '2', '2017-07-22 16:21:41');
INSERT INTO `orderdetail` VALUES ('45', '118', '14', '39', '2', '2017-08-03 14:57:18');
INSERT INTO `orderdetail` VALUES ('46', '119', '14', '39', '2', '2017-08-03 14:57:49');
INSERT INTO `orderdetail` VALUES ('47', '120', '14', '39', '2', '2017-08-03 14:57:50');
INSERT INTO `orderdetail` VALUES ('48', '121', '14', '39', '2', '2017-08-03 14:57:51');
INSERT INTO `orderdetail` VALUES ('49', '122', '14', '39', '2', '2017-08-03 14:57:52');
INSERT INTO `orderdetail` VALUES ('50', '123', '14', '39', '2', '2017-08-03 14:57:53');
INSERT INTO `orderdetail` VALUES ('51', '124', '14', '39', '2', '2017-08-03 14:57:54');
INSERT INTO `orderdetail` VALUES ('52', '125', '14', '39', '2', '2017-08-03 14:57:55');
INSERT INTO `orderdetail` VALUES ('53', '126', '14', '39', '2', '2017-08-03 14:57:57');
INSERT INTO `orderdetail` VALUES ('54', '127', '14', '39', '2', '2017-08-03 14:57:58');
INSERT INTO `orderdetail` VALUES ('55', '128', '14', '39', '2', '2017-08-03 14:57:59');
INSERT INTO `orderdetail` VALUES ('56', '129', '14', '39', '2', '2017-08-03 14:58:00');
INSERT INTO `orderdetail` VALUES ('57', '130', '14', '39', '2', '2017-08-03 14:58:01');
INSERT INTO `orderdetail` VALUES ('58', '131', '14', '39', '2', '2017-08-03 14:58:02');
INSERT INTO `orderdetail` VALUES ('59', '132', '14', '39', '2', '2017-08-03 14:58:03');
INSERT INTO `orderdetail` VALUES ('60', '133', '14', '39', '2', '2017-08-03 14:58:04');
INSERT INTO `orderdetail` VALUES ('61', '134', '14', '39', '2', '2017-08-03 14:58:05');
INSERT INTO `orderdetail` VALUES ('62', '135', '14', '39', '2', '2017-08-03 14:58:06');
INSERT INTO `orderdetail` VALUES ('63', '136', '14', '39', '2', '2017-08-03 14:58:07');
INSERT INTO `orderdetail` VALUES ('64', '137', '14', '39', '2', '2017-08-03 14:58:08');
INSERT INTO `orderdetail` VALUES ('65', '138', '14', '39', '2', '2017-08-03 14:59:07');
INSERT INTO `orderdetail` VALUES ('66', '139', '14', '39', '2', '2017-08-03 14:59:08');
INSERT INTO `orderdetail` VALUES ('67', '140', '14', '39', '2', '2017-08-03 14:59:09');
INSERT INTO `orderdetail` VALUES ('68', '141', '14', '39', '2', '2017-08-03 14:59:10');
INSERT INTO `orderdetail` VALUES ('69', '142', '14', '39', '2', '2017-08-03 14:59:11');
INSERT INTO `orderdetail` VALUES ('70', '143', '14', '39', '2', '2017-08-03 14:59:12');
INSERT INTO `orderdetail` VALUES ('71', '144', '14', '39', '2', '2017-08-03 14:59:13');
INSERT INTO `orderdetail` VALUES ('72', '145', '14', '39', '2', '2017-08-03 14:59:14');
INSERT INTO `orderdetail` VALUES ('73', '146', '14', '39', '2', '2017-08-03 14:59:15');
INSERT INTO `orderdetail` VALUES ('74', '147', '14', '39', '2', '2017-08-03 14:59:16');
INSERT INTO `orderdetail` VALUES ('75', '148', '14', '39', '2', '2017-08-03 14:59:17');
INSERT INTO `orderdetail` VALUES ('76', '149', '14', '39', '2', '2017-08-03 14:59:18');
INSERT INTO `orderdetail` VALUES ('77', '150', '14', '39', '2', '2017-08-03 14:59:19');
INSERT INTO `orderdetail` VALUES ('78', '151', '14', '39', '2', '2017-08-03 14:59:20');
INSERT INTO `orderdetail` VALUES ('79', '152', '14', '39', '2', '2017-08-03 14:59:21');
INSERT INTO `orderdetail` VALUES ('80', '153', '14', '39', '2', '2017-08-03 14:59:22');
INSERT INTO `orderdetail` VALUES ('81', '154', '14', '39', '2', '2017-08-03 14:59:23');
INSERT INTO `orderdetail` VALUES ('82', '155', '14', '39', '2', '2017-08-03 14:59:24');
INSERT INTO `orderdetail` VALUES ('83', '156', '14', '39', '2', '2017-08-03 14:59:25');
INSERT INTO `orderdetail` VALUES ('84', '157', '14', '39', '2', '2017-08-03 14:59:26');
INSERT INTO `orderdetail` VALUES ('85', '158', '14', '39', '2', '2017-08-03 14:59:28');
INSERT INTO `orderdetail` VALUES ('86', '159', '14', '39', '2', '2017-08-03 14:59:29');
INSERT INTO `orderdetail` VALUES ('87', '160', '14', '39', '2', '2017-08-03 14:59:30');
INSERT INTO `orderdetail` VALUES ('88', '161', '14', '39', '2', '2017-08-03 14:59:31');
INSERT INTO `orderdetail` VALUES ('89', '162', '14', '39', '2', '2017-08-03 14:59:32');
INSERT INTO `orderdetail` VALUES ('90', '163', '14', '39', '2', '2017-08-03 14:59:33');
INSERT INTO `orderdetail` VALUES ('91', '164', '14', '39', '2', '2017-08-03 14:59:34');
INSERT INTO `orderdetail` VALUES ('92', '165', '14', '39', '2', '2017-08-03 14:59:35');
INSERT INTO `orderdetail` VALUES ('93', '166', '14', '39', '2', '2017-08-03 14:59:36');
INSERT INTO `orderdetail` VALUES ('94', '167', '14', '39', '2', '2017-08-03 14:59:37');
INSERT INTO `orderdetail` VALUES ('95', '168', '14', '39', '2', '2017-08-03 14:59:38');
INSERT INTO `orderdetail` VALUES ('96', '169', '14', '39', '2', '2017-08-03 14:59:39');
INSERT INTO `orderdetail` VALUES ('97', '170', '14', '39', '2', '2017-08-03 14:59:40');
INSERT INTO `orderdetail` VALUES ('98', '171', '14', '39', '2', '2017-08-03 14:59:41');
INSERT INTO `orderdetail` VALUES ('99', '172', '14', '39', '2', '2017-08-03 14:59:42');
INSERT INTO `orderdetail` VALUES ('100', '173', '14', '39', '2', '2017-08-03 14:59:43');
INSERT INTO `orderdetail` VALUES ('101', '174', '14', '39', '2', '2017-08-03 14:59:44');
INSERT INTO `orderdetail` VALUES ('102', '175', '14', '39', '2', '2017-08-03 14:59:45');
INSERT INTO `orderdetail` VALUES ('103', '176', '14', '39', '2', '2017-08-03 14:59:46');
INSERT INTO `orderdetail` VALUES ('104', '177', '14', '39', '2', '2017-08-03 14:59:47');
INSERT INTO `orderdetail` VALUES ('105', '178', '14', '39', '2', '2017-08-03 14:59:49');
INSERT INTO `orderdetail` VALUES ('106', '179', '14', '39', '2', '2017-08-03 14:59:50');
INSERT INTO `orderdetail` VALUES ('107', '180', '14', '39', '2', '2017-08-03 14:59:51');
INSERT INTO `orderdetail` VALUES ('108', '181', '14', '39', '2', '2017-08-03 14:59:52');
INSERT INTO `orderdetail` VALUES ('109', '182', '14', '39', '2', '2017-08-03 14:59:53');
INSERT INTO `orderdetail` VALUES ('110', '183', '14', '39', '2', '2017-08-03 14:59:54');
INSERT INTO `orderdetail` VALUES ('111', '184', '14', '39', '2', '2017-08-03 14:59:55');
INSERT INTO `orderdetail` VALUES ('112', '185', '14', '39', '2', '2017-08-03 14:59:56');
INSERT INTO `orderdetail` VALUES ('113', '186', '14', '39', '2', '2017-08-03 14:59:57');
INSERT INTO `orderdetail` VALUES ('114', '187', '14', '39', '2', '2017-08-03 14:59:58');
INSERT INTO `orderdetail` VALUES ('115', '188', '17', '44', '2', '2017-08-03 15:01:49');
INSERT INTO `orderdetail` VALUES ('116', '189', '17', '44', '2', '2017-08-03 15:01:50');
INSERT INTO `orderdetail` VALUES ('117', '190', '17', '44', '2', '2017-08-03 15:01:51');
INSERT INTO `orderdetail` VALUES ('118', '191', '17', '44', '2', '2017-08-03 15:01:52');
INSERT INTO `orderdetail` VALUES ('119', '192', '17', '44', '2', '2017-08-03 15:01:53');
INSERT INTO `orderdetail` VALUES ('120', '193', '17', '44', '2', '2017-08-03 15:01:54');
INSERT INTO `orderdetail` VALUES ('121', '194', '17', '44', '2', '2017-08-03 15:01:55');
INSERT INTO `orderdetail` VALUES ('122', '195', '17', '44', '2', '2017-08-03 15:01:56');
INSERT INTO `orderdetail` VALUES ('123', '196', '17', '44', '2', '2017-08-03 15:01:57');
INSERT INTO `orderdetail` VALUES ('124', '197', '17', '44', '2', '2017-08-03 15:01:58');
INSERT INTO `orderdetail` VALUES ('125', '198', '17', '44', '2', '2017-08-03 15:01:59');
INSERT INTO `orderdetail` VALUES ('126', '199', '17', '44', '2', '2017-08-03 15:02:00');
INSERT INTO `orderdetail` VALUES ('127', '200', '17', '44', '2', '2017-08-03 15:02:01');
INSERT INTO `orderdetail` VALUES ('128', '201', '17', '44', '2', '2017-08-03 15:02:02');
INSERT INTO `orderdetail` VALUES ('129', '202', '17', '44', '2', '2017-08-03 15:02:03');
INSERT INTO `orderdetail` VALUES ('130', '203', '17', '44', '2', '2017-08-03 15:02:04');
INSERT INTO `orderdetail` VALUES ('131', '204', '17', '44', '2', '2017-08-03 15:02:05');
INSERT INTO `orderdetail` VALUES ('132', '205', '17', '44', '2', '2017-08-03 15:02:06');
INSERT INTO `orderdetail` VALUES ('133', '206', '17', '44', '2', '2017-08-03 15:02:07');
INSERT INTO `orderdetail` VALUES ('134', '207', '17', '44', '2', '2017-08-03 15:02:08');
INSERT INTO `orderdetail` VALUES ('135', '208', '17', '44', '2', '2017-08-03 15:02:09');
INSERT INTO `orderdetail` VALUES ('136', '209', '17', '44', '2', '2017-08-03 15:02:11');
INSERT INTO `orderdetail` VALUES ('137', '210', '17', '44', '2', '2017-08-03 15:02:12');
INSERT INTO `orderdetail` VALUES ('138', '211', '17', '44', '2', '2017-08-03 15:02:13');
INSERT INTO `orderdetail` VALUES ('139', '212', '17', '44', '2', '2017-08-03 15:02:14');
INSERT INTO `orderdetail` VALUES ('140', '213', '17', '44', '2', '2017-08-03 15:02:15');
INSERT INTO `orderdetail` VALUES ('141', '214', '17', '44', '2', '2017-08-03 15:02:16');
INSERT INTO `orderdetail` VALUES ('142', '215', '17', '44', '2', '2017-08-03 15:02:17');
INSERT INTO `orderdetail` VALUES ('143', '216', '17', '44', '2', '2017-08-03 15:02:18');
INSERT INTO `orderdetail` VALUES ('144', '217', '17', '44', '2', '2017-08-03 15:02:19');
INSERT INTO `orderdetail` VALUES ('145', '218', '17', '44', '2', '2017-08-03 15:02:20');
INSERT INTO `orderdetail` VALUES ('146', '219', '17', '44', '2', '2017-08-03 15:02:21');
INSERT INTO `orderdetail` VALUES ('147', '220', '17', '44', '2', '2017-08-03 15:02:22');
INSERT INTO `orderdetail` VALUES ('148', '221', '14', '39', '2', '2017-08-03 15:02:23');
INSERT INTO `orderdetail` VALUES ('149', '222', '17', '44', '2', '2017-08-03 15:02:23');
INSERT INTO `orderdetail` VALUES ('150', '223', '17', '44', '2', '2017-08-03 15:02:24');
INSERT INTO `orderdetail` VALUES ('151', '224', '17', '44', '2', '2017-08-03 15:02:25');
INSERT INTO `orderdetail` VALUES ('152', '225', '17', '44', '2', '2017-08-03 15:02:26');
INSERT INTO `orderdetail` VALUES ('153', '226', '17', '44', '2', '2017-08-03 15:02:27');
INSERT INTO `orderdetail` VALUES ('154', '227', '17', '44', '2', '2017-08-03 15:02:28');
INSERT INTO `orderdetail` VALUES ('155', '228', '17', '44', '2', '2017-08-03 15:02:30');
INSERT INTO `orderdetail` VALUES ('156', '229', '17', '44', '2', '2017-08-03 15:02:31');
INSERT INTO `orderdetail` VALUES ('157', '230', '17', '44', '2', '2017-08-03 15:02:32');
INSERT INTO `orderdetail` VALUES ('158', '231', '17', '44', '2', '2017-08-03 15:02:33');
INSERT INTO `orderdetail` VALUES ('159', '232', '17', '44', '2', '2017-08-03 15:02:34');
INSERT INTO `orderdetail` VALUES ('160', '233', '17', '44', '2', '2017-08-03 15:02:35');
INSERT INTO `orderdetail` VALUES ('161', '234', '17', '44', '2', '2017-08-03 15:02:36');
INSERT INTO `orderdetail` VALUES ('162', '235', '17', '44', '2', '2017-08-03 15:02:37');
INSERT INTO `orderdetail` VALUES ('163', '236', '17', '44', '2', '2017-08-03 15:02:38');
INSERT INTO `orderdetail` VALUES ('164', '237', '17', '44', '2', '2017-08-03 15:02:39');
INSERT INTO `orderdetail` VALUES ('165', '238', '17', '44', '2', '2017-08-03 15:02:40');
INSERT INTO `orderdetail` VALUES ('166', '239', '17', '44', '2', '2017-08-03 15:02:41');
INSERT INTO `orderdetail` VALUES ('167', '240', '17', '44', '2', '2017-08-03 15:02:42');
INSERT INTO `orderdetail` VALUES ('168', '241', '17', '44', '2', '2017-08-03 15:02:43');
INSERT INTO `orderdetail` VALUES ('169', '242', '17', '44', '2', '2017-08-03 15:02:44');
INSERT INTO `orderdetail` VALUES ('170', '243', '17', '44', '2', '2017-08-03 15:02:45');
INSERT INTO `orderdetail` VALUES ('171', '244', '17', '44', '2', '2017-08-03 15:02:46');
INSERT INTO `orderdetail` VALUES ('172', '245', '17', '44', '2', '2017-08-03 15:02:47');
INSERT INTO `orderdetail` VALUES ('173', '246', '17', '44', '2', '2017-08-03 15:02:48');
INSERT INTO `orderdetail` VALUES ('174', '247', '17', '44', '2', '2017-08-03 15:02:49');
INSERT INTO `orderdetail` VALUES ('175', '248', '17', '44', '2', '2017-08-03 15:02:50');
INSERT INTO `orderdetail` VALUES ('176', '249', '17', '44', '2', '2017-08-03 15:02:52');
INSERT INTO `orderdetail` VALUES ('177', '250', '17', '44', '2', '2017-08-03 15:02:53');
INSERT INTO `orderdetail` VALUES ('178', '251', '17', '44', '2', '2017-08-03 15:02:54');
INSERT INTO `orderdetail` VALUES ('179', '252', '17', '44', '2', '2017-08-03 15:02:55');
INSERT INTO `orderdetail` VALUES ('180', '253', '17', '44', '2', '2017-08-03 15:02:56');
INSERT INTO `orderdetail` VALUES ('181', '254', '17', '44', '2', '2017-08-03 15:02:57');
INSERT INTO `orderdetail` VALUES ('182', '255', '17', '44', '2', '2017-08-03 15:02:58');
INSERT INTO `orderdetail` VALUES ('183', '256', '17', '44', '2', '2017-08-03 15:02:59');
INSERT INTO `orderdetail` VALUES ('184', '257', '17', '44', '2', '2017-08-03 15:03:00');
INSERT INTO `orderdetail` VALUES ('185', '258', '17', '44', '2', '2017-08-03 15:03:01');
INSERT INTO `orderdetail` VALUES ('186', '259', '17', '44', '2', '2017-08-03 15:03:02');
INSERT INTO `orderdetail` VALUES ('187', '260', '17', '44', '2', '2017-08-03 15:03:03');
INSERT INTO `orderdetail` VALUES ('188', '261', '17', '44', '2', '2017-08-03 15:03:04');
INSERT INTO `orderdetail` VALUES ('189', '262', '17', '44', '2', '2017-08-03 15:03:05');
INSERT INTO `orderdetail` VALUES ('190', '263', '17', '44', '2', '2017-08-03 15:03:06');
INSERT INTO `orderdetail` VALUES ('191', '264', '17', '44', '2', '2017-08-03 15:03:07');
INSERT INTO `orderdetail` VALUES ('192', '265', '17', '44', '2', '2017-08-03 15:03:08');
INSERT INTO `orderdetail` VALUES ('193', '266', '17', '44', '2', '2017-08-03 15:03:09');
INSERT INTO `orderdetail` VALUES ('194', '267', '17', '44', '2', '2017-08-03 15:03:10');
INSERT INTO `orderdetail` VALUES ('195', '268', '17', '44', '2', '2017-08-03 15:03:11');
INSERT INTO `orderdetail` VALUES ('196', '269', '17', '44', '2', '2017-08-03 15:03:12');
INSERT INTO `orderdetail` VALUES ('197', '270', '17', '44', '2', '2017-08-03 15:03:14');
INSERT INTO `orderdetail` VALUES ('198', '271', '17', '44', '2', '2017-08-03 15:03:15');
INSERT INTO `orderdetail` VALUES ('199', '272', '17', '44', '2', '2017-08-03 15:03:16');
INSERT INTO `orderdetail` VALUES ('200', '273', '17', '44', '2', '2017-08-03 15:03:17');
INSERT INTO `orderdetail` VALUES ('201', '274', '17', '44', '2', '2017-08-03 15:03:18');
INSERT INTO `orderdetail` VALUES ('202', '275', '17', '44', '2', '2017-08-03 15:03:19');
INSERT INTO `orderdetail` VALUES ('203', '276', '17', '44', '2', '2017-08-03 15:03:20');
INSERT INTO `orderdetail` VALUES ('204', '277', '17', '44', '2', '2017-08-03 15:03:21');
INSERT INTO `orderdetail` VALUES ('205', '278', '17', '44', '2', '2017-08-03 15:03:22');
INSERT INTO `orderdetail` VALUES ('206', '279', '17', '44', '2', '2017-08-03 15:03:23');
INSERT INTO `orderdetail` VALUES ('207', '280', '17', '44', '2', '2017-08-03 15:03:24');
INSERT INTO `orderdetail` VALUES ('208', '281', '17', '44', '2', '2017-08-03 15:03:25');
INSERT INTO `orderdetail` VALUES ('209', '282', '17', '44', '2', '2017-08-03 15:03:26');
INSERT INTO `orderdetail` VALUES ('210', '283', '17', '44', '2', '2017-08-03 15:03:27');
INSERT INTO `orderdetail` VALUES ('211', '284', '17', '44', '2', '2017-08-03 15:03:28');
INSERT INTO `orderdetail` VALUES ('212', '285', '17', '44', '2', '2017-08-03 15:03:29');
INSERT INTO `orderdetail` VALUES ('213', '286', '17', '44', '2', '2017-08-03 15:03:30');
INSERT INTO `orderdetail` VALUES ('214', '287', '17', '44', '2', '2017-08-03 15:03:31');
INSERT INTO `orderdetail` VALUES ('215', '288', '17', '44', '2', '2017-08-03 15:03:32');
INSERT INTO `orderdetail` VALUES ('216', '289', '17', '44', '2', '2017-08-03 15:03:34');
INSERT INTO `orderdetail` VALUES ('217', '290', '17', '44', '2', '2017-08-03 15:03:35');
INSERT INTO `orderdetail` VALUES ('218', '291', '17', '44', '2', '2017-08-03 15:03:36');
INSERT INTO `orderdetail` VALUES ('219', '292', '17', '44', '2', '2017-08-03 15:03:37');
INSERT INTO `orderdetail` VALUES ('220', '293', '17', '44', '2', '2017-08-03 15:03:38');
INSERT INTO `orderdetail` VALUES ('221', '294', '17', '44', '2', '2017-08-03 15:03:39');
INSERT INTO `orderdetail` VALUES ('222', '295', '17', '44', '2', '2017-08-03 15:03:40');
INSERT INTO `orderdetail` VALUES ('223', '296', '17', '44', '2', '2017-08-03 15:03:41');
INSERT INTO `orderdetail` VALUES ('224', '297', '17', '44', '2', '2017-08-03 15:03:42');
INSERT INTO `orderdetail` VALUES ('225', '298', '17', '44', '2', '2017-08-03 15:03:43');
INSERT INTO `orderdetail` VALUES ('226', '299', '17', '44', '2', '2017-08-03 15:03:44');
INSERT INTO `orderdetail` VALUES ('227', '300', '17', '44', '2', '2017-08-03 15:03:45');
INSERT INTO `orderdetail` VALUES ('228', '301', '17', '44', '2', '2017-08-03 15:03:46');
INSERT INTO `orderdetail` VALUES ('229', '302', '17', '44', '2', '2017-08-03 15:03:47');
INSERT INTO `orderdetail` VALUES ('230', '303', '17', '44', '2', '2017-08-03 15:03:48');
INSERT INTO `orderdetail` VALUES ('231', '304', '17', '44', '2', '2017-08-03 15:03:49');
INSERT INTO `orderdetail` VALUES ('232', '305', '17', '44', '2', '2017-08-03 15:03:50');
INSERT INTO `orderdetail` VALUES ('233', '306', '17', '44', '2', '2017-08-03 15:03:51');
INSERT INTO `orderdetail` VALUES ('234', '307', '17', '44', '2', '2017-08-03 15:03:52');
INSERT INTO `orderdetail` VALUES ('235', '308', '17', '44', '2', '2017-08-03 15:03:54');
INSERT INTO `orderdetail` VALUES ('236', '309', '17', '44', '2', '2017-08-03 15:03:55');
INSERT INTO `orderdetail` VALUES ('237', '310', '17', '44', '2', '2017-08-03 15:03:56');
INSERT INTO `orderdetail` VALUES ('238', '311', '17', '44', '2', '2017-08-03 15:03:57');
INSERT INTO `orderdetail` VALUES ('239', '312', '17', '44', '2', '2017-08-03 15:03:58');
INSERT INTO `orderdetail` VALUES ('240', '313', '17', '44', '2', '2017-08-03 15:03:59');
INSERT INTO `orderdetail` VALUES ('241', '314', '17', '44', '2', '2017-08-03 15:04:00');
INSERT INTO `orderdetail` VALUES ('242', '315', '17', '44', '2', '2017-08-03 15:04:01');
INSERT INTO `orderdetail` VALUES ('243', '316', '17', '44', '2', '2017-08-03 15:04:02');
INSERT INTO `orderdetail` VALUES ('244', '317', '17', '44', '2', '2017-08-03 15:04:03');
INSERT INTO `orderdetail` VALUES ('245', '318', '17', '44', '2', '2017-08-03 15:04:04');
INSERT INTO `orderdetail` VALUES ('246', '319', '17', '44', '2', '2017-08-03 15:04:05');
INSERT INTO `orderdetail` VALUES ('247', '320', '17', '44', '2', '2017-08-03 15:04:06');
INSERT INTO `orderdetail` VALUES ('248', '321', '17', '44', '2', '2017-08-03 15:04:07');
INSERT INTO `orderdetail` VALUES ('249', '322', '17', '44', '2', '2017-08-03 15:04:08');
INSERT INTO `orderdetail` VALUES ('250', '323', '17', '44', '2', '2017-08-03 15:04:09');
INSERT INTO `orderdetail` VALUES ('251', '324', '17', '44', '2', '2017-08-03 15:04:10');
INSERT INTO `orderdetail` VALUES ('252', '325', '17', '44', '2', '2017-08-03 15:04:11');
INSERT INTO `orderdetail` VALUES ('253', '326', '17', '44', '2', '2017-08-03 15:04:12');
INSERT INTO `orderdetail` VALUES ('254', '327', '17', '44', '2', '2017-08-03 15:04:14');
INSERT INTO `orderdetail` VALUES ('255', '328', '17', '44', '2', '2017-08-03 15:04:15');
INSERT INTO `orderdetail` VALUES ('256', '329', '17', '44', '2', '2017-08-03 15:04:16');
INSERT INTO `orderdetail` VALUES ('257', '330', '17', '44', '2', '2017-08-03 15:04:17');
INSERT INTO `orderdetail` VALUES ('258', '331', '17', '44', '2', '2017-08-03 15:04:18');
INSERT INTO `orderdetail` VALUES ('259', '332', '17', '44', '2', '2017-08-03 15:04:19');
INSERT INTO `orderdetail` VALUES ('260', '333', '17', '44', '2', '2017-08-03 15:04:20');
INSERT INTO `orderdetail` VALUES ('261', '334', '17', '44', '2', '2017-08-03 15:04:21');
INSERT INTO `orderdetail` VALUES ('262', '335', '17', '44', '2', '2017-08-03 15:04:22');
INSERT INTO `orderdetail` VALUES ('263', '336', '17', '44', '2', '2017-08-03 15:04:23');
INSERT INTO `orderdetail` VALUES ('264', '337', '17', '44', '2', '2017-08-03 15:04:24');
INSERT INTO `orderdetail` VALUES ('265', '338', '17', '44', '2', '2017-08-03 15:04:25');
INSERT INTO `orderdetail` VALUES ('266', '339', '17', '44', '2', '2017-08-03 15:04:26');
INSERT INTO `orderdetail` VALUES ('267', '340', '17', '44', '2', '2017-08-03 15:04:27');
INSERT INTO `orderdetail` VALUES ('268', '341', '17', '44', '2', '2017-08-03 15:04:28');
INSERT INTO `orderdetail` VALUES ('269', '342', '17', '44', '2', '2017-08-03 15:04:29');
INSERT INTO `orderdetail` VALUES ('270', '343', '17', '44', '2', '2017-08-03 15:04:30');
INSERT INTO `orderdetail` VALUES ('271', '344', '17', '44', '2', '2017-08-03 15:04:31');
INSERT INTO `orderdetail` VALUES ('272', '345', '17', '44', '2', '2017-08-03 15:04:33');
INSERT INTO `orderdetail` VALUES ('273', '346', '17', '44', '2', '2017-08-03 15:04:34');
INSERT INTO `orderdetail` VALUES ('274', '347', '17', '44', '2', '2017-08-03 15:04:35');
INSERT INTO `orderdetail` VALUES ('275', '348', '17', '44', '2', '2017-08-03 15:04:36');
INSERT INTO `orderdetail` VALUES ('276', '349', '17', '44', '2', '2017-08-03 15:04:37');
INSERT INTO `orderdetail` VALUES ('277', '350', '17', '44', '2', '2017-08-03 15:04:38');
INSERT INTO `orderdetail` VALUES ('278', '351', '17', '44', '2', '2017-08-03 15:04:39');
INSERT INTO `orderdetail` VALUES ('279', '352', '17', '44', '2', '2017-08-03 15:04:40');
INSERT INTO `orderdetail` VALUES ('280', '353', '17', '44', '2', '2017-08-03 15:04:41');
INSERT INTO `orderdetail` VALUES ('281', '354', '17', '44', '2', '2017-08-03 15:04:42');
INSERT INTO `orderdetail` VALUES ('282', '355', '17', '44', '2', '2017-08-03 15:04:43');
INSERT INTO `orderdetail` VALUES ('283', '356', '17', '44', '2', '2017-08-03 15:04:44');
INSERT INTO `orderdetail` VALUES ('284', '357', '17', '44', '2', '2017-08-03 15:04:45');
INSERT INTO `orderdetail` VALUES ('285', '358', '17', '44', '2', '2017-08-03 15:04:46');
INSERT INTO `orderdetail` VALUES ('286', '359', '17', '44', '2', '2017-08-03 15:04:47');
INSERT INTO `orderdetail` VALUES ('287', '360', '17', '44', '2', '2017-08-03 15:04:48');
INSERT INTO `orderdetail` VALUES ('288', '361', '17', '44', '2', '2017-08-03 15:04:49');
INSERT INTO `orderdetail` VALUES ('289', '362', '17', '44', '2', '2017-08-03 15:04:50');
INSERT INTO `orderdetail` VALUES ('290', '363', '17', '44', '2', '2017-08-03 15:04:51');
INSERT INTO `orderdetail` VALUES ('291', '364', '17', '44', '2', '2017-08-03 15:04:52');
INSERT INTO `orderdetail` VALUES ('292', '365', '17', '44', '2', '2017-08-03 15:04:54');
INSERT INTO `orderdetail` VALUES ('293', '366', '17', '44', '2', '2017-08-03 15:04:55');
INSERT INTO `orderdetail` VALUES ('294', '367', '17', '44', '2', '2017-08-03 15:04:56');
INSERT INTO `orderdetail` VALUES ('295', '368', '17', '44', '2', '2017-08-03 15:04:57');
INSERT INTO `orderdetail` VALUES ('296', '369', '17', '44', '2', '2017-08-03 15:04:58');
INSERT INTO `orderdetail` VALUES ('297', '370', '17', '44', '2', '2017-08-03 15:04:59');
INSERT INTO `orderdetail` VALUES ('298', '371', '17', '44', '2', '2017-08-03 15:05:00');
INSERT INTO `orderdetail` VALUES ('299', '372', '17', '44', '2', '2017-08-03 15:05:01');
INSERT INTO `orderdetail` VALUES ('300', '373', '17', '44', '2', '2017-08-03 15:05:02');
INSERT INTO `orderdetail` VALUES ('301', '374', '17', '44', '2', '2017-08-03 15:05:03');
INSERT INTO `orderdetail` VALUES ('302', '375', '17', '44', '2', '2017-08-03 15:05:04');
INSERT INTO `orderdetail` VALUES ('303', '376', '17', '44', '2', '2017-08-03 15:05:05');
INSERT INTO `orderdetail` VALUES ('304', '377', '17', '44', '2', '2017-08-03 15:05:06');
INSERT INTO `orderdetail` VALUES ('305', '378', '17', '44', '2', '2017-08-03 15:05:07');
INSERT INTO `orderdetail` VALUES ('306', '379', '17', '44', '2', '2017-08-03 15:05:08');
INSERT INTO `orderdetail` VALUES ('307', '380', '17', '44', '2', '2017-08-03 15:05:09');
INSERT INTO `orderdetail` VALUES ('308', '381', '17', '44', '2', '2017-08-03 15:05:10');
INSERT INTO `orderdetail` VALUES ('309', '382', '17', '44', '2', '2017-08-03 15:05:11');
INSERT INTO `orderdetail` VALUES ('310', '383', '17', '44', '2', '2017-08-03 15:05:12');
INSERT INTO `orderdetail` VALUES ('311', '384', '17', '44', '2', '2017-08-03 15:05:13');
INSERT INTO `orderdetail` VALUES ('312', '385', '17', '44', '2', '2017-08-03 15:05:15');
INSERT INTO `orderdetail` VALUES ('313', '386', '17', '44', '2', '2017-08-03 15:05:16');
INSERT INTO `orderdetail` VALUES ('314', '387', '17', '44', '2', '2017-08-03 15:05:17');
INSERT INTO `orderdetail` VALUES ('315', '388', '17', '44', '2', '2017-08-03 15:05:18');
INSERT INTO `orderdetail` VALUES ('316', '389', '17', '44', '2', '2017-08-03 15:05:19');
INSERT INTO `orderdetail` VALUES ('317', '390', '17', '44', '2', '2017-08-03 15:05:20');
INSERT INTO `orderdetail` VALUES ('318', '391', '17', '44', '2', '2017-08-03 15:05:21');
INSERT INTO `orderdetail` VALUES ('319', '392', '17', '44', '2', '2017-08-03 15:05:22');
INSERT INTO `orderdetail` VALUES ('320', '393', '17', '44', '2', '2017-08-03 15:05:23');
INSERT INTO `orderdetail` VALUES ('321', '394', '17', '44', '2', '2017-08-03 15:05:24');
INSERT INTO `orderdetail` VALUES ('322', '395', '17', '44', '2', '2017-08-03 15:05:25');
INSERT INTO `orderdetail` VALUES ('323', '396', '17', '44', '2', '2017-08-03 15:05:26');
INSERT INTO `orderdetail` VALUES ('324', '397', '17', '44', '2', '2017-08-03 15:05:27');
INSERT INTO `orderdetail` VALUES ('325', '398', '17', '44', '2', '2017-08-03 15:05:28');
INSERT INTO `orderdetail` VALUES ('326', '399', '17', '44', '2', '2017-08-03 15:05:29');
INSERT INTO `orderdetail` VALUES ('327', '400', '17', '44', '2', '2017-08-03 15:05:30');
INSERT INTO `orderdetail` VALUES ('328', '401', '17', '44', '2', '2017-08-03 15:05:31');
INSERT INTO `orderdetail` VALUES ('329', '402', '17', '44', '2', '2017-08-03 15:05:32');
INSERT INTO `orderdetail` VALUES ('330', '403', '17', '44', '2', '2017-08-03 15:05:33');
INSERT INTO `orderdetail` VALUES ('331', '404', '17', '44', '2', '2017-08-03 15:05:34');

-- ----------------------------
-- Table structure for pics
-- ----------------------------
DROP TABLE IF EXISTS `pics`;
CREATE TABLE `pics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `pic_http` varchar(255) DEFAULT NULL,
  `pic_descr` varchar(255) DEFAULT NULL,
  `pic_add_time` datetime DEFAULT NULL,
  `pic_state` tinyint(4) DEFAULT NULL COMMENT '1 正常\r\n2 禁用',
  `pic_address` varchar(10) DEFAULT NULL COMMENT '图片的位置 1header  2middle',
  `end_time` datetime DEFAULT NULL COMMENT '过期时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pics
-- ----------------------------
INSERT INTO `pics` VALUES ('9', '6', '2017-08-09/598a800767070.jpg', '/gzsc/index.php/Home/Goods/detail?id=14', 'baidu', '2017-07-10 15:33:03', '2', '2', '2017-08-01 00:00:00');
INSERT INTO `pics` VALUES ('5', '6', '2017-06-09/593a202d5dc00.jpg', '/gzsc/index.php/Home/Goods/detail?id=15', 'eqrh', '2017-06-09 11:24:47', '1', '2', '2017-08-11 00:00:00');
INSERT INTO `pics` VALUES ('8', '6', '2017-06-09/593a3b055eba0.jpg', '/gzsc/index.php/Home/Goods/detail?id=14', 'qeryhqegeq', '2017-06-09 14:07:01', '1', '2', '2017-08-08 00:00:00');
INSERT INTO `pics` VALUES ('10', '6', '2017-07-10/5963344ecd140.jpg', '/gzsc/index.php/Home/Goods/detail?id=15', 'cctv', '2017-07-10 16:01:18', '1', '2', '2017-08-16 00:00:00');
INSERT INTO `pics` VALUES ('11', '6', '2017-07-10/5963397460310.jpg', '/gzsc/index.php/Home/Goods/detail?id=15', 'cctv3', '2017-07-10 16:23:16', '1', '1', '2017-08-01 00:00:00');
INSERT INTO `pics` VALUES ('13', '6', '2017-07-27/597996c9b9be1.jpg', '/gzsc/index.php/Home/Goods/detail?id=14', 'SDFGKUH IU', '2017-07-27 15:31:21', '1', '1', '2017-08-15 11:36:12');
INSERT INTO `pics` VALUES ('12', '6', '2017-07-27/597942e1dca78.jpg', '/gzsc/index.php/Home/Goods/detail?id=14', '6541', '2017-07-27 09:33:21', '1', '1', '2017-08-18 11:36:15');
INSERT INTO `pics` VALUES ('16', '6', '2017-08-09/598a755ca0668.jpg', '/gzsc/index.php/Home/Goods/detail?id=14', 'asgfwert', '2017-08-09 10:37:16', '1', '1', '2017-08-19 11:36:20');
INSERT INTO `pics` VALUES ('18', '6', '2017-08-09/598aaf8a4f1a0.jpg', '/gzsc/index.php/Home/Goods/detail?id=14', '他围绕', '2017-08-09 14:45:30', '1', '1', '2017-08-16 14:45:30');
INSERT INTO `pics` VALUES ('19', '6', '2017-08-09/598ad541cf468.jpg', '/gzsc/index.php/Home/Goods/detail?id=15', 'EWF', '2017-08-09 17:26:25', '1', '2', '2017-08-16 17:26:25');

-- ----------------------------
-- Table structure for rele
-- ----------------------------
DROP TABLE IF EXISTS `rele`;
CREATE TABLE `rele` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `good_id` int(11) DEFAULT NULL,
  `good_attr_id` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rele
-- ----------------------------
INSERT INTO `rele` VALUES ('64', '14', '39', '84');
INSERT INTO `rele` VALUES ('65', '15', '40', '85');
INSERT INTO `rele` VALUES ('66', '16', '41', '86');
INSERT INTO `rele` VALUES ('67', '14', '42', '87');
INSERT INTO `rele` VALUES ('68', '14', '42', '88');
INSERT INTO `rele` VALUES ('69', '15', '43', '89');
INSERT INTO `rele` VALUES ('70', '15', '43', '90');
INSERT INTO `rele` VALUES ('71', '17', '44', '91');
INSERT INTO `rele` VALUES ('72', '17', '44', '92');
INSERT INTO `rele` VALUES ('73', '18', '45', '93');
INSERT INTO `rele` VALUES ('75', '19', '47', '95');
INSERT INTO `rele` VALUES ('76', '20', '48', '96');
INSERT INTO `rele` VALUES ('77', '21', '49', '97');
INSERT INTO `rele` VALUES ('78', '21', '50', '98');
INSERT INTO `rele` VALUES ('79', '22', '51', '99');

-- ----------------------------
-- Table structure for second_hand_car
-- ----------------------------
DROP TABLE IF EXISTS `second_hand_car`;
CREATE TABLE `second_hand_car` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `cate_id` int(11) DEFAULT NULL,
  `brank` varchar(50) DEFAULT '' COMMENT '品牌',
  `color` varchar(50) DEFAULT NULL,
  `first_time` datetime DEFAULT NULL COMMENT '首次上牌时间',
  `price` double(11,2) DEFAULT NULL,
  `des` varchar(255) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `driving_lience_pic` varchar(255) DEFAULT NULL COMMENT '行驶证照片',
  `lience_num_pic` varchar(255) DEFAULT NULL COMMENT '车牌照照片',
  `register_pic` varchar(255) DEFAULT NULL COMMENT '登记照照片',
  `bill_pic` varchar(255) DEFAULT NULL COMMENT '购买发票照片',
  `add_time` datetime DEFAULT NULL,
  `states` tinyint(4) DEFAULT '1' COMMENT '状态（1待审核 2通过 3禁用）',
  `clicknum` int(11) DEFAULT '1' COMMENT '点击量',
  `valid_time` datetime DEFAULT NULL COMMENT '有效期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of second_hand_car
-- ----------------------------
INSERT INTO `second_hand_car` VALUES ('28', '9', '8', '奥迪', 'white', '2012-12-12 00:00:00', '12.00', 'aaaaaaaaaaa', '亚龙2', '156388514569', '江苏省镇江市润州区', '2017-08-02/5980b282aae60.jpg', '2017-08-02/5980b282ac5d0.jpg', '2017-08-02/5980b282ad958.jpg', '2017-08-02/5980b282aece0.jpg', '2017-08-02 00:47:53', '3', '1', '0000-00-00 00:00:00');
INSERT INTO `second_hand_car` VALUES ('29', '16', '8', '奥迪', 'white', '2012-12-12 00:00:00', '10.00', '你好', '亚龙1', '156388514569', '河南', '2017-08-02/5980b282aae60.jpg', '2017-08-02/5980b282ac5d0.jpg', '2017-08-02/5980b282ad958.jpg', '2017-08-02/5980b282aece0.jpg', '2017-08-02 00:47:53', '2', '1', '2017-08-06 08:32:21');
INSERT INTO `second_hand_car` VALUES ('31', '16', '8', '奥迪', 'white', '2012-12-12 00:00:00', '12.00', 'aaaaaaaaaaa', '亚龙1', '156388514569', '河南', '2017-08-02/5980b282aae60.jpg', '2017-08-02/5980b282ac5d0.jpg', '2017-08-02/5980b282ad958.jpg', '2017-08-02/5980b282aece0.jpg', '2017-08-02 00:47:53', '2', '1', '2017-08-07 08:32:27');
INSERT INTO `second_hand_car` VALUES ('30', '6', '8', '玛莎拉蒂', 'white', '2012-12-12 00:00:00', '11.00', 'aaaaaaaaaaa', '亚龙2', '156388514569', '河南省新乡市辉县市', '2017-08-02/5980b282aae60.jpg', '2017-08-02/5980b282ac5d0.jpg', '2017-08-02/5980b282ad958.jpg', '2017-08-02/5980b282aece0.jpg', '2017-08-02 00:47:53', '2', '2', '2017-08-14 00:00:00');
INSERT INTO `second_hand_car` VALUES ('33', null, '8', 'ASDAS', 'ASDAS', '0000-00-00 00:00:00', '0.00', 'SADSA', 'ASDAS', '13409362482', null, '2017-08-10/1502358332584092.jpg', '2017-08-10/1502358332957519.jpg', '2017-08-10/1502358332193603.jpg', '2017-08-10/1502358333724799.jpg', '2017-08-10 17:45:34', '1', '1', '2017-08-17 17:45:34');

-- ----------------------------
-- Table structure for second_hand_carfile
-- ----------------------------
DROP TABLE IF EXISTS `second_hand_carfile`;
CREATE TABLE `second_hand_carfile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `second_hand_card_id` int(11) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of second_hand_carfile
-- ----------------------------
INSERT INTO `second_hand_carfile` VALUES ('108', '33', '2017-08-10/1502358332263861.jpg', '2017-08-10 17:45:34');
INSERT INTO `second_hand_carfile` VALUES ('107', '33', '2017-08-10/1502358332786675.jpg', '2017-08-10 17:45:34');
INSERT INTO `second_hand_carfile` VALUES ('106', '31', '2017-08-02/5980b386c11d8.jpg', '2017-08-02 00:00:00');
INSERT INTO `second_hand_carfile` VALUES ('105', '31', '2017-08-02/SGAERSGASDGA.jpg', '2017-08-02 00:47:53');
INSERT INTO `second_hand_carfile` VALUES ('104', '30', '2017-08-02/5980b386c11d8.jpg', '2017-08-02 00:00:00');
INSERT INTO `second_hand_carfile` VALUES ('103', '30', '2017-08-02/SGAERSGASDGA.jpg', '2017-08-02 00:47:53');

-- ----------------------------
-- Table structure for shoppingcar
-- ----------------------------
DROP TABLE IF EXISTS `shoppingcar`;
CREATE TABLE `shoppingcar` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `good_id` int(11) DEFAULT NULL,
  `good_attr_id` int(11) DEFAULT NULL,
  `good_num` int(11) DEFAULT '1' COMMENT '商品的数量',
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shoppingcar
-- ----------------------------
INSERT INTO `shoppingcar` VALUES ('21', '9', '6', '14', '42', '2', '2017-07-26 09:01:03');
INSERT INTO `shoppingcar` VALUES ('22', '9', '16', '17', '44', '2', '2017-07-26 09:00:33');
INSERT INTO `shoppingcar` VALUES ('25', '1', '6', '14', '39', '3', '2017-08-03 15:11:13');
INSERT INTO `shoppingcar` VALUES ('20', '9', '6', '14', '39', '2', '2017-07-26 09:00:33');
INSERT INTO `shoppingcar` VALUES ('26', '1', '6', '13', '39', '5', '2017-08-03 15:11:48');
INSERT INTO `shoppingcar` VALUES ('27', '1', '6', '12', '39', '5', '2017-08-03 15:11:54');
INSERT INTO `shoppingcar` VALUES ('28', '1', '6', '11', '39', '5', '2017-08-03 15:12:02');
INSERT INTO `shoppingcar` VALUES ('29', '1', '6', '8', '39', '5', '2017-08-03 15:12:09');

-- ----------------------------
-- Table structure for store_notice
-- ----------------------------
DROP TABLE IF EXISTS `store_notice`;
CREATE TABLE `store_notice` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `store_notice_http` varchar(50) DEFAULT NULL,
  `store_notice_state` tinyint(4) DEFAULT NULL COMMENT '1 使用状态  2禁用状态',
  `store_notice_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of store_notice
-- ----------------------------
INSERT INTO `store_notice` VALUES ('2', '污染事故', '打过去', 'sDFWFD', '1', '2017-06-09 15:06:54');
INSERT INTO `store_notice` VALUES ('3', '污染事故', '打过去按时支、、', 'sDFWFD', '2', '2017-06-09 15:29:07');
INSERT INTO `store_notice` VALUES ('4', '污染事故', '打过', 'sDFWFD', '2', '2017-06-09 15:29:51');

-- ----------------------------
-- Table structure for truck_rend
-- ----------------------------
DROP TABLE IF EXISTS `truck_rend`;
CREATE TABLE `truck_rend` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `cate_id` int(11) DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL COMMENT '品牌',
  `car_num` varchar(10) DEFAULT NULL COMMENT '车牌',
  `date_for_production` varchar(50) DEFAULT NULL COMMENT '出厂日期',
  `price` double(10,2) DEFAULT NULL,
  `des` text,
  `tel` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `states` tinyint(4) DEFAULT '1' COMMENT '状态（1正常 2禁用）',
  `clicknum` int(11) DEFAULT '1' COMMENT '点击量',
  `valid_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of truck_rend
-- ----------------------------
INSERT INTO `truck_rend` VALUES ('6', '6', '3', '大众', '豫S1234A', '2012年12月13日', '12.00', '你好', '156388514569', '亚龙', '2017-08-02 14:43:24', '2', '1', '2017-08-14 00:00:00');
INSERT INTO `truck_rend` VALUES ('3', '6', '3', '大众1', '豫S1234A2', '2012年12月13日', '112.00', '你好1', '156385514569', '亚龙31', '2017-08-02 14:07:06', '2', '1', '2017-08-01 10:38:53');
INSERT INTO `truck_rend` VALUES ('4', '16', '3', '大众2', '豫S1234A', '2012年12月13日', '12.00', '你好', '156368514569', '亚龙2', '2017-08-02 14:07:06', '2', '1', '2017-08-15 10:38:58');
INSERT INTO `truck_rend` VALUES ('5', '17', '3', '大众3', '豫S1234A', '2012年12月13日', '12.00', '你好', '156388516569', '亚龙1', '2017-08-02 14:07:06', '2', '1', '2017-08-28 10:39:01');
INSERT INTO `truck_rend` VALUES ('7', null, '3', 'sada', 'asdas', 'sadassadsa', '0.00', 'asdasasd', '13409362482', 'asdsa', '2017-08-09 20:56:38', '1', '1', '2017-08-16 20:56:38');
INSERT INTO `truck_rend` VALUES ('8', null, '3', 'sada', 'asdas', 'sadassadsa', '0.00', 'asdasasd', '13409362482', 'asdsa', '2017-08-09 20:56:57', '1', '1', '2017-08-16 20:56:57');
INSERT INTO `truck_rend` VALUES ('9', null, '3', 'sada', 'asdas', 'sadassadsa', '0.00', 'asdasasd', '13409362482', 'asdsa', '2017-08-09 20:57:30', '1', '1', '2017-08-16 20:57:30');
INSERT INTO `truck_rend` VALUES ('10', null, '3', 'sada', 'asdas', 'sadassadsa', '0.00', 'asdasasd', '13409362482', 'asdsa', '2017-08-09 20:57:32', '1', '1', '2017-08-16 20:57:32');
INSERT INTO `truck_rend` VALUES ('26', null, '3', '12', '12', '15', '15.00', '15', '13409362482', '12', '2017-08-10 09:51:17', '1', '1', '2017-08-17 09:51:17');
INSERT INTO `truck_rend` VALUES ('27', null, '3', '123', '123', '123', '123.00', '12', '13409362482', '123', '2017-08-10 09:54:50', '1', '1', '2017-08-17 09:54:50');
INSERT INTO `truck_rend` VALUES ('28', null, '3', '123', '123', '123', '123.00', '12', '13409362482', '123', '2017-08-10 09:54:58', '1', '1', '2017-08-17 09:54:58');

-- ----------------------------
-- Table structure for truck_rendfile
-- ----------------------------
DROP TABLE IF EXISTS `truck_rendfile`;
CREATE TABLE `truck_rendfile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `truck_rend_id` int(11) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=539 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of truck_rendfile
-- ----------------------------
INSERT INTO `truck_rendfile` VALUES ('15', '3', '2017-07-31/3f54a3aed1d7c2ed9a3b41da3c3d5735.jpg', '2017-08-02 14:43:24');
INSERT INTO `truck_rendfile` VALUES ('16', '4', '2017-07-31/4ed0bfd806ba867d22f05c218d6e08d9.jpg', '2017-08-02 14:43:24');
INSERT INTO `truck_rendfile` VALUES ('17', '5', '2017-08-02/5981761bed8c8.jpg', '2017-08-02 00:00:00');
INSERT INTO `truck_rendfile` VALUES ('529', '26', '/storage/emulated/0/Pictures/Screenshots/S70808-18385456.jpg', '2017-08-10 09:51:17');
INSERT INTO `truck_rendfile` VALUES ('530', '26', '/storage/emulated/0/Pictures/Screenshots/S70808-07515741.jpg', '2017-08-10 09:51:17');
INSERT INTO `truck_rendfile` VALUES ('531', '26', '2017-08-10/1502329876271619.jpg', '2017-08-10 09:51:17');
INSERT INTO `truck_rendfile` VALUES ('532', '26', '2017-08-10/1502329876212429.jpg', '2017-08-10 09:51:17');
INSERT INTO `truck_rendfile` VALUES ('533', '27', '2017-08-10/1502330089760904.jpg', '2017-08-10 09:54:50');
INSERT INTO `truck_rendfile` VALUES ('534', '27', '2017-08-10/1502330089836914.jpg', '2017-08-10 09:54:50');
INSERT INTO `truck_rendfile` VALUES ('535', '28', '2017-08-10/1502330089760904.jpg', '2017-08-10 09:54:58');
INSERT INTO `truck_rendfile` VALUES ('536', '28', '2017-08-10/1502330089836914.jpg', '2017-08-10 09:54:58');
INSERT INTO `truck_rendfile` VALUES ('537', '28', '2017-08-10/1502330097836290.jpg', '2017-08-10 09:54:58');
INSERT INTO `truck_rendfile` VALUES ('538', '28', '2017-08-10/1502330097134629.jpg', '2017-08-10 09:54:58');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(50) DEFAULT NULL COMMENT 'socked_id',
  `user_name` varchar(50) DEFAULT NULL,
  `user_id` char(18) DEFAULT NULL COMMENT '生份证号',
  `user_pwd` varchar(255) DEFAULT NULL,
  `user_phone` varchar(20) DEFAULT NULL,
  `user_pic` varchar(255) DEFAULT NULL,
  `user_money` int(11) DEFAULT NULL,
  `user_grade` int(4) DEFAULT NULL COMMENT '0超级管理员\r\n1 管理员正常\r\n11管理员禁用\r\n\r\n2 会员商户\r\n3 禁用的商户\r\n4未激活商户\r\n\r\n5会员\r\n6禁用的用户',
  `user_sex` tinyint(4) DEFAULT NULL COMMENT '0女\r\n1男\r\n2不详',
  `user_store_x` varchar(50) DEFAULT NULL,
  `user_store_y` varchar(50) DEFAULT NULL,
  `user_store_address` varchar(255) DEFAULT NULL,
  `user_store_phone` varchar(20) DEFAULT NULL,
  `user_store_headerpic` varchar(255) DEFAULT NULL COMMENT '商户的头部头像',
  `user_store_pic` varchar(255) DEFAULT NULL,
  `user_store_pic1` varchar(255) DEFAULT NULL,
  `user_store_pic2` varchar(255) DEFAULT NULL,
  `user_store_pic3` varchar(255) DEFAULT NULL,
  `user_store_pic4` varchar(255) DEFAULT NULL,
  `user_store_star` tinyint(4) DEFAULT '0' COMMENT '商铺等级',
  `user_store_lience` varchar(50) DEFAULT NULL COMMENT '营业执照',
  `user_store_name` varchar(50) DEFAULT NULL COMMENT '商铺名',
  `user_store_registered` int(11) DEFAULT NULL COMMENT '注册资金',
  `user_store_cash` varchar(50) DEFAULT NULL COMMENT '保证金',
  `user_store_evaluate` tinyint(4) DEFAULT '5' COMMENT '商户评价 5五星 4四星 3三星 2二星 1一星 ',
  `user_add_time` datetime DEFAULT NULL,
  `user_store_percent` int(4) DEFAULT '0' COMMENT '抽成百分比',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', null, 'lyl', '111111111111111111', 'e10adc3949ba59abbe56e057f20f883e', '15538165120', '2017-06-13/593fab69ad329.jpg', '0', '5', null, '', '', '', '', null, '2017-06-09/593a741cd9878.jpg', '', '', '', '', null, '', '', null, '', null, '2017-06-09 18:10:36', '0');
INSERT INTO `user` VALUES ('7', null, 'admin', '123456789123456781', 'e10adc3949ba59abbe56e057f20f883e', '15638861289', '', '0', '0', null, null, null, '', null, null, '', null, null, null, null, null, '123123', 'EFD', null, '', null, '0000-00-00 00:00:00', '0');
INSERT INTO `user` VALUES ('6', null, 'yi', '123456789123456', 'e10adc3949ba59abbe56e057f20f883e', '15638861281', '', '0', '2', null, null, null, '郑州市', '15643351287', '2017-07-11/5964e4813b538.jpg', '2017-06-13/593fab69a9c79.jpg', '2017-06-13/593fab69ad329.jpg', '2017-06-13/593fab69aea99.jpg', '2017-06-13/593fab69afe21.jpg', '2017-06-13/593fab69b1591.jpg', '0', '156', 'shangdianyi', '213', '12312', '5', '2017-06-08 09:03:35', '10');
INSERT INTO `user` VALUES ('9', null, 'userone', null, 'e10adc3949ba59abbe56e057f20f883e', '15638861283', '2017-06-08/5939583804d58.jpg', '0', '5', '2', null, null, null, null, null, '2017-06-13/593fab69ad329.jpg', null, null, null, null, null, null, null, null, null, '5', '2017-06-08 20:48:30', '0');
INSERT INTO `user` VALUES ('10', null, 'usertwo', null, 'e10adc3949ba59abbe56e057f20f883e', '', '2017-06-13/593fab69a9c79.jpg', '0', '5', '2', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '5', '2017-06-08 21:12:05', '0');
INSERT INTO `user` VALUES ('11', null, 'userthree', '', 'e10adc3949ba59abbe56e057f20f883e', '', '2017-06-13/593fab69ad329.jpg', '0', '5', '2', null, null, null, null, null, null, null, null, null, null, null, '', '', '0', '', '5', '2017-06-08 21:12:54', '0');
INSERT INTO `user` VALUES ('12', null, 'userfour', null, 'e10adc3949ba59abbe56e057f20f883e', null, '', '0', '5', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '5', '2017-06-08 22:29:19', '0');
INSERT INTO `user` VALUES ('13', null, 'userfive', null, 'e10adc3949ba59abbe56e057f20f883e', null, '2017-06-08/5939583804d58.jpg', '0', '5', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '5', '2017-06-08 21:59:20', '0');
INSERT INTO `user` VALUES ('16', null, 'er', '123456789123456729', 'e10adc3949ba59abbe56e057f20f883e', '15638861285', null, '0', '2', null, null, null, '郑州市', null, null, '2017-07-11/5964e4813b538.jpg', '2017-07-11/5964e4813c4d8.jpg', '2017-07-11/5964e4813d478.jpg', '2017-07-11/5964e4813e030.jpg', '2017-07-11/5964e4813f3b8.jpg', '0', '12342342424', 'shangdianer', '2147483647', '2342342', '4', '2017-06-09 15:57:21', '10');
INSERT INTO `user` VALUES ('17', null, 'san', '111111111111111111', 'e10adc3949ba59abbe56e057f20f883e', '15638861284', null, '0', '2', null, null, null, '郑州市', null, null, '2017-06-09/593a563158228.jpg', null, null, null, null, '0', '15621', '商店三', '123123', '123123', '3', '2017-06-09 16:02:57', '10');
INSERT INTO `user` VALUES ('18', null, 'si', '222222222222222222', 'e10adc3949ba59abbe56e057f20f883e', null, null, '0', '2', null, null, null, '郑州市', null, null, '2017-06-09/593a68b1bd358.jpg', null, null, null, null, '0', '415665', '商店四', '541', '5461', '2', '2017-06-09 17:21:53', '10');
INSERT INTO `user` VALUES ('19', null, 'wu', '555555555555555555', 'e10adc3949ba59abbe56e057f20f883e', null, null, '0', '2', null, null, null, '郑州市', null, null, '2017-06-09/593a725b65518.jpg', null, null, null, null, '0', '123143', 'shangdianwu', '2', '2342', '1', '2017-06-09 18:03:07', '10');
INSERT INTO `user` VALUES ('20', null, 'liu', '444444444555555555', 'e10adc3949ba59abbe56e057f20f883e', null, null, '0', '2', null, null, null, '郑州市', null, null, '2017-06-09/593a7282efbf0.jpg', null, null, null, null, '0', '7658796', 'sahngdianliu', '987098', '98790', '5', '2017-06-09 18:03:46', '10');
INSERT INTO `user` VALUES ('21', null, 'qi', '666666666555555555', 'e10adc3949ba59abbe56e057f20f883e', null, null, '0', '2', null, null, null, '郑州市', null, null, '2017-06-09/593a72a96ca48.jpg', null, null, null, null, '0', '876809', 'shangdainqi', '98709', '98798', '5', '2017-06-09 18:04:25', '10');
INSERT INTO `user` VALUES ('22', null, 'ba', '666666666333333333', 'e10adc3949ba59abbe56e057f20f883e', null, null, '0', '2', null, null, null, '郑州市', null, null, '2017-06-09/593a72cf9c400.jpg', null, null, null, null, '0', '907890', 'shangdianba', '908', '897', '5', '2017-06-09 18:05:03', '10');
INSERT INTO `user` VALUES ('23', null, 'jiu', '777777777444444444', 'e10adc3949ba59abbe56e057f20f883e', null, null, '0', '2', null, null, null, '郑州市', null, null, '2017-06-09/593a72f857a58.jpg', null, null, null, null, '0', '48665', 'shangdianjiu', '465', '456', '5', '2017-06-09 18:05:44', '0');
INSERT INTO `user` VALUES ('24', null, 'shi', '999999999111111111', 'e10adc3949ba59abbe56e057f20f883e', null, null, '0', '2', null, null, null, '郑州市', null, null, '2017-06-09/593a7324b69e0.jpg', null, null, null, null, '0', '4564', 'shangdainshi', '45665', '654', '5', '2017-06-09 18:06:28', '0');
INSERT INTO `user` VALUES ('25', null, 'shiyi', '888888888999999999', 'e10adc3949ba59abbe56e057f20f883e', null, null, '0', '2', null, null, null, '郑州市', null, null, '2017-06-09/593a735588f68.jpg', null, null, null, null, null, '356465', 'shangdianshiyi', '56465', '654', '5', '2017-06-09 18:07:17', '0');
INSERT INTO `user` VALUES ('26', null, 'shier', '666666666111111111', 'e10adc3949ba59abbe56e057f20f883e', null, null, '0', '2', null, null, null, 'hjklgbijk', null, null, '2017-06-09/593a741cd9878.jpg', null, null, null, null, null, '456', 'shangdianshier', '865465', '4165', '5', '2017-06-09 18:10:36', '0');
INSERT INTO `user` VALUES ('31', null, 'shisan', '123456789987654322', 'e10adc3949ba59abbe56e057f20f883e', null, null, '0', '2', null, null, null, 'sdga', null, null, '2017-07-10/59631ea72cec0.jpg', null, null, null, null, '0', '234', 'shangdianshisan', '234', '234', '5', '2017-07-10 14:28:55', '0');
INSERT INTO `user` VALUES ('33', null, 'sshisi', '123456789123456897', 'e10adc3949ba59abbe56e057f20f883e', '15638869821', null, '0', '2', null, null, null, '郑州市', null, '2017-07-12/596573c91cf48.jpg', '2017-07-12/596573c91eaa0.jpg', '2017-07-12/596573c91fe28.jpg', '2017-07-12/596573c921598.jpg', '2017-07-12/596573c9230f0.jpg', '2017-07-12/596573c924478.jpg', '0', '123456', 'shangdianshisi', '534', '123', '5', '2017-07-11 23:05:16', '0');
INSERT INTO `user` VALUES ('34', null, 'shiwu', '123456789654987321', 'e10adc3949ba59abbe56e057f20f883e', null, null, '0', '2', null, null, null, '俺的沙发SDF爽肤水 ', null, null, null, null, null, null, null, '0', '6546', 'shangdianshiwu', '534', '23432', '5', '2017-07-24 16:17:17', '12');

-- ----------------------------
-- Table structure for weixiu_service
-- ----------------------------
DROP TABLE IF EXISTS `weixiu_service`;
CREATE TABLE `weixiu_service` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `cate_id` int(11) DEFAULT NULL,
  `serve_cate` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pay_method` varchar(255) DEFAULT NULL,
  `des` text,
  `name` varchar(255) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `states` tinyint(4) DEFAULT '1' COMMENT '状态（1正常 2禁用）',
  `clicknum` int(11) DEFAULT '1' COMMENT '点击量',
  `valid_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of weixiu_service
-- ----------------------------
INSERT INTO `weixiu_service` VALUES ('5', '6', '6', '大众', '豫S1234A', '0', '你好1', '亚龙3', '156388514569', '2017-08-02 16:40:51', '2', '3', '2017-08-16 00:00:00');
INSERT INTO `weixiu_service` VALUES ('6', '6', '6', '大众', '豫S1234A1', '01', '你好2', '亚龙21', '1563885145691', '2017-08-02 16:42:04', '2', '2', '2017-08-16 14:38:53');
INSERT INTO `weixiu_service` VALUES ('3', '9', '6', '大众', '豫S1234A', '0', '你好3', '亚龙3', '156388514569', '2017-08-02 16:40:51', '2', '1', '2017-08-08 08:27:32');
INSERT INTO `weixiu_service` VALUES ('4', '6', '6', '大众', '豫S1234A', '0', '你好4', '亚龙3', '156388514569', '2017-08-02 16:40:51', '2', '2', '2017-08-15 08:27:27');
INSERT INTO `weixiu_service` VALUES ('2', '16', '6', '大众', '豫S1234A', '0', '你好5', '亚龙3', '156388514569', '2017-08-02 16:40:51', '2', '3', '2017-08-07 08:27:21');

-- ----------------------------
-- Table structure for weixiu_servicefile
-- ----------------------------
DROP TABLE IF EXISTS `weixiu_servicefile`;
CREATE TABLE `weixiu_servicefile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weixiu_service_id` int(11) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of weixiu_servicefile
-- ----------------------------
INSERT INTO `weixiu_servicefile` VALUES ('16', '6', '2017-08-02/5981985a17ed0.jpg', '2017-08-02 00:00:00');
INSERT INTO `weixiu_servicefile` VALUES ('9', '4', '2017-07-31/3f54a3aed1d7c2ed9a3b41da3c3d5735.jpg', '2017-08-02 16:40:51');
INSERT INTO `weixiu_servicefile` VALUES ('10', '4', '2017-07-31/4ed0bfd806ba867d22f05c218d6e08d9.jpg', '2017-08-02 16:40:51');
