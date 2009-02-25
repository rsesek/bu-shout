<?php
//  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Code Igniter
*
* An open source application development framework for PHP 4.3.2 or newer
*
* @package        CodeIgniter
* @author        Rick Ellis
* @copyright    Copyright (c) 2006, pMachine, Inc.
* @license        http://www.codeignitor.com/user_guide/license.html
* @link        http://www.codeigniter.com
* @since        Version 1.0
* @filesource
*/

// ------------------------------------------------------------------------

/**
* Code Igniter Microformat Helpers
*
* @package        CodeIgniter
* @subpackage    Helpers
* @category    Helpers
* @author        Derek Allard
* @link        http://derekallard.com/category/code-igniter/
*/

// ------------------------------------------------------------------------

/**
* hCard
*
* Generates an microformats hCard.  Accepts either distinct variable references
* (for example hCard ("Firstname", "Middlename", "Lastname", "Organizationname")
* or more commonly an array such as
* $hCard_data = array (
*    'given_name' => 'Firstname',
*    'middle_name' => 'Middlename',
*    'family_name' => 'Lastname',
*    'organization' => 'OrganizationName',
*    'street' => '123 Street',
*    'city' => 'City',
*    'province' => 'Province/State',
*    'postal_code' => 'Postal/Zip',
*    'country' => 'Country',
*    'phone' => 'phonenumber',
*    'email' => 'email@yoursite.com',
*    'url' => 'http://yoursite.com',
*    'aim_screenname' => 'aimname',
*    'yim_screenname' => 'yimname'
*);
*
* @access    public
* @param    array
* @return    string
*/    



function hCard($given_name = '', $middle_name = '', $family_name = '', $organization = '', $street = '', $city = '', $province = '', $postal_code = '', $country = '', $phone = '', $email = '', $url = '', $aim_screenname = '', $yim_screenname = '')
{

    if (is_array($given_name)) {        
        foreach (array('middle_name', 'family_name', 'organization', 'street', 'city', 'province', 'postal_code', 'country', 'phone', 'email', 'url', 'aim_screenname', 'yim_screenname', 'given_name') as $item) {
            if (isset($given_name[$item])) {
                $$item = $given_name[$item];
            }
        }
    }

    $middle_name != '' ? $name_class = 'fn n' : $name_class = 'fn';
    if ( $url != '' ) {
        $name_wrapper_start = "<a href=\"$url\" class=\"$name_class\">";
        $name_wrapper_end = "</a>";
    } else {
        $name_wrapper_start ="<span class=\"$name_class\">";
        $name_wrapper_end = "</span>";
    }

    $hCard = "<div class=\"vcard\">\n";
    $hCard .= "\t$name_wrapper_start\n";
    if ($given_name != '') {
        $hCard .= "\t\t<span class=\"given-name\">$given_name</span>\n";    
    }
    if ($middle_name != '') {
        $hCard .= "\t\t<span class=\"additional_name\">$middle_name</span>\n";    
    }
    if ($family_name != '') {
        $hCard .= "\t\t<span class=\"family_name\">$family_name</span>\n";    
    }
    $hCard .= "\t$name_wrapper_end\n";
    if ($organization != '') {
        $hCard .= "\t<div class=\"org\">$organization</div>\n";    
    }
    if ($email != '') {
        $hCard .= "<a class=\"email\" href=\"mailto:$email\">$email</a>\n";
    }
    if ($street !== '' || $city !== '' || $province != '' || $postal_code != '' || $country != '') {
        $hCard .= "\t<div class=\"adr\">\n";
        if ($street !== '') {
            $hCard .= "\t\t<div class=\"street-address\">$street</div>\n";
        }
        if ($city !== '') {
            $hCard .= "\t\t<div class=\"locality\">$city</div>\n";
        }
        if ($province !== '') {
            $hCard .= "\t\t<div class=\"region\">$province</div>\n";
        }
        if ($postal_code !== '') {
            $hCard .= "\t\t<div class=\"postal-code\">$postal_code</div>\n";
        }
        if ($country !== '') {
            $hCard .= "\t\t<div class=\"country-name\">$country</div>\n";
        }
        $hCard .= "\t</div>\n";
    }
    if ($phone != '') {
        $hCard .= "\t<div id=\"tel\">$phone</div>\n";
    }
    if ($aim_screenname != '') {
        $hCard .= "\t<a class=\"url\" href=\"aim:goim?screenname=$aim_screenname\">AIM</a>\n";
    }
    if ($yim_screenname != '') {
        $hCard .= "\t<a class=\"url\" href=\"ymsgr:sendIM?$yim_screenname\">YIM</a>\n";
    }
    $hCard .= "</div>\n";
    return $hCard;
}

// ------------------------------------------------------------------------

