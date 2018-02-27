<?php
/**
* 生成商品编号 （goods_sn、sku_sn）
*
*/
namespace App\Alg;

class Sn 
{	
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
	 * @param unknown $c 当前总数
	 * @param number $len
	 * @return string
	 */
	public static function getSn($c, $len = 4)
	{
		return sprintf("%04X", ++$c);
	}
}