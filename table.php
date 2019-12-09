//商品表
create table pre_product(
id INT NOT NULL AUTO_INCREMENT COMMENT '商品id',
category_id INT NOT NULL COMMENT '分类id' ,
name VARCHAR(50) NOT NULL COMMENT '商品名称',
sale_num INT   COMMENT '商品的销量',
content longtext COMMENT '商品的描述',
sort INT COMMENT '排序',
status char(1) COMMENT'状态',
created_at DATETIME COMMENT'创建时间',
updated_at DATETIME COMMENT'修改时间',
PRIMARY KEY ( id )
)


//标签表
create table pre_product_tag(
id INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
product_id INT NOT NULL COMMENT '商品id' ,
tag_id tinyint NOT NULL COMMENT '标签类型id',
value varchar(255)    COMMENT '标签值',
status   char(1) COMMENT '状态',
created_at DATETIME COMMENT'创建时间',
updated_at DATETIME COMMENT'修改时间',
PRIMARY KEY ( id )
)


//库存表
create table pre_sku(
id INT NOT NULL AUTO_INCREMENT COMMENT '库存id',
product_id INT NOT NULL COMMENT '商品id' ,
original_price decimal(10,2) NOT NULL COMMENT '原价',
price  decimal(10,2)    COMMENT '售价',
attr1   varchar(50) COMMENT '商品的属性1',
attr2   varchar(50) COMMENT '商品的属性2',
attr3   varchar(50) COMMENT '商品的属性3',
quantity   int  COMMENT '商品的库存',
sort   int  COMMENT '排序',
status   char(1)  COMMENT '状态',
created_at DATETIME COMMENT'创建时间',
updated_at DATETIME COMMENT'修改时间',
PRIMARY KEY ( id )
)


//导航菜单
create table pre_nav(
id  int AUTO_INCREMENT ,
type_id  tinyint NOT NULL  COMMENT '类型id',
sort tinyint  COMMENT '排序' ,
title varchar(50)  COMMENT '名字',
picture   varchar(255)    COMMENT '图片',
link_type   tinyint COMMENT '链接类型',
link_target    varchar(255) COMMENT '链接目标',
status    char(1) COMMENT '状态',
created_at DATETIME COMMENT'创建时间',
updated_at DATETIME COMMENT'修改时间',
PRIMARY KEY ( id  )
)


//分类表
create table pre_category(
id  int NOT NULL AUTO_INCREMENT COMMENT '分类的id',
name varchar(50)   COMMENT '分类的名称' ,
property VARCHAR(500)  COMMENT '属性(json数据)',
sort    int     COMMENT '排序',
status   char(1)  COMMENT '状态',
created_at DATETIME COMMENT'创建时间',
updated_at DATETIME COMMENT'修改时间',
PRIMARY KEY ( id  )
)
