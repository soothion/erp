<?php namespace Bluebanner\Core;

use Illuminate\Database\Seeder;
use Bluebanner\Core\Model\Vendor;

class VendorTableSeeder extends Seeder
{
	
	public function run()
	{
    $now = date('Y-m-d H:i:s');

    Vendor::create(array('id' => 1, 'created_at' => $now, 'updated_at' => $now, 'code' => 'N1', 'name' => '深圳富高盈电子有限公司', 'abbreviation' => '富高盈', 'categorys_id' => 1, 'location' => '', 'note' => '', 'contact' => '', 'tel' => '', 'fax' => '', 'email' => '', 'contact_addr' => '', 'delivery_addr' => '', 'delivery_addr_ext' => '', 'tax_registration_card' => '', 'business_license' => '', 'registered_capital' => 0.00, 'payment_method' => '货到付款', 'discount_rate' => 0.0, 'payment_period' => '现金', 'status' => 'normal', 'qq' => '', 'home_page' => '', 'payment_credit_limit' => 0.0, 'developer' => ''));
    Vendor::create(array('id' => 2, 'created_at' => $now, 'updated_at' => $now, 'code' => 'YAA11011', 'name' => '东莞市宝三电子有限公司', 'abbreviation' => '宝三', 'categorys_id' => 1, 'location' => '', 'note' => '1.交 货 期：请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担             \n2.付款方式:  货到15天付款，开17%的增值税发票             \n3.检验标准：输入端对输出端要求过高压3000V，有过流、过稳、欠压保护，出货要求全检验，用真机测试，外观符合要求 。             \n4.包装要求：电源贴中性标签，采用气泡袋包装，配牛皮纸盒包装，产品保修一年   \n5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。         \n6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）\n7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。\n8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为011），如5月出货则是：1305011，同样不影响美观效果即可。', 'contact' => '王阳军13543779610', 'tel' => '0769-86814578分机806', 'fax' => '0769-87330839', 'email' => 'wyj@powsun.com', 'contact_addr' => '东莞市清溪镇渔_围村工业区', 'delivery_addr' => '', 'delivery_addr_ext' => '', 'tax_registration_card' => '', 'business_license' => '', 'registered_capital' => 0.00, 'payment_method' => '月结30天', 'discount_rate' => 8.0, 'payment_period' => '月结', 'status' => 'normal', 'qq' => '王小姐110635529', 'home_page' => '', 'payment_credit_limit' => 0.0, 'developer' => '谢静'));
    Vendor::create(array('id' => 3, 'created_at' => $now, 'updated_at' => $now, 'code' => 'YAT11012', 'name' => '中山市万视达天线器材有限公司', 'abbreviation' => '万视达', 'categorys_id' => 14, 'location' => '', 'note' => '1.交 货 期：请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担        \n2.付款方式:货到3天，开17%的增值税发票        \n3.供应商负责送货到我司指定仓库        \n4.包装要求：中性包装，美国版本，产品保修一年         \n5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识\n6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）\n7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。\n9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为012），如5月出货则是：1305012，同样不影响美观效果即可。', 'contact' => '高经理 13902828262', 'tel' => '0760-22602987', 'fax' => '0760-22613987', 'email' => '314257923@qq.com', 'contact_addr' => '广东省中山市东凤镇东凤大道南52号', 'delivery_addr' => '', 'delivery_addr_ext' => '', 'tax_registration_card' => '', 'business_license' => '', 'registered_capital' => 0.00, 'payment_method' => '款到发货', 'discount_rate' => 8.0, 'payment_period' => '现金', 'status' => 'normal', 'qq' => '46020073', 'home_page' => '', 'payment_credit_limit' => 0.0, 'developer' => '谢静'));
		
		// Vendor::create(array('id' => 1, 'name' => '深圳富高盈电子有限公司', 'categorys_id' => '1', 'location' => '', 'note' => '', 'contact' => '', 'tel' => '', 'fax' => '', 'email' => '', 'contact_addr' => '', 'delivery_addr' => '', 'delivery_addr_ext' => '', 'payment_method' => '0', 'discount_rate' => '0', 'payment_period' => '0', 'code' => 'N', 'qq' => '"'));
/** (\d+),"([^"]*)",(\d*),"([^"]*)","([^"]*)","([^"]*)","?([^"]*)"?,"([^"]*)","([^"]*)","([^"]*)","([^"]*)","([^"]*)",([0-9.]*),([0-9.]*),([0-9.]*),([0-9.]*),(\d*),(\d*),"([^"]*)","?([^"]*)"?\n

Vendor::create(array("id" => $1, "name" => "$2", "categorys_id" => "$3", "location" => "$4", "note" => "$5", "contact" => "$6", "tel" => "$7", "fax" => "$8", "email" => "$9", "contact_addr" => "$10", "delivery_addr" => "$11", "delivery_addr_ext" => "$12", "payment_method" => "$13", "discount_rate" => "$14", "payment_period" => "$15", "code" => "$19$1", "qq" => "$20"));\n
**/

// `erp2`.`vendor1`//这个是采购重新更新的数据
/*Vendor::create(array('id' => '1','code' => 'N1','name' => '深圳富高盈电子有限公司','abbreviation' => '富高盈','categorys_id' => '1','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '2','code' => 'YAA11011','name' => '东莞市宝三电子有限公司','abbreviation' => '宝三','categorys_id' => '1','location' => '','note' => '1.交 货 期：请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2.付款方式:  货到15天付款，开17%的增值税发票							
3.检验标准：输入端对输出端要求过高压3000V，有过流、过稳、欠压保护，出货要求全检验，用真机测试，外观符合要求 。							
4.包装要求：电源贴中性标签，采用气泡袋包装，配牛皮纸盒包装，产品保修一年		
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。					
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为011），如5月出货则是：1305011，同样不影响美观效果即可。','contact' => '王阳军13543779610','tel' => '0769-86814578分机806','fax' => '0769-87330839','email' => 'wyj@powsun.com','contact_addr' => '东莞市清溪镇渔_围村工业区','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '8.0','payment_period' => '15','status' => 'normal','qq' => '王小姐110635529','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '3','code' => 'YAT11012','name' => '中山市万视达天线器材有限公司','abbreviation' => '万视达','categorys_id' => '14','location' => '','note' => '1.交 货 期：请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担				
2.付款方式:货到3天，开17%的增值税发票				
3.供应商负责送货到我司指定仓库				
4.包装要求：中性包装，美国版本，产品保修一年					
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为012），如5月出货则是：1305012，同样不影响美观效果即可。','contact' => '高经理 13902828262','tel' => '0760-22602987','fax' => '0760-22613987','email' => '314257923@qq.com','contact_addr' => '广东省中山市东凤镇东凤大道南52号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '8.0','payment_period' => '3','status' => 'normal','qq' => '46020073','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '4','code' => 'YAA11013','name' => '东莞市伍胜塑胶电子有限公司','abbreviation' => '伍胜','categorys_id' => '1','location' => '','note' => '1、如无法按订单交期保质保量交付产品的，在7天以内的，按逾期订单金额实行折扣，折扣标准为每天1%（按天实行累计）；超过7天的，双方协商取消订单。
2.付款方式: 月结60天，开17%增值税发票，单价加8个点。有少量不含税，月底对账前核实. 如遇逾期交货，当月的付款也酌情延期。	
3.检验标准：输入端对输出端要求过高压3000V，有过流、过稳、欠压保护，出货要求全检验，用真机测试，外观符合要求 。		
4.包装要求：电源贴中性标签，采用气泡袋包装，配外纸箱包装，产品保修一年
5、所有产品型号,请加电源指示灯。		
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为013），如5月出货则是：1305013，同样不影响美观效果即可。','contact' => '蔡总13602337109','tel' => '0769-86957788','fax' => '0769-86957799','email' => '赵总kevin@dgysr.com  ','contact_addr' => '东莞市塘厦镇沙湖区葡萄路2号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '8.0','payment_period' => '60','status' => 'normal','qq' => '赵小姐 229549863','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '5','code' => 'YNT11014','name' => '深圳必联电子有限公司','abbreviation' => '必联','categorys_id' => '3','location' => '','note' => '1.交 货 期：请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担。								
2.付款方式:  货到验收合格7天内付款，（是否含税，付款前确定），如含税，开17%增值税发票。								
3、包装：带品牌标志的彩盒包装，需印有made in china 字样，英文版本，配光盘。		
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。						
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为014），如5月出货则是：1305014，同样不影响美观效果即可。','contact' => '周小姐 15112327322','tel' => '0755-28023441','fax' => '0755-28029002','email' => 'lefen15@lefen.net 吕小姐','contact_addr' => '深圳市宝安区观澜街道桔塘社区桔岭钟兴工业区B1栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '11.0','payment_period' => '7','status' => 'normal','qq' => '周小姐anlin326@126','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '6','code' => 'NPT11015','name' => '深圳市新发展宠物用品公司','abbreviation' => '新发展','categorys_id' => '8','location' => '','note' => '1.交 货 期：请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2.付款方式: 货到验收7天内付款至供应商美金账户，按付款当日汇率结算。							
4.包装要求：中性包装，外箱和内盒上需有made in china 字样。美国版本，产品保修一年			
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。				
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '滕媚 13670209086','tel' => '0755-29112919','fax' => '0755-29112919 ','email' => 'li13421320142@163.com','contact_addr' => '深圳市宝安33区瓦窑花园4巷5号A栋802','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '李先生411720434','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '7','code' => 'N2','name' => '维希照明','abbreviation' => '维希照明','categorys_id' => '2','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '8','code' => 'YCB11016','name' => '深圳市东景盛电子技术有限公司','abbreviation' => '东景盛','categorys_id' => '5','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2、包装要求：黑色不透明较厚的PE袋单个包装，加外纸箱，PE袋和外箱上请印上 made in China 和产品SKU编码以及装箱数量。							
3、产品请做好出厂全检，并协助做好商检							
4、如开17%的增值税发票，单价加10%
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '蒋小姐 13480124905','tel' => '0755-61503188-8853','fax' => '0755-27456160','email' => 'crystal@east-toptech.com','contact_addr' => '深圳市宝安区福永镇大洋开发区九区一号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '10.0','payment_period' => '30','status' => 'normal','qq' => '632872361','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '9','code' => 'YCR11017','name' => '深圳欧诺达电子有限公司','abbreviation' => '欧诺达','categorys_id' => '11','location' => '','note' => '1.交 货 期：请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担。							
2.付款方式: 交货后次月10日付款。开17%增值税发票.					
3.检验标准：出货要求全检验，产品保修一年。						
4.包装要求：黄皮纸盒包装，印有made in china 字样，美国版本说明书。    
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为017），如XX月出货则是：13XX017，同样不影响美观效果即可。','contact' => '徐冬妹 13724328044','tel' => '0755-29703420-820','fax' => '0755-29063486','email' => 'onuodaltd@163.com','contact_addr' => '深圳宝安西乡固戍航空路景福工业园D座三楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '10.0','payment_period' => '20','status' => 'normal','qq' => '徐小姐 1427022287','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '10','code' => 'YCB11018','name' => '深圳市佳信连接线材厂','abbreviation' => '佳信','categorys_id' => '5','location' => '','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2.付款方式:月结60天，如开增值税发票，单价加10个点		
3、产品请做好出厂全检，气泡袋散装加外包装纸箱。		
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '饶先生 15899854439','tel' => '0755-83030411','fax' => '0755-83030411','email' => 'lisazxj@126.com；1401429460@qq.com','contact_addr' => '深圳市龙岗区坂田街道办马安堂社区侨联东（九巷一号）202','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '10.0','payment_period' => '60','status' => 'normal','qq' => '饶生1401429460','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '11','code' => 'NPK11019','name' => '深圳市佳杰印刷厂','abbreviation' => '佳杰','categorys_id' => '4','location' => '','note' => '1.按订单数量总数的0.3%送备品
2.付款条件：月结30天。
3.请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担	
','contact' => '陈小姐 15012816991','tel' => '0755-84165293','fax' => '0755-82266187','email' => '1561302150@qq.com ；','contact_addr' => '深圳市坂田镇河背村国成工业区三/六楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '8','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '陈小姐136073177','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '12','code' => 'N3','name' => '华锋达','abbreviation' => '华锋达','categorys_id' => '4','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2.每款请提供5个备品。							
3、检验标准：外观无破损，需印有made in china 字样，印字清晰。							
','contact' => '陶先生 13724333589','tel' => '0755-27791379','fax' => '0755-27903736','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '13','code' => 'YAA11020','name' => '东莞市顺杰电子有限公司','abbreviation' => '顺杰','categorys_id' => '1','location' => '','note' => '1、如无法按订单交期保质保量交付产品的，在7天以内的，按逾期订单金额实行折扣，折扣标准为每天1%（按天实行累计）；超过7天的，双方协商取消订单。
2.付款方式: 月结90天，开17%增值税发票，单价加8个点。如逾期交货，当月的付款也酌情延期。		
3.检验标准：输入端对输出端要求过高压3000V，有过流、过稳、欠压保护，出货要求全检验，用真机测试，外观符合要求 。		
4.包装要求：电源贴中性标签，采用气泡袋包装，配外纸箱包装，产品保修一年。		
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。
6、所有产品型号,请加电源指示灯，另提供千分之三的备品。		
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为020），如5月出货则是：1305020，同样不影响美观效果即可。','contact' => '王先生  1867691318','tel' => '0769-87893698','fax' => '0769-87890398','email' => '1355963719@qq.com','contact_addr' => '东莞市清溪镇土桥村委会老围村清凤路旁','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '8.0','payment_period' => '90','status' => 'normal','qq' => '王经理470927510','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '14','code' => 'N4','name' => 'JGG','abbreviation' => 'JGG','categorys_id' => '1','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '15','code' => 'N5','name' => '斯格','abbreviation' => '斯格','categorys_id' => '1','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '16','code' => 'YSV11021','name' => '深圳市普顺达科技有限公司','abbreviation' => '普顺达','categorys_id' => '9','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2、彩盒包装，加外纸盒，内箱和外箱上需贴有made in china 字样。							
3、产品请做好出厂全检，产品保修一年。							
4、开17%的增值税发票，加8个点。（开票数量月底对账时确定）							
5、付款方式：月结20天(次月20日付款）
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为021），如XX月出货则是：13XX021，同样不影响美观效果即可。','contact' => '钟小姐 15012566923','tel' => '0755-86976069 ','fax' => '0755-27960501','email' => 'sales-c5@easyn.cn','contact_addr' => '深圳市宝安区西乡铁岗兴发工业区1栋4楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '8.0','payment_period' => '20','status' => 'normal','qq' => '1043952649','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '17','code' => 'YAA11022','name' => '深圳市格瑞尔电子有限公司','abbreviation' => '格瑞尔','categorys_id' => '1','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2.检验标准：输入端对输出端要求过高压3000V，有过流、过稳、欠压保护，出货要求全检验，用真机测试，外观符合要求 。							
3.包装要求：电源贴中性标签，采用气泡袋包装，配外纸箱包装，产品保修一年。							
4、所有产品型号,请加电源指示灯。							
5、供方负责到我司指定的深圳市内仓库的快递费用。							
6、款到发货，如含税报价，需开17%的增值税发票。							
7、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
8、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
9、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '陈小姐','tel' => '0755-89452966-813','fax' => '0755-89452809','email' => '0','contact_addr' => '深圳龙岗龙东社区南通道利好工业园18栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '8.0','payment_period' => '0','status' => 'normal','qq' => '小吕  762865129','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '18','code' => 'N6','name' => '华强北','abbreviation' => '华强北','categorys_id' => '6','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '19','code' => 'N7','name' => '丽世宏洋','abbreviation' => '丽世宏洋','categorys_id' => '1','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '20','code' => 'YTT11023','name' => '深圳市欣宝瑞仪器有限公司','abbreviation' => '欣宝瑞','categorys_id' => '7','location' => '','note' => '1、交 货 期：请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担。							
2、付款方式:  月结30天。							
3、检验标准：出货要求全检验，外观符合要求 。							
4、包装要求：中性包装，外箱和内盒上需有made in china 字样,外箱还需有产品SKU以及数量，美国版本，产品保修一年。							
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为023），如5月出货则是：1305023，同样不影响美观效果即可。','contact' => '万先生 13418683633','tel' => '0755-27863686','fax' => '0755-27863682','email' => 'sales@chinasampo.cn','contact_addr' => '深圳市宝安区宝城43区新厂房3栋3楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '10.0','payment_period' => '30','status' => 'normal','qq' => '1010201885','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '21','code' => 'N8','name' => '深圳远通','abbreviation' => '深圳远通','categorys_id' => '1','location' => '','note' => 'USB CDROM','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '8','discount_rate' => '0.0','payment_period' => '30','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '22','code' => 'N9','name' => '库存期初','abbreviation' => '库存期初','categorys_id' => '0','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '23','code' => 'N10','name' => '深圳市宇豪电热制品有限公司','abbreviation' => '宇豪','categorys_id' => '5','location' => '','note' => '（恒利德）','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '24','code' => 'YTT11024','name' => '杭州华谊电子实业有限公司','abbreviation' => '华谊','categorys_id' => '7','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担。							
2、付款方式: 货到后次月底前付款。							
3、彩盒加外纸箱包装，需印有made in china 字样，英文版本说明书。							
4、产品请做好出厂全检，产品保修一年。							
5、开17%的增值税发票
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为024），如5月出货则是：1305024，同样不影响美观效果即可。','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '浙江省杭州市文三路498号天苑花园2幢9楼B','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '25','code' => 'NSV11025','name' => '东莞市天虎科技有限公司','abbreviation' => '天虎','categorys_id' => '18','location' => '','note' => '1.交 货 期：请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2.付款方式:  货到验收合格五天内付款。							
3.检验标准：出货要求全检验，外观符合要求 。							
4.包装要求：中性包装，贴有made in china 字样，带光盘、英文版本说明书，产品保修一年							
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为025），如XX月出货则是：13XX025，同样不影响美观效果即可。','contact' => '冯先生 15602600963','tel' => '0769－22606700','fax' => '0769－89026480','email' => '3636655@qq.com','contact_addr' => '广东省东莞市东城樟村罗塘工业区5号7栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '3','status' => 'normal','qq' => '3636655','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '26','code' => 'N11','name' => 'Fiyyaz','abbreviation' => 'Fiyyaz','categorys_id' => '0','location' => 'TX 77477','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '27','code' => 'YSV11026','name' => '深圳市联益达科技有限公司','abbreviation' => '联益达','categorys_id' => '9','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2、产品品牌为LYD，中性包装，彩盒和外包装箱上需有made in china 字样。							
3、产品请做好出厂全检，产品保修一年。							
4，如含税报价，开17%的增值税发票.							
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '钟先生 13751105361','tel' => '0755-28066615','fax' => '0755-28066085','email' => '0','contact_addr' => '宝安区龙华镇油松水斗老围工业区A栋3楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '8.0','payment_period' => '0','status' => 'normal','qq' => '28747515','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '28','code' => 'YSV13087','name' => '深圳市福智达电子有限公司','abbreviation' => '福智达','categorys_id' => '9','location' => '','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修一年。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
      贵司供应商代码为087，比如XX年XX月份交货的，出货的产品代码为XXXX087，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）
7.付款方式：50%预付，50%月结45天','contact' => '匡小姐13410073970','tel' => '0755-26720367','fax' => '','email' => 'sales15@foscam.com；sales6@foscam.com','contact_addr' => '深圳市南山区高新南九道9号威新软件科技园2号楼5层西翼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '8.0','payment_period' => '0','status' => 'normal','qq' => '1109843739','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '29','code' => 'MSV11027','name' => '深圳市华格特电子有限公司','abbreviation' => '华格特','categorys_id' => '9','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2、产品品牌为LYD，中性包装，内盒和外包装需有made in China 字样。							
3、产品请做好出厂全检，产品保修一年。							
4、先付30%订金，款到发货
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '林小姐13410443626','tel' => '0755-82863012','fax' => '0755-82959139','email' => 'sales006@vangold.cn','contact_addr' => '深圳市光明新区光明街道甲子塘社区得富利第二工业区1栋5楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '1349484563','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '30','code' => 'N12','name' => '恒利德','abbreviation' => '恒利德','categorys_id' => '6','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '8','discount_rate' => '0.0','payment_period' => '30','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '31','code' => 'NVG11028','name' => '深圳纳达电子有限公司','abbreviation' => '纳达','categorys_id' => '10','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2、付款方式: 货到付款							
3、中性纸盒包装，印有made in china 字样，英文版本说明书							
4、产品请做好出厂全检，产品保修一年
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为028），如5月出货则是：1305028，同样不影响美观效果即可。','contact' => '赖小姐  1355686668','tel' => '0755-61361689','fax' => '0755-61361689','email' => '0','contact_addr' => '新国亚二期国利大厦','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '赖S 1244139709','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '32','code' => 'N13','name' => '东莞市林安电子有限公司','abbreviation' => '林安','categorys_id' => '1','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '8','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '33','code' => 'N14','name' => 'Sunvalleytek International Inc','abbreviation' => 'Sunvalleytek','categorys_id' => '1','location' => 'US','note' => 'We used to be their dropshipper.','contact' => 'Jenny','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '10','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '34','code' => 'N15','name' => '深圳祥泰有限公司','abbreviation' => '祥泰','categorys_id' => '2','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2、产品质量按原来要求，黄皮纸盒、中性包装，印有made in china 字样。
3、产品请做好出厂全检							
','contact' => '王经理 13828773376','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '35','code' => 'N16','name' => 'Williamsons, Inc.','abbreviation' => 'Williamsons','categorys_id' => '6','location' => 'US','note' => 'Supplier for \\"The Reindeer Decoration for Cars\\".','contact' => 'Sue Williamson ','tel' => '610-850-5400','fax' => '','email' => 'info@williamsonsprod','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '1','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '36','code' => 'NCP11029','name' => '明虹通讯','abbreviation' => '明虹通讯','categorys_id' => '6','location' => '','note' => '','contact' => '张演民 13632983089','tel' => '','fax' => '0755-82796507','email' => '0','contact_addr' => '深圳市华强北路通讯市场2楼A258','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '37','code' => 'N17','name' => '不含税仓','abbreviation' => '不含税仓','categorys_id' => '0','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '38','code' => 'N18','name' => '裕同电子有限公司','abbreviation' => '裕同','categorys_id' => '0','location' => '','note' => 'lamp','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '39','code' => 'N19','name' => '库存调整','abbreviation' => '库存调整','categorys_id' => '6','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '40','code' => 'NTB11030','name' => '深圳市卓尼斯科技有限公司','abbreviation' => '卓尼斯','categorys_id' => '12','location' => '','note' => '1.交 货 期：请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担.							
2.付款方式: 款到发货.							
3.自提或者发国内快递，我方承担运费							
4.包装要求：中性包装，外包装和彩盒上要有made in china 字样。美国版本，产品保修一年.		
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。					
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '徐小姐 13428967130','tel' => '0755-86119766','fax' => '0755-86119733','email' => '0','contact_addr' => '深圳市安南山区麻雀岭工业区M-3栋2楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '1583461049','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '41','code' => 'NPC11031','name' => '翔辉科技（香港）有限公司','abbreviation' => '翔辉','categorys_id' => '13','location' => '','note' => '1、keyboard layout；US。							
2、manual,Giftbox,Sticker according to the email and MSN message.							
3、15 months warranty.							
4、内盒和外箱要贴有made in china 字样							
5、货到付款
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为031），如5月出货则是：1305031，同样不影响美观效果即可。','contact' => '廖小姐15814400382 ','tel' => '0755-29360362','fax' => '0755-29360353','email' => '0','contact_addr' => '西乡固戍二路时代科创中心609','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '廖S 1551432965','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '42','code' => 'NCR11032','name' => '深圳市车龙电子科技有限公司','abbreviation' => '车龙','categorys_id' => '11','location' => '','note' => '出美国车载DVD region的设定界面要默认为region 1 。
1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2、产品请做好出厂全检，保修一年。							
3、每套：888C DVD430元+红外耳机60元+20元红外遥控手柄；每对彩盒包装，每三对加外纸箱包装，耳机和手柄请装入每对纸箱，彩盒和外包装箱需有made in china 字样。							
4.付款方式: 供应商送货上门，收货方清点后，付款至供应商美金账户，付款汇率以当日美金基准价为折算标准，余款10万RMB20天后付清。			
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。		
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为032），如XX月出货则是：13XX032，同样不影响美观效果即可。','contact' => '李小姐 13682203388','tel' => '13682203388','fax' => '020-28242022','email' => 'chelongchina@126.com','contact_addr' => '广州市永福路倚云汽车用品广场A114-A115','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '190714796','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '43','code' => 'YAA11033','name' => '广州斯泰克电子科技有限公司','abbreviation' => '斯泰克','categorys_id' => '1','location' => '番禺区东涌区太石工业区标准工业园2栋','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2.检验标准：输入端对输出端要求过高压3000V，有过流、过稳、欠压保护，出货要求全检验，用真机测试，外观符合要求 。							
3.包装要求：电源贴中性标签，采用气泡袋包装，配外纸箱包装，产品保修一年。							
4、所有产品型号,请加电源指示灯。							
5、开17%的增值税发票，月结90天（有少量不含税，在月底对账前确定具体开票数量）
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为033），如XX月出货则是：13XX033，同样不影响美观效果即可。','contact' => '黄小姐13825237457','tel' => '0755-83030247','fax' => '020-34925825','email' => 'ht8@gzstiger.com','contact_addr' => '广州市番禺区东涌镇太石村标准工业园厂房2号1-3层、7号首层','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '8.0','payment_period' => '60','status' => 'normal','qq' => '黄小姐 179585549','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '44','code' => 'N20','name' => '德国高科集团','abbreviation' => '德国高科','categorys_id' => '0','location' => '德国','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '45','code' => 'N21','name' => 'Micmac-Computers','abbreviation' => 'Micmac','categorys_id' => '0','location' => '荷兰','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '46','code' => 'N22','name' => '朱运生-自用','abbreviation' => '自用','categorys_id' => '0','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '47','code' => 'N23','name' => '广州杨生','abbreviation' => '广州杨生','categorys_id' => '0','location' => '广州','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '48','code' => 'MTT11034','name' => 'Sinometer','abbreviation' => '仪华','categorys_id' => '7','location' => '','note' => '说明：						
1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担。						
2.付款方式: 先支付30%订金，款到发货						
3、彩盒加外纸箱包装，内盒和外箱需印有made in chian 字样，英文版本说明书。						
4、产品请做好出厂全检，产品保修一年。						
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为034），如5月出货则是：1305034，同样不影响美观效果即可。','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => 'Room 2410 and 2411','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '49','code' => 'N24','name' => '深圳凯普特电子有限公司','abbreviation' => '凯普特','categorys_id' => '6','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '50','code' => 'NPC11035','name' => '深圳锐爱科技有限公司','abbreviation' => '锐爱','categorys_id' => '13','location' => '','note' => '1、keyboard layout 见描述。							
2、manual,Giftbox,Sticker according to the email and MSN message.							
3、15 months warranty.							
4、内盒和外箱要贴有made in china 字样		
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可
8、付款方式: 月结30天。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为035），如5月出货则是：1305035，同样不影响美观效果即可。','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => 'Room1320','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '51','code' => 'NCP11036','name' => '深圳华裕工具行','abbreviation' => '华裕','categorys_id' => '6','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2、付款方式: 供应商送货上门，收货方清点后付款							
3、要统一包装，工具中包含五角星螺丝刀头
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '陈小姐 13902989101','tel' => '0755-82533791  ','fax' => '','email' => '','contact_addr' => '华强北路赛格通信市场二楼2A25号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '52','code' => 'N25','name' => '深圳市国邦兴业电子有限公司','abbreviation' => '国邦','categorys_id' => '12','location' => '	','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2.检验标准：所有产品要求全检出货，英文说明书，一年保修							
3.包装要求：中性包装，内盒和外箱有made in china 字样							
4、送至供应商指定地点，运费供方付			
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。				
6、如含税报价，开17%的增值税发票							
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '陈程 15817316140','tel' => '0755-28302769  	','fax' => '0755-28301735','email' => '','contact_addr' => '深圳市布吉镇李朗大道联创科技园4栋5楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '53','code' => 'N26','name' => 'Ebundle','abbreviation' => 'Ebundle','categorys_id' => '0','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '54','code' => 'N27','name' => 'Central Computers','abbreviation' => 'Central','categorys_id' => '5','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '55','code' => 'NDR11037','name' => '深圳市创新科技有限公司','abbreviation' => '创新','categorys_id' => '2','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2、产品质量按原来要求，黄皮纸盒、中性包装，有made in china 标签
3、产品请做好出厂全检，质保1年					
4、供应商负责送货，收货方清点后付款，货到三天
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '李英  13715375395','tel' => '0755-83334501 ','fax' => '','email' => '','contact_addr' => '深圳市福田区华强电子世界2号楼23C213','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '56','code' => 'NHG11038','name' => '北京旭能阳光科技有限公司','abbreviation' => '旭能','categorys_id' => '15','location' => '','note' => '1.请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2.彩盒包装，内附英文说明书，保修1年							
3.供方负责到我司指定的深圳市内仓库的快递费用。							
4.款到发货							
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为038），如5月出货则是：1305038，同样不影响美观效果即可。','contact' => '周先生 13601327260','tel' => '010-57227906','fax' => '010-57202207','email' => '0','contact_addr' => '北京市朝阳区百子湾大成国际中心3号楼B座1907室','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '王先生860882623','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '57','code' => 'YCB11039','name' => '东莞翰云五金塑胶有限公司 ','abbreviation' => '翰云','categorys_id' => '5','location' => '东莞','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2、PE袋加外纸箱包装，PE袋和外箱上请印上 made in China 字样。							
3、产品请做好出厂全检，并协助做好商检							
4、开17%的增值税发票
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '刘总 13509843853','tel' => '0769-82025941','fax' => '0769-82025940','email' => '0','contact_addr' => '东莞市黄江镇田心村聚龙工业园A龙','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '8.0','payment_period' => '30','status' => 'normal','qq' => '2217663793','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '58','code' => 'N28','name' => '深圳市震韩电子科技有限公司','abbreviation' => '震韩','categorys_id' => '5','location' => '','note' => '','contact' => '李小姐 13430931864','tel' => '0755-27947259','fax' => '0755-27947408','email' => '','contact_addr' => '深圳市宝安区西乡镇流塘大厦1807室','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '8','discount_rate' => '0.0','payment_period' => '30','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '59','code' => 'N29','name' => '金鹏腾包装制品有限公司','abbreviation' => '金鹏腾','categorys_id' => '4','location' => '','note' => '','contact' => '郑先生13590375963','tel' => ' 0755-28659778','fax' => '0755-84260623','email' => '','contact_addr' => '深圳市龙岗区横岗镇大康莘唐工业区龙兴路11号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '60','code' => 'N30','name' => '深圳市麦恩科技有限公司','abbreviation' => '麦恩','categorys_id' => '2','location' => '','note' => '1.交 货 期：请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担。							
2.付款方式: 款到发货；如果供方产品与我司摄像头不匹配，三天内全额退款至我司。						
3.检验标准：出货要求全检验，产品保修一年。							
4.包装要求：配件齐全，美国版本说明书。    
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '唐誉珈  1371391021','tel' => '0755-83281889-8120','fax' => '0755-83048160','email' => '','contact_addr' => '深圳市福田区华强北路现代之窗','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '61','code' => 'YVG11040','name' => '深圳市捷锐泓电子有限公司','abbreviation' => '捷锐','categorys_id' => '10','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2、产品请做好出厂全检，保修一年。							
3、每单个产品上需有made in china 字样。
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可
7、付款方式: 供应商负责送货，月结30天（货到第二个自然月结束前付款），含税单价加9个点，收到开票合同后在当月完成开票，发票及合同盖章原件回寄我司	。
8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为040），如5月出货则是：1305040，同样不影响美观效果即可。	','contact' => '蔡小姐 13418981084','tel' => '','fax' => '0755-29552319 ','email' => 'c13418981084@163.com','contact_addr' => '宝安沙井马安山第一工业区第五栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '9.0','payment_period' => '20','status' => 'normal','qq' => '蔡小姐 13418981084','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '62','code' => 'NCP11041','name' => '深圳市保实丰电子有限公司','abbreviation' => '保实丰','categorys_id' => '6','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2、产品请做好出厂全检，保修一年。							
3、每单个产品上需有made in china 字样。							
4.付款方式: 供应商负责送货，收货方清点后付款
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '吴小姐 13417340927','tel' => '0755-33552510  ','fax' => '0755-82595096','email' => '0','contact_addr' => '深圳市宝安区观澜大道田背花园H单元1301','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '小吴948163272','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '63','code' => 'NCP11042','name' => '深圳市康和力电子有限公司','abbreviation' => '康和力','categorys_id' => '6','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2、检验标准：所有产品全检后出货，产品保修一年						
3、包装要求：PE袋中性包装，PASS标										
4、付款方式：电源月结60天，其他月结30天
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9，单个产品货起单个包装上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为042），如XX月出货则是：13XX042，同样不影响美观效果即可。','contact' => '刘奎 13922805676','tel' => '0755-28401695 ','fax' => '0755-28401683','email' => 'kandl0401@yahoo.cn','contact_addr' => ' 深圳市龙岗区宝龙一路 留学生产业园8栋4楼 ','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '30','status' => 'normal','qq' => '刘总466902314','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '64','code' => 'YCR11043','name' => '深圳市路安宝电子有限公司','abbreviation' => '路安宝','categorys_id' => '11','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2、如我司定制品牌之产品需严格按照确认样板做。彩盒包装，加外纸盒，内箱和外箱上需贴有made in china 字样。							
3、产品请做好出厂全检，产品保修一年。							
4、开17%的增值税发票，加9个点。（开票数量月底对账时确定）							
5、付款方式：月结30天
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为043），如XX月出货则是：13XX043，同样不影响美观效果即可。','contact' => '朱燕 13802210103','tel' => '0755-84190683','fax' => '','email' => '2355839630@qq.com','contact_addr' => '深圳市光明新区公明街道合水口社区第四工业区A3号02动3楼8区','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '9.0','payment_period' => '27','status' => 'normal','qq' => '1531824532','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '65','code' => 'YOF11044','name' => '珠海市华尚光电科技有限公司','abbreviation' => '华尚光电','categorys_id' => '16','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2、彩盒包装，加外纸盒，内箱和外箱上需贴有made in china 字样
3、包装外箱上还需标明SKU（我司产品编码），装箱数量						
4、产品请做好出厂全检，产品保修一年
5、开17%的增值税发票，加6个点（开票数量月底对账时确定）
6、付款方式：款到发货
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
  贵司供应商代码为044，比如XX年XX月份交货的，出货的产品代码为XXXX044，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '胡志彬  1365143374','tel' => '0755-83987731','fax' => '0755-83987731','email' => 'jerry@farsun.cn','contact_addr' => '珠海市金湾区三灶镇恒辉路6号A栋厂房2-1','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '6.0','payment_period' => '0','status' => 'normal','qq' => '345375228','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '66','code' => 'NCB11045','name' => '辉瑞配件','abbreviation' => '辉瑞配件','categorys_id' => '5','location' => '','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货	
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '李培辉 13510907710','tel' => '','fax' => '','email' => '0','contact_addr' => '深圳市深南中路通天地通讯市场A178 ','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '李先生171153554','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '67','code' => 'N31','name' => 'MegaWatts Computers, LLC','abbreviation' => 'MegaWatts','categorys_id' => '1','location' => 'U.S.A','note' => '','contact' => 'Doug Watts','tel' => '918-664-6342','fax' => '','email' => 'doug@megawatts.com','contact_addr' => '','delivery_addr' => '3501 South Sheridan Road, Tulsa, OK 74145','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '6','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '68','code' => 'N32','name' => 'Southern Computer Repair, Inc.','abbreviation' => 'Southern','categorys_id' => '1','location' => 'U.S.','note' => '','contact' => 'Bob Mc Millan','tel' => '770-904-5810*351','fax' => '','email' => 'bob_mcmillan@scrpart','contact_addr' => '','delivery_addr' => '500 Satellite Blvd, NW Suite E,Suwanee, GA 30024','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '69','code' => 'NAA11046','name' => '深圳市富高盈电子有限公司','abbreviation' => '富高盈','categorys_id' => '1','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、检验标准：输入端对输出端要求过高压3000V，有过流、过稳、欠压保护，出货要求全检验，用真机测试，外观符合要求 					
3、包装要求：电源贴中性标签，采用气泡袋包装，配外纸箱包装，产品保修一年						
4、所有产品型号,请加电源指示灯
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、付款方式:货到付款
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为046），如5月出货则是：1305046，同样不影响美观效果即可。','contact' => '陈锐添13480814231','tel' => '0755-33093396','fax' => '','email' => '0','contact_addr' => '宝安区石岩镇洲石路梨园工业园B栋2楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '陈先生 1015798976','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '70','code' => 'MPC11047','name' => 'DYGJ','abbreviation' => 'DYGJ','categorys_id' => '13','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '0','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '71','code' => 'NPK11048','name' => '深圳市万飞达纸品包装有限公司','abbreviation' => '万飞达','categorys_id' => '4','location' => '','note' => '1.请按质按量，如期交货。
2.付款条件：月结30天。','contact' => '郑先生13590375963','tel' => '0755-98731981','fax' => '0755-89731983','email' => '407503976@qq.com','contact_addr' => '深圳市龙岗区横岗六约六和路22号三栋厂房一楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '8','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '郑先生407503976','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '72','code' => 'MAA11049','name' => 'YZDY1','abbreviation' => 'YZDY1','categorys_id' => '19','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '0','contact_addr' => '','delivery_addr' => 'HK仓库','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '73','code' => 'NSV11050','name' => '深圳市威视达康科技有限公司','abbreviation' => '威视达康','categorys_id' => '9','location' => '','note' => '1.交 货 期：请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担.							
2.付款方式:货到30天					
3.供应商负责送货到我司指定仓库.							
4.包装要求：按照我司Esky品牌要求包装
5.包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6.发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8.出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
  贵司供应商代码为050，比如XX年XX月份交货的，出货的产品代码为XXXX050，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '黄永涛18675512078','tel' => '0755-26736182','fax' => '0755-26736182-804','email' => 'sales5@vstarcam.com','contact_addr' => '深圳市宝安区石岩镇洲石路万大工业区F栋5楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '9.0','payment_period' => '30','status' => 'normal','qq' => '2273040974','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '74','code' => 'NAA11051','name' => '深圳市奥强电源有限公司','abbreviation' => '奥强','categorys_id' => '1','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:预付30%，提货前付余款
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '彭忠博15976857622','tel' => '0755 -36638252','fax' => '0755-27921880','email' => 'wangabc1212@qq.com','contact_addr' => '深圳市宝47区 富源海滨工业区','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '1831855115','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '75','code' => 'MPC11052','name' => 'SHJL','abbreviation' => 'SHJL','categorys_id' => '13','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '0','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '76','code' => 'NHG11053','name' => '深圳市宇丰达光电有限公司','abbreviation' => '宇丰达','categorys_id' => '15','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:货到付款
3、产品请做好出厂全，每款加送3%备品，不良比例若超出5%，需如数补货
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为053），如5月出货则是：1305053，同样不影响美观效果即可。','contact' => '陈__13924588177','tel' => '0755-27661015','fax' => '0755-27661016','email' => '511581555@qq.com','contact_addr' => '深圳宝安71区留仙二路江南百货6楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '陈小姐511581555','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '77','code' => 'NAT11054','name' => '中山市杰霸电器有限公司','abbreviation' => '杰霸','categorys_id' => '14','location' => '中山市','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:预付30%，提货前付余款
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '周小姐13925308301','tel' => '0760-22265299','fax' => '0760 22836817','email' => '0','contact_addr' => '广东省中山市小榄镇_西一广丰北路121号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '424272820','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '78','code' => 'NHG11055','name' => '深圳市广百思科技有限公司','abbreviation' => '广百思','categorys_id' => '15','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '李永昌13310843453','tel' => '0755 82055658','fax' => '0755 82053969','email' => '0','contact_addr' => '深圳福田区八卦四路5号索泰克大厦4楼W区','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '1401919742','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '79','code' => 'N33','name' => '深圳市赛特莱特科技有限公司','abbreviation' => '赛特莱特','categorys_id' => '10','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:预付20%，提货前付余款
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '邓桂荣13510560140','tel' => '','fax' => '0755 27186411','email' => '','contact_addr' => '深圳市宝安区观兰镇第三工业区观中街7号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '80','code' => 'NOF11056','name' => '深圳市富喆科技有限公司','abbreviation' => '富_','categorys_id' => '16','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '袁旭15889297136','tel' => '0755-84528255-805','fax' => '0755 84528390','email' => '5917110@qq.com','contact_addr' => '深圳市龙岗区坂田元征工业园','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '袁先生 5917110','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '81','code' => 'N34','name' => '深圳市福田区中电信息时代广场亿惠电子经营部','abbreviation' => '中电信息','categorys_id' => '5','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '邱泽斌13713785260','tel' => '','fax' => '','email' => '','contact_addr' => '深圳市福田区华强北龙胜手机批发市场3楼383','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '82','code' => 'N35','name' => '深圳市华创信电子有限公司','abbreviation' => '华创信','categorys_id' => '0','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:预付30%，提货前付余款
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '范小姐13544240661','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '83','code' => 'NHG11057','name' => '东莞市常平爱迪电子厂','abbreviation' => '爱迪','categorys_id' => '15','location' => '东莞','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为057），如5月出货则是：1305057，同样不影响美观效果即可。','contact' => '李先生13600243205','tel' => '','fax' => '','email' => '0','contact_addr' => '东莞常平镇环城北路苏坑工业园','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '53851401','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '84','code' => 'YSV11058','name' => '深圳市慧眼视讯电子有限公司','abbreviation' => '慧眼','categorys_id' => '9','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:月结30天
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
  贵司供应商代码为058，比如XX年XX月份交货的，出货的产品代码为XXXX058，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '刘文辉18665355798','tel' => '18665355798','fax' => '0755 89390380','email' => 'sales@sznv.net','contact_addr' => '深圳市坂田上雪科技城北区6号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '10.0','payment_period' => '30','status' => 'normal','qq' => '272012419','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '85','code' => 'NHG11059','name' => '英飞特电子（杭州）股份有限公司','abbreviation' => '英飞特','categorys_id' => '15','location' => '浙江杭州','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:月结30天
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为059），如5月出货则是：1305059，同样不影响美观效果即可。','contact' => '邓先生 18758013069','tel' => '0571-56565866 ','fax' => '0571-86601139','email' => '0','contact_addr' => '浙江省杭州市滨江区六和路368号海创基地北区3楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '30','status' => 'normal','qq' => '549695919','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '86','code' => 'NTT11060','name' => '深圳华谊仪表有限公司','abbreviation' => '深圳华谊','categorys_id' => '7','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '江闯 13682532582','tel' => '0755-83766667','fax' => '0755-83766510','email' => '0','contact_addr' => '深圳华强北赛格科技园三栋西九楼C','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '416683683','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '87','code' => 'YCB11061','name' => '海能电子（深圳）有限公司','abbreviation' => '海能','categorys_id' => '5','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '李宏斌13902964360','tel' => '','fax' => '','email' => '0','contact_addr' => '深圳市宝安区沙井镇共和村丽城工业园M栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '12.0','payment_period' => '0','status' => 'normal','qq' => '854108628','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '88','code' => 'N36','name' => '深圳市磁展悬浮科技有限公司','abbreviation' => '磁展悬浮','categorys_id' => '0','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '周维波15817225659','tel' => '0755-61157886 ','fax' => '0755-61157787','email' => '','contact_addr' => '深圳市宝安区福永镇桥南新区136栋811-812','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '89','code' => 'MTT11062','name' => '东莞华仪仪表科技有限公司','abbreviation' => '东莞华仪','categorys_id' => '7','location' => '东莞','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为062），如5月出货则是：1305062，同样不影响美观效果即可。','contact' => '涂先生13560893631','tel' => '0769-81901614','fax' => '','email' => 'sale1@mastech.cn','contact_addr' => '东莞市清溪镇渔梁围工业区','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '535770224','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '90','code' => 'MPC12063','name' => 'XGTY','abbreviation' => 'XGTY','categorys_id' => '13','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '0','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '91','code' => 'YSV12064','name' => '深圳市联缘达科技有限公司','abbreviation' => '联缘达','categorys_id' => '9','location' => '深圳','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2、产品品牌为LYD，中性包装，彩盒和外包装箱上需有made in china 字样。							
3、产品请做好出厂全检，产品保修一年							
4、如含税报价，开17%的增值税发票
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
  贵司供应商代码为064，比如XX年XX月份交货的，出货的产品代码为XXXX064，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '钟先生13751105361','tel' => '0755-28065142','fax' => '','email' => '28747515@qq.com','contact_addr' => '深圳市宝安区龙华街道油松社区水斗老围村一区27号3楼302','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '8.0','payment_period' => '0','status' => 'normal','qq' => '28747515','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '92','code' => 'NHG12065','name' => '深圳市诚信神火科技有限公司','abbreviation' => '诚信神火','categorys_id' => '15','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为065），如5月出货则是：1305065，同样不影响美观效果即可。','contact' => '肖小姐13410152761','tel' => '0755 84617577','fax' => '','email' => '1050798539@qq.com','contact_addr' => '深圳龙岗龙西富民路236号A栋一楼','delivery_addr' => '','delivery_addr_ext' => '深圳市龙岗区龙城街道龙西社区富民路236号B栋3楼','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '9.0','payment_period' => '0','status' => 'normal','qq' => '1050798539','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '93','code' => 'NHG12066','name' => '中山市艾威尼节能照明有限公司','abbreviation' => '艾威尼','categorys_id' => '15','location' => '中山市','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为066），如5月出货则是：1305066，同样不影响美观效果即可。','contact' => '曾小姐15917246769','tel' => '0760 23651988','fax' => '0760 23651989','email' => '0','contact_addr' => '广东中山市古镇镇曹三创业园华盛东路南三路4号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '526810236','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '94','code' => 'YPC12067','name' => '深圳市天下鑫集采科技有限公司','abbreviation' => '天下鑫','categorys_id' => '13','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为067），如5月出货则是：1305067，同样不影响美观效果即可。','contact' => '罗先生13603097248','tel' => '0755 83763203','fax' => '0755 86644216','email' => '168121018@qq.com','contact_addr' => '深圳市南山区南山大道3838号设计产业园金栋201-206','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '168121018','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '95','code' => 'MTT12068','name' => '深圳市德与辅科技有限公司','abbreviation' => '德与辅','categorys_id' => '7','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为068），如5月出货则是：1305068，同样不影响美观效果即可。','contact' => '孙先生13423822943','tel' => '0755 89603760','fax' => '0755 84192557','email' => '1281342846@qq.com','contact_addr' => '深圳市龙岗区五和南路和勘工业区B1栋3楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '1281342846','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '96','code' => 'YCB12069','name' => '安福县海能实业有限公司','abbreviation' => '海能','categorys_id' => '5','location' => '江西吉安','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）。
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '李宏斌13902964360','tel' => '0796-7551168','fax' => '','email' => '0','contact_addr' => '江西省吉安市安福县工业园','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '854108628','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '97','code' => 'NPK12070','name' => '深圳市新宏远包装制品有限公司','abbreviation' => '新宏远','categorys_id' => '4','location' => '','note' => '1.请按质按量，如期交货;
2.印我司指定LOGO,交货需与样品一致，否则拒收;
3.付款条件：当月结。','contact' => '杨先生','tel' => '0755-36813776/135306','fax' => '0755-29574172','email' => '862389607@qq.com','contact_addr' => '深圳市龙华新区潭罗华侨新村','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '862389607','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '98','code' => 'MSV12071','name' => '深圳市安斯尔科技有限公司','abbreviation' => '安斯尔','categorys_id' => '9','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
  贵司供应商代码为071，比如XX年XX月份交货的，出货的产品代码为XXXX071，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '张小姐13798267665','tel' => '13798267665','fax' => '','email' => '1597234285@qq.com','contact_addr' => '深圳市宝安区西乡黄田三力工业园6栋','delivery_addr' => '深圳市福田区华强北汇通安防市场A127号','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '1597234285','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '99','code' => 'NHG12072','name' => '深圳长基科技开发有限公司','abbreviation' => '长基','categorys_id' => '15','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上标贴标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的包装贴上产品SKU，made in china，及贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为072），如5月出货则是：1305072，同样不影响美观效 果即可。
','contact' => '葛小姐13923794756','tel' => '0755-88840309','fax' => '0755-28411180','email' => '362110813@qq.com','contact_addr' => '深圳市龙岗区布吉布澜路甘李工业区科伦特科技园3号厂房5楼 ','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '362110813','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '100','code' => 'NHG12073','name' => '深圳市菲科科技有限公司','abbreviation' => '菲科','categorys_id' => '15','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为073），如5月出货则是：1305073，同样不影响美观效果即可。','contact' => '陈立娟13640920145','tel' => '0755-61557192','fax' => '','email' => 'fetin88@foxmail.com','contact_addr' => '深圳市宝安区福永新和华丽工业园9栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '1390650412','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '101','code' => 'NHG12074','name' => '中山市香江灯饰电器有限公司','abbreviation' => '香江灯饰','categorys_id' => '15','location' => '中山市','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为074），如5月出货则是：1305074，同样不影响美观效果即可。','contact' => '毛江玲13924939805','tel' => '','fax' => '','email' => '0504122@163.com','contact_addr' => '中山市横栏镇裕详工业区南苑路','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '20196376','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '102','code' => 'YPC12075','name' => '深圳市吉礼宏邦科技有限公司','abbreviation' => '吉礼宏邦','categorys_id' => '13','location' => '','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为075），如5月出货则是：1305075，同样不影响美观效果即可。','contact' => '刘先生13682637462','tel' => '0755-28372863','fax' => '0755 61462938','email' => 'hongxingifts88@126.com','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '1921175530','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '103','code' => 'NCP12076','name' => '深圳市兴达尔科技有限公司','abbreviation' => '兴达尔','categorys_id' => '6','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
  贵司供应商代码为076，比如XX年X月份交货的，出货的产品代码为XXXX076，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '靳先生1368254959','tel' => '0755-25321716','fax' => '0755-25320602','email' => 'sale03@mydalle.com','contact_addr' => '深圳市福田区福华路福桥大厦A15E','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '280805053','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '104','code' => 'YPC12077','name' => '深圳市顾达电子有限公司','abbreviation' => '顾达','categorys_id' => '13','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '邓先生15919873703','tel' => '0755-29733785','fax' => '0755-28162045','email' => 'ddl668@126.com','contact_addr' => '深圳市宝安区观澜镇牛湖兴业路108号泰顺工业园C栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '1635677455','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '105','code' => 'NHG12078','name' => '深圳市宝安区荣汇电子厂','abbreviation' => '荣汇电子','categorys_id' => '15','location' => '','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:下单预付订金30%，余款发货前付清，供应商送货至我司仓库。
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒或外包装上贴产品SKU，标签大小视产品而定，不影响产品外包装美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为078），如5月出货则是：1305078，同样不影响美观效果即可。','contact' => '柯小丽 18680395626','tel' => '18680395626','fax' => '','email' => '402818346@qq.com','contact_addr' => '深圳市宝安区西乡镇黄麻布东区4巷8号(AB)栋6楼厂房','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '402818346','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '106','code' => 'NHG12079','name' => '金润实业集团有限公司','abbreviation' => '金润','categorys_id' => '15','location' => '','note' => '','contact' => 'Simon Xiao  186','tel' => '0755-82367746','fax' => '','email' => '0','contact_addr' => '深圳市罗湖区红宝路139号蔡屋围金龙大厦1515室','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '107','code' => 'YAT12080','name' => '中山市万里通天线器材有限公司','abbreviation' => '万里通','categorys_id' => '14','location' => '','note' => '1.交 货 期：请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担				
2.付款方式:20%订金，发货前付余款。含税价格需开17个点增值税票。			
3.供应商负责送货到我司指定仓库。				
4.包装要求：千岸品牌，OEM 定制包装，美国版本，产品保修一年					
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为080），如5月出货则是：1305080，同样不影响美观效果即可。','contact' => '卢小姐 13924978272','tel' => '0760-23379888','fax' => '0760-22604086','email' => '1574872393@qq.com','contact_addr' => '中山市东凤镇安乐工业区','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '108','code' => 'YSV12081','name' => '深圳市中品腾飞智能科技有限公司','abbreviation' => '中品腾飞','categorys_id' => '9','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修一年。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
      贵司供应商代码为081，比如XX年XX月份交货的，出货的产品代码为XXXX081，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '陈雅俐13714421990','tel' => '0755-29451580','fax' => '0755-89352578','email' => 'zoe@tenvis.com','contact_addr' => '深圳市龙岗区横岗六约埔夏夏安街3号6栋301','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '8','discount_rate' => '9.0','payment_period' => '0','status' => 'normal','qq' => '1218900205','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '109','code' => 'YCP12083','name' => '广州新战线商贸有限公司','abbreviation' => '新战线','categorys_id' => '6','location' => '广州市','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。						
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。	
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。	
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为083），如5月出货则是：1305083，同样不影响美观效果即可。','contact' => '梁先生 13928769833','tel' => '020-85520085-8074','fax' => '','email' => '623089938@qq.com','contact_addr' => '广州市天河区员村西街二号大院广纺联创意园119号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '8.0','payment_period' => '0','status' => 'normal','qq' => '623089938','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '110','code' => 'YCP12084','name' => '中山市品能电池有限公司','abbreviation' => '品能','categorys_id' => '6','location' => '中山市','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。						
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。	
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。	
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为084），如5月出货则是：1305084，同样不影响美观效果即可。','contact' => '朱小姐 13631174520','tel' => '0760-86938144','fax' => '0760-86938154','email' => '690057810@qq.com','contact_addr' => '中山市火炬高新技术产业开发区凤凰路9号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '7.0','payment_period' => '0','status' => 'normal','qq' => '690057810','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '111','code' => 'NCP13085','name' => '深圳市方之圆科技有限公司','abbreviation' => '方之圆','categorys_id' => '6','location' => '','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品质量:请做好出厂全检,如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '马海滨 13751177219','tel' => '0755-81481155','fax' => '','email' => '254714962@qq.com','contact_addr' => '深圳市华强北华新村22栋605','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '254714962','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '112','code' => 'NHG13086','name' => '深圳龙星龙电子厂','abbreviation' => '龙星龙','categorys_id' => '15','location' => '','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品质量:请做好出厂全检,如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为086），如5月出货则是：1305086，同样不影响美观效果即可。','contact' => '赵小姐 13428932436','tel' => '0755-89623142','fax' => '0755-89623142','email' => '1454779657@qq.com','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '113','code' => 'YAC13088','name' => '深圳市联运达电子有限公司','abbreviation' => '联运达','categorys_id' => '1','location' => '深圳市宝安区西乡西成工业城茂成大厦6楼东段','note' => '1、请准时交货，若贵司原因延期，无法按订单交期保质保量交付产品的，在7天以内的，按逾期订单金额实行折扣，折扣标准为每天1%（按天实行累计）;超过7天的，双方协商取消订单。						
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。	
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。	
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为088），如5月出货则是：1305088，同样不影响美观效果即可。','contact' => '黄珊珊 13714734604','tel' => '0755-27587573-602','fax' => '0755-27826541','email' => '1597121326@qq.com','contact_addr' => '深圳宝安西乡西城工业城茂成大厦6楼东段','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '10.0','payment_period' => '0','status' => 'normal','qq' => '1597121326','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '114','code' => 'YAC13089','name' => '深圳市天久电子有限公司','abbreviation' => '天久','categorys_id' => '1','location' => '深圳市南山区西丽镇麻磡路21号5栋','note' => '1、如无法按订单交期保质保量交付产品的，在7天以内的，按逾期订单金额实行折扣，折扣标准为每天1%（按天实行累计）；超过7天的，双方协商取消订单。
2.付款方式: 月结45天，开17%增值税发票，单价加9个点。		
3.检验标准：输入端对输出端要求过高压3000V，有过流、过稳、欠压保护，出货要求全检验，用真机测试，外观符合要求 。		
4.包装要求：采用气泡袋包装，配外纸箱包装，产品保修一年。		
5、包装外箱标签，请标明：SKU（我司产品编码），装箱数量，我司发货渠道如 美海，各渠道产品 不可混装，made in china标识。
6、所有产品型号,请加电源指示灯。		
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码。
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为089），如5月出货则是：1305089，同样不影响美观效果即可。','contact' => '付红云  1599961414','tel' => '0755-88855908-8004','fax' => '0755-26552869','email' => 'tianjiu01@tianjiudz.','contact_addr' => '深圳市南山区西丽镇麻_路21号5栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '9.0','payment_period' => '0','status' => 'normal','qq' => '2355721813','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '115','code' => 'NCP13090','name' => '深圳市时商创展科技有限公司','abbreviation' => '时商创展','categorys_id' => '6','location' => '深圳市','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。
2、产品请做好出厂全检，如产品加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、交货产品logo印制需与给我司打样确认的样品一致
4、产品质量要求：如因产品质量引起客户投诉或损失，贵司负责补货，并参照特别说明
5、付款方式：预先支付货款60%，剩余40%货款在交货之日支付
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）    
特别说明：
1.若出现批量性的质量或尺寸问题（包括卡位不精准），需承担我方的相关损失
2.需保证订购的每个手机套都有唤醒、休眠功能，如遇到我方客户投诉，相关的损失需由贵司承担','contact' => '李小姐 18820268792','tel' => '0755-23047663','fax' => '','email' => 'starry@baseus.com','contact_addr' => '深圳市宝安区民治街道梅龙路七星商业广场B1208','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '2639270217','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '116','code' => 'NPT13091','name' => '深圳市派旺宠物用品有限公司','abbreviation' => '派旺','categorys_id' => '8','location' => '','note' => '1.交 货 期：请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2.产品保修一年							
3.包装要求：外箱和内盒上需有made in china 字样。		
4.包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。				
5.发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6.需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7.出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
  贵司供应商代码为091，比如XX年XX月份交货的，出货的产品代码为XXXX091，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '李琴15920017331','tel' => '0755-61596912','fax' => '0755-83766998','email' => 'sales01@petwantprodu','contact_addr' => '深圳市石岩镇应人石天宝路13号雅丽工业园5栋7楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '30','status' => 'normal','qq' => '476671973','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '117','code' => 'YCP13092','name' => '欣旺达电子股份有限公司','abbreviation' => '欣旺达','categorys_id' => '20','location' => '深圳市宝安区石岩街道石龙社区颐和路2号','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。						
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。	
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。	
9、单个产品或彩盒上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为092），如7月出货则是：1307092，同样不影响美观效果即可。','contact' => '曹承贵 13424257931','tel' => '0755-29516888-3941','fax' => '0755-29516999','email' => 'caochenggui@sunwoda.','contact_addr' => '深圳市宝安区石岩街道石龙社区颐和路2号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '17.0','payment_period' => '0','status' => 'normal','qq' => '147385452','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '118','code' => 'YCP13093','name' => '深圳市方胜包装制品有限公司','abbreviation' => '方胜','categorys_id' => '6','location' => '','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。						
2、产品请做好出厂全检，OEM产品，如包装，产品及说明书加印我司logo之定制产品，需严格依照双方样品确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。	
5、付款方式：30%订金，发货前支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。	
9、单个产品或包装上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为093），如5月出货则是：1305093，同样不影响美观效果即可。','contact' => '邱小姐 13530071953','tel' => '0755-27800789','fax' => '0755-27966781','email' => 'agnes347@cnfs6688.co','contact_addr' => '深圳市宝安区西乡街道九围社区龙眼坑方胜工业园','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '8.0','payment_period' => '0','status' => 'normal','qq' => '2579299314','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '119','code' => 'NPT13094','name' => '深圳市嘉亿阳电子有限公司','abbreviation' => '嘉亿阳','categorys_id' => '8','location' => '','note' => '1.交 货 期：请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担							
2.付款方式: 货到验收7天内付款至供应商美金账户，按付款当日汇率结算。							
4.包装要求：中性包装，外箱和内盒上需有made in china 字样。美国版本，产品保修一年			
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。				
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
  贵司供应商代码为094，比如13年XX月份交货的，出货的产品代码为13XX094，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '滕媚 13670209086','tel' => '0755-29112919','fax' => '0755-29112919 ','email' => 'li13421320142@163.com','contact_addr' => '深圳市宝安区22区创业二路南一巷3号B栋2楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '李先生411720434','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '120','code' => 'YAT13095','name' => '深圳市腾威视科技有限公司','abbreviation' => '腾威视','categorys_id' => '9','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修一年。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
      贵司供应商代码为095，比如13年XX月份交货的，出货的产品代码为13XX095，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '陈雅俐13714421990','tel' => '0755-29451580','fax' => '0755-89352578','email' => 'zoe@tenvis.com','contact_addr' => '深圳市龙岗区坪地街道怡心社区吉祥三路10号1#厂房201、301','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '10.0','payment_period' => '0','status' => 'normal','qq' => '1218900205','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '121','code' => 'NCP13096','name' => '深圳市沃高科技有限公司','abbreviation' => '沃高','categorys_id' => '6','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修一年。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
      贵司供应商代码为096，比如13年XX月份交货的，出货的产品代码为13XX096，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '易玲18675649853','tel' => '18675649853','fax' => '','email' => 'elaineyi@vogoge.com','contact_addr' => '深圳市宝安区流塘路河东大厦B栋10层026号','delivery_addr' => '深圳市宝安区福永街道桥头社区重庆路8号万利业科技园B栋2楼201','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '50','status' => 'normal','qq' => '2814490590','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '122','code' => 'MCP13097','name' => '中山市格美通用电子有限公司','abbreviation' => '格美','categorys_id' => '6','location' => '广东省中山市东区孙文东路富湾南路富湾工业区B1栋3楼','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。						
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。	
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU编码（我司产品编码），装箱数量，Made in China标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、单个产品的彩盒上需贴上SKU编码，纸张大小视产品而定，不太影响产品彩盒美观即可，需有Made in China标识。	
9、单个产品或包装上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为097），如8月出货则是：1308097，同样不影响美观效果即可。','contact' => '黄玲 13531753046','tel' => '0760-88668033','fax' => '','email' => 'tina@k-mate.com','contact_addr' => '广东省中山市东区孙文东路富湾南路富湾工业区B1栋3楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => 'tinahl00','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '123','code' => 'NCP13098','name' => '深圳市星晟泰科技有限公司','abbreviation' => '星晟泰','categorys_id' => '6','location' => '东莞市长安镇锦厦三洲工业区','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。						
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。	
5、付款方式：首批合作，预付3K订单15%订金：3000*13*0.15=5850RMB，500起批，单批支付85%余款；
      首单付款为款到发货，第二单起货到一周付款；后续合作无需预付订金，双方协商月结帐期。
6、包装外箱上请标明SKU编码（我司产品编码），装箱数量，Made in China标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、单个产品的彩盒上需贴上SKU编码，纸张大小视产品而定，不太影响产品彩盒美观即可，需有Made in China标识。	
9、单个产品或包装上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为098），如8月出货则是：1308098，同样不影响美观效果即可。','contact' => '罗先生 13809896045','tel' => '0769-89799116','fax' => '0769-89320465','email' => '1843325171@qq.com','contact_addr' => '东莞市长安镇锦厦三洲工业区','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '1843325171','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '124','code' => 'NNT13099','name' => '深圳市宏欣科技有限公司','abbreviation' => '宏欣','categorys_id' => '3','location' => '','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。						
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。	
5、付款方式：20%订金，发货前通知支付余款。
6、包装外箱上请标明SKU编码（我司产品编码），装箱数量，Made in China标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、单个产品的彩盒上需贴上SKU编码，纸张大小视产品而定，不太影响产品彩盒美观即可，需有Made in China标识。	
9、单个产品或包装上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为099），如8月出货则是：1308099，同样不影响美观效果即可。','contact' => '赖先生 13760265786','tel' => '0755-33299470','fax' => '0755-89370401','email' => '1353022273@qq.com','contact_addr' => '深圳市龙岗区坂田金裕城工业区一巷12号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '1353022273','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '125','code' => 'YPB13100','name' => '深圳市迪比科电子科技有限公司','abbreviation' => '迪比科','categorys_id' => '20','location' => '','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。						
2、产品请做好出厂全检，按所要求之配件完整备配出货；OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。	
5、付款方式：月结30天。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。	
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为100），如9月出货则是：1309100，同样不影响美观效果即可。','contact' => '刘随 15220146573','tel' => '0755-61569366-8346','fax' => '0755-61569387','email' => 'market003@dbk.com.cn','contact_addr' => '深圳市龙华新区龙华街道华联社区龙观路北侧迪比科工业园','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '8.0','payment_period' => '0','status' => 'normal','qq' => '2409526759','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '126','code' => 'NHG13101','name' => '深圳市伟信力光电有限公司','abbreviation' => '伟信力','categorys_id' => '15','location' => '深圳市宝安区石岩街道水田社区游氏工业区1号厂房','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修一年。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
     贵司供应商代码为101，比如XX年XX月份交货的，出货的产品代码为13XX101，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）
7、付款方式：预付５０％，交货时付清余款','contact' => '辜欣','tel' => '18676681775','fax' => '0755-27608837','email' => 'LEDGROW2011@LEDWXL.C','contact_addr' => '深圳市宝安区石岩街道水田宝石东路264号游镇福工业园B栋4楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '397849735','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '127','code' => 'YAC13102','name' => '珠海市宏科电子科技有限公司','abbreviation' => '宏科','categorys_id' => '1','location' => '珠海市南屏科技园屏工1路8号厂房四楼西面','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修24个月。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
      贵司供应商代码为102，比如XX年XX月份交货的，出货的产品代码为13XX102，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）
7.付款方式：30%订金，发货前付清余款','contact' => '周大翔','tel' => '18928030288','fax' => '','email' => 'sales06@zhhkdz.com','contact_addr' => '珠海市南屏科技园屏工1路8号厂房四楼西面','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '8.0','payment_period' => '0','status' => 'normal','qq' => '727812371','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '128','code' => 'NHG13103','name' => '宁波星光灿烂电子有限公司','abbreviation' => '星光灿烂','categorys_id' => '15','location' => '宁海县西店镇蔡家村','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修24个月。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
      贵司供应商代码为103，比如XX年XX月份交货的，出货的产品代码为13XX103，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）
','contact' => '邬吉明','tel' => '13857425248 0574-651','fax' => '','email' => 'wujimingyes@126.com','contact_addr' => '浙江宁波宁海县西店镇蔡家村','delivery_addr' => '宁海县西店镇蔡家村','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '4051593','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '129','code' => 'NTB13104','name' => '深圳市旭云信息技术有限公司','abbreviation' => '旭云','categorys_id' => '12','location' => '深圳市南山西丽白芒村南1号百旺大厦A座367-1','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修一个月。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
      贵司供应商代码为104，比如XX年XX月份交货的，出货的产品代码为13XX104，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '吴尚贵18688782142','tel' => '18688782142','fax' => '','email' => 'ivan@young-clound.co','contact_addr' => '南山数字文化产业基地西塔1106','delivery_addr' => '深圳市南山数字文化产业基地西塔1106室','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '70492029','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '130','code' => 'NHG13105','name' => '深圳市圣宏亮科技有限公司','abbreviation' => '圣宏亮','categorys_id' => '15','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货
3、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为105），如XX月出货则是：13XX105，同样不影响美观效果即可。','contact' => '姚兰 13302452778','tel' => '0755-84611815-815','fax' => '','email' => 's9@superlightled.com','contact_addr' => '深圳市龙岗区龙城街道办龙西社区学园路第三工业园','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '593916072','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '131','code' => 'YPC13106','name' => '深圳市中天成科技有限公司','abbreviation' => '中天成','categorys_id' => '13','location' => '深圳市龙华大浪新围第三工业区N栋2楼A区','note' => '1、keyboard layout 见描述。							
2、manual,Giftbox,Sticker according to the email and MSN message.							
3、12 months warranty.							
4、内盒和外箱要贴有made in china 字样		
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可
8、付款方式: 样品检测OK后预付30%，大货验收合格后付尾款。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为106），如13年XX月出货则是：13XX106，同样不影响美观效果即可。','contact' => 'CANDY 186662234','tel' => '0755-28151821-813','fax' => '','email' => 'salesd@ztusb.com','contact_addr' => '深圳龙华大浪新围第三工业区N栋2楼','delivery_addr' => '深圳市龙华大浪新围第三工业区N栋2楼','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '1003013601','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '132','code' => 'NHG13107','name' => '中山市横栏镇爱拉风灯饰厂','abbreviation' => '爱拉风','categorys_id' => '15','location' => '中山市横栏镇贴边村北新村路26号首层','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修12个月。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
      贵司供应商代码为107，比如XX年XX月份交货的，出货的产品代码为13XX107，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）
7、付款方式：30%订金，发货前付清余款','contact' => '黄中成13424528481','tel' => '13424528481','fax' => '','email' => '362262822@qq.com','contact_addr' => '中山市横栏镇贴边村北新村路26号首层','delivery_addr' => '中山市横栏镇贴边村北新村路26号首层','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '362262822','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '133','code' => 'YPB130108','name' => '深圳市华旗电源科技有限公司','abbreviation' => '华旗','categorys_id' => '20','location' => '','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。						
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。	
5、付款方式：货到一周付款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。	
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为108），如XX月出货则是：13XX108，同样不影响美观效果即可。','contact' => '雷菊梅   180025120','tel' => '0755-29027630','fax' => '0755-27320840','email' => 'bnd013@bnd-battery.c','contact_addr' => '深圳市宝安区福永镇新和村天福路红牌科技园C栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '8.0','payment_period' => '0','status' => 'normal','qq' => '2441401045','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '134','code' => 'NCP130109','name' => '深圳市数码荟科技有限公司','abbreviation' => '数码荟','categorys_id' => '6','location' => '','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。						
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。	
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。	
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为109），如XX月出货则是：13XX109，同样不影响美观效果即可。','contact' => '陈金玲 15818704472','tel' => '','fax' => '','email' => '1639783373@qq.com','contact_addr' => '深圳市龙岗区平湖街道新木新园工业区1号C栋3楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '1639783373','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '135','code' => 'YPB130110','name' => '深圳市乔威电源有限公司','abbreviation' => '乔威','categorys_id' => '20','location' => '','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。						
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。	
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。	
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为110），如XX月出货则是：13XX110，同样不影响美观效果即可。','contact' => '赖小波 13590356603','tel' => '0755-29607103-8010','fax' => '0755-29607113','email' => '2637917384@qq.com','contact_addr' => '深圳是宝安区福永街道和平社区福园一路德金工业园D栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '2637917384','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '136','code' => 'NPC13111','name' => '深圳市元创时代科技有限公司','abbreviation' => '元创','categorys_id' => '13','location' => '深圳市龙岗区布吉街道李朗大道甘李科技园深港中海信科技园厂房第1栋A座901-904','note' => '1.交 货 期：请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2.产品保修两年							
3.包装要求：外箱和内盒上需有made in china 字样。		
4.包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。				
5.发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6.需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7.出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
  贵司供应商代码为111，比如XX年XX月份交货的，出货的产品代码为XXXX111，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）
8.付款方式：预付30%，发货前付清余款','contact' => '徐丹丽','tel' => '15814482184','fax' => '','email' => 'stanley@orico.com.cn','contact_addr' => '深圳市龙岗区布澜大道中海信科技园总部经济中心9楼','delivery_addr' => '深圳市龙岗区布吉街道李朗大道甘李科技园深港中海信科技园厂房第1栋A座901-904','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '10.0','payment_period' => '0','status' => 'normal','qq' => '470025265','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '137','code' => 'YAC11020','name' => '东莞市奋诚电子科技有限公司','abbreviation' => '奋诚','categorys_id' => '1','location' => '','note' => '1、如无法按订单交期保质保量交付产品的，在7天以内的，按逾期订单金额实行折扣，折扣标准为每天1%（按天实行累计）；超过7天的，双方协商取消订单。
2.付款方式: 月结90天，开17%增值税发票，单价加8个点。如逾期交货，当月的付款也酌情延期。		
3.检验标准：输入端对输出端要求过高压3000V，有过流、过稳、欠压保护，出货要求全检验，用真机测试，外观符合要求 。		
4.包装要求：电源贴中性标签，采用气泡袋包装，配外纸箱包装，产品保修一年。		
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。
6、所有产品型号,请加电源指示灯，另提供千分之三的备品。		
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为020），如5月出货则是：1305020，同样不影响美观效果即可。','contact' => '刘先生  1354371967','tel' => '0769-87893698','fax' => '0769-87890398','email' => '','contact_addr' => '东莞市清溪镇土桥村清凤路366号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '1355963719','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '138','code' => 'YHG13112','name' => '深圳市优洋科技有限公司','abbreviation' => '优洋','categorys_id' => '15','location' => '','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。						
2、产品请做好出厂全检，按所要求之配件完整备配出货；OEM产品，如彩盒，贴纸，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。	
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。	
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为112），如XX月出货则是：13XX112，同样不影响美观效果即可。','contact' => '黄先生 15818649218','tel' => '0755-88830166','fax' => '','email' => 'huang@uyled.com','contact_addr' => '深圳市宝安区民治街道民治大道展滔科技大厦23楼2306室','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '2355693239','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '139','code' => 'YCP13113','name' => '深圳市明科涞电宝电子有限公司','abbreviation' => '明科','categorys_id' => '6','location' => '','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。						
2、产品请做好出厂全检，按所要求之配件完整备配出货；OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。	
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。	
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为113），如XX月出货则是：13XX113，同样不影响美观效果即可。','contact' => '邵玉华 13823581488','tel' => '0755-27926260-8678','fax' => '0755-27926548','email' => 'cnszshao@163.com','contact_addr' => '深圳市宝安西乡银田工业区西发C区五栋二楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '2355698579','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '140','code' => 'NCP13114','name' => '深圳市易达华威科技有限公司','abbreviation' => '易达华威','categorys_id' => '6','location' => '','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。						
2、产品请做好出厂全检，按所要求之配件完整备配出货；OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。	
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。	
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为114），如XX月出货则是：13XX114，同样不影响美观效果即可。','contact' => '丁先生 13602673745','tel' => '0755-29238580','fax' => '0755-29461578','email' => 'luke@elecsung.com','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '43824483','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '141','code' => 'YCB13115','name' => '深圳市和泰达电子科技有限公司','abbreviation' => '和泰达','categorys_id' => '5','location' => '深圳市龙岗区坂田街道办马安堂社区侨联东（九巷一号）202','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2.付款方式:月结60天，如开增值税发票，单价加10个点		
3、产品请做好出厂全检，气泡袋散装加外包装纸箱。		
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识','contact' => '饶先生 15899854439','tel' => '0755-83030411','fax' => '0755-83030411','email' => 'lisazxj@126.com；1401429460@qq.com','contact_addr' => '深圳市龙岗区坂田街道办马安堂社区侨联东（九巷一号）202','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '8','discount_rate' => '10.0','payment_period' => '60','status' => 'normal','qq' => '饶生1401429460','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '142','code' => 'YSV13116','name' => '深圳市福斯康姆智能科技有限公司','abbreviation' => '福斯康姆','categorys_id' => '9','location' => '深圳市南山区高新南九道9号威新软件科技园2号楼5层西翼','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修一年。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
      贵司供应商代码为116，比如XX年XX月份交货的，出货的产品代码为XXXX116，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）
7、退货部分，请务必保证维修OK后将配件补齐按照新品出货标准送回我司仓库（包括贴标事宜也一样）
8、付款方式：50%预付，50%月结45天','contact' => '匡小姐13410073970','tel' => '0755-26720367','fax' => '','email' => 'sales15@foscam.com；sales6@foscam.com','contact_addr' => '深圳市南山区高新南九道9号威新软件科技园2号楼5层西翼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '8.0','payment_period' => '0','status' => 'normal','qq' => '匡小姐1021295862','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '143','code' => 'MNT13117','name' => '无锡中科龙泽信息科技有限公司','abbreviation' => '中科龙泽','categorys_id' => '3','location' => '','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担		
2、付款方式:款到发货。
3、产品质量:请做好出厂全检,如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、单个产品包装上需有产品SKU，made in china ，以及出厂日期小标贴，出厂日期格式为：年+月+供应商代码（贵司代码为117），如XX月出货则是：13XX117, 贴纸大小视产品而定，不太影响产品包装美观即可。','contact' => '耿然','tel' => '','fax' => '','email' => '642431757@qq.com','contact_addr' => '无锡市滴翠路100号530大厦2号楼18层','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '642431757','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
*/

    /*Vendor::create(array('id' => '1','code' => 'N1','name' => '深圳富高盈电子有限公司','abbreviation' => '富高盈','categorys_id' => '1','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '货到付款','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '2','code' => 'YAA11011','name' => '东莞市宝三电子有限公司','abbreviation' => '宝三','categorys_id' => '1','location' => '','note' => '1.交 货 期：请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担             
2.付款方式:  货到15天付款，开17%的增值税发票             
3.检验标准：输入端对输出端要求过高压3000V，有过流、过稳、欠压保护，出货要求全检验，用真机测试，外观符合要求 。             
4.包装要求：电源贴中性标签，采用气泡袋包装，配牛皮纸盒包装，产品保修一年   
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。         
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为011），如5月出货则是：1305011，同样不影响美观效果即可。','contact' => '王阳军13543779610','tel' => '0769-86814578分机806','fax' => '0769-87330839','email' => 'wyj@powsun.com','contact_addr' => '东莞市清溪镇渔_围村工业区','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '月结30天','discount_rate' => '8.0','payment_period' => '月结','status' => 'normal','qq' => '王小姐110635529','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '3','code' => 'YAT11012','name' => '中山市万视达天线器材有限公司','abbreviation' => '万视达','categorys_id' => '14','location' => '','note' => '1.交 货 期：请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担        
2.付款方式:货到3天，开17%的增值税发票        
3.供应商负责送货到我司指定仓库        
4.包装要求：中性包装，美国版本，产品保修一年         
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为012），如5月出货则是：1305012，同样不影响美观效果即可。','contact' => '高经理 13902828262','tel' => '0760-22602987','fax' => '0760-22613987','email' => '314257923@qq.com','contact_addr' => '广东省中山市东凤镇东凤大道南52号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => ' 款到发货 ','discount_rate' => '8.0','payment_period' => '现金','status' => 'normal','qq' => '46020073','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '4','code' => 'YAA11013','name' => '东莞市伍胜塑胶电子有限公司','abbreviation' => '伍胜','categorys_id' => '1','location' => '','note' => '1、如无法按订单交期保质保量交付产品的，在7天以内的，按逾期订单金额实行折扣，折扣标准为每天1%（按天实行累计）；超过7天的，双方协商取消订单。
2.付款方式: 月结60天，开17%增值税发票，单价加8个点。有少量不含税，月底对账前核实. 如遇逾期交货，当月的付款也酌情延期。 
3.检验标准：输入端对输出端要求过高压3000V，有过流、过稳、欠压保护，出货要求全检验，用真机测试，外观符合要求 。   
4.包装要求：电源贴中性标签，采用气泡袋包装，配外纸箱包装，产品保修一年
5、所有产品型号,请加电源指示灯。   
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为013），如5月出货则是：1305013，同样不影响美观效果即可。','contact' => '蔡总13602337109','tel' => '0769-86957788','fax' => '0769-86957799','email' => '赵总kevin@dgysr.com  ','contact_addr' => '东莞市塘厦镇沙湖区葡萄路2号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '月结60天','discount_rate' => '8.0','payment_period' => '月结','status' => 'normal','qq' => '赵小姐 229549863','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '5','code' => 'YNT11014','name' => '深圳必联电子有限公司','abbreviation' => '必联','categorys_id' => '3','location' => '','note' => '1.交 货 期：请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担。                
2.付款方式:  货到验收合格7天内付款，（是否含税，付款前确定），如含税，开17%增值税发票。                
3、包装：带品牌标志的彩盒包装，需印有made in china 字样，英文版本，配光盘。   
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。           
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为014），如5月出货则是：1305014，同样不影响美观效果即可。','contact' => '周小姐 15112327322','tel' => '0755-28023441','fax' => '0755-28029002','email' => 'lefen15@lefen.net 吕小姐','contact_addr' => '深圳市宝安区观澜街道桔塘社区桔岭钟兴工业区B1栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '货到一周','discount_rate' => '11.0','payment_period' => '现金','status' => 'normal','qq' => '周小姐anlin326@126','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '6','code' => 'NPT11015','name' => '深圳市新发展宠物用品公司','abbreviation' => '新发展','categorys_id' => '8','location' => '','note' => '1.交 货 期：请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担              
2.付款方式: 货到验收7天内付款至供应商美金账户，按付款当日汇率结算。              
4.包装要求：中性包装，外箱和内盒上需有made in china 字样。美国版本，产品保修一年      
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。       
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '滕媚 13670209086','tel' => '0755-29112919','fax' => '0755-29112919 ','email' => 'li13421320142@163.com','contact_addr' => '深圳市宝安33区瓦窑花园4巷5号A栋802','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '李先生411720434','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '7','code' => 'N2','name' => '维希照明','abbreviation' => '维希照明','categorys_id' => '2','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '8','code' => 'YCB11016','name' => '深圳市东景盛电子技术有限公司','abbreviation' => '东景盛','categorys_id' => '5','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担              
2、包装要求：黑色不透明较厚的PE袋单个包装，加外纸箱，PE袋和外箱上请印上 made in China 和产品SKU编码以及装箱数量。              
3、产品请做好出厂全检，并协助做好商检             
4、如开17%的增值税发票，单价加10%
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '蒋小姐 13480124905','tel' => '0755-61503188-8853','fax' => '0755-27456160','email' => 'crystal@east-toptech.com','contact_addr' => '深圳市宝安区福永镇大洋开发区九区一号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '月结30天','discount_rate' => '10.0','payment_period' => '月结','status' => 'normal','qq' => '632872361','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '9','code' => 'YCR11017','name' => '深圳欧诺达电子有限公司','abbreviation' => '欧诺达','categorys_id' => '11','location' => '','note' => '1.交 货 期：请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担。             
2.付款方式: 交货后次月10日付款。开17%增值税发票.         
3.检验标准：出货要求全检验，产品保修一年。            
4.包装要求：黄皮纸盒包装，印有made in china 字样，美国版本说明书。    
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为017），如XX月出货则是：13XX017，同样不影响美观效果即可。','contact' => '徐冬妹 13724328044','tel' => '0755-29703420-820','fax' => '0755-29063486','email' => 'onuodaltd@163.com','contact_addr' => '深圳宝安西乡固戍航空路景福工业园D座三楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '次月10日','discount_rate' => '10.0','payment_period' => '月结','status' => 'normal','qq' => '徐小姐 1427022287','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '10','code' => 'YCB11018','name' => '深圳市佳信连接线材厂','abbreviation' => '佳信','categorys_id' => '5','location' => '','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担   
2.付款方式:月结60天，如开增值税发票，单价加10个点    
3、产品请做好出厂全检，气泡袋散装加外包装纸箱。    
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '饶先生 15899854439','tel' => '0755-83030411','fax' => '0755-83030411','email' => 'lisazxj@126.com；1401429460@qq.com','contact_addr' => '深圳市龙岗区坂田街道办马安堂社区侨联东（九巷一号）202','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '10.0','payment_period' => '60','status' => 'normal','qq' => '饶生1401429460','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '11','code' => 'NPK11019','name' => '深圳市佳杰印刷厂','abbreviation' => '佳杰','categorys_id' => '4','location' => '','note' => '1.按订单数量总数的0.3%送备品
2.付款条件：月结30天。
3.请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担  
','contact' => '陈小姐 15012816991','tel' => '0755-84165293','fax' => '0755-82266187','email' => '1561302150@qq.com ；','contact_addr' => '深圳市坂田镇河背村国成工业区三/六楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => ' 月结30天 ','discount_rate' => '0.0','payment_period' => ' 月结 ','status' => 'normal','qq' => '陈小姐136073177','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '12','code' => 'N3','name' => '华锋达','abbreviation' => '华锋达','categorys_id' => '4','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担              
2.每款请提供5个备品。              
3、检验标准：外观无破损，需印有made in china 字样，印字清晰。              
','contact' => '陶先生 13724333589','tel' => '0755-27791379','fax' => '0755-27903736','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '13','code' => 'YAA11020','name' => '东莞市顺杰电子有限公司','abbreviation' => '顺杰','categorys_id' => '1','location' => '','note' => '1、如无法按订单交期保质保量交付产品的，在7天以内的，按逾期订单金额实行折扣，折扣标准为每天1%（按天实行累计）；超过7天的，双方协商取消订单。
2.付款方式: 月结90天，开17%增值税发票，单价加8个点。如逾期交货，当月的付款也酌情延期。    
3.检验标准：输入端对输出端要求过高压3000V，有过流、过稳、欠压保护，出货要求全检验，用真机测试，外观符合要求 。   
4.包装要求：电源贴中性标签，采用气泡袋包装，配外纸箱包装，产品保修一年。   
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。
6、所有产品型号,请加电源指示灯，另提供千分之三的备品。    
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为020），如5月出货则是：1305020，同样不影响美观效果即可。','contact' => '王先生  1867691318','tel' => '0769-87893698','fax' => '0769-87890398','email' => '1355963719@qq.com','contact_addr' => '东莞市清溪镇土桥村委会老围村清凤路旁','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '月结90天','discount_rate' => '8.0','payment_period' => '月结','status' => 'normal','qq' => '王经理470927510','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '14','code' => 'N4','name' => 'JGG','abbreviation' => 'JGG','categorys_id' => '1','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '15','code' => 'N5','name' => '斯格','abbreviation' => '斯格','categorys_id' => '1','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '16','code' => 'YSV11021','name' => '深圳市普顺达科技有限公司','abbreviation' => '普顺达','categorys_id' => '9','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担             
2、彩盒包装，加外纸盒，内箱和外箱上需贴有made in china 字样。              
3、产品请做好出厂全检，产品保修一年。             
4、开17%的增值税发票，加8个点。（开票数量月底对账时确定）             
5、付款方式：月结20天(次月20日付款）
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为021），如XX月出货则是：13XX021，同样不影响美观效果即可。','contact' => '钟小姐 15012566923','tel' => '0755-86976069 ','fax' => '0755-27960501','email' => 'sales-c5@easyn.cn','contact_addr' => '深圳市宝安区西乡铁岗兴发工业区1栋4楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '次月20日付款','discount_rate' => '8.0','payment_period' => '月结','status' => 'normal','qq' => '1043952649','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '17','code' => 'YAA11022','name' => '深圳市格瑞尔电子有限公司','abbreviation' => '格瑞尔','categorys_id' => '1','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担             
2.检验标准：输入端对输出端要求过高压3000V，有过流、过稳、欠压保护，出货要求全检验，用真机测试，外观符合要求 。             
3.包装要求：电源贴中性标签，采用气泡袋包装，配外纸箱包装，产品保修一年。             
4、所有产品型号,请加电源指示灯。             
5、供方负责到我司指定的深圳市内仓库的快递费用。              
6、款到发货，如含税报价，需开17%的增值税发票。             
7、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
8、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
9、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '陈小姐','tel' => '0755-89452966-813','fax' => '0755-89452809','email' => '0','contact_addr' => '深圳龙岗龙东社区南通道利好工业园18栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '8.0','payment_period' => '现金','status' => 'normal','qq' => '小吕  762865129','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '18','code' => 'N6','name' => '华强北','abbreviation' => '华强北','categorys_id' => '6','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '19','code' => 'N7','name' => '丽世宏洋','abbreviation' => '丽世宏洋','categorys_id' => '1','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '20','code' => 'YTT11023','name' => '深圳市欣宝瑞仪器有限公司','abbreviation' => '欣宝瑞','categorys_id' => '7','location' => '','note' => '1、交 货 期：请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担。              
2、付款方式:  月结30天。             
3、检验标准：出货要求全检验，外观符合要求 。             
4、包装要求：中性包装，外箱和内盒上需有made in china 字样,外箱还需有产品SKU以及数量，美国版本，产品保修一年。              
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为023），如5月出货则是：1305023，同样不影响美观效果即可。','contact' => '万先生 13418683633','tel' => '0755-27863686','fax' => '0755-27863682','email' => 'sales@chinasampo.cn','contact_addr' => '深圳市宝安区宝城43区新厂房3栋3楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '月结30天','discount_rate' => '10.0','payment_period' => '月结','status' => 'normal','qq' => '1010201885','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '21','code' => 'N8','name' => '深圳远通','abbreviation' => '深圳远通','categorys_id' => '1','location' => '','note' => 'USB CDROM','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '8','discount_rate' => '0.0','payment_period' => '30','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '22','code' => 'N9','name' => '库存期初','abbreviation' => '库存期初','categorys_id' => '0','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '23','code' => 'N10','name' => '深圳市宇豪电热制品有限公司','abbreviation' => '宇豪','categorys_id' => '5','location' => '','note' => '（恒利德）','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '24','code' => 'YTT11024','name' => '杭州华谊电子实业有限公司','abbreviation' => '华谊','categorys_id' => '7','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担。             
2、付款方式: 货到后次月底前付款。              
3、彩盒加外纸箱包装，需印有made in china 字样，英文版本说明书。             
4、产品请做好出厂全检，产品保修一年。             
5、开17%的增值税发票
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为024），如5月出货则是：1305024，同样不影响美观效果即可。','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '浙江省杭州市文三路498号天苑花园2幢9楼B','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '月结30天','discount_rate' => '0.0','payment_period' => '月结','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '25','code' => 'NSV11025','name' => '东莞市天虎科技有限公司','abbreviation' => '天虎','categorys_id' => '18','location' => '','note' => '1.交 货 期：请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担              
2.付款方式:  货到验收合格五天内付款。             
3.检验标准：出货要求全检验，外观符合要求 。             
4.包装要求：中性包装，贴有made in china 字样，带光盘、英文版本说明书，产品保修一年             
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为025），如XX月出货则是：13XX025，同样不影响美观效果即可。','contact' => '冯先生 15602600963','tel' => '0769－22606700','fax' => '0769－89026480','email' => '3636655@qq.com','contact_addr' => '广东省东莞市东城樟村罗塘工业区5号7栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '货到七天付款','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '3636655','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '26','code' => 'N11','name' => 'Fiyyaz','abbreviation' => 'Fiyyaz','categorys_id' => '0','location' => 'TX 77477','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '27','code' => 'YSV11026','name' => '深圳市联益达科技有限公司','abbreviation' => '联益达','categorys_id' => '9','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担             
2、产品品牌为LYD，中性包装，彩盒和外包装箱上需有made in china 字样。             
3、产品请做好出厂全检，产品保修一年。             
4，如含税报价，开17%的增值税发票.             
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '钟先生 13751105361','tel' => '0755-28066615','fax' => '0755-28066085','email' => '0','contact_addr' => '宝安区龙华镇油松水斗老围工业区A栋3楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '8.0','payment_period' => '0','status' => 'normal','qq' => '28747515','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '28','code' => 'YSV13087','name' => '深圳市福智达电子有限公司','abbreviation' => '福智达','categorys_id' => '9','location' => '','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修一年。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
      贵司供应商代码为087，比如XX年XX月份交货的，出货的产品代码为XXXX087，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）
7.付款方式：50%预付，50%月结45天','contact' => '匡小姐13410073970','tel' => '0755-26720367','fax' => '','email' => 'sales15@foscam.com；sales6@foscam.com','contact_addr' => '深圳市南山区高新南九道9号威新软件科技园2号楼5层西翼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '8.0','payment_period' => '0','status' => 'normal','qq' => '1109843739','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '29','code' => 'MSV11027','name' => '深圳市华格特电子有限公司','abbreviation' => '华格特','categorys_id' => '9','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担             
2、产品品牌为LYD，中性包装，内盒和外包装需有made in China 字样。             
3、产品请做好出厂全检，产品保修一年。             
4、先付30%订金，款到发货
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '林小姐13410443626','tel' => '0755-82863012','fax' => '0755-82959139','email' => 'sales006@vangold.cn','contact_addr' => '深圳市光明新区光明街道甲子塘社区得富利第二工业区1栋5楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '需付30%订金，自提货前付余款','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '1349484563','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '30','code' => 'N12','name' => '恒利德','abbreviation' => '恒利德','categorys_id' => '6','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '8','discount_rate' => '0.0','payment_period' => '30','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '31','code' => 'NVG11028','name' => '深圳纳达电子有限公司','abbreviation' => '纳达','categorys_id' => '10','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担             
2、付款方式: 货到付款              
3、中性纸盒包装，印有made in china 字样，英文版本说明书             
4、产品请做好出厂全检，产品保修一年
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为028），如5月出货则是：1305028，同样不影响美观效果即可。','contact' => '赖小姐  1355686668','tel' => '0755-61361689','fax' => '0755-61361689','email' => '0','contact_addr' => '新国亚二期国利大厦','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '货到付款','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '赖S 1244139709','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '32','code' => 'N13','name' => '东莞市林安电子有限公司','abbreviation' => '林安','categorys_id' => '1','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '8','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '33','code' => 'N14','name' => 'Sunvalleytek International Inc','abbreviation' => 'Sunvalleytek','categorys_id' => '1','location' => 'US','note' => 'We used to be their dropshipper.','contact' => 'Jenny','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '10','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '34','code' => 'N15','name' => '深圳祥泰有限公司','abbreviation' => '祥泰','categorys_id' => '2','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担             
2、产品质量按原来要求，黄皮纸盒、中性包装，印有made in china 字样。
3、产品请做好出厂全检             
','contact' => '王经理 13828773376','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '35','code' => 'N16','name' => 'Williamsons, Inc.','abbreviation' => 'Williamsons','categorys_id' => '6','location' => 'US','note' => 'Supplier for \\"The Reindeer Decoration for Cars\\".','contact' => 'Sue Williamson ','tel' => '610-850-5400','fax' => '','email' => 'info@williamsonsprod','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '1','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '36','code' => 'NCP11029','name' => '明虹通讯','abbreviation' => '明虹通讯','categorys_id' => '6','location' => '','note' => '','contact' => '张演民 13632983089','tel' => '','fax' => '0755-82796507','email' => '0','contact_addr' => '深圳市华强北路通讯市场2楼A258','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '37','code' => 'N17','name' => '不含税仓','abbreviation' => '不含税仓','categorys_id' => '0','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '38','code' => 'N18','name' => '裕同电子有限公司','abbreviation' => '裕同','categorys_id' => '0','location' => '','note' => 'lamp','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '39','code' => 'N19','name' => '库存调整','abbreviation' => '库存调整','categorys_id' => '6','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '40','code' => 'NTB11030','name' => '深圳市卓尼斯科技有限公司','abbreviation' => '卓尼斯','categorys_id' => '12','location' => '','note' => '1.交 货 期：请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担.              
2.付款方式: 款到发货.             
3.自提或者发国内快递，我方承担运费              
4.包装要求：中性包装，外包装和彩盒上要有made in china 字样。美国版本，产品保修一年.    
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。         
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '徐小姐 13428967130','tel' => '0755-86119766','fax' => '0755-86119733','email' => '0','contact_addr' => '深圳市安南山区麻雀岭工业区M-3栋2楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货，待确认最终良品数再付款','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '1583461049','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '41','code' => 'NPC11031','name' => '翔辉科技（香港）有限公司','abbreviation' => '翔辉','categorys_id' => '13','location' => '','note' => '1、keyboard layout；US。             
2、manual,Giftbox,Sticker according to the email and MSN message.              
3、15 months warranty.             
4、内盒和外箱要贴有made in china 字样              
5、货到付款
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为031），如5月出货则是：1305031，同样不影响美观效果即可。','contact' => '廖小姐15814400382 ','tel' => '0755-29360362','fax' => '0755-29360353','email' => '0','contact_addr' => '西乡固戍二路时代科创中心609','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '货到付款','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '廖S 1551432965','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '42','code' => 'NCR11032','name' => '深圳市车龙电子科技有限公司','abbreviation' => '车龙','categorys_id' => '11','location' => '','note' => '出美国车载DVD region的设定界面要默认为region 1 。
1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担             
2、产品请做好出厂全检，保修一年。             
3、每套：888C DVD430元+红外耳机60元+20元红外遥控手柄；每对彩盒包装，每三对加外纸箱包装，耳机和手柄请装入每对纸箱，彩盒和外包装箱需有made in china 字样。              
4.付款方式: 供应商送货上门，收货方清点后，付款至供应商美金账户，付款汇率以当日美金基准价为折算标准，余款10万RMB20天后付清。     
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。   
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为032），如XX月出货则是：13XX032，同样不影响美观效果即可。','contact' => '李小姐 13682203388','tel' => '13682203388','fax' => '020-28242022','email' => 'chelongchina@126.com','contact_addr' => '广州市永福路倚云汽车用品广场A114-A115','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '货到付款，留余款20万20天后支付','discount_rate' => '0.0','payment_period' => '部分月结部分现金','status' => 'normal','qq' => '190714796','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '43','code' => 'YAA11033','name' => '广州斯泰克电子科技有限公司','abbreviation' => '斯泰克','categorys_id' => '1','location' => '番禺区东涌区太石工业区标准工业园2栋','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担              
2.检验标准：输入端对输出端要求过高压3000V，有过流、过稳、欠压保护，出货要求全检验，用真机测试，外观符合要求 。             
3.包装要求：电源贴中性标签，采用气泡袋包装，配外纸箱包装，产品保修一年。             
4、所有产品型号,请加电源指示灯。             
5、开17%的增值税发票，月结90天（有少量不含税，在月底对账前确定具体开票数量）
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为033），如XX月出货则是：13XX033，同样不影响美观效果即可。','contact' => '黄小姐13825237457','tel' => '0755-83030247','fax' => '020-34925825','email' => 'ht8@gzstiger.com','contact_addr' => '广州市番禺区东涌镇太石村标准工业园厂房2号1-3层、7号首层','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '月结90天','discount_rate' => '8.0','payment_period' => '月结','status' => 'normal','qq' => '黄小姐 179585549','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '44','code' => 'N20','name' => '德国高科集团','abbreviation' => '德国高科','categorys_id' => '0','location' => '德国','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '45','code' => 'N21','name' => 'Micmac-Computers','abbreviation' => 'Micmac','categorys_id' => '0','location' => '荷兰','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '46','code' => 'N22','name' => '朱运生-自用','abbreviation' => '自用','categorys_id' => '0','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '47','code' => 'N23','name' => '广州杨生','abbreviation' => '广州杨生','categorys_id' => '0','location' => '广州','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '48','code' => 'MTT11034','name' => 'Sinometer','abbreviation' => '仪华','categorys_id' => '7','location' => '','note' => '说明：           
1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担。            
2.付款方式: 先支付30%订金，款到发货           
3、彩盒加外纸箱包装，内盒和外箱需印有made in chian 字样，英文版本说明书。            
4、产品请做好出厂全检，产品保修一年。           
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为034），如5月出货则是：1305034，同样不影响美观效果即可。','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => 'Room 2410 and 2411','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '49','code' => 'N24','name' => '深圳凯普特电子有限公司','abbreviation' => '凯普特','categorys_id' => '6','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '50','code' => 'NPC11035','name' => '深圳锐爱科技有限公司','abbreviation' => '锐爱','categorys_id' => '13','location' => '','note' => '1、keyboard layout 见描述。              
2、manual,Giftbox,Sticker according to the email and MSN message.              
3、15 months warranty.             
4、内盒和外箱要贴有made in china 字样    
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可
8、付款方式: 月结30天。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为035），如5月出货则是：1305035，同样不影响美观效果即可。','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => 'Room1320','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => ' 月结30天 ','discount_rate' => '0.0','payment_period' => '月结','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '51','code' => 'NCP11036','name' => '深圳华裕工具行','abbreviation' => '华裕','categorys_id' => '6','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担             
2、付款方式: 供应商送货上门，收货方清点后付款              
3、要统一包装，工具中包含五角星螺丝刀头
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '陈小姐 13902989101','tel' => '0755-82533791  ','fax' => '','email' => '','contact_addr' => '华强北路赛格通信市场二楼2A25号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '货到3天','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '52','code' => 'N25','name' => '深圳市国邦兴业电子有限公司','abbreviation' => '国邦','categorys_id' => '12','location' => ' ','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担              
2.检验标准：所有产品要求全检出货，英文说明书，一年保修              
3.包装要求：中性包装，内盒和外箱有made in china 字样              
4、送至供应商指定地点，运费供方付     
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。       
6、如含税报价，开17%的增值税发票              
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '陈程 15817316140','tel' => '0755-28302769    ','fax' => '0755-28301735','email' => '','contact_addr' => '深圳市布吉镇李朗大道联创科技园4栋5楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '53','code' => 'N26','name' => 'Ebundle','abbreviation' => 'Ebundle','categorys_id' => '0','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '54','code' => 'N27','name' => 'Central Computers','abbreviation' => 'Central','categorys_id' => '5','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '55','code' => 'NDR11037','name' => '深圳市创新科技有限公司','abbreviation' => '创新','categorys_id' => '2','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担             
2、产品质量按原来要求，黄皮纸盒、中性包装，有made in china 标签
3、产品请做好出厂全检，质保1年          
4、供应商负责送货，收货方清点后付款，货到三天
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '李英  13715375395','tel' => '0755-83334501 ','fax' => '','email' => '','contact_addr' => '深圳市福田区华强电子世界2号楼23C213','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '最晚当月20号付款','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '56','code' => 'NHG11038','name' => '北京旭能阳光科技有限公司','abbreviation' => '旭能','categorys_id' => '15','location' => '','note' => '1.请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担             
2.彩盒包装，内附英文说明书，保修1年             
3.供方负责到我司指定的深圳市内仓库的快递费用。              
4.款到发货              
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为038），如5月出货则是：1305038，同样不影响美观效果即可。','contact' => '周先生 13601327260','tel' => '010-57227906','fax' => '010-57202207','email' => '0','contact_addr' => '北京市朝阳区百子湾大成国际中心3号楼B座1907室','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '王先生860882623','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '57','code' => 'YCB11039','name' => '东莞翰云五金塑胶有限公司 ','abbreviation' => '翰云','categorys_id' => '5','location' => '东莞','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担             
2、PE袋加外纸箱包装，PE袋和外箱上请印上 made in China 字样。              
3、产品请做好出厂全检，并协助做好商检             
4、开17%的增值税发票
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '刘总 13509843853','tel' => '0769-82025941','fax' => '0769-82025940','email' => '0','contact_addr' => '东莞市黄江镇田心村聚龙工业园A龙','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '月结30天','discount_rate' => '8.0','payment_period' => '月结','status' => 'normal','qq' => '2217663793','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '58','code' => 'N28','name' => '深圳市震韩电子科技有限公司','abbreviation' => '震韩','categorys_id' => '5','location' => '','note' => '','contact' => '李小姐 13430931864','tel' => '0755-27947259','fax' => '0755-27947408','email' => '','contact_addr' => '深圳市宝安区西乡镇流塘大厦1807室','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '8','discount_rate' => '0.0','payment_period' => '30','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '59','code' => 'N29','name' => '金鹏腾包装制品有限公司','abbreviation' => '金鹏腾','categorys_id' => '4','location' => '','note' => '','contact' => '郑先生13590375963','tel' => ' 0755-28659778','fax' => '0755-84260623','email' => '','contact_addr' => '深圳市龙岗区横岗镇大康莘唐工业区龙兴路11号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '60','code' => 'N30','name' => '深圳市麦恩科技有限公司','abbreviation' => '麦恩','categorys_id' => '2','location' => '','note' => '1.交 货 期：请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担。             
2.付款方式: 款到发货；如果供方产品与我司摄像头不匹配，三天内全额退款至我司。            
3.检验标准：出货要求全检验，产品保修一年。              
4.包装要求：配件齐全，美国版本说明书。    
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '唐誉珈  1371391021','tel' => '0755-83281889-8120','fax' => '0755-83048160','email' => '','contact_addr' => '深圳市福田区华强北路现代之窗','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '货到付款','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '61','code' => 'YVG11040','name' => '深圳市捷锐泓电子有限公司','abbreviation' => '捷锐','categorys_id' => '10','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担             
2、产品请做好出厂全检，保修一年。             
3、每单个产品上需有made in china 字样。
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可
7、付款方式: 供应商负责送货，月结30天（货到第二个自然月结束前付款），含税单价加9个点，收到开票合同后在当月完成开票，发票及合同盖章原件回寄我司  。
8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为040），如5月出货则是：1305040，同样不影响美观效果即可。  ','contact' => '蔡小姐 13418981084','tel' => '','fax' => '0755-29552319 ','email' => 'c13418981084@163.com','contact_addr' => '宝安沙井马安山第一工业区第五栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => ' 月结30天 ','discount_rate' => '9.0','payment_period' => '月结','status' => 'normal','qq' => '蔡小姐 13418981084','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '62','code' => 'NCP11041','name' => '深圳市保实丰电子有限公司','abbreviation' => '保实丰','categorys_id' => '6','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担             
2、产品请做好出厂全检，保修一年。             
3、每单个产品上需有made in china 字样。             
4.付款方式: 供应商负责送货，收货方清点后付款
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '吴小姐 13417340927','tel' => '0755-33552510  ','fax' => '0755-82595096','email' => '0','contact_addr' => '深圳市宝安区观澜大道田背花园H单元1301','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '小吴948163272','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '63','code' => 'NCP11042','name' => '深圳市康和力电子有限公司','abbreviation' => '康和力','categorys_id' => '6','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担             
2、检验标准：所有产品全检后出货，产品保修一年           
3、包装要求：PE袋中性包装，PASS标                    
4、付款方式：电源月结60天，其他月结30天
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9，单个产品货起单个包装上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为042），如XX月出货则是：13XX042，同样不影响美观效果即可。','contact' => '刘奎 13922805676','tel' => '0755-28401695 ','fax' => '0755-28401683','email' => 'kandl0401@yahoo.cn','contact_addr' => ' 深圳市龙岗区宝龙一路 留学生产业园8栋4楼 ','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '月结30天','discount_rate' => '0.0','payment_period' => '月结','status' => 'normal','qq' => '刘总466902314','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '64','code' => 'YCR11043','name' => '深圳市路安宝电子有限公司','abbreviation' => '路安宝','categorys_id' => '11','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担              
2、如我司定制品牌之产品需严格按照确认样板做。彩盒包装，加外纸盒，内箱和外箱上需贴有made in china 字样。             
3、产品请做好出厂全检，产品保修一年。             
4、开17%的增值税发票，加9个点。（开票数量月底对账时确定）             
5、付款方式：月结30天
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为043），如XX月出货则是：13XX043，同样不影响美观效果即可。','contact' => '朱燕 13802210103','tel' => '0755-84190683','fax' => '','email' => '2355839630@qq.com','contact_addr' => '深圳市光明新区公明街道合水口社区第四工业区A3号02动3楼8区','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '次月28日','discount_rate' => '9.0','payment_period' => '月结','status' => 'normal','qq' => '1531824532','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '65','code' => 'YOF11044','name' => '珠海市华尚光电科技有限公司','abbreviation' => '华尚光电','categorys_id' => '16','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担              
2、彩盒包装，加外纸盒，内箱和外箱上需贴有made in china 字样
3、包装外箱上还需标明SKU（我司产品编码），装箱数量           
4、产品请做好出厂全检，产品保修一年
5、开17%的增值税发票，加6个点（开票数量月底对账时确定）
6、付款方式：款到发货
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
  贵司供应商代码为044，比如XX年XX月份交货的，出货的产品代码为XXXX044，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '胡志彬  1365143374','tel' => '0755-83987731','fax' => '0755-83987731','email' => 'jerry@farsun.cn','contact_addr' => '珠海市金湾区三灶镇恒辉路6号A栋厂房2-1','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '6.0','payment_period' => '现金','status' => 'normal','qq' => '345375228','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '66','code' => 'NCB11045','name' => '辉瑞配件','abbreviation' => '辉瑞配件','categorys_id' => '5','location' => '','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担   
2、付款方式:款到发货 
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '李培辉 13510907710','tel' => '','fax' => '','email' => '0','contact_addr' => '深圳市深南中路通天地通讯市场A178 ','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '货到付款','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '李先生171153554','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '67','code' => 'N31','name' => 'MegaWatts Computers, LLC','abbreviation' => 'MegaWatts','categorys_id' => '1','location' => 'U.S.A','note' => '','contact' => 'Doug Watts','tel' => '918-664-6342','fax' => '','email' => 'doug@megawatts.com','contact_addr' => '','delivery_addr' => '3501 South Sheridan Road, Tulsa, OK 74145','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '6','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '68','code' => 'N32','name' => 'Southern Computer Repair, Inc.','abbreviation' => 'Southern','categorys_id' => '1','location' => 'U.S.','note' => '','contact' => 'Bob Mc Millan','tel' => '770-904-5810*351','fax' => '','email' => 'bob_mcmillan@scrpart','contact_addr' => '','delivery_addr' => '500 Satellite Blvd, NW Suite E,Suwanee, GA 30024','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '69','code' => 'NAA11046','name' => '深圳市富高盈电子有限公司','abbreviation' => '富高盈','categorys_id' => '1','location' => '','note' => '1、请准时交货，若因为贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、检验标准：输入端对输出端要求过高压3000V，有过流、过稳、欠压保护，出货要求全检验，用真机测试，外观符合要求           
3、包装要求：电源贴中性标签，采用气泡袋包装，配外纸箱包装，产品保修一年            
4、所有产品型号,请加电源指示灯
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、付款方式:货到付款
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为046），如5月出货则是：1305046，同样不影响美观效果即可。','contact' => '陈锐添13480814231','tel' => '0755-33093396','fax' => '','email' => '0','contact_addr' => '宝安区石岩镇洲石路梨园工业园B栋2楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '陈先生 1015798976','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '70','code' => 'MPC11047','name' => 'DYGJ','abbreviation' => 'DYGJ','categorys_id' => '13','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '0','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '71','code' => 'NPK11048','name' => '深圳市万飞达纸品包装有限公司','abbreviation' => '万飞达','categorys_id' => '4','location' => '','note' => '1.请按质按量，如期交货。
2.付款条件：月结30天。','contact' => '郑先生13590375963','tel' => '0755-98731981','fax' => '0755-89731983','email' => '407503976@qq.com','contact_addr' => '深圳市龙岗区横岗六约六和路22号三栋厂房一楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => ' 月结30天 ','discount_rate' => '0.0','payment_period' => ' 月结 ','status' => 'normal','qq' => '郑先生407503976','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '72','code' => 'MAA11049','name' => 'YZDY1','abbreviation' => 'YZDY1','categorys_id' => '19','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '0','contact_addr' => '','delivery_addr' => 'HK仓库','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '73','code' => 'NSV11050','name' => '深圳市威视达康科技有限公司','abbreviation' => '威视达康','categorys_id' => '9','location' => '','note' => '1.交 货 期：请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担.             
2.付款方式:货到30天          
3.供应商负责送货到我司指定仓库.             
4.包装要求：按照我司Esky品牌要求包装
5.包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6.发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8.出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
  贵司供应商代码为050，比如XX年XX月份交货的，出货的产品代码为XXXX050，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '黄永涛18675512078','tel' => '0755-26736182','fax' => '0755-26736182-804','email' => 'sales5@vstarcam.com','contact_addr' => '深圳市宝安区石岩镇洲石路万大工业区F栋5楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '月结30天','discount_rate' => '9.0','payment_period' => '月结','status' => 'normal','qq' => '2273040974','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '74','code' => 'NAA11051','name' => '深圳市奥强电源有限公司','abbreviation' => '奥强','categorys_id' => '1','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担    
2、付款方式:预付30%，提货前付余款
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '彭忠博15976857622','tel' => '0755 -36638252','fax' => '0755-27921880','email' => 'wangabc1212@qq.com','contact_addr' => '深圳市宝47区 富源海滨工业区','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '1831855115','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '75','code' => 'MPC11052','name' => 'SHJL','abbreviation' => 'SHJL','categorys_id' => '13','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '0','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '76','code' => 'NHG11053','name' => '深圳市宇丰达光电有限公司','abbreviation' => '宇丰达','categorys_id' => '15','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担   
2、付款方式:货到付款
3、产品请做好出厂全，每款加送3%备品，不良比例若超出5%，需如数补货
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为053），如5月出货则是：1305053，同样不影响美观效果即可。','contact' => '陈__13924588177','tel' => '0755-27661015','fax' => '0755-27661016','email' => '511581555@qq.com','contact_addr' => '深圳宝安71区留仙二路江南百货6楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '当月结','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '陈小姐511581555','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '77','code' => 'NAT11054','name' => '中山市杰霸电器有限公司','abbreviation' => '杰霸','categorys_id' => '14','location' => '中山市','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担    
2、付款方式:预付30%，提货前付余款
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '周小姐13925308301','tel' => '0760-22265299','fax' => '0760 22836817','email' => '0','contact_addr' => '广东省中山市小榄镇_西一广丰北路121号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '424272820','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '78','code' => 'NHG11055','name' => '深圳市广百思科技有限公司','abbreviation' => '广百思','categorys_id' => '15','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担   
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '李永昌13310843453','tel' => '0755 82055658','fax' => '0755 82053969','email' => '0','contact_addr' => '深圳福田区八卦四路5号索泰克大厦4楼W区','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '1401919742','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '79','code' => 'N33','name' => '深圳市赛特莱特科技有限公司','abbreviation' => '赛特莱特','categorys_id' => '10','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担    
2、付款方式:预付20%，提货前付余款
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '邓桂荣13510560140','tel' => '','fax' => '0755 27186411','email' => '','contact_addr' => '深圳市宝安区观兰镇第三工业区观中街7号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '80','code' => 'NOF11056','name' => '深圳市富喆科技有限公司','abbreviation' => '富_','categorys_id' => '16','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担   
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '袁旭15889297136','tel' => '0755-84528255-805','fax' => '0755 84528390','email' => '5917110@qq.com','contact_addr' => '深圳市龙岗区坂田元征工业园','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '袁先生 5917110','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '81','code' => 'N34','name' => '深圳市福田区中电信息时代广场亿惠电子经营部','abbreviation' => '中电信息','categorys_id' => '5','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担   
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '邱泽斌13713785260','tel' => '','fax' => '','email' => '','contact_addr' => '深圳市福田区华强北龙胜手机批发市场3楼383','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '82','code' => 'N35','name' => '深圳市华创信电子有限公司','abbreviation' => '华创信','categorys_id' => '0','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担   
2、付款方式:预付30%，提货前付余款
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '范小姐13544240661','tel' => '','fax' => '','email' => '','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '83','code' => 'NHG11057','name' => '东莞市常平爱迪电子厂','abbreviation' => '爱迪','categorys_id' => '15','location' => '东莞','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担    
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为057），如5月出货则是：1305057，同样不影响美观效果即可。','contact' => '李先生13600243205','tel' => '','fax' => '','email' => '0','contact_addr' => '东莞常平镇环城北路苏坑工业园','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '53851401','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '84','code' => 'YSV11058','name' => '深圳市慧眼视讯电子有限公司','abbreviation' => '慧眼','categorys_id' => '9','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担    
2、付款方式:月结30天
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
  贵司供应商代码为058，比如XX年XX月份交货的，出货的产品代码为XXXX058，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '刘文辉18665355798','tel' => '18665355798','fax' => '0755 89390380','email' => 'sales@sznv.net','contact_addr' => '深圳市坂田上雪科技城北区6号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '月结30天','discount_rate' => '10.0','payment_period' => '月结','status' => 'normal','qq' => '272012419','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '85','code' => 'NHG11059','name' => '英飞特电子（杭州）股份有限公司','abbreviation' => '英飞特','categorys_id' => '15','location' => '浙江杭州','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担    
2、付款方式:月结30天
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为059），如5月出货则是：1305059，同样不影响美观效果即可。','contact' => '邓先生 18758013069','tel' => '0571-56565866 ','fax' => '0571-86601139','email' => '0','contact_addr' => '浙江省杭州市滨江区六和路368号海创基地北区3楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '月结30天','discount_rate' => '0.0','payment_period' => '月结','status' => 'normal','qq' => '549695919','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '86','code' => 'NTT11060','name' => '深圳华谊仪表有限公司','abbreviation' => '深圳华谊','categorys_id' => '7','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担   
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '江闯 13682532582','tel' => '0755-83766667','fax' => '0755-83766510','email' => '0','contact_addr' => '深圳华强北赛格科技园三栋西九楼C','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '416683683','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '87','code' => 'YCB11061','name' => '海能电子（深圳）有限公司','abbreviation' => '海能','categorys_id' => '5','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担   
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '李宏斌13902964360','tel' => '','fax' => '','email' => '0','contact_addr' => '深圳市宝安区沙井镇共和村丽城工业园M栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '12.0','payment_period' => '0','status' => 'normal','qq' => '854108628','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '88','code' => 'N36','name' => '深圳市磁展悬浮科技有限公司','abbreviation' => '磁展悬浮','categorys_id' => '0','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担   
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '周维波15817225659','tel' => '0755-61157886 ','fax' => '0755-61157787','email' => '','contact_addr' => '深圳市宝安区福永镇桥南新区136栋811-812','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => ''));
  Vendor::create(array('id' => '89','code' => 'MTT11062','name' => '东莞华仪仪表科技有限公司','abbreviation' => '东莞华仪','categorys_id' => '7','location' => '东莞','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担   
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为062），如5月出货则是：1305062，同样不影响美观效果即可。','contact' => '涂先生13560893631','tel' => '0769-81901614','fax' => '','email' => 'sale1@mastech.cn','contact_addr' => '东莞市清溪镇渔梁围工业区','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '535770224','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '90','code' => 'MPC12063','name' => 'XGTY','abbreviation' => 'XGTY','categorys_id' => '13','location' => '','note' => '','contact' => '','tel' => '','fax' => '','email' => '0','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '91','code' => 'YSV12064','name' => '深圳市联缘达科技有限公司','abbreviation' => '联缘达','categorys_id' => '9','location' => '深圳','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担             
2、产品品牌为LYD，中性包装，彩盒和外包装箱上需有made in china 字样。             
3、产品请做好出厂全检，产品保修一年              
4、如含税报价，开17%的增值税发票
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
  贵司供应商代码为064，比如XX年XX月份交货的，出货的产品代码为XXXX064，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '钟先生13751105361','tel' => '0755-28065142','fax' => '','email' => '28747515@qq.com','contact_addr' => '深圳市宝安区龙华街道油松社区水斗老围村一区27号3楼302','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '8.0','payment_period' => '现金','status' => 'normal','qq' => '28747515','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '92','code' => 'NHG12065','name' => '深圳市诚信神火科技有限公司','abbreviation' => '诚信神火','categorys_id' => '15','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担   
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为065），如5月出货则是：1305065，同样不影响美观效果即可。','contact' => '肖小姐13410152761','tel' => '0755 84617577','fax' => '','email' => '1050798539@qq.com','contact_addr' => '深圳龙岗龙西富民路236号A栋一楼','delivery_addr' => '','delivery_addr_ext' => '深圳市龙岗区龙城街道龙西社区富民路236号B栋3楼','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '9.0','payment_period' => '现金','status' => 'normal','qq' => '1050798539','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '93','code' => 'NHG12066','name' => '中山市艾威尼节能照明有限公司','abbreviation' => '艾威尼','categorys_id' => '15','location' => '中山市','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担    
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为066），如5月出货则是：1305066，同样不影响美观效果即可。','contact' => '曾小姐15917246769','tel' => '0760 23651988','fax' => '0760 23651989','email' => '0','contact_addr' => '广东中山市古镇镇曹三创业园华盛东路南三路4号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '526810236','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '94','code' => 'YPC12067','name' => '深圳市天下鑫集采科技有限公司','abbreviation' => '天下鑫','categorys_id' => '13','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担   
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为067），如5月出货则是：1305067，同样不影响美观效果即可。','contact' => '罗先生13603097248','tel' => '0755 83763203','fax' => '0755 86644216','email' => '168121018@qq.com','contact_addr' => '深圳市南山区南山大道3838号设计产业园金栋201-206','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '168121018','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '95','code' => 'MTT12068','name' => '深圳市德与辅科技有限公司','abbreviation' => '德与辅','categorys_id' => '7','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担    
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为068），如5月出货则是：1305068，同样不影响美观效果即可。','contact' => '孙先生13423822943','tel' => '0755 89603760','fax' => '0755 84192557','email' => '1281342846@qq.com','contact_addr' => '深圳市龙岗区五和南路和勘工业区B1栋3楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '1281342846','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '96','code' => 'YCB12069','name' => '安福县海能实业有限公司','abbreviation' => '海能','categorys_id' => '5','location' => '江西吉安','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担    
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）。
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '李宏斌13902964360','tel' => '0796-7551168','fax' => '','email' => '0','contact_addr' => '江西省吉安市安福县工业园','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '854108628','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '97','code' => 'NPK12070','name' => '深圳市新宏远包装制品有限公司','abbreviation' => '新宏远','categorys_id' => '4','location' => '','note' => '1.请按质按量，如期交货;
2.印我司指定LOGO,交货需与样品一致，否则拒收;
3.付款条件：当月结。','contact' => '杨先生','tel' => '0755-36813776/135306','fax' => '0755-29574172','email' => '862389607@qq.com','contact_addr' => '深圳市龙华新区潭罗华侨新村','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => ' 当月结 ','discount_rate' => '0.0','payment_period' => ' 现金 ','status' => 'normal','qq' => '862389607','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '98','code' => 'MSV12071','name' => '深圳市安斯尔科技有限公司','abbreviation' => '安斯尔','categorys_id' => '9','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担    
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
  贵司供应商代码为071，比如XX年XX月份交货的，出货的产品代码为XXXX071，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '张小姐13798267665','tel' => '13798267665','fax' => '','email' => '1597234285@qq.com','contact_addr' => '深圳市宝安区西乡黄田三力工业园6栋','delivery_addr' => '深圳市福田区华强北汇通安防市场A127号','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '1597234285','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '99','code' => 'NHG12072','name' => '深圳长基科技开发有限公司','abbreviation' => '长基','categorys_id' => '15','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担    
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上标贴标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的包装贴上产品SKU，made in china，及贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为072），如5月出货则是：1305072，同样不影响美观效 果即可。
','contact' => '葛小姐13923794756','tel' => '0755-88840309','fax' => '0755-28411180','email' => '362110813@qq.com','contact_addr' => '深圳市龙岗区布吉布澜路甘李工业区科伦特科技园3号厂房5楼 ','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '362110813','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '100','code' => 'NHG12073','name' => '深圳市菲科科技有限公司','abbreviation' => '菲科','categorys_id' => '15','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担    
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为073），如5月出货则是：1305073，同样不影响美观效果即可。','contact' => '陈立娟13640920145','tel' => '0755-61557192','fax' => '','email' => 'fetin88@foxmail.com','contact_addr' => '深圳市宝安区福永新和华丽工业园9栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '货到一周','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '1390650412','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '101','code' => 'NHG12074','name' => '中山市香江灯饰电器有限公司','abbreviation' => '香江灯饰','categorys_id' => '15','location' => '中山市','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担   
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为074），如5月出货则是：1305074，同样不影响美观效果即可。','contact' => '毛江玲13924939805','tel' => '','fax' => '','email' => '0504122@163.com','contact_addr' => '中山市横栏镇裕详工业区南苑路','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '货到一周','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '20196376','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '102','code' => 'YPC12075','name' => '深圳市吉礼宏邦科技有限公司','abbreviation' => '吉礼宏邦','categorys_id' => '13','location' => '','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担    
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为075），如5月出货则是：1305075，同样不影响美观效果即可。','contact' => '刘先生13682637462','tel' => '0755-28372863','fax' => '0755 61462938','email' => 'hongxingifts88@126.com','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '1921175530','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '103','code' => 'NCP12076','name' => '深圳市兴达尔科技有限公司','abbreviation' => '兴达尔','categorys_id' => '6','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担   
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
  贵司供应商代码为076，比如XX年X月份交货的，出货的产品代码为XXXX076，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '靳先生1368254959','tel' => '0755-25321716','fax' => '0755-25320602','email' => 'sale03@mydalle.com','contact_addr' => '深圳市福田区福华路福桥大厦A15E','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '货到3天','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '280805053','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '104','code' => 'YPC12077','name' => '深圳市顾达电子有限公司','abbreviation' => '顾达','categorys_id' => '13','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担    
2、付款方式:款到发货
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '邓先生15919873703','tel' => '0755-29733785','fax' => '0755-28162045','email' => 'ddl668@126.com','contact_addr' => '深圳市宝安区观澜镇牛湖兴业路108号泰顺工业园C栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '1635677455','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '105','code' => 'NHG12078','name' => '深圳市宝安区荣汇电子厂','abbreviation' => '荣汇电子','categorys_id' => '15','location' => '','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担    
2、付款方式:下单预付订金30%，余款发货前付清，供应商送货至我司仓库。
3、产品请做好出厂全检
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒或外包装上贴产品SKU，标签大小视产品而定，不影响产品外包装美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为078），如5月出货则是：1305078，同样不影响美观效果即可。','contact' => '柯小丽 18680395626','tel' => '18680395626','fax' => '','email' => '402818346@qq.com','contact_addr' => '深圳市宝安区西乡镇黄麻布东区4巷8号(AB)栋6楼厂房','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '预付30%，余款发货前付','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '402818346','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '106','code' => 'NHG12079','name' => '金润实业集团有限公司','abbreviation' => '金润','categorys_id' => '15','location' => '','note' => '','contact' => 'Simon Xiao  186','tel' => '0755-82367746','fax' => '','email' => '0','contact_addr' => '深圳市罗湖区红宝路139号蔡屋围金龙大厦1515室','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '107','code' => 'YAT12080','name' => '中山市万里通天线器材有限公司','abbreviation' => '万里通','categorys_id' => '14','location' => '','note' => '1.交 货 期：请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担        
2.付款方式:20%订金，发货前付余款。含税价格需开17个点增值税票。     
3.供应商负责送货到我司指定仓库。       
4.包装要求：千岸品牌，OEM 定制包装，美国版本，产品保修一年          
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为080），如5月出货则是：1305080，同样不影响美观效果即可。','contact' => '卢小姐 13924978272','tel' => '0760-23379888','fax' => '0760-22604086','email' => '1574872393@qq.com','contact_addr' => '中山市东凤镇安乐工业区','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => ' 20%订金，提货余款 ','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '108','code' => 'YSV12081','name' => '深圳市中品腾飞智能科技有限公司','abbreviation' => '中品腾飞','categorys_id' => '9','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修一年。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
      贵司供应商代码为081，比如XX年XX月份交货的，出货的产品代码为XXXX081，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '陈雅俐13714421990','tel' => '0755-29451580','fax' => '0755-89352578','email' => 'zoe@tenvis.com','contact_addr' => '深圳市龙岗区横岗六约埔夏夏安街3号6栋301','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '8','discount_rate' => '9.0','payment_period' => '0','status' => 'normal','qq' => '1218900205','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '109','code' => 'YCP12083','name' => '广州新战线商贸有限公司','abbreviation' => '新战线','categorys_id' => '6','location' => '广州市','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。           
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。  
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。 
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为083），如5月出货则是：1305083，同样不影响美观效果即可。','contact' => '梁先生 13928769833','tel' => '020-85520085-8074','fax' => '','email' => '623089938@qq.com','contact_addr' => '广州市天河区员村西街二号大院广纺联创意园119号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '8.0','payment_period' => '现金','status' => 'normal','qq' => '623089938','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '110','code' => 'YCP12084','name' => '中山市品能电池有限公司','abbreviation' => '品能','categorys_id' => '6','location' => '中山市','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。            
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。  
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。 
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为084），如5月出货则是：1305084，同样不影响美观效果即可。','contact' => '朱小姐 13631174520','tel' => '0760-86938144','fax' => '0760-86938154','email' => '690057810@qq.com','contact_addr' => '中山市火炬高新技术产业开发区凤凰路9号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '订金30%，提货余款','discount_rate' => '7.0','payment_period' => '现金','status' => 'normal','qq' => '690057810','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '111','code' => 'NCP13085','name' => '深圳市方之圆科技有限公司','abbreviation' => '方之圆','categorys_id' => '6','location' => '','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担   
2、付款方式:款到发货
3、产品质量:请做好出厂全检,如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。','contact' => '马海滨 13751177219','tel' => '0755-81481155','fax' => '','email' => '254714962@qq.com','contact_addr' => '深圳市华强北华新村22栋605','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '254714962','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '112','code' => 'NHG13086','name' => '深圳龙星龙电子厂','abbreviation' => '龙星龙','categorys_id' => '15','location' => '','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担    
2、付款方式:款到发货
3、产品质量:请做好出厂全检,如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为086），如5月出货则是：1305086，同样不影响美观效果即可。','contact' => '赵小姐 13428932436','tel' => '0755-89623142','fax' => '0755-89623142','email' => '1454779657@qq.com','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '113','code' => 'YAC13088','name' => '深圳市联运达电子有限公司','abbreviation' => '联运达','categorys_id' => '1','location' => '深圳市宝安区西乡西成工业城茂成大厦6楼东段','note' => '1、请准时交货，若贵司原因延期，无法按订单交期保质保量交付产品的，在7天以内的，按逾期订单金额实行折扣，折扣标准为每天1%（按天实行累计）;超过7天的，双方协商取消订单。           
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。  
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。 
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为088），如5月出货则是：1305088，同样不影响美观效果即可。','contact' => '黄珊珊 13714734604','tel' => '0755-27587573-602','fax' => '0755-27826541','email' => '1597121326@qq.com','contact_addr' => '深圳宝安西乡西城工业城茂成大厦6楼东段','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '当月结','discount_rate' => '10.0','payment_period' => '现金','status' => 'normal','qq' => '1597121326','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '114','code' => 'YAC13089','name' => '深圳市天久电子有限公司','abbreviation' => '天久','categorys_id' => '1','location' => '深圳市南山区西丽镇麻磡路21号5栋','note' => '1、如无法按订单交期保质保量交付产品的，在7天以内的，按逾期订单金额实行折扣，折扣标准为每天1%（按天实行累计）；超过7天的，双方协商取消订单。
2.付款方式: 月结45天，开17%增值税发票，单价加9个点。   
3.检验标准：输入端对输出端要求过高压3000V，有过流、过稳、欠压保护，出货要求全检验，用真机测试，外观符合要求 。   
4.包装要求：采用气泡袋包装，配外纸箱包装，产品保修一年。   
5、包装外箱标签，请标明：SKU（我司产品编码），装箱数量，我司发货渠道如 美海，各渠道产品 不可混装，made in china标识。
6、所有产品型号,请加电源指示灯。   
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码。
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为089），如5月出货则是：1305089，同样不影响美观效果即可。','contact' => '付红云  1599961414','tel' => '0755-88855908-8004','fax' => '0755-26552869','email' => 'tianjiu01@tianjiudz.','contact_addr' => '深圳市南山区西丽镇麻_路21号5栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '月结45天','discount_rate' => '9.0','payment_period' => '月结','status' => 'normal','qq' => '2355721813','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '115','code' => 'NCP13090','name' => '深圳市时商创展科技有限公司','abbreviation' => '时商创展','categorys_id' => '6','location' => '深圳市','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。
2、产品请做好出厂全检，如产品加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、交货产品logo印制需与给我司打样确认的样品一致
4、产品质量要求：如因产品质量引起客户投诉或损失，贵司负责补货，并参照特别说明
5、付款方式：预先支付货款60%，剩余40%货款在交货之日支付
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）    
特别说明：
1.若出现批量性的质量或尺寸问题（包括卡位不精准），需承担我方的相关损失
2.需保证订购的每个手机套都有唤醒、休眠功能，如遇到我方客户投诉，相关的损失需由贵司承担','contact' => '李小姐 18820268792','tel' => '0755-23047663','fax' => '','email' => 'starry@baseus.com','contact_addr' => '深圳市宝安区民治街道梅龙路七星商业广场B1208','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '预付60%货款，发货前付余款','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '2639270217','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '116','code' => 'NPT13091','name' => '深圳市派旺宠物用品有限公司','abbreviation' => '派旺','categorys_id' => '8','location' => '','note' => '1.交 货 期：请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2.产品保修一年              
3.包装要求：外箱和内盒上需有made in china 字样。    
4.包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。       
5.发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6.需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7.出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
  贵司供应商代码为091，比如XX年XX月份交货的，出货的产品代码为XXXX091，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '李琴15920017331','tel' => '0755-61596912','fax' => '0755-83766998','email' => 'sales01@petwantprodu','contact_addr' => '深圳市石岩镇应人石天宝路13号雅丽工业园5栋7楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '预付10%，余款月底结清','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '476671973','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '117','code' => 'YCP13092','name' => '欣旺达电子股份有限公司','abbreviation' => '欣旺达','categorys_id' => '20','location' => '深圳市宝安区石岩街道石龙社区颐和路2号','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。            
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。  
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。 
9、单个产品或彩盒上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为092），如7月出货则是：1307092，同样不影响美观效果即可。','contact' => '曹承贵 13424257931','tel' => '0755-29516888-3941','fax' => '0755-29516999','email' => 'caochenggui@sunwoda.','contact_addr' => '深圳市宝安区石岩街道石龙社区颐和路2号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '订金30%，提货余款','discount_rate' => '17.0','payment_period' => '现金','status' => 'normal','qq' => '147385452','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '118','code' => 'YCP13093','name' => '深圳市方胜包装制品有限公司','abbreviation' => '方胜','categorys_id' => '6','location' => '','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。           
2、产品请做好出厂全检，OEM产品，如包装，产品及说明书加印我司logo之定制产品，需严格依照双方样品确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。  
5、付款方式：30%订金，发货前支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。 
9、单个产品或包装上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为093），如5月出货则是：1305093，同样不影响美观效果即可。','contact' => '邱小姐 13530071953','tel' => '0755-27800789','fax' => '0755-27966781','email' => 'agnes347@cnfs6688.co','contact_addr' => '深圳市宝安区西乡街道九围社区龙眼坑方胜工业园','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '8.0','payment_period' => '现金','status' => 'normal','qq' => '2579299314','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '119','code' => 'NPT13094','name' => '深圳市嘉亿阳电子有限公司','abbreviation' => '嘉亿阳','categorys_id' => '8','location' => '','note' => '1.交 货 期：请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担              
2.付款方式: 货到验收7天内付款至供应商美金账户，按付款当日汇率结算。              
4.包装要求：中性包装，外箱和内盒上需有made in china 字样。美国版本，产品保修一年      
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。       
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
8、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
  贵司供应商代码为094，比如13年XX月份交货的，出货的产品代码为13XX094，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '滕媚 13670209086','tel' => '0755-29112919','fax' => '0755-29112919 ','email' => 'li13421320142@163.com','contact_addr' => '深圳市宝安区22区创业二路南一巷3号B栋2楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '采购额超60万月底支付30万，次月15日付余款,60万以内月底支付20万，其余次月15日付清','discount_rate' => '0.0','payment_period' => '部分月结部分现金','status' => 'normal','qq' => '李先生411720434','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '120','code' => 'YAT13095','name' => '深圳市腾威视科技有限公司','abbreviation' => '腾威视','categorys_id' => '9','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修一年。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
      贵司供应商代码为095，比如13年XX月份交货的，出货的产品代码为13XX095，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '陈雅俐13714421990','tel' => '0755-29451580','fax' => '0755-89352578','email' => 'zoe@tenvis.com','contact_addr' => '深圳市龙岗区坪地街道怡心社区吉祥三路10号1#厂房201、301','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '月结30天','discount_rate' => '10.0','payment_period' => '月结','status' => 'normal','qq' => '1218900205','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '121','code' => 'NCP13096','name' => '深圳市沃高科技有限公司','abbreviation' => '沃高','categorys_id' => '6','location' => '','note' => '1、请准时交货，若也能贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修一年。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
      贵司供应商代码为096，比如13年XX月份交货的，出货的产品代码为13XX096，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '易玲18675649853','tel' => '18675649853','fax' => '','email' => 'elaineyi@vogoge.com','contact_addr' => '深圳市宝安区流塘路河东大厦B栋10层026号','delivery_addr' => '深圳市宝安区福永街道桥头社区重庆路8号万利业科技园B栋2楼201','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '50%TT,50%货到前发','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '2814490590','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '122','code' => 'MCP13097','name' => '中山市格美通用电子有限公司','abbreviation' => '格美','categorys_id' => '6','location' => '广东省中山市东区孙文东路富湾南路富湾工业区B1栋3楼','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。           
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。  
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU编码（我司产品编码），装箱数量，Made in China标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、单个产品的彩盒上需贴上SKU编码，纸张大小视产品而定，不太影响产品彩盒美观即可，需有Made in China标识。  
9、单个产品或包装上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为097），如8月出货则是：1308097，同样不影响美观效果即可。','contact' => '黄玲 13531753046','tel' => '0760-88668033','fax' => '','email' => 'tina@k-mate.com','contact_addr' => '广东省中山市东区孙文东路富湾南路富湾工业区B1栋3楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '预付订金30%，提货余款','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => 'tinahl00','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '123','code' => 'NCP13098','name' => '深圳市星晟泰科技有限公司','abbreviation' => '星晟泰','categorys_id' => '6','location' => '东莞市长安镇锦厦三洲工业区','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。            
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。  
5、付款方式：首批合作，预付3K订单15%订金：3000*13*0.15=5850RMB，500起批，单批支付85%余款；
      首单付款为款到发货，第二单起货到一周付款；后续合作无需预付订金，双方协商月结帐期。
6、包装外箱上请标明SKU编码（我司产品编码），装箱数量，Made in China标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、单个产品的彩盒上需贴上SKU编码，纸张大小视产品而定，不太影响产品彩盒美观即可，需有Made in China标识。  
9、单个产品或包装上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为098），如8月出货则是：1308098，同样不影响美观效果即可。','contact' => '罗先生 13809896045','tel' => '0769-89799116','fax' => '0769-89320465','email' => '1843325171@qq.com','contact_addr' => '东莞市长安镇锦厦三洲工业区','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '货到一周','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '1843325171','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '124','code' => 'NNT13099','name' => '深圳市宏欣科技有限公司','abbreviation' => '宏欣','categorys_id' => '3','location' => '','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。           
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。  
5、付款方式：20%订金，发货前通知支付余款。
6、包装外箱上请标明SKU编码（我司产品编码），装箱数量，Made in China标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、单个产品的彩盒上需贴上SKU编码，纸张大小视产品而定，不太影响产品彩盒美观即可，需有Made in China标识。  
9、单个产品或包装上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为099），如8月出货则是：1308099，同样不影响美观效果即可。','contact' => '赖先生 13760265786','tel' => '0755-33299470','fax' => '0755-89370401','email' => '1353022273@qq.com','contact_addr' => '深圳市龙岗区坂田金裕城工业区一巷12号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '1353022273','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '125','code' => 'YPB13100','name' => '深圳市迪比科电子科技有限公司','abbreviation' => '迪比科','categorys_id' => '20','location' => '','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。            
2、产品请做好出厂全检，按所要求之配件完整备配出货；OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。  
5、付款方式：月结30天。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。 
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为100），如9月出货则是：1309100，同样不影响美观效果即可。','contact' => '刘随 15220146573','tel' => '0755-61569366-8346','fax' => '0755-61569387','email' => 'market003@dbk.com.cn','contact_addr' => '深圳市龙华新区龙华街道华联社区龙观路北侧迪比科工业园','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '月结30天','discount_rate' => '8.0','payment_period' => '月结','status' => 'normal','qq' => '2409526759','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '126','code' => 'NHG13101','name' => '深圳市伟信力光电有限公司','abbreviation' => '伟信力','categorys_id' => '15','location' => '深圳市宝安区石岩街道水田社区游氏工业区1号厂房','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修一年。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
     贵司供应商代码为101，比如XX年XX月份交货的，出货的产品代码为13XX101，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）
7、付款方式：预付５０％，交货时付清余款','contact' => '辜欣','tel' => '18676681775','fax' => '0755-27608837','email' => 'LEDGROW2011@LEDWXL.C','contact_addr' => '深圳市宝安区石岩街道水田宝石东路264号游镇福工业园B栋4楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '50%预付，发货前付清','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '397849735','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '127','code' => 'YAC13102','name' => '珠海市宏科电子科技有限公司','abbreviation' => '宏科','categorys_id' => '1','location' => '珠海市南屏科技园屏工1路8号厂房四楼西面','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修24个月。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
      贵司供应商代码为102，比如XX年XX月份交货的，出货的产品代码为13XX102，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）
7.付款方式：30%订金，发货前付清余款','contact' => '周大翔','tel' => '18928030288','fax' => '','email' => 'sales06@zhhkdz.com','contact_addr' => '珠海市南屏科技园屏工1路8号厂房四楼西面','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '30%预付，发货前付清','discount_rate' => '8.0','payment_period' => '现金','status' => 'normal','qq' => '727812371','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '128','code' => 'NHG13103','name' => '宁波星光灿烂电子有限公司','abbreviation' => '星光灿烂','categorys_id' => '15','location' => '宁海县西店镇蔡家村','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修24个月。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
      贵司供应商代码为103，比如XX年XX月份交货的，出货的产品代码为13XX103，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）
','contact' => '邬吉明','tel' => '13857425248 0574-651','fax' => '','email' => 'wujimingyes@126.com','contact_addr' => '浙江宁波宁海县西店镇蔡家村','delivery_addr' => '宁海县西店镇蔡家村','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '4051593','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '129','code' => 'NTB13104','name' => '深圳市旭云信息技术有限公司','abbreviation' => '旭云','categorys_id' => '12','location' => '深圳市南山西丽白芒村南1号百旺大厦A座367-1','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修一个月。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
      贵司供应商代码为104，比如XX年XX月份交货的，出货的产品代码为13XX104，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）','contact' => '吴尚贵18688782142','tel' => '18688782142','fax' => '','email' => 'ivan@young-clound.co','contact_addr' => '南山数字文化产业基地西塔1106','delivery_addr' => '深圳市南山数字文化产业基地西塔1106室','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '25%预付，货到后付余款','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '70492029','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '130','code' => 'NHG13105','name' => '深圳市圣宏亮科技有限公司','abbreviation' => '圣宏亮','categorys_id' => '15','location' => '深圳','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担    
2、付款方式:款到发货
3、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为105），如XX月出货则是：13XX105，同样不影响美观效果即可。','contact' => '姚兰 13302452778','tel' => '0755-84611815-815','fax' => '','email' => 's9@superlightled.com','contact_addr' => '深圳市龙岗区龙城街道办龙西社区学园路第三工业园','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '款到发货','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '593916072','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '131','code' => 'YPC13106','name' => '深圳市中天成科技有限公司','abbreviation' => '中天成','categorys_id' => '13','location' => '深圳市龙华大浪新围第三工业区N栋2楼A区','note' => '1、keyboard layout 见描述。              
2、manual,Giftbox,Sticker according to the email and MSN message.              
3、12 months warranty.             
4、内盒和外箱要贴有made in china 字样    
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
6、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
7、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可
8、付款方式: 样品检测OK后预付30%，大货验收合格后付尾款。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为106），如13年XX月出货则是：13XX106，同样不影响美观效果即可。','contact' => 'CANDY 186662234','tel' => '0755-28151821-813','fax' => '','email' => 'salesd@ztusb.com','contact_addr' => '深圳龙华大浪新围第三工业区N栋2楼','delivery_addr' => '深圳市龙华大浪新围第三工业区N栋2楼','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '30%预付，货到后付余款','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '1003013601','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '132','code' => 'NHG13107','name' => '中山市横栏镇爱拉风灯饰厂','abbreviation' => '爱拉风','categorys_id' => '15','location' => '中山市横栏镇贴边村北新村路26号首层','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修12个月。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
      贵司供应商代码为107，比如XX年XX月份交货的，出货的产品代码为13XX107，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）
7、付款方式：30%订金，发货前付清余款','contact' => '黄中成13424528481','tel' => '13424528481','fax' => '','email' => '362262822@qq.com','contact_addr' => '中山市横栏镇贴边村北新村路26号首层','delivery_addr' => '中山市横栏镇贴边村北新村路26号首层','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '30%预付，发货前付清','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '362262822','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '133','code' => 'YPB130108','name' => '深圳市华旗电源科技有限公司','abbreviation' => '华旗','categorys_id' => '20','location' => '','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。           
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。  
5、付款方式：货到一周付款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。 
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为108），如XX月出货则是：13XX108，同样不影响美观效果即可。','contact' => '雷菊梅   180025120','tel' => '0755-29027630','fax' => '0755-27320840','email' => 'bnd013@bnd-battery.c','contact_addr' => '深圳市宝安区福永镇新和村天福路红牌科技园C栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '货到一周','discount_rate' => '8.0','payment_period' => '现金','status' => 'normal','qq' => '2441401045','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '134','code' => 'NCP130109','name' => '深圳市数码荟科技有限公司','abbreviation' => '数码荟','categorys_id' => '6','location' => '','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。            
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。  
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。 
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为109），如XX月出货则是：13XX109，同样不影响美观效果即可。','contact' => '陈金玲 15818704472','tel' => '','fax' => '','email' => '1639783373@qq.com','contact_addr' => '深圳市龙岗区平湖街道新木新园工业区1号C栋3楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '货到一周','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '1639783373','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '135','code' => 'YPB130110','name' => '深圳市乔威电源有限公司','abbreviation' => '乔威','categorys_id' => '20','location' => '','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。           
2、产品请做好出厂全检，OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。  
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。 
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为110），如XX月出货则是：13XX110，同样不影响美观效果即可。','contact' => '赖小波 13590356603','tel' => '0755-29607103-8010','fax' => '0755-29607113','email' => '2637917384@qq.com','contact_addr' => '深圳是宝安区福永街道和平社区福园一路德金工业园D栋','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '预付订金30%，提货余款','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '2637917384','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '136','code' => 'NPC13111','name' => '深圳市元创时代科技有限公司','abbreviation' => '元创','categorys_id' => '13','location' => '深圳市龙岗区布吉街道李朗大道甘李科技园深港中海信科技园厂房第1栋A座901-904','note' => '1.交 货 期：请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2.产品保修两年              
3.包装要求：外箱和内盒上需有made in china 字样。    
4.包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。       
5.发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6.需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
7.出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
  贵司供应商代码为111，比如XX年XX月份交货的，出货的产品代码为XXXX111，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）
8.付款方式：预付30%，发货前付清余款','contact' => '徐丹丽','tel' => '15814482184','fax' => '','email' => 'stanley@orico.com.cn','contact_addr' => '深圳市龙岗区布澜大道中海信科技园总部经济中心9楼','delivery_addr' => '深圳市龙岗区布吉街道李朗大道甘李科技园深港中海信科技园厂房第1栋A座901-904','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '30%订金,70%余款发货前付清','discount_rate' => '10.0','payment_period' => '现金','status' => 'normal','qq' => '470025265','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '137','code' => 'YAC11020','name' => '东莞市奋诚电子科技有限公司','abbreviation' => '奋诚','categorys_id' => '1','location' => '','note' => '1、如无法按订单交期保质保量交付产品的，在7天以内的，按逾期订单金额实行折扣，折扣标准为每天1%（按天实行累计）；超过7天的，双方协商取消订单。
2.付款方式: 月结90天，开17%增值税发票，单价加8个点。如逾期交货，当月的付款也酌情延期。    
3.检验标准：输入端对输出端要求过高压3000V，有过流、过稳、欠压保护，出货要求全检验，用真机测试，外观符合要求 。   
4.包装要求：电源贴中性标签，采用气泡袋包装，配外纸箱包装，产品保修一年。   
5、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识。
6、所有产品型号,请加电源指示灯，另提供千分之三的备品。    
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为020），如5月出货则是：1305020，同样不影响美观效果即可。','contact' => '刘先生  1354371967','tel' => '0769-87893698','fax' => '0769-87890398','email' => '','contact_addr' => '东莞市清溪镇土桥村清凤路366号','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '0','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '1355963719','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '138','code' => 'YHG13112','name' => '深圳市优洋科技有限公司','abbreviation' => '优洋','categorys_id' => '15','location' => '','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。            
2、产品请做好出厂全检，按所要求之配件完整备配出货；OEM产品，如彩盒，贴纸，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。  
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。 
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为112），如XX月出货则是：13XX112，同样不影响美观效果即可。','contact' => '黄先生 15818649218','tel' => '0755-88830166','fax' => '','email' => 'huang@uyled.com','contact_addr' => '深圳市宝安区民治街道民治大道展滔科技大厦23楼2306室','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '订金30%，提货前余款','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '2355693239','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '139','code' => 'YCP13113','name' => '深圳市明科涞电宝电子有限公司','abbreviation' => '明科','categorys_id' => '6','location' => '','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。            
2、产品请做好出厂全检，按所要求之配件完整备配出货；OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。  
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。 
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为113），如XX月出货则是：13XX113，同样不影响美观效果即可。','contact' => '邵玉华 13823581488','tel' => '0755-27926260-8678','fax' => '0755-27926548','email' => 'cnszshao@163.com','contact_addr' => '深圳市宝安西乡银田工业区西发C区五栋二楼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '订金30%，提货前余款','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '2355698579','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '140','code' => 'NCP13114','name' => '深圳市易达华威科技有限公司','abbreviation' => '易达华威','categorys_id' => '6','location' => '','note' => '1、请准时交货，若贵司原因延期交货而造成我方经济损失，其损失由贵方承担。           
2、产品请做好出厂全检，按所要求之配件完整备配出货；OEM产品，如彩盒，产品及说明书加印我司logo之定制产品，需严格依照双方确认后之标准执行。
3、产品质量要求：产品保修一年，保修期内如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、交货方式：贵司需负责送货到我司指定交货地址。  
5、付款方式：30%订金，发货前通知支付余款。
6、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
7、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
8、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。 
9、单个产品上需贴出厂日期标识，格式为：年+月+供应商代码（贵司代码为114），如XX月出货则是：13XX114，同样不影响美观效果即可。','contact' => '丁先生 13602673745','tel' => '0755-29238580','fax' => '0755-29461578','email' => 'luke@elecsung.com','contact_addr' => '','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '订金30%，提货前余款','discount_rate' => '0.0','payment_period' => '现金','status' => 'normal','qq' => '43824483','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));
  Vendor::create(array('id' => '141','code' => 'YCB13115','name' => '深圳市和泰达电子科技有限公司','abbreviation' => '和泰达','categorys_id' => '5','location' => '深圳市龙岗区坂田街道办马安堂社区侨联东（九巷一号）202','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担   
2.付款方式:月结60天，如开增值税发票，单价加10个点    
3、产品请做好出厂全检，气泡袋散装加外包装纸箱。    
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识','contact' => '饶先生 15899854439','tel' => '0755-83030411','fax' => '0755-83030411','email' => 'lisazxj@126.com；1401429460@qq.com','contact_addr' => '深圳市龙岗区坂田街道办马安堂社区侨联东（九巷一号）202','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => ' 月结60天 ','discount_rate' => '10.0','payment_period' => ' 月结 ','status' => 'normal','qq' => '饶生1401429460','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '142','code' => 'YSV13116','name' => '深圳市福斯康姆智能科技有限公司','abbreviation' => '福斯康姆','categorys_id' => '9','location' => '深圳市南山区高新南九道9号威新软件科技园2号楼5层西翼','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担
2、产品请做好出厂全检，产品保修一年。
3、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china标识
4、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
5、需要在单个产品的彩盒上用一个小长条型不干胶纸贴上产品SKU，纸张大小视产品而定，不太影响产品彩盒美观即可。
6、出货的产品上要标有一个出货代码：年（两位）+月（两位）+供应商代码（三位），以便追溯产品。
      贵司供应商代码为116，比如XX年XX月份交货的，出货的产品代码为XXXX116，出货代码需贴在产品底部或不易被看到的地方（需不影响美观）
7、退货部分，请务必保证维修OK后将配件补齐按照新品出货标准送回我司仓库（包括贴标事宜也一样）
8、付款方式：50%预付，50%月结45天','contact' => '匡小姐13410073970','tel' => '0755-26720367','fax' => '','email' => 'sales15@foscam.com；sales6@foscam.com','contact_addr' => '深圳市南山区高新南九道9号威新软件科技园2号楼5层西翼','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '发货前50%，余50%45天账期','discount_rate' => '8.0','payment_period' => '部分月结部分现金','status' => 'normal','qq' => '匡小姐1021295862','home_page' => '','payment_credit_limit' => '0.0','developer' => '周美琴'));
  Vendor::create(array('id' => '143','code' => 'MNT13117','name' => '无锡中科龙泽信息科技有限公司','abbreviation' => '中科龙泽','categorys_id' => '3','location' => '','note' => '1、请准时交货，若因贵司原因延期交货而造成我方经济损失，其损失由贵方承担    
2、付款方式:款到发货。
3、产品质量:请做好出厂全检,如因产品质量引起客户投诉或损失，贵司负责维修，换货或赔偿。
4、包装外箱上请标明SKU（我司产品编码），装箱数量，made in china
5、发货请附送货单，送货单上的货物请填上对应的SKU（我司产品编码）
6、单个产品包装上需有产品SKU，made in china ，以及出厂日期小标贴，出厂日期格式为：年+月+供应商代码（贵司代码为117），如XX月出货则是：13XX117, 贴纸大小视产品而定，不太影响产品包装美观即可。','contact' => '耿然','tel' => '','fax' => '','email' => '642431757@qq.com','contact_addr' => '无锡市滴翠路100号530大厦2号楼18层','delivery_addr' => '','delivery_addr_ext' => '','tax_registration_card' => '','business_license' => '','registered_capital' => '0.00','payment_method' => '5','discount_rate' => '0.0','payment_period' => '0','status' => 'normal','qq' => '642431757','home_page' => '','payment_credit_limit' => '0.0','developer' => '谢静'));*/

	}
}