/**
* license
*
* Generates an microformats license.  Accepts one of the following licenses
* and an optional text string.
*
* using 'ci' gives Code Igniter License Agreement
*                    http://www.codeigniter.com/user_guide/license.html
* using 'cc_by' gives Creative Commons Attribution (version 2.5)
*                     http://creativecommons.org/licenses/by/2.5/
* using 'cc_by-nd' gives Creative Commons Attribution-NoDerivs (version 2.5)
*                    http://creativecommons.org/licenses/by-nd/2.5/
* using 'cc_by-nc-nd' gives Creative Commons Attribution-NonCommercial-NoDerivs (version 2.5)
*                    http://creativecommons.org/licenses/by-nc-nd/2.5/
* using 'cc_by-nc' gives Creative Commons Attribution-NonCommercial (version 2.5)
*                    http://creativecommons.org/licenses/by-nc/2.5/
* using 'cc_by-nc-sa' gives Creative Commons Attribution-NonCommercial-ShareAlike (version 2.5)
*                    http://creativecommons.org/licenses/by-nc-sa/2.5/
* using 'cc_by-sa' gives Creative Commons Attribution-ShareAlike (version 2.5)
*                    http://creativecommons.org/licenses/by-sa/2.5/
* using 'gpl' gives GNU General Public License (version 2)
*                    http://www.gnu.org/copyleft/gpl.html
* using 'lgpl' gives GNU Lesser General Public License (version 2.1)
*                    http://www.gnu.org/licenses/lgpl.html
* using 'mpl' gives Mozilla Public License (Version 1.1)
*                    http://www.mozilla.org/MPL/MPL-1.1.html
* using 'apache' gives Apache License (version 2.0)
*                    http://www.apache.org/licenses/LICENSE-2.0
* using 'w3c' gives W3C SOFTWARE NOTICE AND LICENSE
*                    http://www.w3.org/Consortium/Legal/2002/copyright-software-20021231
*
* Using any string but one of these generates an error.
*
* @access    public
* @param    string
* @param    string
* @return    string
*/    

function license ($license_choice, $text = '')
{
    $license_types = array(
        array( 'ci', 'Code Igniter License Agreement', 'http://www.codeigniter.com/user_guide/license.html' ),
        array( 'cc_by', 'Creative Commons Attribution (version 2.5)', 'http://creativecommons.org/licenses/by/2.5/' ),
        array( 'cc_by-nd', 'Creative Commons Attribution-NoDerivs (version 2.5)', 'http://creativecommons.org/licenses/by-nd/2.5/' ),
        array( 'cc_by-nc-nd', 'Creative Commons Attribution-NonCommercial-NoDerivs (version 2.5)', 'http://creativecommons.org/licenses/by-nc-nd/2.5/' ),
        array( 'cc_by-nc', 'Creative Commons Attribution-NonCommercial (version 2.5)', 'http://creativecommons.org/licenses/by-nc/2.5/' ),
        array( 'cc_by-nc-sa', 'Creative Commons Attribution-NonCommercial-ShareAlike (version 2.5)', 'http://creativecommons.org/licenses/by-nc-sa/2.5/' ),
        array( 'cc_by-sa', 'Creative Commons Attribution-ShareAlike (version 2.5)', 'http://creativecommons.org/licenses/by-sa/2.5/' ),
        array( 'gpl', 'GNU General Public License (version 2)', 'http://www.gnu.org/licenses/old-licenses/gpl-2.0.html' ),
        array( 'lgpl', 'GNU Lesser General Public License (version 2.1)', 'http://www.gnu.org/licenses/lgpl.html' ),
        array( 'mpl', 'Mozilla Public License (Version 1.1)', 'http://www.mozilla.org/MPL/MPL-1.1.html' ),
        array( 'apache', 'Apache License (version 2.0)', 'http://www.apache.org/licenses/LICENSE-2.0' ),
        array( 'w3c', 'W3C SOFTWARE NOTICE AND LICENSE', 'http://www.w3.org/Consortium/Legal/2002/copyright-software-20021231' )
    );

    if ( array_search_recursive($license_choice, $license_types) ) {
        $license_array = array_search_recursive($license_choice, $license_types);
        if ($text == '') {
            $text = $license_types[$license_array[0]][1];
        }
        $license_url = $license_types[$license_array[0]][2];
        return '<a rel="license" href="' . $license_url . '">' . $text . '</a>';
    } else {
        show_error ('unknown license type');
    }
}



/**
* Just a quick handy function to search down through multi-dimensional arrays
* it returns an array within which the $needle was found
* needed for license() function.
*/
function array_search_recursive($needle, $haystack, $key_lookin="")
{
    $path = NULL;
   if (!empty($key_lookin) && array_key_exists($key_lookin, $haystack) && $needle === $haystack[$key_lookin]) {
       $path[] = $key_lookin;
   } else {
       foreach($haystack as $key => $val) {
           if (is_scalar($val) && $val === $needle && empty($key_lookin)) {
               $path[] = $key;
               break;
           } elseif (is_array($val) && $path = array_search_recursive($needle, $val, $key_lookin)) {
               array_unshift($path, $key);
               break;
           }
       }
   }
return $path;
}

?>