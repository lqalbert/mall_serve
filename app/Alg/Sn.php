<?php
/**
* 生成商品编号 （goods_sn、sku_sn）
* 订单号或发货单号要重新生成　不要用count
* 订单号
*/
namespace App\Alg;

class Sn 
{	
    
    const ORDER = 'OR';
    const ASSIGN = 'AS';
    const IN_ENTREPOT= 'IN';
    const OUT_ENTREPOT = 'OU';
    const ORDER_RETURN = 'RX';
    const ORDER_EXCHANGE = 'EX';
    const CHECK = 'CH';
    
	/**
	 * 生成商品编号
	 * @param int $c
	 * 
	 * @return string G000A
	 */
	public static function getGoodsSn($c, $len = 4)
	{
		return 'G'. self::getSn($c, $len);
	}
	
	/**
	 * 生成sku_sn
	 * @param int $c
	 * @param number $len
	 */
	public static function getSkuSn($c, $len = 4)
	{
		return 'K'.self::getSn($c, $len);
	}
	
	
	
	/**
	 * 生成 sn
	 * 平时一天二三百单  双十一  一天两千单 
	 * 所以4位16进制完全够了　16^4 = 65536  要6万多单后才会再次回到0000
	 * @param unknown $c id对65536求余
	 * @param number $len
	 * @return string
	 */
	public static function getSn($c, $len = 4)
	{
		return sprintf("%04X", $c);
	}
	
	/**
	 * 生成单号
	 * @param string $pre  上面的常量
	 * @param string $base 仓库的简写
	 * @param number $c 总数
	 * 
	 * @return string
	 */
	public static function getDanSn($pre, $base, $c)
	{
	    return $pre.Date('Ymd').$base. self::getSn($c % DAN_MAX, DAN_NUM_LENGTH);
	}
	
	/**
	 * 生成订单号
	 * 
	 * @param string $base
	 * @param number $c
	 * 
	 * @return sring
	 */
	public static function getOrderSn($base, $c)
	{
	    return self::getDanSn(self::ORDER, $base, $c);
	}
	
	/**
	 * 生成 配货单（发货单） 号
	 * 
	 * @param string $base
	 * @param number $c
	 * 
	 * @return string 
	 */
	public static function getAssignSn($base, $c)
	{
	    return self::getDanSn(self::ASSIGN, $base, $c);
	}
	
	/**
	 * 生成入库单号
	 * 
	 * @param string $base
	 * @param number $c
	 * 
	 * @return string
	 */
	public static function getInSn($base, $c)
	{
	    return self::getDanSn(self::IN_ENTREPOT, $base, $c);
	}
	
	/**
	 * 生成出库单号
	 *
	 * @param string $base
	 * @param number $c
	 *
	 * @return string
	 */
	public static function getOuSn($base, $c)
	{
	    return self::getDanSn(self::OUT_ENTREPOT, $base, $c);
	}
	
	/**
	 * 生成退/换货单号
	 *
	 * @param string $base
	 * @param number $c
	 *
	 * @return string
	 */
	public static function getRXSn($base, $c)
	{
	    return self::getDanSn(self::ORDER_RETURN, $base, $c);
	}
	
	/**
	 * 生成换货单号　估计不用了
	 *
	 * @param string $base
	 * @param number $c
	 *
	 * @return string
	 */
	public static function getExSn($base, $c)
	{
	    return self::getDanSn(self::ORDER_EXCHANGE, $base, $c);
	}
	
	/**
	 * 生成盘点单
	 * @param unknown $base
	 * @param unknown $c
	 * @return string
	 */
	public static function getCheckSn($base, $c)
	{
	    return self::getDanSn(self::CHECK, $base ,$c);
	}
}