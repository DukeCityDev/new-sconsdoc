<?php
/**
 * Created by PhpStorm.
 * User: deaton747
 * Date: 6/15/2018
 * Time: 3:38 PM
 */

namespace util;


class Util
{
    public static function verifyDate(\DateTime $date){
        return (\DateTime::createFromFormat('m/d/Y',$date)!== false);
    }
}